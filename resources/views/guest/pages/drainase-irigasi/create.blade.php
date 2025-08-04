@extends('guest.layouts.main')

@section('document.start')
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <div class="max-w-4xl mx-auto border shadow-lg p-4 sm:p-8 rounded-xl space-y-8">
      {{-- Header --}}
      <div class="text-center space-y-2.5">
        <h1 class="text-2xl md:text-3xl font-bold">
          Form Pengaduan Drainase dan Irigasi
        </h1>
        <p class="text-gray-700 text-base md:text-lg">
          Silakan isi formulir di bawah ini untuk melaporkan masalah drainase dan irigasi di Kota Samarinda.
        </p>
      </div>

      {{-- Stepper --}}
      <div class="mb-8">
        <div class="relative flex items-center justify-between" style="height:56px;">
          <!-- Garis stepper kiri -->
          <div id="stepper-line-left"
            class="absolute left-[calc(50%/3)] right-2/3 top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors"></div>
          <!-- Garis stepper kanan -->
          <div id="stepper-line-right"
            class="absolute left-1/3 right-[calc(50%/3)] top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors"></div>
          <ol id="stepper-bar" class="flex w-full z-10 relative">
            <li class="flex-1 flex flex-col items-center stepper-step stepper-step-active relative">
              <span class="flex items-center justify-center w-10 h-10 bg-brand-blue text-white rounded-full z-10">
                <i class="fa-solid fa-address-card"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-clipboard-list"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-paper-plane"></i>
              </span>
            </li>
          </ol>
        </div>
        <div class="flex w-full mt-2">
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-brand-blue text-xs sm:text-sm text-center">Data Diri</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Detail Laporan</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Konfirmasi</span>
          </div>
        </div>
      </div>

      <form id="stepper-form">
        {{-- Langkah 1: Data Diri Pelapor --}}
        <div class="stepper-content" data-step="0">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 1: <span class="font-semibold">Data Diri
                  Pelapor</span>
              </h2>
              <hr>
            </div>

            <div class="space-y-4">
              <div class="space-y-1.5">
                <label for="pelapor__nama_lengkap" class="block text-sm font-medium text-gray-900 required">Nama
                  Lengkap</label>
                <input type="text" id="pelapor__nama_lengkap"
                  class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Muhammad Farrel Sirah" required>
                <p id="pelapor__nama_lengkap-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan nama
                  lengkap Anda</p>
              </div>

              <div class="space-y-1.5">
                <label for="pelapor__pekerjaan" class="block text-sm font-medium text-gray-900 required">Pekerjaan</label>
                <input type="text" id="pelapor__pekerjaan"
                  class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Pelajar/Mahasiswa" required>
                <p id="pelapor__pekerjaan-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan pekerjaan
                  Anda</p>
              </div>

              <div class="space-y-1.5">
                <label for="pelapor__alamat" class="block text-sm font-medium text-gray-900 required">Alamat
                  Tempat Tinggal</label>
                <input type="text" id="pelapor__alamat"
                  class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Jalan Haji Achmad Amins, no. 123, RT 18, Kelurahan Gunung Lingai, Kecamatan Sungai Pinang"
                  required>
                <p id="pelapor__alamat-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan alamat
                  tempat
                  tinggal Anda</p>
              </div>

              <div class="space-y-1.5">
                <label for="pelapor__nomor_telepon" class="block text-sm font-medium text-gray-900 required">Nomor
                  Telepon</label>
                <input type="text" id="pelapor__nomor_telepon"
                  class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: 08123456789" required>
                <p id="pelapor__nomor_telepon-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan nomor
                  telepon Anda yang dapat dihubungi</p>
              </div>
            </div>
            <div class="flex justify-end">
              <button type="button"
                class="stepper-next flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none">
                <i class="fa-solid fa-circle-right"></i> Selanjutnya
              </button>
            </div>
          </div>
        </div>

        {{-- Langkah 2: Detail Laporan --}}
        <div class="stepper-content hidden" data-step="1">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 2: <span class="font-semibold">Detail
                  Laporan</span>
              </h2>
              <hr>
            </div>

            <div class="space-y-4">
              <div class="flex flex-col gap-1.5">
                <p>
                  Anda dapat memilih lokasi kerusakan <b>menggunakan posisi Anda saat ini (GPS)</b> maupun <b>memilih dari
                    peta</b>
                </p>
                <div class="flex flex-col sm:flex-row gap-2">
                  <button type="button" id="detect-location-gps-btn"
                    class="flex-1 items-center px-3 py-2 rounded-lg border border-primary-500 text-white bg-brand-blue hover:opacity-90 transition text-sm font-medium"
                    title="Gunakan lokasi sekarang">
                    <i class="fa-solid fa-location-crosshairs mr-1.5"></i>
                    Gunakan lokasi sekarang
                  </button>
                  <button type="button" id="select-location-map-btn"
                    class="flex-1 items-center px-3 py-2 rounded-lg border border-primary-500 text-white bg-brand-blue hover:opacity-90 transition text-sm font-medium"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="modal-pilih-lokasi-peta"
                    data-hs-overlay="#modal-pilih-lokasi-peta" title="Pilih lokasi dari peta">
                    <i class="fa-solid fa-map-location-dot mr-1.5"></i>
                    Pilih lokasi dari peta
                  </button>
                </div>
                <p>
                  atau <b>mengisi lokasi secara manual</b> di bawah ini.
                </p>
              </div>

              <div class="space-y-1.5">
                <label for="laporan__nama_jalan" class="block text-sm font-medium text-gray-900 required">
                  Nama Jalan
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                  </div>
                  <input type="search" id="laporan__nama_jalan"
                    class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Contoh: Pangeran Antasari" required />
                  <button type="submit"
                    class="hidden text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Search
                  </button>
                </div>
                <p id="laporan__nama_jalan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                  Ketik nama jalan lokasi kerusakan.
                </p>
              </div>

              <div class="flex flex-col md:flex-row gap-4">
                <div class="space-y-1 flex-1">
                  <label for="laporan__kecamatan" class="block text-sm font-medium text-gray-900 required">
                    Kecamatan
                  </label>
                  <select id="laporan__kecamatan"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                    <option selected disabled>Pilih kecamatan</option>
                    <option value="Samarinda Ulu">Samarinda Ulu</option>
                    <option value="Samarinda Ilir">Samarinda Ilir</option>
                    <option value="Samarinda Kota">Samarinda Kota</option>
                    <option value="Sungai Kunjang">Sungai Kunjang</option>
                  </select>
                  <p id="laporan__kecamatan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                    Pilih kecamatan lokasi kerusakan.
                  </p>
                </div>

                <div class="space-y-1 flex-1">
                  <label for="laporan__kelurahan" class="block text-sm font-medium text-gray-900 required">
                    Kelurahan
                  </label>
                  <select id="laporan__kelurahan"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                    <option selected disabled>Pilih kelurahan</option>
                    <option value="Air Putih">Air Putih</option>
                    <option value="Sempaja">Sempaja</option>
                    <option value="Gunung Kelua">Gunung Kelua</option>
                    <option value="Sidodadi">Sidodadi</option>
                  </select>
                  <p id="laporan__kelurahan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                    Pilih kelurahan lokasi kerusakan.
                  </p>
                </div>
              </div>

              <div class="flex flex-col md:flex-row gap-4">
                <div class="space-y-1 flex-1">
                  <label for="laporan__longitude"
                    class="block text-sm font-medium text-gray-900 required">Longitude</label>
                  <input type="text" id="laporan__longitude"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Contoh: 112.123456" required>
                  <p id="laporan__longitude-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan
                    longitude
                    lokasi kerusakan</p>
                </div>

                <div class="space-y-1 flex-1">
                  <label for="laporan__latitude"
                    class="block text-sm font-medium text-gray-900 required">Latitude</label>
                  <input type="text" id="laporan__latitude"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Contoh: 112.123456" required>
                  <p id="laporan__latitude-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan
                    latitude
                    lokasi kerusakan</p>
                </div>
              </div>

              <div id="laporan__foto_group">
                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="laporan__foto_input[]">
                  Foto Kerusakan
                </label>

                <div id="laporan__foto_input_list" class="flex flex-row gap-2 overflow-x-auto">
                  <div
                    class="relative group laporan__foto_item_wrapper h-28 sm:h-32 mb-2 min-w-[calc(7rem*16/9)] max-w-[calc(8rem*16/9)] flex-shrink-0 aspect-[16/9]">
                    <label
                      class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0 aspect-[16/9]">
                      <div class="laporan__foto_placeholder flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                        </svg>
                        <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (maks 2MB)</p>
                      </div>
                      <img
                        class="laporan__foto_preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
                      <input name="laporan__foto_input[]" type="file" accept="image/*"
                        class="hidden laporan__foto_file_input" />
                    </label>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove_laporan__foto_btn hidden"
                      title="Hapus foto">
                      <i class="fa-solid fa-xmark"></i>
                    </button>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert_laporan__foto_btn hidden"
                      title="Kembalikan foto sebelumnya">
                      <i class="fa-solid fa-rotate-right"></i>
                    </button>

                    <a type="button"
                      class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit_laporan__foto_btn hidden"
                      title="Edit foto">
                      <i class="fa-solid fa-crop-simple"></i>
                    </a>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add_laporan__foto_btn"
                      title="Tambah foto">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>

                <p id="laporan__foto_explanation" class="text-sm text-gray-500 dark:text-gray-400">
                  Masukkan foto kerusakan. Anda dapat mengunggah lebih dari satu foto dengan menekan tombol "+".
                </p>
              </div>

              <div class="space-y-1.5">
                <label for="laporan__detail_lokasi" class="block text-sm font-medium text-gray-900 required">
                  Detail Lokasi
                </label>
                <textarea id="laporan__detail_lokasi"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Dekat toko roti Amansa, gang 4, no. 123" rows="2" required></textarea>
                <p id="laporan__detail_lokasi-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                  Masukkan detail lengkap lokasi, sertakan juga patokan bangunan terdekat untuk memudahkan
                  pencarian.
                </p>
              </div>

              <div class="space-y-1.5">
                <label for="laporan__deskripsi" class="block text-sm font-medium text-gray-900 required">Deskripsi
                  Kerusakan</label>
                <textarea id="laporan__deskripsi"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Parit tersumbat sampah, air tidak mengalir dengan baik" rows="3" required></textarea>
                <p id="laporan__deskripsi-explanation" class="text-sm text-gray-500 dark:text-gray-400">Jelaskan kondisi
                  kerusakan.</p>
              </div>
            </div>
            <div class="flex justify-between">
              <button type="button"
                class="stepper-prev flex justify-center items-center gap-1 text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none">
                <i class="fa-solid fa-circle-left"></i> Sebelumnya
              </button>
              <button type="button"
                class="stepper-next flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none">
                <i class="fa-solid fa-circle-right"></i> Selanjutnya
              </button>
            </div>
          </div>
        </div>

        {{-- Langkah 3: Konfirmasi --}}
        <div class="stepper-content hidden" data-step="2">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 3: <span
                  class="font-semibold">Konfirmasi</span>
              </h2>
              <hr>
            </div>

            <div class="space-y-1.5">
              <p class="block text-sm font-medium text-gray-900 required">Silakan centang kotak di bawah ini</p>
              <div class="flex items-center ps-4 border border-gray-200 rounded-lg">
                <input id="bordered-checkbox-2" type="checkbox" value="" name="bordered-checkbox"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label for="bordered-checkbox-2" class="w-full py-4 ms-2 text-gray-900 text-sm">Saya menyatakan bahwa
                  informasi yang saya berikan benar dan dapat dipertanggungjawabkan.</label>
              </div>
            </div>
            <div class="flex justify-between">
              <button type="button"
                class="stepper-prev flex justify-center items-center gap-1 text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none">
                <i class="fa-solid fa-circle-left"></i> Sebelumnya
              </button>
              <button type="submit"
                class="stepper-submit flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none disabled:opacity-80">
                <i class="fa-solid fa-paper-plane fa-sm"></i> Kirim
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // ...existing code for select provinsi/kabupaten/kecamatan/desa...

      // Stepper logic
      const stepperContents = Array.from(document.querySelectorAll('.stepper-content'));
      const stepperBar = document.querySelectorAll('#stepper-bar .stepper-step');
      const stepperLineLeft = document.getElementById('stepper-line-left');
      const stepperLineRight = document.getElementById('stepper-line-right');
      let currentStep = 0;

      function showStepperStep(idx) {
        stepperContents.forEach((el, i) => {
          el.classList.toggle('hidden', i !== idx);
        });
        stepperBar.forEach((el, i) => {
          const iconSpan = el.querySelector('span');
          if (iconSpan) {
            if (i <= idx) {
              iconSpan.classList.add('bg-brand-blue', 'text-white');
              iconSpan.classList.remove('bg-gray-100', 'text-gray-500');
            } else {
              iconSpan.classList.remove('bg-brand-blue', 'text-white');
              iconSpan.classList.add('bg-gray-100', 'text-gray-500');
            }
          }
          // Update label color below stepper
          const labelBar = document.querySelectorAll('.mb-8 > .flex.w-full.mt-2 > div > span');
          if (labelBar[i]) {
            if (i <= idx) {
              labelBar[i].classList.add('text-brand-blue');
              labelBar[i].classList.remove('text-gray-500');
            } else {
              labelBar[i].classList.remove('text-brand-blue');
              labelBar[i].classList.add('text-gray-500');
            }
          }
        });
        // Garis stepper logic
        if (stepperLineLeft && stepperLineRight) {
          if (idx === 0) {
            stepperLineLeft.classList.remove('bg-brand-blue');
            stepperLineLeft.classList.add('bg-gray-200');
            stepperLineRight.classList.remove('bg-brand-blue');
            stepperLineRight.classList.add('bg-gray-200');
          } else if (idx === 1) {
            stepperLineLeft.classList.remove('bg-gray-200');
            stepperLineLeft.classList.add('bg-brand-blue');
            stepperLineRight.classList.remove('bg-brand-blue');
            stepperLineRight.classList.add('bg-gray-200');
          } else if (idx === 2) {
            stepperLineLeft.classList.remove('bg-gray-200');
            stepperLineLeft.classList.add('bg-brand-blue');
            stepperLineRight.classList.remove('bg-gray-200');
            stepperLineRight.classList.add('bg-brand-blue');
          }
        }
      }

      document.querySelectorAll('.stepper-next').forEach(btn => {
        btn.addEventListener('click', function() {
          if (currentStep < stepperContents.length - 1) {
            currentStep++;
            showStepperStep(currentStep);
          }
        });
      });

      document.querySelectorAll('.stepper-prev').forEach(btn => {
        btn.addEventListener('click', function() {
          if (currentStep > 0) {
            currentStep--;
            showStepperStep(currentStep);
          }
        });
      });

      showStepperStep(currentStep);

      // ...existing code for dynamic select...
    });
  </script>
@endsection
