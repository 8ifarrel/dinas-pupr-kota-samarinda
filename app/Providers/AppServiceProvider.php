<?php

namespace App\Providers;

use App\Observers\LogAktivitasObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Carbon::setLocale('id');
    setlocale(LC_TIME, 'id_ID.UTF-8');

    $this->pasangPencatatLogAktivitas();
  }

  /**
   * Pasang pencatat jejak audit ke seluruh model.
   *
   * Daftar model dipindai dari folder app/Models, bukan ditulis manual, supaya
   * model baru yang dibuat kelak otomatis ikut tercatat tanpa perlu diingat
   * mendaftarkannya - celah audit paling umum justru lahir dari daftar manual
   * yang lupa diperbarui.
   */
  private function pasangPencatatLogAktivitas(): void
  {
    foreach (glob(app_path('Models') . '/*.php') as $berkas) {
      $kelas = 'App\\Models\\' . basename($berkas, '.php');

      if (!class_exists($kelas)) {
        continue;
      }

      if (in_array($kelas, LogAktivitasObserver::DIKECUALIKAN, true)) {
        continue;
      }

      $refleksi = new ReflectionClass($kelas);

      // Kelas abstrak (mis. BaseApiKey) tidak bisa dan tidak perlu diamati;
      // yang dicatat adalah turunannya yang benar-benar menyentuh basis data.
      if ($refleksi->isAbstract() || !$refleksi->isSubclassOf(Model::class)) {
        continue;
      }

      $kelas::observe(LogAktivitasObserver::class);
    }
  }
}
