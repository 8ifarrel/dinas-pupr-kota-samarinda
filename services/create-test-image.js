// Create dummy test image using Jimp (no native deps)
const Jimp = require('jimp');

(async () => {
	const width = 128, height = 128;
	const image = new Jimp(width, height, '#808080');

	// Darker gray cracks as rectangles
	const drawRect = (x, y, w, h, color) => {
		for (let yy = y; yy < y + h; yy++) {
			for (let xx = x; xx < x + w; xx++) {
				image.setPixelColor(Jimp.cssColorToHex(color), xx, yy);
			}
		}
	};
	drawRect(30, 40, 2, 50, '#404040');
	drawRect(20, 60, 60, 2, '#404040');

	// Simple pothole as filled circle
	const cx = 80, cy = 80, r = 8, color = Jimp.cssColorToHex('#202020');
	for (let y = -r; y <= r; y++) {
		for (let x = -r; x <= r; x++) {
			if (x*x + y*y <= r*r) {
				const px = cx + x, py = cy + y;
				if (px >= 0 && py >= 0 && px < width && py < height) {
					image.setPixelColor(color, px, py);
				}
			}
		}
	}

	await image.writeAsync('test-damage.png');
	console.log('Test image created: test-damage.png');
})();
