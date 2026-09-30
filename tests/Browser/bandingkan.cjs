/*
 * Bandingkan dua hasil uji browser Hantu Banyu. Kunci berawalan "_" adalah
 * metrik (mis. waktu redraw) dan tidak ikut dibandingkan. Kunci yang
 * disebut di argumen ke-3 (dipisah koma, mis. "autocompletePengaduan.balapan")
 * dilaporkan sebagai perubahan yang disengaja.
 *   node tests/Browser/bandingkan.cjs sebelum.json sesudah.json [disengaja]
 */
const fs = require('fs');
const [a, b] = [JSON.parse(fs.readFileSync(process.argv[2])), JSON.parse(fs.readFileSync(process.argv[3]))];
const disengaja = (process.argv[4] || '').split(',').filter(Boolean);
const beda = [];

function jalan(x, y, jalur) {
  if (jalur.split('.').pop().startsWith('_')) return;
  if (typeof x !== 'object' || x === null || typeof y !== 'object' || y === null) {
    if (JSON.stringify(x) !== JSON.stringify(y)) beda.push(jalur);
    return;
  }
  for (const k of new Set([...Object.keys(x), ...Object.keys(y)])) jalan(x[k], y[k], jalur ? jalur + '.' + k : k);
}
jalan(a, b, '');

const tak = beda.filter((j) => !disengaja.some((d) => j === d || j.startsWith(d + '.')));
const ya = beda.filter((j) => !tak.includes(j));
console.log('Perbedaan disengaja :', ya.length ? [...new Set(ya.map((j) => disengaja.find((d) => j === d || j.startsWith(d + '.'))))].join(', ') : '-');
console.log('Perbedaan TAK terduga:', tak.length ? tak.join('\n  ') : '-');
process.exit(tak.length ? 1 : 0);
