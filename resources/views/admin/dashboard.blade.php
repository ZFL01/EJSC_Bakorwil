"@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class=\"space-y-6\">
    <!-- Stats Cards Grid -->
    <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4\">
        <div class=\"bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4\">
            <div class=\"w-12 h-12 bg-sky-50 text-sky-600 rounded-lg flex items-center justify-center font-bold text-xl\">
                🏢
            </div>
            <div>
                <p class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider\">Total Client (UMKM)</p>
                <h3 class=\"text-2xl font-bold text-gray-800\">{{ $stats->total_clients ?? 0 }}</h3>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4\">
            <div class=\"w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center font-bold text-xl\">
                🎓
            </div>
            <div>
                <p class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider\">Total Mentor</p>
                <h3 class=\"text-2xl font-bold text-gray-800\">{{ $stats->total_mentors ?? 0 }}</h3>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4\">
            <div class=\"w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center font-bold text-xl\">
                💡
            </div>
            <div>
                <p class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider\">Total Talenta</p>
                <h3 class=\"text-2xl font-bold text-gray-800\">{{ $stats->total_talents ?? 0 }}</h3>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4\">
            <div class=\"w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-bold text-xl\">
                📅
            </div>
            <div>
                <p class=\"text-xs font-semibold text-gray-500 uppercase tracking-wider\">Kegiatan Mendatang</p>
                <h3 class=\"text-2xl font-bold text-gray-800\">{{ $stats->upcoming_kegiatan ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Quick Links & Recent Actions -->
    <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-6\">
        <!-- Recent Activities (Audit Log) -->
        <div class=\"lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6\">
            <div class=\"flex justify-between items-center mb-4\">
                <h3 class=\"text-lg font-bold text-gray-800\">Aktivitas Terbaru Admin</h3>
                <a href=\"{{ route('admin.activity-logs') }}\" class=\"text-xs text-[#56b8c2] hover:underline font-medium\">Lihat Semua Audit Logs</a>
            </div>
            <div class=\"divide-y divide-gray-100\">
                @forelse($recentActivities as $log)
                    <div class=\"py-3 flex items-center justify-between text-sm\">
                        <div class=\"flex items-center gap-3\">
                            <span class=\"px-2 py-1 rounded text-xs font-semibold 
                                {{ $log->action === 'create' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $log->action === 'update' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $log->action === 'delete' ? 'bg-rose-100 text-rose-700' : '' }}\">
                                {{ strtoupper($log->action) }}
                            </span>
                            <span class=\"font-medium text-gray-700\">{{ $log->table_name }}</span>
                            <span class=\"text-gray-400 text-xs\">ID #{{ $log->record_id }}</span>
                        </div>
                        <span class=\"text-xs text-gray-400\">{{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}</span>
                    </div>
                @empty
                    <p class=\"text-sm text-gray-400 py-4 text-center\">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>
        </div>

        <!-- Mentors Availability & Quick Links -->
        <div class=\"space-y-6\">
            <div class=\"bg-white rounded-xl border border-gray-200 shadow-sm p-6\">
                <h3 class=\"text-lg font-bold text-gray-800 mb-4\">Status Mentor</h3>
                <div class=\"space-y-3\">
                    <div class=\"flex justify-between items-center text-sm\">
                        <span class=\"text-gray-600\">Mentor Available</span>
                        <span class=\"font-bold text-emerald-600\">{{ $mentorAvailability['available'] ?? 0 }}</span>
                    </div>
                    <div class=\"flex justify-between items-center text-sm\">
                        <span class=\"text-gray-600\">Mentor Full/Unavailable</span>
                        <span class=\"font-bold text-rose-600\">{{ $mentorAvailability['unavailable'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class=\"bg-white rounded-xl border border-gray-200 shadow-sm p-6\">
                <h3 class=\"text-lg font-bold text-gray-800 mb-4\">Aksi Cepat</h3>
                <div class=\"flex flex-col gap-2\">
                    <a href=\"{{ route('admin.clients.create') }}\" class=\"w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium py-2 rounded-lg border border-gray-200 transition\">+ Tambah Client</a>
                    <a href=\"{{ route('admin.mentors.create') }}\" class=\"w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium py-2 rounded-lg border border-gray-200 transition\">+ Tambah Mentor</a>
                    <a href=\"{{ route('admin.talents.create') }}\" class=\"w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium py-2 rounded-lg border border-gray-200 transition\">+ Tambah Talent</a>
                    <a href=\"{{ route('admin.kegiatans.create') }}\" class=\"w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium py-2 rounded-lg border border-gray-200 transition\">+ Tambah Kegiatan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
"