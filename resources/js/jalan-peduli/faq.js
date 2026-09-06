document.addEventListener('DOMContentLoaded', function () {
    const faqContainer = document.getElementById('faqAccordion');
    
    const toggleAccordion = (button, forceOpen = null) => {
        const content = document.getElementById(button.getAttribute('aria-controls'));
        const icon = button.querySelector('i.fa-chevron-down');
        const item = button.closest('.faq-item');
        const isOpening = (forceOpen !== null) ? forceOpen : button.getAttribute('aria-expanded') === 'false';

        button.setAttribute('aria-expanded', isOpening);
        icon.classList.toggle('rotate-180', isOpening);
        item.classList.toggle('border-blue-500', isOpening);
        item.classList.toggle('shadow-lg', isOpening);
        
        if (content) {
            if (isOpening) {
                content.classList.remove('hidden');
                requestAnimationFrame(() => {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.style.opacity = '1';
                });
            } else {
                content.style.maxHeight = '0px';
                content.style.opacity = '0';
                // Tunggu transisi selesai sebelum menambahkan class 'hidden'
                setTimeout(() => {
                    if (button.getAttribute('aria-expanded') === 'false') {
                        content.classList.add('hidden');
                        content.style.maxHeight = ''; // Reset style untuk pembukaan selanjutnya
                    }
                }, 500); // Durasi harus cocok dengan durasi transisi di CSS
            }
        }
    };
    
    const closeAllAccordions = (exceptButton = null) => {
        const faqItems = faqContainer.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const button = item.querySelector('.faq-button');
            if (button !== exceptButton && button.getAttribute('aria-expanded') === 'true') {
                toggleAccordion(button, false);
            }
        });
    };

    const initializeAccordions = () => {
        if (!faqContainer) return;
        const faqButtons = faqContainer.querySelectorAll('.faq-button');
        faqButtons.forEach(button => {
            button.removeEventListener('click', handleAccordionClick);
            button.addEventListener('click', handleAccordionClick);
        });
    };

    const handleAccordionClick = (event) => {
        const button = event.currentTarget;
        const isCurrentlyOpen = button.getAttribute('aria-expanded') === 'true';
        closeAllAccordions(button); 
        toggleAccordion(button, !isCurrentlyOpen);
    };

    initializeAccordions();

    const openContactModalBtn = document.getElementById('openContactModalBtn');
    const contactModal = document.getElementById('contactModal');
    const closeContactModalBtn = document.getElementById('closeContactModalBtn');
    const sendToWhatsAppBtn = document.getElementById('sendToWhatsAppBtn');
    const whatsappPhoneNumber = "6282252544708";
    const formStatus = document.getElementById('formStatusMessage');

    if (openContactModalBtn && contactModal) {
        openContactModalBtn.addEventListener('click', () => {
            contactModal.classList.remove('hidden');
            requestAnimationFrame(() => {
                const modalContent = contactModal.querySelector('#modalContent');
                if (modalContent) {
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                }
            });
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeContactModalBtn && contactModal) {
        const closeModal = () => {
            const modalContent = contactModal.querySelector('#modalContent');
            if (modalContent) {
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
            }
            setTimeout(() => {
                contactModal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300); 
        };

        closeContactModalBtn.addEventListener('click', closeModal);

        contactModal.addEventListener('click', (e) => {
            if (e.target === contactModal) {
                closeModal();
            }
        });
    }

    if (sendToWhatsAppBtn && contactModal) {
        sendToWhatsAppBtn.addEventListener('click', () => {
            const nameInput = document.getElementById('contactName');
            const emailInput = document.getElementById('contactEmail');
            const categorySelect = document.getElementById('contactCategory');
            const messageTextarea = document.getElementById('contactMessage');
            
            if(formStatus) {
                formStatus.classList.add('hidden');
                formStatus.textContent = '';
                formStatus.className = 'block p-4 mb-4 text-sm rounded-lg hidden'; 
            }

            [nameInput, emailInput, categorySelect, messageTextarea].forEach(el => el.classList.remove('border-red-500'));

            const name = nameInput.value.trim();
            const email = emailInput.value.trim();
            const category = categorySelect.value;
            const message = messageTextarea.value.trim();
            
            let errors = [];
            if (!name) { errors.push({ field: nameInput, msg: 'Nama' }); }
            if (!category) { errors.push({ field: categorySelect, msg: 'Kategori' }); }
            if (!message) { errors.push({ field: messageTextarea, msg: 'Pesan' }); }

            if (errors.length > 0) {
                if(formStatus) {
                    formStatus.textContent = `Kolom berikut wajib diisi: ${errors.map(e => e.msg).join(', ')}.`;
                    formStatus.classList.remove('hidden');
                    formStatus.className = 'block p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400';
                }
                errors.forEach(err => err.field.classList.add('border-red-500'));
                return;
            }

            if(formStatus) {
                formStatus.textContent = 'Membuka WhatsApp...';
                formStatus.classList.remove('hidden');
                formStatus.className = 'block p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400';
            }

            const formattedMessage = `*Jalan Peduli Butuh Bantuan* 📣\n\n*Nama:* ${name}\n*Email:* ${email}\n*Kategori Bantuan:* ${category}\n\n*Pesan:*\n${message}\n\n---\n_Pesan ini dikirim melalui form Bantuan & Informasi._`;

            const whatsappUrl = `https://api.whatsapp.com/send?phone=${whatsappPhoneNumber}&text=${encodeURIComponent(formattedMessage)}`;
            window.open(whatsappUrl, '_blank');

            setTimeout(() => {
                if(formStatus) formStatus.classList.add('hidden');
                contactModal.querySelector('form').reset();
                closeContactModalBtn.click(); 
            }, 2000);
        });
    }
});