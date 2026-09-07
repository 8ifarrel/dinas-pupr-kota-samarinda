<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silalad extends Model
{
    use HasFactory;

    protected $table = 'silalad';

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
        });

        // Riwayat status dimulai begitu pesanan dibuat, dari jalur mana pun
        // (formulir publik, API, maupun seeder) - supaya tidak ada pesanan
        // yang riwayatnya kosong.
        static::created(function ($model) {
            $model->tindakLanjut()->create([
                'status' => $model->status_pengerjaan ?? 'Belum dikerjakan',
                'keterangan' => 'Pesanan diterima dan menunggu dijadwalkan.',
            ]);
        });
    }
}
