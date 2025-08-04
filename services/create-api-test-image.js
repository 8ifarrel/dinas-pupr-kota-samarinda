// Create sample test image untuk testing API
const { createCanvas } = require('canvas');
const fs = require('fs');

// Create a more realistic road damage image
const canvas = createCanvas(300, 300);
const ctx = canvas.getContext('2d');

// Background road texture
ctx.fillStyle = '#707070';
ctx.fillRect(0, 0, 300, 300);

// Add road texture pattern
for (let i = 0; i < 300; i += 10) {
    ctx.fillStyle = '#606060';
    ctx.fillRect(i, 150, 5, 2);
}

// Add crack pattern (more realistic)
ctx.strokeStyle = '#303030';
ctx.lineWidth = 3;
ctx.beginPath();
ctx.moveTo(50, 100);
ctx.lineTo(80, 120);
ctx.lineTo(120, 110);
ctx.lineTo(160, 140);
ctx.lineTo(200, 130);
ctx.lineTo(250, 160);
ctx.stroke();

// Add secondary cracks
ctx.lineWidth = 2;
ctx.beginPath();
ctx.moveTo(100, 80);
ctx.lineTo(130, 200);
ctx.stroke();

ctx.beginPath();
ctx.moveTo(180, 70);
ctx.lineTo(210, 220);
ctx.stroke();

// Add some holes/potholes
ctx.fillStyle = '#202020';
ctx.beginPath();
ctx.arc(70, 200, 12, 0, 2 * Math.PI);
ctx.fill();

ctx.beginPath();
ctx.arc(180, 250, 8, 0, 2 * Math.PI);
ctx.fill();

// Save as test image for API
const buffer = canvas.toBuffer('image/jpeg', { quality: 0.8 });
fs.writeFileSync('../public/test-road-damage.jpg', buffer);
console.log('API test image created: public/test-road-damage.jpg');
