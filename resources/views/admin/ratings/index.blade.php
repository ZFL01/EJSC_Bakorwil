@extends('layouts.admin')

@section('title', 'Rating & Ulasan')

@section('content')

<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes softPulse {
        0%, 100% { opacity: .55; transform: scale(1); }
        50%      { opacity: 1;   transform: scale(1.06); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .anim-fade-up {
        opacity: 0;
        animation: fadeUp .55s cubic-bezier(.22,.61,.36,1) forwards;
    }
    .delay-1 { animation-delay: .05s; }
    .delay-2 { animation-delay: .12s; }
    .delay-3 { animation-delay: .19s; }
    .delay-4 { animation-delay: .26s; }

    .star-pulse { animation: softPulse 2.4s ease-in-out infinite; }

    .row-hover {
        transition: background-color .25s ease, transform .25s ease, box-shadow .25s ease;
    }
    .row-hover:hover {
        background-color: #f8fdfe;
        transform: translateX(2px);
        box-shadow: inset 3px 0 0 0 #56b8c2;
    }

    .btn-primary {
        background-image: linear-gradient(135deg, #0e4f81 0%, #1a6ba8 100%);
        transition: transform .2s ease, box-shadow .25s ease, background-position .4s ease;
        background-size: 200% 200%;
        background-position: 0% 50%;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -8px rgba(14,79,129,.55);
        background-position: 100% 50%;
    }
    .btn-primary:active { transform: translateY(0); }

    .btn-danger {
        transition: transform .2s ease, background-color .2s ease, color .2s ease;
    }
    .btn-danger:hover { transform: translateY(-1px); }
    .btn-danger:active { transform: translateY(0); }

    .btn-reset {
        transition: transform .2s ease, background-color .2s ease, border-color .2s ease;
    }
    .btn-reset:hover {
        transform: translateY(-1px);
        border-color: #56b8c2;
        color: #0e4f81;
    }

    .star {
        display: inline-block;
        transition: transform .2s ease, color .2s ease;
    }
    .star.filled { color: #fbbf24; text-shadow: 0 0 8px rgba(251,191,36,.35); }
    .star.empty  { color: #e5e7eb; }
    tr:hover .star.filled { transform: scale(1.15); }

    .table-head-glow {
        background: linear-gradient(90deg, #f5fbfc 0%, #eef7f9 50%, #f5fbfc 100%);
        background-size: 200% 100%;
        animation: shimmer 6s linear infinite;
    }

    .badge {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px -4px rgba(0,0,0,.15);
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .001ms !important;
        }
    }
</style>

<div class="p-6">

    {{-- HEADER --}}
    <div class="anim-fade-up flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#0e4f81] tracking-tight">
                Rating &amp; Ulasan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola rating dan komentar Client untuk Mentor dan Talenta.
            </p>
        </div>
    </div>


    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="anim-fade-up delay-1 mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700
                    shadow-sm">
            {{ session('success') }}
        </div>
    @endif


    {{-- FILTER --}}
    <div class="anim-fade-up delay-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6
                hover:shadow-md transition-shadow duration-300">
        <form
            method="GET"
            action="{{ route('admin.ratings.index') }}"
            class="grid md:grid-cols-3 gap-4"
        >
            {{-- TARGET --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Target</label>
                <select
                    name="type"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm
                           transition-all duration-200
                           focus:border-[#56b8c2] focus:ring-2 focus:ring-[#56b8c2]/20 focus:outline-none
                           hover:border-[#56b8c2]/60"
                >
                    <option value="">Semua</option>
                    <option value="mentor"  {{ request('type') === 'mentor'  ? 'selected' : '' }}>Mentor</option>
                    <option value="talenta" {{ request('type') === 'talenta' ? 'selected' : '' }}>Talenta</option>
                </select>
            </div>

            {{-- RATING --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                <select
                    name="rating"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm
                           transition-all duration-200
                           focus:border-[#56b8c2] focus:ring-2 focus:ring-[#56b8c2]/20 focus:outline-none
                           hover:border-[#56b8c2]/60"
                >
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (string) request('rating') === (string) $i ? 'selected' : '' }}>
                            {{ $i }} Bintang
                        </option>
                    @endfor
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="btn-primary flex-1 rounded-xl px-4 py-3 text-sm font-semibold text-white"
                >
                    Terapkan Filter
                </button>
                <a
                    href="{{ route('admin.ratings.index') }}"
                    class="btn-reset rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>


    {{-- TABLE --}}
    <div class="anim-fade-up delay-3 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="table-head-glow border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-4 text-left  font-semibold text-[#0e4f81]">Client</th>
                        <th class="px-5 py-4 text-left  font-semibold text-[#0e4f81]">Target</th>
                        <th class="px-5 py-4 text-center font-semibold text-[#0e4f81]">Rating</th>
                        <th class="px-5 py-4 text-left  font-semibold text-[#0e4f81]">Komentar</th>
                        <th class="px-5 py-4 text-left  font-semibold text-[#0e4f81]">Tanggal</th>
                        <th class="px-5 py-4 text-center font-semibold text-[#0e4f81]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($ratings as $rating)
                        <tr class="row-hover anim-fade-up" style="animation-delay: {{ $loop->index * 0.04 }}s;">

                            {{-- CLIENT --}}
                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $rating->client->nama_ukm ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $rating->client->email ?? '-' }}
                                </div>
                            </td>

                            {{-- TARGET --}}
                            <td class="px-5 py-4">
                                @php
                                    $targetType = $rating->rateable_type === 'mentor' ? 'Mentor' : 'Talenta';
                                @endphp
                                <div class="font-semibold text-gray-800">
                                    {{ $rating->rateable->nama ?? '-' }}
                                </div>
                                <span class="badge inline-flex mt-1 rounded-full px-2.5 py-1 text-xs font-medium
                                    {{ $rating->rateable_type === 'mentor'
                                        ? 'bg-cyan-50 text-cyan-700'
                                        : 'bg-lime-50 text-lime-700' }}">
                                    {{ $targetType }}
                                </span>
                            </td>

                            {{-- RATING --}}
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star text-lg {{ $i <= $rating->rating ? 'filled' : 'empty' }}">★</span>
                                    @endfor
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $rating->rating }}/5</div>
                            </td>

                            {{-- KOMENTAR --}}
                            <td class="px-5 py-4 max-w-md">
                                @if($rating->comment)
                                    <p class="text-gray-700 leading-relaxed">{{ $rating->comment }}</p>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada komentar.</span>
                                @endif
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-gray-700">{{ $rating->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $rating->created_at->format('H:i') }}</div>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-5 py-4 text-center">
                                <form
                                    method="POST"
                                    action="{{ route('admin.ratings.destroy', $rating) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus rating dan komentar ini?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-danger inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="star-pulse text-gray-300 text-4xl mb-3 inline-block">★</div>
                                <p class="font-semibold text-gray-700">Belum ada rating.</p>
                                <p class="text-sm text-gray-400 mt-1">
                                    Rating dari Client akan muncul di halaman ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($ratings->hasPages())
            <div class="border-t border-gray-100 px-5 py-4">
                {{ $ratings->links() }}
            </div>
        @endif
    </div>

</div>

@endsection