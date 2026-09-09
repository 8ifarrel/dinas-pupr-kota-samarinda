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
    // Halaman ini khusus akun kelurahan. Admin UPTD juga bisa masuk ke area
    // Hantu Banyu sisi guest, tapi akunnya dikelola di E-Panel - bukan di
    // sini - jadi rutenya ditutup untuk mereka.
    $akun = $this->akunKelurahan();
    $akun->loadMissing('kelurahan');

    return view('guest.pages.hantu-banyu.akun.edit', [
      'page_title' => 'Kelola Akun Kelurahan',
      'meta_description' => 'Kelola username dan kata sandi akun kelurahan untuk layanan Hantu Banyu.',
      'page_context' => $this->page_context,
      'akun' => $akun,
    ]);
  }

  public function update(Request $request)
  {
    $akun = $this->akunKelurahan();

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

  /**
   * Akun kelurahan yang sedang login.
   *
   * Rutenya dijaga middleware AuthenticateKelurahan, tapi middleware itu kini
   * juga meloloskan admin - jadi di sini tetap harus dipastikan bahwa yang
   * masuk memang akun kelurahan, bukan sekadar "ada yang login".
   */
  private function akunKelurahan(): \App\Models\UserKelurahan
  {
    $akun = Auth::guard('kelurahan')->user();

    abort_unless($akun instanceof \App\Models\UserKelurahan, 404);

    return $akun;
  }
}
