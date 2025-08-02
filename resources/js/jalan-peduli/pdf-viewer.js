document.addEventListener('DOMContentLoaded', function () {
    // --- ELEMEN MODAL ---
    const pdfModalElement = document.getElementById('pdfModal');
    const openPdfModalBtn = document.getElementById('openPdfModalBtn');
    const closePdfModalBtn = document.getElementById('closePdfModalBtn');
    const pdfIframe = document.getElementById('pdf-iframe'); // Kita gunakan iframe lagi
    
    // Elemen untuk modal peringatan
    const adBlockWarningModal = document.getElementById('adBlockWarningModal');
    const retryPdfBtn = document.getElementById('retryPdfBtn');
    const closeAdBlockWarningBtn = document.getElementById('closeAdBlockModalBtn');
    
    // --- URL GOOGLE DRIVE (Disesuaikan untuk Embedding) ---
    const fileId = '1hsZQWloo3d5KgUfPO0MvOvowUkUqErPg';
    const embedUrl = `https://drive.google.com/file/d/${fileId}/preview`;

    // --- LOGIKA DETEKSI AD BLOCKER (Tidak diubah) ---
    async function detectAdBlock() {
        try {
            await fetch('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', {
                method: 'HEAD', mode: 'no-cors', cache: 'no-store'
            });
            return false;
        } catch (error) {
            console.warn('Ad blocker detected.');
            return true;
        }
    }

    // --- FUNGSI MODAL HANDLING ---
    function openPdfModal() {
        pdfModalElement.classList.remove('hidden');
        if (pdfIframe.src !== embedUrl) {
            pdfIframe.src = embedUrl; // Set source iframe ke URL preview Google Drive
        }
    }

    function closePdfModal() {
        pdfModalElement.classList.add('hidden');
        pdfIframe.src = 'about:blank'; // Kosongkan iframe saat ditutup untuk hemat resource
    }

    function openWarningModal() {
        adBlockWarningModal?.classList.remove('hidden');
    }
    
    function closeWarningModal() {
        adBlockWarningModal?.classList.add('hidden');
    }

    // Fungsi utama saat tombol panduan diklik
    async function handleOpenGuideClick() {
        const isAdBlocked = await detectAdBlock();
        if (isAdBlocked) {
            openWarningModal();
        } else {
            openPdfModal();
        }
    }

    // --- EVENT LISTENERS ---
    openPdfModalBtn?.addEventListener('click', handleOpenGuideClick);
    closePdfModalBtn?.addEventListener('click', closePdfModal);
    retryPdfBtn?.addEventListener('click', () => {
        closeWarningModal();
        handleOpenGuideClick();
    });
    closeAdBlockWarningBtn?.addEventListener('click', closeWarningModal);
});