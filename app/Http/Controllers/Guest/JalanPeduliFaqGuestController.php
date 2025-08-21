<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

class JalanPeduliFaqGuestController extends Controller
{
    public function index(Request $request)
    {
        // Data FAQ baru yang lebih komprehensif
        $baseFaqsData = [
            [
                'question' => 'Apa itu web Jalan Peduli?',
                'answer' => 'Web Jalan Peduli adalah layanan yang disediakan oleh UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda untuk memungkinkan masyarakat melaporkan kerusakan jalan di wilayah Kota Samarinda, serta memantau tindak lanjutnya.'
            ],
            [
                'question' => 'Apakah ada panduan penggunaan web Jalan Peduli?',
                'answer' => 'Ya, panduan penggunaan dapat diakses di halaman utama web Jalan Peduli.'
            ],
            [
                'question' => 'Bagaimana cara membuat laporan kerusakan jalan di web Jalan Peduli?',
                'answer' => 'Klik <a href="' . route('guest.jalan-peduli.laporan.create') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Buat Laporan</a> di halaman utama, isi formulir dengan rinci seperti data diri, detail kerusakan dan unggah foto kerusakan jalan, lalu konfirmasi dan kirim laporan Anda. Setelah itu, laporan Anda akan diverifikasi oleh tim kami.'
            ],
            [
                'question' => 'Berapa lama proses verifikasi laporan?',
                'answer' => 'Proses verifikasi biasanya memakan waktu 1-3 hari kerja, tergantung pada jumlah laporan yang masuk dan tingkat kerusakan yang dilaporkan. Anda dapat memeriksa status laporan Anda di halaman <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a>.'
            ],
            [
                'question' => 'Bagaimana jika laporan saya belum ditindaklanjuti?',
                'answer' => 'Periksa status laporan Anda secara rutin melalui halaman <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a>. Status laporan Anda akan diperbarui secara berkala oleh petugas.'
            ],
            [
                'question' => 'Apakah ada batasan ukuran file untuk foto kerusakan?',
                'answer' => 'Ya, ukuran maksimum per file foto adalah 10MB. Pastikan Anda mengunggah foto dalam format JPEG, PNG, atau WEBP.'
            ],
            [
                'question' => 'Apa yang dimaksud dengan "Verifikasi" dalam alur proses?',
                'answer' => '"Verifikasi" adalah tahap dalam alur proses di mana petugas meninjau dan memastikan keakuratan serta kelengkapan laporan kerusakan jalan yang Anda ajukan sebelum menindaklanjutinya.'
            ],
            [
                'question' => 'Apa yang dimaksud dengan "Tindak Lanjut" dalam alur proses?',
                'answer' => 'Ini adalah tahap di mana Tim menangani laporan kerusakan jalan berdasarkan verifikasi.'
            ],
            [
                'question' => 'Apa saja yang perlu diisi saat membuat laporan?',
                'answer' => 'Anda perlu mengisi data diri yang meliputi nama lengkap, nomor ponsel yang dapat dihubungi, alamat tinggal, dan detail kerusakan jalan, seperti alamat lokasi kerusakan, deskripsi laporan, titik koordinat lokasi kerusakan, serta dokumentasi foto kerusakan jalan dengan maksimal 3 foto dengan maksimal ukuran foto 10MB.'
            ],
            [
                'question' => 'Bagaimana cara mengetahui status laporan saya?',
                'answer' => 'Cek status laporan Anda di halaman <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a> dengan memasukkan ID laporan atau nama jalan yang Anda laporkan di kolom pencarian, kemudian klik tombol “Cari”.'
            ],
            [
                'question' => 'Apa yang dimaksud dengan "Pending", "Belum Dikerjakan", "Sedang Dikerjakan", "Telah Dikerjakan", "Telah Disurvei", dan "Disposisi" pada status laporan saya?',
                'answer' => '<ul>
                                <li class="mb-2"><strong>Pending:</strong> Status ini berarti laporan Anda masih menunggu verifikasi dari admin. Kami sarankan untuk memeriksa pembaruan status secara berkala, karena petugas akan memperbarui informasi ini secara rutin.</li>
                                <li class="mb-2"><strong>Belum Dikerjakan:</strong> Status ini menunjukkan bahwa laporan kerusakan jalan Anda telah diterima dan saat ini masih masuk dalam daftar perbaikan yang akan segera ditangani.</li>
                                <li class="mb-2"><strong>Sedang Dikerjakan:</strong> Status ini berarti Tim UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda sedang menangani laporan kerusakan jalan Anda.</li>
                                <li class="mb-2"><strong>Telah Dikerjakan:</strong> Status ini menunjukkan laporan yang telah dilaporkan sudah diperbaiki.</li>
                                <li class="mb-2"><strong>Telah Disurvei:</strong> Status ini berarti Tim Survei UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda telah mengecek lokasi kerusakan jalan yang dilaporkan.</li>
                                <li class="mb-2"><strong>Disposisi:</strong> Status ini menunjukkan pekerjaan dari laporan tersebut bukan kewenangan UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda, dan laporan ini telah diteruskan kepada pihak yang berwenang untuk ditindaklanjuti. Status Disposisi ini juga menampilkan keterangan kemana laporan ini dialihkan.</li>
                           </ul>'
            ],
            [
                'question' => 'Bagaimana cara melihat peta sebaran laporan di web Jalan Peduli?',
                'answer' => 'Klik menu "Peta Laporan" di bagian bawah halaman utama untuk melihat distribusi laporan kerusakan jalan yang telah masuk.'
            ],
            [
                'question' => 'Apa yang ditampilkan di peta sebaran laporan?',
                'answer' => 'Peta menunjukkan titik lokasi kerusakan jalan yang pernah dilaporkan dengan tanda berdasarkan tingkat kerusakan dan status pengerjaan. Klik titik lokasi yang sudah ada untuk melihat detail laporannya.'
            ],
            [
                'question' => 'Bagaimana cara mencari laporan tertentu di web Jalan Peduli?',
                'answer' => 'Kunjungi menu <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a> maupun menu <a href="' . route('laporan.public.map') . '" class="inline-flex items-center px-4 py-2 mt-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all duration-300">Lihat Peta Laporan</a> untuk menggunakan Filter Pencarian Laporan dengan ID laporan atau nama jalan, lalu klik "Cari".'
            ],
            [
                'question' => 'Apakah saya bisa melihat statistik laporan masuk di web Jalan Peduli?',
                'answer' => 'Ya, statistik jumlah laporan tersedia di halaman Peta Laporan. Klik tombol “Statistik” untuk menuju halaman Statistik Laporan yang informatif.'
            ],
            [
                'question' => 'Apa yang dimaksud dengan "Ringkasan laporan infrastruktur terkini" di halaman Peta Laporan?',
                'answer' => 'Ini adalah ringkasan jumlah laporan kerusakan jalan berdasarkan status terkini.'
            ],
            [
                'question' => 'Bagaimana cara mengulangi pengisian form laporan?',
                'answer' => 'Klik "Reset Form" di halaman form pengaduan untuk mengosongkan data dan mengisi ulang.'
            ],
            [
                'question' => 'Apakah laporan kerusakan jalan saya akan diverifikasi?',
                'answer' => 'Ya, setiap laporan akan melalui proses verifikasi sebelum ditindaklanjuti.'
            ],
            [
                'question' => 'Bisakah saya melaporkan lebih dari satu kerusakan jalan?',
                'answer' => 'Ya, buat laporan terpisah untuk setiap lokasi kerusakan jalan.'
            ],
            [
                'question' => 'Apakah ada batas waktu untuk melaporkan kerusakan jalan?',
                'answer' => 'Tidak ada batas waktu, laporkan kapan saja melalui web Jalan Peduli.'
            ],
            [
                'question' => 'Apa yang harus dilakukan jika ada kesalahan data di laporan?',
                'answer' => 'Anda dapat mengajukan ulang laporan dengan informasi yang lebih lengkap atau menghubungi kami untuk klarifikasi lebih lanjut.'
            ],
            [
                'question' => 'Bagaimana cara tahu kapan laporan kerusakan jalan saya diperbarui?',
                'answer' => 'Tanggal pembaruan status ditampilkan pada setiap laporan di halaman <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a>.'
            ],
            [
                'question' => 'Apakah saya perlu login untuk menggunakan web Jalan Peduli?',
                'answer' => 'Anda tidak perlu login untuk memudahkan penggunaan web Jalan Peduli. Anda dapat langsung melaporkan atau mengecek laporan tanpa login. Fitur login hanya diperuntukkan bagi petugas pengelola laporan.'
            ],
            [
                'question' => 'Bisakah saya melihat laporan orang lain?',
                'answer' => 'Ya, Anda dapat melihatnya melalui tombol <a href="' . route('laporan.data') . '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">Cek Status</a> maupun tombol “Lihat Peta” untuk melihat jalan mana saja telah dilaporkan oleh orang lain.'
            ],
            [
                'question' => 'Apa yang harus dilakukan jika web Jalan Peduli bermasalah?',
                'answer' => 'Refresh halaman atau hubungi petugas melalui tombol "Hubungi Kami" yang terletak dibagian bawah halaman FAQ ini jika masalah berlanjut.'
            ],
            [
                'question' => 'Apakah foto wajib disertakan untuk laporan kerusakan jalan?',
                'answer' => 'Ya, karena foto yang dilampirkan juga merupakan bagian dari verifikasi.'
            ],
            [
                'question' => 'Bagaimana cara mendapatkan jawaban terkait pertanyaan saya atau bantuan lebih lanjut di web Jalan Peduli?',
                'answer' => 'Hubungi petugas via WhatsApp melalui tombol "Hubungi Kami" di bawah halaman FAQ ini atau cek FAQ untuk pertanyaan umum.'
            ],
            [
                'question' => 'Bagaimana jika kerusakan jalan yang saya laporkan memiliki tingkat kerusakan berat ataupun status jalan tersebut bukan jalan kota, apakah masih dapat dilaporkan melalui web Jalan Peduli ini?',
                'answer' => 'Ya, web Jalan Peduli memfasilitasi pelaporan kerusakan jalan dengan segala tingkat. Setiap laporan akan disertai keterangan mengenai disposisi pekerjaan, dan apabila tidak termasuk dalam lingkup tugas UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda, laporan tersebut akan diteruskan kepada pihak yang berwenang.'
            ],
        ];


        $faqsArrayToProcess = $baseFaqsData;

        // Logika pencarian server-side
        if ($request->filled('search')) {
            $searchQuery = strtolower($request->search);
            $faqsArrayToProcess = array_filter($baseFaqsData, function ($faq) use ($searchQuery) {
                return strpos(strtolower($faq['question']), $searchQuery) !== false ||
                       strpos(strtolower(strip_tags($faq['answer'])), $searchQuery) !== false; // strip_tags untuk mencari di konten jawaban HTML
            });
            // Re-index array setelah filter
            $faqsArrayToProcess = array_values($faqsArrayToProcess);
        }

        // Logika Paginasi manual
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage('page');
        $totalItems = count($faqsArrayToProcess);
        $currentPageItems = array_slice($faqsArrayToProcess, ($currentPage - 1) * $perPage, $perPage);

        // Membuat instance LengthAwarePaginator
        $faqs = new LengthAwarePaginator(
            $currentPageItems,
            $totalItems,
            $perPage,
            $currentPage,
            [
                'path' => Paginator::resolveCurrentPath(),
                'query' => $request->query(), // Memastikan parameter pencarian tetap ada di link paginasi
            ]
        );
        
        return view('guest.pages.jalan-peduli.laporan.faq', [
			'meta_description' => 'Buat Laporan Jalan Peduli - Layanan pelaporan kerusakan jalan di Kota Samarinda.',
			'page_title' => 'Buat Laporan Jalan Peduli'
		], compact('faqs'));
    }
}
