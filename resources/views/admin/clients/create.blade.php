@extends('layouts.admin')

@section('title', 'Tambah Client')
@section('header', 'Tambah Client (UMKM)')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <h3 class="text-md font-bold text-gray-700 border-b pb-2">Informasi Akun User</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pengguna</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Email User</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
        </div>

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Data Profil UMKM</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama UKM</label>
                <input type="text" name="nama_ukm" value="{{ old('nama_ukm') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">No WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Profil</label>
                <select name="status" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="aktif">Aktif</option>
                    <option value="tidak aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" required rows="2" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi Usaha</label>
            <textarea name="deskripsi_usaha" rows="3" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">{{ old('deskripsi_usaha') }}</textarea>
        </div>

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Foto</h3>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Foto Logo/Produk UMKM</label>
            <input type="file" name="foto_logo" class="text-xs text-gray-500">
            <p class="text-xs text-gray-400 mt-1">Max 2MB. Format: JPG, PNG.</p>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.clients.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
