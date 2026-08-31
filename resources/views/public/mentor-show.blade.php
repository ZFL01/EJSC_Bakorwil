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
                                ?? $mentor->lama_pengalaman
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

                </div>


                @if(!empty($mentor->deskripsi))

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
                            {{ $mentor->deskripsi }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection