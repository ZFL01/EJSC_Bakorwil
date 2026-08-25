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
            border-color: #35BFD1;
            box-shadow: 0 0 0 3px rgba(53, 191, 209, 0.12);
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


        /* =====================================================
           BACKGROUND
           DISESUAIKAN DENGAN HALAMAN DAFTAR
        ===================================================== */

        .mobile-container {
            position: relative;
            isolation: isolate;
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 12% 18%,
                    rgba(180, 242, 248, 0.70),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 88% 78%,
                    rgba(128, 226, 238, 0.55),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(190, 241, 247, 0.45),
                    transparent 35%
                ),

                linear-gradient(
                    135deg,
                    #72d6e3 0%,
                    #45c5d6 45%,
                    #8ddfe9 100%
                );
        }


        /* =====================================================
           BACKGROUND BUBBLES
        ===================================================== */

        .bubble {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            will-change: transform;

            background:
                radial-gradient(
                    circle at 30% 28%,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.12) 50%,
                    rgba(255,255,255,.035) 100%
                );

            border:
                1px solid rgba(255,255,255,.14);

            box-shadow:
                inset 0 0 30px rgba(255,255,255,.10),
                0 15px 45px rgba(0,120,150,.07);
        }


        /* =====================================================
           BUBBLE 1
           KIRI ATAS
        ===================================================== */

        .bubble-1 {
            width: 300px;
            height: 300px;

            top: -120px;
            left: -90px;

            animation:
                bubbleFloat1
                10s
                ease-in-out
                infinite;
        }


        /* =====================================================
           BUBBLE 2
           KANAN ATAS
        ===================================================== */

        .bubble-2 {
            width: 155px;
            height: 155px;

            top: 16%;
            right: -55px;

            background:
                radial-gradient(
                    circle at 35% 30%,
                    rgba(255,255,255,.28),
                    rgba(255,255,255,.08)
                );

            animation:
                bubbleFloat2
                8s
                ease-in-out
                infinite;
        }


        /* =====================================================
           BUBBLE 3
           KIRI BAWAH
        ===================================================== */

        .bubble-3 {
            width: 105px;
            height: 105px;

            bottom: 15%;
            left: 9%;

            background:
                rgba(255,255,255,.11);

            animation:
                bubbleFloat3
                7s
                ease-in-out
                infinite;
        }


        /* =====================================================
           BUBBLE 4
           KANAN BAWAH
        ===================================================== */

        .bubble-4 {
            width: 270px;
            height: 270px;

            bottom: -120px;
            right: -75px;

            background:
                radial-gradient(
                    circle at 35% 30%,
                    rgba(255,255,255,.27),
                    rgba(255,255,255,.08)
                );

            animation:
                bubbleFloat4
                11s
                ease-in-out
                infinite;
        }


        /* =====================================================
           BUBBLE 5
           KECIL TENGAH
        ===================================================== */

        .bubble-5 {
            width: 60px;
            height: 60px;

            top: 43%;
            right: 17%;

            background:
                rgba(255,255,255,.10);

            animation:
                bubbleFloat5
                6s
                ease-in-out
                infinite;
        }


        /* =====================================================
           BUBBLE ANIMATION
        ===================================================== */

        @keyframes bubbleFloat1 {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(35px, 25px)
                    scale(1.06);
            }
        }


        @keyframes bubbleFloat2 {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(-25px, 35px)
                    scale(1.08);
            }
        }


        @keyframes bubbleFloat3 {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(25px, -30px)
                    scale(1.12);
            }
        }


        @keyframes bubbleFloat4 {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(-35px, -25px)
                    scale(1.07);
            }
        }


        @keyframes bubbleFloat5 {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(-18px, -25px)
                    scale(1.15);
            }
        }


        /* =====================================================
           CARD TETAP DI ATAS BACKGROUND
        ===================================================== */

        .mobile-container > .card-mobile {
            position: relative;
            z-index: 10;
        }


        /* =====================================================
           TABLET
        ===================================================== */

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

            .bubble-1 {
                width: 190px;
                height: 190px;
                left: -85px;
                top: -70px;
            }

            .bubble-2 {
                width: 110px;
                height: 110px;
                right: -45px;
            }

            .bubble-3 {
                width: 75px;
                height: 75px;
            }

            .bubble-4 {
                width: 170px;
                height: 170px;
                right: -65px;
                bottom: -75px;
            }

            .bubble-5 {
                width: 45px;
                height: 45px;
            }
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 480px) {

            .logo-img {
                height: 36px;
                max-width: 140px;
            }

            .bubble-1 {
                width: 160px;
                height: 160px;
            }

            .bubble-2 {
                width: 90px;
                height: 90px;
            }

            .bubble-3 {
                width: 65px;
                height: 65px;
            }

            .bubble-4 {
                width: 145px;
                height: 145px;
            }

            .bubble-5 {
                width: 38px;
                height: 38px;
            }
        }


        /* =====================================================
           ACCESSIBILITY
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            .bubble {
                animation: none !important;
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

                    <a href="{{ route('public.index') }}"
                       class="flex items-center close-all-dropdowns">

                        <img src="{{ Vite::asset('resources/images/logo.png') }}"
                             alt="EJSC Bakorwil"
                             class="logo-img">

                    </a>

                </div>


                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">

                    <a href="{{ route('public.index') }}"
                       class="close-all-dropdowns px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#35BFD1] rounded-md hover:bg-[#f0fbfd] transition">

                        Home

                    </a>


                    <div class="relative menu-group">

                        <button data-menu="menu"
                                class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#35BFD1] rounded-md hover:bg-[#f0fbfd] transition flex items-center gap-1">

                            Menu

                            <svg class="w-4 h-4 menu-arrow transition-transform"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>

                            </svg>

                        </button>


                        <div id="menu-menu"
                             class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">

                            <a href="{{ route('mentor') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Mentor

                            </a>

                            <a href="{{ route('talenta') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Talenta

                            </a>

                            <a href="{{ route('client') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Client

                            </a>

                            <a href="{{ route('gis') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                GIS Map

                            </a>



                        <div id="menu-menu"
                             class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden">

                            <a href="{{ route('mentor') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Mentor

                            </a>

                            <a href="{{ route('talenta') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Talenta

                            </a>

                            <a href="{{ route('client') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                Client

                            </a>

                            <a href="{{ route('gis') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                                GIS Map

                            </a>

                        </div>


                    </div>



                </div>


                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">

                    <button id="mobile-menu-btn"
                            class="text-gray-700 hover:text-[#35BFD1] focus:outline-none p-2">

                        <svg class="w-6 h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>

                        </svg>

                    </button>

                </div>

            </div>

        </div>


        <!-- Mobile Menu -->
        <div id="mobile-menu"
             class="hidden md:hidden bg-white border-t border-gray-200">

            <div class="px-4 pt-2 pb-3 space-y-1">

                <a href="{{ route('public.index') }}"
                   class="close-all-dropdowns block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                    Home

                </a>


                <div class="pt-2">

                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">

                        Menu

                    </p>

                    <a href="{{ route('mentor') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Mentor

                    </a>

                    <a href="{{ route('talenta') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Talenta

                    </a>

                    <a href="{{ route('client') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Client

                    </a>

                    <a href="{{ route('gis') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        GIS Map

                    </a>


                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">

                        Menu

                    </p>

                    <a href="{{ route('mentor') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Mentor

                    </a>

                    <a href="{{ route('talenta') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Talenta

                    </a>

                    <a href="{{ route('client') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        Client

                    </a>

                    <a href="{{ route('gis') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0fbfd] hover:text-[#35BFD1]">

                        GIS Map

                    </a>

                </div>



            </div>

        </div>

    </nav>


    <!-- MAIN CONTENT: FORGOT PASSWORD FORM -->

    <main class="relative pt-20 md:pt-24 pb-10 min-h-screen flex items-center justify-center px-3 sm:px-4 md:px-6 mobile-container overflow-hidden">


        <!-- Background Bubbles -->

        <div class="bubble bubble-1"></div>

        <div class="bubble bubble-2"></div>

        <div class="bubble bubble-3"></div>

        <div class="bubble bubble-4"></div>

        <div class="bubble bubble-5"></div>


        <!-- Card -->

        <div class="relative z-10 w-full max-w-[440px] flex flex-col bg-white rounded-2xl overflow-hidden shadow-2xl border border-white/20 card-mobile">


            <!-- Top Accent / Branding -->

            <div class="relative h-32 md:h-36">

                <img alt="EJSC Forgot Password"
                     class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop&crop=center"
                     style="object-fit: cover;">

                <div class="absolute inset-0"
                     style="background: linear-gradient(135deg, rgba(53,191,209,0.92), rgba(21,149,167,0.92));">
                </div>

                <div class="relative h-full flex flex-col items-center justify-center px-6 text-center">

                    <img src="{{ Vite::asset('resources/images/logo.png') }}"
                         alt="EJSC Bakorwil"
                         class="h-14 md:h-16 w-auto mb-1.5 brightness-0 invert">

                    <p class="text-xs md:text-sm text-white/90">

                        Kami akan bantu kamu masuk kembali

                    </p>

                </div>

            </div>


            <!-- Forgot Password Form -->

            <div class="w-full px-6 md:px-8 py-6 md:py-7">

                <div class="mb-5 flex items-start gap-3">

                    <div class="w-10 h-10 rounded-full bg-[#effcff] flex items-center justify-center flex-shrink-0">

                        <span class="material-symbols-outlined text-[#35BFD1]"
                              style="font-size: 22px;">

                            lock_reset

                        </span>

                    </div>

                    <div>

                        <h1 class="text-xl font-bold text-gray-900 mb-1">

                            Lupa Password?

                        </h1>

                        <p class="text-sm text-gray-500">

                            Masukkan email akun kamu, kami akan kirim tautan untuk mengatur ulang password.

                        </p>

                    </div>

                </div>


                <!-- Success Message -->

                @if (session('status'))

                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-lg mb-4">

                        <div class="flex items-start gap-2">

                            <span class="material-symbols-outlined text-emerald-600 text-base">

                                check_circle

                            </span>

                            <p class="text-xs text-emerald-700">

                                {{ session('status') }}

                            </p>

                        </div>

                    </div>

                @endif


                <form method="POST"
                      action="{{ route('password.email') }}"
                      class="flex flex-col gap-4">

                    @csrf


                    <!-- Email Field -->

                    <div>

                        <label class="form-label"
                               for="email">

                            Email

                        </label>

                        <div class="relative">

                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">

                                mail

                            </span>

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

                            <p class="text-xs text-red-600 mt-1">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    <!-- General Error Messages -->

                    @if (session('error'))

                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">

                            <div class="flex items-start gap-2">

                                <span class="material-symbols-outlined text-red-500 text-base">

                                    error

                                </span>

                                <p class="text-xs text-red-700">

                                    {{ session('error') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    <!-- Submit Button -->

                    <button class="w-full text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm flex items-center justify-center gap-1.5"
                            style="background: linear-gradient(135deg, #35BFD1, #1595A7);"
                            type="submit">

                        <span class="material-symbols-outlined text-[18px]">

                            send

                        </span>

                        Kirim Tautan Reset

                    </button>


                    <!-- Back to Login Link -->

                    <p class="text-center text-sm text-gray-600 pt-1">

                        <a class="font-medium hover:underline inline-flex items-center gap-1"
                           href="{{ route('login') }}"
                           style="color: #35BFD1;">

                            <span class="material-symbols-outlined text-[16px]">

                                arrow_back

                            </span>

                            Kembali ke Masuk

                        </a>

                    </p>


                    <!-- Register Link -->

                    <p class="text-center text-sm text-gray-600">

                        Belum punya akun?

                        <a class="font-medium hover:underline"
                           href="{{ route('registrasi') }}"
                           style="color: #35BFD1;">

                            Daftar sekarang

                        </a>

                    </p>

                </form>

            </div>

        </div>

    </main>


    <script>

        function closeAllDropdowns() {

            document.querySelectorAll('.menu-dropdown').forEach(d =>
                d.classList.add('hidden')
            );

            document.querySelectorAll('.menu-arrow').forEach(a =>
                a.classList.remove('rotate-180')
            );

        }


        const navbar =
            document.getElementById('navbar');


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

                const target =
                    btn.getAttribute('data-menu');

                const dropdown =
                    document.getElementById('menu-' + target);

                const arrow =
                    btn.querySelector('.menu-arrow');

                const isHidden =
                    dropdown.classList.contains('hidden');


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

                const mobileMenu =
                    document.getElementById('mobile-menu');

                if (
                    mobileMenu &&
                    !mobileMenu.classList.contains('hidden')
                ) {

                    mobileMenu.classList.add('hidden');

                }

            });

        });


        const mobileMenuBtn =
            document.getElementById('mobile-menu-btn');

        const mobileMenu =
            document.getElementById('mobile-menu');


        mobileMenuBtn.addEventListener('click', (e) => {

            e.stopPropagation();

            mobileMenu.classList.toggle('hidden');


            const icon =
                mobileMenuBtn.querySelector('svg');


            if (!mobileMenu.classList.contains('hidden')) {

                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';

            } else {

                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';

            }

        });


        document.addEventListener('click', (e) => {

            if (
                !e.target.closest('#mobile-menu') &&
                !e.target.closest('#mobile-menu-btn')
            ) {

                mobileMenu.classList.add('hidden');


                const icon =
                    mobileMenuBtn.querySelector('svg');


                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';

            }

        });


        document.addEventListener('keydown', (e) => {

            if (e.key === 'Escape') {

                closeAllDropdowns();

                mobileMenu.classList.add('hidden');


                const icon =
                    mobileMenuBtn.querySelector('svg');


                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';

            }

        });


        document.addEventListener('DOMContentLoaded', function() {

            const alerts =
                document.querySelectorAll(
                    '.bg-red-50, .bg-emerald-50'
                );


            alerts.forEach(alert => {

                setTimeout(() => {

                    alert.style.transition =
                        'opacity 0.5s ease, transform 0.5s ease';

                    alert.style.opacity = '0';

                    alert.style.transform =
                        'translateY(-5px)';


                    setTimeout(() => {

                        alert.style.display = 'none';

                    }, 500);

                }, 5000);

            });

        });

    </script>

</body>
</html>
