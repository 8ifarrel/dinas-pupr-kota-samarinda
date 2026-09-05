<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginKelurahanGuestController extends Controller
{
	public string $page_context = 'Drainase dan Irigasi';

	public function index()
	{
		return view('guest.pages.drainase-irigasi.login.index', [
			'page_title' => 'Login Akun Kelurahan',
			'meta_description' => 'Halaman login akun kelurahan untuk mengakses layanan Hantu Banyu Dinas PUPR Kota Samarinda.',
			'page_context' => $this->page_context,
		]);
	}

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

		if (Auth::guard('kelurahan')->attempt($credentials, $remember)) {
			$request->session()->regenerate();

			return redirect()
				->intended(route('guest.drainase-irigasi.index'));
		}

		return back()
			->withInput($request->only('name'))
			->withErrors(['name' => 'Username atau kata sandi salah.']);
	}

	public function logout(Request $request)
	{
		Auth::guard('kelurahan')->logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('guest.drainase-irigasi.login.index');
	}
}
