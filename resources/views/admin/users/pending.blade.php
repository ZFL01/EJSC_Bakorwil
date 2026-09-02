@extends('layouts.admin')

@section('title', 'Persetujuan User')
@section('header', 'Persetujuan User (Google)')

@section('content')
@php($pendingUsers = $pendingUsers ?? collect())
<div class="space-y-6">

    <!-- Flash success/error sudah ditampilkan oleh layouts/admin.blade.php -->

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">User Menunggu Persetujuan</h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Akun hasil pendaftaran via Google dengan status <span class="font-medium">pending</span>.
                    Setujui agar user dapat login.
                </p>
            </div>
            <span class="text-xs font-medium text-white bg-[#56b8c2] rounded-full px-2.5 py-1">
                {{ $pendingUsers->count() }} user
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Peran</th>
                        <th class="p-4">Daftar Pada</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pendingUsers as $pendingUser)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-800">{{ $pendingUser->name }}</td>
                            <td class="p-4 text-gray-600">{{ $pendingUser->email }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $pendingUser->role === 'mentor' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $pendingUser->role === 'talenta' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $pendingUser->role === 'client' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ !in_array($pendingUser->role, ['mentor', 'talenta', 'client']) ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ ucfirst($pendingUser->role) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 text-xs">{{ $pendingUser->created_at?->format('d M Y H:i') }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.users.approve', $pendingUser) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.reject', $pendingUser) }}" method="POST" class="inline ml-1"
                                      onsubmit="return confirm('Tolak dan hapus akun {{ $pendingUser->email }}?');">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 text-sm">
                                Tidak ada user yang menunggu persetujuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kelola User (semua akun non-admin) -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Kelola User</h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Semua akun mentor, talenta, dan client. Nonaktifkan untuk memblokir login tanpa menghapus data.
                </p>
            </div>
            <span class="text-xs font-medium text-white bg-[#239EAF] rounded-full px-2.5 py-1">
                {{ $managedUsers->count() }} user
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Peran</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Daftar Pada</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($managedUsers as $managedUser)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-800">{{ $managedUser->name }}</td>
                            <td class="p-4 text-gray-600">{{ $managedUser->email }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $managedUser->role === 'mentor' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $managedUser->role === 'talenta' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $managedUser->role === 'client' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ !in_array($managedUser->role, ['mentor', 'talenta', 'client']) ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ ucfirst($managedUser->role) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $managedUser->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $managedUser->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ !in_array($managedUser->status, ['aktif', 'pending']) ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($managedUser->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 text-xs">{{ $managedUser->created_at?->format('d M Y H:i') }}</td>
                            <td class="p-4 text-center whitespace-nowrap">
                                @include('admin.users._user-actions', ['u' => $managedUser])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-sm">
                                Belum ada user terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
