const stepsData = [
    { id: 1, icon: 'fa-pencil-alt', label: 'Tulis Laporan' },
    { id: 2, icon: 'fa-arrow-right', label: 'Proses Verifikasi' },
    { id: 3, icon: 'fa-comments', label: 'Tindak Lanjut' },    
    { id: 4, icon: 'fa-check', label: 'Selesai' },
];

let currentStepIndex = 0;
let animationTimeout;
let isAnimating = false;

// Fungsi untuk mendapatkan elemen stepper berdasarkan nomor langkah
function getStepElements(stepNumber) {
    const stepItems = document.querySelectorAll(`.step-item[data-step="${stepNumber}"]`);
    const circles = document.querySelectorAll(`.step-item[data-step="${stepNumber}"] .step-circle`);
    const iconElements = document.querySelectorAll(`.step-item[data-step="${stepNumber}"] .step-icon-element`);
    const labels = document.querySelectorAll(`.step-item[data-step="${stepNumber}"] .step-label`);
    const connectors = document.querySelectorAll(`[data-connector="${stepNumber}"]`);
    
    return { stepItems, circles, iconElements, labels, connectors };
}

// Fungsi untuk mengatur ulang semua langkah ke kondisi awal
function resetAllSteps() {
    stepsData.forEach((step) => {
        const { stepItems, circles, iconElements, labels, connectors } = getStepElements(step.id);

        stepItems.forEach(stepItem => {
            stepItem.classList.remove('step-active', 'step-completed');
        });

        circles.forEach(circle => {
            anime.remove(circle);
            circle.style.backgroundColor = '#ffffff';
            circle.style.borderColor = '#d1d5db';
            circle.style.transform = 'scale(1)';
            circle.style.boxShadow = '';
        });

        iconElements.forEach((iconElement, index) => {
            anime.remove(iconElement);
            iconElement.style.color = '#9ca3af';
            iconElement.style.transform = 'rotate(0deg) scale(1)';
            // Mengatur ulang kelas ikon secara dinamis berdasarkan data
            iconElement.className = `fa-solid ${step.icon} step-icon-element`;
        });

        labels.forEach(label => {
            anime.remove(label);
            label.style.color = '#6b7280';
            label.style.fontWeight = '600';
            label.style.opacity = '0.5';
            label.style.transform = 'translateY(10px)';
        });

        connectors.forEach(connector => {
            connector.classList.remove('active');
        });
    });
    currentStepIndex = 0;
}

// Fungsi untuk menganimasikan saat ini aktif
function activateStep(stepNumber) {
    const { stepItems, circles, iconElements, labels, connectors } = getStepElements(stepNumber);

    stepItems.forEach(stepItem => {
        stepItem.classList.remove('step-completed');
        stepItem.classList.add('step-active');
    });

    // Animasikan circle
    circles.forEach(circle => {
        anime({
            targets: circle,
            scale: [1, 1.2, 1],
            backgroundColor: '#f9a825',
            borderColor: '#1a237e',
            duration: 800,
            easing: 'easeOutElastic(1, .8)',
        });
    });

    // Animasikan icon
    iconElements.forEach(iconElement => {
        anime({
            targets: iconElement,
            color: '#ffffff',
            rotate: 360,
            scale: [1, 1.1, 1],
            duration: 600,
            easing: 'easeInOutQuad'
        });
    });

    // Animasikan label
    labels.forEach(label => {
        anime({
            targets: label,
            color: '#1a237e',
            fontWeight: 700,
            opacity: 1,
            translateY: 0,
            duration: 400,
            easing: 'easeOutQuad'
        });
    });

    // Animasikan konektor
    connectors.forEach(connector => {
        connector.classList.add('active');
    });
}

// Fungsi untuk menandai langkah sebagai selesai
function completeStep(stepNumber) {
    const { stepItems, circles, iconElements, labels } = getStepElements(stepNumber);

    stepItems.forEach(stepItem => {
        stepItem.classList.remove('step-active');
        stepItem.classList.add('step-completed');
    });

    // Animasikan circle ke warna hijau
    circles.forEach(circle => {
        anime({
            targets: circle,
            backgroundColor: '#22c55e',
            borderColor: '#22c55e',
            scale: 1,
            duration: 400,
            easing: 'easeOutQuad'
        });
    });

    // Animasikan icon menjadi ikon centang
    iconElements.forEach(iconElement => {
        // Hanya ubah jika ikon belum berupa centang
        if (!iconElement.className.includes('fa-check')) {
            anime({
                targets: iconElement,
                opacity: [1, 0],
                scale: [1, 0.5],
                duration: 200,
                easing: 'easeOutQuad',
                complete: function() {
                    iconElement.className = `fa-solid fa-check step-icon-element`; // Ganti dengan ikon centang
                    anime({
                        targets: iconElement,
                        opacity: [0, 1],
                        scale: [0.5, 1],
                        color: '#ffffff', // Warna ikon centang
                        duration: 300,
                        easing: 'easeOutBack'
                    });
                }
            });
        } else {
            // Jika sudah centang, hanya pastikan warnanya benar
            anime({
                targets: iconElement,
                color: '#ffffff',
                duration: 400,
                easing: 'easeOutQuad'
            });
        }
    });

    // Animasikan label ke warna hijau
    labels.forEach(label => {
        anime({
            targets: label,
            color: '#22c55e',
            fontWeight: 700,
            duration: 400,
            easing: 'easeOutQuad'
        });
    });
}

// Fungsi untuk menjalankan urutan animasi
function startAnimationSequence() {
    if (isAnimating) return;
    isAnimating = true;

    resetAllSteps();
    currentStepIndex = 0;

    function animateNext() {
        if (currentStepIndex < stepsData.length) {
            const currentStepData = stepsData[currentStepIndex];
            activateStep(currentStepData.id);

            animationTimeout = setTimeout(() => {
                completeStep(currentStepData.id);
                currentStepIndex++;
                
                if (currentStepIndex < stepsData.length) {
                    // Beri jeda sebelum mengaktifkan langkah berikutnya
                    setTimeout(animateNext, 800);
                } else {
                    // Setelah langkah terakhir selesai, ulangi urutan setelah jeda
                    setTimeout(() => {
                        isAnimating = false;
                        startAnimationSequence();
                    }, 2000);
                }
            }, 2000); // Jeda selama 2 detik untuk setiap langkah aktif
        }
    }

    animateNext();
}

// Fungsi untuk mereset animasi secara manual dari tombol
function resetAnimation() {
    if (animationTimeout) {
        clearTimeout(animationTimeout);
    }
    isAnimating = false;
    resetAllSteps();
    // Beri jeda sedikit sebelum memulai animasi ulang agar reset terlihat
    setTimeout(() => {
        startAnimationSequence();
    }, 500);
}

// Mulai animasi saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan anime.js sudah ter-load sebelum menjalankan animasi
    if (typeof anime !== 'undefined') {
        setTimeout(() => {
            startAnimationSequence();
        }, 1000); // Beri jeda sedikit agar visual loading awal lebih baik
    } else {
        console.error('Anime.js library not loaded');
    }
});