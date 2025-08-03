document.addEventListener('DOMContentLoaded', function() {
    const publicMapElement = document.getElementById('publicMap');
    if (!publicMapElement) {
        console.error("Elemen peta #publicMap tidak ditemukan.");
        return;
    }

    const mapDataUrl = publicMapElement.dataset.mapDataUrl;
    const maptilerToken = publicMapElement.dataset.maptilerToken || 'YOUR_FALLBACK_MAPTILER_KEY';
    const storageBaseUrl = publicMapElement.dataset.storageBaseUrl || '/storage';

    if (!mapDataUrl) {
        console.error("URL data peta (data-map-data-url) tidak ditemukan pada elemen #publicMap.");
        publicMapElement.innerHTML = '<p class="text-center text-red-600 font-semibold p-3">Konfigurasi peta tidak lengkap.</p>';
        return;
    }

    // Inisialisasi Layer Peta
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });

    const streets = L.tileLayer(`https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=${maptilerToken}`, {
        maxZoom: 19,
        attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>'
    });

    const satellite = L.tileLayer(`https://api.maptiler.com/maps/hybrid/{z}/{x}/{y}.jpg?key=${maptilerToken}`, {
        maxZoom: 19,
        attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>'
    });

    // Inisialisasi Map Leaflet
    const publicMap = L.map('publicMap', {
        center: [-0.502, 117.15], // Koordinat default (Samarinda)
        zoom: 11,
        layers: [streets] // Layer default
    });

    // Menambahkan kontrol layer
    const baseLayers = {
        "Peta OpenStreet": osmLayer,
        "Peta Default": streets,
        "Peta Satelit": satellite
    };
    L.control.layers(baseLayers).addTo(publicMap);

    // --- DEFINISI IKON ---
    const iconBaseUrl = '/image/map/'; // Path ke direktori public

    const iconBelumDikerjakan = new L.Icon({ 
        iconUrl: `${iconBaseUrl}yellow-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    const iconSedangDikerjakan = new L.Icon({ 
        iconUrl: `${iconBaseUrl}orange-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    const iconTelahDikerjakan = new L.Icon({ 
        iconUrl: `${iconBaseUrl}green-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    const iconTelahDisurvei = new L.Icon({ 
        iconUrl: `${iconBaseUrl}blue-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    const iconDisposisi = new L.Icon({ 
        iconUrl: `${iconBaseUrl}purple-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    const iconDefault = new L.Icon({ 
        iconUrl: `${iconBaseUrl}red-dot.png`, 
        iconSize: [32, 32], 
        iconAnchor: [16, 32], 
        popupAnchor: [0, -32] 
    });

    let allMarkers = [];
    let originalData = [];

    // --- Helper Functions ---
    function toTitleCase(str) {
        if (!str) return '';
        return str.replace(/_/g, ' ').replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
    }

    function getStatusBadgeColor(statusNama) {
        let normalized = (statusNama || '').toLowerCase().trim().replace(/\s+/g, '_');
        switch (normalized) {
            case 'belum_dikerjakan':  return 'bg-yellow-100 text-yellow-800';
            case 'sedang_dikerjakan': return 'bg-amber-100 text-amber-800';
            case 'telah_dikerjakan':  return 'bg-green-100 text-green-800';
            case 'telah_disurvei':    return 'bg-blue-100 text-blue-800';
            case 'disposisi':         return 'bg-purple-100 text-purple-800';
            default:                  return 'bg-red-100 text-red-800';
        }
    }

    function getTingkatKerusakanBadgeColor(tingkatKerusakan) {
        let normalized = (tingkatKerusakan || '').toLowerCase().trim();
        switch (normalized) {
            case 'ringan': return 'bg-green-100 text-green-800';
            case 'sedang': return 'bg-yellow-100 text-yellow-800';
            case 'berat':  return 'bg-red-100 text-red-800';
            default:       return 'bg-gray-100 text-gray-800';
        }
    }

    function getStatusIcon(statusNama) {
        const statusLower = (statusNama || '').toLowerCase().trim();
        switch (statusLower) {
            case 'telah_disurvei':    return iconTelahDisurvei;
            case 'disposisi':         return iconDisposisi;
            case 'belum_dikerjakan':  return iconBelumDikerjakan;
            case 'sedang_dikerjakan': return iconSedangDikerjakan;
            case 'telah_dikerjakan':  return iconTelahDikerjakan;
            default:                  return iconDefault;
        }
    }
    
    function updateStats(filteredData) {
        const stats = { belum_dikerjakan: 0, sedang_dikerjakan: 0, telah_dikerjakan: 0, telah_disurvei: 0, disposisi: 0 };
        filteredData.forEach(laporan => {
            const statusLower = (laporan.status?.nama_status || '').toLowerCase().trim();
            if (stats.hasOwnProperty(statusLower)) {
                stats[statusLower]++;
            }
        });
        document.getElementById('stat-belum-dikerjakan').innerText = stats.belum_dikerjakan;
        document.getElementById('stat-sedang-dikerjakan').innerText = stats.sedang_dikerjakan;
        document.getElementById('stat-telah-dikerjakan').innerText = stats.telah_dikerjakan;
        document.getElementById('stat-telah-disurvei').innerText = stats.telah_disurvei;
        document.getElementById('stat-disposisi').innerText = stats.disposisi;
    }

    // --- Fetch and Render Logic ---
    fetch(mapDataUrl)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            originalData = data;

            if (data.error || !Array.isArray(data)) {
                publicMapElement.innerHTML = `<p class="text-center text-red-600 font-semibold p-3">${data.error || 'Gagal memuat data peta.'}</p>`;
                return;
            }
            if (data.length === 0) {
                publicMapElement.innerHTML = '<p class="text-center text-gray-600 font-semibold p-3 no-results-message">Tidak ada laporan yang ditampilkan.</p>';
                updateStats([]);
                return;
            }

            function renderMarkers(formStatusFilterFromForm = '', formTingkatFilter = '', searchKeyword = '') {
                allMarkers.forEach(marker => publicMap.removeLayer(marker));
                allMarkers = [];

                const noResultsMessage = document.querySelector('.no-results-message');
                if (noResultsMessage) noResultsMessage.remove();

                const searchKeywordLower = searchKeyword.toLowerCase();
                const formTingkatFilterLower = formTingkatFilter.toLowerCase().trim();
                const activeLegendaButton = document.getElementById('legendFilters')?.querySelector('.legend-filter-btn.active');
                const filterStatusFromLegenda = activeLegendaButton ? activeLegendaButton.dataset.filterStatus || '' : '';
                const finalStatusFilter = filterStatusFromLegenda ? filterStatusFromLegenda.toLowerCase() : formStatusFilterFromForm.toLowerCase();

                let bounds = [];
                let filteredData = [];

                const apiBaseUrl = window.location.origin + '/api';

                originalData.forEach(laporan => {
                    const statusNama = laporan.status?.nama_status || '';
                    const tingkatNama = laporan.tingkat_kerusakan || '';
                    const statusLower = statusNama.toLowerCase().trim();
                    const matchesSearch = !searchKeywordLower || [
                        laporan.id_laporan?.toString().toLowerCase(),
                        laporan.deskripsi_laporan?.toLowerCase(),
                        laporan.no_hp?.toLowerCase(),
                        laporan.alamat_jalan?.toLowerCase(),
                        statusNama.toLowerCase(),
                        tingkatNama.toLowerCase()
                    ].some(field => field?.includes(searchKeywordLower));
                    if (!matchesSearch) return;
                    if (finalStatusFilter && statusLower !== finalStatusFilter) return;
                    if (formTingkatFilterLower && formTingkatFilterLower !== 'semua' && tingkatNama.toLowerCase().trim() !== formTingkatFilterLower) return;

                    const lat = parseFloat(laporan.latitude);
                    const lon = parseFloat(laporan.longitude);
                    if (isNaN(lat) || isNaN(lon)) return;

                    filteredData.push(laporan);
                    
                    // --- MODIFIKASI DIMULAI DI SINI ---
                    
                    const iconToUse = getStatusIcon(statusNama);
                    const marker = L.marker([lat, lon], { icon: iconToUse }).addTo(publicMap);

                    // 1. Bind popup dengan pesan loading awal
                    marker.bindPopup(`
                        <div class="p-4 text-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat detail laporan...
                        </div>
                    `);

                    // 2. Tambahkan event listener 'click' untuk fetch data detail
                    marker.on('click', function() {
                        fetch(`${apiBaseUrl}/laporan/${laporan.id_laporan}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Gagal mengambil data dari API');
                                }
                                return response.json();
                            })
                            .then(response => {
                                if (!response.success) {
                                    throw new Error(response.message || 'Respons API tidak sukses');
                                }
                                const detail = response.data;
                                
                                // Cek apakah ada foto, dan ambil URL foto pertama
                                const imageUrl = (detail.foto_kerusakan_urls && detail.foto_kerusakan_urls.length > 0)
                                    ? detail.foto_kerusakan_urls[0].url
                                    : null;
                                
                                const imageHtml = imageUrl 
                                    ? `<div class="popup-image-container mt-2.5">
                                        <img src="${imageUrl}" alt="Dokumentasi Laporan" class="w-full h-32 object-cover rounded-md border border-gray-200">
                                    </div>`
                                    : '';
                                
                                // 3. Buat konten popup baru dengan data dari API
                                const newPopupContent = `
                                    <div class="font-sans bg-white rounded-lg shadow-lg" style="width: 85vw; max-width: 280px;">
                                        <div class="p-2.5 border-b border-gray-200">
                                            <h3 class="text-sm font-bold text-gray-800">Laporan #${detail.id_laporan || 'N/A'}</h3>
                                            <p class="text-xs text-gray-500 mt-1">${detail.created_at_formatted || 'N/A'}</p>
                                            <div class="flex flex-wrap gap-1.5 mt-2">
                                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full ${getStatusBadgeColor(detail.status_nama)}">
                                                    ${toTitleCase(detail.status_nama) || 'N/A'}
                                                </span>
                                                <span class="text-xs font-medium px-2 py-0.5 rounded-full ${getTingkatKerusakanBadgeColor(detail.tingkat_kerusakan)}">
                                                    Kerusakan: ${toTitleCase(detail.tingkat_kerusakan) || 'N/A'}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        ${imageHtml}

                                        <div class="p-2.5 space-y-2">
                                            <p class="text-sm text-gray-700 ${imageHtml ? 'line-clamp-2' : 'line-clamp-3'}">
                                                <span class="font-semibold">Deskripsi:</span><br>
                                                ${detail.deskripsi_laporan || 'Tidak ada deskripsi.'}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-2.5">
                                            <a href="/jalan-peduli/laporan/data?search=${encodeURIComponent(detail.id_laporan || '')}"
                                            class="block w-full text-center py-2 px-3 rounded-md text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 -mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 001.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" /><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" /></svg>
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>`;

                                // 4. Perbarui konten popup dan buka
                                this.setPopupContent(newPopupContent);
                            })
                            .catch(error => {
                                console.error('Error fetching laporan detail:', error);
                                // Jika gagal, tampilkan pesan error di popup
                                this.setPopupContent('<p class="p-4 text-center text-red-600">Gagal memuat detail laporan.</p>');
                            });
                    });

                    allMarkers.push(marker);
                    bounds.push([lat, lon]);
                });
                
                // ...Sisa fungsi renderMarkers (updateStats, fitBounds, dll. tetap sama)
                updateStats(filteredData);
                const mapContainer = document.getElementById('publicMap');

                if (bounds.length) {
                    publicMap.fitBounds(bounds, { padding: [50, 50], maxZoom: 16 });
                } else {
                    if (!mapContainer.querySelector('.no-results-message')) {
                        const messageEl = document.createElement('div');
                        messageEl.className = 'no-results-message absolute top-0 left-0 w-full h-full flex items-center justify-center text-gray-600 font-semibold bg-white/80 z-10';
                        messageEl.innerText = 'Tidak ada laporan yang cocok dengan kriteria filter.';
                        mapContainer.appendChild(messageEl);
                    }
                    publicMap.setView([-0.502, 117.15], 11);
                }
                publicMap.invalidateSize();
            }

            // --- Event Listeners ---
            function applyFilters() {
                const searchKeyword = document.getElementById('search')?.value || '';
                const formTingkatFilter = document.getElementById('tingkat_kerusakan_filter')?.value || '';
                const activeLegendaButton = document.getElementById('legendFilters')?.querySelector('.legend-filter-btn.active');
                const filterStatusFromLegenda = activeLegendaButton ? activeLegendaButton.dataset.filterStatus || '' : '';
                renderMarkers(filterStatusFromLegenda, formTingkatFilter, searchKeyword);
            }

            document.getElementById('legendFilters')?.addEventListener('click', e => {
                const targetButton = e.target.closest('.legend-filter-btn');
                if (targetButton) {
                    document.querySelectorAll('#legendFilters .legend-filter-btn').forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.add('inactive');
                    });
                    targetButton.classList.add('active');
                    targetButton.classList.remove('inactive');
                    applyFilters();
                }
            });

            document.getElementById('mapFilterForm')?.addEventListener('submit', e => {
                e.preventDefault();
                document.querySelectorAll('#legendFilters .legend-filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('inactive');
                });
                applyFilters();
            });

            // Initial Load
            applyFilters();
        })
        .catch(error => {
            console.error('Error fetching/processing map data:', error);
            publicMapElement.innerHTML = '<p class="text-center text-red-600 font-semibold p-3">Gagal memuat data peta. Silakan coba lagi nanti.</p>';
        });
});