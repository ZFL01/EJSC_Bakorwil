@extends('layouts.admin')

@section('title', 'Tambah Ruangan')
@section('header', 'Tambah Ruangan')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Tambah Ruangan Booking</h2>
        <p class="text-sm text-slate-500 mt-1">Isi data ruangan agar dapat digunakan pada halaman booking.</p>
    </div>

    @if($errors->any())
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.rooms.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Ruangan</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255"
                placeholder="Contoh: Ruang Kreatif"
                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-[#56b8c2] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/20">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="capacity" class="block text-sm font-semibold text-slate-700 mb-1">Kapasitas</label>
                <input id="capacity" name="capacity" type="number" value="{{ old('capacity') }}" required min="1"
                    placeholder="Jumlah orang"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-[#56b8c2] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/20">
            </div>
            <div>
                <label for="facilities" class="block text-sm font-semibold text-slate-700 mb-1">Fasilitas</label>
                <input id="facilities" name="facilities" type="text" value="{{ old('facilities') }}"
                    placeholder="Proyektor, WiFi, Papan tulis"
                    class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-[#56b8c2] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/20">
                <p class="text-xs text-slate-400 mt-1">Pisahkan beberapa fasilitas dengan koma.</p>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
            <textarea id="description" name="description" rows="4"
                placeholder="Deskripsi singkat ruangan (opsional)"
                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-[#56b8c2] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/20">{{ old('description') }}</textarea>
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                class="rounded border-slate-300 text-[#0e4f81] focus:ring-[#56b8c2]">
            Aktif dan tampil pada halaman booking
        </label>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#0e4f81] text-white text-sm font-semibold hover:bg-[#0b416b] transition">Simpan Ruangan</button>
        </div>
    </form>
</div>
@endsection