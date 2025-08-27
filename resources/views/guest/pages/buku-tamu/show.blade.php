@extends('guest.layouts.buku-tamu')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('document.body')
  <main>
    <hgroup class="flex flex-col items-center text-center py-5">
      <h1 class="text-3xl font-bold">Buku Tamu Digital</h1>
      <p class="text-lg font-medium">Dinas PUPR Kota Samarinda</p>
    </hgroup>

    <hr class="w-full border-gray-700">

    {{-- Progress bar --}}
    <section class="flex flex-col items-center p-4" id="status-section">
      <h2 class="text-2xl font-semibold">Status Kunjungan</h2>

      <ol class="relative my-4" id="progress-bar">
        {{-- Progress 1 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Pending' || $buku_tamu->status === 'Diterima' || $buku_tamu->status === 'Ditolak' ? 'bg-green-400' : 'bg-gray-400' }} rounded-full" id="progress-1-icon">
            <i class="fa-solid fa-check text-white"></i>
          </span>
          <p class="ms-10 font-medium leading-8" id="progress-1-label">Terajukan</p>
          <hr
            class="h-10 w-1 translate-x-[14px] {{ $buku_tamu->status === 'Pending' ? 'bg-yellow-300' : 'bg-green-400' }}" id="progress-1-bar">
        </li>

        {{-- Progress 2 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Pending' ? 'bg-yellow-300' : ($buku_tamu->status === 'Diterima' ? 'bg-green-400' : 'bg-green-400') }} rounded-full" id="progress-2-icon">
            <i
              class="{{ $buku_tamu->status === 'Pending' ? 'fa-solid fa-hourglass-half' : 'fa-solid fa-check' }} text-white" id="progress-2-fa"></i>
          </span>
          <p class="ms-10 font-medium leading-8" id="progress-2-label">{{ $buku_tamu->status === 'Pending' ? 'Pending' : 'Selesai' }}</p>
          <hr
            class="h-10 w-1 translate-x-[14px] {{ $buku_tamu->status === 'Pending' ? 'bg-gray-400' : ($buku_tamu->status === 'Diterima' ? 'bg-green-400' : 'bg-red-500') }}" id="progress-2-bar">
        </li>

        {{-- Progress 3 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Diterima' ? 'bg-green-400' : ($buku_tamu->status === 'Ditolak' ? 'bg-red-500' : 'bg-gray-400') }} rounded-full" id="progress-3-icon">
            <i
              class="{{ $buku_tamu->status === 'Diterima' ? 'fa-solid fa-check' : ($buku_tamu->status === 'Ditolak' ? 'fa-solid fa-xmark' : 'fa-solid fa-hourglass-half') }} text-white" id="progress-3-fa"></i>
          </span>
          <p class="ms-10 font-medium leading-8" id="progress-3-label">
            {{ $buku_tamu->status === 'Diterima' ? 'Diterima' : ($buku_tamu->status === 'Ditolak' ? 'Ditolak' : 'Pending') }}
          </p>
        </li>
      </ol>

      {{-- Pesan Berdasarkan Status --}}
      <p class="text-center" id="status-message">
        @if ($buku_tamu->status === 'Pending')
          Harap untuk <strong>memantau status kunjungan</strong> Anda secara berkala. Status akan diperbarui otomatis.
        @elseif ($buku_tamu->status === 'Diterima')
          Kunjungan Anda <strong>diterima</strong>. Silakan datang ke kantor untuk melanjutkan proses kunjungan.
        @else
          Kunjungan Anda <strong>ditolak</strong>. Kami mohon maaf atas ketidaknyamanan ini. Silakan ajukan kunjungan di lain waktu.
        @endif
      </p>
    </section>

    <hr class="w-full border-gray-700">

    {{-- Deskripsi Status --}}
    <section class="flex flex-col items-center p-4">
      <h2 class="text-2xl font-semibold mb-4 text-center">
        Deskripsi Status
      </h2>

      <p class="text-start" id="deskripsi-status">
        {{ $buku_tamu->deskripsi_status ?? "Permintaan kunjungan sedang diproses" }}
      </p>
    </section>

    <hr class="w-full border-gray-700">

    <section class="p-4 flex flex-col items-center">
      <h2 class="text-2xl font-semibold mb-4 text-center">Detail Tamu</h2>
      <table class="border-separate border-spacing-1.5">
        {{-- ID --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Nomor Urut</td>
          <td>{{ $buku_tamu->nomor_urut }}</td>
        </tr>
        {{-- Nama --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Nama Tamu</td>
          <td>{{ $buku_tamu->nama_pengunjung }}</td>
        </tr>
        {{-- Alamat --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Alamat Asal Tamu</td>
          <td>{{ $buku_tamu->alamat }}</td>
        </tr>
        {{-- Jabatan --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Bagian yang Dikunjungi</td>
          <td>{{ $buku_tamu->susunanOrganisasi->nama_susunan_organisasi }}</td>
        </tr>
        {{-- Maksud --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Keperluan Kunjungan</td>
          <td>{{ $buku_tamu->maksud_dan_tujuan }}</td>
        </tr>
      </table>
    </section>
  </main>

  <hr class="w-full border-gray-700">

  <footer class="flex flex-col items-center py-5 px-5">
    <p class="text-center text-sm">
      © 2024-2025 {{ config('app.nama_dinas') }}.
    </p>
  </footer>

  @if ($buku_tamu->status === 'Pending')
  <script>
    // Auto-refresh status setiap 5 detik
    const idBukuTamu = @json($buku_tamu->id_buku_tamu);
    let polling = true;

    function updateStatusUI(data) {
      // Progress 1
      document.getElementById('progress-1-icon').className = 'absolute flex items-center justify-center w-8 h-8 ' + ((data.status === 'Pending' || data.status === 'Diterima' || data.status === 'Ditolak') ? 'bg-green-400' : 'bg-gray-400') + ' rounded-full';
      // Progress 2
      document.getElementById('progress-2-icon').className = 'absolute flex items-center justify-center w-8 h-8 ' + (data.status === 'Pending' ? 'bg-yellow-300' : (data.status === 'Diterima' ? 'bg-green-400' : 'bg-green-400')) + ' rounded-full';
      document.getElementById('progress-2-fa').className = (data.status === 'Pending' ? 'fa-solid fa-hourglass-half' : 'fa-solid fa-check') + ' text-white';
      document.getElementById('progress-2-label').innerHTML = (data.status === 'Pending' ? 'Pending' : 'Selesai');
      document.getElementById('progress-2-bar').className = 'h-10 w-1 translate-x-[14px] ' + (data.status === 'Pending' ? 'bg-gray-400' : (data.status === 'Diterima' ? 'bg-green-400' : 'bg-red-500'));
      // Progress 3
      document.getElementById('progress-3-icon').className = 'absolute flex items-center justify-center w-8 h-8 ' + (data.status === 'Diterima' ? 'bg-green-400' : (data.status === 'Ditolak' ? 'bg-red-500' : 'bg-gray-400')) + ' rounded-full';
      document.getElementById('progress-3-fa').className = (data.status === 'Diterima' ? 'fa-solid fa-check' : (data.status === 'Ditolak' ? 'fa-solid fa-xmark' : 'fa-solid fa-hourglass-half')) + ' text-white';
      document.getElementById('progress-3-label').innerHTML = (data.status === 'Diterima' ? 'Diterima' : (data.status === 'Ditolak' ? 'Ditolak' : 'Pending'));

      // Status message
      let msg = '';
      if (data.status === 'Pending') {
        msg = 'Harap untuk <strong>memantau status kunjungan</strong> Anda secara berkala. Status akan diperbarui otomatis.';
      } else if (data.status === 'Diterima') {
        msg = 'Kunjungan Anda <strong>diterima</strong>. Silakan datang ke kantor untuk melanjutkan proses kunjungan.';
      } else {
        msg = 'Kunjungan Anda <strong>ditolak</strong>. Kami mohon maaf atas ketidaknyamanan ini. Silakan ajukan kunjungan di lain waktu.';
      }
      document.getElementById('status-message').innerHTML = msg;

      // Deskripsi status
      document.getElementById('deskripsi-status').innerHTML = data.deskripsi_status ?? "Permintaan kunjungan sedang diproses";
    }

    function pollStatus() {
      if (!polling) return;
      fetch("{{ route('guest.buku-tamu.show') }}?id=" + encodeURIComponent(idBukuTamu) + "&ajax=1")
        .then(res => res.json())
        .then(data => {
          if (data && data.status) {
            updateStatusUI(data);
            if (data.status !== 'Pending') {
              polling = false;
              document.getElementById('auto-refresh-info').innerHTML = 'Status sudah final.';
            } else {
              setTimeout(pollStatus, 5000);
            }
          }
        })
        .catch(() => setTimeout(pollStatus, 5000));
    }

    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(pollStatus, 5000);
    });
  </script>
  @endif
@endsection


