<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - EJSC Bakorwil</title>
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

        .mobile-container {
            overflow-x: hidden;
            width: 100%;
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

            .card-mobile {
                margin-left: 12px;
                margin-right: 12px;
                width: calc(100% - 24px);
            }
        }

        @media (max-width: 480px) {
            .logo-img {
                height: 36px;
                max-width: 140px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 transition-all duration-300" style="z-index:99999!important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 md:h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center close-all-dropdowns">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="EJSC Bakorwil" class="logo-img">
                    </a>
                </div>

                <!-- Desktop Menu -->
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
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT: FORGOT PASSWORD FORM -->
    <main class="pt-20 md:pt-24 pb-10 min-h-screen flex items-center justify-center px-3 sm:px-4 md:px-6 bg-gradient-to-br from-[#56b8c2] to-[#3a8a92] mobile-container">

        <!-- Card -->
        <div class="w-full max-w-[440px] flex flex-col bg-white rounded-2xl overflow-hidden shadow-2xl border border-white/20 card-mobile">

            <!-- Top Accent / Branding -->
            <div class="relative h-32 md:h-36">
                <img alt="EJSC Forgot Password" class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop&crop=center"
                     style="object-fit: cover;">
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(86,184,194,0.92), rgba(58,138,146,0.92));"></div>
                <div class="relative h-full flex flex-col items-center justify-center px-6 text-center">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="EJSC Bakorwil" class="h-14 md:h-16 w-auto mb-1.5 brightness-0 invert">
                    <p class="text-xs md:text-sm text-white/90">Kami akan bantu kamu masuk kembali</p>
                </div>
            </div>

            <!-- Forgot Password Form -->
            <div class="w-full px-6 md:px-8 py-6 md:py-7">
                <div class="mb-5 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#f0f9fa] flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[#56b8c2]" style="font-size: 22px;">lock_reset</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 mb-1">Lupa Password?</h1>
                        <p class="text-sm text-gray-500">Masukkan email akun kamu, kami akan kirim tautan untuk mengatur ulang password.</p>
                    </div>
                </div>

                <!-- Success Message (muncul setelah link dikirim) -->
                @if (session('status'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-lg mb-4">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-base">check_circle</span>
                            <p class="text-xs text-emerald-700">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
                    @csrf

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
                                   autofocus
                                   type="email">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- General Error Messages -->
                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-red-500 text-base">error</span>
                                <p class="text-xs text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button class="w-full text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm flex items-center justify-center gap-1.5"
                            style="background: linear-gradient(135deg, #56b8c2, #3a8a92);"
                            type="submit">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Kirim Tautan Reset
                    </button>

                    <!-- Back to Login Link -->
                    <p class="text-center text-sm text-gray-600 pt-1">
                        <a class="font-medium hover:underline inline-flex items-center gap-1" href="{{ route('login') }}" style="color: #56b8c2;">
                            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                            Kembali ke Masuk
                        </a>
                    </p>

                    <!-- Register Link -->
                    <p class="text-center text-sm text-gray-600">
                        Belum punya akun? <a class="font-medium hover:underline" href="{{ route('registrasi') }}" style="color: #56b8c2;">Daftar sekarang</a>
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

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.bg-red-50, .bg-emerald-50');
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