@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('document.body')
  <div class="border shadow bg-white rounded-lg p-5 mb-8 space-y-3">
    <div class="flex gap-1.5 items-center">
      <i class="fa-solid fa-circle-question"></i>
      <h2 class="font-bold text-lg">Cara menggunakan API Key</h2>
    </div>
    <hr class="border-gray-300">
    <ol class="space-y-2 list-decimal list-inside">
      <li>Salin salah satu API Key di tabel di bawah.</li>
      <li>
        Di Postman (atau klien HTTP lain):
        <ul class="list-disc list-inside ml-5 space-y-1">
          <li>URL: <code class="bg-gray-100 px-2 py-0.5 rounded">POST {{ url('/api/silalad/pesanan') }}</code></li>
          <li>
            Header:
            <ul class="list-disc list-inside ml-6">
              <li><code>X-API-KEY</code>: tempelkan API Key Anda</li>
              <li><code>Accept</code>: <code>application/json</code></li>
            </ul>
          </li>
          <li>
            Body: pilih <code>form-data</code> atau <code>raw JSON</code>, lalu isi field berikut:
            <ul class="list-disc list-inside ml-6 space-y-0.5">
              <li><code>nama_pelanggan</code> — wajib, maksimal 150 karakter</li>
              <li><code>nomor_telepon_pelanggan</code> — wajib, diawali <code>08</code>, 10-15 digit</li>
              <li><code>alamat</code> — wajib, alamat pribadi pelanggan (bukan lokasi yang dilayani)</li>
              <li><code>kabkota_id</code> — wajib, nama kabupaten/kota lokasi layanan (mis.
                <code>Samarinda</code>)</li>
              <li><code>kecamatan_id</code>, <code>kelurahan_id</code> — wajib. Untuk
                <strong>Kota Samarinda</strong> isi dengan id numerik internal (lihat
                <code>GET {{ url('/api/kecamatans') }}</code>); untuk luar Samarinda isi dengan
                <strong>nama</strong> kecamatan/kelurahannya
              </li>
              <li><code>alamat_detail</code> — opsional, nama jalan &amp; patokan lokasi bangunan yang dilayani</li>
              <li><code>layanan</code> — opsional, jenis layanan (mis. <code>sedot tinja</code>)</li>
              <li><code>detail_laporan</code> — opsional, uraian keluhan</li>
              <li><code>jenis_bangunan</code> — wajib, maksimal 20 karakter. Bila diisi <code>Lainnya</code>, isian
                <code>jenis_bangunan_lainnya</code> yang akan dipakai
              </li>
              <li><code>rt</code>, <code>nomor_bangunan</code> — wajib, angka</li>
              <li><code>latitude</code>, <code>longitude</code> — opsional, titik lokasi bangunan</li>
              <li><code>setuju</code> — opsional, <code>true</code>/<code>false</code>, persetujuan biaya tambahan</li>
              <li><code>tanggal_diharapkan</code> — <strong>wajib</strong>, format <code>YYYY-MM-DD</code>, tidak boleh
                tanggal lampau. Ini tanggal pengerjaan yang <em>diminta pelanggan</em>, bukan jadwal yang mengikat;
                jadwal yang ditetapkan UPTD ada di <code>petugas.tanggal_pelaksanaan</code> pada respons.</li>
              <li><code>skm_nilai</code> — opsional, penilaian layanan 1-5</li>
              <li><code>skm_kritik</code>, <code>skm_saran</code> — opsional</li>
            </ul>
          </li>
        </ul>
      </li>
      <li>Kirim request. Respon sukses mengembalikan <code>id_pesanan</code>, <code>kode_booking</code>, status awal
        <em>Menunggu konfirmasi</em>, dan <code>detail_url</code> untuk memantau pesanan.
      </li>
      <li>Pantau satu pesanan lewat <code class="bg-gray-100 px-2 py-0.5 rounded">GET
          {{ url('/api/silalad/pesanan/{id}') }}</code> memakai header yang sama.</li>
      <li>Ambil seluruh pesanan milik satu nomor telepon lewat
        <code class="bg-gray-100 px-2 py-0.5 rounded">GET
          {{ url('/api/silalad/pesanan/status') }}?nomor_telepon_pelanggan=08xxxx</code>, opsional ditambah
        <code>&amp;status=Dijadwalkan</code> (nilai yang sah: {{ implode(', ', \App\Models\Silalad::STATUS) }}).
      </li>
    </ol>

    <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3 text-sm">
      <i class="fa-solid fa-circle-info me-1"></i>
      Untuk Kota Samarinda, pasangan kecamatan-kelurahan diverifikasi ke basis data: kelurahan yang bukan bagian dari
      kecamatan yang dikirim akan ditolak dengan status <code>422</code>. Penilaian
      <code>skm_nilai</code>/<code>skm_kritik</code>/<code>skm_saran</code> ikut terekap di halaman Survei Kepuasan
      SILALAD. Kunci API fitur lain (Jalan Peduli, Hantu Banyu, Akun Kelurahan) tidak berlaku di endpoint ini, begitu
      pula sebaliknya.
    </div>
  </div>

  <a href="{{ route('admin.super.api-key.silalad.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Buat API Key
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <style>
        /* Kolom Nama dan Aksi butuh ruang minimum sendiri supaya tidak
           kepenyet saat DataTables membagi lebar tabel; sisanya menyesuaikan
           konten masing-masing, dan tabel akan discroll ke samping bila perlu. */
        #api-key th:nth-child(2),
        #api-key td:nth-child(2) {
          min-width: 140px;
        }

        #api-key th:nth-child(7),
        #api-key td:nth-child(7) {
          min-width: 260px;
        }
      </style>
      <table id="api-key" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Key</th>
            <th>Status</th>
            <th>Dibuat Oleh</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data akan dimuat via AJAX -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Detail Modal -->
  <div id="detailModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-2xl">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail API Key</h3>
          <button type="button" onclick="closeModal('detailModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div id="detailContent" class="p-4 md:p-5 space-y-4">
          <!-- Content will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Toggle Status Modal -->
  <div id="toggleModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ubah Status API Key</h3>
          <button type="button" onclick="closeModal('toggleModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4 md:p-5 space-y-4">
          <p id="toggleModalText" class="text-base leading-relaxed text-gray-500 dark:text-gray-400"></p>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" id="toggleModalConfirmBtn" onclick="confirmToggle()"></button>
          <button type="button" onclick="closeModal('toggleModal')"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Regenerate Modal -->
  <div id="regenerateModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Regenerate API Key</h3>
          <button type="button" onclick="closeModal('regenerateModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4 md:p-5 space-y-4">
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            Apakah Anda yakin ingin meregenerasi API key ini? Key lama akan tidak bisa digunakan lagi.
          </p>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" onclick="confirmRegenerate()"
            class="text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">Ya,
            Regenerate</button>
          <button type="button" onclick="closeModal('regenerateModal')"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hapus API Key</h3>
          <button type="button" onclick="closeModal('deleteModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4 md:p-5 space-y-4">
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            Apakah Anda yakin ingin menghapus API key "<strong id="deleteApiKeyName"></strong>"?
          </p>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" onclick="confirmDelete()"
            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Ya,
            Hapus</button>
          <button type="button" onclick="closeModal('deleteModal')"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal for Regenerate -->
  <div id="successModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fa-solid fa-circle-check text-green-500 me-2"></i>API Key Berhasil Dibuat/Diregenerasi
          </h3>
          <button type="button" onclick="closeModal('successModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4 md:p-5 space-y-3">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">API Key Baru:</label>
          <div class="flex items-center gap-2">
            <input type="text" id="newApiKey" readonly
              class="flex-1 p-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm font-mono">
            <button type="button" onclick="copyApiKey()"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 focus:outline-none">
              <i class="fa-solid fa-copy"></i>
            </button>
          </div>
          <p class="text-sm text-red-600">⚠️ Simpan API key ini dengan aman. Anda tidak akan melihatnya lagi setelah
            modal ini ditutup.</p>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" onclick="closeModal('successModal')"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center focus:outline-none">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    // Global variables
    let apiKeysTable;
    let currentApiKeyId = null;

    document.addEventListener('DOMContentLoaded', function() {
      // Initialize DataTable with AJAX
      apiKeysTable = $('#api-key').DataTable({
        ajax: {
          url: '{{ route("api.silalad-keys.index") }}',
          type: 'GET',
          dataSrc: 'data',
          error: function(xhr, error, code) {
            console.error('Error loading data:', error);
            alert('Error loading API keys: ' + error);
          }
        },
        autoWidth: false,
        columns: [
          { data: 'id' },
          { data: 'name' },
          {
            data: 'masked_key',
            render: function(data, type, row) {
              return '<code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">' + data + '</code>';
            }
          },
          {
            data: 'is_active',
            render: function(data, type, row) {
              if (data) {
                return '<span class="bg-green-100 text-green-800 text-xs px-1.5 py-0.5 rounded border border-green-400">Aktif</span>';
              } else {
                return '<span class="bg-red-100 text-red-800 text-xs px-1.5 py-0.5 rounded border border-red-400">Nonaktif</span>';
              }
            }
          },
          {
            data: 'generator',
            render: function(data, type, row) {
              if (data && data.name) {
                return data.name;
              }
              return 'System';
            }
          },
          {
            data: 'created_at',
            render: function(data, type, row) {
              return new Date(data).toLocaleDateString('id-ID');
            }
          },
          {
            data: null,
            orderable: false,
            render: function(data, type, row) {
              const btn = 'inline-flex items-center justify-center gap-1 h-8 px-2.5 text-white rounded-lg text-xs font-medium whitespace-nowrap focus:ring-4 focus:outline-none';
              const statusButton = row.is_active
                ? `<button type="button" onclick="toggleApiKey(${row.id}, false)"
                     class="${btn} bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-300">
                     <i class="fa-solid fa-pause"></i> Nonaktifkan
                   </button>`
                : `<button type="button" onclick="toggleApiKey(${row.id}, true)"
                     class="${btn} bg-green-700 hover:bg-green-800 focus:ring-green-300">
                     <i class="fa-solid fa-play"></i> Aktifkan
                   </button>`;

              return `
                <div class="grid grid-cols-2 gap-2">
                  <button type="button" onclick="viewApiKey(${row.id})"
                    class="${btn} bg-blue-700 hover:bg-blue-800 focus:ring-blue-300">
                    <i class="fa-solid fa-eye"></i> Detail
                  </button>
                  <button type="button" onclick="regenerateApiKey(${row.id})"
                    class="${btn} bg-orange-700 hover:bg-orange-800 focus:ring-orange-300">
                    <i class="fa-solid fa-sync"></i> Regenerate
                  </button>
                  ${statusButton}
                  <button type="button" onclick="deleteApiKey(${row.id}, '${row.name}')"
                    class="${btn} bg-red-700 hover:bg-red-800 focus:ring-red-300">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </div>
              `;
            }
          }
        ],
        order: [[0, 'desc']],
        responsive: true,
        language: {
          emptyTable: "Tidak ada API key ditemukan",
          loadingRecords: "Memuat data API keys...",
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
          infoFiltered: "(difilter dari _MAX_ total data)",
          paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Selanjutnya",
            previous: "Sebelumnya"
          }
        }
      });
    });

    // View API Key details
    function viewApiKey(id) {
      $.ajax({
        url: `/api/silalad-keys/${id}`,
        type: 'GET',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            const data = response.data;
            const generatorName = data.generator ? data.generator.name : 'System';
            const generatorEmail = data.generator ? data.generator.email : '-';

            $('#detailContent').html(`
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">ID:</label>
                  <p class="text-sm text-gray-900">${data.id}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Nama:</label>
                  <p class="text-sm text-gray-900">${data.name}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">API Key:</label>
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">${data.masked_key}</code>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Status:</label>
                  <span class="bg-${data.is_active ? 'green' : 'red'}-100 text-${data.is_active ? 'green' : 'red'}-800 text-xs px-2 py-1 rounded">
                    ${data.is_active ? 'Aktif' : 'Nonaktif'}
                  </span>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Dibuat oleh:</label>
                  <p class="text-sm text-gray-900">${generatorName} (${generatorEmail})</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Dibuat pada:</label>
                  <p class="text-sm text-gray-900">${new Date(data.created_at).toLocaleString('id-ID')}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Terakhir diupdate:</label>
                  <p class="text-sm text-gray-900">${new Date(data.updated_at).toLocaleString('id-ID')}</p>
                </div>
              </div>
            `);

            showModal('detailModal');
          }
        },
        error: function(xhr, status, error) {
          alert('Error loading API key details: ' + error);
        }
      });
    }

    // Toggle API Key status
    let pendingToggle = {
      id: null,
      newStatus: null
    };

    function toggleApiKey(id, newStatus) {
      pendingToggle = {
        id,
        newStatus
      };

      const verb = newStatus ? 'mengaktifkan' : 'menonaktifkan';
      document.getElementById('toggleModalText').textContent =
        `Apakah Anda yakin ingin ${verb} API key ini?`;

      const confirmBtn = document.getElementById('toggleModalConfirmBtn');
      confirmBtn.textContent = newStatus ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan';
      confirmBtn.className = newStatus
        ? 'text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800'
        : 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800';

      showModal('toggleModal');
    }

    function confirmToggle() {
      const {
        id,
        newStatus
      } = pendingToggle;

      $.ajax({
        url: `/api/silalad-keys/${id}`,
        type: 'PUT',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          is_active: newStatus
        }),
        success: function(response) {
          closeModal('toggleModal');
          if (response.success) {
            const message = newStatus ? 'API key berhasil diaktifkan' : 'API key berhasil dinonaktifkan';
            alert(message);
            apiKeysTable.ajax.reload();
          } else {
            alert('Gagal mengubah status API key: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          closeModal('toggleModal');
          let errorMessage = 'Error updating API key status';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          alert(errorMessage + ': ' + error);
        }
      });
    }

    // Regenerate API Key
    function regenerateApiKey(id) {
      currentApiKeyId = id;
      showModal('regenerateModal');
    }

    function confirmRegenerate() {
      $.ajax({
        url: `/api/silalad-keys/${currentApiKeyId}/regenerate`,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            closeModal('regenerateModal');

            // Show new API key in success modal
            $('#newApiKey').val(response.data.key);
            showModal('successModal');

            // Reload table
            apiKeysTable.ajax.reload();
          }
        },
        error: function(xhr, status, error) {
          alert('Error regenerating API key: ' + error);
        }
      });
    }

    // Delete API Key
    function deleteApiKey(id, name) {
      currentApiKeyId = id;
      $('#deleteApiKeyName').text(name);
      showModal('deleteModal');
    }

    function confirmDelete() {
      $.ajax({
        url: `/api/silalad-keys/${currentApiKeyId}`,
        type: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            alert('API key berhasil dihapus');
            closeModal('deleteModal');
            apiKeysTable.ajax.reload();
          }
        },
        error: function(xhr, status, error) {
          alert('Error deleting API key: ' + error);
        }
      });
    }

    // Copy API Key to clipboard
    function copyApiKey() {
      const apiKeyInput = document.getElementById('newApiKey');
      apiKeyInput.select();
      apiKeyInput.setSelectionRange(0, 99999);

      try {
        document.execCommand('copy');
        alert('API key berhasil disalin ke clipboard!');
      } catch (err) {
        console.error('Failed to copy: ', err);
        alert('Gagal menyalin API key. Silakan salin manual.');
      }
    }

    // Modal functions
    function showModal(modalId) {
      document.getElementById(modalId).classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).classList.add('hidden');
      document.body.style.overflow = 'auto';

      // Clear current API key ID
      currentApiKeyId = null;

      // Clear success modal content
      if (modalId === 'successModal') {
        $('#newApiKey').val('');
      }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modals = ['detailModal', 'regenerateModal', 'deleteModal', 'successModal'];
      modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
          closeModal(modalId);
        }
      });
    }
  </script>
@endsection
