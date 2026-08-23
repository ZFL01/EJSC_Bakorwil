"@extends('layouts.admin')

@section('title', 'Detail Talent')
@section('header', 'Detail Talent')

@section('content')
<div class="max-w-4xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $talent->nama }}</h3>
            <p class="text-sm text-gray-500">Keahlian: {{ $talent->keahlian }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                {{ $talent->status_pekerjaan === 'bekerja' ? 'bg-emerald-100 text-emerald-700' : '' }}
                {{ $talent->status_pekerjaan === 'belum bekerja' ? 'bg-amber-100 text-amber-700' : '' }}
                {{ $talent->status_pekerjaan === 'magang' ? 'bg-sky-100 text-sky-700' : '' }}">
                {{ ucfirst($talent->status_pekerjaan ?? '-') }}
            </span>
            <a href="{{ route('admin.talents.edit', $talent->id_talenta) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition">Edit</a>
            <a href="{{ route('admin.talents.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Informasi Umum</h4>
            <dl class="space-y-2 text-sm">
                <div>
                    <dt class="text-xs text-gray-400">Nama User</dt>
                    <dd class="font-medium text-gray-800">{{ $talent->user->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Email</dt>
                    <dd class="font-medium text-gray-800">{{ $talent->user->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Pengalaman</dt>
                    <dd class="text-gray-700">{{ $talent->pengalaman ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Mentor</dt>
                    <dd class="font-medium text-gray-800">
                        @if($talent->mentor)
                            <a href="{{ route('admin.mentors.show', $talent->mentor->id_mentor) }}" class="text-[#56b8c2] hover:underline">{{ $talent->mentor->nama }}</a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                @if($talent->skill_tags)
                <div>
                    <dt class="text-xs text-gray-400 mb-1">Skill Tags</dt>
                    <dd class="flex flex-wrap gap-1">
                        @foreach($talent->skill_tags as $tag)
                            <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded-full">{{ $tag }}</span>
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
                    <dd class="font-semibold text-gray-800">{{ $talent->no_wa }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500">Alamat Lengkap</dt>
                    <dd class="text-gray-800">{{ $talent->alamat_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">Foto KTP</dt>
                    <dd>
                        @if($talent->url_foto_ktp)
                            <a href="{{ asset('storage/' . $talent->url_foto_ktp) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">Lihat Dokumen KTP</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">CV Lengkap</dt>
                    <dd>
                        @if($talent->url_cv)
                            <a href="{{ asset('storage/' . $talent->url_cv) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">Lihat CV</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">Foto Buku Tabungan</dt>
                    <dd>
                        @if($talent->url_butap)
                            <a href="{{ asset('storage/' . $talent->url_butap) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">Lihat Bukti Tabungan</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection"