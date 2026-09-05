<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\SKM;

class SKMGuestController extends Controller
{
  /** Survei pada halaman ini bersifat umum, tidak terikat fitur tertentu. */
  public int $layanan_id = Layanan::ID_UMUM;

  public function index()
  {
    $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    $page_title = "Survei Kepuasan Masyarakat";

    // Angka yang ditampilkan hanya dari survei umum, sejalan dengan survei yang
    // diisi di halaman ini; penilaian per fitur direkap terpisah di E-Panel.
    $umum = SKM::where('layanan_id', $this->layanan_id);

    $total_responden = (clone $umum)->count();
    $total_nilai = (clone $umum)->sum('nilai');
    $rata_rata = $total_responden > 0 ? round($total_nilai / $total_responden, 3) : 0;

    return view('guest.pages.skm.index', [
      'meta_description' => $meta_description,
      'page_title' => $page_title,
      'total_responden' => $total_responden,
      'rata_rata' => $rata_rata,
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'nilai' => 'required|integer|min:1|max:4',
    ]);

    SKM::create([
      'nilai' => $validated['nilai'],
      'ip_address' => $request->ip(),
      'layanan_id' => $this->layanan_id,
    ]);

    return redirect()->back()->with('success', 'Terima kasih atas partisipasi Anda!');
  }
}

