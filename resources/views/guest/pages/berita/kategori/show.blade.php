@extends('guest.layouts.main')

@section('document.start')
  @vite('resources/css/splidejs.css')
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-5 lg:px-48 3xl:px-48">
    @include('guest.components.section-title')

    <div class="mx-auto mb-5" data-slug-kategori="{{ $slug_kategori }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="search" id="default-search"
          class="block w-full p-4 ps-10 text-gray-900 border border-gray-300 rounded-full bg-gray-50"
          placeholder="Ketik berita yang ingin Anda cari" required />
      </div>
    </div>

    <ul id="berita-list" class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-5">
      @foreach ($berita as $item)
        <li>
          <a href="{{ route('guest.berita.show', ['slug_berita' => $item->slug_berita]) }}">
            <figure>
              <img class="w-full h-full object-cover aspect-[16/9]"
                src="{{ Storage::disk('public')->exists($item->foto_berita) ? Storage::url($item->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}"
                alt="{{ $item->judul_berita }}" />
              <div class="flex items-center gap-1.5 text-sm my-0.5">
                <i class="fa-solid fa-calendar-days"></i>
                <time>{{ $item->created_at->translatedFormat('l, d F Y (H:i)') }}</time>
              </div>
              <figcaption>
                <h1 class="font-medium text-lg">{{ $item->judul_berita }}</h1>
              </figcaption>
            </figure>
          </a>
        </li>
      @endforeach
    </ul>

    <div id="pagination-links" class="mt-5">
      {{ $berita->links() }}
    </div>

    <div class="mt-10">
      <div class="flex mb-5">
        <h2 class="text-2xl sm:text-3xl font-bold">Berita Lainnya</h2>
        <hr class="ms-4 w-20 sm:w-48 h-1 bg-black border-0 my-auto dark:bg-gray-700">
      </div>

      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($berita_lainnya as $item)
              <li class="splide__slide px-2 !w-[200px] 2xl:!w-[350px]">
                <img class="aspect-[16/9] !w-[200px] 2xl:!w-[350px]" src="{{ Storage::url($item->foto_berita) }}"
                  alt="">
                <h1>{{ Str::limit($item->judul_berita, 60) }}</h1>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite('resources/js/splidejs.js')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var splide = new Splide('.splide', {
        type: 'loop',
        focus: 'center',
        drag: 'free',
        breakpoints: {
          640: {
            perPage: 2,
          },
          768: {
            perPage: 3,
          },
          1024: {
            perPage: 3,
          },
          1280: {
            perPage: 4,
          },
          1920: {
            perPage: 4,
          }
        },
        pagination: false,
      });
      splide.mount();
    });
  </script>

  <script>
    function debounce(func, wait) {
      let timeout;
      return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    }

    document.getElementById('default-search').addEventListener('input', debounce(function(e) {
      const query = e.target.value;
      const slugKategori = document.querySelector('[data-slug-kategori]').dataset.slugKategori;
      const csrfToken = document.querySelector('input[name="_token"]').value;

      fetch(`/berita/kategori/${slugKategori}/search?query=${encodeURIComponent(query)}`, {
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          updateBeritaList(data, slugKategori, query, csrfToken);
          history.pushState(null, '', `/berita/kategori/${slugKategori}?query=${encodeURIComponent(query)}`);
        })
        .catch(error => {
          console.error('Fetch error:', error);
          alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        });
    }, 300));

    function updateBeritaList(data, slugKategori, query, csrfToken) {
      const beritaList = document.getElementById('berita-list');
      beritaList.innerHTML = '';

      data.data.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `
        <a href="#">
          <figure>
            <img class="w-full h-full object-cover aspect-[16/9]" src="${item.foto_berita}" alt="image description">
            <figcaption>
              <div class="flex items-center gap-1.5 text-sm my-0.5">
                <i class="fa-solid fa-calendar-days"></i> 
                <time>
                  ${new Date(item.created_at).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                  })} (${new Date(item.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                  })})
                </time>
              </div>
              <h1 class="font-medium text-lg">${item.judul_berita}</h1>
            </figcaption>
          </figure>
        </a>
        `;
        beritaList.appendChild(li);
      });

      const paginationLinks = document.getElementById('pagination-links');
      paginationLinks.innerHTML = data.viewPagination;

      const paginationAnchors = paginationLinks.querySelectorAll('a');
      paginationAnchors.forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const url = new URL(this.href);
          const page = url.searchParams.get('page');
          fetch(`/berita/kategori/${slugKategori}/search?query=${encodeURIComponent(query)}&page=${page}`, {
              headers: {
                'X-CSRF-TOKEN': csrfToken
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              updateBeritaList(data, slugKategori, query, csrfToken);
              history.pushState(null, '',
                `/berita/kategori/${slugKategori}?query=${encodeURIComponent(query)}&page=${page}`);
            })
            .catch(error => {
              console.error('Fetch error:', error);
              alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
            });
        });
      });
    }

    function htmlspecialchars(str) {
      if (typeof str === 'string') {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(
          /'/g, '&#039;');
      }
      return str;
    }
  </script>
@endsection
