@extends('layouts.app')

@section('title', 'Daftar Talenta - EJSC Bakorwil')

@section('content')

<style>
    /* =========================================================
       DAFTAR TALENTA - LIME THEME
       Ukuran & layout TIDAK DIUBAH
    ========================================================= */

    .talenta-page {
        position: relative;
        overflow: hidden;
        background: #fafcf7;
        min-height: 100vh;
    }


    /* =========================================================
       BACKGROUND BUBBLES
    ========================================================= */

    .talenta-page::before,
    .talenta-page::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    .talenta-page::before {
        width: 320px;
        height: 320px;
        left: -160px;
        top: 300px;

        background: rgba(199, 234, 70, 0.08);

        animation:
            talentBubble
            8s
            ease-in-out
            infinite;
    }

    .talenta-page::after {
        width: 380px;
        height: 380px;
        right: -200px;
        bottom: 100px;

        background: rgba(199, 234, 70, 0.055);

        animation:
            talentBubble2
            10s
            ease-in-out
            infinite;
    }

    @keyframes talentBubble {

        0%,
        100% {
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

    @keyframes talentBubble2 {

        0%,
        100% {
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

    .talenta-hero {
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 10% 20%,
                rgba(199, 234, 70, 0.17),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 80%,
                rgba(199, 234, 70, 0.07),
                transparent 35%
            ),
            linear-gradient(
                135deg,
                #ffffff,
                #f9fcec,
                #ffffff
            );

        background-size: 180% 180%;

        animation:
            talentHeroGradient
            10s
            ease-in-out
            infinite;
    }

    @keyframes talentHeroGradient {

        0% {
            background-position:
                0% 50%;
        }

        50% {
            background-position:
                100% 50%;
        }

        100% {
            background-position:
                0% 50%;
        }

    }


    /* =========================================================
       HERO BUBBLES
    ========================================================= */

    .talenta-hero::before {
        content: "";

        position: absolute;

        width: 360px;
        height: 360px;

        border-radius: 50%;

        background:
            rgba(199, 234, 70, 0.07);

        right: -120px;
        top: -220px;

        animation:
            talentHeroBubble
            7s
            ease-in-out
            infinite;
    }

    .talenta-hero::after {
        content: "";

        position: absolute;

        width: 170px;
        height: 170px;

        border-radius: 50%;

        background:
            rgba(199, 234, 70, 0.10);

        left: 4%;
        bottom: -110px;

        animation:
            talentHeroBubble2
            6s
            ease-in-out
            infinite;
    }

    @keyframes talentHeroBubble {

        0%,
        100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(20px);
        }

    }

    @keyframes talentHeroBubble2 {

        0%,
        100% {
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

    .talenta-hero-content {
        position: relative;
        z-index: 3;

        animation:
            talentHeroEnter
            0.9s
            ease-out;
    }

    @keyframes talentHeroEnter {

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

    .talenta-title {
        color: #17324d;
    }

    /*
     * WARNA LIME UTAMA
     * Disamakan untuk semua elemen lime di halaman Talenta
     */
    .talenta-title span {
        color: #c7ea46;
    }

    .talenta-description {
        color: #64748b;
    }


    /* =========================================================
       DECORATIVE DOTS
    ========================================================= */

    .talenta-dots {
        position: absolute;

        width: 110px;
        height: 110px;

        right: 6%;
        bottom: 20px;

        background-image:
            radial-gradient(
                #c7ea46 1.7px,
                transparent 1.7px
            );

        background-size: 14px 14px;

        opacity: 0.42;

        animation:
            talentDotsFloat
            5s
            ease-in-out
            infinite,

            talentDotsPulse
            3s
            ease-in-out
            infinite;

        z-index: 2;
    }

    @keyframes talentDotsFloat {

        0%,
        100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(-12px);
        }

    }

    @keyframes talentDotsPulse {

        0%,
        100% {
            opacity: 0.25;
        }

        50% {
            opacity: 0.55;
        }

    }


    /* =========================================================
       SEARCH & FILTER
    ========================================================= */

    .talenta-search,
    .talenta-filter {

        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.25s ease;
    }

    .talenta-search:focus,
    .talenta-filter:focus {

        border-color:
            #c7ea46 !important;

        box-shadow:
            0 0 0 4px
                rgba(199, 234, 70, 0.13),

            0 6px 18px
                rgba(15, 23, 42, 0.06);

        transform:
            translateY(-1px);

        outline: none;
    }


    /* =========================================================
       TALENTA CARD
    ========================================================= */

    .talenta-card {
        position: relative;
        overflow: hidden;

        background:
            rgba(255, 255, 255, 0.98);

        border:
            1px solid #e8edf0;

        border-radius:
            18px;

        padding:
            24px;

        box-shadow:
            0 5px 20px
            rgba(15, 23, 42, 0.05);

        opacity: 0;

        animation:
            talentCardEnter
            0.65s
            cubic-bezier(
                0.22,
                0.61,
                0.36,
                1
            )
            forwards;

        transition:
            transform
            0.4s
            cubic-bezier(
                0.22,
                0.61,
                0.36,
                1
            ),

            box-shadow
            0.4s
            ease,

            border-color
            0.4s
            ease;
    }


    /* =========================================================
       CARD LIGHT CIRCLE
    ========================================================= */

    .talenta-card::before {
        content: "";

        position: absolute;

        width: 150px;
        height: 150px;

        border-radius: 50%;

        right: -80px;
        top: -80px;

        background:
            rgba(199, 234, 70, 0.08);

        transition:
            transform 0.5s ease,
            opacity 0.5s ease;
    }


    /* =========================================================
       CARD BOTTOM LINE
    ========================================================= */

    .talenta-card::after {
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
                #c7ea46,
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

    @keyframes talentCardEnter {

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

    .talenta-card:hover {

        transform:
            translateY(-9px)
            scale(1.015);

        border-color:
            rgba(199, 234, 70, 0.55);

        box-shadow:

            0 20px 40px
            rgba(15, 23, 42, 0.08),

            0 5px 15px
            rgba(199, 234, 70, 0.10);
    }

    .talenta-card:hover::before {

        transform:
            scale(1.7);

        opacity:
            0.7;
    }

    .talenta-card:hover::after {

        width:
            70%;
    }


    /* =========================================================
       AVATAR
    ========================================================= */

    .talenta-avatar {

        background:
            #c7ea46;

        color:
            #20300d;

        box-shadow:
            0 8px 18px
            rgba(199, 234, 70, 0.25);

        animation:
            talentAvatarFloat
            4s
            ease-in-out
            infinite;

        transition:
            transform 0.35s ease,
            box-shadow 0.35s ease;
    }

    @keyframes talentAvatarFloat {

        0%,
        100% {
            transform:
                translateY(0);
        }

        50% {
            transform:
                translateY(-4px);
        }

    }

    .talenta-card:hover
    .talenta-avatar {

        transform:
            translateY(-5px)
            rotate(3deg)
            scale(1.04);

        box-shadow:
            0 13px 25px
            rgba(199, 234, 70, 0.32);
    }


    /* =========================================================
       TEXT
    ========================================================= */

    .talenta-name {
        color:
            #17324d;
    }

    .talenta-skill {
        color:
            #50677a;
    }


    /* =========================================================
       KEAHLIAN BADGE
    ========================================================= */

    .badge-programming {

        background:
            #f0f7d9;

        color:
            #536b16;
    }

    .badge-design {

        background:
            #f3f7e7;

        color:
            #66753a;
    }

    .badge-marketing {

        background:
            #eef5df;

        color:
            #607533;
    }

    .badge-data {

        background:
            #f1f6e6;

        color:
            #65763d;
    }


    /* =========================================================
       LEVEL BADGE
    ========================================================= */

    .level-senior {

        background:
            #edf6d3;

        color:
            #587018;
    }

    .level-mid {

        background:
            #f2f6e5;

        color:
            #66733f;
    }

    .level-junior {

        background:
            #eef5df;

        color:
            #607533;
    }

    .level-umum {
        background: #eef2f4;
        color: #5b6b7a;
    }


    /* =========================================================
       MODAL PROFIL (animasi masuk + polish)
    ========================================================= */

    .talenta-modal-card {
        animation: talentModalIn .32s cubic-bezier(.2, .9, .3, 1) both;
    }

    @keyframes talentModalIn {
        from {
            opacity: 0;
            transform: translateY(18px) scale(.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .talenta-modal-avatar {
        background: linear-gradient(135deg, #c7ea46 0%, #8fc92a 100%);
        color: #2b3d0f;
        box-shadow: 0 10px 22px rgba(199, 234, 70, 0.35);
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .talenta-button {

        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #c7ea46,
                #b9dc3d
            );

        color:
            #20300d;

        box-shadow:
            0 5px 12px
            rgba(199, 234, 70, 0.22);

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            background 0.3s ease;
    }


    /* =========================================================
       BUTTON SHINE
    ========================================================= */

    .talenta-button::before {

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

    .talenta-button:hover::before {

        left:
            130%;
    }

    .talenta-button:hover {

        transform:
            translateY(-3px);

        background:
            linear-gradient(
                135deg,
                #b9dc3d,
                #abcf35
            );

        box-shadow:
            0 10px 22px
            rgba(199, 234, 70, 0.30);
    }


    /* =========================================================
       CARD DELAY
    ========================================================= */

    .talenta-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .talenta-card:nth-child(2) {
        animation-delay: 0.12s;
    }

    .talenta-card:nth-child(3) {
        animation-delay: 0.19s;
    }

    .talenta-card:nth-child(4) {
        animation-delay: 0.26s;
    }

    .talenta-card:nth-child(5) {
        animation-delay: 0.33s;
    }

    .talenta-card:nth-child(6) {
        animation-delay: 0.40s;
    }

    .talenta-card:nth-child(7) {
        animation-delay: 0.47s;
    }

    .talenta-card:nth-child(8) {
        animation-delay: 0.54s;
    }

    .talenta-card:nth-child(9) {
        animation-delay: 0.61s;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .talenta-hero::before {
            right:
                -160px;
        }

        .talenta-card {
            padding:
                20px;
        }

        .talenta-dots {
            right:
                -20px;
        }

    }
</style>


<!-- =========================================================
     MAIN PAGE
========================================================= -->

<div class="talenta-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="talenta-hero py-16">

        <div class="talenta-dots"></div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
        >

            <div class="talenta-hero-content">

                <h1
                    class="
                        talenta-title
                        text-4xl
                        font-bold
                        mb-4
                    "
                >

                    Daftar <span>Talenta</span>

                </h1>

                <p
                    class="
                        talenta-description
                        text-lg
                    "
                >

                    Jelajahi talenta terbaik dengan keahlian dan potensi luar biasa

                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         TALENTA SECTION
    ====================================================== -->

    <section class="py-12">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
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

                    <div
                        class="relative md:w-80"
                    >

                        <svg
                            class="
                                w-5
                                h-5
                                text-[#94a3b8]
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
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />

                        </svg>

                        <input
                            id="search-input"
                            type="text"
                            placeholder="Cari talenta..."
                            class="
                                talenta-search
                                w-full
                                pl-10
                                pr-4
                                py-2.5
                                border
                                border-[#e2e8ec]
                                rounded-xl
                                bg-white
                                text-[#17324d]
                                placeholder-[#94a3b8]
                                focus:outline-none
                            "
                        >

                    </div>


                    <!-- FILTER -->

                    <div>

                        <select
                            id="filter-select"
                            class="
                                talenta-filter
                                px-4
                                py-2.5
                                border
                                border-[#e2e8ec]
                                rounded-xl
                                bg-white
                                text-[#36566a]
                                focus:outline-none
                            "
                        >

                            <option value="semua">
                                Semua Keahlian ({{ number_format(count($talentas)) }})
                            </option>

                            @foreach ($kategoriTalenta as $kat)
                                <option value="{{ $kat['key'] }}">
                                    {{ $kat['label'] }} ({{ $kat['count'] }})
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 TALENTA LIST
            ================================================== -->

            <div
                id="talenta-list"
                class="
                    grid
                    md:grid-cols-2
                    lg:grid-cols-3
                    gap-6
                "
            >

                <!-- Talenta cards dirender oleh JavaScript -->

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
                        text-[#c7ea46]
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
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />

                </svg>

                <h3
                    class="
                        text-xl
                        font-semibold
                        text-[#17324d]
                        mb-2
                    "
                >

                    Talenta tidak ditemukan

                </h3>

                <p
                    class="text-[#64748b]"
                >

                    Coba ubah kata kunci pencarian atau filter keahlian

                </p>

            </div>

        </div>

    </section>

</div>


<!-- =========================================================
     MODAL PROFIL TALENTA
========================================================== -->
<div
    id="talenta-modal"
    class="fixed inset-0 z-[100000] hidden items-center justify-center p-4"
    style="background: rgba(23, 50, 77, .55); backdrop-filter: blur(4px);"
    role="dialog"
    aria-modal="true"
>
    <div class="talenta-modal-card relative w-full max-w-md rounded-3xl bg-white p-7 shadow-2xl">

        <!-- CLOSE -->
        <button
            type="button"
            class="talenta-modal-close absolute top-4 right-4 w-9 h-9 rounded-full flex items-center justify-center text-[#7a8a6f] hover:bg-[#f4f8ec] hover:rotate-90 active:scale-90 transition duration-200"
            aria-label="Tutup"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- HEADER -->
        <div class="flex flex-col items-center text-center mb-6 pt-2">
            <div id="talenta-modal-avatar" class="talenta-modal-avatar w-20 h-20 rounded-full ring-4 ring-[#eef7cf] flex items-center justify-center text-3xl font-bold mb-3"></div>
            <span id="talenta-modal-badge" class="px-3 py-1 rounded-full text-xs font-semibold mb-2"></span>
            <h3 id="talenta-modal-nama" class="text-2xl font-bold text-[#17324d] leading-tight mb-1.5"></h3>
            <p id="talenta-modal-skill" class="text-sm font-medium text-[#5c768f] leading-relaxed max-w-xs"></p>
        </div>

        <!-- DETAIL -->
        <div class="rounded-2xl bg-[#f6faf0] border border-[#e7f0d5]">
            <div id="talenta-modal-detail" class="px-5 py-2 divide-y divide-[#eef3e3]"></div>
        </div>

    </div>
</div>


@endsection


@section('scripts')

<script>

    /* =========================================================
       DATA TALENTA
    ========================================================= */

    const talentas = @json($talentas);

    /* Data terakhir yang dirender (dipakai oleh modal "Lihat Profil") */
    let currentTalentas = [];


    /* =========================================================
       KEAHLIAN LABEL (dibangkitkan dari data nyata di backend)
    ========================================================= */

    /* Berisi { key: { label, color } } untuk semua kategori yang
       benar-benar muncul di data (dari $kategoriTalenta). */
    const keahlianLabel = {};
    @json($kategoriTalenta)
        .forEach(function (kt) {
            keahlianLabel[kt.key] = {
                label: kt.label,
                color: kt.color
            };
        });


    /* =========================================================
       LEVEL COLOR
    ========================================================= */

    const levelColor = {

        Senior: 'level-senior',

        Mid: 'level-mid',

        Junior: 'level-junior',

        Umum: 'level-umum'

    };


    /* =========================================================
       ELEMENT
    ========================================================= */

    const searchInput =
        document.getElementById('search-input');

    const filterSelect =
        document.getElementById('filter-select');

    const talentaList =
        document.getElementById('talenta-list');

    const emptyState =
        document.getElementById('empty-state');


    /* =========================================================
       RENDER TALENTA
    ========================================================= */

    function renderTalentas() {

        const keyword =
            searchInput.value.toLowerCase();

        const keahlian =
            filterSelect.value;


        const filtered =
            talentas.filter(t => {

                const matchKeyword =
                    t.nama
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    t.skill
                        .toLowerCase()
                        .includes(keyword);


                const matchKeahlian =
                    keahlian === 'semua' ||
                    t.keahlian === keahlian;


                return matchKeyword &&
                       matchKeahlian;

            });


        /* EMPTY STATE */

        emptyState.classList.toggle(
            'hidden',
            filtered.length > 0
        );


        /* Simpan data yang sedang dirender agar bisa dibaca oleh modal */

        currentTalentas = filtered;


        /* =====================================================
           RENDER CARD
        ====================================================== */

        talentaList.innerHTML =
            filtered
                .map((t, index) => {

                    const k =
                        keahlianLabel[t.keahlian];


                    return `

                        <div
                            class="talenta-card"
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
                                        talenta-avatar
                                        w-16
                                        h-16
                                        rounded-2xl
                                        flex
                                        items-center
                                        justify-center
                                        text-xl
                                        font-bold
                                    "
                                >

                                    ${t.avatar}

                                </div>


                                <!-- LEVEL -->

                                <span
                                    class="
                                        px-3
                                        py-1
                                        rounded-full
                                        text-xs
                                        font-medium
                                        ${levelColor[t.level]}
                                    "
                                >

                                    ${t.level}

                                </span>

                            </div>


                            <!-- NAME -->

                            <h3
                                class="
                                    talenta-name
                                    text-lg
                                    font-semibold
                                    mb-1
                                "
                            >

                                ${t.nama}

                            </h3>


                            <!-- SKILL -->

                            <p
                                class="
                                    talenta-skill
                                    text-sm
                                    font-medium
                                    mb-3
                                "
                            >

                                ${t.skill}

                            </p>


                            <!-- KEAHLIAN -->

                            <span
                                class="
                                    inline-block
                                    px-3
                                    py-1
                                    rounded-full
                                    text-xs
                                    font-medium
                                    ${k.color}
                                    mb-4
                                "
                            >

                                ${k.label}

                            </span>


                            <!-- BUTTON -->

                            <button
                                type="button"
                                data-idx="${index}"
                                class="
                                    talenta-button
                                    w-full
                                    mt-2
                                    py-2.5
                                    rounded-xl
                                    font-medium
                                "
                            >

                                <span class="relative z-10">

                                    Lihat Profil

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
        renderTalentas
    );


    /* =========================================================
       FILTER EVENT
    ========================================================= */

    filterSelect.addEventListener(
        'change',
        renderTalentas
    );


    /* =========================================================
       INITIAL RENDER
    ========================================================= */

    renderTalentas();


    /* =========================================================
       MODAL PROFIL TALENTA
    ========================================================= */

    const talentaModal =
        document.getElementById('talenta-modal');

    function openTalentaModal(item) {

        if (!item) { return; }

        const k =
            keahlianLabel[item.keahlian] ||
            { label: 'Umum', color: 'badge-data' };

        document.getElementById('talenta-modal-avatar').textContent =
            item.avatar || '?';

        const badge =
            document.getElementById('talenta-modal-badge');
        badge.textContent = k.label;
        badge.className = 'px-3 py-1 rounded-full text-xs font-semibold ' + k.color;

        document.getElementById('talenta-modal-nama').textContent =
            item.nama;

        document.getElementById('talenta-modal-skill').textContent =
            item.skill || '—';

        /* Hanya baris yang datanya TERISI yang ditampilkan. Jika kosong,
           baris disembunyikan sama sekali (bukan teks "belum diisi"). */
        document.getElementById('talenta-modal-detail').innerHTML =
            rowDetail('Level', item.level) +
            rowDetail('Bidang Pekerjaan', item.bidang) +
            rowDetail('Domisili', item.domisili);

        talentaModal.classList.remove('hidden');
        talentaModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    /* Sembunyikan baris saat nilainya kosong (biar popup rapi). */
    function rowDetail(label, value) {
        const v =
            (value == null ? '' : String(value)).trim();
        if (!v) { return ''; }
        return `
            <div class="flex items-start gap-3 py-3">
                <svg class="w-5 h-5 mt-0.5 text-[#b7d83c] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <div class="text-[11px] font-semibold text-[#8aa06b] uppercase tracking-wider">${label}</div>
                    <div class="text-[15px] text-[#233d54] font-medium mt-0.5">${value}</div>
                </div>
            </div>`;
    }

    function closeTalentaModal() {
        talentaModal.classList.add('hidden');
        talentaModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    /* Delegasi klik tombol "Lihat Profil" pada daftar talenta */

    talentaList.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-idx]');
        if (!btn) { return; }
        openTalentaModal(currentTalentas[parseInt(btn.getAttribute('data-idx'), 10)]);
    });

    talentaModal.querySelector('.talenta-modal-close')
        .addEventListener('click', closeTalentaModal);

    talentaModal.addEventListener('click', (e) => {
        if (e.target === talentaModal) { closeTalentaModal(); }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !talentaModal.classList.contains('hidden')) {
            closeTalentaModal();
        }
    });

</script>

@endsection
