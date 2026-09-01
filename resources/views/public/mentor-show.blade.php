@extends('layouts.app')

@section(
    'title',
    'Profil Mentor - ' . ($mentor->nama ?? 'Mentor')
)

@section('content')

<div class="min-h-screen bg-[#f8feff] py-12">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">


        <!-- BACK -->

        <a
            href="{{ route('mentor') }}"
            class="
                inline-flex
                items-center
                gap-2
                mb-8
                text-[#16b8c4]
                font-medium
                hover:text-[#159da8]
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
                    d="
                        M15 19l-7-7
                        7-7
                    "
                />

            </svg>

            Kembali ke Mentor

        </a>


        <!-- PROFILE -->

        <div
            class="
                bg-white
                rounded-3xl
                shadow-xl
                border
                border-[#dceff2]
                overflow-hidden
            "
        >


            <!-- HEADER -->

            <div
                class="
                    p-8
                    md:p-10
                    bg-gradient-to-br
                    from-[#dffbfc]
                    via-white
                    to-[#f3feff]
                "
            >

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

                    @php

                        $nama =
                            $mentor->nama
                            ?? 'Mentor';

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
                            w-28
                            h-28
                            rounded-3xl
                            bg-gradient-to-br
                            from-[#20c4ce]
                            to-[#159da8]
                            text-white
                            flex
                            items-center
                            justify-center
                            text-3xl
                            font-bold
                            shadow-lg
                        "
                    >
                        {{ $avatar ?: 'ME' }}
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
                                bg-[#dcf8fa]
                                text-[#138d98]
                                text-sm
                                font-medium
                                mb-3
                            "
                        >
                            Mentor
                        </span>


                        <h1
                            class="
                                text-3xl
                                md:text-4xl
                                font-bold
                                text-[#12344d]
                            "
                        >
                            {{ $nama }}
                        </h1>


                        <p
                            class="
                                mt-2
                                text-lg
                                font-medium
                                text-[#16aeb9]
                            "
                        >
                            {{ $mentor->keahlian ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            <!-- CONTENT -->

            <div class="p-8 md:p-10">

                <h2
                    class="
                        text-2xl
                        font-bold
                        text-[#12344d]
                        mb-6
                    "
                >
                    Informasi Mentor
                </h2>


                <div
                    class="
                        grid
                        md:grid-cols-2
                        gap-5
                    "
                >

                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Nama
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->nama ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Jenis Kelamin
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->jenis_kelamin ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Domisili
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->domisili ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->keahlian ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Pengalaman
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{
                                $mentor->pengalaman
                                ?? '-'
                            }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Email
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                                break-all
                            "
                        >
                            {{ $mentor->email ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            No. WhatsApp
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->no_wa ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Alamat Lengkap
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->alamat_lengkap ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Status
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


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Portofolio
                        </p>

                        @if(!empty($mentor->portofolio_url))

                            <a
                                href="{{ $mentor->portofolio_url }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#16b8c4]
                                    hover:underline
                                    break-all
                                "
                            >
                                {{ $mentor->portofolio_url }}
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#12344d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            CV / Resume
                        </p>

                        @if(!empty($mentor->url_cv))

                            <a
                                href="{{ asset($mentor->url_cv) }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#16b8c4]
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
                                    text-[#12344d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Tag Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            @if(!empty($mentor->expertise_tags))
                                {{ implode(', ', $mentor->expertise_tags) }}
                            @else
                                -
                            @endif
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Ketersediaan
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                {{
                                    $mentor->is_available === null
                                        ? 'text-[#78909c]'
                                        : ($mentor->is_available ? 'text-green-600' : 'text-[#78909c]')
                                }}
                            "
                        >
                            {{
                                $mentor->is_available === null
                                    ? '-'
                                    : ($mentor->is_available ? 'Tersedia' : 'Tidak Tersedia')
                            }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Jumlah Mentee
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->jumlah_mentee ?? '0' }}
                        </p>

                    </div>

                </div>


                <div class="mt-8">

                    <h2
                        class="
                            text-xl
                            font-bold
                            text-[#12344d]
                            mb-3
                        "
                    >
                        Tentang Mentor
                    </h2>

                    <p
                        class="
                            text-[#64748b]
                            leading-relaxed
                        "
                    >
                        {{ $mentor->bio ?? 'Belum ada deskripsi tentang mentor ini.' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection