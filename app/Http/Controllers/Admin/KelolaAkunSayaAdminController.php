<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Shared\ValidasiKekuatanPassword;
use Illuminate\Http\Request;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KelolaAkunSayaAdminController extends Controller
{
  public function edit($id)
  {
    // Anotasi diperlukan karena guard mengembalikan kontrak Authenticatable,
    // sedangkan model sebenarnya baru ditentukan config/auth.php saat berjalan.
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->id != $id) {
      abort(403);
    }
    $page_title = "Kelola Akun Saya";
    $page_description = "Ubah data akun dan password Anda.";
    $susunan_organisasi = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
      ->orderBy('nama_susunan_organisasi')
      ->get();

    return view('admin.pages.kelola-akun-saya.edit', compact('page_title', 'page_description', 'user', 'susunan_organisasi'));
  }

  public function update(Request $request, $id)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->id != $id) {
      abort(403);
    }

    $rules = [
      'fullname' => ['required', 'string', 'max:255'],
      'name' => [
        'required',
        'string',
        'max:255',
        'unique:users,name,' . $user->id,
        'regex:/^[A-Za-z0-9_.-]+$/',
        'not_regex:/\s/',
      ],
      'id_susunan_organisasi' => [
        'required',
        'exists:susunan_organisasi,id_susunan_organisasi'
      ],
      'old_password' => ['required'],
      'password' => ValidasiKekuatanPassword::aturan($request),
    ];

    $validated = $request->validate($rules, ValidasiKekuatanPassword::pesan());

    if (!Hash::check($request->old_password, $user->password)) {
      return back()->withErrors(['old_password' => 'Password lama salah.'])->withInput();
    }

    $user->fullname = $validated['fullname'];
    $user->name = $validated['name'];
    $user->id_susunan_organisasi = $validated['id_susunan_organisasi'];
    $user->password = Hash::make($validated['password']);
    $user->save();

    return redirect()->route('admin.kelola-akun-saya.edit', $user->id)->with('success', 'Akun berhasil diperbarui.');
  }

  public function destroy($id)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->id != $id) {
      abort(403);
    }
    $request = request();
    $request->validate([
      'delete_password' => ['required'],
    ], [
      'delete_password.required' => 'Password wajib diisi untuk menghapus akun.',
    ]);
    if (!Hash::check($request->delete_password, $user->password)) {
      return back()->withErrors(['delete_password' => 'Password salah.'])->withInput();
    }
    Auth::logout();
    $user->delete();
    return redirect()->route('admin.login.index')->with('success', 'Akun Anda berhasil dihapus.');
  }
}
