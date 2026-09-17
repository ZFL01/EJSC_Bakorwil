@extends('layouts.admin')

@section('title', 'Tambah Projek Kami')
@section('header', 'Tambah Projek Kami')

@section('content')
<div class="max-w-3xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <form action="{{ route('admin.ejsc-projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @include('admin.ejsc-projects.form', ['project' => null])
        <div class="flex justify-end gap-2 pt-4 border-t"><a href="{{ route('admin.ejsc-projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Batal</a><button class="px-4 py-2 bg-[#56b8c2] text-white rounded-lg text-sm font-medium">Simpan Projek</button></div>
    </form>
</div>
@endsection
