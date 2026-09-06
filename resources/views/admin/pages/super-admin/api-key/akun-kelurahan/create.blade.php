@extends('admin.layout')

@section('document.head')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('document.body')
  <div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6">
      <h2 class="text-2xl font-bold">Buat API Key Akun Kelurahan</h2>
      <p class="text-gray-600 mt-2">Buat API key baru untuk mengakses API akun kelurahan.</p>
    </div>

    <form id="createApiKeyForm">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nama API</label>
        <input type="text" name="name" id="name"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          required
          placeholder="Masukkan nama untuk API key ini" />
        <div class="text-gray-500 text-xs mt-1">Masukkan nama deskriptif untuk memudahkan identifikasi API key ini.</div>
      </div>

      <div class="mb-6">
        <label for="generated_by_user_id" class="block text-sm font-medium text-gray-700">Dibuat untuk User ID (Optional)</label>
        <input type="number" name="generated_by_user_id" id="generated_by_user_id"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          placeholder="Kosongkan jika untuk sistem" />
        <div class="text-gray-500 text-xs mt-1">ID user yang akan memiliki API key ini. Kosongkan untuk sistem default.</div>
      </div>

      <div class="flex space-x-4">
        <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
          <i class="fa-solid fa-plus mr-2"></i>Buat API Key
        </button>
        <a href="{{ route('admin.super.api-key.akun-kelurahan.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
          <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
        </a>
      </div>
    </form>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fa-solid fa-circle-check text-green-500 me-2"></i>API Key Berhasil Dibuat
          </h3>
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
            halaman ini.</p>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" onclick="goToIndex()"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center focus:outline-none">Lihat
            Semua API Keys</button>
          <button type="button" onclick="createAnother()"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Buat
            API Key Lagi</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Error Modal -->
  <div id="errorModal" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full h-full bg-gray-900/50 dark:bg-gray-900/80">
    <div class="relative top-20 mx-auto w-11/12 md:w-1/2 max-w-lg">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fa-solid fa-triangle-exclamation text-red-500 me-2"></i>Terjadi Kesalahan
          </h3>
          <button type="button" onclick="closeModal('errorModal')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div id="errorMessage" class="p-4 md:p-5 text-gray-500 dark:text-gray-400"></div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" onclick="closeModal('errorModal')"
            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center focus:outline-none">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('createApiKeyForm');

      form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = {
          name: formData.get('name'),
          generated_by_user_id: formData.get('generated_by_user_id') || null
        };

        // Disable form during submission
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Membuat API Key...';

        $.ajax({
          url: '/api/akun-kelurahan-keys',
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
          },
          data: JSON.stringify(data),
          success: function(response) {
            if (response.success) {
              // Show success modal with new API key
              $('#newApiKey').val(response.data.key);
              showModal('successModal');

              // Clear form
              form.reset();
            } else {
              showError('Gagal membuat API key: ' + response.message);
            }
          },
          error: function(xhr, status, error) {
            let errorMessage = 'Terjadi kesalahan saat membuat API key.';

            if (xhr.responseJSON && xhr.responseJSON.message) {
              errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
              const errors = xhr.responseJSON.errors;
              errorMessage = Object.values(errors).flat().join(', ');
            }

            showError(errorMessage);
          },
          complete: function() {
            // Re-enable form
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        });
      });
    });

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

    // Navigation functions
    function goToIndex() {
      window.location.href = '{{ route("admin.super.api-key.akun-kelurahan.index") }}';
    }

    function createAnother() {
      closeModal('successModal');
      $('#newApiKey').val('');
    }

    // Modal functions
    function showModal(modalId) {
      document.getElementById(modalId).classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    function showError(message) {
      $('#errorMessage').text(message);
      showModal('errorModal');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modals = ['successModal', 'errorModal'];
      modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
          closeModal(modalId);
        }
      });
    }
  </script>
@endsection
