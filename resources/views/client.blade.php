@extends('layouts.app')

@section('title', 'Daftar Client - EJSC Bakorwil')

@section('content')

<style>
    /* =========================================================
       DAFTAR CLIENT - SOFT BRIGHT YELLOW THEME
       PRIMARY COLOR : #E5CD35
    ========================================================= */

    .client-page {
        position: relative;
        overflow: hidden;
        background: #fffef5;
        min-height: 100vh;
    }


    /* =========================================================
       BACKGROUND BUBBLES
    ========================================================= */

    .client-page::before,
    .client-page::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    .client-page::before {
        width: 320px;
        height: 320px;
        left: -160px;
        top: 300px;

        background: rgba(229, 205, 53, 0.09);

        animation:
            clientBubble
            8s
            ease-in-out
            infinite;
    }

    .client-page::after {
        width: 380px;
        height: 380px;
        right: -200px;
        bottom: 100px;

        background: rgba(229, 205, 53, 0.07);

        animation:
            clientBubble2
            10s
            ease-in-out
            infinite;
    }

    @keyframes clientBubble {

        0%, 100% {
            transform:
                translate(0, 0)
                scale(1);
        }

        50% {
            transform:
                translate(35px, -25px)
                scale(1.08);
        }
    }

    @keyframes clientBubble2 {

        0%, 100% {
            transform:
                translate(0, 0);
        }

        50% {
            transform:
                translate(-30px, 25px);
        }
    }


    /* =========================================================
       HERO
    ========================================================= */

    .client-hero {
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 10% 20%,
                rgba(229, 205, 53, 0.22),
                transparent 30%
            ),

            radial-gradient(
                circle at 90% 80%,
                rgba(229, 205, 53, 0.12),
                transparent 35%
            ),

            linear-gradient(
                135deg,
                #fffbe0,
                #fff8c4,
                #fffef0
            );

        background-size: 180% 180%;

        animation:
            clientHeroGradient
            10s
            ease-in-out
            infinite;
    }

    @keyframes clientHeroGradient {

        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }


    /* =========================================================
       HERO DECORATION
    ========================================================= */

    .client-hero::before {
        content: "";

        position: absolute;

        width: 360px;
        height: 360px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, 0.42);

        right: -120px;
        top: -220px;

        animation:
            clientHeroBubble
            7s
            ease-in-out
            infinite;
    }

    .client-hero::after {
        content: "";

        position: absolute;

        width: 170px;
        height: 170px;

        border-radius: 50%;

        background:
            rgba(229, 205, 53, 0.13);

        left: 4%;
        bottom: -110px;

        animation:
            clientHeroBubble2
            6s
            ease-in-out
            infinite;
    }

    @keyframes clientHeroBubble {

        0%, 100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(20px);
        }
    }

    @keyframes clientHeroBubble2 {

        0%, 100% {
            transform:
                translate(0, 0);
        }

        50% {
            transform:
                translate(20px, -15px);
        }
    }


    /* =========================================================
       HERO CONTENT
    ========================================================= */

    .client-hero-content {
        position: relative;
        z-index: 3;

        animation:
            clientHeroEnter
            0.9s
            ease-out;
    }

    @keyframes clientHeroEnter {

        from {
            opacity: 0;

            transform:
                translateY(25px);
        }

        to {
            opacity: 1;

            transform:
                translateY(0);
        }
    }


    /* =========================================================
       HERO TEXT
    ========================================================= */

    .client-title {
        color: #263238;
    }

    .client-title span {
        color: #E5CD35;
    }

    .client-description {
        color: #6d6a50;
    }


    /* =========================================================
       DECORATIVE DOTS
    ========================================================= */

    .client-dots {
        position: absolute;

        width: 110px;
        height: 110px;

        right: 6%;
        bottom: 20px;

        background-image:
            radial-gradient(
                #E5CD35 1.7px,
                transparent 1.7px
            );

        background-size: 14px 14px;

        opacity: 0.32;

        animation:
            clientDotsFloat
            5s
            ease-in-out
            infinite,

            clientDotsPulse
            3s
            ease-in-out
            infinite;

        z-index: 2;
    }

    @keyframes clientDotsFloat {

        0%, 100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(-12px);
        }
    }

    @keyframes clientDotsPulse {

        0%, 100% {
            opacity: 0.22;
        }

        50% {
            opacity: 0.48;
        }
    }


    /* =========================================================
       SEARCH & FILTER
    ========================================================= */

    .client-search,
    .client-filter {

        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.25s ease;
    }

    .client-search:focus,
    .client-filter:focus {

        border-color:
            #E5CD35 !important;

        box-shadow:
            0 0 0 4px rgba(229, 205, 53, 0.13),
            0 6px 18px rgba(180, 155, 25, 0.08);

        transform:
            translateY(-1px);

        outline: none;
    }


    /* =========================================================
       CLIENT CARD
    ========================================================= */

    .client-card {

        position: relative;
        overflow: hidden;

        background:
            rgba(255, 255, 255, 0.97);

        border:
            1px solid #eee7b8;

        border-radius:
            18px;

        padding:
            24px;

        box-shadow:
            0 5px 20px
            rgba(130, 110, 20, 0.06);

        opacity: 0;

        animation:
            clientCardEnter
            0.65s
            cubic-bezier(
                0.22,
                0.61,
                0.36,
                1
            )
            forwards;

        transition:
            transform 0.4s
            cubic-bezier(
                0.22,
                0.61,
                0.36,
                1
            ),

            box-shadow 0.4s ease,

            border-color 0.4s ease;
    }


    /* =========================================================
       CARD LIGHT CIRCLE
    ========================================================= */

    .client-card::before {

        content: "";

        position: absolute;

        width: 150px;
        height: 150px;

        border-radius: 50%;

        right: -80px;
        top: -80px;

        background:
            rgba(229, 205, 53, 0.10);

        transition:
            transform 0.5s ease,
            opacity 0.5s ease;
    }


    /* =========================================================
       CARD BOTTOM LIGHT
    ========================================================= */

    .client-card::after {

        content: "";

        position: absolute;

        width: 0;
        height: 2px;

        left: 50%;
        bottom: 0;

        background:
            linear-gradient(
                90deg,
                transparent,
                #E5CD35,
                transparent
            );

        transform:
            translateX(-50%);

        transition:
            width 0.5s ease;
    }


    /* =========================================================
       CARD ENTER
    ========================================================= */

    @keyframes clientCardEnter {

        from {
            opacity: 0;

            transform:
                translateY(35px)
                scale(0.97);
        }

        to {
            opacity: 1;

            transform:
                translateY(0)
                scale(1);
        }
    }


    /* =========================================================
       CARD HOVER
    ========================================================= */

    .client-card:hover {

        transform:
            translateY(-9px)
            scale(1.015);

        border-color:
            #e5cd35;

        box-shadow:

            0 20px 40px
            rgba(160, 135, 20, 0.13),

            0 5px 15px
            rgba(160, 135, 20, 0.06);
    }

    .client-card:hover::before {

        transform:
            scale(1.7);

        opacity:
            0.7;
    }

    .client-card:hover::after {

        width:
            70%;
    }


    /* =========================================================
       AVATAR
    ========================================================= */

    .client-avatar {

        background:
            linear-gradient(
                135deg,
                #E5CD35,
                #CDB62D
            );

        box-shadow:
            0 8px 18px
            rgba(190, 165, 25, 0.22);

        animation:
            clientAvatarFloat
            4s
            ease-in-out
            infinite;

        transition:
            transform 0.35s ease,
            box-shadow 0.35s ease;
    }

    @keyframes clientAvatarFloat {

        0%, 100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(-4px);
        }
    }

    .client-card:hover .client-avatar {

        transform:
            translateY(-5px)
            rotate(3deg)
            scale(1.04);

        box-shadow:
            0 13px 25px
            rgba(190, 165, 25, 0.30);
    }


    /* =========================================================
       TEXT
    ========================================================= */

    .client-name {
        color:
            #30352f;
    }

    .client-industry {
        color:
            #a28d20;
    }

    .client-info {
        color:
            #7c806f;
    }


    /* =========================================================
       CATEGORY BADGES
    ========================================================= */

    .badge-korporasi {

        background:
            #fff7c7;

        color:
            #9b8518;
    }

    .badge-startup {

        background:
            #fff9dc;

        color:
            #9e8b27;
    }

    .badge-umkm {

        background:
            #f7f2cf;

        color:
            #8f7c19;
    }

    .badge-pemerintahan {

        background:
            #f2edc8;

        color:
            #817019;
    }


    /* =========================================================
       TRUSTED TEXT
    ========================================================= */

    .trusted-client {

        color:
            #b19a20;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .client-button {

        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #E5CD35,
                #CDB62D
            );

        box-shadow:
            0 5px 12px
            rgba(190, 165, 25, 0.18);

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }


    /* =========================================================
       BUTTON SHINE
    ========================================================= */

    .client-button::before {

        content: "";

        position: absolute;

        top: 0;
        left: -100%;

        width: 60%;
        height: 100%;

        background:
            linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.42),
                transparent
            );

        transform:
            skewX(-20deg);

        transition:
            left 0.6s ease;
    }

    .client-button:hover::before {

        left:
            130%;
    }

    .client-button:hover {

        transform:
            translateY(-3px);

        box-shadow:
            0 10px 22px
            rgba(190, 165, 25, 0.28);
    }


    /* =========================================================
       CARD DELAY
    ========================================================= */

    .client-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .client-card:nth-child(2) {
        animation-delay: 0.12s;
    }

    .client-card:nth-child(3) {
        animation-delay: 0.19s;
    }

    .client-card:nth-child(4) {
        animation-delay: 0.26s;
    }

    .client-card:nth-child(5) {
        animation-delay: 0.33s;
    }

    .client-card:nth-child(6) {
        animation-delay: 0.40s;
    }

    .client-card:nth-child(7) {
        animation-delay: 0.47s;
    }

    .client-card:nth-child(8) {
        animation-delay: 0.54s;
    }

    .client-card:nth-child(9) {
        animation-delay: 0.61s;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .client-hero::before {
            right:
                -160px;
        }

        .client-card {
            padding:
                20px;
        }

        .client-dots {
            right:
                -20px;
        }

    }

</style>


<!-- =========================================================
     MAIN PAGE
========================================================= -->

<div class="client-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="client-hero py-16">

        <div class="client-dots"></div>

        <div
            class="
                max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
            "
        >

            <div class="client-hero-content">

                <h1
                    class="
                        client-title
                        text-4xl
                        font-bold
                        mb-4
                    "
                >

                    Daftar
                    <span>Client</span>

                </h1>

                <p
                    class="
                        client-description
                        text-lg
                    "
                >
                    Terhubung dengan client yang membutuhkan
                    layanan dan keahlian terbaik
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CLIENT SECTION
    ====================================================== -->

    <section class="py-12">

        <div
            class="
                max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
            "
        >


            <!-- =================================================
                 SEARCH & FILTER
            ================================================== -->

            <div class="mb-8">

                <div
                    class="
                        flex
                        flex-col
                        md:flex-row
                        gap-4
                        md:items-center
                        md:justify-between
                    "
                >


                    <!-- SEARCH -->

                    <div class="relative md:w-80">

                        <svg
                            class="
                                w-5
                                h-5
                                text-[#a99b4c]
                                absolute
                                left-3
                                top-1/2
                                -translate-y-1/2
                            "
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="
                                    M21 21l-6-6
                                    m2-5a7 7 0
                                    11-14 0
                                    7 7 0
                                    0114 0z
                                "
                            />

                        </svg>

                        <input
                            id="search-input"
                            type="text"
                            placeholder="Cari client..."
                            class="
                                client-search
                                w-full
                                pl-10
                                pr-4
                                py-2.5
                                border
                                border-[#eee7b8]
                                rounded-xl
                                bg-white
                                text-[#30352f]
                                placeholder-[#a6a48c]
                                focus:outline-none
                            "
                        >

                    </div>


                    <!-- FILTER -->

                    <div>

                        <select
                            id="filter-select"
                            class="
                                client-filter
                                px-4
                                py-2.5
                                border
                                border-[#eee7b8]
                                rounded-xl
                                bg-white
                                text-[#55583f]
                                focus:outline-none
                            "
                        >

                            <option value="semua">
                                Semua Kategori
                            </option>

                            <option value="korporasi">
                                Korporasi
                            </option>

                            <option value="startup">
                                Startup
                            </option>

                            <option value="umkm">
                                UMKM
                            </option>

                            <option value="pemerintahan">
                                Pemerintahan
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 CLIENT LIST
            ================================================== -->

            <div
                id="client-list"
                class="
                    grid
                    md:grid-cols-2
                    lg:grid-cols-3
                    gap-6
                "
            >
                <!-- Client cards dirender oleh JavaScript -->
            </div>


            <!-- =================================================
                 EMPTY STATE
            ================================================== -->

            <div
                id="empty-state"
                class="
                    hidden
                    text-center
                    py-16
                "
            >

                <svg
                    class="
                        w-16
                        h-16
                        mx-auto
                        text-[#d9c83a]
                        mb-4
                    "
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M21 21l-6-6
                            m2-5a7 7 0
                            11-14 0
                            7 7 0
                            0114 0z
                        "
                    />

                </svg>

                <h3
                    class="
                        text-xl
                        font-semibold
                        text-[#55583f]
                        mb-2
                    "
                >
                    Client tidak ditemukan
                </h3>

                <p class="text-[#85856f]">
                    Coba ubah kata kunci pencarian
                    atau filter kategori
                </p>

            </div>

        </div>

    </section>

</div>


@endsection


@section('scripts')

<script>

    /* =========================================================
       DATA CLIENT
    ========================================================= */

    const clients = [

        {
            nama: 'PT Maju Bersama',
            kategori: 'korporasi',
            industri: 'Manufaktur',
            proyek: 25,
            avatar: 'MB'
        },

        {
            nama: 'Startup Inovasi',
            kategori: 'startup',
            industri: 'Teknologi',
            proyek: 12,
            avatar: 'SI'
        },

        {
            nama: 'CV Karya Mandiri',
            kategori: 'umkm',
            industri: 'Kuliner',
            proyek: 8,
            avatar: 'KM'
        },

        {
            nama: 'Dinas Pendidikan',
            kategori: 'pemerintahan',
            industri: 'Pendidikan',
            proyek: 15,
            avatar: 'DP'
        },

        {
            nama: 'PT Solusi Digital',
            kategori: 'korporasi',
            industri: 'IT Services',
            proyek: 30,
            avatar: 'SD'
        },

        {
            nama: 'Startup Fintech',
            kategori: 'startup',
            industri: 'Keuangan',
            proyek: 10,
            avatar: 'SF'
        },

        {
            nama: 'Toko Berkah',
            kategori: 'umkm',
            industri: 'Retail',
            proyek: 5,
            avatar: 'TB'
        },

        {
            nama: 'Bank Daerah',
            kategori: 'pemerintahan',
            industri: 'Perbankan',
            proyek: 18,
            avatar: 'BD'
        },

        {
            nama: 'PT Global Media',
            kategori: 'korporasi',
            industri: 'Media',
            proyek: 22,
            avatar: 'GM'
        }

    ];


    /* =========================================================
       KATEGORI LABEL
    ========================================================= */

    const kategoriLabel = {

        korporasi: {
            label: 'Korporasi',
            color: 'badge-korporasi'
        },

        startup: {
            label: 'Startup',
            color: 'badge-startup'
        },

        umkm: {
            label: 'UMKM',
            color: 'badge-umkm'
        },

        pemerintahan: {
            label: 'Pemerintahan',
            color: 'badge-pemerintahan'
        }

    };


    /* =========================================================
       ELEMENT
    ========================================================= */

    const searchInput =
        document.getElementById(
            'search-input'
        );

    const filterSelect =
        document.getElementById(
            'filter-select'
        );

    const clientList =
        document.getElementById(
            'client-list'
        );

    const emptyState =
        document.getElementById(
            'empty-state'
        );


    /* =========================================================
       RENDER CLIENT
    ========================================================= */

    function renderClients() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();

        const kategori =
            filterSelect.value;


        const filtered =
            clients.filter(c => {

                const matchKeyword =

                    c.nama
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    c.industri
                        .toLowerCase()
                        .includes(keyword);


                const matchKategori =

                    kategori === 'semua'

                    ||

                    c.kategori === kategori;


                return (
                    matchKeyword &&
                    matchKategori
                );

            });


        /* =====================================================
           EMPTY STATE
        ====================================================== */

        emptyState.classList.toggle(
            'hidden',
            filtered.length > 0
        );


        /* =====================================================
           RENDER CARD
        ====================================================== */

        clientList.innerHTML =

            filtered

                .map((c, index) => {

                    const k =
                        kategoriLabel[
                            c.kategori
                        ];


                    return `

                        <div
                            class="client-card"
                            style="
                                animation-delay:
                                ${index * 0.07}s
                            "
                        >

                            <!-- TOP -->

                            <div
                                class="
                                    flex
                                    items-start
                                    justify-between
                                    mb-4
                                "
                            >

                                <!-- AVATAR -->

                                <div
                                    class="
                                        client-avatar
                                        w-16
                                        h-16
                                        rounded-2xl
                                        flex
                                        items-center
                                        justify-center
                                        text-white
                                        text-xl
                                        font-bold
                                    "
                                >

                                    ${c.avatar}

                                </div>


                                <!-- CATEGORY -->

                                <span
                                    class="
                                        px-3
                                        py-1
                                        rounded-full
                                        text-xs
                                        font-medium
                                        ${k.color}
                                    "
                                >

                                    ${k.label}

                                </span>

                            </div>


                            <!-- NAME -->

                            <h3
                                class="
                                    client-name
                                    text-lg
                                    font-semibold
                                    mb-1
                                "
                            >

                                ${c.nama}

                            </h3>


                            <!-- INDUSTRY -->

                            <p
                                class="
                                    client-industry
                                    text-sm
                                    font-medium
                                    mb-3
                                "
                            >

                                ${c.industri}

                            </p>


                            <!-- INFO -->

                            <div
                                class="
                                    client-info
                                    flex
                                    items-center
                                    justify-between
                                    text-sm
                                    mb-4
                                "
                            >

                                <!-- PROJECT -->

                                <span
                                    class="
                                        inline-flex
                                        items-center
                                    "
                                >

                                    <svg
                                        class="
                                            w-4
                                            h-4
                                            mr-1
                                        "
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="
                                                M9 12l2 2
                                                4-4m6 2
                                                a9 9 0
                                                11-18 0
                                                9 9 0
                                                0118 0z
                                            "
                                        />

                                    </svg>

                                    ${c.proyek} Proyek

                                </span>


                                <!-- TRUSTED -->

                                <span
                                    class="
                                        trusted-client
                                        inline-flex
                                        items-center
                                    "
                                >

                                    <svg
                                        class="
                                            w-4
                                            h-4
                                            mr-1
                                        "
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            d="
                                                M12 2
                                                l3.09 6.26
                                                L22 9.27
                                                l-5 4.87
                                                1.18 6.88
                                                L12 17.77
                                                l-6.18 3.25
                                                L7 14.14
                                                2 9.27
                                                l6.91-1.01
                                                L12 2z
                                            "
                                        />

                                    </svg>

                                    Terpercaya

                                </span>

                            </div>


                            <!-- BUTTON -->

                            <button
                                class="
                                    client-button
                                    w-full
                                    py-2.5
                                    text-white
                                    rounded-xl
                                    font-medium
                                "
                            >

                                <span
                                    class="
                                        relative
                                        z-10
                                    "
                                >
                                    Hubungi Client
                                </span>

                            </button>

                        </div>

                    `;

                })

                .join('');

    }


    /* =========================================================
       SEARCH EVENT
    ========================================================= */

    searchInput.addEventListener(
        'input',
        renderClients
    );


    /* =========================================================
       FILTER EVENT
    ========================================================= */

    filterSelect.addEventListener(
        'change',
        renderClients
    );


    /* =========================================================
       INITIAL RENDER
    ========================================================= */

    renderClients();

</script>

@endsection