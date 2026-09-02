<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - Bakorwil Jember</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Mobile Top Nav (fixed saat scroll) -->
        <div class="md:hidden sticky top-0 z-40 bg-slate-800 text-white p-4 flex justify-between items-center">
            <span class="font-bold text-lg">Admin Bakorwil</span>
            <button @click="sidebarOpen = !sidebarOpen" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Sidebar -->
        <!-- Sidebar (fixed di desktop, ikut scroll internal jika menu lebih panjang dari layar) -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" class="md:block md:sticky md:top-0 md:h-screen md:self-start md:overflow-y-auto w-full md:w-64 bg-slate-800 text-slate-100 flex-shrink-0">
            <div class="p-5 border-b border-slate-700 hidden md:block">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#56b8c2] to-[#2e8791] flex items-center justify-center shadow-lg shadow-[#56b8c2]/30 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-base font-bold text-white leading-tight truncate">Bakorwil Admin</h1>
                        <p class="text-xs text-slate-400">Management System</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen Data</div>

                <a href="{{ route('admin.clients.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.clients.*') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                    </svg>
                    Kelola Client
                </a>

                <a href="{{ route('admin.mentors.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.mentors.*') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    Kelola Mentor
                </a>

                <a href="{{ route('admin.talents.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.talents.*') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Kelola Talent
                </a>

                <a href="{{ route('admin.kegiatans.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.kegiatans.*') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Kelola Kegiatan
                </a>

                <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Sistem</div>

                <a href="{{ route('admin.activity-logs') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.activity-logs') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Audit Logs
                </a>

                <a href="{{ route('admin.users.pending') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.pending') ? 'bg-[#56b8c2] text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="flex-1">Persetujuan User</span>
                    @php
                        $pendingCount = \App\Models\User::where('status', 'pending')->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span class="text-xs font-bold bg-red-500 text-white rounded-full px-2 py-0.5">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('public.index') }}" target="_blank"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition mt-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Situs Publik
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar (fixed saat scroll di desktop) -->
            <header class="md:sticky md:top-0 md:z-30 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">@yield('header', 'Dashboard')</h2>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#56b8c2] to-[#2e8791] text-white flex items-center justify-center font-bold text-sm uppercase flex-shrink-0">
                            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="leading-tight">
                            <p class="text-sm font-semibold text-gray-800 max-w-[160px] truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-gray-400 capitalize">{{ auth()->user()->role ?? 'admin' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs bg-gray-100 hover:bg-red-50 text-red-600 px-3 py-1.5 rounded-md font-medium border border-gray-200 hover:border-red-200 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg text-sm flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
    @yield('scripts')
</body>
</html>