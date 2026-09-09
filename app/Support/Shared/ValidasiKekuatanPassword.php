<?php

namespace App\Support\Shared;

use App\Models\SusunanOrganisasi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * Aturan validasi password akun admin: minimal 12 karakter, mengandung
 * huruf & angka, tidak pernah bocor di insiden data (Password::uncompromised),
 * dan tidak boleh mengandung username/nama lengkap/nama susunan organisasi
 * pemilik akun maupun terdaftar di daftar password lemah lokal.
 *
 * Butuh $request berisi (opsional) 'name', 'fullname', dan
 * 'id_susunan_organisasi' milik akun yang passwordnya sedang divalidasi,
 * supaya larangan "tidak boleh mengandung identitas sendiri" bisa dicek.
 */
class ValidasiKekuatanPassword
{
  /** @return array<int, mixed> aturan siap-pakai untuk kunci 'password' pada $request->validate(). */
  public static function aturan(Request $request): array
  {
    return [
      'required',
      'string',
      Password::min(12)->letters()->numbers()->uncompromised(),
      'confirmed',
      self::larangan($request),
    ];
  }

  /** Closure yang menolak password mengandung identitas pemiliknya sendiri, atau tercatat lemah. */
  private static function larangan(Request $request): Closure
  {
    return function ($attribute, $value, $fail) use ($request) {
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
    };
  }

  /** Pesan error yang dipasangkan dengan rule 'name'/'password' di atas. */
  public static function pesan(): array
  {
    return [
      'name.unique' => 'Username sudah digunakan.',
      'name.regex' => 'Username hanya boleh berisi huruf, angka, titik, strip (-), dan underscore (_).',
      'name.not_regex' => 'Username tidak boleh mengandung spasi.',
      'password.min' => 'Password minimal 12 karakter.',
      'password.letters' => 'Password harus mengandung minimal satu huruf.',
      'password.numbers' => 'Password harus mengandung minimal satu angka.',
      'password.confirmed' => 'Konfirmasi password tidak sama.',
      'password.uncompromised' => 'Password ini tercatat pernah digunakan di situs lain yang mengalami insiden kebocoran data, silakan gunakan password lain.',
    ];
  }
}
