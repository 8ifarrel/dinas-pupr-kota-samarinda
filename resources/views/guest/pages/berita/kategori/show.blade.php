@extends('guest.layouts.berita')

@section('slot')
  <div class="py-5 md:py-12 lg:px-48 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-blue uppercase font-bold text-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        {{ $page_title }}
      </span>
    </div>

    <h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 uppercase">
      {{ $page_subtitle }}
    </h1>

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

    <ul id="berita-list" class="grid grid-cols-2 gap-5">
      @foreach ($berita as $item)
        <li>
          <a href="{{ route('guest.berita.show', ['slug_berita' => $item->slug_berita]) }}">
            <figure>
              <img class="w-full h-full object-cover aspect-[16/9]" src="{{ Storage::url($item->foto_berita) }}"
                alt="image description">
              <figcaption>
                <h1 class="font-medium text-lg">{{ $item->judul_berita }}</h1>
              </figcaption>
              <time>{{ $item->created_at->format('D, d M Y') }}</time>
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
        <h2 class="text-3xl font-bold">Berita Lainnya</h2>
        <hr class="ms-4 w-48 h-1 bg-black border-0 my-auto dark:bg-gray-700">
      </div>

      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($berita_lainnya as $item)
              <li class="splide__slide mx-2">
                <img src="{{ Storage::url($item->foto_berita) }}" alt="">
                <h1>{{ Str::limit($item->judul_berita, 60) }}</h1>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

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
              <h1 class="font-medium text-lg">${item.judul_berita}</h1>
            </figcaption>
            <time>${new Date(item.created_at).toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' })}</time>
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
