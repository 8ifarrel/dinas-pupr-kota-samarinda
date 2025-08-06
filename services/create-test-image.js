// Create dummy test image
const { createCanvas } = require('canvas');
const fs = require('fs');

const canvas = createCanvas(128, 128);
const ctx = canvas.getContext('2d');

// Create a test road damage image
ctx.fillStyle = '#808080'; // Gray background (road)
ctx.fillRect(0, 0, 128, 128);

// Add some damage patterns
ctx.fillStyle = '#404040'; // Darker gray for cracks
ctx.fillRect(30, 40, 2, 50); // Vertical crack
ctx.fillRect(20, 60, 60, 2); // Horizontal crack

ctx.fillStyle = '#202020'; // Black for holes
ctx.beginPath();
ctx.arc(80, 80, 8, 0, 2 * Math.PI);
ctx.fill();

// Save as PNG
const buffer = canvas.toBuffer('image/png');
fs.writeFileSync('test-damage.png', buffer);
console.log('Test image created: test-damage.png');
