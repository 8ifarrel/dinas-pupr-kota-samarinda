@extends('admin.layout')

@section('document.head')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('document.body')
  <div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6">
      <h2 class="text-2xl font-bold">Buat API Key Baru</h2>
      <p class="text-gray-600 mt-2">Buat API key baru untuk mengakses layanan API.</p>
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
        <a href="{{ route('admin.super.api-key.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
          <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
        </a>
      </div>
    </form>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
      <div class="text-center">
        <i class="fa-solid fa-check-circle text-green-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">API Key Berhasil Dibuat!</h3>
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
          <p class="text-red-600 text-sm mt-2">⚠️ Simpan API key ini dengan aman. Anda tidak akan melihatnya lagi setelah halaman ini.</p>
        </div>
        <div class="flex justify-center space-x-4">
          <button onclick="goToIndex()" 
                  class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            Lihat Semua API Keys
          </button>
          <button onclick="createAnother()" 
                  class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Buat API Key Lagi
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Error Modal -->
  <div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
      <div class="text-center">
        <i class="fa-solid fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">Terjadi Kesalahan</h3>
        <div id="errorMessage" class="text-gray-600 mb-6"></div>
        <button onclick="closeModal('errorModal')" 
                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
          Tutup
        </button>
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
          url: '/api/keys',
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
      window.location.href = '{{ route("admin.super.api-key.index") }}';
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
