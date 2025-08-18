/**
 * Node.js script untuk TensorFlow.js prediction
 * Dipanggil dari PHP untuk memproses gambar menggunakan model yang sama dengan frontend
 * Menggunakan browser-compatible TensorFlow.js + Canvas untuk kompatibilitas Windows
 */

// Import Canvas untuk headless image processing
const { createCanvas, loadImage, Image } = require('canvas');

// Polyfill untuk browser API di Node.js environment
global.HTMLCanvasElement = createCanvas(1, 1).constructor;
global.HTMLImageElement = Image;
global.ImageData = require('canvas').ImageData;
global.fetch = require('node-fetch');

// Setup TensorFlow.js dengan CPU backend
const tf = require('@tensorflow/tfjs');
require('@tensorflow/tfjs-backend-cpu');

// Register L2 regularizer untuk kompatibilitas dengan model
tf.serialization.registerClass(class L2 {
    constructor(args) {
        this.l2 = args && args.l2 ? args.l2 : 0.01;
    }
    
    apply(x) {
        return tf.mul(this.l2, tf.sum(tf.square(x)));
    }
    
    static get className() {
        return 'L2';
    }
    
    getConfig() {
        return { l2: this.l2 };
    }
});

const fs = require('fs');
const path = require('path');

// Konfigurasi model dan mapping yang sama dengan buat-laporan.js
const MODEL_PATH = path.join(__dirname, '../public/model/model.json');

const JENIS_MAPPING = {
    0: 'Lubang',
    1: 'Retak',
    2: 'Amblas'
};

const TINGKAT_MAPPING = {
    0: 'Ringan',
    1: 'Sedang',
    2: 'Berat'
};

class ServerTensorFlowPredictor {
    constructor() {
        this.model = null;
        this.isModelLoaded = false;
    }

    async loadModel() {
        try {
            if (!fs.existsSync(MODEL_PATH)) {
                throw new Error(`Model not found at: ${MODEL_PATH}`);
            }

            console.error('Loading TensorFlow.js model...');
            
            // Read model.json directly from file system
            const modelJsonContent = fs.readFileSync(MODEL_PATH, 'utf8');
            const modelConfig = JSON.parse(modelJsonContent);
            
            // Create custom IO handler untuk loading dari file system
            const ioHandler = {
                load: async () => {
                    // Load model topology
                    const modelTopology = modelConfig.modelTopology;
                    
                    // Load weights dari binary files
                    const weightSpecs = modelConfig.weightsManifest[0].weights;
                    const weightPaths = modelConfig.weightsManifest[0].paths;
                    
                    // Read all weight files
                    const modelDir = path.dirname(MODEL_PATH);
                    let weightData = new ArrayBuffer(0);
                    
                    for (const weightPath of weightPaths) {
                        const fullWeightPath = path.join(modelDir, weightPath);
                        const weightBuffer = fs.readFileSync(fullWeightPath);
                        
                        // Concatenate weight data
                        const oldWeightData = weightData;
                        weightData = new ArrayBuffer(oldWeightData.byteLength + weightBuffer.byteLength);
                        const uint8View = new Uint8Array(weightData);
                        uint8View.set(new Uint8Array(oldWeightData), 0);
                        uint8View.set(new Uint8Array(weightBuffer), oldWeightData.byteLength);
                    }
                    
                    return {
                        modelTopology: modelTopology,
                        weightSpecs: weightSpecs,
                        weightData: weightData
                    };
                }
            };
            
            this.model = await tf.loadLayersModel(ioHandler);
            this.isModelLoaded = true;
            
            console.error('Model loaded successfully');
            console.error('Model input shape:', this.model.inputs[0].shape);
            console.error('Model output count:', this.model.outputs.length);
            
        } catch (error) {
            console.error('Failed to load model:', error.message);
            throw error;
        }
    }

    async predictFromImagePath(imagePath) {
        if (!this.isModelLoaded) {
            await this.loadModel();
        }

        try {
            console.error('Loading image:', imagePath);
            
            // Load image menggunakan Canvas
            const image = await loadImage(imagePath);
            
            // Create canvas dan resize ke 128x128 - sama dengan frontend
            const canvas = createCanvas(128, 128);
            const ctx = canvas.getContext('2d');
            
            // Draw resized image
            ctx.drawImage(image, 0, 0, 128, 128);
            
            // Get image data dan convert ke tensor
            const imageData = ctx.getImageData(0, 0, 128, 128);
            const imageTensor = tf.browser.fromPixels(imageData, 3);
            
            // Normalize ke [0,1] - sama dengan frontend
            const normalized = imageTensor.div(255.0);
            
            // Add batch dimension
            const batched = normalized.expandDims(0);

            // Predict menggunakan model
            console.error('Running prediction...');
            const prediction = this.model.predict(batched);

            let jenisProbs, tingkatProbs;

            // Handle multi-output model - sama dengan frontend
            if (Array.isArray(prediction)) {
                jenisProbs = prediction[0];
                tingkatProbs = prediction[1];
            } else {
                throw new Error('Expected multi-output model');
            }

            // Get predictions
            const jenisData = await jenisProbs.data();
            const tingkatData = await tingkatProbs.data();

            // Find max indices
            const jenisIndex = jenisData.indexOf(Math.max(...jenisData));
            const tingkatIndex = tingkatData.indexOf(Math.max(...tingkatData));

            // Map ke labels
            const jenis = JENIS_MAPPING[jenisIndex] || 'Tidak Terdeteksi';
            const tingkat = TINGKAT_MAPPING[tingkatIndex] || 'Tidak Terdeteksi';

            const result = {
                jenis: jenis,
                tingkat: tingkat,
                confidence_jenis: jenisData[jenisIndex],
                confidence_tingkat: tingkatData[tingkatIndex],
                method: 'server_tensorflow',
                probabilities: {
                    jenis: Array.from(jenisData),
                    tingkat: Array.from(tingkatData)
                }
            };

            // Cleanup tensors
            imageTensor.dispose();
            normalized.dispose();
            batched.dispose();
            if (Array.isArray(prediction)) {
                prediction.forEach(tensor => tensor.dispose());
            } else {
                prediction.dispose();
            }

            return result;

        } catch (error) {
            console.error('Prediction failed:', error.message);
            throw error;
        }
    }
}

// Main execution
async function main() {
    try {
        if (process.argv.length < 3) {
            throw new Error('Usage: node predict.js <image_path>');
        }

        const imagePath = process.argv[2];
        
        if (!fs.existsSync(imagePath)) {
            throw new Error(`Image file not found: ${imagePath}`);
        }

        const predictor = new ServerTensorFlowPredictor();
        const result = await predictor.predictFromImagePath(imagePath);

        // Output JSON ke stdout untuk PHP
        console.log(JSON.stringify(result));

    } catch (error) {
        console.error('Error:', error.message);
        
        // Return error sebagai valid JSON
        const errorResult = {
            jenis: 'Tidak Terdeteksi',
            tingkat: 'Tidak Terdeteksi',
            confidence_jenis: 0.1,
            confidence_tingkat: 0.1,
            method: 'server_error',
            error: error.message
        };
        
        console.log(JSON.stringify(errorResult));
        process.exit(1);
    }
}

// Handle uncaught exceptions
process.on('uncaughtException', (error) => {
    console.error('Uncaught Exception:', error.message);
    
    const errorResult = {
        jenis: 'Tidak Terdeteksi',
        tingkat: 'Tidak Terdeteksi',
        confidence_jenis: 0.1,
        confidence_tingkat: 0.1,
        method: 'server_exception',
        error: error.message
    };
    
    console.log(JSON.stringify(errorResult));
    process.exit(1);
});

// Run main function
main();
