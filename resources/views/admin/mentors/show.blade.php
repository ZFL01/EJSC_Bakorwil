@extends('layouts.admin')

@section('title', 'Detail Mentor')
@section('header', 'Detail Mentor')

@section('content')
<div class="max-w-4xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $mentor->nama }}</h3>
            <p class="text-sm text-gray-500">Keahlian: {{ $mentor->keahlian }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $mentor->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $mentor->is_available ? 'Available' : 'Unavailable' }}
            </span>
            <a href="{{ route('admin.mentors.edit', $mentor->id_mentor) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition">Edit</a>
            <a href="{{ route('admin.mentors.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Informasi Umum</h4>
            <dl class="space-y-2 text-sm">
                <div>
                    <dt class="text-xs text-gray-400">Nama User</dt>
                    <dd class="font-medium text-gray-800">{{ $mentor->user->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Email</dt>
                    <dd class="font-medium text-gray-800">{{ $mentor->user->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Pengalaman</dt>
                    <dd class="text-gray-700">{{ $mentor->pengalaman ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Jumlah Mentee</dt>
                    <dd class="font-bold text-[#56b8c2]">{{ $mentor->jumlah_mentee }} orang</dd>
                </div>
                @if($mentor->expertise_tags)
                <div>
                    <dt class="text-xs text-gray-400 mb-1">Expertise Tags</dt>
                    <dd class="flex flex-wrap gap-1">
                        @foreach($mentor->expertise_tags as $tag)
                            <span class="px-2 py-0.5 bg-sky-50 text-sky-700 text-xs rounded-full">{{ $tag }}</span>
                        @endforeach
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="bg-rose-50/50 p-4 rounded-xl border border-rose-100">
            <h4 class="text-sm font-bold text-rose-800 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                <span>🔒 Data Sensitif (Admin Only)</span>
            </h4>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs text-rose-500">No. WhatsApp</dt>
                    <dd class="font-semibold text-gray-800">{{ $mentor->no_wa }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500">Alamat Lengkap</dt>
                    <dd class="text-gray-800">{{ $mentor->alamat_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">Foto KTP</dt>
                    <dd>
                        @if($mentor->ktp_src)
                            <a href="{{ $mentor->ktp_src }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">Lihat Dokumen KTP</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">CV Lengkap</dt>
                    <dd>
                        @if($mentor->cv_src)
                            <a href="{{ $mentor->cv_src }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">Lihat CV</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    @if(isset($mentor->talents) && count($mentor->talents) > 0)
        <div class="border-t pt-4">
            <h4 class="text-sm font-bold text-gray-700 mb-2">Daftar Talenta yang Dibimbing</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($mentor->talents as $talent)
                    <a href="{{ route('admin.talents.show', $talent->id_talenta) }}" class="p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 text-sm transition">
                        <span class="font-medium text-gray-800">{{ $talent->nama }}</span>
                        <span class="text-gray-500 ml-2">- {{ $talent->keahlian }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
