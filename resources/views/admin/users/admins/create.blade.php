@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('header', 'Tambah Akun Admin')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <div>
        <h3 class="text-md font-bold text-gray-700 border-b pb-2">Informasi Akun Admin</h3>
        <p class="text-xs text-gray-500 mt-2">
            Akun admin langsung aktif dan dapat mengakses seluruh menu panel admin.
        </p>
    </div>

    <form action="{{ route('admin.users.admins.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required maxlength="255"
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2] @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" maxlength="100"
                       placeholder="Kosongkan untuk otomatis dari email"
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2] @error('username') border-red-400 @enderror">
                @error('username')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required maxlength="255"
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2] @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required
                        class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2] @error('password') border-red-400 @enderror">
                <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.users.admins.index') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit"
                    class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
