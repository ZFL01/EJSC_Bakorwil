@extends('layouts.admin')

@section('title', 'Edit Project')
@section('header', 'Edit Project')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <form action="{{ route('admin.projects.update', $project->id_project) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', $project->tahun) }}" min="2000" max="2100" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
                    @foreach(['draft', 'berjalan', 'selesai', 'dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ old('status', $project->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Project</label>
                <input type="text" name="nama_project" value="{{ old('nama_project', $project->nama_project) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">OPD</label>
                <input type="text" name="opd" value="{{ old('opd', $project->opd) }}" required class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Bidang</label>
                <input type="text" name="bidang" value="{{ old('bidang', $project->bidang) }}" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $project->tanggal?->format('Y-m-d')) }}" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Output Project</label>
            <textarea name="output_project" rows="3" class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">{{ old('output_project', $project->output_project) }}</textarea>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.projects.show', $project->id_project) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Update</button>
        </div>
    </form>
</div>
@endsection
