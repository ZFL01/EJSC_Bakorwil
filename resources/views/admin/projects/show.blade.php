@extends('layouts.admin')

@section('title', 'Detail Project')
@section('header', 'Detail Project')

@php
    $statusBadge = [
        'draft'     => 'bg-amber-100 text-amber-700',
        'berjalan'  => 'bg-emerald-100 text-emerald-700',
        'dibatalkan'=> 'bg-rose-100 text-rose-700',
        'selesai' => 'bg-slate-100 text-slate-600',
    ];
@endphp

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
    @endif

    <!-- Ringkasan Project -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-bold text-gray-800">{{ $project->nama_project }}</h2>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusBadge[$project->status] ?? '' }}">{{ ucfirst($project->status) }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-[#f0f9fa] text-[#2e8791]">{{ $project->tahun }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $project->opd }}@if($project->bidang) / {{ $project->bidang }}@endif
                    @if($project->tanggal)
                        &middot; {{ $project->tanggal->format('d-m-Y') }}
                    @endif
                </p>
                @if($project->output_project)
                    <p class="text-xs text-gray-400 mt-1">Output: {{ $project->output_project }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.projects.edit', $project->id_project) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-sm font-medium transition">Edit</a>
                <form method="POST" action="{{ route('admin.projects.destroy', $project->id_project) }}" onsubmit="return confirm('Hapus project ini beserta seluruh tautan anggotanya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-sm font-medium transition">Hapus</button>
                </form>
                <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Kembali</a>
            </div>
        </div>
    </div>

    <!-- MENTOR -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">Mentor Terlibat <span class="text-gray-400 font-medium">({{ $project->mentors->count() }})</span></h3>
        </div>

        @if($project->mentors->count())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($project->mentors as $mentor)
                    <span class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-full pl-3 pr-1.5 py-1 text-sm text-emerald-800">
                        {{ $mentor->nama }}
                        <form method="POST" action="{{ route('admin.projects.detach', $project->id_project) }}" onsubmit="return confirm('Lepas mentor ini dari project?')">
                            @csrf
                            <input type="hidden" name="type" value="mentor">
                            <input type="hidden" name="id" value="{{ $mentor->id_mentor }}">
                            <button type="submit" class="w-5 h-5 rounded-full hover:bg-rose-100 text-rose-500 text-xs leading-none" title="Lepas">x</button>
                        </form>
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 mb-4">Belum ada mentor tertaut.</p>
        @endif

        @if($mentorOptions->count())
            <form method="POST" action="{{ route('admin.projects.attach', $project->id_project) }}" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input type="hidden" name="type" value="mentor">
                <select name="id" required class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
                    <option value="">-- Pilih mentor untuk ditautkan --</option>
                    @foreach($mentorOptions as $m)
                        <option value="{{ $m->id_mentor }}">{{ $m->nama }}@if($m->keahlian) - {{ $m->keahlian }}@endif</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition">Tautkan</button>
            </form>
        @endif
    </div>

    <!-- TALENTA -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">Talenta Terlibat <span class="text-gray-400 font-medium">({{ $project->talents->count() }})</span></h3>
        </div>

        @if($project->talents->count())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($project->talents as $talent)
                    <span class="inline-flex items-center gap-2 bg-purple-50 border border-purple-200 rounded-full pl-3 pr-1.5 py-1 text-sm text-purple-800">
                        {{ $talent->nama }}
                        <form method="POST" action="{{ route('admin.projects.detach', $project->id_project) }}" onsubmit="return confirm('Lepas talenta ini dari project?')">
                            @csrf
                            <input type="hidden" name="type" value="talenta">
                            <input type="hidden" name="id" value="{{ $talent->id_talenta }}">
                            <button type="submit" class="w-5 h-5 rounded-full hover:bg-rose-100 text-rose-500 text-xs leading-none" title="Lepas">x</button>
                        </form>
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 mb-4">Belum ada talenta tertaut.</p>
        @endif

        @if($talentOptions->count())
            <form method="POST" action="{{ route('admin.projects.attach', $project->id_project) }}" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input type="hidden" name="type" value="talenta">
                <select name="id" required class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
                    <option value="">-- Pilih talenta untuk ditautkan --</option>
                    @foreach($talentOptions as $t)
                        <option value="{{ $t->id_talenta }}">{{ $t->nama }}@if($t->keahlian) - {{ $t->keahlian }}@endif</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition">Tautkan</button>
            </form>
        @endif
    </div>

    <!-- CLIENT / UKM -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">Klien / UKM Terlibat <span class="text-gray-400 font-medium">({{ $project->clients->count() }})</span></h3>
        </div>

        @if($project->clients->count())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($project->clients as $client)
                    <span class="inline-flex items-center gap-2 bg-sky-50 border border-sky-200 rounded-full pl-3 pr-1.5 py-1 text-sm text-sky-800">
                        {{ $client->nama_ukm }}
                        <form method="POST" action="{{ route('admin.projects.detach', $project->id_project) }}" onsubmit="return confirm('Lepas client ini dari project?')">
                            @csrf
                            <input type="hidden" name="type" value="client">
                            <input type="hidden" name="id" value="{{ $client->id_client }}">
                            <button type="submit" class="w-5 h-5 rounded-full hover:bg-rose-100 text-rose-500 text-xs leading-none" title="Lepas">x</button>
                        </form>
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 mb-4">Belum ada client tertaut.</p>
        @endif

        @if($clientOptions->count())
            <form method="POST" action="{{ route('admin.projects.attach', $project->id_project) }}" class="flex flex-col sm:flex-row gap-2">
                @csrf
                <input type="hidden" name="type" value="client">
                <select name="id" required class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
                    <option value="">-- Pilih client/UKM untuk ditautkan --</option>
                    @foreach($clientOptions as $c)
                        <option value="{{ $c->id_client }}">{{ $c->nama_ukm }}@if($c->nama_produk) - {{ $c->nama_produk }}@endif</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-sm font-medium transition">Tautkan</button>
            </form>
        @endif
    </div>

    <p class="text-xs text-gray-400">Mentor, talenta, dan client yang tertaut di sini akan ikut tampil pada Ekspor Excel untuk tahun {{ $project->tahun }}.</p>

</div>
@endsection
