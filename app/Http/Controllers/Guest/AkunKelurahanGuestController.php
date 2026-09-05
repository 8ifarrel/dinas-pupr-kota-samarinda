<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AkunKelurahanGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';

  public function edit()
  {
    $akun = Auth::guard('kelurahan')->user()->loadMissing('kelurahan');

    return view('guest.pages.hantu-banyu.akun.edit', [
      'page_title' => 'Kelola Akun Kelurahan',
      'meta_description' => 'Kelola username dan kata sandi akun kelurahan untuk layanan Hantu Banyu.',
      'page_context' => $this->page_context,
      'akun' => $akun,
    ]);
  }

  public function update(Request $request)
  {
    $akun = Auth::guard('kelurahan')->user();

    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('users_kelurahan', 'name')->ignore($akun->id)],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ], [
      'name.required' => 'Username wajib diisi.',
      'name.max' => 'Username maksimal 255 karakter.',
      'name.unique' => 'Username sudah dipakai akun lain.',
      'password.min' => 'Kata sandi baru minimal 8 karakter.',
      'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ], [
      'name' => 'username',
      'password' => 'kata sandi baru',
    ]);

    $akun->name = $validated['name'];

    if (!empty($validated['password'])) {
      // Model UserKelurahan meng-cast 'password' => 'hashed'
      $akun->password = $validated['password'];
    }

    $akun->save();

    return redirect()
      ->route('guest.hantu-banyu.akun.edit')
      ->with('success', 'Akun berhasil diperbarui.');
  }
}
