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
    public function show($id = null)
    {
        $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
        $page_title = "Lihat Laporan Sedot Tinja";

        if ($id) {
            // Kalau ada ID → tampilkan detail 1 data
            $order = SedotTinja::findOrFail($id);

            return view('guest.pages.sedot-tinja.show', [
                'order' => $order,
                'page_title' => 'Detail Pemesanan Sedot Tinja',
                'meta_description' => $meta_description,
            ]);
        } else {
            // Kalau tidak ada ID → tampilkan semua data
            $data = SedotTinja::all();

            return view('guest.pages.sedot-tinja.show', [
                'data' => $data,
                'page_title' => $page_title,
                'meta_description' => $meta_description,
            ]);
        }
    }


    // public function show()
    // {
    //     $meta_description = "Laporkan kerusakan serta dapatkan berita dan informasi terbaru lainnya dari Dinas PUPR Kota Samarinda.";
    //     $page_title = "Lihat Laporan Sedot Tinja";

    //     $data = SedotTinja::all();

    //     return view('guest.pages.sedot-tinja.show', compact(
    //         'page_title',
    //         'meta_description',
    //         'data'
    //     ));
    // }

    // public function show($id)
    // {
    //     // Ambil data berdasarkan ID
    //     $order = SedotTinja::findOrFail($id);

    //     return view('guest.pages.sedot-tinja.show', [
    //         'order' => $order,
    //         'page_title' => 'Detail Pemesanan Sedot Tinja'
    //     ]);
    // }


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

        // === Generate kode_booking otomatis ===
        $lastOrder = SedotTinja::whereYear('created_at', now()->year)
            ->orderByDesc('id')
            ->first();

        $lastNumber = $lastOrder ? intval(substr($lastOrder->kode_booking, -3)) : 0;
        $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $kode_booking = 'STJ-' . now()->year . '-' . $newNumber;
        $validated['kode_booking'] = $kode_booking; // tambahkan ke data validasi


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

    public function status(Request $request)
        {
            // Ambil semua tahun dari data untuk filter
            $years = SedotTinja::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            // Query dasar histori
            $historyQuery = SedotTinja::query();

            // Filter histori berdasarkan tahun
            if ($request->filled('year')) {
                $historyQuery->whereYear('created_at', $request->year);
            }

            // Filter histori berdasarkan bulan
            if ($request->filled('month')) {
                $historyQuery->whereMonth('created_at', $request->month);
            }

            $history = $historyQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'history_page');

            // Query hasil pencarian khusus
            $result = collect(); // default kosong
            if ($request->filled('nomor_telepon_pelanggan')) {
                $result = SedotTinja::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            return view('guest.pages.sedot-tinja.status', [
                'result'      => $result,
                'history'     => $history,
                'years'       => $years,
                'page_title'  => 'Cek Status Sedot Tinja',
            ]);
        }


}
