@extends('layouts.app')

@section(
    'title',
    'Profil Talenta - ' . ($talent->nama ?? 'Talenta')
)

@section('content')

<div class="min-h-screen bg-[#fafcf7] py-12">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">


        <a
            href="{{ route('talenta') }}"
            class="
                inline-flex
                items-center
                gap-2
                mb-8
                text-[#8aaa28]
                font-medium
            "
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />

            </svg>

            Kembali ke Talenta

        </a>


        <div
            class="
                bg-white
                rounded-3xl
                shadow-xl
                border
                border-[#e8edf0]
                overflow-hidden
            "
        >


            <div
                class="
                    p-8
                    md:p-10
                    bg-gradient-to-br
                    from-[#f4fadf]
                    via-white
                    to-[#fafcf7]
                "
            >

                @php

                    $nama =
                        $talent->nama
                        ?? 'Talenta';

                    $avatar =
                        collect(
                            preg_split(
                                '/\s+/',
                                trim($nama)
                            )
                        )
                        ->filter()
                        ->take(2)
                        ->map(
                            fn($word) =>
                            strtoupper(
                                substr(
                                    $word,
                                    0,
                                    1
                                )
                            )
                        )
                        ->implode('');

                @endphp


                <div
                    class="
                        flex
                        flex-col
                        md:flex-row
                        items-center
                        md:items-start
                        gap-6
                    "
                >

                    <div
                        class="
                            w-28
                            h-28
                            rounded-3xl
                            bg-[#c7ea46]
                            text-[#20300d]
                            flex
                            items-center
                            justify-center
                            text-3xl
                            font-bold
                            shadow-lg
                        "
                    >
                        {{ $avatar ?: 'TA' }}
                    </div>


                    <div
                        class="
                            text-center
                            md:text-left
                        "
                    >

                        <span
                            class="
                                inline-block
                                px-3
                                py-1
                                rounded-full
                                bg-[#edf6d3]
                                text-[#587018]
                                text-sm
                                font-medium
                                mb-3
                            "
                        >
                            Talenta
                        </span>


                        <h1
                            class="
                                text-3xl
                                md:text-4xl
                                font-bold
                                text-[#17324d]
                            "
                        >
                            {{ $nama }}
                        </h1>


                        <p
                            class="
                                mt-2
                                text-lg
                                font-medium
                                text-[#687d2a]
                            "
                        >
                            {{ $talent->keahlian ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-8 md:p-10">

                <h2
                    class="
                        text-2xl
                        font-bold
                        text-[#17324d]
                        mb-6
                    "
                >
                    Informasi Talenta
                </h2>


                <div
                    class="
                        grid
                        md:grid-cols-2
                        gap-5
                    "
                >

                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Nama
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->nama ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Jenis Kelamin
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->jenis_kelamin ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Domisili
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->domisili ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->keahlian ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Status Pekerjaan
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->status_pekerjaan ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Bidang Pekerjaan
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->bidang_pekerjaan ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Pengalaman
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->pengalaman ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Email
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                                break-all
                            "
                        >
                            {{ $talent->email ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            No. WhatsApp
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->no_wa ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Alamat Lengkap
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            {{ $talent->alamat_lengkap ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Portofolio
                        </p>

                        @if(!empty($talent->portofolio_url))

                            <a
                                href="{{ $talent->portofolio_url }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#8aaa28]
                                    hover:underline
                                    break-all
                                "
                            >
                                {{ $talent->portofolio_url }}
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#17324d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Status Akun
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-green-600
                            "
                        >
                            Aktif
                        </p>

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            CV / Resume
                        </p>

                        @if(!empty($talent->url_cv))

                            <a
                                href="{{ asset($talent->url_cv) }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#8aaa28]
                                    hover:underline
                                    break-all
                                "
                            >
                                Lihat CV
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#17324d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div class="bg-[#fafcf7] rounded-2xl p-5">

                        <p class="text-sm text-[#94a3b8]">
                            Tag Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#17324d]
                            "
                        >
                            @if(!empty($talent->skill_tags))
                                {{ implode(', ', $talent->skill_tags) }}
                            @else
                                -
                            @endif
                        </p>

                    </div>

                </div>


                <div class="mt-8">

                    <h2
                        class="
                            text-xl
                            font-bold
                            text-[#17324d]
                            mb-3
                        "
                    >
                        Tentang Talenta
                    </h2>

                    <p
                        class="
                            text-[#64748b]
                            leading-relaxed
                        "
                    >
                        {{ $talent->bio ?? 'Belum ada deskripsi tentang talenta ini.' }}
                    </p>

                </div>


                @if($talent->mentor)

                    <div class="mt-8">

                        <h2
                            class="
                                text-xl
                                font-bold
                                text-[#17324d]
                                mb-4
                            "
                        >
                            Mentor
                        </h2>


                        <div
                            class="
                                rounded-2xl
                                bg-[#fafcf7]
                                p-5
                            "
                        >

                            <p
                                class="
                                    font-semibold
                                    text-[#17324d]
                                "
                            >
                                {{ $talent->mentor->nama }}
                            </p>

                            <p
                                class="
                                    text-sm
                                    text-[#687d2a]
                                    mt-1
                                "
                            >
                                {{ $talent->mentor->keahlian ?? '-' }}
                            </p>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection