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
          <li>URL: <code class="bg-gray-100 px-2 py-0.5 rounded">POST {{ url('/api/laporan/upload') }}</code></li>
          <li>
            Header:
            <ul class="list-disc list-inside ml-6">
              <li><code>X-API-KEY</code>: tempelkan API Key Anda</li>
              <li><code>Accept</code>: <code>application/json</code></li>
            </ul>
          </li>
          <li>Body: pilih <code>form-data</code>, lalu isi field seperti <code>nama_pelapor</code>,
            <code>nomor_telepon</code>, <code>foto_kerusakan</code>, dll.
          </li>
        </ul>
      </li>
      <li>Kirim request. Respon sukses akan mengembalikan <code>id_laporan</code> dan status <em>Menunggu
          Verifikasi</em>.</li>
    </ol>
  </div>

  <a href="{{ route('admin.super.api-key.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Buat API Key
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
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
  <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Detail API Key</h3>
        <button onclick="closeModal('detailModal')" class="text-gray-400 hover:text-gray-600">
          <i class="fa-solid fa-times"></i>
        </button>
      </div>
      <div id="detailContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

  <!-- Regenerate Modal -->
  <div id="regenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-md bg-white">
      <div class="text-center">
        <i class="fa-solid fa-exclamation-triangle text-orange-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">Regenerate API Key</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin meregenerasi API key ini? Key lama akan tidak bisa digunakan lagi.</p>
        <div class="flex justify-center space-x-4">
          <button onclick="closeModal('regenerateModal')" 
                  class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Batal
          </button>
          <button onclick="confirmRegenerate()" 
                  class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
            Ya, Regenerate
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-md bg-white">
      <div class="text-center">
        <i class="fa-solid fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">Hapus API Key</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus API key "<span id="deleteApiKeyName"></span>"?</p>
        <div class="flex justify-center space-x-4">
          <button onclick="closeModal('deleteModal')" 
                  class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Batal
          </button>
          <button onclick="confirmDelete()" 
                  class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Ya, Hapus
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal for Regenerate -->
  <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
      <div class="text-center">
        <i class="fa-solid fa-check-circle text-green-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">API Key Berhasil Dibuat/Diregenerasi!</h3>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">API Key Baru:</label>
          <div class="flex items-center space-x-2">
            <input type="text" id="newApiKey" readonly 
                   class="flex-1 p-2 border border-gray-300 rounded bg-gray-50 text-sm font-mono">
            <button onclick="copyApiKey()" 
                    class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              <i class="fa-solid fa-copy"></i>
            </button>
          </div>
          <p class="text-red-600 text-sm mt-2">⚠️ Simpan API key ini dengan aman. Anda tidak akan melihatnya lagi setelah modal ini ditutup.</p>
        </div>
        <button onclick="closeModal('successModal')" 
                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
          Tutup
        </button>
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
          url: '{{ route("api.keys.index") }}',
          type: 'GET',
          dataSrc: 'data',
          error: function(xhr, error, code) {
            console.error('Error loading data:', error);
            alert('Error loading API keys: ' + error);
          }
        },
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
              const statusButton = row.is_active 
                ? `<button type="button" onclick="toggleApiKey(${row.id}, false)" 
                     class="text-white bg-yellow-600 hover:bg-yellow-700 font-medium rounded-lg text-xs px-2 py-1">
                     <i class="fa-solid fa-pause"></i> Nonaktifkan
                   </button>`
                : `<button type="button" onclick="toggleApiKey(${row.id}, true)" 
                     class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-xs px-2 py-1">
                     <i class="fa-solid fa-play"></i> Aktifkan
                   </button>`;

              return `
                <div class="flex items-center space-x-2">
                  <button type="button" onclick="viewApiKey(${row.id})" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-2 py-1">
                    <i class="fa-solid fa-eye"></i> Detail
                  </button>
                  ${statusButton}
                  <button type="button" onclick="regenerateApiKey(${row.id})" 
                    class="text-white bg-orange-700 hover:bg-orange-800 font-medium rounded-lg text-xs px-2 py-1">
                    <i class="fa-solid fa-sync"></i> Regenerate
                  </button>
                  <button type="button" onclick="deleteApiKey(${row.id}, '${row.name}')" 
                    class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-xs px-2 py-1">
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
        url: `/api/keys/${id}`,
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
    function toggleApiKey(id, newStatus) {
      // Show confirmation message
      const statusText = newStatus ? 'mengaktifkan' : 'menonaktifkan';
      if (!confirm(`Apakah Anda yakin ingin ${statusText} API key ini?`)) {
        return;
      }

      $.ajax({
        url: `/api/keys/${id}`,
        type: 'PUT',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'Content-Type': 'application/json'
        },
        data: JSON.stringify({
          is_active: newStatus
        }),
        success: function(response) {
          if (response.success) {
            const message = newStatus ? 'API key berhasil diaktifkan' : 'API key berhasil dinonaktifkan';
            alert(message);
            apiKeysTable.ajax.reload();
          } else {
            alert('Gagal mengubah status API key: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
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
        url: `/api/keys/${currentApiKeyId}/regenerate`,
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
        url: `/api/keys/${currentApiKeyId}`,
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
