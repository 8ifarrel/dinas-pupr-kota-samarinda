<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginKelurahanGuestController extends Controller
{
  public string $page_context = 'Hantu Banyu';

  public function index()
  {
    return view('guest.pages.hantu-banyu.login.index', [
      'page_title' => 'Login Akun Kelurahan',
      'meta_description' => 'Halaman login akun kelurahan untuk mengakses layanan Hantu Banyu Dinas PUPR Kota Samarinda.',
      'page_context' => $this->page_context,
    ]);
  }

  /**
   * Halaman ini menerima dua macam akun: akun kelurahan dan akun admin
   * E-Panel. Keduanya dicoba dengan kredensial yang sama persis, akun
   * kelurahan lebih dulu karena merekalah pemakai utama halaman ini.
   *
   * Karena kedua guard berbagi session yang sama, admin yang login di sini
   * sekaligus login di E-Panel - dan sebaliknya. Itu memang yang diinginkan:
   * satu kali login untuk dua sisi aplikasi.
   */

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'name' => 'required|string',
      'password' => 'required|string',
    ], [], [
      'name' => 'username',
      'password' => 'kata sandi',
    ]);

    $remember = $request->boolean('remember');

    foreach (['kelurahan', 'web'] as $guard) {
      if (Auth::guard($guard)->attempt($credentials, $remember)) {
        $request->session()->regenerate();

        return redirect()
          ->intended(route('guest.hantu-banyu.index'));
      }
    }

    return back()
      ->withInput($request->only('name'))
      ->withErrors(['name' => 'Username atau kata sandi salah.']);
  }

  /**
   * Keluar dari kedua guard sekaligus.
   *
   * Untuk admin ini berarti keluar juga dari E-Panel, konsekuensi wajar dari
   * satu session yang dipakai bersama - sama seperti login yang berlaku di
   * kedua sisi.
   */
  public function logout(Request $request)
  {
    Auth::guard('kelurahan')->logout();
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('guest.hantu-banyu.login.index');
  }
}
