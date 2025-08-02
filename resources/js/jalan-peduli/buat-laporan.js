// =========================================================================
// Kode Javascript untuk Form Laporan (FINAL)
// =========================================================================

document.addEventListener('DOMContentLoaded', function() {
    // =========================================================================
    // Definisi Variabel dan Fungsi Global di dalam Scope DOMContentLoaded
    // =========================================================================

    // cek model
    let model;
    class L2Regularizer {
        constructor(config) {
            this.l2 = config.l2;
        }
        apply(x) {
            return tf.mul(this.l2, tf.sum(tf.square(x)));
        }
        getConfig() {
            return { l2: this.l2 };
        }
        static className = 'L2';
    }
    tf.serialization.registerClass(L2Regularizer);

    tf.loadLayersModel('/model/model.json')
        .then(loadedModel => {
            model = loadedModel;
        })


    let currentStep = 1;
    const FORM_STORAGE_KEY = 'laporanFormState';
    const STEP_STORAGE_KEY = 'laporanFormCurrentStep';
    let saveTimer;
    let uploadedFiles = [];
    let map, marker, selectedLatLng;
    const kirimLaporanBtn = document.getElementById('kirimLaporanBtn');

    const gunakanLokasiBtn = document.getElementById("gunakanLokasiBtn");
    const mapModalElement = document.getElementById("mapModal");
    const btnPilihLokasi = document.getElementById("pilihLokasiBtn");
    const simpanBtn = document.getElementById("simpanLokasiBtn");
    const closeMapModalBtn = document.getElementById("closeMapModalBtn");
    const cancelMapModalBtn = document.getElementById("cancelMapModalBtn");
    const searchButton = document.getElementById("searchButton");
    const addressSearch = document.getElementById("addressSearch");
    const phoneInput = document.getElementById('nomor_ponsel');
    const resetFormButton = document.getElementById('resetFormBtn');
    const form = document.getElementById('laporanForm');

    function clearClientStorage() {
        localStorage.removeItem(FORM_STORAGE_KEY);
        localStorage.removeItem(STEP_STORAGE_KEY);
    }
    
    // Cek apakah ada notifikasi sukses di halaman.
    const successNotification = document.getElementById('success-notification-block');
    if (successNotification) {
        clearClientStorage();
    } else {
        updatePreview(); 
        loadFormData();
    }

    // =========================================================================
    // Logika Geolokasi & Peta
    // =========================================================================
    const openMapModal = () => {
        if (mapModalElement) {
            mapModalElement.classList.remove('hidden');
            setTimeout(initMap, 50);
        }
    };

    const closeMapModal = () => {
        if (mapModalElement) mapModalElement.classList.add('hidden');
    };

    async function fetchAddressFromCoordinates(lat, lng) {
        const alamatInput = document.getElementById('alamat_lengkap_kerusakan');
        const kecamatanSelect = document.getElementById('lokasi_kecamatan_id');
        const kelurahanSelect = document.getElementById('lokasi_kelurahan_id');
        if (!alamatInput || !kecamatanSelect || !kelurahanSelect) return;

        alamatInput.placeholder = 'Mencari nama jalan, kecamatan, dan kelurahan...';
        alamatInput.classList.remove('bg-gray-100');
        alamatInput.readOnly = false;

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&accept-language=id`);
            if (!response.ok) throw new Error('Gagal menghubungi server geocoding.');
            const data = await response.json();
            if (data && data.address) {
                const address = data.address;
                alamatInput.value = address.road || 'Nama jalan tidak ditemukan dari peta.';
                alamatInput.title = `Alamat ini diisi otomatis dari peta: ${data.display_name}. Anda dapat mengubahnya.`;
                alamatInput.placeholder = 'Alamat Lengkap Lokasi Kerusakan';

                const kecamatanName = address.city_district || address.suburb || address.county;
                let kecamatanFound = false;
                if (kecamatanName) {
                    for (let option of kecamatanSelect.options) {
                        if (option.text.toLowerCase().includes(kecamatanName.toLowerCase())) {
                            kecamatanSelect.value = option.value;
                            kecamatanFound = true;
                            break;
                        }
                    }
                }
                if (kecamatanFound) {
                    await fetchKelurahan(kecamatanSelect.value, kelurahanSelect, null, address.village || address.hamlet);
                } else {
                    kelurahanSelect.innerHTML = '<option value="">-- Kecamatan tidak cocok, pilih manual --</option>';
                    kelurahanSelect.disabled = false;
                }
            } else {
                alamatInput.placeholder = 'Gagal mendapatkan data alamat. Silakan isi manual.';
            }
        } catch (error) {
            console.error("Reverse geocoding error:", error);
            alert("Gagal mendapatkan nama jalan otomatis. Anda bisa mengisinya secara manual.");
            alamatInput.placeholder = 'Alamat Lengkap Lokasi Kerusakan';
        } finally {
            alamatInput.readOnly = false;
            alamatInput.classList.remove('bg-gray-100');
        }
    }

    function initMap() {
        if (!document.getElementById('map')) return;

        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        });

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles © Esri'
        });

        if (!map) {
            map = L.map('map', {
                center: [-0.502106, 117.153709],
                zoom: 13,
                layers: [osmLayer] // default layer saat pertama kali
            });

            // Layer control (dropdown di kanan atas)
            const baseMaps = {
                "OpenStreetMap": osmLayer,
                "Satelit (Esri)": satelliteLayer
            };

            L.control.layers(baseMaps).addTo(map);

            map.on('click', (e) => updateSelectedLocation(e.latlng));
        } else {
            map.invalidateSize();
        }

        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        if (lat && lng) {
            const latLng = L.latLng(parseFloat(lat), parseFloat(lng));
            updateSelectedLocation(latLng);
            map.setView(latLng, 15);
        }
    }


    function updateSelectedLocation(latLng) {
        selectedLatLng = latLng;
        if (marker) map.removeLayer(marker);
        marker = L.marker(selectedLatLng).addTo(map).bindPopup("Lokasi terpilih.").openPopup();
        map.panTo(selectedLatLng);
    }

    // =========================================================================
    // Logika Form (Simpan, Muat, Validasi, Submit)
    // =========================================================================
    window.saveFormData = function() {
        clearTimeout(saveTimer);
        saveTimer = setTimeout(() => {
            if (!form) return;
            if (!document.getElementById('success-notification-block')) {
                const formData = {};
                form.querySelectorAll('input, textarea, select').forEach(field => {
                    if (field.name && field.type !== 'file' && field.name !== '_token' && field.name !== 'cf-turnstile-response') {
                        formData[field.id || field.name] = field.value;
                    }
                });
                localStorage.setItem(FORM_STORAGE_KEY, JSON.stringify(formData));
                localStorage.setItem(STEP_STORAGE_KEY, currentStep.toString());
            }
        }, 300);
    };
    
    async function loadFormData() {
        const storedData = localStorage.getItem(FORM_STORAGE_KEY);
        let ratingValue = document.getElementById('rating_kepuasan').value || 1;
        if (form && storedData) {
            const formData = JSON.parse(storedData);
            Object.keys(formData).forEach(key => {
                const field = document.getElementById(key) || document.getElementsByName(key)[0];
                if (field) field.value = formData[key];
            });
            const [kec1, kel1, kec2, kel2] = [
                document.getElementById('kecamatan_id'), document.getElementById('kelurahan_id'),
                document.getElementById('lokasi_kecamatan_id'), document.getElementById('lokasi_kelurahan_id')
            ];
            if (kec1 && kec1.value) await fetchKelurahan(kec1.value, kel1, formData.kelurahan_id);
            if (kec2 && kec2.value) await fetchKelurahan(kec2.value, kel2, formData.lokasi_kelurahan_id);
            
            // [MODIFIKASI] Gunakan nilai dari formData jika ada
            if(formData.rating_kepuasan) {
                ratingValue = formData.rating_kepuasan;
            }
            
            const storedStep = localStorage.getItem(STEP_STORAGE_KEY);
            currentStep = storedStep ? parseInt(storedStep) : 1;
            // Panggil showStep tanpa animasi saat load awal
            showStep(currentStep, false); 
        }

        // Panggil updateStars di akhir dengan nilai yang sudah ditentukan
        updateStars(parseInt(ratingValue));
    }
    function updateStepperUI(step) {
        const totalSteps = 3; // Asumsikan ada 3 step
        const stepperItems = document.querySelectorAll('.stepper-item');
        stepperItems.forEach((item, index) => {
            let stepNum = index + 1;
            if (stepNum === step) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else if (stepNum < step) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else {
                item.classList.remove('active', 'completed');
            }
        });

        // Animate the progress bar
        const progressBar = document.getElementById('stepper-progress-bar');
        // Hitung persentase progress bar dengan benar, pastikan tidak di 0% untuk step 1
        const progressPercentage = step > 1 ? ((step - 1) / (totalSteps - 1)) * 100 : 0; 

        if (progressBar) {
            anime({
                targets: progressBar,
                width: progressPercentage + '%',
                duration: 0, // Set duration ke 0 agar langsung tampil tanpa animasi
                easing: 'easeInOutQuad'
            });
        }
    }

    function clearFormData() {
        localStorage.removeItem(FORM_STORAGE_KEY);
        localStorage.removeItem(STEP_STORAGE_KEY);
    }
    
        
    function updatePreview() {
        const previewContainer = document.getElementById('preview_container');
        const input = document.getElementById('foto_kerusakan');
        const uploadBox = document.getElementById('upload_box');
        if (!previewContainer || !input || !uploadBox) return;

        previewContainer.querySelectorAll('.image-preview-wrapper').forEach(el => el.remove());
        const dataTransfer = new DataTransfer();
        
        uploadedFiles.forEach((file, index) => {
            dataTransfer.items.add(file);
            const wrapper = document.createElement('div');
            wrapper.className = 'image-preview-wrapper relative shrink-0';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-24 h-24 object-cover rounded-md shadow-sm border border-gray-200';
            img.onload = () => URL.revokeObjectURL(img.src);
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.title = 'Hapus Foto';
            removeBtn.className = 'absolute -top-2 -right-2 w-6 h-6 flex items-center justify-center rounded-full bg-red-600 text-white hover:bg-red-700 transition-colors duration-150 shadow-md border-2 border-white z-10';
            removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`;
            removeBtn.onclick = () => {
                uploadedFiles.splice(index, 1);
                updatePreview();
                saveFormData();
            };
            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.insertBefore(wrapper, uploadBox);
        });
        input.files = dataTransfer.files;
        uploadBox.style.display = uploadedFiles.length >= 3 ? 'none' : 'flex';
        if (uploadedFiles.length > 0) {
            // Ambil hanya foto pertama untuk prediksi
            predictKerusakanFromImage(uploadedFiles[0]).then(prediction => {
                document.getElementById('jenis_kerusakan').value = prediction.jenis;
                document.getElementById('tingkat_kerusakan').value = prediction.tingkat;
            })
        }
    }

    async function predictKerusakanFromImage(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
            };

            img.onload = async function () {
                const tensor = tf.browser.fromPixels(img)
                    .resizeNearestNeighbor([128, 128])
                    .toFloat()
                    .div(tf.scalar(255))
                    .expandDims();

                try {
                    const predictions = await model.predict(tensor);
                    tensor.dispose();

                    const jenisPred = predictions[0].softmax().dataSync();
                    const tingkatPred = predictions[1].softmax().dataSync();

                    const jenisClassNames = ['Retak Buaya', 'Lubang-lubang', 'Longsor'];
                    const tingkatClassNames = ['Ringan', 'Sedang', 'Berat'];

                    const jenisIndex = jenisPred.indexOf(Math.max(...jenisPred));
                    const tingkatIndex = tingkatPred.indexOf(Math.max(...tingkatPred));

                    predictions.forEach(p => p.dispose());

                    resolve({
                        jenis: jenisClassNames[jenisIndex],
                        tingkat: tingkatClassNames[tingkatIndex]
                    });
                } catch (err) {
                    reject(err);
                }
            };

            img.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function validatePhoneNumber(phone) { return /^08\d{8,11}$/.test(phone); }
    function validateEmail(email) {
        const input = document.createElement('input');
        input.type = 'email';
        input.value = email;
        return input.checkValidity() && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);
    }

    function validateRT(rt) {
        return /^[0-9]{1,3}$/.test(rt);
    }

    function validateRTorRW(value) {
        return value.trim() === '' || /^\d{1,3}$/.test(value); // valid jika kosong atau 1-3 digit angka
    }




    function updateStars(rating) {
        const validRating = (Number.isInteger(rating) && rating >= 1 && rating <= 5) ? rating : 1;
        
        document.querySelectorAll('#star-rating .star').forEach(star => {
            star.classList.toggle('text-yellow-400', parseInt(star.dataset.value) <= validRating);
            star.classList.toggle('text-gray-300', parseInt(star.dataset.value) > validRating);
        });
    }

    function showError(element, message) {
        clearError(element);
        const parent = element.id === 'upload_box' ? element.parentElement.parentElement : element.parentElement;
        const errorElement = document.createElement('p');
        errorElement.className = 'error-message text-red-600 text-xs mt-1';
        errorElement.textContent = message;
        parent.appendChild(errorElement);
        element.classList.add('border-red-500', 'ring-1', 'ring-red-500');
    }

    function clearError(element) {
        const parent = element.id === 'upload_box' ? element.parentElement.parentElement : element.parentElement;
        parent.querySelector('.error-message')?.remove();
        element.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
    }

    // Add this to your validateStep function or create a new validation function
    function validateTextInput(inputElement, maxLength, required = true, lettersOnly = false) {
        const value = inputElement.value.trim();
        const fieldName = inputElement.getAttribute('name') || inputElement.id;
        
        // Check if required and empty
        if (required && value === '') {
            showError(inputElement, 'Field ini wajib diisi.');
            return false;
        }
        
        // If not required and empty, it's valid
        if (!required && value === '') {
            clearError(inputElement);
            return true;
        }
        
        // Check length
        if (value.length > maxLength) {
            showError(inputElement, `Teks tidak boleh lebih dari ${maxLength} karakter.`);
            return false;
        }
        
        // Check allowed characters (letters, numbers, spaces, common punctuation)
        const allowedChars = lettersOnly ? /^[A-Za-z\s]+$/ : /^[a-zA-Z0-9 .,?!\-:/]+$/;
        if (!allowedChars.test(value)) {
            if (lettersOnly) {
                showError(inputElement, 'Mohon maaf hanya bisa menulis huruf saja.');
            } else {
                showError(inputElement, 'Terdapat karakter yang tidak diizinkan. Hanya huruf, angka, spasi, dan tanda baca umum yang diperbolehkan.');
            }
            return false;
        }
        
        clearError(inputElement);
        return true;
    }


    function validateStep(stepDiv) {
        if (!stepDiv) return true;
        let allValid = true;
        stepDiv.querySelectorAll('.error-message').forEach(el => el.remove());
        stepDiv.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'ring-1', 'ring-red-500'));

        stepDiv.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
            if (!field.value.trim()) {
                showError(field, 'Field ini wajib diisi.');
                allValid = false;
            } else if (field.id === 'nomor_ponsel' && !validatePhoneNumber(field.value)) {
                showError(field, 'Nomor ponsel tidak valid.');
                allValid = false;
            }
        });

        const namaLengkap = stepDiv.querySelector('#nama_lengkap');
        if (namaLengkap && !validateTextInput(namaLengkap, 1000, true, true)) {
            allValid = false;
        }

        const alamatPelapor = stepDiv.querySelector('#alamat_pelapor');
        if (alamatPelapor && !validateTextInput(alamatPelapor, 1000)) {
            allValid = false;
        }

        const alamatKerusakan = stepDiv.querySelector('#alamat_lengkap_kerusakan');
        if (alamatKerusakan && !validateTextInput(alamatKerusakan, 1000)) {
            allValid = false;
        }

        const deskripsiLaporan = stepDiv.querySelector('#deskripsi_laporan');
        if (deskripsiLaporan && !validateTextInput(deskripsiLaporan, 1000)) {
            allValid = false;
        }

        const feedback = stepDiv.querySelector('#feedback');
        if (feedback && !validateTextInput(feedback, 1000, false)) {
            allValid = false;
        }

        const rtPelapor = stepDiv.querySelector('#rt_pelapor');
        if (rtPelapor && rtPelapor.value.trim() !== '' && !validateRT(rtPelapor.value.trim())) {
            showError(rtPelapor, 'RT harus berupa angka 1 sampai 3 digit.');
            allValid = false;
        }


        const rwPelapor = document.getElementById('rw_pelapor');
        if (rwPelapor && !validateRTorRW(rwPelapor.value)) {
            showError(rwPelapor, 'RW harus berupa angka 1 sampai 3 digit.');
            allValid = false;
        }
        
        const emailField = stepDiv.querySelector('#email');
        if (emailField && emailField.value.trim() !== '' && !validateEmail(emailField.value)) {
            showError(emailField, 'Format email tidak valid.');
            allValid = false;
        }

        if (stepDiv.id === 'step-2' && uploadedFiles.length === 0) {
            showError(document.getElementById('upload_box'), 'Minimal satu foto wajib diunggah.');
            allValid = false;
        }

        if (!allValid) {
            const firstInvalid = stepDiv.querySelector('.border-red-500');
            if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return allValid;
    }
    
    // =========================================================================
    // MODIFIKASI INTI: Fungsi showStep dengan Anime.js
    // =========================================================================
    function showStep(step, useAnimation = true) {
        const totalSteps = 3;
        let previousStep = currentStep;

        // Hide all step divs
        document.querySelectorAll('[id^="step-"]').forEach((el, index) => {
            if (index + 1 !== step && el.style.display !== 'none') {
                 if (useAnimation) {
                    anime({
                        targets: el,
                        opacity: [1, 0],
                        translateY: [0, 20],
                        duration: 300,
                        easing: 'easeInQuad',
                        complete: () => {
                            el.style.display = 'none';
                        }
                    });
                 } else {
                     el.style.display = 'none';
                 }
            }
        });

        const activeStepDiv = document.getElementById(`step-${step}`);
        if (activeStepDiv) {
            // Show the target step div with animation
            activeStepDiv.style.display = 'block'; // Set display before animating
            if (useAnimation) {
                anime({
                    targets: activeStepDiv,
                    opacity: [0, 1],
                    translateY: [20, 0],
                    duration: 400,
                    easing: 'easeOutQuad',
                    begin: () => {
                        // Scroll to the top of the form container smoothly
                        activeStepDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        // Focus on the first input
                        activeStepDiv.querySelector('input:not([type="hidden"]), textarea, select')?.focus();
                    }
                });
            }
        }
        
        // Update the stepper timeline UI
        const stepperItems = document.querySelectorAll('.stepper-item');
        stepperItems.forEach((item, index) => {
            let stepNum = index + 1;
            if (stepNum === step) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else if (stepNum < step) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else {
                item.classList.remove('active', 'completed');
            }
        });
        
        // Animate the progress bar
        const progressBar = document.getElementById('stepper-progress-bar');
        const progressPercentage = step > 1 ? ((step - 1) / (totalSteps - 1)) * 100 : 0;
        
        if (useAnimation) {
            anime({
                targets: progressBar,
                width: progressPercentage + '%',
                duration: 400,
                easing: 'easeInOutQuad'
            });
        } else {
            progressBar.style.width = progressPercentage + '%';
        }

        // Reset turnstile captcha if moving to step 3
        if (step === 3) {
            const { kirimBtn, captchaErrorDiv } = getCaptchaElements();
            if (kirimBtn) {
                kirimBtn.disabled = true;
                kirimBtn.classList.add('disabled');
            }
            
            if (captchaErrorDiv) {
                captchaErrorDiv.style.display = 'none';
            }
            
            if (typeof turnstile !== 'undefined') {
                turnstile.reset();
            }
        }

        // Update currentStep and save to localStorage
        currentStep = step;
        localStorage.setItem(STEP_STORAGE_KEY, currentStep.toString());
    }

    window.nextStep = () => {
        if (validateStep(document.getElementById(`step-${currentStep}`))) {
            if (currentStep < 3) showStep(currentStep + 1);
            saveFormData();
        }
    };
    window.prevStep = () => {
        // [FIX] Tambahkan blok ini untuk menonaktifkan tombol kirim
        // saat meninggalkan Langkah 3.
        if (currentStep === 3) {
            const { kirimBtn, captchaErrorDiv } = getCaptchaElements();
            if (kirimBtn) {
                kirimBtn.disabled = true;
                kirimBtn.classList.add('disabled');
            }
            if (captchaErrorDiv) {
                captchaErrorDiv.style.display = 'none';
            }
        }

        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
        
        saveFormData();
    };

    async function fetchKelurahan(kecId, kelSelect, selKelId = null, selKelName = null) {
        if (!kecId) {
            kelSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            kelSelect.disabled = true;
            return;
        }
        kelSelect.innerHTML = '<option value="">Memuat kelurahan...</option>';
        kelSelect.disabled = true;
        try {
            const response = await fetch(`${KELURAHAN_BY_KECAMATAN_URL_PREFIX}${kecId}`);
            if (!response.ok) throw new Error('Gagal memuat data kelurahan');
            const data = await response.json();
            kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
            data.forEach(kel => {
                const opt = new Option(kel.nama, kel.id);
                if ((selKelId && kel.id == selKelId) || (selKelName && kel.nama.toLowerCase().includes(selKelName.toLowerCase()))) {
                    opt.selected = true;
                }
                kelSelect.add(opt);
            });
        } catch (error) {
            console.error("Error fetching kelurahan:", error);
            kelSelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
        } finally {
            kelSelect.disabled = false;
        }
    }

    function resetFullForm() {
        if (!confirm('Anda yakin ingin mereset seluruh isian form? Aksi ini tidak dapat dibatalkan.')) return;
        clearFormData();
        if (form) form.reset();
        uploadedFiles = [];
        updatePreview();
        updateStars(1);
        document.querySelectorAll('#kelurahan_id, #lokasi_kelurahan_id').forEach(select => {
            select.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan Dahulu --</option>';
            select.disabled = true;
        });
        const alamatKerusakanInput = document.getElementById('alamat_lengkap_kerusakan');
        if (alamatKerusakanInput) {
            alamatKerusakanInput.readOnly = false;
            alamatKerusakanInput.classList.remove('bg-gray-100');
            alamatKerusakanInput.title = '';
            alamatKerusakanInput.placeholder = 'Alamat Lengkap Lokasi Kerusakan';
        }
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'ring-1', 'ring-red-500'));
        document.getElementById('ajax-error-container')?.classList.add('hidden');
        
        // Reset stepper and go to step 1 with animation
        showStep(1); 
        
        if (typeof turnstile !== 'undefined') turnstile.reset();
        alert('Form berhasil direset.');
    }

    function getCaptchaElements() {
        const kirimBtn = document.getElementById('kirimLaporanBtn');
        const captchaErrorDiv = document.getElementById('captcha-error');
        return { kirimBtn, captchaErrorDiv };
    }

    // Fungsi ini harus tersedia di scope global, jadi kita pasang ke 'window'
    window.onCaptchaSuccess = function(token) {
        console.log("Turnstile verification successful!");
        const { kirimBtn, captchaErrorDiv } = getCaptchaElements();
        
        if (kirimBtn) {
            kirimBtn.disabled = false;
            kirimBtn.classList.remove('disabled');
        }
        if (captchaErrorDiv) {
            captchaErrorDiv.style.display = 'none';
        }
    };

    window.onCaptchaExpired = function() {
        console.warn("Turnstile token expired.");
        const { kirimBtn, captchaErrorDiv } = getCaptchaElements();

        if (kirimBtn) {
            kirimBtn.disabled = true;
            kirimBtn.classList.add('disabled');
        }
        if (captchaErrorDiv) {
            captchaErrorDiv.textContent = 'Sesi verifikasi Anda telah berakhir. Mohon verifikasi ulang.';
            captchaErrorDiv.style.display = 'block';
        }
    };

    window.onCaptchaError = function() {
        console.error("Turnstile failed to load or verify.");
        const { kirimBtn, captchaErrorDiv } = getCaptchaElements();

        if (kirimBtn) {
            kirimBtn.disabled = true;
            kirimBtn.classList.add('disabled');
        }
        if (captchaErrorDiv) {
            captchaErrorDiv.textContent = 'Gagal memuat verifikasi. Periksa koneksi Anda dan coba lagi.';
            captchaErrorDiv.style.display = 'block';
        }
    };

    // =========================================================================
    // Inisialisasi Event Listeners
    // =========================================================================
    if (gunakanLokasiBtn) {
        gunakanLokasiBtn.onclick = async () => {
            if (!navigator.geolocation) return alert("Browser Anda tidak mendukung geolokasi.");
            gunakanLokasiBtn.disabled = true;
            gunakanLokasiBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mendeteksi...';
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const { latitude, longitude } = position.coords;
                    document.getElementById('latitude').value = latitude.toFixed(6);
                    document.getElementById('longitude').value = longitude.toFixed(6);
                    document.getElementById('link_koordinat').value = `https://maps.google.com/?q=${latitude.toFixed(6)},${longitude.toFixed(6)}`;
                    await fetchAddressFromCoordinates(latitude, longitude);
                    alert("Lokasi berhasil didapatkan dan detail alamat telah diisi otomatis.");
                    saveFormData();
                    gunakanLokasiBtn.disabled = false;
                    gunakanLokasiBtn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Gunakan Lokasi Saya';
                },
                (error) => {
                    const messages = {
                        [error.PERMISSION_DENIED]: "Anda menolak permintaan Geolokasi. Aktifkan izin lokasi.",
                        [error.POSITION_UNAVAILABLE]: "Informasi lokasi tidak tersedia.",
                        [error.TIMEOUT]: "Permintaan untuk mendapatkan lokasi pengguna timeout."
                    };
                    alert(messages[error.code] || "Terjadi kesalahan yang tidak diketahui saat mendapatkan lokasi.");
                    gunakanLokasiBtn.disabled = false;
                    gunakanLokasiBtn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Gunakan Lokasi Saya';
                }
            );
        };
    }
    
    if (btnPilihLokasi) btnPilihLokasi.addEventListener('click', openMapModal);
    if (closeMapModalBtn) closeMapModalBtn.addEventListener('click', closeMapModal);
    if (cancelMapModalBtn) cancelMapModalBtn.addEventListener('click', closeMapModal);
    if (mapModalElement) mapModalElement.addEventListener('click', (e) => { if (e.target === mapModalElement) closeMapModal(); });
    
    if (simpanBtn) {
        simpanBtn.onclick = async () => {
            if (selectedLatLng) {
                document.getElementById('latitude').value = selectedLatLng.lat.toFixed(6);
                document.getElementById('longitude').value = selectedLatLng.lng.toFixed(6);
                document.getElementById('link_koordinat').value = `https://maps.google.com/?q=${selectedLatLng.lat.toFixed(6)},${selectedLatLng.lng.toFixed(6)}`;
                await fetchAddressFromCoordinates(selectedLatLng.lat, selectedLatLng.lng);
                closeMapModal();
                saveFormData();
            } else {
                alert("Silakan pilih lokasi pada peta terlebih dahulu.");
            }
        };
    }

    if (searchButton) {
        const performSearch = () => {
            const query = addressSearch.value.trim();
            if (!query) return alert('Silakan masukkan alamat/tempat yang ingin dicari');
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}%20Samarinda&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        const latLng = L.latLng(parseFloat(lat), parseFloat(lon));
                        map.setView(latLng, 16);
                        updateSelectedLocation(latLng);
                        marker.bindPopup(`<b>${display_name}</b>`).openPopup();
                        addressSearch.value = display_name;
                    } else {
                        alert("Alamat/tempat tidak ditemukan.");
                    }
                }).catch(error => console.error('Error searching address:', error));
        };
        searchButton.addEventListener('click', performSearch);
        addressSearch.addEventListener('keypress', (e) => { if (e.key === 'Enter') { e.preventDefault(); performSearch(); } });
    }

    if (form) {
        form.addEventListener('input', saveFormData);
        // Ganti event submit form untuk menggunakan AJAX
        form.addEventListener('submit', function(event) {
            // Validasi step terakhir sebelum submit
            if (validateStep(document.getElementById(`step-${currentStep}`))) {

            } else {
                // Jika validasi gagal, hentikan submit
                event.preventDefault();
            }
        });
    }

    if (resetFormButton) resetFormButton.addEventListener('click', resetFullForm);
    document.getElementById('foto_kerusakan')?.addEventListener('change', (e) => {
        const newFiles = Array.from(e.target.files);
        if ((uploadedFiles.length + newFiles.length) > 3) {
            return alert(`Maksimal 3 foto. Anda sudah mengupload ${uploadedFiles.length} foto.`);
        }
        for (const file of newFiles) {
            if (file.size > 10 * 1024 * 1024) {
                return alert(`File ${file.name} terlalu besar. Maksimal 10 MB.`);
            }
        }
        uploadedFiles = uploadedFiles.concat(newFiles);
        updatePreview();
        saveFormData();
    });
    
    document.querySelectorAll('#kecamatan_id, #lokasi_kecamatan_id').forEach(select => {
        select.addEventListener('change', (e) => {
            const kelurahanSelectId = e.target.id === 'kecamatan_id' ? 'kelurahan_id' : 'lokasi_kelurahan_id';
            fetchKelurahan(e.target.value, document.getElementById(kelurahanSelectId));
        });
    });

    document.getElementById('star-rating')?.addEventListener('click', (e) => {
        if (e.target.matches('.star')) {
            const rating = parseInt(e.target.dataset.value);
            document.getElementById('rating_kepuasan').value = rating;
            updateStars(rating);
        }
    });

    document.getElementById('star-rating')?.addEventListener('touchstart', (e) => {
        if (e.target.matches('.star')) {
            const rating = parseInt(e.target.dataset.value);
            document.getElementById('rating_kepuasan').value = rating;
            updateStars(rating);
        }
    });

    if (kirimLaporanBtn && currentStep === 3) {
        kirimLaporanBtn.disabled = true;
        kirimLaporanBtn.classList.add('disabled');
    }

    if (kirimLaporanBtn) {
        const kirimIcon = document.getElementById('kirimIcon');
        const kirimText = document.getElementById('kirimText');

        form.addEventListener('submit', function(event) {
            if (!validateStep(document.getElementById(`step-${currentStep}`))) {
                // Jika validasi gagal, hentikan submit dan kembalikan tombol ke keadaan normal
                event.preventDefault(); // Tetap hentikan submit jika validasi gagal
                return; // Keluar dari fungsi submit
            }

            // Periksa apakah tombol sudah dalam keadaan loading
            if (kirimLaporanBtn.classList.contains('disabled')) {
                event.preventDefault(); // Cegah pengiriman ganda
                return;
            }
            
            // Tambahkan indikator loading
            kirimLaporanBtn.classList.add('disabled');
            kirimIcon.classList.remove('fa-paper-plane');
            kirimIcon.classList.add('fa-spinner', 'fa-spin'); // Gunakan ikon spinner
            kirimText.textContent = 'Mengirim...';

            // Submit form secara normal (browser akan menangani pengiriman)
            // event.preventDefault() tidak diperlukan di sini karena kita ingin submit
        });
    }
        
    // =========================================================================
    // Eksekusi Inisialisasi Awal
    // =========================================================================
    if (successNotification) {
    clearClientStorage();
    } else {
        updatePreview(); 
        loadFormData();
        updateStepperUI(currentStep); 
    }

});