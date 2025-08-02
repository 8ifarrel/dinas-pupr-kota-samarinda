<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas PUPR Samarinda - Mobile Friendly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Animasi slide-in dari kanan */
        @keyframes slideInFromRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .slide-in-from-right {
            animation: slideInFromRight 0.3s ease-out forwards;
        }
        
        .fade-in {
            animation: fadeIn 0.2s ease-out;
        }
        
        .custom-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .touch-target {
            min-height: 48px;
            min-width: 48px;
        }

        .bg-nav-plain {
            background-color: #ffffff;
        }
        
        .active-indicator {
            position: relative;
        }
        
        .active-indicator::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: #3b82f6;
            border-radius: 50%;
        }

        /* Perbaikan untuk mobile menu agar tidak keluar dari container */
        #mobile-menu {
            left: 0;
            right: 0;
            width: 100vw;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Memastikan container tidak overflow */
        .container {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Responsif untuk logo text */
        @media (max-width: 480px) {
            .logo-text-mobile {
                font-size: 0.65rem;
                line-height: 1.2;
            }
        }

        /* Perbaikan untuk desktop menu agar tidak overflow */
        @media (min-width: 1024px) {
            .desktop-menu-container {
                display: flex;
                align-items: center;
                gap: 0.25rem;
                flex-wrap: nowrap;
                overflow: hidden;
            }
            
            .desktop-menu-item {
                white-space: nowrap;
                flex-shrink: 0;
            }
        }

        @media (min-width: 1280px) {
            .desktop-menu-container {
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="hidden my-4 mx-16 lg:flex justify-between items-center">
        <figure class="flex gap-2">
            <img class="h-[55px]" src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" />
            <img class="h-[55px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
            <figcaption class="my-auto text-lg text-brand-blue font-bold w-[365px] uppercase">
                {{ config('app.nama_dinas') }}
            </figcaption>
        </figure>
        
        <div>
            <p class="text-lg font-semibold current-time"></p>
        </div>
    </div>
    
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-nav-plain custom-shadow border-b border-gray-100">
        <div class="container mx-auto px-4">
            <!-- Bottom Bar - Navigation Menu -->
            <div class="z-50 border-t border-gray-200 py-2 backdrop-blur-md bg-white/30">
                <div class="flex flex-col items-end">
                    <!-- Desktop Menu - Right aligned -->
                    <div class="hidden lg:flex desktop-menu-container justify-end space-x-1">
                        <a href="{{ route('guest.jalan-peduli.index') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'home' ? 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-blue-600 bg-blue-50 font-semibold' : 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-all duration-300">
                            <i class="fas fa-home text-sm"></i>
                            <span class="text-sm">Menu Jalan Peduli</span>
                        </a>
                        <a href="{{ route('laporan.data') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'laporan.data' ? 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-blue-600 bg-blue-50 font-semibold' : 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-all duration-300">
                        {{-- <a href="{{ route('laporan.data') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'laporan.data' ? 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-blue-600 bg-blue-50 font-semibold' : 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-all duration-300"> --}}
                            <i class="fas fa-search text-sm"></i>
                            <span class="text-sm">Cek Status</span>
                        </a>

                        <a href="{{ route('laporan.public.map') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'laporan.public.map' ? 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-blue-600 bg-blue-50 font-semibold' : 'flex items-center space-x-2 px-3 xl:px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} transition-all duration-300">
                            <i class="fas fa-map-marked-alt text-sm"></i>
                            <span class="text-sm">Peta Laporan</span>
                        </a>
                    </div>

                    <!-- Mobile Menu Button - Centered -->
                    <div class="lg:hidden flex justify-center">
                        <button id="mobile-menu-button" aria-label="Buka menu navigasi" class="touch-target flex items-center justify-center p-2 rounded-full shadow-md bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 flex-shrink-0">
                            <i id="menu-icon" class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden fixed top-[120px] left-0 w-full z-40 pb-2 px-4">
                <div class="bg-white rounded-xl custom-shadow p-2 slide-in-from-right">
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Menu Jalan Peduli -->
                        <a href="{{ route('guest.jalan-peduli.index') }}" class="{{ Route::currentRouteName() == 'home' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600' }} transition-all duration-300">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-center">Menu Jalan Peduli</span>
                        </a>

                        <!-- Cek Status -->
                        <a href="#" class="{{ Route::currentRouteName() == 'laporan.data' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition-all duration-300">
                        {{-- <a href="{{ route('laporan.data') }}" class="{{ Route::currentRouteName() == 'laporan.data' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition-all duration-300"> --}}
                            <div class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-search text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-center">Cek Status</span>
                        </a>

                        <!-- Peta Laporan -->
                        <a href="{{ route('laporan.public.map') }}" class="{{ Route::currentRouteName() == 'laporan.public.map' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-600' }} transition-all duration-300">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-map-marked-alt text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-center">Peta Laporan</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            let isMenuOpen = false;

            mobileMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();

                isMenuOpen = !isMenuOpen;
                
                if (isMenuOpen) {
                    mobileMenu.classList.remove('hidden');
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                    
                    setTimeout(() => {
                        const menuContent = mobileMenu.querySelector('.slide-in-from-right');
                        if (menuContent) {
                            menuContent.classList.add('slide-in-from-right');
                        }
                    }, 10); 
                } else {
                    const menuContent = mobileMenu.querySelector('.slide-in-from-right');
                    if (menuContent) {
                        menuContent.classList.remove('slide-in-from-right');
                    }
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });

            document.addEventListener('click', function(event) {
                if (isMenuOpen && !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                    isMenuOpen = false;
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    if (isMenuOpen) {
                        mobileMenu.classList.add('hidden');
                        menuIcon.classList.remove('fa-times');
                        menuIcon.classList.add('fa-bars');
                        isMenuOpen = false;
                    }
                }
            });

            const links = document.querySelectorAll('a[href]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.id === 'mobile-menu-button' || this.closest('#mobile-menu')) return;

                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>