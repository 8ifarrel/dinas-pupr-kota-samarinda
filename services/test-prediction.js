// Test prediction dengan gambar asli (tanpa modul native)
const Jimp = require("jimp");
global.fetch = require("node-fetch");

const tf = require("@tensorflow/tfjs");
require("@tensorflow/tfjs-backend-cpu");

// Register L2 regularizer
tf.serialization.registerClass(
    class L2 {
        constructor(args) {
            this.l2 = args && args.l2 ? args.l2 : 0.01;
        }

        apply(x) {
            return tf.mul(this.l2, tf.sum(tf.square(x)));
        }

        static get className() {
            return "L2";
        }

        getConfig() {
            return { l2: this.l2 };
        }
    }
);

const path = require("path");
const fs = require("fs");

const MODEL_PATH = path.join(__dirname, "../public/model/model.json");

const JENIS_MAPPING = {
    0: "Lubang",
    1: "Retak",
    2: "Amblas",
};

const TINGKAT_MAPPING = {
    0: "Ringan",
    1: "Sedang",
    2: "Berat",
};

async function testImagePrediction() {
    try {
        console.log("Loading model...");

        // Load model dengan custom IO handler
        const modelJsonContent = fs.readFileSync(MODEL_PATH, "utf8");
        const modelConfig = JSON.parse(modelJsonContent);

        const ioHandler = {
            load: async () => {
                const modelTopology = modelConfig.modelTopology;
                const weightSpecs = modelConfig.weightsManifest[0].weights;
                const weightPaths = modelConfig.weightsManifest[0].paths;

                const modelDir = path.dirname(MODEL_PATH);
                let weightData = new ArrayBuffer(0);

                for (const weightPath of weightPaths) {
                    const fullWeightPath = path.join(modelDir, weightPath);
                    const weightBuffer = fs.readFileSync(fullWeightPath);

                    const oldWeightData = weightData;
                    weightData = new ArrayBuffer(
                        oldWeightData.byteLength + weightBuffer.byteLength
                    );
                    const uint8View = new Uint8Array(weightData);
                    uint8View.set(new Uint8Array(oldWeightData), 0);
                    uint8View.set(
                        new Uint8Array(weightBuffer),
                        oldWeightData.byteLength
                    );
                }

                return {
                    modelTopology: modelTopology,
                    weightSpecs: weightSpecs,
                    weightData: weightData,
                };
            },
        };

        const model = await tf.loadLayersModel(ioHandler);
        console.log("✅ Model loaded!");

        // Create dummy image data (white 128x128 image) using Jimp
        console.log("Creating test image...");
        const img = new Jimp(128, 128, "#FFFFFF");
        // Draw a black square
        for (let y = 50; y < 78; y++) {
            for (let x = 50; x < 78; x++) {
                img.setPixelColor(Jimp.cssColorToHex("#000000"), x, y);
            }
        }
        // Convert to tensor [128,128,3]
        const { data, width, height } = img.bitmap; // RGBA
        const numPixels = width * height;
        const rgb = new Uint8Array(numPixels * 3);
        for (let i = 0, j = 0; i < data.length; i += 4, j += 3) {
            rgb[j] = data[i];
            rgb[j + 1] = data[i + 1];
            rgb[j + 2] = data[i + 2];
        }
        const imageTensor = tf.tensor3d(rgb, [height, width, 3], "int32");

        // Normalize ke [0,1]
        const normalized = imageTensor.div(255.0);

        // Add batch dimension
        const batched = normalized.expandDims(0);

        console.log("Running prediction...");
        const prediction = model.predict(batched);

        if (Array.isArray(prediction)) {
            const jenisData = await prediction[0].data();
            const tingkatData = await prediction[1].data();

            const jenisIndex = jenisData.indexOf(Math.max(...jenisData));
            const tingkatIndex = tingkatData.indexOf(Math.max(...tingkatData));

            const jenis = JENIS_MAPPING[jenisIndex] || "Tidak Terdeteksi";
            const tingkat = TINGKAT_MAPPING[tingkatIndex] || "Tidak Terdeteksi";

            console.log("✅ Prediction Results:");
            console.log(
                "Jenis:",
                jenis,
                `(confidence: ${jenisData[jenisIndex].toFixed(4)})`
            );
            console.log(
                "Tingkat:",
                tingkat,
                `(confidence: ${tingkatData[tingkatIndex].toFixed(4)})`
            );
            console.log(
                "Jenis probabilities:",
                Array.from(jenisData).map((x) => x.toFixed(4))
            );
            console.log(
                "Tingkat probabilities:",
                Array.from(tingkatData).map((x) => x.toFixed(4))
            );

            // Cleanup
            imageTensor.dispose();
            normalized.dispose();
            batched.dispose();
            prediction.forEach((tensor) => tensor.dispose());

            console.log("✅ Full prediction test completed successfully!");
        }
    } catch (error) {
        console.error("❌ Error:", error.message);
        console.error("Stack:", error.stack);
    }
}

testImagePrediction();
