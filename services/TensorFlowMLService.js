/**
 * Server-side TensorFlow.js ML Prediction Service
 * Menggunakan model yang sama dengan client-side untuk konsistensi
 */

const tf = require('@tensorflow/tfjs-node');
const fs = require('fs');
const path = require('path');

class TensorFlowMLService {
    constructor() {
        this.model = null;
        this.isInitialized = false;
        this.jenisClassNames = ['Retak Buaya', 'Lubang-lubang', 'Longsor'];
        this.tingkatClassNames = ['Ringan', 'Sedang', 'Berat'];
    }

    /**
     * Initialize TensorFlow.js model
     */
    async initialize() {
        try {
            console.log('🤖 Loading TensorFlow.js model...');
            
            // Load model dari path yang sama dengan frontend
            const modelPath = path.join(__dirname, '../public/model/model.json');
            this.model = await tf.loadLayersModel(`file://${modelPath}`);
            
            this.isInitialized = true;
            console.log('✅ TensorFlow.js model loaded successfully');
            
        } catch (error) {
            console.error('❌ Failed to load TensorFlow.js model:', error);
            throw error;
        }
    }

    /**
     * Predict jenis dan tingkat kerusakan dari image buffer
     * Menggunakan logic yang sama dengan buat-laporan.js
     */
    async predict(imageBuffer) {
        if (!this.isInitialized) {
            throw new Error('TensorFlow.js model not initialized');
        }

        try {
            // Decode image buffer ke tensor
            const imageTensor = tf.node.decodeImage(imageBuffer, 3);
            
            // Preprocess sama seperti di buat-laporan.js
            const preprocessed = imageTensor
                .resizeNearestNeighbor([128, 128])
                .toFloat()
                .div(tf.scalar(255))
                .expandDims();

            // Run prediction
            const predictions = await this.model.predict(preprocessed);
            
            // Process hasil prediction
            const jenisPred = predictions[0].softmax().dataSync();
            const tingkatPred = predictions[1].softmax().dataSync();

            // Get index dengan confidence tertinggi
            const jenisIndex = jenisPred.indexOf(Math.max(...jenisPred));
            const tingkatIndex = tingkatPred.indexOf(Math.max(...tingkatPred));

            // Cleanup tensors
            imageTensor.dispose();
            preprocessed.dispose();
            predictions[0].dispose();
            predictions[1].dispose();

            return {
                jenis: this.jenisClassNames[jenisIndex],
                tingkat: this.tingkatClassNames[tingkatIndex],
                confidence_jenis: Math.max(...jenisPred),
                confidence_tingkat: Math.max(...tingkatPred),
                method: 'server_tensorflowjs'
            };

        } catch (error) {
            console.error('❌ TensorFlow.js prediction failed:', error);
            throw error;
        }
    }

    /**
     * Health check untuk model
     */
    isReady() {
        return this.isInitialized && this.model !== null;
    }
}

// Export singleton instance
const mlService = new TensorFlowMLService();

module.exports = mlService;
