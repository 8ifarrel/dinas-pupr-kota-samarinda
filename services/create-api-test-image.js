// Create sample test image untuk testing API (Jimp-only)
const Jimp = require("jimp");
const path = require("path");

(async () => {
    const width = 300,
        height = 300;
    const image = new Jimp(width, height, "#707070");

    // Road texture pattern
    const texColor = Jimp.cssColorToHex("#606060");
    for (let i = 0; i < width; i += 10) {
        for (let dx = 0; dx < 5; dx++) {
            const x = i + dx;
            const y = 150;
            if (x < width) image.setPixelColor(texColor, x, y);
        }
    }

    // Crack pattern: draw polyline by plotting pixels (Bresenham-like simple steps)
    const crackColor = Jimp.cssColorToHex("#303030");
    const line = (x0, y0, x1, y1) => {
        const dx = Math.abs(x1 - x0),
            sx = x0 < x1 ? 1 : -1;
        const dy = -Math.abs(y1 - y0),
            sy = y0 < y1 ? 1 : -1;
        let err = dx + dy,
            x = x0,
            y = y0;
        while (true) {
            if (x >= 0 && y >= 0 && x < width && y < height)
                image.setPixelColor(crackColor, x, y);
            if (x === x1 && y === y1) break;
            const e2 = 2 * err;
            if (e2 >= dy) {
                err += dy;
                x += sx;
            }
            if (e2 <= dx) {
                err += dx;
                y += sy;
            }
        }
    };
    // main crack
    line(50, 100, 80, 120);
    line(80, 120, 120, 110);
    line(120, 110, 160, 140);
    line(160, 140, 200, 130);
    line(200, 130, 250, 160);
    // secondary cracks
    line(100, 80, 130, 200);
    line(180, 70, 210, 220);

    // Potholes as filled circles
    const fillCircle = (cx, cy, r, hex) => {
        for (let y = -r; y <= r; y++) {
            for (let x = -r; x <= r; x++) {
                if (x * x + y * y <= r * r) {
                    const px = cx + x,
                        py = cy + y;
                    if (px >= 0 && py >= 0 && px < width && py < height)
                        image.setPixelColor(hex, px, py);
                }
            }
        }
    };
    const hole = Jimp.cssColorToHex("#202020");
    fillCircle(70, 200, 12, hole);
    fillCircle(180, 250, 8, hole);

    const outPath = path.join(
        __dirname,
        "..",
        "public",
        "test-road-damage.jpg"
    );
    await image.quality(80).writeAsync(outPath);
    console.log("API test image created:", outPath);
})();
