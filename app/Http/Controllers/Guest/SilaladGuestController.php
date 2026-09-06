<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Silalad;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\SKM;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SilaladGuestController extends Controller
{
    public string $page_context = 'SILALAD';

    /**
     * Id layanan SILALAD di tabel `layanan` - dipakai untuk merekap SKM
     * (Survei Kepuasan Masyarakat) khusus fitur ini di E-Panel, terpisah
     * dari survei umum maupun survei fitur lain seperti Hantu Banyu.
     */
    public int $layanan_id = 6;

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
        // Checkbox persetujuan biaya tambahan - opsional, dicentang atau
        // tidak tetap boleh mengirim form.
        $request->merge(['setuju' => $request->has('setuju')]);

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
            'kritik'                   => 'nullable|string',
            'saran'                    => 'nullable|string',
            'setuju'                   => 'boolean',
        ],[
        'jenis_bangunan.required' => 'Jenis bangunan wajib dipilih.',
        'jenis_bangunan_lainnya.required_if' => 'Jenis bangunan lain harus diisi bila memilih Lainnya.',
        ],[
            'nama_pelanggan.required' => 'Nama wajib diisi.',
            'nomor_telepon_pelanggan.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'kabkota_id.required' => 'Kabupaten/Kota harus dipilih.',
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'kelurahan_id.required' => 'Kelurahan harus dipilih.',
            'jenis_bangunan.required' => 'Jenis bangunan wajib dipilih.',
            'rt.required' => 'RT wajib diisi.',
            'nomor_bangunan.required' => 'Nomor rumah wajib diisi.',
        ]);

        // Kritik & saran dikirim terpisah dari SKM (Survei Kepuasan
        // Masyarakat) - simpan salinannya sebelum digabung, supaya bisa
        // dicatat sebagai baris SKM tersendiri di tabel `skm` (lihat bawah).
        $skmNilai = $validated['rating'] ?? null;
        $skmKritik = $validated['kritik'] ?? null;
        $skmSaran = $validated['saran'] ?? null;

        // Form punya dua kotak terpisah "Kritik" dan "Saran", tapi kolom
        // fisiknya di tabel cuma satu (saran_masukan) - gabungkan di sini
        // (konvensi yang sama dipakai SilaladAdminController).
        $validated['saran_masukan'] = collect([$validated['kritik'] ?? null, $validated['saran'] ?? null])
            ->filter()
            ->implode("\n");
        unset($validated['kritik'], $validated['saran']);

        // === Handle opsi "Lainnya" ===
        if ($request->jenis_bangunan === 'Lainnya' && $request->filled('jenis_bangunan_lainnya')) {
            $validated['jenis_bangunan'] = $request->jenis_bangunan_lainnya;
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

        // === Simpan SKM (rating, kritik, saran bersifat opsional) ===
        // Direkap di tabel `skm` bersama (id layanan 6 = SILALAD), sama
        // seperti pola yang dipakai Hantu Banyu, supaya E-Panel bisa
        // menampilkan survei kepuasan lewat halaman yang sama bentuknya.
        SKM::create([
            'nilai' => $skmNilai,
            'ip_address' => $request->ip(),
            'kritik' => $skmKritik,
            'saran' => $skmSaran,
            'layanan_id' => $this->layanan_id,
        ]);

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

    /**
     * Halaman detail satu pesanan (dibuka dari "Lihat Detail" di halaman
     * cek status).
     */
    public function show(Request $request, $id)
    {
        $data = Silalad::findOrFail($id);

        // Nomor telepon dipakai sebagai "kunci" - tanpa nomor telepon yang
        // cocok, orang lain tidak bisa asal menebak id pesanan untuk
        // mengintip detail pesanan pelanggan lain.
        if ($data->nomor_telepon_pelanggan !== $request->query('nomor_telepon_pelanggan')) {
            abort(403);
        }

        $page_title = 'Detail Pesanan SILALAD';
        $meta_description = 'Detail pemesanan layanan SILALAD.';
        $namaKecamatan = optional(Kecamatan::find($data->kecamatan_id))->nama ?? $data->kecamatan_id;
        $namaKelurahan = optional(Kelurahan::find($data->kelurahan_id))->nama ?? $data->kelurahan_id;

        return view('guest.pages.silalad.show', compact(
            'data',
            'page_title',
            'meta_description',
            'namaKecamatan',
            'namaKelurahan'
        ));
    }

    public function status(Request $request)
        {
            // Wajib disaring berdasarkan nomor telepon yang dipakai saat
            // mendaftar. Tanpa nomor telepon, tetap kosong - supaya halaman
            // ini tidak jadi daftar publik seluruh pemesanan pelanggan lain.
            $history = collect();
            // Tahun difilter hanya dari pesanan milik nomor telepon ini
            // sendiri, bukan dari seluruh pelanggan lain - supaya pilihan
            // tahun yang tampil memang relevan dengan riwayat orang ini.
            $years = collect();
            $statusList = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];

            if ($request->filled('nomor_telepon_pelanggan')) {
                $years = Silalad::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan)
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

                $historyQuery = Silalad::where('nomor_telepon_pelanggan', $request->nomor_telepon_pelanggan);

                if ($request->filled('status')) {
                    $historyQuery->where('status_pengerjaan', $request->status);
                }

                if ($request->filled('year')) {
                    $historyQuery->whereYear('created_at', $request->year);
                }

                if ($request->filled('month')) {
                    $historyQuery->whereMonth('created_at', $request->month);
                }

                $history = $historyQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'history_page')->withQueryString();
            }

            return view('guest.pages.silalad.status', [
                'history'     => $history,
                'years'       => $years,
                'statusList'  => $statusList,
                'page_title'  => 'Cek Status SILALAD',
                'meta_description' => 'Cek status pemesanan layanan SILALAD berdasarkan nomor telepon.',
            ]);
        }


}
