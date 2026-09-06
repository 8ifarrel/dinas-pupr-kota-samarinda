// Debug script untuk test model loading
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

const path = require('path');
const fs = require('fs');

async function testModelLoading() {
    try {
        const MODEL_PATH = path.join(__dirname, '../public/model/model.json');
        console.log('Model path:', MODEL_PATH);
        
        // Read model.json directly
        console.log('Reading model.json...');
        const modelJsonContent = fs.readFileSync(MODEL_PATH, 'utf8');
        const modelConfig = JSON.parse(modelJsonContent);
        
        console.log('Model config loaded');
        console.log('Weight manifest:', modelConfig.weightsManifest);
        
        // Create custom IO handler
        const ioHandler = {
            load: async () => {
                const modelTopology = modelConfig.modelTopology;
                const weightSpecs = modelConfig.weightsManifest[0].weights;
                const weightPaths = modelConfig.weightsManifest[0].paths;
                
                console.log('Loading weights from:', weightPaths);
                
                // Read all weight files
                const modelDir = path.dirname(MODEL_PATH);
                let weightData = new ArrayBuffer(0);
                
                for (const weightPath of weightPaths) {
                    const fullWeightPath = path.join(modelDir, weightPath);
                    console.log('Reading weight file:', fullWeightPath);
                    const weightBuffer = fs.readFileSync(fullWeightPath);
                    
                    // Concatenate weight data
                    const oldWeightData = weightData;
                    weightData = new ArrayBuffer(oldWeightData.byteLength + weightBuffer.byteLength);
                    const uint8View = new Uint8Array(weightData);
                    uint8View.set(new Uint8Array(oldWeightData), 0);
                    uint8View.set(new Uint8Array(weightBuffer), oldWeightData.byteLength);
                }
                
                console.log('Total weight data size:', weightData.byteLength);
                
                return {
                    modelTopology: modelTopology,
                    weightSpecs: weightSpecs,
                    weightData: weightData
                };
            }
        };
        
        console.log('Loading model with custom IO handler...');
        const model = await tf.loadLayersModel(ioHandler);
        
        console.log('✅ Model loaded successfully!');
        console.log('Input shape:', model.inputs[0].shape);
        console.log('Output count:', model.outputs.length);
        
        // Test dengan dummy data
        const dummyInput = tf.randomNormal([1, 128, 128, 3]);
        console.log('Testing prediction with dummy data...');
        
        const prediction = model.predict(dummyInput);
        console.log('✅ Prediction successful!');
        
        if (Array.isArray(prediction)) {
            console.log('Multi-output model detected');
            console.log('Output 1 shape:', prediction[0].shape);
            console.log('Output 2 shape:', prediction[1].shape);
        }
        
        // Cleanup
        dummyInput.dispose();
        if (Array.isArray(prediction)) {
            prediction.forEach(tensor => tensor.dispose());
        } else {
            prediction.dispose();
        }
        
        console.log('✅ Test completed successfully!');
        
    } catch (error) {
        console.error('❌ Error:', error.message);
        console.error('Stack:', error.stack);
    }
}

testModelLoading();
