@extends('layouts.app')

@section(
    'title',
    'Profil Client - ' . ($client->nama_ukm ?? 'Client')
)

@section('content')

<div class="min-h-screen bg-[#fffef5] py-12">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">


        <a
            href="{{ route('client') }}"
            class="
                inline-flex
                items-center
                gap-2
                mb-8
                text-[#a28d20]
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

            Kembali ke Client

        </a>


        <div
            class="
                bg-white
                rounded-3xl
                shadow-xl
                border
                border-[#eee7b8]
                overflow-hidden
            "
        >


            <!-- HEADER -->

            <div
                class="
                    p-8
                    md:p-10
                    bg-gradient-to-br
                    from-[#fffbe0]
                    via-white
                    to-[#fffef5]
                "
            >

                @php

                    $nama =
                        $client->nama_ukm
                        ?? 'Client';

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
                            bg-gradient-to-br
                            from-[#E5CD35]
                            to-[#CDB62D]
                            text-white
                            flex
                            items-center
                            justify-center
                            text-3xl
                            font-bold
                            shadow-lg
                        "
                    >
                        {{ $avatar ?: 'CL' }}
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
                                bg-[#fff7c7]
                                text-[#9b8518]
                                text-sm
                                font-medium
                                mb-3
                            "
                        >
                            Client
                        </span>


                        <h1
                            class="
                                text-3xl
                                md:text-4xl
                                font-bold
                                text-[#30352f]
                            "
                        >
                            {{ $nama }}
                        </h1>


                        <p
                            class="
                                mt-2
                                text-lg
                                font-medium
                                text-[#a28d20]
                            "
                        >
                            {{ $client->nama_produk ?? '-' }}
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
                        text-[#30352f]
                        mb-6
                    "
                >
                    Informasi Client
                </h2>


                <div
                    class="
                        grid
                        md:grid-cols-2
                        gap-5
                    "
                >

                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Nama UKM / Client
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->nama_ukm ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Produk
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->nama_produk ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Nama Pemilik
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->nama_pemilik ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Domisili
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->domisili ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Alamat Lengkap
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->alamat_lengkap ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Kontak
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                            "
                        >
                            {{ $client->no_hp ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Email
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#30352f]
                                break-all
                            "
                        >
                            {{ $client->email ?? '-' }}
                        </p>

                    </div>


                    <div class="bg-[#fffef5] rounded-2xl p-5">

                        <p class="text-sm text-[#a6a48c]">
                            Website
                        </p>

                        @if(!empty($client->website))

                            <a
                                href="{{ $client->website }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#a28d20]
                                    hover:underline
                                    break-all
                                "
                            >
                                {{ $client->website }}
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#30352f]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>

                </div>


                <div class="mt-8">

                    <h2
                        class="
                            text-xl
                            font-bold
                            text-[#30352f]
                            mb-3
                        "
                    >
                        Tentang Client
                    </h2>

                    <p
                        class="
                            text-[#6d6a50]
                            leading-relaxed
                        "
                    >
                        {{ $client->deskripsi_usaha ?? 'Belum ada deskripsi tentang client ini.' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection