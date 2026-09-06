<?php
// Pelapor
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

use App\Models\JalanPeduliPelapor;
use Illuminate\Http\Request;

class JalanPeduliPelaporController extends Controller
{
    public static function simpanAtauAmbilPelapor(array $data)
    {
        return JalanPeduliPelapor::updateOrCreate(
            ['nomor_ponsel' => $data['nomor_ponsel']],
            [
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'] ?? null,
                'alamat_pelapor' => $data['alamat_pelapor'],
                'kecamatan_id' => $data['kecamatan_id'],
                'kelurahan_id' => $data['kelurahan_id'],
                'rt'              => $data['rt'] ?? null,
                'rw'              => $data['rw'] ?? null,
            ]
        );
    }
}