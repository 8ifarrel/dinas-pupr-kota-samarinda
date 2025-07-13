<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SusunanOrganisasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class KelolaAkunSayaAdminController extends Controller
{
  public function edit($id)
  {
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
      'password' => [
        'required',
        'string',
        Password::min(10)->letters()->numbers()->uncompromised(),
        'confirmed',
        function ($attribute, $value, $fail) use ($request, $user) {
          if ($request->name && Str::contains(Str::lower($value), Str::lower($request->name))) {
            $fail('Password tidak boleh mengandung username.');
          }
          if ($request->fullname && Str::contains(Str::lower($value), Str::lower(str_replace(' ', '', $request->fullname)))) {
            $fail('Password tidak boleh mengandung nama lengkap.');
          }
          if ($request->id_susunan_organisasi) {
            $so = SusunanOrganisasi::find($request->id_susunan_organisasi);
            if ($so && $so->nama_susunan_organisasi) {
              $namaSO = Str::lower(str_replace(' ', '', $so->nama_susunan_organisasi));
              if (Str::contains(Str::lower($value), $namaSO)) {
                $fail('Password tidak boleh mengandung nama susunan organisasi.');
              }
            }
          }
          if (in_array($request->password, config('weak_local_passwords'))) {
            $fail('Password ini terlalu mudah ditebak. Silakan pilih yang lebih kuat.');
          }
        },
      ],
    ];

    $messages = [
      'name.unique' => 'Username sudah digunakan.',
      'name.regex' => 'Username hanya boleh berisi huruf, angka, titik, strip (-), dan underscore (_).',
      'name.not_regex' => 'Username tidak boleh mengandung spasi.',
      'password.min' => 'Password minimal 10 karakter.',
      'password.letters' => 'Password harus mengandung minimal satu huruf.',
      'password.numbers' => 'Password harus mengandung minimal satu angka.',
      'password.confirmed' => 'Konfirmasi password tidak sama.',
      'password.uncompromised' => 'Password ini tercatat pernah digunakan di situs lain yang mengalami insiden kebocoran data, silakan gunakan password lain.',
    ];

    $validated = $request->validate($rules, $messages);

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
