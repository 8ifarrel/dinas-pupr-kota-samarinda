<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UserKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class HantuBanyuAkunKelurahanAdminController extends Controller
{
  public function index(Request $request)
  {
    $kecamatanId = $request->query('kecamatan_id');

    $akun = UserKelurahan::with('kelurahan.kecamatan')
      ->whereHas('kelurahan', function ($q) use ($kecamatanId) {
        $q->when($kecamatanId, fn($qq) => $qq->where('kecamatan_id', $kecamatanId));
      })
      ->join('kelurahan', 'kelurahan.id', '=', 'users_kelurahan.kelurahan_id')
      ->orderBy('kelurahan.nama')
      ->select('users_kelurahan.*')
      ->get();

    $kecamatanList = Kecamatan::orderBy('nama')->get(['id', 'nama']);

    $page_title = 'Akun Kelurahan';
    $page_description = 'Kelola akun kelurahan yang digunakan untuk melaporkan Hantu Banyu. Setiap kelurahan hanya boleh memiliki satu akun.';

    return view('admin.pages.hantu-banyu.akun-kelurahan.index', compact(
      'akun',
      'kecamatanList',
      'kecamatanId',
      'page_title',
      'page_description'
    ));
  }

  public function create()
  {
    $kelurahanTersedia = Kelurahan::with('kecamatan')
      ->whereNotIn('id', UserKelurahan::pluck('kelurahan_id'))
      ->orderBy('nama')
      ->get();

    $page_title = 'Tambah Akun Kelurahan';
    $page_description = 'Isi form untuk menambahkan akun kelurahan baru.';

    return view('admin.pages.hantu-banyu.akun-kelurahan.create', compact(
      'kelurahanTersedia',
      'page_title',
      'page_description'
    ));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'kelurahan_id' => ['required', 'integer', 'exists:kelurahan,id', 'unique:users_kelurahan,kelurahan_id'],
      'fullname' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255', 'unique:users_kelurahan,name'],
      'password' => ['required', 'string', Password::min(8), 'confirmed'],
    ], [
      'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
      'kelurahan_id.unique' => 'Kelurahan ini sudah memiliki akun.',
      'name.unique' => 'Username sudah digunakan.',
      'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ]);

    UserKelurahan::create([
      'kelurahan_id' => $validated['kelurahan_id'],
      'fullname' => $validated['fullname'],
      'name' => $validated['name'],
      'password' => Hash::make($validated['password']),
    ]);

    return redirect()
      ->route('admin.hantu-banyu.akun-kelurahan.index')
      ->with('success', 'Akun kelurahan berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $akun = UserKelurahan::with('kelurahan.kecamatan')->findOrFail($id);

    $kelurahanTersedia = Kelurahan::with('kecamatan')
      ->where(function ($q) use ($akun) {
        $q->whereNotIn('id', UserKelurahan::where('id', '!=', $akun->id)->pluck('kelurahan_id'));
      })
      ->orderBy('nama')
      ->get();

    $page_title = 'Edit Akun Kelurahan';
    $page_description = 'Ubah data akun atau atur ulang kata sandi akun kelurahan.';

    return view('admin.pages.hantu-banyu.akun-kelurahan.edit', compact(
      'akun',
      'kelurahanTersedia',
      'page_title',
      'page_description'
    ));
  }

  public function update(Request $request, $id)
  {
    $akun = UserKelurahan::findOrFail($id);

    $validated = $request->validate([
      'kelurahan_id' => [
        'required',
        'integer',
        'exists:kelurahan,id',
        Rule::unique('users_kelurahan', 'kelurahan_id')->ignore($akun->id),
      ],
      'fullname' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255', Rule::unique('users_kelurahan', 'name')->ignore($akun->id)],
      'password' => ['nullable', 'string', Password::min(8), 'confirmed'],
    ], [
      'kelurahan_id.required' => 'Kelurahan wajib dipilih.',
      'kelurahan_id.unique' => 'Kelurahan ini sudah memiliki akun.',
      'name.unique' => 'Username sudah digunakan.',
      'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ]);

    $akun->kelurahan_id = $validated['kelurahan_id'];
    $akun->fullname = $validated['fullname'];
    $akun->name = $validated['name'];

    if (!empty($validated['password'])) {
      $akun->password = Hash::make($validated['password']);
    }

    $akun->save();

    return redirect()
      ->route('admin.hantu-banyu.akun-kelurahan.index')
      ->with('success', 'Akun kelurahan berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $akun = UserKelurahan::findOrFail($id);
    $akun->delete();

    return redirect()
      ->route('admin.hantu-banyu.akun-kelurahan.index')
      ->with('success', 'Akun kelurahan berhasil dihapus.');
  }
}
