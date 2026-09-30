{{--
  Skrip pendukung form tambah/edit pemeriksaan berkala. Dipakai bersama oleh
  create.blade.php dan edit.blade.php lewat @include di section
  'document.end' masing-masing.

  Dua bagian:
  1. Kaskade Kecamatan -> Kelurahan -> Nama Jalan, dengan pencarian nama
     jalan langsung dari Overpass API (OSM) dibatasi pada kelurahan
     terpilih - konsep dan sumber datanya sama persis dengan form
     "Buat Laporan" di sisi guest, hanya tanpa tombol GPS/peta.
  2. Kalkulasi otomatis persentase & kategori sedimentasi (dari input cm
     dibagi dimensi tinggi eksisting), sinkron dengan
     HantuBanyuPemeriksaanBerkala::getPersenSedimentasiAttribute()/
     getKategoriSedimentasiAttribute() di sisi server.
--}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // ---------- Kaskade lokasi: Kecamatan -> Kelurahan -> Nama Jalan ----------
    const kecSelect = document.getElementById('pb__kecamatan');
    const kelSelect = document.getElementById('pb__kelurahan');
    const namaJalanInput = document.getElementById('pb__nama_jalan');
    const kelOptions = Array.from(kelSelect.querySelectorAll('option[data-kecamatan]'));
    const initialKelurahanId = kecSelect.dataset.initialKelurahan || '';
    const initialNamaJalan = kecSelect.dataset.initialNamaJalan || '';

    function rebuildKelurahan(kecId, preselectId) {
      kelSelect.innerHTML = '<option value="" disabled' + (preselectId ? '' : ' selected') + '>Pilih kelurahan</option>';
      kelOptions.forEach(function(opt) {
        if (opt.getAttribute('data-kecamatan') === kecId) {
          kelSelect.appendChild(opt.cloneNode(true));
        }
      });
      if (preselectId) {
        kelSelect.value = preselectId;
      }
    }

    function resetKelurahan() {
      kelSelect.innerHTML = '<option value="" selected disabled>Pilih kecamatan terlebih dahulu</option>';
      kelSelect.disabled = true;
      kelSelect.classList.add('disabled:bg-gray-100');
    }

    function resetNamaJalan(placeholder) {
      namaJalanInput.value = '';
      namaJalanInput.disabled = true;
      namaJalanInput.classList.add('disabled:bg-gray-100');
      namaJalanInput.placeholder = placeholder;
    }

    function enableNamaJalan() {
      namaJalanInput.disabled = false;
      namaJalanInput.classList.remove('disabled:bg-gray-100');
      namaJalanInput.placeholder = 'Contoh: Insinyur Haji Juanda';
    }

    // Kondisi awal: kecamatan sudah terisi (mode edit, atau formulir tambah
    // yang dimuat ulang setelah validasi gagal) -> susun ulang kelurahan dan
    // aktifkan nama jalan sesuai nilai yang sudah ada, jangan direset.
    if (kecSelect.value) {
      rebuildKelurahan(kecSelect.value, initialKelurahanId);
      kelSelect.disabled = false;
      kelSelect.classList.remove('disabled:bg-gray-100');
      if (kelSelect.value) {
        enableNamaJalan();
        if (initialNamaJalan) {
          namaJalanInput.value = initialNamaJalan;
        }
      } else {
        resetNamaJalan('Pilih kelurahan terlebih dahulu');
      }
    } else {
      resetKelurahan();
      resetNamaJalan('Pilih kelurahan terlebih dahulu');
    }

    kecSelect.addEventListener('change', function() {
      rebuildKelurahan(this.value, null);
      kelSelect.disabled = false;
      kelSelect.classList.remove('disabled:bg-gray-100');
      resetNamaJalan('Pilih kelurahan terlebih dahulu');
    });

    kelSelect.addEventListener('change', function() {
      if (this.value) {
        enableNamaJalan();
      } else {
        resetNamaJalan('Pilih kelurahan terlebih dahulu');
      }
    });

    // Nama jalan: autocomplete langsung dari Overpass API OSM, dibatasi pada
    // kelurahan yang sedang aktif.
    let jalanTimeout;
    namaJalanInput.addEventListener('input', function() {
      clearTimeout(jalanTimeout);
      const query = this.value;
      const kelurahanNama = kelSelect.options[kelSelect.selectedIndex]?.text;
      const ul = document.getElementById('pb__nama_jalan_autocomplete');
      if (query.length < 3 || !kelSelect.value) {
        ul.classList.add('hidden');
        return;
      }
      jalanTimeout = setTimeout(function() {
        const overpassQuery = `
          [out:json][timeout:25];
          area["name"="${kelurahanNama}"]["boundary"="administrative"];
          (
            way(area)["highway"]["name"~".*${query}.*",i];
          );
          out tags center;
        `;
        fetch(@json(config('services.overpass.url')), {
            method: 'POST',
            body: overpassQuery,
            headers: {
              'Content-Type': 'text/plain'
            }
          })
          .then(res => res.json())
          .then(data => {
            ul.innerHTML = '';
            if (!data.elements || data.elements.length === 0) {
              ul.classList.add('hidden');
              return;
            }
            const names = [...new Set(
              data.elements.map(e => e.tags.name).filter(nama => nama && !/gang/i.test(nama))
            )];
            names.forEach(function(nama) {
              const li = document.createElement('li');
              li.textContent = nama;
              li.className = 'px-3 py-2 cursor-pointer hover:bg-gray-100';
              li.addEventListener('click', function() {
                namaJalanInput.value = nama;
                ul.classList.add('hidden');
              });
              ul.appendChild(li);
            });
            ul.classList.toggle('hidden', names.length === 0);
          });
      }, 400);
    });

    namaJalanInput.addEventListener('blur', function() {
      setTimeout(function() {
        document.getElementById('pb__nama_jalan_autocomplete').classList.add('hidden');
      }, 200);
    });

    // ---------- Kalkulasi otomatis persentase & kategori sedimentasi ----------
    const tinggiInput = document.getElementById('dimensi_tinggi_m');
    const sedimentasiInput = document.getElementById('tingkat_sedimentasi_sampah_cm');
    const sedimentasiHasil = document.getElementById('pb__sedimentasi_hasil');

    // Sinkron dengan HantuBanyuPemeriksaanBerkala::getKategoriSedimentasiAttribute().
    function kategoriSedimentasi(persen) {
      if (persen <= 15) return 'Normal';
      if (persen <= 30) return 'Sedang';
      return 'Tinggi';
    }

    function hitungSedimentasi() {
      const cm = parseFloat(sedimentasiInput.value);
      const tinggiM = parseFloat(tinggiInput.value);

      if (isNaN(cm) || isNaN(tinggiM) || tinggiM <= 0) {
        sedimentasiHasil.textContent = 'Isi tinggi eksisting & sedimentasi untuk melihat persentase & kategorinya secara otomatis.';
        return;
      }

      const persen = Math.round((cm / (tinggiM * 100)) * 100 * 10) / 10;
      sedimentasiHasil.innerHTML = 'Persentase terhadap tinggi eksisting: <b>' + persen + '%</b> (' + kategoriSedimentasi(persen) + ')';
    }

    sedimentasiInput.addEventListener('input', hitungSedimentasi);
    tinggiInput.addEventListener('input', hitungSedimentasi);
  });
</script>
