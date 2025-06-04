<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PegawaiAdminController extends Controller
{
    public function index(Request $request)
    {
        $jabatanId = $request->get('jabatan');
        $jabatan = Jabatan::findOrFail($jabatanId);
        $page_title = "Pegawai " . $jabatan->nama_jabatan;

        // Pengecualian untuk Kepala Dinas
        if (strtolower($jabatan->nama_jabatan) === 'kepala dinas') {
            $jabatanIds = [$jabatanId];
        } else {
            // Ambil id jabatan induk + seluruh anak (subbagian/fungsional)
            $jabatanIds = Jabatan::where('id_jabatan', $jabatanId)
                ->orWhere('id_jabatan_parent', $jabatanId)
                ->pluck('id_jabatan')
                ->toArray();
        }

        $pegawai = Pegawai::with('jabatan')
            ->whereIn('id_jabatan', $jabatanIds)
            ->orderByRaw("FIELD(posisi, 'Sekretaris', 'Kepala', 'PLT', 'Staf')")
            ->get();

        return view('admin.pages.pegawai.index', compact('pegawai', 'page_title'));
    }

    public function create(Request $request)
    {
        $jabatanId = $request->get('jabatan');
        $jabatan = Jabatan::where('id_jabatan', $jabatanId)
            ->orWhere('id_jabatan_parent', $jabatanId)
            ->get();
        $page_title = "Tambah Pegawai";

        return view('admin.pages.pegawai.create', compact('jabatan', 'page_title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'nama_pegawai' => 'required|string|max:255',
            'foto_pegawai' => 'nullable|string',
            'nomor_induk_pegawai' => 'nullable|string|max:255|unique:pegawai,nomor_induk_pegawai',
            'nomor_telepon_pegawai' => 'required|string|max:255|unique:pegawai,nomor_telepon_pegawai',
            'golongan_pegawai' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pegawai = new Pegawai($request->except(['foto_pegawai', 'username', 'email', 'password']));
        
        if ($request->filled('foto_pegawai')) {
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
        $user->save();

        return redirect()->route('admin.pegawai.index', ['jabatan' => $request->get('jabatan')])
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        $jabatan = Jabatan::all();
        $page_title = "Edit Pegawai";

        return view('admin.pages.pegawai.edit', compact('pegawai', 'jabatan', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);

        $validated = $request->validate([
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'nama_pegawai' => 'required|string|max:255',
            'foto_pegawai' => 'nullable|string',
            'nomor_induk_pegawai' => 'nullable|string|max:255|unique:pegawai,nomor_induk_pegawai,' . $pegawai->id_pegawai . ',id_pegawai',
            'nomor_telepon_pegawai' => 'required|string|max:255|unique:pegawai,nomor_telepon_pegawai,' . $pegawai->id_pegawai . ',id_pegawai',
            'golongan_pegawai' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name,' . ($pegawai->user->id ?? 'NULL'),
            'email' => 'required|string|email|max:255|unique:users,email,' . ($pegawai->user->id ?? 'NULL'),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $pegawai->fill($request->except(['foto_pegawai', 'username', 'email', 'password']));

        if ($request->filled('foto_pegawai')) {
            $fotoPegawaiData = json_decode($request->input('foto_pegawai'), true);
            if (isset($fotoPegawaiData['fileUrl'])) {
                $tempFilePath = str_replace('/storage/', '', $fotoPegawaiData['fileUrl']);
                $fileName = 'pegawai/' . Str::slug($request->nama_pegawai) . '.' . pathinfo($tempFilePath, PATHINFO_EXTENSION);
                Storage::disk('public')->move($tempFilePath, $fileName);
                $pegawai->foto_pegawai = $fileName;
            }
        }

        $pegawai->save();

        $user = $pegawai->user;
        if ($user) {
            $user->name = $request->username;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        return redirect()->route('admin.pegawai.index', ['jabatan' => $pegawai->id_jabatan])
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->user) {
            $pegawai->user->delete();
        }

        if ($pegawai->foto_pegawai && Storage::disk('public')->exists($pegawai->foto_pegawai)) {
            Storage::disk('public')->delete($pegawai->foto_pegawai);
        }

        $pegawai->delete();

        return back()->with('success', 'Pegawai berhasil dihapus.');
    }
}
