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
        
        /* Smooth floating navbar animation */
        #liquid-navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Enhanced glassmorphism effect */
        .glass-effect {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: linear-gradient(135deg, rgba(255,255,255,0.6) 30%, rgba(240,248,255,0.4) 70%);
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }
        
        /* Floating navbar specific styles */
        .floating-navbar {
            border-radius: 1.5rem !important;
            max-width: 64rem;
            width: 95vw;
        }
        
        @media (max-width: 768px) {
            .floating-navbar {
                width: 98vw;
                max-width: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="hidden my-4 px-6 py-4 lg:flex justify-between items-center">
        <figure class="flex flex-col py-2 gap-y-2 gap-x-4 lg:flex-row">
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
    <nav id="liquid-navbar" class="sticky top-0 z-50 bg-white/40 backdrop-blur-xl border border-white/60 shadow-2xl mt-0" style="background: linear-gradient(120deg, rgba(255,255,255,0.45) 60%, rgba(230,245,255,0.25) 100%); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);">
        <div class="container mx-auto px-0">
            <!-- Bottom Bar - Navigation Menu -->
            <div class="z-50 border-t border-white/30 py-3 bg-transparent">
                <div class="flex flex-col items-center">
                    <!-- Desktop Menu - Right aligned -->
                    <div class="hidden lg:flex desktop-menu-container justify-between items-center w-full px-4">
                        <!-- Logo and Title Section -->
                        <div class="flex items-center gap-3 ml-4">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('image/logo/jalan-peduli.png') }}" alt="Logo Jalan Peduli" class="h-8 w-auto max-w-[32px]" style="object-fit: contain;" />
                            </div>
                            <span class="text-gray-700 font-semibold text-base">Jalan Peduli</span>
                        </div>
                        
                        <!-- Menu Navigation -->
                        <div class="flex space-x-2">
                            <a href="{{ route('guest.jalan-peduli.index') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'home' ? 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-blue-600 bg-white/70 font-semibold shadow-sm' : 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-white/50' }} transition-all duration-300">
                                <i class="fas fa-home text-sm"></i>
                                <span class="text-sm font-medium">Menu Jalan Peduli</span>
                            </a>

                            <a href="{{ route('guest.jalan-peduli.laporan.create') }}"
                                class="desktop-menu-item flex items-center space-x-2 px-4 py-2.5 rounded-xl transition-all duration-300
                                {{ Route::currentRouteName() == 'guest.jalan-peduli.laporan.create' ? 'text-blue-600 bg-white/70 font-semibold shadow-sm' : 'text-gray-700 hover:text-blue-600 hover:bg-white/50' }}
                                group">
                                 <span class="w-5 h-5 flex items-center justify-center border rounded-full transition-all duration-300
                                      {{ Route::currentRouteName() == 'guest.jalan-peduli.laporan.create'
                                            ? 'border-blue-600 text-blue-600'
                                            : 'border-gray-600 text-gray-600 group-hover:border-blue-600 group-hover:text-blue-600' }}">
                                      <i class="fas fa-plus text-xs"></i>
                                 </span>
                                 <span class="text-sm font-medium">Buat Laporan</span>
                            </a>

                            <a href="{{ route('laporan.data') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'laporan.data' ? 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-blue-600 bg-white/70 font-semibold shadow-sm' : 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-white/50' }} transition-all duration-300">
                                <i class="fas fa-search text-sm"></i>
                                <span class="text-sm font-medium">Cek Status</span>
                            </a>

                            <a href="{{ route('laporan.public.map') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'laporan.public.map' ? 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-blue-600 bg-white/70 font-semibold shadow-sm' : 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-white/50' }} transition-all duration-300">
                                <i class="fas fa-map-marked-alt text-sm"></i>
                                <span class="text-sm font-medium">Peta Laporan</span>
                            </a>

                            <a href="{{ route('faq') }}" class="desktop-menu-item {{ Route::currentRouteName() == 'faq' ? 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-blue-600 bg-white/70 font-semibold shadow-sm' : 'flex items-center space-x-2 px-4 py-2.5 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-white/50' }} transition-all duration-300">
                                <i class="fas fa-question-circle text-sm"></i>
                                <span class="text-sm font-medium">FAQ</span>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button with Title -->
                    <div class="lg:hidden flex justify-end items-center w-full pr-4 pl-2 gap-3">
                        <div class="flex items-center justify-center mr-2">
                            <img src="{{ asset('image/logo/jalan-peduli.png') }}" alt="Logo Jalan Peduli" class="h-7 w-auto max-w-[28px]" style="object-fit: contain;" />
                        </div>
                        <span class="text-gray-700 font-semibold text-sm mr-auto">Jalan Peduli</span>
                        <button id="mobile-menu-button" aria-label="Buka menu navigasi" class="touch-target flex items-center justify-center p-3 rounded-full shadow-lg bg-white/80 border border-white/60 text-blue-600 hover:bg-white hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 flex-shrink-0 backdrop-blur-sm">
                            <i id="menu-icon" class="fas fa-bars text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden fixed top-19 left-0 w-full z-40 pb-2 px-4">
                <div class="bg-white rounded-xl custom-shadow p-2 slide-in-from-right">
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Menu Jalan Peduli -->
                        <a href="{{ route('guest.jalan-peduli.index') }}" class="{{ Route::currentRouteName() == 'guest.jalan-peduli.index' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600' }} transition-all duration-300">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-center">Menu Jalan Peduli</span>
                        </a>

                        <!-- Buat Laporan -->
                        <a href="{{ route('guest.jalan-peduli.laporan.create') }}" class="{{ Route::currentRouteName() == 'guest.jalan-peduli.laporan.create' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600' }} transition-all duration-300">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-center">Buat Laporan</span>
                        </a>

                        <!-- Cek Status -->
                        <a href="{{ route('laporan.data') }}" class="{{ Route::currentRouteName() == 'laporan.data' ? 'flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex flex-col items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition-all duration-300">
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

                    <!-- FAQ Section - Full Width -->
                    <div class="mt-2">
                        <a href="{{ route('faq') }}" class="{{ Route::currentRouteName() == 'faq' ? 'flex items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 active-indicator' : 'flex items-center justify-center p-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all duration-300">
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-question-circle text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Frequently Asked Questions</span>
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

            // Navbar floating animation on scroll
            const navbar = document.getElementById('liquid-navbar');
            let lastScrollY = window.scrollY;
            let isScrolled = false;
            
            function handleNavbarScroll() {
                const currentScrollY = window.scrollY;
                
                if (currentScrollY > 100 && !isScrolled) {
                    // Floating state
                    isScrolled = true;
                    navbar.style.transform = 'translateX(-50%) scale(0.95)';
                    navbar.classList.add('fixed', 'left-1/2', 'top-6', 'rounded-3xl', 'w-[95vw]', 'max-w-4xl', 'shadow-xl');
                    navbar.classList.remove('sticky', 'top-0', 'w-full', 'mt-0');
                    navbar.style.background = 'linear-gradient(135deg, rgba(255,255,255,0.6) 30%, rgba(240,248,255,0.4) 70%)';
                    navbar.style.backdropFilter = 'blur(20px)';
                    navbar.style.border = '1px solid rgba(255,255,255,0.8)';
                    
                    // Add separator to logo section
                    const logoSection = navbar.querySelector('.flex.items-center.gap-3');
                    if (logoSection && !logoSection.querySelector('.separator')) {
                        const separator = document.createElement('span');
                        separator.className = 'separator text-gray-400 text-lg font-light mx-2';
                        separator.textContent = '|';
                        logoSection.appendChild(separator);
                    }
                    
                    // Animate container padding for better mobile spacing
                    const container = navbar.querySelector('.container');
                    if (container) {
                        container.style.padding = '0 1rem';
                    }
                    
                } else if (currentScrollY <= 50 && isScrolled) {
                    // Normal state
                    isScrolled = false;
                    navbar.style.transform = 'translateX(0) scale(1)';
                    navbar.classList.remove('fixed', 'left-1/2', 'top-6', 'rounded-3xl', 'w-[95vw]', 'max-w-4xl', 'shadow-xl');
                    navbar.classList.add('sticky', 'top-0', 'w-full', 'mt-0');
                    navbar.style.background = 'linear-gradient(120deg, rgba(255,255,255,0.45) 60%, rgba(230,245,255,0.25) 100%)';
                    navbar.style.backdropFilter = 'blur(16px)';
                    navbar.style.border = '1px solid rgba(255,255,255,0.6)';
                    
                    // Remove separator from logo section
                    const separator = navbar.querySelector('.separator');
                    if (separator) {
                        separator.remove();
                    }
                    
                    // Reset container padding
                    const container = navbar.querySelector('.container');
                    if (container) {
                        container.style.padding = '0';
                    }
                }
                
                lastScrollY = currentScrollY;
            }
            window.addEventListener('scroll', handleNavbarScroll);
            handleNavbarScroll();

            // Mobile menu logic (unchanged)
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