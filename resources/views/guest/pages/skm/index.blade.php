@extends('guest.layouts.skm')

@section('slot')
  @if (session('success'))
    <script>
      Swal.fire({
        html: `
        <div class="flex flex-col items-center">
          <!-- ICON ATAS -->
          <dotlottie-player
            src="https://lottie.host/1e9820b7-84fe-45d5-ad40-14004aa784a9/N2PtNg9vHv.lottie"
            background="transparent"
            speed="1"
            class="w-[100px] h-[100px] tv-vertical:w-[250px] tv-vertical:h-[250px]"
            loop autoplay>
          </dotlottie-player>

          <!-- TITLE -->
          <h2 class="text-blue font-bold text-xl sm:text-2xl tv-vertical:text-5xl tv-vertical:mt-2 mb-4 text-center">
            Berhasil!
          </h2>

          <!-- TEXT SESSION -->
          <p class="tv-vertical:mt-4 text-gray-700 text-base sm:text-lg tv-vertical:text-3xl font-medium text-center">
            {{ session('success') }}
          </p>
        </div>
      `,
        icon: null,
        showConfirmButton: true,
        confirmButtonText: 'Oke',
        customClass: {
          popup: 'tv-vertical:w-full tv-vertical:max-w-2xl tv-vertical:pb-10 rounded-2xl',
          confirmButton: 'rounded-full bg-blue text-yellow px-4 py-2 text-lg font-bold transition-all duration-200 hover:bg-yellow hover:text-blue active:scale-95 focus:outline-none focus:ring-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed tv-vertical:text-2xl tv-vertical:px-10 tv-vertical:py-4'
        },
        buttonsStyling: false
      });
    </script>
  @endif


  <div
    class="bg-gray-50 py-4 tv-vertical:py-16 tv-vertical:flex tv-vertical:items-center tv-vertical:h-[calc(100vh-639.516px)]">
    <div class="mx-auto mt-5 px-4 tv-vertical:w-[700px] tv-vertical:mt-0 tv-vertical:px-0">
      <div class="text-center">
        <span
          class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300 tv-vertical:text-2xl tv-vertical:px-8 tv-vertical:py-2">
          Penilaian
        </span>
        <h1 class="mt-3 mb-5 text-3xl font-bold tv-vertical:text-5xl tv-vertical:mt-8 tv-vertical:mb-10">
          {{ $page_title }}
        </h1>
      </div>

      <div class="mb-5 flex justify-center flex-col items-center gap-y-1 tv-vertical:mb-10 tv-vertical:gap-y-4">
        <p
          class="rounded-xl bg-yellow px-3 py-1.5 sm:px-4 sm:py-2 text-sm xs:text-base sm:text-lg font-semibold text-blue shadow w-fit text-center tv-vertical:text-3xl tv-vertical:px-8 tv-vertical:py-4">
          Indeks Kepuasan Masyarakat:
          <span class="font-extrabold">{{ number_format($rata_rata, 3, ',', '.') }}/4</span>
        </p>

        <p class="font-medium tv-vertical:text-2xl">
          dengan total <span class="font-bold">{{ number_format($total_responden) }}</span> responden
        </p>
      </div>

      <form action="{{ route('guest.skm.store') }}" method="POST">
        @csrf

        <div class="flex flex-wrap justify-center gap-5 tv-vertical:gap-10">
          @php
            $options = [
                ['id' => 'tidak-puas', 'value' => 1, 'label' => 'Tidak Puas', 'video' => '11175771'],
                ['id' => 'biasa-saja', 'value' => 2, 'label' => 'Biasa Saja', 'video' => '11175745'],
                ['id' => 'puas', 'value' => 3, 'label' => 'Puas', 'video' => '11175727'],
                ['id' => 'sangat-puas', 'value' => 4, 'label' => 'Sangat Puas', 'video' => '11175766'],
            ];
          @endphp

          @foreach ($options as $option)
            <div>
              <input type="radio" name="nilai" id="{{ $option['id'] }}" value="{{ $option['value'] }}"
                class="peer hidden" required />

              <label for="{{ $option['id'] }}"
                class="bg-white flex cursor-pointer flex-col items-center gap-2 rounded-2xl border p-4 shadow-md transition peer-checked:ring-2 peer-checked:ring-blue hover:scale-105 active:scale-95 group tv-vertical:p-8 tv-vertical:gap-4">
                <video width="100" height="100" autoplay loop muted playsinline preload="auto"
                  poster="https://cdn-icons-png.flaticon.com/512/11175/{{ $option['video'] }}.png"
                  class="mx-auto rounded-xl tv-vertical:w-[180px] tv-vertical:h-[180px]"
                  style="background: transparent center center / contain no-repeat;">
                  <source src="https://cdn-icons-mp4.flaticon.com/512/11175/{{ $option['video'] }}.mp4"
                    type="video/mp4" />
                </video>
                <span class="font-semibold tv-vertical:text-2xl">
                  {{ $option['label'] }}
                </span>
              </label>
            </div>
          @endforeach
        </div>

        <!-- Tombol Submit -->
        <div class="my-6 flex justify-center tv-vertical:my-12">
          <button type="submit"
            class="rounded-full bg-yellow text-blue px-6 py-2 text-lg font-bold transition-all duration-200 hover:bg-blue hover:text-yellow active:scale-95 focus:outline-none focus:ring-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed tv-vertical:text-2xl tv-vertical:px-16 tv-vertical:py-4">
            Kirim Survei
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
