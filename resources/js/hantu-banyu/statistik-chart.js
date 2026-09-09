// Grafik statistik laporan Hantu Banyu (Chart.js).
//
// Baca datanya dari elemen #statistik-hantu-banyu-data lewat atribut data-*:
//   data-by-ym           JSON: { [tahun]: { [bulan]: { masuk, status, jenis, kecamatan, kelurahan } } }
//   data-kecamatan-list  JSON array nama kecamatan
//   data-kelurahan-map   JSON: { [nama_kecamatan]: [nama_kelurahan, ...] }
//   data-now-year, data-now-month, data-now-quarter   angka acuan "sekarang"
//
// Berjalan otomatis saat elemen #statistik-hantu-banyu-data ditemukan di
// halaman (window load). Elemen kanvas/kontrol yang tidak ada di markup
// halaman (mis. #chartKecamatan atau #chartKelurahan) dilewati begitu saja,
// tidak menimbulkan error.

window.addEventListener('load', function() {
  if (!window.Chart) return;

  var dataEl = document.getElementById('statistik-hantu-banyu-data');
  if (!dataEl) return;

  Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
  Chart.defaults.color = '#6b7280';

  var byYM = JSON.parse(dataEl.dataset.byYm);
  var kecList = JSON.parse(dataEl.dataset.kecamatanList);
  var kelMap = JSON.parse(dataEl.dataset.kelurahanMap);
  var nowYear = parseInt(dataEl.dataset.nowYear, 10);
  var nowMonth = parseInt(dataEl.dataset.nowMonth, 10);
  var nowQuarter = parseInt(dataEl.dataset.nowQuarter, 10);

  var bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
    'Oktober', 'November', 'Desember'
  ];

  var diprosesKeys = ['diterima', 'menunggu_survei', 'sudah_disurvei', 'menunggu_jadwal_pengerjaan',
    'sedang_dikerjakan'
  ];
  var diprosesLabel = ['Diterima', 'Menunggu Survei', 'Sudah Disurvei', 'Menunggu Jadwal Pengerjaan',
    'Sedang Dikerjakan'
  ];
  var diprosesColor = ['#3b82f6', '#ec4899', '#a855f7', '#f97316', '#6366f1'];

  var jenisKeys = ['belum_diklasifikasikan', 'darurat', 'biasa', 'rutin'];
  var jenisLabel = ['Belum Diklasifikasikan', 'Penanganan Darurat', 'Penanganan Biasa', 'Pemeliharaan Rutin'];
  var jenisColor = ['#9ca3af', '#ef4444', '#14b8a6', '#3b82f6'];

  function cell(y, m) {
    return (byYM[y] && byYM[y][m]) || {
      masuk: 0,
      status: {},
      jenis: {},
      kecamatan: {}
    };
  }

  function num(o, k) {
    return (o && o[k]) ? o[k] : 0;
  }

  function sum(arr) {
    return arr.reduce(function(a, b) {
      return a + b;
    }, 0);
  }

  function toggleNoData(id, empty) {
    var el = document.getElementById(id);
    if (el) el.style.display = empty ? 'flex' : 'none';
  }

  // Elemen-elemen di bawah tidak selalu ada (mis. grafik kecamatan tidak
  // dirender untuk akun kelurahan), jadi semua helper ini menoleransi
  // elemen yang tidak ditemukan.
  function isiBulan(id) {
    var sel = document.getElementById(id);
    if (!sel) return;
    bulanNama.forEach(function(nama, i) {
      var opt = document.createElement('option');
      opt.value = i + 1;
      opt.textContent = nama;
      sel.appendChild(opt);
    });
  }

  function setNilai(id, nilai) {
    var el = document.getElementById(id);
    if (el) el.value = nilai;
  }

  function pasangListener(id, fungsi) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('change', fungsi);
  }

  // Isi dropdown bulan
  ['diprosesMonth', 'jenisMonth', 'kecMonth'].forEach(isiBulan);

  // Set nilai default
  setNilai('masukQuarter', nowQuarter);
  setNilai('masukYear', nowYear);
  ['diprosesMonth', 'jenisMonth', 'kecMonth'].forEach(function(id) {
    setNilai(id, nowMonth);
  });
  ['diprosesYear', 'jenisYear', 'kecYear'].forEach(function(id) {
    setNilai(id, nowYear);
  });

  var doughnutOpts = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right'
      }
    }
  };

  // ---------- Laporan Masuk ----------
  var chartMasuk = new Chart(document.getElementById('chartMasuk'), {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
          label: 'Belum diproses',
          data: [],
          backgroundColor: '#E63846',
          borderRadius: 4
        },
        {
          label: 'Sedang diproses',
          data: [],
          backgroundColor: '#F9A11A',
          borderRadius: 4
        },
        {
          label: 'Selesai',
          data: [],
          backgroundColor: '#9EDE73',
          borderRadius: 4
        },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          stacked: true
        },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  function renderMasuk() {
    var q = parseInt(document.getElementById('masukQuarter').value, 10);
    var y = parseInt(document.getElementById('masukYear').value, 10);
    var start = (q - 1) * 3 + 1;
    var months = [start, start + 1, start + 2];
    var pending = [],
      proses = [],
      selesai = [];
    months.forEach(function(m) {
      var st = cell(y, m).status;
      pending.push(num(st, 'pending'));
      proses.push(diprosesKeys.reduce(function(a, k) {
        return a + num(st, k);
      }, 0));
      selesai.push(num(st, 'selesai'));
    });
    chartMasuk.data.labels = months.map(function(m) {
      return bulanNama[m - 1];
    });
    chartMasuk.data.datasets[0].data = pending;
    chartMasuk.data.datasets[1].data = proses;
    chartMasuk.data.datasets[2].data = selesai;
    chartMasuk.update();

    var totalP = sum(pending) + sum(proses) + sum(selesai);
    toggleNoData('nodataMasuk', totalP === 0);
  }

  // ---------- Laporan sedang Diproses ----------
  var chartDiproses = new Chart(document.getElementById('chartDiproses'), {
    type: 'doughnut',
    data: {
      labels: diprosesLabel,
      datasets: [{
        data: [],
        backgroundColor: diprosesColor
      }]
    },
    options: doughnutOpts
  });

  function renderDiproses() {
    var m = parseInt(document.getElementById('diprosesMonth').value, 10);
    var y = parseInt(document.getElementById('diprosesYear').value, 10);
    var st = cell(y, m).status;
    var data = diprosesKeys.map(function(k) {
      return num(st, k);
    });
    chartDiproses.data.datasets[0].data = data;
    chartDiproses.update();
    toggleNoData('nodataDiproses', sum(data) === 0);
  }

  // ---------- Jenis Laporan ----------
  var chartJenis = new Chart(document.getElementById('chartJenis'), {
    type: 'doughnut',
    data: {
      labels: jenisLabel,
      datasets: [{
        data: [],
        backgroundColor: jenisColor
      }]
    },
    options: doughnutOpts
  });

  function renderJenis() {
    var m = parseInt(document.getElementById('jenisMonth').value, 10);
    var y = parseInt(document.getElementById('jenisYear').value, 10);
    var jn = cell(y, m).jenis;
    var data = jenisKeys.map(function(k) {
      return num(jn, k);
    });
    chartJenis.data.datasets[0].data = data;
    chartJenis.update();
    toggleNoData('nodataJenis', sum(data) === 0);
  }

  // ---------- Kecamatan (tidak selalu ada, mis. akun kelurahan) ----------
  var renderKec = function() {};
  var kanvasKec = document.getElementById('chartKecamatan');

  if (kanvasKec) {
    var chartKec = new Chart(kanvasKec, {
      type: 'bar',
      data: {
        labels: kecList,
        datasets: [{
          label: 'Jumlah laporan',
          data: [],
          backgroundColor: '#223468',
          borderRadius: 4
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    renderKec = function() {
      var m = parseInt(document.getElementById('kecMonth').value, 10);
      var y = parseInt(document.getElementById('kecYear').value, 10);
      var kc = cell(y, m).kecamatan;
      var data = kecList.map(function(nama) {
        return num(kc, nama);
      });
      chartKec.data.datasets[0].data = data;
      chartKec.update();
      toggleNoData('nodataKec', sum(data) === 0);
    };
  }

  pasangListener('masukQuarter', renderMasuk);
  pasangListener('masukYear', renderMasuk);
  pasangListener('diprosesMonth', renderDiproses);
  pasangListener('diprosesYear', renderDiproses);
  pasangListener('jenisMonth', renderJenis);
  pasangListener('jenisYear', renderJenis);
  pasangListener('kecMonth', renderKec);
  pasangListener('kecYear', renderKec);

  renderMasuk();
  renderDiproses();
  renderJenis();
  renderKec();

  // ---------- Sebaran per Kelurahan (tidak selalu ada) ----------
  var kanvasKel = document.getElementById('chartKelurahan');

  if (kanvasKel) {
    var kelKecamatanSel = document.getElementById('kelKecamatan');
    var kelMonthSel = document.getElementById('kelMonth');
    var kelYearSel = document.getElementById('kelYear');
    var kelChartWrap = document.getElementById('kelChartWrap');
    var nodataKel = document.getElementById('nodataKel');

    function kelCell(y, m) {
      return (byYM[y] && byYM[y][m] && byYM[y][m].kelurahan) || {};
    }

    bulanNama.forEach(function(nama, i) {
      var opt = document.createElement('option');
      opt.value = i + 1;
      opt.textContent = nama;
      kelMonthSel.appendChild(opt);
    });
    kelMonthSel.value = nowMonth;
    kelYearSel.value = nowYear;

    var chartKel = new Chart(kanvasKel, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          label: 'Jumlah laporan',
          data: [],
          backgroundColor: '#223468',
          borderRadius: 4
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    var renderKel = function() {
      var kec = kelKecamatanSel.value;
      var m = parseInt(kelMonthSel.value, 10);
      var y = parseInt(kelYearSel.value, 10);
      var daftar = kelMap[kec] || [];
      var perKec = kelCell(y, m)[kec] || {};
      var data = daftar.map(function(nm) {
        return perKec[nm] || 0;
      });

      kelChartWrap.style.height = Math.max(288, daftar.length * 34) + 'px';
      chartKel.data.labels = daftar;
      chartKel.data.datasets[0].data = data;
      chartKel.update();

      nodataKel.style.display = sum(data) === 0 ? 'flex' : 'none';
    };

    [kelKecamatanSel, kelMonthSel, kelYearSel].forEach(function(el) {
      el.addEventListener('change', renderKel);
    });

    renderKel();
  }
});
