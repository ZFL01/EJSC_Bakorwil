<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EJSC Bakorwil')</title>
    <meta name="description" content="Platform untuk menghubungkan Mentor, Talenta, dan Client.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .navbar-scrolled {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
        }
        /* Warna aksen tombol & shadow */
        .btn-login {
            background-color: #56b8c2;
            color: white;
            padding: 8px 20px;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(86, 184, 194, 0.3);
        }
        .btn-login:hover {
            background-color: #3d9aa3;
            box-shadow: 0 6px 16px rgba(86, 184, 194, 0.4);
            transform: translateY(-1px);
        }
        /* Logo image */
        .logo-img {
            height: 68px;
            width: auto;
            max-width: 260px;
            display: block;
            object-fit: contain;
        }
        /* dropdown tetap rapi */
        .menu-dropdown {
            z-index: 99999 !important;
        }
        /* Style untuk mobile login button */
        .btn-login-mobile {
            background-color: #56b8c2;
            color: white;
            padding: 6px 16px;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(86, 184, 194, 0.3);
        }
        .btn-login-mobile:hover {
            background-color: #3d9aa3;
            box-shadow: 0 4px 12px rgba(86, 184, 194, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased bg-gray-50 text-gray-900">
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 transition-all duration-300" style="z-index:99999!important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo with image -->
                <div class="flex items-center">
                    <a href="{{ route('public.index') }}" class="flex items-center close-all-dropdowns">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="EJSC Bakorwil" class="logo-img">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <!-- Home -->
                    <a href="{{ route('public.index') }}"
                       class="close-all-dropdowns px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition {{ request()->routeIs('public.index') ? 'text-[#56b8c2] bg-[#f0f9fa]' : '' }}">
                        Home
                    </a>

                    <!-- Tentang Kami Dropdown -->
                    <div class="relative menu-group">
                        <button data-menu="tentang" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition flex items-center gap-1 {{ request()->routeIs('tentang-kami') ? 'text-[#56b8c2] bg-[#f0f9fa]' : '' }}">
                            Tentang Kami
                            <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="menu-tentang" class="menu-dropdown absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">
                            <a href="{{ route('tentang-kami') }}#about" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2] {{ request()->routeIs('tentang-kami') ? 'text-[#56b8c2] bg-[#f0f9fa]' : '' }}">Tentang Kami</a>
                            <a href="{{ route('tentang-kami') }}#fasilitas" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Fasilitas</a>
                            <a href="{{ route('tentang-kami') }}#kegiatan" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kegiatan</a>
                        </div>
                    </div>

                    <!-- Menu Dropdown -->
                    <div class="relative menu-group">
                        <button data-menu="menu" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition flex items-center gap-1">
                            Menu
                            <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="menu-menu" class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">
                            <a href="{{ route('mentor') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Mentor</a>
                            <a href="{{ route('talenta') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Talenta</a>
                            <a href="{{ route('client') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Client</a>
                        </div>
                    </div>

                    @guest
                        <!-- LOGIN BUTTON (aksen #56b8c2 + shadow) -->
                        <a href="{{ route('login') }}" class="btn-login ml-2 close-all-dropdowns">
                            Login
                        </a>
                    @else
                        <!-- USER DROPDOWN (saat sudah login) -->
                        <div class="relative menu-group">
                            <button data-menu="user" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition flex items-center gap-1 max-w-[200px]">
                                <span class="truncate">{{ auth()->user()->name ?? 'Akun' }}</span>
                                <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="menu-user" class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="close-all-dropdowns flex items-center gap-2 px-4 py-2 text-sm font-semibold text-[#56b8c2] hover:bg-[#f0f9fa]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Panel Admin
                                    </a>
                                    <div class="my-1 border-t border-gray-100"></div>
                                @endif
                                <a href="{{ route('profile.show') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button - TANPA tombol login terpisah -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-[#56b8c2] focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('public.index') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Home</a>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tentang Kami</p>
                    <a href="{{ route('tentang-kami') }}#about" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Tentang Kami</a>
                    <a href="{{ route('tentang-kami') }}#fasilitas" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Fasilitas</a>
                    <a href="{{ route('tentang-kami') }}#kegiatan" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kegiatan</a>
                </div>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</p>
                    <a href="{{ route('mentor') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Mentor</a>
                    <a href="{{ route('talenta') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Talenta</a>
                    <a href="{{ route('client') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Client</a>
                </div>

                @guest
                    <!-- Login di mobile - hanya muncul dalam menu dropdown -->
                    <div class="pt-3 border-t border-gray-100">
                        <a href="{{ route('login') }}" class="close-all-dropdowns block w-full text-center btn-login">
                            Login
                        </a>
                    </div>
                @else
                    <!-- Akun di mobile (saat sudah login) -->
                    <div class="pt-3 border-t border-gray-100">
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="close-all-dropdowns flex items-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-[#56b8c2] hover:bg-[#f0f9fa]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Panel Admin
                            </a>
                        @endif
                        <a href="{{ route('profile.show') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">
                            {{ auth()->user()->name ?? 'Akun' }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main class="pt-16 flex-1">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} EJSC Bakorwil. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-[#56b8c2]">Tentang</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-[#56b8c2]">Kontak</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-[#56b8c2]">Kebijakan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Function to close all dropdowns
        function closeAllDropdowns() {
            document.querySelectorAll('.menu-dropdown').forEach(d => d.classList.add('hidden'));
            document.querySelectorAll('.menu-arrow').forEach(a => a.classList.remove('rotate-180'));
        }

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Dropdown menus
        document.querySelectorAll('.menu-btn').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const target = btn.getAttribute('data-menu');
                const dropdown = document.getElementById('menu-' + target);
                const arrow = btn.querySelector('.menu-arrow');
                const isHidden = dropdown.classList.contains('hidden');

                // Close all others
                closeAllDropdowns();

                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.menu-group')) {
                closeAllDropdowns();
            }
        });

        // Close dropdowns when clicking on any navigation link
        document.querySelectorAll('.close-all-dropdowns').forEach(link => {
            link.addEventListener('click', () => {
                closeAllDropdowns();
                // Also close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
            
            // Toggle icon between hamburger and X
            const icon = mobileMenuBtn.querySelector('svg');
            if (!mobileMenu.classList.contains('hidden')) {
                // Menu is open, show X icon
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                // Menu is closed, show hamburger icon
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#mobile-menu') && !e.target.closest('#mobile-menu-btn')) {
                mobileMenu.classList.add('hidden');
                // Reset icon to hamburger
                const icon = mobileMenuBtn.querySelector('svg');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });

        // Close dropdowns on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllDropdowns();
                mobileMenu.classList.add('hidden');
                // Reset icon to hamburger
                const icon = mobileMenuBtn.querySelector('svg');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });
    </script>
    @yield('scripts')
</body>
</html>