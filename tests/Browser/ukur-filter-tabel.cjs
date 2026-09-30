/*
 * Ukur waktu redraw DataTables daftar laporan e-panel dengan penyaring aktif
 * (untuk data besar). Server & data disiapkan oleh jalankan-ukur.sh.
 *   BASE_URL=http://127.0.0.1:8191 node tests/Browser/ukur-filter-tabel.cjs
 */
const puppeteer = require('puppeteer');
const BASE = process.env.BASE_URL || 'http://127.0.0.1:8191';

(async () => {
  const b = await puppeteer.launch({ headless: 'new' });
  const p = await b.newPage();
  await p.goto(BASE + '/e-panel/login', { waitUntil: 'domcontentloaded' });
  await p.type('input[name=name]', 'super_admin');
  await p.type('input[name=password]', 'rahasia-uji-123');
  await Promise.all([p.waitForNavigation({ waitUntil: 'domcontentloaded' }), p.$eval('form', (f) => f.submit())]);
  await p.goto(BASE + '/e-panel/hantu-banyu/laporan', { waitUntil: 'networkidle2', timeout: 120000 });
  await p.waitForFunction(() => window.$ && $.fn.dataTable && $.fn.dataTable.isDataTable('#laporan'));

  const hasil = await p.evaluate(() => {
    const set = (id, v) => { const el = document.getElementById(id); el.value = v; el.dispatchEvent(new Event('change', { bubbles: true })); };
    const cek = (sel) => { const c = document.querySelector(sel); c.checked = true; c.dispatchEvent(new Event('change', { bubbles: true })); };
    set('filterTanggalDari', '2025-01-01');
    set('filterTanggalSampai', '2026-12-31');
    set('filterDibuatOleh', 'kelurahan');
    cek('.filterStatus[value="selesai"]');
    cek('.filterStatus[value="pending"]');
    cek('.filterJenis[value="biasa"]');
    const t = $('#laporan').DataTable();
    const ukur = () => { const m = performance.now(); for (let i = 0; i < 20; i++) t.draw(); return (performance.now() - m) / 20; };
    ukur();
    const kali = [ukur(), ukur(), ukur()].sort((a, b) => a - b);
    return { baris: t.rows().count(), lolos: t.rows({ search: 'applied' }).count(), ms_per_redraw: Math.round(kali[1] * 100) / 100 };
  });
  console.log(JSON.stringify(hasil));
  await b.close();
})();
