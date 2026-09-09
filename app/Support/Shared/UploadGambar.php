<?php

namespace App\Support\Shared;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Simpan gambar yang dikirim lewat salah satu dari dua bentuk input:
 * upload file biasa (multipart), atau string JSON hasil filepond/cropper
 * berisi 'fileUrl' yang menunjuk ke file sementara di disk 'public'
 * (dipindah ke lokasi akhir).
 */
class UploadGambar
{
  /**
   * @param  string  $field               nama field input (mis. 'foto_slider')
   * @param  string  $tujuanTanpaEkstensi  path relatif di disk 'public', tanpa
   *                                       ekstensi (mis. "Slider/nama-1")
   * @param  string|null  $pathLama        path file lama yang akan digantikan
   *                                       (dihapus tepat sebelum file baru
   *                                       ditulis, supaya aman walau path
   *                                       lama & baru kebetulan sama - mis.
   *                                       nama file berbasis slug yang tidak
   *                                       berubah). Biarkan null untuk data
   *                                       baru (tidak ada yang dihapus).
   * @return string|null  path relatif yang tersimpan (untuk disetel ke kolom
   *                       model), atau null bila field ini tidak berisi
   *                       file/JSON valid pada request (tidak ada perubahan).
   */
  public static function simpan(Request $request, string $field, string $tujuanTanpaEkstensi, ?string $pathLama = null): ?string
  {
    if ($request->hasFile($field)) {
      $file = $request->file($field);
      $path = $tujuanTanpaEkstensi . '.' . $file->getClientOriginalExtension();

      self::hapusLama($pathLama);
      $file->storeAs('public/' . dirname($path), basename($path));

      return $path;
    }

    if ($request->filled($field)) {
      $data = json_decode($request->input($field), true);

      if (isset($data['fileUrl'])) {
        $tempFilePath = str_replace('/storage/', '', $data['fileUrl']);
        $path = $tujuanTanpaEkstensi . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);

        self::hapusLama($pathLama);
        Storage::disk('public')->move($tempFilePath, $path);

        return $path;
      }
    }

    return null;
  }

  /** Hapus file lama di disk 'public', bila ada. */
  public static function hapusLama(?string $path): void
  {
    if ($path && Storage::disk('public')->exists($path)) {
      Storage::disk('public')->delete($path);
    }
  }
}
