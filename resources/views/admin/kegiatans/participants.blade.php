@extends('layouts.admin')

@section('title', 'Kelola Peserta')
@section('header', 'Kelola Peserta: ' . $kegiatan->judul_kegiatan)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-200">
        <div>
            <p class="text-sm text-gray-600">Total Peserta: <span class="font-bold text-[#56b8c2]">{{ $participants->total() }}</span></p>
        </div>
        <a href="{{ route('admin.kegiatans.show', $kegiatan->id_kegiatan) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
            Kembali ke Detail Kegiatan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal Daftar</th>
                        <th class="p-4">Kehadiran</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($participants as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-800">{{ $p->user->name ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $p->user->email ?? '-' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $p->status === 'registered' ? 'bg-sky-100 text-sky-700' : '' }}
                                    {{ $p->status === 'confirmed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $p->status === 'attended' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $p->status === 'cancelled' ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600">{{ $p->registered_at ? $p->registered_at->format('d M Y H:i') : '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $p->attended_at ? $p->attended_at->format('d M Y H:i') : '-' }}</td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.kegiatans.participants.update-status', [$kegiatan->id_kegiatan, $p->id_participant]) }}" method="POST" class="flex items-center justify-end gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                                        <option value="registered" {{ $p->status === 'registered' ? 'selected' : '' }}>Registered</option>
                                        <option value="confirmed" {{ $p->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="attended" {{ $p->status === 'attended' ? 'selected' : '' }}>Attended</option>
                                        <option value="cancelled" {{ $p->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="text-[#56b8c2] hover:underline font-medium text-xs">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Belum ada peserta yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($participants->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
