@extends('layouts.admin')

@section('title', 'Edit Mentor')
@section('header', 'Edit Mentor')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <form action="{{ route('admin.mentors.update', $mentor->id_mentor) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <h3 class="text-md font-bold text-gray-700 border-b pb-2">Data Profil Mentor</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $mentor->nama) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">No WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa', $mentor->no_wa) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Bidang Keahlian</label>
                <input type="text" name="keahlian" value="{{ old('keahlian', $mentor->keahlian) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Expertise Tags (pisahkan koma)</label>
                <input type="text" name="expertise_tags" value="{{ old('expertise_tags', isset($mentor->expertise_tags) ? implode(', ', $mentor->expertise_tags) : '') }}" placeholder="Digital Marketing, SEO, Content" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pengalaman</label>
                <input type="text" name="pengalaman" value="{{ old('pengalaman', $mentor->pengalaman) }}" placeholder="10+ tahun" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Ketersediaan</label>
                <select name="is_available" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="1" {{ $mentor->is_available ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ !$mentor->is_available ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Profil</label>
                <select name="status" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="aktif" {{ $mentor->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ $mentor->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" required rows="2" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap', $mentor->alamat_lengkap) }}</textarea>
        </div>

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Berkas & Dokumen</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto KTP</label>
                @if($mentor->ktp_src)
                    <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ $mentor->ktp_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                @endif
                <input type="file" name="url_foto_ktp" class="text-xs text-gray-500 w-full">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">CV (PDF/DOC)</label>
                @if($mentor->cv_src)
                    <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ $mentor->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                @endif
                <input type="file" name="url_cv" class="text-xs text-gray-500 w-full">
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.mentors.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Update</button>
        </div>
    </form>
</div>
@endsection
