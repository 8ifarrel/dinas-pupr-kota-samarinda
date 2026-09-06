<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\PPIDPelaksana;
use Illuminate\Support\Facades\Storage;

class PPIDPelaksanaGuestController extends Controller
{
  public function download($id)
  {
    $ppid = PPIDPelaksana::findOrFail($id);

    if (!$ppid->file || !Storage::disk('public')->exists($ppid->file)) {
      abort(404, 'File tidak ditemukan');
    }

    $ppid->increment('download_count');

    return Storage::disk('public')->download($ppid->file, $ppid->judul . '.' . pathinfo($ppid->file, PATHINFO_EXTENSION));
  }
}

