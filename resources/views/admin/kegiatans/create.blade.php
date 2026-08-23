"@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')
@section('header', 'Tambah Kegiatan Baru')

@section('content')
<div class=\"max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6\">
    <form action=\"{{ route('admin.kegiatans.store') }}\" method=\"POST\" enctype=\"multipart/form-data\" class=\"space-y-4\">
        @csrf

        <h3 class=\"text-md font-bold text-gray-700 border-b pb-2\">Detail Kegiatan</h3>
        <div class=\"grid grid-cols-1 md:grid-cols-2 gap-4\">
            <div class=\"md:col-span-2\">
                <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Nama Kegiatan</label>
                <input type=\"text\" name=\"nama_kegiatan\" value=\"{{ old('nama_kegiatan') }}\" required class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">
            </div>
            <div>
                <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Tanggal</label>
                <input type=\"date\" name=\"tanggal\" value=\"{{ old('tanggal') }}\" required min=\"{{ date('Y-m-d') }}\" class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">
                <p class=\"text-xs text-rose-500 mt-1\">* Hanya 1 kegiatan yang diperbolehkan per hari.</p>
            </div>
            <div>
                <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Jenis Kegiatan</label>
                <select name=\"jenis_kegiatan\" required class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">
                    <option value=\"online\">Online</option>
                    <option value=\"offline\">Offline</option>
                    <option value=\"hybrid\">Hybrid</option>
                </select>
            </div>
            <div>
                <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Lokasi / Link</label>
                <input type=\"text\" name=\"lokasi\" value=\"{{ old('lokasi') }}\" placeholder=\"Contoh: Zoom Link atau Alamat Tempat\" required class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">
            </div>
            <div>
                <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Kuota Maksimal (Kosongkan jika tidak terbatas)</label>
                <input type=\"number\" name=\"max_participants\" value=\"{{ old('max_participants') }}\" min=\"1\" class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">
            </div>
            <div>
                <label class=\"flex items-center space-x-2 cursor-pointer mt-4 md:mt-0 md:pt-6\">
                    <input type=\"checkbox\" name=\"is_public\" value=\"1\" {{ old('is_public', 1) ? 'checked' : '' }} class=\"rounded text-[#56b8c2] focus:ring-[#56b8c2]\">
                    <span class=\"text-sm font-medium text-gray-700\">Tampilkan ke Publik?</span>
                </label>
            </div>
        </div>

        <div>
            <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Keterangan / Deskripsi</label>
            <textarea name=\"keterangan\" rows=\"4\" class=\"w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]\">{{ old('keterangan') }}</textarea>
        </div>

        <h3 class=\"text-md font-bold text-gray-700 border-b pb-2 pt-4\">Galeri Foto</h3>
        <div>
            <label class=\"block text-xs font-semibold text-gray-600 mb-1\">Upload Foto (Bisa multiple)</label>
            <input type=\"file\" name=\"gallery[]\" multiple class=\"text-xs text-gray-500 w-full border border-gray-200 rounded-lg p-2\">
            <p class=\"text-xs text-gray-400 mt-1\">Max 2MB per file. Format: JPG, PNG.</p>
        </div>

        <div class=\"flex justify-end gap-2 pt-4 border-t\">
            <a href=\"{{ route('admin.kegiatans.index') }}\" class=\"px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition\">Batal</a>
            <button type=\"submit\" class=\"px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition\">Simpan</button>
        </div>
    </form>
</div>
@endsection"