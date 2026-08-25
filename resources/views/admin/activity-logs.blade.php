@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('header', 'Audit Logs')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <form action="{{ route('admin.activity-logs') }}" method="GET" class="bg-white p-4 rounded-xl border border-gray-200 flex flex-wrap gap-2 items-center">
        <input type="text" name="table_name" value="{{ request('table_name') }}" placeholder="Nama tabel (mis. client)"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">

        <select name="action" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
            <option value="">-- Semua Aksi --</option>
            @foreach(['create', 'update', 'delete'] as $act)
                <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ ucfirst($act) }}</option>
            @endforeach
        </select>

        <input type="date" name="date_from" value="{{ request('date_from') }}" title="Dari tanggal"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
        <span class="text-sm text-gray-400">s/d</span>
        <input type="date" name="date_to" value="{{ request('date_to') }}" title="Sampai tanggal"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">

        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        <a href="{{ route('admin.activity-logs') }}" class="text-sm text-gray-500 hover:text-gray-700 hover:underline">Reset</a>
    </form>

    <!-- Tabel Log -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Waktu</th>
                        <th class="p-4">Admin</th>
                        <th class="p-4">Aksi</th>
                        <th class="p-4">Tabel</th>
                        <th class="p-4">Record</th>
                        <th class="p-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="p-4 whitespace-nowrap">
                                <p class="text-gray-800 font-medium">{{ $log->created_at?->format('d M Y H:i') ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $log->created_at?->diffForHumans() ?? '' }}</p>
                            </td>
                            <td class="p-4 text-gray-700">{{ $log->user?->name ?? 'Sistem' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $log->action === 'create' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $log->action === 'update' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $log->action === 'delete' ? 'bg-rose-100 text-rose-700' : '' }}
                                    {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ strtoupper($log->action) }}
                                </span>
                            </td>
                            <td class="p-4 font-medium text-gray-700">{{ $log->table_name }}</td>
                            <td class="p-4 text-gray-500">#{{ $log->record_id ?? '-' }}</td>
                            <td class="p-4 text-gray-400 font-mono text-xs">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Belum ada aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
