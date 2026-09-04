@extends('layouts.admin')

@section('title', 'Tambah Talent')
@section('header', 'Tambah Talent Baru')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <form action="{{ route('admin.talents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <h3 class="text-md font-bold text-gray-700 border-b pb-2">Informasi Akun User</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pengguna</label>
                <input type="text" name="user_name" value="{{ old('user_name') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
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

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Data Profil Talent</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">No WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Bidang Keahlian</label>
                <input type="text" name="keahlian" value="{{ old('keahlian') }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Wilayah/Domisili</label>
                <select name="id_wilayah" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    @foreach($wilayah as $wil)
                        <option value="{{ $wil->id_wilayah }}" {{ old('id_wilayah') == $wil->id_wilayah ? 'selected' : '' }}>{{ $wil->nama_wilayah }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Domisili (Kecamatan/Desa)</label>
                <input type="text" name="domisili" value="{{ old('domisili') }}" required placeholder="Contoh: Kec. Kaliwates, Jember" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Skill Tags (pisahkan koma)</label>
                <input type="text" name="skill_tags" value="{{ old('skill_tags') }}" placeholder="UI/UX, Figma, Adobe XD" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pengalaman</label>
                <input type="text" name="pengalaman" value="{{ old('pengalaman') }}" placeholder="Fresh Graduate" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Mentor (Opsional)</label>
                <select name="mentor_id" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="">-- Tidak Ada Mentor --</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id_mentor }}" {{ old('mentor_id') == $mentor->id_mentor ? 'selected' : '' }}>{{ $mentor->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pekerjaan</label>
                <select name="status_pekerjaan" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="belum bekerja">Belum Bekerja</option>
                    <option value="bekerja">Bekerja</option>
                    <option value="magang">Magang</option>
                </select>
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

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Berkas & Dokumen</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto KTP</label>
                <input type="file" name="url_foto_ktp" class="text-xs text-gray-500 w-full">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">CV (PDF/DOC)</label>
                <input type="file" name="url_cv" class="text-xs text-gray-500 w-full">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto Buku Tabungan</label>
                <input type="file" name="url_butap" class="text-xs text-gray-500 w-full">
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.talents.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
