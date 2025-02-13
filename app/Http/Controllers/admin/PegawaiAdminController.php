<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PegawaiAdminController extends Controller
{
    public function index(Request $request)
    {
        $jabatanId = $request->get('jabatan');
        $jabatan = Jabatan::find($jabatanId);
        $page_title = "Pegawai " . $jabatan->nama_jabatan;

        $relatedJabatanIds = Jabatan::where('id_jabatan_parent', $jabatanId)
            ->orWhere('id_jabatan', $jabatanId)
            ->pluck('id_jabatan');

        $pegawai = Pegawai::with('jabatan')
            ->whereIn('id_jabatan', $relatedJabatanIds)
            ->orderByRaw("FIELD(posisi, 'Sekretaris', 'Kepala', 'PLT', 'Staf')")
            ->get();

        return view('admin.pages.pegawai.index', [
            'pegawai' => $pegawai,
            'page_title' => $page_title
        ]);
    }

    public function create(Request $request)
    {
        $jabatanId = $request->get('jabatan');
        $jabatan = Jabatan::where('id_jabatan', $jabatanId)
            ->orWhere('id_jabatan_parent', $jabatanId)
            ->get();
        $page_title = "Tambah Pegawai";

        return view('admin.pages.pegawai.create', [
            'jabatan' => $jabatan,
            'page_title' => $page_title
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jabatan' => 'required',
            'nama_pegawai' => 'required|string|max:255',
            'foto_pegawai' => 'nullable|string',
            'nomor_induk_pegawai' => 'nullable|string|max:255|unique:pegawai',
            'nomor_telepon_pegawai' => 'required|string|max:255|unique:pegawai',
            'golongan_pegawai' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pegawai = new Pegawai($request->except(['foto_pegawai', 'username', 'email', 'password']));
        
        if ($request->has('foto_pegawai')) {
            $fotoPegawaiData = json_decode($request->input('foto_pegawai'), true);
            if (isset($fotoPegawaiData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoPegawaiData['fileUrl']);
                $fileName = 'pegawai/' . Str::slug($request->nama_pegawai) . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $fileName);
                $pegawai->foto_pegawai = $fileName;
            }
        }

        $pegawai->save();

        $user = new User([
            'id_pegawai' => $pegawai->id_pegawai,
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->id_pegawai = $pegawai->id_pegawai;
        $user->save();

        return redirect()->route('admin.pegawai.index', ['jabatan' => $request->get('jabatan')])->with('success', 'Pegawai berhasil ditambahkan.');
    }
}
