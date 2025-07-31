@extends('guest.layouts.main')

@section('document.start')
@endsection

@section('document.body')
  <section class="lg:p-5">
    <div
      class="bg-center bg-no-repeat bg-cover bg-gray-600 bg-blend-multiply lg:rounded-2xl flex items-center h-[calc(100vh-100px)] lg:h-[calc(100vh-188px)] justify-center"
      style="background-image: url('{{ asset('image/hero/drainase-irigasi.jpeg') }}')">
      <div class="px-4 mx-auto max-w-screen-xl text-center">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Laporkan
          Masalah Drainase & Irigasi <br> di Samarinda</h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Bantu kami menjaga sistem drainase
          dan irigasi agar tetap berfungsi. Laporkan kendala di lingkungan Anda melalui formulir ini.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
          <a href="#"
            class="inline-flex justify-center items-center py-3 px-5 text-base font-semibold text-center text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-black">
            Buat Pengaduan
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
          <a href="#"
            class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
            Cek Status Pengaduan
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-repeat bg-[#E5E0DC] bg-blend-color-dodge"
      style="background-image: url('{{ asset('image/element/kesemutan.svg') }}');">
    </div>

    <div class="relative py-8 lg:py-16 space-y-4 lg:space-y-8 z-10">
      <div class=" mx-auto max-w-screen-xl text-center space-y-4 lg:space-y-8 px-8 lg:px-0">
        <h2 class="mb-4 text-3xl font-semibold tracking-tight leading-none md:text-4xl lg:text-5xl">
          Tentang Aplikasi Pengaduan
        </h2>
        <p class="text-lg font-normal lg:text-xl sm:px-16 lg:px-48">
          Aplikasi ini adalah layanan digital dari <strong>UPTD Pemeliharaan Saluran Drainase dan Irigasi</strong>, Dinas
          PUPR Kota Samarinda. Masyarakat dapat melaporkan kerusakan atau gangguan drainase dan irigasi secara langsung
          untuk ditindaklanjuti oleh petugas kami.
        </p>
      </div>

      <div
        class="flex  flex-col lg:flex-row justify-center border-t border-black border-dashed font-semibold text-brand-blue text-lg lg:px-24 text-center lg:text-start">
        <div class="flex-1 py-5 lg:pt-5 lg:pb-0 space-y-1.5 px-8 lg:px-0">
          <i class="fa-solid fa-users text-6xl lg:w-[60px]"></i>
          <h3>Siapa yang Bisa Melapor?</h3>
          <p class="text-black text-base font-medium">
            Seluruh warga Kota Samarinda
          </p>
        </div>

        <div
          class="flex-1 py-5 lg:pt-5 lg:pb-0 space-y-1.5 border-y lg:border-x lg:border-y-0 border-black border-dashed lg:mx-10 px-8 lg:px-10">
          <i class="fa-solid fa-clock text-6xl lg:w-[60px]"></i>
          <h3>Jadwal Pekerjaan</h3>
          <ul class="lg:list-disc text-black text-base font-medium lg:pl-5">
            <li>Petugas lapangan libur setiap <br class="block lg:hidden"> hari Jumat</li>
            <li>Petugas kantor libur setiap <br class="block lg:hidden"> hari Sabtu & Minggu</li>
          </ul>
        </div>

        <div class="flex-1 pt-5 space-y-1.5 px-8 lg:px-0">
          <i class="fa-solid fa-list-check text-6xl lg:w-[60px]"></i>
          <h3>Proses Laporan</h3>
          <p class="text-black text-sm lg:text-base font-medium">
            Diurutkan berdasarkan tanggal laporan masuk dan tingkat prioritas
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-8 lg:py-16 px-8 lg:px-16">
    <div class="text-center space-y-1.5 pb-5 lg:pb-10">
      <h2 class="text-3xl lg:text-4xl font-bold">Statistik Pengaduan</h2>
      <p class="text-gray-600">Data terakhir diperbarui pada 31 Juli 2025</p>
    </div>

    <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 mb-5">
      {{-- Laporan masuk --}}
      <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="mb-1.5 sm:mb-0">
          <h3 class="text-xl lg:text-2xl font-semibold">Laporan Masuk</h3>
        </div>

        <div>
          <button id="dropdownLaporanMasuk" data-dropdown-toggle="dropdownLaporanMasukMenu"
            class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
            type="button">Januari-April 2025 <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownLaporanMasukMenu"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLaporanMasuk">
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Januari-April
                  2025</a>
              </li>
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mei-Agustus
                  2025</a>
              </li>
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">September-Desember
                  2025
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="w-full h-[250px] md:h-[350px]">
        <canvas id="statistikChart" class="w-full h-full"></canvas>
      </div>

    </div>

    <div class="lg:flex space-y-5 lg:gap-x-5 lg:space-y-0">
      {{-- Laporan diproses --}}
      <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 flex-1">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="mb-1.5 sm:mb-0">
            <h3 class="text-xl sm:text-2xl font-semibold">Laporan Diproses</h3>
          </div>

          <div>
            <button id="dropdownLaporanDiproses" data-dropdown-toggle="dropdownLaporanDiprosesMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">Januari 2025 <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>

            <div id="dropdownLaporanDiprosesMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLaporanDiproses">
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Januari
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Februari
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Maret 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">April 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mei 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juni 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juli 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Agustus
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">September
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Oktober
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">November
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Desember
                    2025</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div>
          <div class="lg:max-w-full lg:max-h-[250px]">
            <canvas id="laporanDiprosesChart" class="lg:max-w-full lg:h-auto"></canvas>
          </div>
        </div>
      </div>

      {{-- Jenis Laporan --}}
      <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 flex-1">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="mb-1.5 sm:mb-0">
            <h3 class="text-xl lg:text-2xl font-semibold">Jenis Laporan</h3>
          </div>

          <div>
            <button id="dropdownJenisLaporan" data-dropdown-toggle="dropdownJenisLaporanMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">Januari 2025 <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>

            <div id="dropdownJenisLaporanMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownJenisLaporan">
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Januari
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Februari
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Maret 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">April 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mei 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juni 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juli 2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Agustus
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">September
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Oktober
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">November
                    2025</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Desember
                    2025</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div>
          <div class="lg:max-w-full lg:max-h-[250px]">
            <canvas id="jenisLaporanChart" class="lg:max-w-full lg:h-auto"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('document.end')
  @vite('resources/js/chartjs.js')
  <script>
    function getLegendPosition() {
      return window.innerWidth < 768 ? 'bottom' : 'right';
    }

    let laporanDiprosesChart, jenisLaporanChart;

    window.onload = function() {
      const ctx = document.getElementById('statistikChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Januari', 'Februari', 'Maret', 'April'],
          datasets: [{
              label: 'Belum ditindaklanjuti',
              data: [12, 9, 7, 10],
              backgroundColor: '#E63846'
            },
            {
              label: 'Sedang diproses',
              data: [5, 7, 6, 8],
              backgroundColor: '#F9A11A'
            },
            {
              label: 'Selesai',
              data: [8, 12, 15, 13],
              backgroundColor: '#9EDE73'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: false
            }
          },
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
          }
        }
      });

      // Doughnut chart for Laporan Diproses
      const ctxDiproses = document.getElementById('laporanDiprosesChart').getContext('2d');
      laporanDiprosesChart = new Chart(ctxDiproses, {
        type: 'doughnut',
        data: {
          labels: [
            'Laporan diterima',
            'Menunggu survei',
            'Sudah disurvei',
            'Menunggu jadwal',
            'Sedang dikerjakan'
          ],
          datasets: [{
            data: [10, 7, 5, 4, 3],
            backgroundColor: [
              '#9EDE73',
              '#F9A11A',
              '#009CE4',
              '#E63846',
              '#E4C900'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });

      // Doughnut chart for Jenis Laporan
      const ctxJenis = document.getElementById('jenisLaporanChart').getContext('2d');
      jenisLaporanChart = new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
          labels: [
            'Penanganan Darurat',
            'Penanganan Biasa',
            'Pemeliharaan Rutin'
          ],
          datasets: [{
            data: [6, 14, 9],
            backgroundColor: [
              '#E63846',
              '#f59e42',
              '#3b82f6'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });
    };

    // Update legend position on resize
    window.addEventListener('resize', function() {
      const legendPos = getLegendPosition();
      if (laporanDiprosesChart) {
        laporanDiprosesChart.options.plugins.legend.position = legendPos;
        laporanDiprosesChart.update();
      }
      if (jenisLaporanChart) {
        jenisLaporanChart.options.plugins.legend.position = legendPos;
        jenisLaporanChart.update();
      }
    });
  </script>
@endsection
