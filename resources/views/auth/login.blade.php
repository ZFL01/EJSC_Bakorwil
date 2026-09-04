<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - EJSC Bakorwil</title>
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
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
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


        /* =========================================================
           BACKGROUND LOGIN
           DISAMAKAN DENGAN BACKGROUND DAFTAR SEKARANG
        ========================================================= */

        .mobile-container {
            overflow: hidden;
            width: 100%;
            position: relative;
            isolation: isolate;

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
                ) !important;
        }


        /* =========================================================
           BUBBLE BACKGROUND
           DISAMAKAN DENGAN DAFTAR SEKARANG
        ========================================================= */

        .mobile-container::before,
        .mobile-container::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }


        /* =========================================================
           BUBBLE KIRI ATAS
        ========================================================= */

        .mobile-container::before {
            width: 330px;
            height: 330px;

            top: -150px;
            left: -110px;

            background:
                radial-gradient(
                    circle at 30% 28%,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.12) 50%,
                    rgba(255,255,255,.035) 100%
                );

            border: 1px solid rgba(255,255,255,.14);

            box-shadow:
                inset 0 0 30px rgba(255,255,255,.10),
                0 15px 45px rgba(0,120,150,.07);

            filter: none;

            animation:
                bubbleTop
                10s
                ease-in-out
                infinite;
        }


        /* =========================================================
           BUBBLE KANAN BAWAH
        ========================================================= */

        .mobile-container::after {
            width: 400px;
            height: 400px;

            right: -170px;
            bottom: -180px;

            background:
                radial-gradient(
                    circle at 35% 30%,
                    rgba(255,255,255,.27),
                    rgba(255,255,255,.08)
                );

            border: 1px solid rgba(255,255,255,.14);

            box-shadow:
                inset 0 0 30px rgba(255,255,255,.10),
                0 15px 45px rgba(0,120,150,.07);

            filter: none;

            animation:
                bubbleBottom
                11s
                ease-in-out
                infinite;
        }


        /* =========================================================
           BUBBLE KECIL 1
        ========================================================= */

        .mobile-container .login-card-mobile::before {
            content: "";

            position: absolute;

            width: 110px;
            height: 110px;

            left: -55px;
            top: 30%;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 30% 28%,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.12) 50%,
                    rgba(255,255,255,.035) 100%
                );

            border: 1px solid rgba(255,255,255,.14);

            box-shadow:
                inset 0 0 30px rgba(255,255,255,.10),
                0 15px 45px rgba(0,120,150,.07);

            filter: none;

            pointer-events: none;

            animation:
                bubbleSmallOne
                7s
                ease-in-out
                infinite;

            z-index: -1;
        }


        /* =========================================================
           BUBBLE KECIL 2
        ========================================================= */

        .mobile-container .login-card-mobile::after {
            content: "";

            position: absolute;

            width: 75px;
            height: 75px;

            right: -35px;
            top: 20%;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 30% 28%,
                    rgba(255,255,255,.30),
                    rgba(255,255,255,.12) 50%,
                    rgba(255,255,255,.035) 100%
                );

            border: 1px solid rgba(255,255,255,.14);

            box-shadow:
                inset 0 0 30px rgba(255,255,255,.10),
                0 15px 45px rgba(0,120,150,.07);

            filter: none;

            pointer-events: none;

            animation:
                bubbleSmallTwo
                8s
                ease-in-out
                infinite;

            z-index: -1;
        }


        /* =========================================================
           SEMUA ISI MAIN TETAP DI ATAS BUBBLE
        ========================================================= */

        .mobile-container > * {
            position: relative;
            z-index: 1;
        }


        /* =========================================================
           ANIMASI BUBBLE ATAS
        ========================================================= */

        @keyframes bubbleTop {

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


        /* =========================================================
           ANIMASI BUBBLE BAWAH
        ========================================================= */

        @keyframes bubbleBottom {

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


        /* =========================================================
           ANIMASI BUBBLE KECIL 1
        ========================================================= */

        @keyframes bubbleSmallOne {

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


        /* =========================================================
           ANIMASI BUBBLE KECIL 2
        ========================================================= */

        @keyframes bubbleSmallTwo {

            0%, 100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            50% {
                transform:
                    translate(-18px, 30px)
                    scale(1.08);
            }

        }


        /* Mobile specific - prevent horizontal scroll */
        @media (max-width: 768px) {

            .logo-img {
                height: 44px;
                max-width: 160px;
            }

            .login-card-mobile {
                margin-left: 8px;
                margin-right: 8px;
                width: calc(100% - 16px);
            }
        }


        @media (max-width: 480px) {

            .logo-img {
                height: 36px;
                max-width: 140px;
            }
        }


        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {

            .mobile-container::before,
            .mobile-container::after,
            .mobile-container .login-card-mobile::before,
            .mobile-container .login-card-mobile::after {
                animation: none !important;
            }

        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 overflow-hidden">

    <!-- HEADER (tanpa tombol login dan daftar) -->
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
                       class="close-all-dropdowns px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#35BFD1] rounded-md hover:bg-[#f0f9fa] transition">

                        Home

                    </a>


                    <!-- Menu -->
                    <div class="relative menu-group">

                        <button data-menu="menu"
                                class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#35BFD1] rounded-md hover:bg-[#f0f9fa] transition flex items-center gap-1">

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
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                                Mentor

                            </a>

                            <a href="{{ route('talenta') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                                Talenta

                            </a>

                            <a href="{{ route('client') }}"
                               class="close-all-dropdowns block px-4 py-2 text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                                Client

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
                                  d="M4 6h16M4 12h16M4 18h-16"/>

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
                   class="close-all-dropdowns block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                    Home

                </a>


                <div class="pt-2">

                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">

                        Menu

                    </p>

                    <a href="{{ route('mentor') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                        Mentor

                    </a>

                    <a href="{{ route('talenta') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                        Talenta

                    </a>

                    <a href="{{ route('client') }}"
                       class="close-all-dropdowns block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-[#f0f9fa] hover:text-[#35BFD1]">

                        Client

                    </a>

                </div>



            </div>

        </div>

    </nav>


    <!-- MAIN CONTENT: LOGIN FORM -->

    <main class="mt-14 md:mt-16 h-[calc(100vh-3.5rem)] md:h-[calc(100vh-4rem)] flex items-center justify-center overflow-y-auto px-3 sm:px-4 md:px-6 py-2 mobile-container">


        <!-- Login Container -->
        <div class="w-full max-w-[700px] max-h-full flex flex-col md:flex-row bg-white rounded-xl overflow-hidden shadow-xl border border-white/20 login-card-mobile">


            <!-- Left Side: Visual / Branding -->
            <div class="hidden md:block w-2/5 relative">

                <img alt="EJSC Workspace"
                     class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&crop=center"
                     style="object-fit: cover;">

                <div class="absolute inset-0"
                     style="background: linear-gradient(to top, rgba(53, 191, 209, 0.9) 0%, rgba(53, 191, 209, 0.3) 50%, transparent 100%);">
                </div>

                <div class="absolute inset-0 flex flex-col justify-end p-5">

                    <h2 class="text-xl font-bold text-white mb-1">

                        Kolaborasi<br/>Tanpa Batas

                    </h2>

                    <p class="text-xs text-white/90 max-w-md">

                        Bergabunglah dengan ekosistem inovasi terbesar di Jawa Timur.

                    </p>

                </div>

            </div>


            <!-- Right Side: Login Form -->
            <div class="w-full md:w-3/5 p-4 md:p-5 flex flex-col justify-center overflow-y-auto">


                <!-- Mobile Brand -->
                <div class="md:hidden flex items-center justify-center mb-3">

                    <img src="{{ Vite::asset('resources/images/logo.png') }}"
                         alt="EJSC Bakorwil"
                         class="h-10 w-auto">

                </div>


                <div class="mb-3 text-center md:text-left">

                    <h1 class="text-lg md:text-xl font-bold text-gray-900 mb-0.5">

                        Selamat Datang

                    </h1>

                    <p class="text-sm text-gray-600">

                        Masuk ke akun EJSC Anda

                    </p>

                </div>


                <form method="POST"
                      action="{{ route('login') }}"
                      class="flex flex-col gap-2.5">

                    @csrf


                    <!-- Email Field -->
                    <div class="flex flex-col gap-0.5">

                        <label class="text-sm font-medium text-gray-700"
                               for="email">

                            Email

                        </label>

                        <div class="relative">

                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-lg">

                                mail

                            </span>

                            <input class="w-full pl-10 pr-3 py-2 bg-gray-50 rounded-lg border border-gray-300 focus:border-[#35BFD1] focus:ring-1 focus:ring-[#35BFD1] outline-none transition-colors duration-200 text-sm text-gray-900 placeholder:text-gray-400"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required
                                   type="email">

                        </div>

                        @error('email')

                            <p class="text-xs text-red-600 mt-0.5">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    <!-- Password Field -->
                    <div class="flex flex-col gap-0.5">

                        <label class="text-sm font-medium text-gray-700"
                               for="password">

                            Password

                        </label>

                        <div class="relative">

                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-lg">

                                lock

                            </span>

                            <input class="w-full pl-10 pr-10 py-2 bg-gray-50 rounded-lg border border-gray-300 focus:border-[#35BFD1] focus:ring-1 focus:ring-[#35BFD1] outline-none transition-colors duration-200 text-sm text-gray-900 placeholder:text-gray-400"
                                   id="password"
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   type="password">

                            <button aria-label="Toggle password visibility"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                    type="button"
                                    onclick="togglePassword()">

                                <span class="material-symbols-outlined text-lg"
                                      id="toggleIcon">

                                    visibility

                                </span>

                            </button>

                        </div>

                        @error('password')

                            <p class="text-xs text-red-600 mt-0.5">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    <!-- Error Messages -->
                    @if ($errors->any())

                        <div class="bg-red-50 border-l-4 border-red-500 p-2 rounded-lg">

                            <div class="flex items-start gap-1.5">

                                <span class="material-symbols-outlined text-red-500 text-base">

                                    error

                                </span>

                                <div>

                                    @foreach ($errors->all() as $error)

                                        <p class="text-xs text-red-700">

                                            {{ $error }}

                                        </p>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    @endif


                    @if (session('success'))

                        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-2 rounded-lg">

                            <div class="flex items-start gap-1.5">

                                <span class="material-symbols-outlined text-emerald-500 text-base">

                                    check_circle

                                </span>

                                <p class="text-xs text-emerald-700">

                                    {{ session('success') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    @if (session('error'))

                        <div class="bg-red-50 border-l-4 border-red-500 p-2 rounded-lg">

                            <div class="flex items-start gap-1.5">

                                <span class="material-symbols-outlined text-red-500 text-base">

                                    error

                                </span>

                                <p class="text-xs text-red-700">

                                    {{ session('error') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-1.5 cursor-pointer group">

                            <input class="w-4 h-4 rounded border-gray-300 focus:ring-[#35BFD1] transition-colors cursor-pointer"
                                   type="checkbox"
                                   name="remember"
                                   id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>

                            <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">

                                Ingat saya

                            </span>

                        </label>


                        <a class="text-sm hover:underline transition-all"
                           href="{{ route('forgot-password') }}"
                           style="color: #35BFD1;">

                            Lupa password?

                        </a>

                    </div>


                    <!-- Submit Button -->
                    <button class="mt-0.5 w-full text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2 text-sm"
                            style="background: linear-gradient(135deg, #35BFD1, #239EAF);"
                            type="submit">

                        Masuk

                    </button>


                    <!-- Divider -->
                    <div class="relative flex items-center py-1">

                        <div class="flex-grow border-t border-gray-200"></div>

                        <span class="flex-shrink-0 px-2 text-xs text-gray-500">

                            Atau masuk dengan

                        </span>

                        <div class="flex-grow border-t border-gray-200"></div>

                    </div>


                    <!-- SSO Buttons -->
                    <div class="flex gap-2">

                        <a class="flex-1 flex items-center justify-center gap-1.5 py-1.5 px-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-700 text-sm"
                           href="{{ route('google.redirect') }}">

                            <svg class="w-4 h-4"
                                 viewBox="0 0 24 24">

                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"
                                      fill="#4285F4"/>

                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                      fill="#34A853"/>

                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                      fill="#FBBC05"/>

                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                      fill="#EA4335"/>

                            </svg>

                            Google

                        </a>


                        <a class="flex-1 flex items-center justify-center gap-1.5 py-1.5 px-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-700 text-sm"
                            href="{{ route('linkedin.redirect') }}">

                                <svg class="w-4 h-4"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    style="color: #0A66C2;">

                                    <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04
                                            -1.85 0-2.14 1.45-2.14 2.94v5.67H9.34V8.99h3.42v1.56h.05
                                            c.48-.9 1.64-1.85 3.37-1.85 3.61 0 4.27 2.38 4.27 5.48v6.27z
                                            M5.32 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14z
                                            M7.1 20.45H3.55V8.99H7.1v11.46z
                                            M22.22 0H1.78C.8 0 0 .78 0 1.74v20.52C0 23.22.8 24 1.78 24
                                            h20.44c.98 0 1.78-.78 1.78-1.74V1.74C24 .78 23.2 0 22.22 0z"/>
                                </svg>

                                LinkedIn

                            </a>

                    </div>


                    <!-- Sign Up Link -->
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


        function togglePassword() {

            const passwordInput =
                document.getElementById('password');

            const toggleIcon =
                document.getElementById('toggleIcon');


            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                toggleIcon.textContent =
                    'visibility_off';

            } else {

                passwordInput.type = 'password';

                toggleIcon.textContent =
                    'visibility';

            }

        }


        document.addEventListener('DOMContentLoaded', function() {

            const alerts =
                document.querySelectorAll('.bg-red-50');

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
