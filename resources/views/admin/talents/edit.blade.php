@extends('layouts.admin')

@section('title', 'Edit Talent')
@section('header', 'Edit Talent')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <form action="{{ route('admin.talents.update', $talent->id_talenta) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <h3 class="text-md font-bold text-gray-700 border-b pb-2">Data Profil Talent</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $talent->nama) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">No WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa', $talent->no_wa) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Bidang Keahlian</label>
                <input type="text" name="keahlian" value="{{ old('keahlian', $talent->keahlian) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Wilayah/Domisili</label>
                <select name="id_wilayah" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    @foreach($wilayah as $wil)
                        <option value="{{ $wil->id_wilayah }}" {{ old('id_wilayah', $talent->id_wilayah) == $wil->id_wilayah ? 'selected' : '' }}>{{ $wil->nama_wilayah }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Domisili (Kecamatan/Desa)</label>
                <input type="text" name="domisili" value="{{ old('domisili', $talent->domisili) }}" required placeholder="Contoh: Kec. Kaliwates, Jember" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Skill Tags (pisahkan koma)</label>
                <input type="text" name="skill_tags" value="{{ old('skill_tags', isset($talent->skill_tags) ? implode(', ', $talent->skill_tags) : '') }}" placeholder="UI/UX, Figma, Adobe XD" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pengalaman</label>
                <input type="text" name="pengalaman" value="{{ old('pengalaman', $talent->pengalaman) }}" placeholder="Fresh Graduate" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Mentor (Opsional)</label>
                <select name="mentor_id" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="">-- Tidak Ada Mentor --</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id_mentor }}" {{ old('mentor_id', $talent->mentor_id) == $mentor->id_mentor ? 'selected' : '' }}>{{ $mentor->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pekerjaan</label>
                <select name="status_pekerjaan" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="belum bekerja" {{ old('status_pekerjaan', $talent->status_pekerjaan) === 'belum bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                    <option value="bekerja" {{ old('status_pekerjaan', $talent->status_pekerjaan) === 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                    <option value="magang" {{ old('status_pekerjaan', $talent->status_pekerjaan) === 'magang' ? 'selected' : '' }}>Magang</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Profil</label>
                <select name="status" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    <option value="aktif" {{ $talent->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ $talent->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" required rows="2" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap', $talent->alamat_lengkap) }}</textarea>
        </div>

        <h3 class="text-md font-bold text-gray-700 border-b pb-2 pt-4">Berkas & Dokumen</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto KTP</label>
                @if($talent->ktp_src)
                    <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ $talent->ktp_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                @endif
                <input type="file" name="url_foto_ktp" class="text-xs text-gray-500 w-full">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">CV (PDF/DOC)</label>
                @if($talent->cv_src)
                    <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ $talent->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                @endif
                <input type="file" name="url_cv" class="text-xs text-gray-500 w-full">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Foto Buku Tabungan</label>
                @if($talent->butap_src)
                    <p class="text-xs text-gray-500 mb-1">File saat ini: <a href="{{ $talent->butap_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                @endif
                <input type="file" name="url_butap" class="text-xs text-gray-500 w-full">
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.talents.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Update</button>
        </div>
    </form>
</div>
@endsection
