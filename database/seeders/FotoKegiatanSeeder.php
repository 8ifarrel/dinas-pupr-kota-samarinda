<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AlbumKegiatan;
use Faker\Factory as Faker;
// [CHANGE] Import the necessary classes for Intervention Image v3
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FotoKegiatanSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$faker = Faker::create();
		$albumIds = AlbumKegiatan::pluck('id')->toArray();

		// [CHANGE] Create an ImageManager instance with a specific driver (e.g., GD)
		$imageManager = new ImageManager(new Driver());

		$resolutions = [
			[640, 360],    // 360p
			[1280, 720],   // 720p
			[1920, 1080],  // 1080p
			[800, 600],    // 4:3
			[1024, 768],   // 4:3
			[1280, 1024],  // 5:4
			[1366, 768],   // 16:9
			[1600, 900],   // 16:9
			[1920, 1200],  // 16:10
		];

		// --- IMPORTANT ---
		// Intervention Image v3 does not come with a default font.
		// You must provide your own font file.
		// 1. Create a 'fonts' directory in 'storage/app/'.
		// 2. Place a .ttf font file (like 'arial.ttf') inside 'storage/app/fonts/'.
		$fontPath = storage_path('app/fonts/arial.ttf');

		if (!file_exists($fontPath)) {
			$this->command->warn("Font file not found at: {$fontPath}. Images will be created without text. Please add a font file to proceed with text generation.");
			$fontPath = null;
		}

		for ($i = 1; $i <= 120; $i++) {
			$resolution = $faker->randomElement($resolutions);
			[$width, $height] = $resolution;

			$albumId = $faker->randomElement($albumIds);
			$fileName = Str::uuid() . '.jpg';
			$relativePath = "album/{$albumId}/{$fileName}";
			$fullPath = storage_path("app/public/{$relativePath}");

			$directory = dirname($fullPath);
			if (!is_dir($directory)) {
				mkdir($directory, 0755, true);
			}

			// [CHANGE] Use the manager to create a canvas and fill it with a color.
			// The v3 'fill' method expects a color string without the '#'.
			$image = $imageManager->create($width, $height)->fill(ltrim($faker->hexColor(), '#'));

			// Add text only if the font file was found
			if ($fontPath) {
				$image->text("Dummy {$width}x{$height}", $width / 2, $height / 2, function ($font) use ($fontPath) {
					// [CHANGE] Use filename() instead of file() for v3
					$font->filename($fontPath);
					$font->size(24);
					// [CHANGE] Color in v3 does not use a '#' prefix
					$font->color('ffffff');
					$font->align('center');
					$font->valign('center');
				});
			}

			// Save the image to the specified path
			$image->save($fullPath);

			DB::table('foto_kegiatan')->insert([
				'uuid' => Str::uuid(),
				'foto' => $relativePath,
				'caption' => $faker->sentence,
				'id_album_kegiatan' => $albumId,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
	}
}

