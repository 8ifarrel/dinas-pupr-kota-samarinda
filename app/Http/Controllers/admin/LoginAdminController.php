<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginAdminController extends Controller
{
	public function index()
	{
		return view('admin.pages.login.index');
	}

	public function login(Request $request)
	{
		$request->validate([
			'name' => 'required|exists:users,name',
			'password' => 'required|string',
		]);

		$user = User::where('name', $request->name)->first();

		if ($user && Hash::check($request->password, $user->password)) {
			Auth::login($user);

			return redirect()->route('admin.dashboard.index');
		}
	}

	public function logout()
	{
		Auth::logout();
		return redirect()->route('guest.beranda.index');
	}
	
}

