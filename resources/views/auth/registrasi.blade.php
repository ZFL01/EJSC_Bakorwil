<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - EJSC Bakorwil</title>
    <meta name="description" content="Platform untuk menghubungkan Mentor, Talenta, dan Client.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        html, body {
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        .navbar-scrolled {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
        }

        .logo-img {
            height: 56px;
            width: auto;
            max-width: 220px;
            display: block;
            object-fit: contain;
        }

        .menu-dropdown {
            z-index: 99999 !important;
        }

        /* Mobile specific - prevent horizontal scroll */
        .mobile-container {
            overflow-x: hidden;
            width: 100%;
        }

        .role-card {
            transition: all 0.2s ease;
        }

        .role-card:hover {
            transform: translateY(-1px);
        }

        .role-card input:checked + .role-card-inner {
            border-color: #56b8c2;
            background: rgba(86, 184, 194, 0.08);
            box-shadow: 0 0 0 2px rgba(86, 184, 194, 0.15);
        }

        .role-card-inner {
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
            padding: 12px 8px;
            border-radius: 12px;
            background: #f9fafb;
            text-align: center;
        }

        .role-card-inner:hover {
            background: #f0f9fa;
        }

        .role-card-inner .material-symbols-outlined {
            font-size: 26px;
        }

        .form-input {
            width: 100%;
            padding: 0.65rem 0.75rem 0.65rem 2.5rem;
            background: #f9fafb;
            border-radius: 0.6rem;
            border: 1px solid #e5e7eb;
            outline: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            color: #111827;
        }

        .form-input:focus {
            background: #ffffff;
            border-color: #56b8c2;
            box-shadow: 0 0 0 3px rgba(86, 184, 194, 0.12);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.3rem;
            display: block;
        }

        @media (max-width: 768px) {
            .logo-img {
                height: 44px;
                max-width: 160px;
            }

            .register-card-mobile {
                margin-left: 12px;
                margin-right: 12px;
                width: calc(100% - 24px);
            }

            .role-card-inner .material-symbols-outlined {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            .logo-img {
                height: 36px;
                max-width: 140px;
            }

            .role-card-inner {
                padding: 10px 4px;
            }

            .role-card-inner .material-symbols-outlined {
                font-size: 20px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- HEADER (tanpa tombol login dan daftar) -->
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 transition-all duration-300" style="z-index:99999!important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 md:h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center close-all-dropdowns">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="EJSC Bakorwil" class="logo-img">
                    </a>
                </div>

                <!-- Desktop Menu (tanpa tombol login/daftar) -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                       class="close-all-dropdowns px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition">
                        Home
                    </a>

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
                            <a href="{{ route('gis') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">GIS Map</a>
                        </div>
                    </div>

                    <div class="relative menu-group">
                        <button data-menu="kelola" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#56b8c2] rounded-md hover:bg-[#f0f9fa] transition flex items-center gap-1">
                            Kelola
                            <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="menu-kelola" class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">
                            <a href="{{ route('kelola.mentor') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Mentor</a>
                            <a href="{{ route('kelola.talenta') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Talenta</a>
                            <a href="{{ route('kelola.client') }}" class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Client</a>
                        </div>
                    </div>

                    <!-- TOMBOL LOGIN DAN DAFTAR DIHAPUS -->
                </div>

                <!-- Mobile Menu Button -->
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
                <a href="{{ route('home') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Home</a>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</p>
                    <a href="{{ route('mentor') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Mentor</a>
                    <a href="{{ route('talenta') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Talenta</a>
                    <a href="{{ route('client') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Client</a>
                    <a href="{{ route('gis') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">GIS Map</a>
                </div>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola</p>
                    <a href="{{ route('kelola.mentor') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Mentor</a>
                    <a href="{{ route('kelola.talenta') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Talenta</a>
                    <a href="{{ route('kelola.client') }}" class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#56b8c2]">Kelola Client</a>
                </div>

                <!-- TOMBOL LOGIN DAN DAFTAR DI MOBILE DIHAPUS -->
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT: REGISTER FORM -->
    <main class="pt-20 md:pt-24 pb-10 min-h-screen flex items-center justify-center px-3 sm:px-4 md:px-6 bg-gradient-to-br from-[#56b8c2] to-[#3a8a92] mobile-container">

        <!-- Register Container -->
        <div class="w-full max-w-[440px] flex flex-col bg-white rounded-2xl overflow-hidden shadow-2xl border border-white/20 register-card-mobile">

            <!-- Top Accent / Branding -->
            <div class="relative h-32 md:h-36">
                <img alt="EJSC Registration" class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop&crop=center"
                     style="object-fit: cover;">
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(86,184,194,0.92), rgba(58,138,146,0.92));"></div>
                <div class="relative h-full flex flex-col items-center justify-center px-6 text-center">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="EJSC Bakorwil" class="h-14 md:h-16 w-auto mb-1.5 brightness-0 invert">
                    <p class="text-xs md:text-sm text-white/90">Bergabung dengan ekosistem inovasi Jawa Timur</p>
                </div>
            </div>

            <!-- Register Form -->
            <div class="w-full px-6 md:px-8 py-6 md:py-7">
                <div class="mb-5">
                    <h1 class="text-xl font-bold text-gray-900 mb-1">Daftar Akun</h1>
                    <p class="text-sm text-gray-500">Lengkapi data di bawah untuk membuat akun baru</p>
                </div>

                <form method="POST" action="{{ route('registrasi') }}" class="flex flex-col gap-4">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <label class="form-label">Pilih Peran Utama</label>
                        <div class="grid grid-cols-3 gap-2">
                            <!-- Talent -->
                            <label class="role-card">
                                <input type="radio" name="role" value="talent" checked class="sr-only">
                                <div class="role-card-inner">
                                    <span class="material-symbols-outlined text-[#56b8c2]" style="font-variation-settings: 'FILL' 1;">emoji_objects</span>
                                    <p class="text-xs font-medium text-gray-700 mt-1">Talent</p>
                                </div>
                            </label>
                            <!-- Mentor -->
                            <label class="role-card">
                                <input type="radio" name="role" value="mentor" class="sr-only">
                                <div class="role-card-inner">
                                    <span class="material-symbols-outlined text-[#56b8c2]" style="font-variation-settings: 'FILL' 1;">school</span>
                                    <p class="text-xs font-medium text-gray-700 mt-1">Mentor</p>
                                </div>
                            </label>
                            <!-- Client -->
                            <label class="role-card">
                                <input type="radio" name="role" value="client" class="sr-only">
                                <div class="role-card-inner">
                                    <span class="material-symbols-outlined text-[#56b8c2]" style="font-variation-settings: 'FILL' 1;">domain</span>
                                    <p class="text-xs font-medium text-gray-700 mt-1">Client</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">person</span>
                            <input class="form-input"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required
                                   type="text">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">mail</span>
                            <input class="form-input"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required
                                   type="email">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="form-label" for="password">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">lock</span>
                            <input class="form-input"
                                   id="password"
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   type="password">
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">verified</span>
                            <input class="form-input"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="••••••••"
                                   required
                                   type="password">
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-red-500 text-base">error</span>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <p class="text-xs text-red-700">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-red-500 text-base">error</span>
                                <p class="text-xs text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Terms Agreement -->
                    <div class="flex items-start gap-2">
                        <input class="w-4 h-4 mt-0.5 rounded border-gray-300 focus:ring-[#56b8c2] transition-colors cursor-pointer"
                               type="checkbox"
                               name="terms"
                               id="terms"
                               required>
                        <label class="text-xs text-gray-600 cursor-pointer leading-relaxed" for="terms">
                            Saya setuju dengan <a class="text-[#56b8c2] hover:underline font-medium" href="#">Syarat & Ketentuan</a> dan <a class="text-[#56b8c2] hover:underline font-medium" href="#">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button class="w-full text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm"
                            style="background: linear-gradient(135deg, #56b8c2, #3a8a92);"
                            type="submit">
                        Daftar Sekarang
                    </button>

                    <!-- Divider -->
                    <div class="relative flex items-center py-1">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 px-3 text-xs text-gray-500">Atau daftar dengan</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <!-- SSO Buttons -->
                    <div class="flex gap-3">
                        <button class="flex-1 flex items-center justify-center gap-2 py-2 px-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-700 text-sm" type="button">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Google
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-2 py-2 px-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-700 text-sm" type="button">
                            <span class="material-symbols-outlined text-lg" style="color: #0a66c2; font-variation-settings: 'FILL' 1;">work</span>
                            LinkedIn
                        </button>
                    </div>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 pt-1">
                        Sudah punya akun? <a class="font-medium hover:underline" href="{{ route('login') }}" style="color: #56b8c2;">Masuk sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </main>

    <script>
        function closeAllDropdowns() {
            document.querySelectorAll('.menu-dropdown').forEach(d => d.classList.add('hidden'));
            document.querySelectorAll('.menu-arrow').forEach(a => a.classList.remove('rotate-180'));
        }

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        document.querySelectorAll('.menu-btn').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const target = btn.getAttribute('data-menu');
                const dropdown = document.getElementById('menu-' + target);
                const arrow = btn.querySelector('.menu-arrow');
                const isHidden = dropdown.classList.contains('hidden');

                closeAllDropdowns();

                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                }
            });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.menu-group')) {
                closeAllDropdowns();
            }
        });

        document.querySelectorAll('.close-all-dropdowns').forEach(link => {
            link.addEventListener('click', () => {
                closeAllDropdowns();
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');

            const icon = mobileMenuBtn.querySelector('svg');
            if (!mobileMenu.classList.contains('hidden')) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#mobile-menu') && !e.target.closest('#mobile-menu-btn')) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('svg');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllDropdowns();
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('svg');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        });

        // Role card selection styling
        document.querySelectorAll('.role-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.role-card-inner').forEach(card => {
                    card.style.borderColor = 'transparent';
                    card.style.background = '#f9fafb';
                });
                if (this.checked) {
                    const parent = this.closest('.role-card');
                    const inner = parent.querySelector('.role-card-inner');
                    inner.style.borderColor = '#56b8c2';
                    inner.style.background = 'rgba(86, 184, 194, 0.08)';
                }
            });
        });

        // Trigger initial state for checked radio
        document.querySelectorAll('.role-card input[type="radio"]:checked').forEach(radio => {
            const parent = radio.closest('.role-card');
            const inner = parent.querySelector('.role-card-inner');
            inner.style.borderColor = '#56b8c2';
            inner.style.background = 'rgba(86, 184, 194, 0.08)';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.bg-red-50');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-5px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>