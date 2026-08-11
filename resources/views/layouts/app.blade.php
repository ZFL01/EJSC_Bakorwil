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
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 transition-all duration-300" style="z-index:99999!important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <span class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </span>
                        <span class="text-xl font-bold text-gray-900">EJSC <span class="text-indigo-600">Bakorwil</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <!-- Home -->
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md hover:bg-indigo-50 transition {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        Home
                    </a>

                    <!-- Menu Dropdown -->
                    <div class="relative menu-group">
                        <button data-menu="menu" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md hover:bg-indigo-50 transition flex items-center gap-1">
                            Menu
                            <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
<div id="menu-menu" class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden" style="z-index:99999!important;">
                            <a href="{{ route('mentor') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Mentor</a>
                            <a href="{{ route('talenta') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Talenta</a>
                            <a href="{{ route('client') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Client</a>
                            <a href="{{ route('gis') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">GIS Map</a>
                        </div>
                    </div>

                    <!-- Kelola Dropdown -->
                    <div class="relative menu-group">
                        <button data-menu="kelola" class="menu-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md hover:bg-indigo-50 transition flex items-center gap-1">
                            Kelola
                            <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="menu-kelola" class="menu-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 hidden" style="z-index:99999!important;">
                            <a href="{{ route('kelola.mentor') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Mentor</a>
                            <a href="{{ route('kelola.talenta') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Talenta</a>
                            <a href="{{ route('kelola.client') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Client</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
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
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Home</a>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</p>
<a href="{{ route('mentor') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Mentor</a>
                    <a href="{{ route('talenta') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Talenta</a>
                    <a href="{{ route('client') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Client</a>
                    <a href="{{ route('gis') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">GIS Map</a>
                </div>

                <div class="pt-2">
                    <p class="px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola</p>
                    <a href="{{ route('kelola.mentor') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Mentor</a>
                    <a href="{{ route('kelola.talenta') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Talenta</a>
                    <a href="{{ route('kelola.client') }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Kelola Client</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} EJSC Bakorwil. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Tentang</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Kontak</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Kebijakan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
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
        const menuGroups = document.querySelectorAll('.menu-group');
        document.querySelectorAll('.menu-btn').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const target = btn.getAttribute('data-menu');
                const dropdown = document.getElementById('menu-' + target);
                const arrow = btn.querySelector('.menu-arrow');
                const isHidden = dropdown.classList.contains('hidden');

                // Close all others
                document.querySelectorAll('.menu-dropdown').forEach(d => d.classList.add('hidden'));
                document.querySelectorAll('.menu-arrow').forEach(a => a.classList.remove('rotate-180'));

                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.menu-group')) {
                document.querySelectorAll('.menu-dropdown').forEach(d => d.classList.add('hidden'));
                document.querySelectorAll('.menu-arrow').forEach(a => a.classList.remove('rotate-180'));
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    @yield('scripts')
</body>
</html>
