// Simple test untuk TensorFlow.js service (CPU backend)
const tf = require("@tensorflow/tfjs");
require("@tensorflow/tfjs-backend-cpu");

console.log("TensorFlow.js version:", tf.version.tfjs);
console.log("Available backends:", tf.engine().backendNames);

// Test simple tensor operation
const tensor = tf.tensor([1, 2, 3, 4]);
console.log("Simple tensor test:", tensor.dataSync());

tensor.dispose();
console.log("TensorFlow.js is working correctly!");
