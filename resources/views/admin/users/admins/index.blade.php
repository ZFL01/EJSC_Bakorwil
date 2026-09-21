@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('header', 'Kelola Akun Admin')

@section('content')
<div class="space-y-6">

    <!-- Flash success/error sudah ditampilkan oleh layouts/admin.blade.php -->

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="font-semibold text-gray-800">Akun Admin</h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Akun dengan peran <span class="font-medium">admin</span> yang dapat mengakses panel ini.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-white bg-[#56b8c2] rounded-full px-2.5 py-1">
                    {{ $admins->count() }} admin
                </span>
                <a href="{{ route('admin.users.admins.create') }}"
                   class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition whitespace-nowrap">
                    + Tambah Admin
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Dibuat Pada</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-800">
                                {{ $admin->name }}
                                @if ($admin->id_user === auth()->id())
                                    <span class="ml-1 text-[11px] font-semibold text-[#239EAF]">(Anda)</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">{{ $admin->username ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $admin->email }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $admin->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 text-xs">{{ $admin->created_at?->format('d M Y H:i') }}</td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.users.admins.edit', $admin) }}"
                                   class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                    Edit
                                </a>
                                @if ($admin->id_user !== auth()->id())
                                    <form action="{{ route('admin.users.admins.destroy', $admin) }}" method="POST" class="inline ml-1"
                                          onsubmit="return confirm('Hapus PERMANEN akun admin {{ $admin->email }}? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-sm">
                                Belum ada akun admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
