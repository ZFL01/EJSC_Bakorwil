@extends('layouts.app')

@section('title', 'Menu Mentor - EJSC Bakorwil')

@section('content')

<style>
    /* =========================================================
       DAFTAR MENTOR - EJSC BAKORWIL
       COLOR STYLE MENGIKUTI REFERENCE IMAGE
    ========================================================= */

    .mentor-page {
        position: relative;
        overflow: hidden;
        background: #f8feff;
        min-height: 100vh;
    }


    /* =========================================================
       BACKGROUND BUBBLES
    ========================================================= */

    .mentor-page::before,
    .mentor-page::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    .mentor-page::before {
        width: 320px;
        height: 320px;
        left: -160px;
        top: 300px;

        background: rgba(22, 184, 196, 0.10);

        animation: floatingBubble 8s ease-in-out infinite;
    }

    .mentor-page::after {
        width: 380px;
        height: 380px;
        right: -200px;
        bottom: 100px;

        background: rgba(22, 184, 196, 0.07);

        animation: floatingBubble2 10s ease-in-out infinite;
    }


    @keyframes floatingBubble {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }

        50% {
            transform: translate(35px, -25px) scale(1.08);
        }
    }


    @keyframes floatingBubble2 {
        0%, 100% {
            transform: translate(0, 0);
        }

        50% {
            transform: translate(-30px, 25px);
        }
    }


    /* =========================================================
       HERO
    ========================================================= */

    .mentor-hero {
        position: relative;
        overflow: hidden;

        background:
            radial-gradient(
                circle at 10% 20%,
                rgba(72, 221, 228, 0.28),
                transparent 30%
            ),

            radial-gradient(
                circle at 90% 80%,
                rgba(22, 184, 196, 0.12),
                transparent 35%
            ),

            linear-gradient(
                135deg,
                #dffbfc,
                #c9f5f7,
                #f4feff
            );

        background-size: 180% 180%;

        animation: heroGradient 10s ease-in-out infinite;
    }


    @keyframes heroGradient {
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

    .mentor-hero::before {
        content: "";

        position: absolute;

        width: 360px;
        height: 360px;

        border-radius: 50%;

        background: rgba(255, 255, 255, 0.30);

        right: -120px;
        top: -220px;

        animation: heroBubble 7s ease-in-out infinite;
    }


    .mentor-hero::after {
        content: "";

        position: absolute;

        width: 170px;
        height: 170px;

        border-radius: 50%;

        background: rgba(72, 221, 228, 0.16);

        left: 4%;
        bottom: -110px;

        animation: heroBubble2 6s ease-in-out infinite;
    }


    @keyframes heroBubble {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(20px);
        }
    }


    @keyframes heroBubble2 {
        0%, 100% {
            transform: translate(0, 0);
        }

        50% {
            transform: translate(20px, -15px);
        }
    }


    /* =========================================================
       HERO CONTENT
    ========================================================= */

    .hero-content {
        position: relative;
        z-index: 3;

        animation: heroEnter 0.9s ease-out;
    }


    @keyframes heroEnter {
        from {
            opacity: 0;
            transform: translateY(25px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* =========================================================
       JUDUL
       Mengikuti warna tulisan pada gambar referensi
    ========================================================= */

    .hero-title {
        color: #12344d;
    }


    /* "Mentor" dibuat cyan seperti "Mentor," pada gambar */

    .hero-title span {
        color: #16b8c4;
    }


    .hero-description {
        color: #52758b;
    }


    /* =========================================================
       DECORATIVE DOTS
    ========================================================= */

    .mentor-dots {
        position: absolute;

        width: 110px;
        height: 110px;

        right: 6%;
        bottom: 20px;

        background-image:
            radial-gradient(
                #35cbd4 1.7px,
                transparent 1.7px
            );

        background-size: 14px 14px;

        opacity: 0.35;

        animation:
            dotsFloat 5s ease-in-out infinite,
            dotsPulse 3s ease-in-out infinite;

        z-index: 2;
    }


    @keyframes dotsFloat {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-12px);
        }
    }


    @keyframes dotsPulse {
        0%, 100% {
            opacity: 0.25;
        }

        50% {
            opacity: 0.55;
        }
    }


    /* =========================================================
       SEARCH & FILTER
    ========================================================= */

    .mentor-search,
    .mentor-filter {
        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.25s ease;
    }


    .mentor-search:focus,
    .mentor-filter:focus {
        border-color: #16b8c4 !important;

        box-shadow:
            0 0 0 4px rgba(22, 184, 196, 0.10),
            0 6px 18px rgba(22, 184, 196, 0.08);

        transform: translateY(-1px);

        outline: none;
    }


    /* =========================================================
       MENTOR CARD
    ========================================================= */

    .mentor-card {
        position: relative;
        overflow: hidden;

        background: rgba(255, 255, 255, 0.97);

        border: 1px solid #dceff2;

        border-radius: 18px;

        padding: 24px;

        box-shadow:
            0 5px 20px rgba(18, 52, 77, 0.06);

        opacity: 0;

        animation:
            cardEnter 0.65s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;

        transition:
            transform 0.4s cubic-bezier(0.22, 0.61, 0.36, 1),
            box-shadow 0.4s ease,
            border-color 0.4s ease;
    }


    /* Lingkaran cahaya di dalam card */

    .mentor-card::before {
        content: "";

        position: absolute;

        width: 150px;
        height: 150px;

        border-radius: 50%;

        right: -80px;
        top: -80px;

        background: rgba(72, 221, 228, 0.09);

        transition:
            transform 0.5s ease,
            opacity 0.5s ease;
    }


    /* Garis cahaya bawah */

    .mentor-card::after {
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
                #16b8c4,
                transparent
            );

        transform: translateX(-50%);

        transition: width 0.5s ease;
    }


    /* =========================================================
       CARD ENTER ANIMATION
    ========================================================= */

    @keyframes cardEnter {
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

    .mentor-card:hover {
        transform:
            translateY(-9px)
            scale(1.015);

        border-color: #b6e8ec;

        box-shadow:
            0 20px 40px rgba(20, 150, 160, 0.13),
            0 5px 15px rgba(20, 150, 160, 0.06);
    }


    .mentor-card:hover::before {
        transform: scale(1.7);

        opacity: 0.7;
    }


    .mentor-card:hover::after {
        width: 70%;
    }


    /* =========================================================
       AVATAR
    ========================================================= */

    .mentor-avatar {
        background:
            linear-gradient(
                135deg,
                #20c4ce,
                #159da8
            );

        box-shadow:
            0 8px 18px rgba(22, 184, 196, 0.20);

        animation:
            avatarFloat 4s ease-in-out infinite;

        transition:
            transform 0.35s ease,
            box-shadow 0.35s ease;
    }


    @keyframes avatarFloat {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-4px);
        }
    }


    .mentor-card:hover .mentor-avatar {
        transform:
            translateY(-5px)
            rotate(3deg)
            scale(1.04);

        box-shadow:
            0 13px 25px rgba(22, 184, 196, 0.28);
    }


    /* =========================================================
       TEXT
    ========================================================= */

    /* Nama mengikuti navy "Menghubungkan / Client" */

    .mentor-name {
        color: #12344d;
    }


    /* Keahlian mengikuti cyan "Mentor" */

    .mentor-skill {
        color: #16aeb9;
    }


    .mentor-experience {
        color: #708898;
    }


    /* =========================================================
       BADGE
    ========================================================= */

    .badge-teknologi {
        background: #dcf8fa;

        color: #138d98;
    }


    .badge-bisnis {
        background: #e2f8f2;

        color: #168a72;
    }


    .badge-desain {
        background: #e4f7f9;

        color: #278c98;
    }


    .badge-pendidikan {
        background: #edf8f6;

        color: #43877c;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .mentor-button {
        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #16bac4,
                #159da8
            );

        box-shadow:
            0 5px 12px rgba(22, 184, 196, 0.16);

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }


    /* Cahaya berjalan */

    .mentor-button::before {
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
                rgba(255, 255, 255, 0.35),
                transparent
            );

        transform: skewX(-20deg);

        transition: left 0.6s ease;
    }


    .mentor-button:hover::before {
        left: 130%;
    }


    .mentor-button:hover {
        transform: translateY(-3px);

        box-shadow:
            0 10px 22px rgba(22, 184, 196, 0.27);
    }


    /* =========================================================
       CARD ANIMATION DELAY
    ========================================================= */

    .mentor-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .mentor-card:nth-child(2) {
        animation-delay: 0.12s;
    }

    .mentor-card:nth-child(3) {
        animation-delay: 0.19s;
    }

    .mentor-card:nth-child(4) {
        animation-delay: 0.26s;
    }

    .mentor-card:nth-child(5) {
        animation-delay: 0.33s;
    }

    .mentor-card:nth-child(6) {
        animation-delay: 0.40s;
    }

    .mentor-card:nth-child(7) {
        animation-delay: 0.47s;
    }

    .mentor-card:nth-child(8) {
        animation-delay: 0.54s;
    }

    .mentor-card:nth-child(9) {
        animation-delay: 0.61s;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .mentor-hero::before {
            right: -160px;
        }

        .mentor-card {
            padding: 20px;
        }

        .mentor-dots {
            right: -20px;
        }

    }
</style>


<!-- =========================================================
     MAIN PAGE
========================================================= -->

<div class="mentor-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="mentor-hero py-16">

        <div class="mentor-dots"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="hero-content">

                <h1 class="hero-title text-4xl font-bold mb-4">

                    Daftar
                    <span>Mentor</span>

                </h1>

                <p class="hero-description text-lg">
                    Temukan mentor berpengalaman untuk membimbing pengembangan karier Anda
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         MENTOR SECTION
    ====================================================== -->

    <section class="py-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- =================================================
                 SEARCH & FILTER
            ================================================== -->

            <div class="mb-8">

                <div
                    class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between"
                >


                    <!-- Search -->

                    <div class="relative md:w-80">

                        <svg
                            class="w-5 h-5 text-[#7da0ad] absolute left-3 top-1/2 -translate-y-1/2"
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
                            placeholder="Cari mentor..."
                            class="mentor-search w-full pl-10 pr-4 py-2.5 border border-[#dceff2] rounded-xl bg-white text-[#12344d] placeholder-[#8ba4af] focus:outline-none"
                        >

                    </div>


                    <!-- Filter -->

                    <div>

                        <select
                            id="filter-select"
                            class="mentor-filter px-4 py-2.5 border border-[#dceff2] rounded-xl bg-white text-[#36566a] focus:outline-none"
                        >

                            <option value="semua">
                                Semua Bidang
                            </option>

                            <option value="teknologi">
                                Teknologi
                            </option>

                            <option value="bisnis">
                                Bisnis
                            </option>

                            <option value="desain">
                                Desain
                            </option>

                            <option value="pendidikan">
                                Pendidikan
                            </option>

                        </select>

                    </div>

                </div>

            </div>


           <!-- =========================================================
                MENTOR LIST
            ========================================================= -->

            <div
                id="mentor-list"
                class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
            >

                @forelse($mentors as $mentor)

                    @php
                        $nama = $mentor->nama ?? 'Mentor';

                        $keahlian = $mentor->keahlian ?? '-';

                        $avatar = collect(
                            preg_split('/\s+/', trim($nama))
                        )
                        ->filter()
                        ->take(2)
                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                        ->implode('');

                        /*
                        * Tentukan bidang dari keahlian.
                        * Jika database Anda memiliki field bidang,
                        * field tersebut akan diprioritaskan.
                        */
                        $bidang = strtolower(
                            $mentor->bidang
                            ?? ''
                        );

                        if ($bidang === '') {

                            $keahlianLower =
                                strtolower($keahlian);

                            if (
                                str_contains($keahlianLower, 'program')
                                || str_contains($keahlianLower, 'software')
                                || str_contains($keahlianLower, 'teknologi')
                                || str_contains($keahlianLower, 'ai')
                                || str_contains($keahlianLower, 'data')
                                || str_contains($keahlianLower, 'cloud')
                            ) {
                                $bidang = 'teknologi';

                            } elseif (
                                str_contains($keahlianLower, 'bisnis')
                                || str_contains($keahlianLower, 'marketing')
                                || str_contains($keahlianLower, 'usaha')
                            ) {
                                $bidang = 'bisnis';

                            } elseif (
                                str_contains($keahlianLower, 'desain')
                                || str_contains($keahlianLower, 'design')
                                || str_contains($keahlianLower, 'ui')
                                || str_contains($keahlianLower, 'ux')
                            ) {
                                $bidang = 'desain';

                            } else {
                                $bidang = 'pendidikan';
                            }
                        }


                        $bidangLabel = match($bidang) {

                            'teknologi' => [
                                'label' => 'Teknologi',
                                'class' => 'badge-teknologi'
                            ],

                            'bisnis' => [
                                'label' => 'Bisnis',
                                'class' => 'badge-bisnis'
                            ],

                            'desain' => [
                                'label' => 'Desain',
                                'class' => 'badge-desain'
                            ],

                            default => [
                                'label' => 'Pendidikan',
                                'class' => 'badge-pendidikan'
                            ],
                        };
                    @endphp


                    <div
                        class="mentor-card"
                        data-nama="{{ strtolower($nama) }}"
                        data-keahlian="{{ strtolower($keahlian) }}"
                        data-bidang="{{ $bidang }}"
                    >

                        <!-- TOP -->

                        <div class="flex items-start justify-between mb-4">

                            <!-- AVATAR -->

                            <div
                                class="
                                    mentor-avatar
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
                                {{ $avatar ?: 'ME' }}
                            </div>


                            <!-- BADGE -->

                            <span
                                class="
                                    px-3
                                    py-1
                                    rounded-full
                                    text-xs
                                    font-medium
                                    {{ $bidangLabel['class'] }}
                                "
                            >
                                {{ $bidangLabel['label'] }}
                            </span>

                        </div>


                        <!-- NAME -->

                        <h3
                            class="
                                mentor-name
                                text-lg
                                font-semibold
                                mb-1
                            "
                        >
                            {{ $nama }}
                        </h3>


                        <!-- SKILL -->

                        <p
                            class="
                                mentor-skill
                                text-sm
                                font-medium
                                mb-3
                            "
                        >
                            {{ $keahlian }}
                        </p>


                        <!-- EXPERIENCE -->

                        <div
                            class="
                                mentor-experience
                                flex
                                items-center
                                text-sm
                                mb-4
                            "
                        >

                            <svg
                                class="w-4 h-4 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="
                                        M12 8v4l3 3
                                        m6-3a9 9 0 11-18 0
                                        9 9 0 0118 0z
                                    "
                                />

                            </svg>

                            @if(!empty($mentor->pengalaman))
                                Pengalaman {{ $mentor->pengalaman }}
                            @elseif(!empty($mentor->lama_pengalaman))
                                Pengalaman {{ $mentor->lama_pengalaman }}
                            @else
                                Mentor Profesional
                            @endif

                        </div>


                        <!-- BUTTON -->

                        <a
                            href="{{ route('mentor.show', $mentor->id_mentor) }}"
                            class="
                                mentor-button
                                w-full
                                py-2.5
                                text-white
                                rounded-xl
                                font-medium
                                block
                                text-center
                            "
                        >

                            <span class="relative z-10">
                                Lihat Profil
                            </span>

                        </a>

                    </div>

                @empty

                    <div class="col-span-full text-center py-16">

                        <svg
                            class="w-16 h-16 mx-auto text-[#9edce1] mb-4"
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
                                text-[#31566a]
                                mb-2
                            "
                        >
                            Belum ada mentor
                        </h3>

                        <p class="text-[#78909c]">
                            Data mentor belum tersedia.
                        </p>

                    </div>

                @endforelse

            </div>


            <!-- =========================================================
                PAGINATION
            ========================================================= -->

            @if($mentors->hasPages())

                <div class="mt-10">
                    {{ $mentors->links() }}
                </div>

            @endif


            <!-- =========================================================
                EMPTY SEARCH STATE
            ========================================================= -->

            <div
                id="empty-state"
                class="hidden text-center py-16"
            >

                <svg
                    class="w-16 h-16 mx-auto text-[#9edce1] mb-4"
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
                        text-[#31566a]
                        mb-2
                    "
                >
                    Mentor tidak ditemukan
                </h3>

                <p class="text-[#78909c]">
                    Coba ubah kata kunci pencarian atau filter bidang.
                </p>

            </div>


            @endsection


            @section('scripts')

            <script>

            document.addEventListener('DOMContentLoaded', function () {

                const searchInput =
                    document.getElementById('search-input');

                const filterSelect =
                    document.getElementById('filter-select');

                const mentorList =
                    document.getElementById('mentor-list');

                const emptyState =
                    document.getElementById('empty-state');


                function filterMentors() {

                    const keyword =
                        searchInput.value
                            .toLowerCase()
                            .trim();

                    const bidang =
                        filterSelect.value;


                    const cards =
                        mentorList.querySelectorAll(
                            '.mentor-card'
                        );


                    let visible = 0;


                    cards.forEach(function(card) {

                        const nama =
                            card.dataset.nama || '';

                        const keahlian =
                            card.dataset.keahlian || '';

                        const cardBidang =
                            card.dataset.bidang || '';


                        const cocokKeyword =
                            nama.includes(keyword)
                            ||
                            keahlian.includes(keyword);


                        const cocokBidang =
                            bidang === 'semua'
                            ||
                            cardBidang === bidang;


                        if (
                            cocokKeyword &&
                            cocokBidang
                        ) {

                            card.style.display = '';

                            visible++;

                        } else {

                            card.style.display = 'none';
                        }

                    });


                    if (visible === 0) {

                        emptyState.classList.remove(
                            'hidden'
                        );

                    } else {

                        emptyState.classList.add(
                            'hidden'
                        );
                    }
                }


                if (searchInput) {

                    searchInput.addEventListener(
                        'input',
                        filterMentors
                    );

                }


                if (filterSelect) {

                    filterSelect.addEventListener(
                        'change',
                        filterMentors
                    );

                }

            });

            </script>

            @endsection


@section('scripts')

<script>

    /* =========================================================
       DATA MENTOR
    ========================================================= */

    const mentors = [

        {
            nama: 'Dr. Andi Wijaya',
            bidang: 'teknologi',
            keahlian: 'AI & Machine Learning',
            pengalaman: '15 tahun',
            avatar: 'AW'
        },

        {
            nama: 'Rina Kusuma, MBA',
            bidang: 'bisnis',
            keahlian: 'Strategi Bisnis',
            pengalaman: '12 tahun',
            avatar: 'RK'
        },

        {
            nama: 'Budi Santoso',
            bidang: 'teknologi',
            keahlian: 'Software Engineering',
            pengalaman: '10 tahun',
            avatar: 'BS'
        },

        {
            nama: 'Siti Rahayu',
            bidang: 'desain',
            keahlian: 'UI/UX Design',
            pengalaman: '8 tahun',
            avatar: 'SR'
        },

        {
            nama: 'Prof. Joko Susilo',
            bidang: 'pendidikan',
            keahlian: 'Metodologi Pengajaran',
            pengalaman: '20 tahun',
            avatar: 'JS'
        },

        {
            nama: 'Maya Anggraini',
            bidang: 'bisnis',
            keahlian: 'Marketing & Branding',
            pengalaman: '9 tahun',
            avatar: 'MA'
        },

        {
            nama: 'David Pratama',
            bidang: 'teknologi',
            keahlian: 'Cloud & DevOps',
            pengalaman: '11 tahun',
            avatar: 'DP'
        },

        {
            nama: 'Lestari Dewi',
            bidang: 'desain',
            keahlian: 'Motion & Animation',
            pengalaman: '7 tahun',
            avatar: 'LD'
        },

        {
            nama: 'Hendra Gunawan',
            bidang: 'pendidikan',
            keahlian: 'Kurikulum & Training',
            pengalaman: '13 tahun',
            avatar: 'HG'
        }

    ];


    /* =========================================================
       LABEL BIDANG
    ========================================================= */

    const bidangLabel = {

        teknologi: {
            label: 'Teknologi',
            color: 'badge-teknologi'
        },

        bisnis: {
            label: 'Bisnis',
            color: 'badge-bisnis'
        },

        desain: {
            label: 'Desain',
            color: 'badge-desain'
        },

        pendidikan: {
            label: 'Pendidikan',
            color: 'badge-pendidikan'
        }

    };


    /* =========================================================
       ELEMENT
    ========================================================= */

    const searchInput =
        document.getElementById('search-input');

    const filterSelect =
        document.getElementById('filter-select');

    const mentorList =
        document.getElementById('mentor-list');

    const emptyState =
        document.getElementById('empty-state');


    /* =========================================================
       RENDER MENTOR
    ========================================================= */

    function renderMentors() {

        const keyword =
            searchInput.value.toLowerCase();

        const bidang =
            filterSelect.value;


        const filtered =
            mentors.filter(m => {

                const matchKeyword =
                    m.nama
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    m.keahlian
                        .toLowerCase()
                        .includes(keyword);


                const matchBidang =
                    bidang === 'semua' ||
                    m.bidang === bidang;


                return matchKeyword && matchBidang;

            });


        /* Empty state */

        emptyState.classList.toggle(
            'hidden',
            filtered.length > 0
        );


        /* =====================================================
           RENDER CARD
        ====================================================== */

        mentorList.innerHTML = filtered
            .map((m, index) => {

                const b =
                    bidangLabel[m.bidang];


                return `

                    <div
                        class="mentor-card"
                        style="animation-delay: ${index * 0.07}s"
                    >

                        <!-- TOP -->

                        <div
                            class="flex items-start justify-between mb-4"
                        >


                            <!-- AVATAR -->

                            <div
                                class="
                                    mentor-avatar
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

                                ${m.avatar}

                            </div>


                            <!-- BADGE -->

                            <span
                                class="
                                    px-3
                                    py-1
                                    rounded-full
                                    text-xs
                                    font-medium
                                    ${b.color}
                                "
                            >

                                ${b.label}

                            </span>

                        </div>


                        <!-- NAME -->

                        <h3
                            class="
                                mentor-name
                                text-lg
                                font-semibold
                                mb-1
                            "
                        >

                            ${m.nama}

                        </h3>


                        <!-- SKILL -->

                        <p
                            class="
                                mentor-skill
                                text-sm
                                font-medium
                                mb-3
                            "
                        >

                            ${m.keahlian}

                        </p>


                        <!-- EXPERIENCE -->

                        <div
                            class="
                                mentor-experience
                                flex
                                items-center
                                text-sm
                                mb-4
                            "
                        >

                            <svg
                                class="w-4 h-4 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />

                            </svg>

                            Pengalaman ${m.pengalaman}

                        </div>


                        <!-- BUTTON -->

                        <button
                            class="
                                mentor-button
                                w-full
                                py-2.5
                                text-white
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
        renderMentors
    );


    /* =========================================================
       FILTER EVENT
    ========================================================= */

    filterSelect.addEventListener(
        'change',
        renderMentors
    );


    /* =========================================================
       INITIAL RENDER
    ========================================================= */

    renderMentors();

</script>

@endsection