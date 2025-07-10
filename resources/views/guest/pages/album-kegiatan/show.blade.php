@extends('guest.layouts.album-kegiatan')

@section('slot')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-brand-blue uppercase font-bold text-brand-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        {{ $page_title }}
      </span>
    </div>

    <h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 uppercase">
      Album Kegiatan <br> {{ $page_subtitle }}
    </h1>

    <div id="gallery-masonry" class="masonry-flex gap-2">
    </div>
  </div>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css" />
  <style>
    .masonry-flex {
      display: flex;
      gap: 8px;
      width: 100%;
    }

    .masonry-column {
      flex: 1 1 0;
      display: flex;
      flex-direction: column;
      gap: 8px;
      min-width: 0;
    }

    .masonry-item {
      margin-bottom: 0;
      overflow: hidden;
      display: flex;
      align-items: stretch;
      justify-content: stretch;
    }

    .masonry-item img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: contain;
      background: #f3f4f6;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"></script>
  <script>
    function getColumnCount() {
      if (window.innerWidth >= 1536) return 5;
      if (window.innerWidth >= 1024) return 4;
      if (window.innerWidth >= 768) return 3;
      return 2;
    }

    const masonryItemsData = [
      @foreach ($photos as $photo)
        {
          src: "{{ Storage::url($photo->foto) }}",
          alt: "{{ $photo->caption ?? $album->judul }}",
          caption: @json($photo->caption)
        },
      @endforeach
    ];

    function createMasonryItem(data) {
      const item = document.createElement('div');
      item.className = 'masonry-item';
      const img = document.createElement('img');
      img.src = data.src;
      img.alt = data.alt;
      if (data.caption) img.setAttribute('data-caption', data.caption);
      item.appendChild(img);
      return item;
    }

    let viewer = null;

    function initViewer() {
      var gallery = document.getElementById('gallery-masonry');
      if (viewer) {
        viewer.destroy();
      }
      viewer = new Viewer(gallery, {
        toolbar: true,
        navbar: true,
        title: [1, (image, imageData) => image.alt || ''],
        tooltip: true,
        filter: image => image.tagName === 'IMG'
      });
      var openBtn = document.getElementById('open-viewer-btn');
      if (openBtn) {
        openBtn.addEventListener('click', function() {
          viewer.show();
        });
      }
    }

    function layoutMasonry() {
      const container = document.getElementById('gallery-masonry');
      container.innerHTML = '';
      const colCount = getColumnCount();
      const columns = [];
      for (let i = 0; i < colCount; i++) {
        const col = document.createElement('div');
        col.className = 'masonry-column';
        columns.push(col);
        container.appendChild(col);
      }
      const colHeights = Array(colCount).fill(0);
      const tempImgs = [];
      masonryItemsData.forEach((data, idx) => {
        const item = createMasonryItem(data);
        const img = item.querySelector('img');
        tempImgs.push(img);
        img.onload = function() {
          if (tempImgs.every(im => im.complete)) {
            columns.forEach(col => col.innerHTML = '');
            colHeights.fill(0);
            masonryItemsData.forEach((d, i) => {
              const it = createMasonryItem(d);
              const im = it.querySelector('img');
              let minIdx = 0;
              for (let j = 1; j < colCount; j++) {
                if (colHeights[j] < colHeights[minIdx]) minIdx = j;
              }
              columns[minIdx].appendChild(it);
              const aspect = im.naturalHeight / im.naturalWidth;
              const colWidth = container.offsetWidth / colCount;
              colHeights[minIdx] += colWidth * aspect + 8;
            });
            initViewer();
          }
        };
      });
      if (tempImgs.length && tempImgs.every(im => im.complete)) {
        columns.forEach(col => col.innerHTML = '');
        colHeights.fill(0);
        masonryItemsData.forEach((d, i) => {
          const it = createMasonryItem(d);
          const im = it.querySelector('img');
          let minIdx = 0;
          for (let j = 1; j < colCount; j++) {
            if (colHeights[j] < colHeights[minIdx]) minIdx = j;
          }
          columns[minIdx].appendChild(it);
          const aspect = im.naturalHeight / im.naturalWidth;
          const colWidth = container.offsetWidth / colCount;
          colHeights[minIdx] += colWidth * aspect + 8;
        });
        initViewer();
      }
    }

    window.addEventListener('load', layoutMasonry);
    window.addEventListener('resize', layoutMasonry);

    document.addEventListener('DOMContentLoaded', function() {
      layoutMasonry();
    });
  </script>
@endpush


