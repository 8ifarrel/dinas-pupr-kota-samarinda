<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SedotTinja;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SedotTinjaGuestController extends Controller
{
    public string $page_context = 'Sedot Tinja';

    /**
     * Halaman utama daftar layanan Sedot Tinja
     */
    public function index()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Sedot Tinja";

        // Ambil data dari DB (10 terbaru)
        $data = SedotTinja::latest()->paginate(10);

        return view('guest.pages.sedot-tinja.index', compact(
            'page_title',
            'meta_description',
            'data'
        ));
    }

    /**
     * Menampilkan daftar laporan
     */
    public function show()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Lihat Laporan Sedot Tinja";

        $data = SedotTinja::all();

        return view('guest.pages.sedot-tinja.show', compact(
            'page_title',
            'meta_description',
            'data'
        ));
    }

    /**
     * Form create laporan
     */
    public function create()
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Form Pendaftaran Sedot Tinja";

        return view('guest.pages.sedot-tinja.create', compact(
            'page_title',
            'meta_description'
        ));
    }

    /**
     * Simpan data form laporan
     */
  public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan'           => 'required|string|max:150',
            'nomor_telepon_pelanggan'  => 'required|string|max:15',
            'alamat'                   => 'required|string|max:255',
            'alamat_detail'            => 'nullable|string|max:255',
            'layanan'                  => 'nullable|string|max:50',
            'detail_laporan'           => 'nullable|string',
            'kabkota_id'               => 'required|string|max:50',
            'kecamatan_id'             => 'required|string|max:50',
            'kelurahan_id'             => 'required|string|max:50',
            'longitude'                => 'nullable|numeric',
            'latitude'                 => 'nullable|numeric',
            'jenis_bangunan'           => 'required|string|max:20',
            'jenis_bangunan_lainnya'   => 'nullable|string|max:100',
            'rt'                       => 'required|string',
            'nomor_bangunan'           => 'required|string',
            'foto'                     => 'nullable|image|max:2048',
            'rating'                   => 'nullable|integer|min:1|max:5',
            'saran_dan_masukan'        => 'nullable|string',
            'cf-turnstile-response'    => 'required',
        ],[
        'jenis_bangunan.required' => 'Jenis bangunan wajib dipilih.',
        'jenis_bangunan_lainnya.required_if' => 'Jenis bangunan lain harus diisi bila memilih Lainnya.',
        ],[
            'cf-turnstile-response.required' => 'Captcha wajib diselesaikan.',
            'nama_pelanggan.required' => 'Nama wajib diisi.',
            'nomor_telepon_pelanggan.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'kabkota_id.required' => 'Kabupaten/Kota harus dipilih.',
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'kelurahan_id.required' => 'Kelurahan harus dipilih.',
            'jenis_bangunan.required' => 'Jenis bangunan wajib dipilih.',
            'rt.required' => 'RT wajib diisi.',
            'nomor_bangunan.required' => 'Nomor rumah wajib diisi.',
            'setuju.accepted' => 'Anda harus menyetujui syarat tambahan biaya.',
        ]);

        // === Handle opsi "Lainnya" ===
        if ($request->jenis_bangunan === 'Lainnya' && $request->filled('jenis_bangunan_lainnya')) {
            $validated['jenis_bangunan'] = $request->jenis_bangunan_lainnya;
        }

        // === Verifikasi ke API Cloudflare Turnstile ===
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret'   => config('services.turnstile.secret'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!($result['success'] ?? false)) {
            return back()->withErrors(['cf-turnstile-response' => 'Verifikasi captcha gagal.'])->withInput();
        }

        // Simpan ke database
        $data = SedotTinja::create($validated);

        // === Notifikasi Email ke Admin ===
        try {
            Mail::raw(
                "Pendaftaran baru Sedot Tinja dari: {$data->nama_pelanggan}, 
                 No: {$data->nomor_telepon_pelanggan}, 
                 Alamat: {$data->alamat}", 
                function($msg) {
                    $msg->to('pipaair1605@gmail.com')
                        ->subject('Pendaftaran Baru Sedot Tinja');
                }
            );
        } catch (\Exception $e) {
            Log::error("Gagal kirim email: ".$e->getMessage());
        }

        // === Buat link WA untuk user ===
        $waAdmin = "+6281528231245"; // ganti nomor admin
        $pesanWA = urlencode("Halo Admin, saya {$data->nama_pelanggan} sudah daftar layanan Sedot Tinja. Mohon info lebih lanjut.");
        $urlWA   = "https://wa.me/{$waAdmin}?text={$pesanWA}";

        // Redirect ke halaman sukses
        return redirect()
            ->route('guest.sedot-tinja.success')
            ->with([
                'status' => 'Pendaftaran berhasil dikirim. Tim kami akan segera memproses.',
                'wa_link' => $urlWA
            ]);
    }

    /**
     * Halaman sukses setelah pendaftaran
     */
    public function success()
    {
        $page_title = "Pendaftaran Sukses";
        $meta_description = "Pendaftaran layanan sedot tinja berhasil dikirim.";

        return view('guest.pages.sedot-tinja.success', compact(
            'page_title',
            'meta_description'
        ));
    }

    /**
     * Cek status pendaftaran berdasarkan nomor telepon
     */
    // public function status(Request $request)
    // {
    //     $page_title = "Cek Status Pendaftaran";
    //     $meta_description = "Cek status pendaftaran layanan Sedot Tinja berdasarkan nomor telepon.";

    //     $result = null;
    //     if ($request->filled('nomor_telepon_pelanggan')) {
    //         $result = SedotTinja::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan)->get();
    //     }

    //     return view('guest.pages.sedot-tinja.status', compact(
    //         'page_title',
    //         'meta_description',
    //         'result'
    //     ));
    // }

    public function status(Request $request)
    {
        if ($request->filled('nomor_telepon_pelanggan')) {
            $result = SedotTinja::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan)
                ->paginate(10);
        } else {
            // kalau kosong, ambil semua data dengan pagination
            $result = SedotTinja::paginate(10);
        }

        return view('guest.pages.sedot-tinja.status', [
            'result' => $result,
            'page_title' => 'Cek Status Sedot Tinja',
        ]);

    }

}
