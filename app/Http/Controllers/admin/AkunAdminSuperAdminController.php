<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\SusunanOrganisasi;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AkunAdminSuperAdminController extends Controller
{
  public function index()
  {
    $users = User::with('susunanOrganisasi')
      ->where('is_super_admin', false)
      ->get();

    $page_title = "Akun Admin";
    $page_description = "Kelola akun admin yang digunakan untuk mengakses E-Panel. Akun super admin tidak ditampilkan di sini.";

    return view('admin.pages.super-admin.akun-admin.index', compact('users', 'page_title', 'page_description'));
  }

  public function create()
  {
    $page_title = "Tambah Akun Admin";
    $page_description = "Isi form untuk menambahkan akun admin.";

    $susunan_organisasi = SusunanOrganisasi::orderBy('nama_susunan_organisasi')->get();

    return view('admin.pages.super-admin.akun-admin.create', compact('page_title', 'susunan_organisasi', 'page_description'));
  }

  public function store(Request $request)
  {
    if ($request->id_susunan_organisasi == 1) {
      $kepalaDinasSudahAda = User::where('id_susunan_organisasi', 1)->exists();
      if ($kepalaDinasSudahAda) {
        return back()->withErrors(['id_susunan_organisasi' => 'Akun Kepala Dinas sudah ada, tidak boleh lebih dari satu.'])->withInput();
      }
    }

    $validated = $request->validate([
      'fullname' => ['required', 'string', 'max:255'],
      'name' => [
        'required',
        'string',
        'max:255',
        'unique:users,name',
        'regex:/^[A-Za-z0-9_.-]+$/',
        'not_regex:/\s/',
      ],
      'id_susunan_organisasi' => [
        'required',
        'exists:susunan_organisasi,id_susunan_organisasi'
      ],
      'password' => [
        'required',
        'string',
        Password::min(12)
          ->letters()
          ->numbers()
          ->uncompromised(),
        'confirmed',
        function ($attribute, $value, $fail) use ($request) {
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
    ], [
      'name.unique' => 'Username sudah digunakan.',
      'name.regex' => 'Username hanya boleh berisi huruf, angka, titik, strip (-), dan underscore (_).',
      'name.not_regex' => 'Username tidak boleh mengandung spasi.',
      'password.min' => 'Password minimal 12 karakter.',
      'password.letters' => 'Password harus mengandung minimal satu huruf.',
      'password.numbers' => 'Password harus mengandung minimal satu angka.',
      'password.confirmed' => 'Konfirmasi password tidak sama.',
      'password.uncompromised' => 'Password ini tercatat pernah digunakan di situs lain yang mengalami insiden kebocoran data, silakan gunakan password lain.',
    ]);

    User::create([
      'fullname' => $validated['fullname'],
      'name' => $validated['name'],
      'id_susunan_organisasi' => $validated['id_susunan_organisasi'],
      'password' => Hash::make($validated['password']),
      'is_super_admin' => false,
    ]);

    return redirect()
      ->route('admin.super.akun-admin.index')
      ->with('success', 'Akun admin berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $page_title = "Edit Akun Admin";
    $page_description = "Isi form untuk mengubah data atau mereset password akun admin.";
    $user = User::findOrFail($id);
    $susunan_organisasi = SusunanOrganisasi::orderBy('nama_susunan_organisasi')->get();

    return view('admin.pages.super-admin.akun-admin.edit', compact('page_title', 'page_description', 'user', 'susunan_organisasi'));
  }

  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    if ($request->id_susunan_organisasi == 1 && $user->id_susunan_organisasi != 1) {
      $kepalaDinasSudahAda = User::where('id_susunan_organisasi', 1)->where('id', '!=', $user->id)->exists();
      if ($kepalaDinasSudahAda) {
        return back()->withErrors(['id_susunan_organisasi' => 'Akun Kepala Dinas sudah ada, tidak boleh lebih dari satu.'])->withInput();
      }
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
    ];

    // Password logic
    if ($request->has('reset_mode')) {
      if ($request->reset_mode === 'ingat') {
        $rules['old_password'] = ['required'];
        $rules['password'] = [
          'required',
          'string',
          Password::min(12)->letters()->numbers()->uncompromised(),
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
        ];
      } elseif ($request->reset_mode === 'lupa') {
        $rules['superadmin_name'] = ['required', 'string'];
        $rules['superadmin_password'] = ['required', 'string'];
        $rules['password'] = [
          'required',
          'string',
          Password::min(12)->letters()->numbers()->uncompromised(),
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
        ];
      }
    }

    $messages = [
      'name.unique' => 'Username sudah digunakan.',
      'name.regex' => 'Username hanya boleh berisi huruf, angka, titik, strip (-), dan underscore (_).',
      'name.not_regex' => 'Username tidak boleh mengandung spasi.',
      'password.min' => 'Password minimal 12 karakter.',
      'password.letters' => 'Password harus mengandung minimal satu huruf.',
      'password.numbers' => 'Password harus mengandung minimal satu angka.',
      'password.confirmed' => 'Konfirmasi password tidak sama.',
      'password.uncompromised' => 'Password ini tercatat pernah digunakan di situs lain yang mengalami insiden kebocoran data, silakan gunakan password lain.',
    ];

    $validated = $request->validate($rules, $messages);

    // Update data
    $user->fullname = $validated['fullname'];
    $user->name = $validated['name'];
    $user->id_susunan_organisasi = $validated['id_susunan_organisasi'];

    // Password update
    if ($request->has('reset_mode')) {
      if ($request->reset_mode === 'ingat') {
        // Cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
          return back()->withErrors(['old_password' => 'Password lama salah.'])->withInput();
        }
        $user->password = Hash::make($request->password);
      } elseif ($request->reset_mode === 'lupa') {
        // Cek superadmin yang sedang login
        $superadmin = Auth::user();
        if (
          !$superadmin ||
          !$superadmin->is_super_admin ||
          $superadmin->name !== $request->superadmin_name ||
          !Hash::check($request->superadmin_password, $superadmin->password)
        ) {
          return back()->withErrors(['superadmin_password' => 'Akun superadmin tidak valid.'])->withInput();
        }
        $user->password = Hash::make($request->password);
      }
    }

    $user->save();

    return redirect()->route('admin.super.akun-admin.index')->with('success', 'Akun admin berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);

    if ($user->is_super_admin) {
      return redirect()
        ->route('admin.super.akun-admin.index')
        ->withErrors(['error' => 'Akun super admin tidak dapat dihapus.']);
    }

    if ($user->id_susunan_organisasi == 1) {
      return redirect()
        ->route('admin.super.akun-admin.index')
        ->withErrors(['error' => 'Akun Kepala Dinas tidak dapat dihapus.']);
    }

    $user->delete();

    return redirect()
      ->route('admin.super.akun-admin.index')
      ->with('success', 'Akun admin berhasil dihapus.');
  }

}

