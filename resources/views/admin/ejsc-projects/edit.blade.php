@extends('layouts.admin')

@section('title', 'Edit Projek Kami')
@section('header', 'Edit Projek Kami')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <form action="{{ route('admin.ejsc-projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        @include('admin.ejsc-projects.form', ['project' => $project])
        <div class="flex justify-end gap-2 pt-4 border-t"><a href="{{ route('admin.ejsc-projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Batal</a><button class="px-4 py-2 bg-[#56b8c2] text-white rounded-lg text-sm font-medium">Simpan Perubahan</button></div>
    </form>
</div>
@endsection
