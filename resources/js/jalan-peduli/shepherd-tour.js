document.addEventListener('DOMContentLoaded', () => {

    // Memberi jeda untuk memastikan semua elemen selesai dimuat.
    setTimeout(() => {
        // Fungsi untuk memvalidasi bahwa semua elemen target tur ada di halaman.
        const validateSteps = (steps) => {
            return steps.filter(step => {
                const targetElement = document.querySelector(step.target);
                if (!targetElement) {
                    console.warn(`Elemen target untuk tur tidak ditemukan: ${step.target}`);
                    return false;
                }
                const rect = targetElement.getBoundingClientRect();
                return rect.width > 0 && rect.height > 0;
            });
        };

        /**
         * FUNGSI KUNCI PERBAIKAN:
         * Mengecek apakah sebuah elemen sepenuhnya terlihat dalam viewport (area pandang layar).
         * @param {Element} el - Elemen HTML yang akan dicek.
         * @returns {boolean} - True jika elemen sepenuhnya terlihat, false jika tidak.
         */
        const isElementFullyVisible = (el) => {
            const rect = el.getBoundingClientRect();
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
            
            // Cek apakah privacy notification aktif
            const privacyNotif = document.getElementById('privacy-notif');
            const isPrivacyVisible = privacyNotif && privacyNotif.style.display === 'flex';
            const privacyHeight = isPrivacyVisible ? (privacyNotif.offsetHeight || 80) : 0;
            
            // Kurangi viewport height dengan tinggi privacy notification jika ada
            const adjustedViewportHeight = viewportHeight - privacyHeight;

            // Memastikan seluruh sisi elemen (atas, bawah, kiri, kanan) berada dalam viewport yang sudah disesuaikan.
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= adjustedViewportHeight &&
                rect.right <= viewportWidth
            );
        };

        // Fungsi untuk mengatur style tour guide agar tidak bertabrakan dengan privacy notification
        function adjustTourGuidePosition() {
            var privacyNotif = document.getElementById('privacy-notif');
            var isPrivacyVisible = privacyNotif && privacyNotif.style.display === 'flex';
            var privacyHeight = isPrivacyVisible ? (privacyNotif.offsetHeight || 80) : 0;
            var existingStyle = document.getElementById('tour-guide-adjustment');
            if (existingStyle) existingStyle.remove();
            var style = document.createElement('style');
            style.id = 'tour-guide-adjustment';
            style.textContent = `
                .tg-dialog {
                    z-index: 9999 !important;
                }
                .tg-dialog.tg-dialog--bottom {
                    margin-bottom: ${privacyHeight + (isPrivacyVisible ? 24 : 12)}px !important;
                }
                .tg-overlay {
                    z-index: 9998 !important;
                }
            `;
            document.head.appendChild(style);
        }

        // Definisikan langkah-langkah tur
        const steps = [
            {
                target: '.create-report-button',
                title: 'Buat Laporan',
                content: 'Jika Anda menemukan kerusakan jalan atau masalah lainnya, klik di sini untuk membuat laporan baru.',
                placement: 'bottom',
            },
            {
                target: '.check-report-button',
                title: 'Cek Laporan',
                content: 'Gunakan tombol ini untuk melihat status dan perkembangan dari laporan yang sudah Anda buat.',
                placement: 'bottom',
            },
            {
                target: '.map-report-button',
                title: 'Lihat Peta Laporan',
                content: 'Lihat sebaran semua laporan kerusakan jalan dalam tampilan peta interaktif.',
                placement: 'bottom',
            },
            {
                target: '.faq-button',
                title: 'Bantuan & FAQ',
                content: 'Temukan jawaban untuk pertanyaan yang sering diajukan mengenai proses pelaporan di sini.',
                placement: 'bottom',
            }
        ];

        const validSteps = validateSteps(steps);

        if (validSteps.length === 0) {
            console.warn('Tur tidak dapat dimulai karena tidak ada langkah yang valid.');
            return;
        }

        // Adjust tour guide position untuk privacy notification
        adjustTourGuidePosition();
        // Monitor perubahan privacy notification
        var privacyNotif = document.getElementById('privacy-notif');
        if (privacyNotif) {
            var observer = new MutationObserver(function() {
                setTimeout(adjustTourGuidePosition, 100);
            });
            observer.observe(privacyNotif, { attributes: true, attributeFilter: ['style'] });
            var closeBtn = document.getElementById('privacy-notif-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    setTimeout(adjustTourGuidePosition, 200);
                });
            }
        }
        // Inisialisasi TourGuide.js
        var tg = new tourguide.TourGuideClient({
            nextLabel: 'Berikutnya',
            prevLabel: 'Kembali',
            finishLabel: 'Selesai',
            exitOnEscape: true,
            exitOnClickOutside: true,
            offset: 15,
            zIndex: 9999,
            onBeforeStepChange: function(step) {
                return new Promise(function(resolve) {
                    adjustTourGuidePosition();
                    var targetElement = document.querySelector(step.target);
                    if (targetElement) {
                        if (isElementFullyVisible(targetElement)) {
                            setTimeout(resolve, 50);
                            return;
                        }
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
                        var privacyNotif2 = document.getElementById('privacy-notif');
                        var isPrivacyVisible2 = privacyNotif2 && privacyNotif2.style.display === 'flex';
                        if (isPrivacyVisible2) {
                            setTimeout(function() {
                                var privacyHeight2 = privacyNotif2.offsetHeight || 80;
                                window.scrollBy(0, -(privacyHeight2 + 24));
                            }, 300);
                        }
                        setTimeout(resolve, 600);
                    } else {
                        resolve();
                    }
                });
            },
            onStart: function() {
                setTimeout(adjustTourGuidePosition, 100);
            },
            onAfterStepChange: function() {
                setTimeout(adjustTourGuidePosition, 100);
            },
            steps: validSteps
        });

        // LOGIKA SEBELUM MEMULAI TUR
        if (validSteps.length > 0) {
            const firstElement = document.querySelector(validSteps[0].target);
            if (firstElement) {
                // Cek apakah elemen pertama sudah sepenuhnya terlihat saat halaman dimuat.
                if (isElementFullyVisible(firstElement)) {
                    // Jika ya, langsung mulai tur tanpa scroll awal.
                    console.log('Elemen pertama sudah terlihat. Memulai tur tanpa scroll.');
                    tg.start();
                } else {
                    // Jika tidak (misalnya di halaman yang panjang), scroll dulu baru mulai.
                    console.log('Elemen pertama tidak terlihat. Melakukan scroll sebelum memulai tur.');
                    
                    // Cek privacy notification untuk initial scroll
                    const privacyNotif = document.getElementById('privacy-notif');
                    const isPrivacyVisible = privacyNotif && privacyNotif.style.display === 'flex';
                    
                    firstElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                    
                    setTimeout(() => {
                        // Adjustment untuk privacy notification
                        if (isPrivacyVisible) {
                            const privacyHeight = privacyNotif.offsetHeight || 80;
                            const additionalOffset = 50;
                            window.scrollBy(0, -(privacyHeight + additionalOffset));
                        }
                        
                        // Mulai tour setelah adjustment
                        setTimeout(() => {
                            tg.start();
                        }, 200);
                    }, 400); // Tunggu scroll utama selesai
                }
            }
        }

    }, 500);
});