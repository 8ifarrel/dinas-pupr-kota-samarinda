<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silalad extends Model
{
    use HasFactory;

    protected $table = 'silalad';

    // Status pesanan. Sebelumnya daftar ini disalin di empat controller yang
    // berbeda; disatukan di sini supaya perubahan alur cukup di satu tempat.
    // Kelas warna badge sengaja TIDAK ditaruh di sini - Tailwind hanya
    // memindai resources/, jadi kelas yang ditulis di app/ akan terbuang saat
    // build. Warna tetap ditulis literal di masing-masing view.
    public const MENUNGGU = 'Menunggu konfirmasi';
    public const DIJADWALKAN = 'Dijadwalkan';
    public const DIKERJAKAN = 'Sedang dikerjakan';
    public const SELESAI = 'Selesai';
    public const DIBATALKAN = 'Dibatalkan';

    public const STATUS = [
        self::MENUNGGU,
        self::DIJADWALKAN,
        self::DIKERJAKAN,
        self::SELESAI,
        self::DIBATALKAN,
    ];

    /**
     * Urutan tahap pengerjaan. Dipakai untuk menentukan data apa yang sudah
     * wajib terisi: pesanan yang sudah sampai tahap tertentu berarti sudah
     * melewati semua tahap sebelumnya, jadi datanya ikut diwajibkan meski
     * statusnya dilompati (mis. admin mencatat pesanan lama langsung sebagai
     * "Selesai"). "Dibatalkan" di luar urutan ini karena bisa terjadi kapan
     * saja, jadi tidak mewajibkan data tahap mana pun.
     */
    public const TAHAP = [
        self::MENUNGGU => 0,
        self::DIJADWALKAN => 1,
        self::DIKERJAKAN => 2,
        self::SELESAI => 3,
    ];

    public static function tahap(?string $status): int
    {
        return self::TAHAP[$status] ?? -1;
    }

    /**
     * Surat Pesanan dan Surat Perintah Kerja sama-sama terbit saat pesanan
     * dijadwalkan, jadi syarat cetaknya sama.
     *
     * Pesanan yang dibatalkan setelah SPK-nya terbit tetap boleh dicetak
     * ulang: suratnya sudah benar-benar diterbitkan dan jadi arsip UPTD,
     * jadi mengunci cetak ulang justru menghilangkan dokumen yang ada.
     */
    public function suratPenugasanTerbit(): bool
    {
        if (self::tahap($this->status_pengerjaan) >= self::TAHAP[self::DIJADWALKAN]) {
            return true;
        }

        return $this->status_pengerjaan === self::DIBATALKAN && filled($this->nomor_spk);
    }

    protected $fillable = [
        'kode_booking',
        'nama_pelanggan',
        'nomor_telepon_pelanggan',
        'alamat',
        'layanan',
        'detail_laporan',
        'kabkota_id',
        'kecamatan_id',
        'kelurahan_id',
        'latitude',
        'longitude',
        'jenis_bangunan',
        'alamat_detail',
        'tanggal_diharapkan',
        'tanggal_pelaksanaan',
        'nomor_bangunan',
        'rt',
        'rating',
        'saran_masukan',
        'captcha',
        'status_pengerjaan',
        'setuju',

        // Penugasan & pelaksanaan - diisi admin, jadi bahan ketiga surat
        'nomor_spk',
        'jarak_tangki',
        'bisa_disedot',
        'tanggal_pesanan',
        'nama_operator',
        'nomor_kendaraan',
        'kapasitas_kendaraan',
        'tanggal_perintah',
        'jumlah_rit',
        'tanggal_jalan',
        'alasan_batal',
    ];

    protected $casts = [
        'bisa_disedot' => 'boolean',
        'setuju' => 'boolean',
        'tanggal_diharapkan' => 'date',
        'tanggal_pelaksanaan' => 'date',
        'tanggal_pesanan' => 'date',
        'tanggal_perintah' => 'date',
        'tanggal_jalan' => 'date',
    ];

    /** Riwayat perubahan status, terbaru di akhir. */
    public function tindakLanjut()
    {
        return $this->hasMany(SilaladTindakLanjut::class, 'silalad_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // ambil tahun sekarang
            $tahun = date('Y');

            // ambil nomor urut terakhir
            $last = static::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();

            $nextNumber = $last ? ((int) substr($last->kode_booking, -3)) + 1 : 1;

            $model->kode_booking = 'SIL-' . $tahun . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Nilai bawaan status ada di kolom basis data, tapi model hasil
            // create() tidak ikut mengetahuinya - status di memori jadi null
            // sampai di-refresh. Diisi di sini supaya pemanggil mana pun
            // (formulir, API, seeder) langsung mendapat status yang benar.
            $model->status_pengerjaan = $model->status_pengerjaan ?: self::MENUNGGU;
        });

        // Riwayat status dimulai begitu pesanan dibuat, dari jalur mana pun
        // (formulir publik, API, maupun seeder) - supaya tidak ada pesanan
        // yang riwayatnya kosong.
        static::created(function ($model) {
            $model->tindakLanjut()->create([
                'status' => $model->status_pengerjaan ?? self::MENUNGGU,
                'keterangan' => 'Pesanan diterima dan menunggu dijadwalkan.',
            ]);
        });
    }
}
