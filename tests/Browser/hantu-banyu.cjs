/*
 * Uji perilaku frontend Hantu Banyu di Chrome headless (Puppeteer bawaan
 * Browsershot). Merekam keadaan halaman setelah serangkaian interaksi ke
 * sebuah berkas JSON, untuk dibandingkan sebelum vs sesudah optimasi.
 *
 * Pemakaian:
 *   BASE_URL=http://127.0.0.1:8191 node tests/Browser/hantu-banyu.cjs hasil.json
 *
 * Server harus menunjuk database pupr_smr_test yang sudah diisi
 * HantuBanyuFixture (lihat tests/Browser/jalankan.sh). Permintaan ke Overpass
 * dan server peta dijawab tiruan (dengan jeda terkendali untuk menguji
 * balapan respons), sehingga hasilnya tidak bergantung internet.
 */
const puppeteer = require('puppeteer');
const fs = require('fs');

const BASE = process.env.BASE_URL || 'http://127.0.0.1:8191';
const OUT = process.argv[2] || 'hasil-browser.json';
const PASSWORD = 'rahasia-uji-123';
const PNG_1PX = Buffer.from('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', 'base64');

// Jawaban Overpass tiruan per kata kunci: [jeda ms, daftar nama jalan].
const OVERPASS = {
  jua: [80, ['Jalan Juanda', 'Jalan Juanda', 'Gang Juanda 3', 'Jalan Ir. H. Juanda']],
  pah: [1500, ['Jalan Pahlawan', 'Jalan Pahala']],
  pahl: [80, ['Jalan Pahlawan']],
  xyz: [80, []],
};
const overpassLog = [];
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function siapkanHalaman(browser) {
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });
  await page.setRequestInterception(true);
  page.on('request', async (req) => {
    const url = req.url();
    if (/tile\.openstreetmap\.org|arcgisonline\.com/.test(url)) {
      return req.respond({ status: 200, contentType: 'image/png', body: PNG_1PX });
    }
    if (/lottie/.test(url)) return req.abort();
    if (/overpass|\/interpreter/.test(url)) {
      const body = req.postData() || '';
      const kunci = (body.match(/"name"~"\.\*(.*?)\.\*"/) || [])[1] || '';
      const area = (body.match(/area\["name"="(.*?)"\]/) || [])[1] || '';
      overpassLog.push({ kunci, area });
      const [jeda, nama] = OVERPASS[kunci] || [80, []];
      await sleep(jeda);
      return req.respond({
        status: 200,
        contentType: 'application/json',
        headers: { 'Access-Control-Allow-Origin': '*' },
        body: JSON.stringify({ elements: nama.map((n) => ({ type: 'way', tags: { name: n, highway: 'residential' }, center: { lat: -0.5, lon: 117.1 } })) }),
      });
    }
    return req.continue();
  });
  const galat = [];
  page.on('pageerror', (e) => galat.push(String(e.message).split('\n')[0]));
  return { page, galat };
}

async function loginAdmin(page) {
  await page.goto(BASE + '/e-panel/login', { waitUntil: 'domcontentloaded' });
  await page.type('input[name=name]', 'super_admin');
  await page.type('input[name=password]', PASSWORD);
  await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.$eval('form', (f) => f.submit())]);
}

async function loginKelurahan(page) {
  await page.goto(BASE + '/hantu-banyu/login', { waitUntil: 'domcontentloaded' });
  await page.type('input[name=name]', 'air_putih');
  await page.type('input[name=password]', PASSWORD);
  await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.$eval('form', (f) => f.submit())]);
}

async function ujiPeta(page) {
  await page.goto(BASE + '/hantu-banyu/peta-sebaran', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => typeof markerLayer !== 'undefined' && document.getElementById('search-nama-jalan'));

  const marker = () => page.evaluate(() => markerLayer.getLayers().map((m) => {
    const ll = m.getLatLng();
    return [ll.lat, ll.lng, (m.options.icon.options.html.match(/fill="(#[0-9a-fA-F]+)"/) || [])[1]];
  }));
  const ubahCentang = (sel, nilai) => page.evaluate((sel, nilai) => {
    const cb = document.querySelector(sel);
    cb.checked = nilai;
    cb.dispatchEvent(new Event('change', { bubbles: true }));
  }, sel, nilai);

  const hasil = { awal: await marker() };
  await ubahCentang('.status-checkbox[value="selesai"]', true);
  hasil.plusSelesai = await marker();
  await ubahCentang('.status-checkbox[value="pending"]', false);
  hasil.tanpaPending = await marker();
  await ubahCentang('.jenis-checkbox[value="darurat"]', false);
  hasil.tanpaDarurat = await marker();
  await page.type('#search-nama-jalan', 'jalan a');
  hasil.cariJalanA = await marker();
  await page.$eval('#search-nama-jalan', (i) => { i.value = ''; i.dispatchEvent(new Event('input')); });
  await page.click('#filter-status-clear').catch(() => page.$eval('#filter-status-clear', (b) => b.click()));
  await page.$eval('#filter-jenis-clear', (b) => b.click());
  hasil.setelahReset = await marker();

  hasil.modal = await page.evaluate(() => {
    const m = markerLayer.getLayers()[3];
    m.fire('click');
    const t = (id) => document.getElementById(id).textContent.trim();
    return {
      judul: t('modal-title'), kelurahan: t('modal-kelurahan'), kecamatan: t('modal-kecamatan'),
      status: t('modal-status-badge'), statusWarna: document.getElementById('modal-status-badge').style.backgroundColor,
      jenis: t('modal-jenis-badge'), jenisWarna: document.getElementById('modal-jenis-badge').style.backgroundColor,
      detail: document.getElementById('modal-detail-link').getAttribute('href'),
      gmaps: document.getElementById('modal-gmaps-link').getAttribute('href'),
    };
  });
  return hasil;
}

async function ujiTabelAdmin(page) {
  await page.goto(BASE + '/e-panel/hantu-banyu/laporan', { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.$ && $.fn.dataTable && $.fn.dataTable.isDataTable('#laporan'));

  const baris = () => page.evaluate(() => $('#laporan').DataTable().rows({ search: 'applied', order: 'applied' }).nodes().toArray().map((tr) => tr.cells[0].textContent.trim()));
  const isi = (id, nilai) => page.evaluate((id, nilai) => {
    const el = document.getElementById(id);
    el.value = nilai;
    el.dispatchEvent(new Event('change', { bubbles: true }));
  }, id, nilai);
  const centang = (sel) => page.evaluate((sel) => {
    const cb = document.querySelector(sel);
    cb.checked = !cb.checked;
    cb.dispatchEvent(new Event('change', { bubbles: true }));
  }, sel);

  const hasil = { awal: await baris() };
  await isi('filterTanggalDari', '2026-03-01');
  hasil.dari = await baris();
  await isi('filterTanggalSampai', '2026-08-31');
  hasil.rentang = await baris();
  await isi('filterDibuatOleh', 'kelurahan');
  hasil.kelurahan = await baris();
  await centang('.filterStatus[value="selesai"]');
  await centang('.filterStatus[value="pending"]');
  hasil.status = await baris();
  await centang('.filterJenis[value="biasa"]');
  hasil.jenis = await baris();
  hasil.teksMultifilter = await page.evaluate(() => Array.from(document.querySelectorAll('[data-multifilter-teks]')).map((e) => e.textContent.trim()));
  await page.$eval('#btnResetFilter', (b) => b.click());
  hasil.reset = await baris();
  await isi('filterDibuatOleh', 'admin');
  await page.evaluate(() => $('#laporan').DataTable().search('Juanda').draw());
  hasil.cariDanAdmin = await baris();
  hasil.info = await page.$eval('.dt-info, .dataTables_info', (e) => e.textContent.trim()).catch(() => null);

  // Waktu redraw dengan semua filter aktif (metrik, bukan pembanding).
  await page.evaluate(() => $('#laporan').DataTable().search('').draw());
  await centang('.filterStatus[value="selesai"]');
  hasil._msRedraw = await page.evaluate(() => {
    const t = $('#laporan').DataTable();
    const mulai = performance.now();
    for (let i = 0; i < 50; i++) t.draw();
    return Math.round((performance.now() - mulai) / 50 * 100) / 100;
  });
  return hasil;
}

async function ujiAutocomplete(page, url, id) {
  await page.goto(BASE + url, { waitUntil: 'networkidle2' });
  const kec = id.kec, kel = id.kel, jalan = id.jalan, ul = id.ul;
  if (kec) {
    await page.select('#' + kec, '1');
    await page.select('#' + kel, '1');
  }

  const daftar = () => page.evaluate((ul) => {
    const el = document.getElementById(ul);
    return { tampil: !el.classList.contains('hidden'), isi: Array.from(el.querySelectorAll('li')).map((li) => li.textContent) };
  }, ul);
  // Kolom bisa berada di langkah stepper yang belum tampil, jadi ketikan
  // disimulasikan per karakter lewat event input (sama seperti keyboard).
  const ketik = (teks) => page.evaluate(async (id, teks) => {
    const el = document.getElementById(id);
    for (const ch of teks) {
      el.value += ch;
      el.dispatchEvent(new Event('input', { bubbles: true }));
      await new Promise((r) => setTimeout(r, 30));
    }
  }, jalan, teks);
  const hapusSatu = () => page.$eval('#' + jalan, (i) => { i.value = i.value.slice(0, -1); i.dispatchEvent(new Event('input', { bubbles: true })); });
  const kosongkan = () => page.$eval('#' + jalan, (i) => { i.value = ''; i.dispatchEvent(new Event('input', { bubbles: true })); });
  const hitung = () => overpassLog.length;

  const hasil = {};
  let awal = hitung();
  await ketik('jua');
  await sleep(900);
  hasil.normal = await daftar();
  hasil.normalArea = overpassLog[overpassLog.length - 1];
  await page.$eval('#' + ul + ' li', (li) => li.click());
  hasil.setelahPilih = { nilai: await page.$eval('#' + jalan, (i) => i.value), ...(await daftar()) };

  await kosongkan();
  await ketik('jua');
  await sleep(900);
  hasil.ulangSama = await daftar();
  hasil.permintaanUntukDuaKaliJua = hitung() - awal;

  // Balapan: "pah" (lambat) masih jalan ketika "pahl" (cepat) dikirim.
  await kosongkan();
  await ketik('pah');
  await sleep(500);
  await ketik('l');
  await sleep(2500);
  hasil.balapan = await daftar();

  // Diperpendek < 3 huruf saat respons masih dalam perjalanan.
  await kosongkan();
  await ketik('pah');
  await sleep(500);
  await hapusSatu();
  hasil.segeraSetelahPendek = await daftar();
  await sleep(2000);
  hasil.akhirSetelahPendek = await daftar();

  await kosongkan();
  await ketik('xyz');
  await sleep(900);
  hasil.kosong = await daftar();
  return hasil;
}

async function ujiStatistik(page, url) {
  await page.goto(BASE + url, { waitUntil: 'networkidle2' });
  await page.waitForFunction(() => window.Chart && Object.keys(Chart.instances).length > 0, { timeout: 20000 });
  await sleep(300);
  const grafik = () => page.evaluate(() => Object.values(Chart.instances)
    .map((c) => ({ id: c.canvas.id, labels: c.data.labels, data: c.data.datasets.map((d) => ({ label: d.label, data: d.data })) }))
    .sort((a, b) => a.id.localeCompare(b.id)));
  const pilih = async (id, v) => {
    if (await page.$('#' + id)) {
      await page.select('#' + id, String(v));
    }
  };

  const hasil = { awal: await grafik(), kpi: await page.evaluate(() => document.body.innerText.match(/\d[\d.]*\s*\n?\s*(Laporan|Total|Selesai|Diproses|Belum)[^\n]*/g)) };
  await pilih('masukYear', 2025);
  await pilih('masukQuarter', 4);
  await pilih('diprosesYear', 2026);
  await pilih('diprosesMonth', 6);
  await pilih('jenisMonth', 8);
  await pilih('kecYear', 2025);
  await pilih('kecMonth', 12);
  await pilih('kelKecamatan', 'Samarinda Ilir');
  await pilih('kelMonth', 5);
  await sleep(300);
  hasil.setelahUbah = await grafik();
  return hasil;
}

(async () => {
  const browser = await puppeteer.launch({ headless: 'new' });
  const hasil = {};
  try {
    const admin = await siapkanHalaman(browser);
    await loginAdmin(admin.page);
    hasil.petaAdmin = await ujiPeta(admin.page);
    hasil.tabelAdmin = await ujiTabelAdmin(admin.page);
    hasil.autocompletePengaduan = await ujiAutocomplete(admin.page, '/hantu-banyu/pengaduan/buat',
      { kec: 'laporan__kecamatan', kel: 'laporan__kelurahan', jalan: 'laporan__nama_jalan', ul: 'nama-jalan-autocomplete' });
    hasil.autocompletePemeriksaan = await ujiAutocomplete(admin.page, '/e-panel/hantu-banyu/pemeriksaan-berkala/tambah',
      { kec: 'pb__kecamatan', kel: 'pb__kelurahan', jalan: 'pb__nama_jalan', ul: 'pb__nama_jalan_autocomplete' });
    hasil.statistikPublikAdmin = await ujiStatistik(admin.page, '/hantu-banyu');
    hasil.statistikEpanel = await ujiStatistik(admin.page, '/e-panel/hantu-banyu/statistik-laporan');
    hasil.galatJsAdmin = admin.galat;

    const ctx = await browser.createBrowserContext();
    const kel = await siapkanHalaman(ctx);
    await loginKelurahan(kel.page);
    hasil.petaKelurahan = await ujiPeta(kel.page);
    hasil.autocompletePengaduanKelurahan = await ujiAutocomplete(kel.page, '/hantu-banyu/pengaduan/buat',
      { jalan: 'laporan__nama_jalan', ul: 'nama-jalan-autocomplete' });
    hasil.statistikKelurahan = await ujiStatistik(kel.page, '/hantu-banyu');
    hasil.galatJsKelurahan = kel.galat;
  } finally {
    await browser.close();
  }
  fs.writeFileSync(OUT, JSON.stringify(hasil, null, 1));
  console.log('OK ->', OUT);
})().catch((e) => { console.error('GAGAL', e); process.exit(1); });
