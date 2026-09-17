@php($isEdit = filled($project))
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-1">Judul Projek</label><input type="text" name="judul" value="{{ old('judul', $project?->judul) }}" required class="w-full border rounded-lg p-2 text-sm"></div>
    <div><label class="block text-xs font-semibold text-gray-600 mb-1">Tahun</label><input type="number" name="tahun" value="{{ old('tahun', $project?->tahun ?? now()->year) }}" min="2000" max="2100" class="w-full border rounded-lg p-2 text-sm"></div>
    <div><label class="block text-xs font-semibold text-gray-600 mb-1">Status</label><select name="status" class="w-full border rounded-lg p-2 text-sm">@foreach(['rencana', 'berjalan', 'selesai'] as $status)<option value="{{ $status }}" {{ old('status', $project?->status ?? 'rencana') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>@endforeach</select></div>
    <div class="md:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-1">Ringkasan</label><input type="text" name="ringkasan" value="{{ old('ringkasan', $project?->ringkasan) }}" maxlength="500" class="w-full border rounded-lg p-2 text-sm"></div>
    <div class="md:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi</label><textarea name="deskripsi" rows="5" class="w-full border rounded-lg p-2 text-sm">{{ old('deskripsi', $project?->deskripsi) }}</textarea></div>
    <div class="md:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-1">Link Projek</label><input type="url" name="link" value="{{ old('link', $project?->link) }}" placeholder="https://contoh.com/projek" maxlength="2048" class="w-full border rounded-lg p-2 text-sm"><p class="mt-1 text-xs text-gray-400">Opsional. Link harus diawali http:// atau https://.</p></div>
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-600 mb-1">Gambar Kegiatan Projek</label>
        <input type="file" name="galeri[]" accept="image/jpeg,image/png,image/webp" multiple class="w-full border rounded-lg p-2 text-sm">
        <p class="mt-1 text-xs text-gray-400">Bisa memilih beberapa gambar PNG, JPG, JPEG, atau WEBP. Maksimal 2 MB per gambar.</p>
        @if($project?->galeri)
            <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($project->galeri as $imagePath)
                    <label class="relative block">
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Gambar kegiatan" class="h-24 w-full object-cover rounded-lg border">
                        <span class="mt-1 flex items-center gap-1 text-xs text-rose-600"><input type="checkbox" name="hapus_galeri[]" value="{{ $imagePath }}"> Hapus</span>
                    </label>
                @endforeach
            </div>
        @endif
    </div>
    <div><label class="block text-xs font-semibold text-gray-600 mb-1">Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}" min="0" class="w-full border rounded-lg p-2 text-sm"></div>
    <label class="flex items-center gap-2 text-sm text-gray-700 mt-6"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $project?->is_published ?? true) ? 'checked' : '' }}> Tampilkan di halaman Tentang Kami</label>
</div>
