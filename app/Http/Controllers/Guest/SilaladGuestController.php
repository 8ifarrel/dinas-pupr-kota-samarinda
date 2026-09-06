<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Silalad;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SilaladGuestController extends Controller
{
    public string $page_context = 'SILALAD';

    /**
     * Halaman utama daftar layanan SILALAD
     */
    public function index()
    {
        $meta_description = "SILALAD - layanan sedot tinja UPTD Pengelolaan Air Limbah Domestik Dinas PUPR Kota Samarinda.";
        $page_title = "SILALAD";

        $statistik = [
            'belum_dikerjakan' => Silalad::where('status_pengerjaan', 'Belum dikerjakan')->count(),
            'sedang_dikerjakan' => Silalad::where('status_pengerjaan', 'Sedang dikerjakan')->count(),
            'sudah_dikerjakan' => Silalad::where('status_pengerjaan', 'Sudah dikerjakan')->count(),
        ];

        return view('guest.pages.silalad.index', compact(
            'page_title',
            'meta_description',
            'statistik'
        ));
    }

    /**
     * Menampilkan detail satu pemesanan.
     *
     * Hanya bisa diakses bila nomor telepon yang dipakai saat mendaftar
     * disertakan lewat query string (?telepon=...) dan cocok dengan data
     * pemesanan tersebut, supaya id pemesanan tidak bisa ditebak/diurut
     * untuk melihat data pelanggan lain.
     */
    public function show($id)
    {
        $meta_description = "Detail pemesanan layanan SILALAD.";

        $order = Silalad::where('id', $id)
            ->where('nomor_telepon_pelanggan', request('telepon'))
            ->first();

        abort_if(!$order, 404);

        return view('guest.pages.silalad.show', [
            'order' => $order,
            'page_title' => 'Detail Pemesanan SILALAD',
            'meta_description' => $meta_description,
        ]);
    }

    /**
     * Form create laporan
     */
    public function create()
    {
        $meta_description = "Daftar layanan SILALAD - sedot tinja - secara online.";
        $page_title = "Form Pendaftaran SILALAD";
        $kecamatans = Kecamatan::orderBy('nama')->get(['id', 'nama']);

        return view('guest.pages.silalad.create', compact(
            'page_title',
            'meta_description',
            'kecamatans'
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
            'rating'                   => 'nullable|integer|min:1|max:5',
            'saran_masukan'        => 'nullable|string',
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
            'secret'   => config('app.turnstile_secret'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!($result['success'] ?? false)) {
            return back()->withErrors(['cf-turnstile-response' => 'Verifikasi captcha gagal.'])->withInput();
        }

        // === Generate kode_booking otomatis ===
        $lastOrder = Silalad::whereYear('created_at', now()->year)
            ->orderByDesc('id')
            ->first();

        $lastNumber = $lastOrder ? intval(substr($lastOrder->kode_booking, -3)) : 0;
        $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $kode_booking = 'SIL-' . now()->year . '-' . $newNumber;
        $validated['kode_booking'] = $kode_booking; // tambahkan ke data validasi


        // Simpan ke database
        $data = Silalad::create($validated);

        // === Notifikasi Email ke Admin ===
        try {
            Mail::raw(
                "Pendaftaran baru SILALAD dari: {$data->nama_pelanggan}, 
                 No: {$data->nomor_telepon_pelanggan}, 
                 Alamat: {$data->alamat}", 
                function($msg) {
                    $msg->to('pipaair1605@gmail.com')
                        ->subject('Pendaftaran Baru SILALAD');
                }
            );
        } catch (\Exception $e) {
            Log::error("Gagal kirim email: ".$e->getMessage());
        }

        // === Buat link WA untuk user ===
        $waAdmin = "+6281528231245"; // ganti nomor admin
        $pesanWA = urlencode("Halo Admin, saya {$data->nama_pelanggan} sudah daftar layanan SILALAD. Mohon info lebih lanjut.");
        $urlWA   = "https://wa.me/{$waAdmin}?text={$pesanWA}";

        // Redirect ke halaman sukses
        return redirect()
            ->route('guest.silalad.success')
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
        $meta_description = "Pendaftaran layanan SILALAD berhasil dikirim.";

        return view('guest.pages.silalad.success', compact(
            'page_title',
            'meta_description'
        ));
    }

    public function status(Request $request)
        {
            // Ambil semua tahun dari data untuk filter
            $years = Silalad::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            // Histori & hasil pencarian sama-sama wajib disaring berdasarkan nomor
            // telepon yang dipakai saat mendaftar. Tanpa nomor telepon, keduanya
            // tetap kosong - supaya halaman ini tidak jadi daftar publik seluruh
            // pemesanan pelanggan lain.
            $result = collect();
            $history = collect();

            if ($request->filled('nomor_telepon_pelanggan')) {
                $historyQuery = Silalad::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan);

                if ($request->filled('year')) {
                    $historyQuery->whereYear('created_at', $request->year);
                }

                if ($request->filled('month')) {
                    $historyQuery->whereMonth('created_at', $request->month);
                }

                $history = $historyQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'history_page');

                $result = Silalad::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            return view('guest.pages.silalad.status', [
                'result'      => $result,
                'history'     => $history,
                'years'       => $years,
                'page_title'  => 'Cek Status SILALAD',
                'meta_description' => 'Cek status pemesanan layanan SILALAD berdasarkan nomor telepon.',
            ]);
        }


}
