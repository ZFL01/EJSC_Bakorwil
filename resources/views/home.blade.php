@extends('layouts.app')

@section('title', 'EJSC Bakorwil - Platform Mentor, Talenta & Client')

@section('content')

<!-- ============================================ -->
<!-- GIS MAP SECTION (Full-Width, Top of Landing) -->
<!-- ============================================ -->
<section id="gis-section" class="relative w-full bg-[#0e4f81]">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Map Header Bar -->
    <div class="absolute top-0 left-0 right-0 z-20 bg-gradient-to-r from-sky-200 via-cyan-200 to-slate-100 text-slate-900 px-6 py-4 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl lg:text-2xl font-bold">Peta Wilayah Bakorwil</h1>
                <p class="text-sm text-slate-700">Sistem Informasi Geografis 7 Daerah Tapal Kuda - Jawa Timur</p>
            </div>
            <span class="hidden sm:inline-flex items-center px-3 py-1 bg-yellow-400 text-teal-900 text-xs font-bold rounded-full">
                <span class="w-2 h-2 bg-teal-700 rounded-full mr-2 animate-pulse"></span>
                QGIS Map
            </span>
        </div>
    </div>

    <!-- Leaflet Map Container (full width, large height) -->
    <div id="qgis-map" class="w-full relative z-0" style="height: 80vh; background: linear-gradient(180deg, #0d4f7a 0%, #4ba3e1 100%);"></div>

<!-- Placeholder Overlay (shown until GeoJSON data is loaded) -->
    <div id="gis-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 text-slate-900" style="background: linear-gradient(135deg, rgba(173,216,230,0.96), rgba(199,229,255,0.96)); z-index: 10;">
        <div class="w-20 h-20 bg-white/15 border border-yellow-400/50 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 mb-3">Tempat Peta QGIS</h2>
        <p class="text-slate-700 max-w-xl mb-6 leading-relaxed">
            Area ini disiapkan untuk menampilkan peta interaktif hasil QGIS.
            Unggah file <span class="font-mono text-yellow-300">GeoJSON</span> hasil ekspor QGIS ke
            <span class="font-mono text-yellow-300">public/maps/bakorwil.geojson</span>
            untuk menampilkan 7 daerah Tapal Kuda secara interaktif.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
            <button onclick="loadQGISData()" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-teal-900 font-bold rounded-lg transition shadow-lg">
                Muat Data Peta
            </button>
            <a href="#after-gis" class="px-6 py-3 bg-white border border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition">
                Lihat Layanan
            </a>
        </div>
    </div>

    <!-- Map Info Panel (populated on region click) -->
    <div id="qgis-info" class="absolute bottom-4 left-4 right-4 md:right-auto md:max-w-sm bg-white/95 backdrop-blur rounded-xl shadow-xl border border-teal-200 p-4 hidden" style="z-index: 20;">
        <div class="flex items-start justify-between">
            <div>
                <h3 id="qgis-info-name" class="text-lg font-bold text-teal-900"></h3>
                <p id="qgis-info-type" class="text-sm font-medium text-teal-600 mb-1"></p>
                <p id="qgis-info-desc" class="text-sm text-gray-600"></p>
            </div>
            <button onclick="document.getElementById('qgis-info').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Anchor so the hero follows the full-width map -->
<a id="after-gis" class="block"></a>

<!-- =========================================================
     HERO SECTION EJSC BAKORWIL
========================================================= -->

<section class="ejsc-hero">

    <!-- BACKGROUND -->
    <div class="ejsc-bg-shape ejsc-bg-shape-1"></div>
    <div class="ejsc-bg-shape ejsc-bg-shape-2"></div>
    <div class="ejsc-bg-shape ejsc-bg-shape-3"></div>

    <div class="ejsc-floating-dot ejsc-dot-1"></div>
    <div class="ejsc-floating-dot ejsc-dot-2"></div>
    <div class="ejsc-floating-dot ejsc-dot-3"></div>
    <div class="ejsc-floating-dot ejsc-dot-4"></div>
    <div class="ejsc-floating-dot ejsc-dot-5"></div>


    <!-- =====================================================
         MAIN HERO
    ====================================================== -->

    <div class="ejsc-hero-container">

        <!-- LEFT -->
        <div class="ejsc-hero-left">

            <!-- BADGE -->
            <div class="ejsc-badge">
                <span class="ejsc-badge-star">✦</span>
                <span>Platform Resmi EJSC Bakorwil</span>
            </div>


            <!-- TITLE -->
            <h1 class="ejsc-title">
                Menghubungkan
                <span>Mentor, Talenta &amp;</span>
                Client
            </h1>


            <!-- DESCRIPTION -->
            <p class="ejsc-description">
                Platform terpercaya untuk menemukan mentor berpengalaman,
                mengembangkan talenta terbaik, dan menghubungkan dengan
                client yang tepat.
            </p>


            <!-- BUTTON -->
            <div class="ejsc-buttons">

                <a href="{{ route('mentor') }}"
                   class="ejsc-btn-primary">

                    <span>Cari Mentor</span>

                    <svg viewBox="0 0 24 24">
                        <path
                            d="M5 12h13M13 6l6 6-6 6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                </a>


                <a href="{{ route('talenta') }}"
                   class="ejsc-btn-secondary">

                    Lihat Talenta

                </a>

            </div>

        </div>


        <!-- =================================================
             RIGHT
        ================================================== -->

        <div class="ejsc-hero-right">


            <!-- STAT CARD -->
            <div class="ejsc-stat-card">

                <div class="ejsc-stat-header">

                    <h3>Statistik Platform</h3>

                    <span class="ejsc-live">
                        <span></span>
                        Live update
                    </span>

                </div>


                <div class="ejsc-stat-grid">


                    <!-- MENTOR -->
                    <div class="ejsc-stat-box">

                        <div class="ejsc-stat-icon">

                            <svg viewBox="0 0 24 24">

                                <path
                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="ejsc-stat-number">
                                150+
                            </div>

                            <div class="ejsc-stat-label">
                                Mentor
                            </div>

                        </div>

                    </div>


                    <!-- TALENTA -->
                    <div class="ejsc-stat-box">

                        <div class="ejsc-stat-icon">

                            <svg viewBox="0 0 24 24">

                                <circle
                                    cx="12"
                                    cy="8"
                                    r="4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M4 21a8 8 0 0 1 16 0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="ejsc-stat-number">
                                500+
                            </div>

                            <div class="ejsc-stat-label">
                                Talenta
                            </div>

                        </div>

                    </div>


                    <!-- CLIENT -->
                    <div class="ejsc-stat-box">

                        <div class="ejsc-stat-icon">

                            <svg viewBox="0 0 24 24">

                                <rect
                                    x="3"
                                    y="7"
                                    width="18"
                                    height="13"
                                    rx="2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M3 12h18M10 12v2h4v-2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="ejsc-stat-number">
                                80+
                            </div>

                            <div class="ejsc-stat-label">
                                Client
                            </div>

                        </div>

                    </div>


                    <!-- KEPUASAN -->
                    <div class="ejsc-stat-box">

                        <div class="ejsc-stat-icon">

                            <svg viewBox="0 0 24 24">

                                <path
                                    d="M3 17l6-6 4 4 7-8"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M15 7h5v5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <div class="ejsc-stat-number">
                                98%
                            </div>

                            <div class="ejsc-stat-label">
                                Kepuasan
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 ILLUSTRATION
            ================================================== -->

            <div class="ejsc-illustration">

                <div class="ejsc-illustration-glow"></div>


                <!-- BOOKS -->
                <div class="ejsc-books">

                    <div class="ejsc-book book-1"></div>
                    <div class="ejsc-book book-2"></div>
                    <div class="ejsc-book book-3"></div>

                </div>


                <!-- PLANT -->
                <div class="ejsc-plant">

                    <div class="ejsc-leaf leaf-1"></div>
                    <div class="ejsc-leaf leaf-2"></div>
                    <div class="ejsc-leaf leaf-3"></div>
                    <div class="ejsc-leaf leaf-4"></div>

                    <div class="ejsc-stem"></div>

                    <div class="ejsc-pot"></div>

                </div>


                <!-- LAPTOP -->
                <div class="ejsc-laptop">

                    <div class="ejsc-screen">

                        <div class="ejsc-screen-logo">
                            EJSC
                        </div>

                        <div class="ejsc-screen-line"></div>
                        <div class="ejsc-screen-line small"></div>

                        <div class="ejsc-chart">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>


                    <div class="ejsc-laptop-base">

                        <div class="ejsc-trackpad"></div>

                    </div>

                </div>


                <!-- ARROW -->
                <svg
                    class="ejsc-curved-arrow"
                    viewBox="0 0 300 190"
                    fill="none"
                >

                    <path
                        d="M30 150
                           C120 170,
                           210 130,
                           195 70
                           C190 45,
                           215 28,
                           260 35"
                        stroke="#51AEB8"
                        stroke-width="8"
                        stroke-linecap="round"
                    />

                    <path
                        d="M250 22L272 35L252 53"
                        stroke="#51AEB8"
                        stroke-width="8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FEATURE BAR
    ====================================================== -->

    <div class="ejsc-feature-wrapper">

        <div class="ejsc-feature-bar">


            <!-- 1 -->
            <div class="ejsc-feature">

                <div class="ejsc-feature-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M12 3l8 3v5c0 5-3.4 8.8-8 10-4.6-1.2-8-5-8-10V6l8-3z"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M9 12l2 2 4-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>

                <div>

                    <h4>Terpercaya</h4>

                    <p>
                        Sistem aman dan terpercaya
                        dengan verifikasi ketat.
                    </p>

                </div>

            </div>


            <!-- 2 -->
            <div class="ejsc-feature">

                <div class="ejsc-feature-icon">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="9"
                            cy="8"
                            r="3"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M3 20a6 6 0 0 1 12 0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M16 11a3 3 0 1 0 0-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                    </svg>

                </div>

                <div>

                    <h4>Berkualitas</h4>

                    <p>
                        Mentor &amp; talenta terbaik
                        di bidangnya.
                    </p>

                </div>

            </div>


            <!-- 3 -->
            <div class="ejsc-feature">

                <div class="ejsc-feature-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M13 2L4 14h6l-1 8 9-12h-6l1-8z"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>

                <div>

                    <h4>Mudah Digunakan</h4>

                    <p>
                        Antarmuka sederhana dan
                        pengalaman terbaik.
                    </p>

                </div>

            </div>


            <!-- 4 -->
            <div class="ejsc-feature">

                <div class="ejsc-feature-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M5 20V10"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="M12 20V5"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="M19 20v-8"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>

                <div>

                    <h4>Data Akurat</h4>

                    <p>
                        Informasi real-time untuk
                        keputusan terbaik.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     CSS
========================================================= -->

<style>

.ejsc-hero,
.ejsc-hero * {
    box-sizing: border-box;
}


/* =========================================================
   MAIN
========================================================= */

.ejsc-hero {

    position: relative;

    width: 100%;

    min-height: 920px;

    overflow: hidden;

    color: #14263b;

    background:

        radial-gradient(
            circle at 8% 20%,
            rgba(120,205,214,.60),
            transparent 28%
        ),

        radial-gradient(
            circle at 90% 65%,
            rgba(133,213,220,.52),
            transparent 30%
        ),

        radial-gradient(
            circle at 55% 100%,
            rgba(176,226,230,.38),
            transparent 35%
        ),

        linear-gradient(
            135deg,
            #eaf8f9 0%,
            #ffffff 45%,
            #edf9fa 100%
        );
}


/* =========================================================
   BACKGROUND SHAPES
========================================================= */

.ejsc-bg-shape {

    position: absolute;

    pointer-events: none;

    will-change: transform;
}


.ejsc-bg-shape-1 {

    width: 470px;
    height: 330px;

    top: -170px;
    left: -110px;

    border-radius: 50%;

    background:
        rgba(103,197,207,.48);

    filter: blur(1px);

    animation:
        ejscBlobOne 7s ease-in-out infinite;
}


.ejsc-bg-shape-2 {

    width: 530px;
    height: 310px;

    right: -230px;
    bottom: -120px;

    border-radius: 50%;

    background:
        rgba(103,198,208,.34);

    animation:
        ejscBlobTwo 8s ease-in-out infinite;
}


.ejsc-bg-shape-3 {

    width: 260px;
    height: 260px;

    right: -90px;
    top: 190px;

    border-radius: 50%;

    background:
        rgba(179,228,232,.52);

    animation:
        ejscBlobThree 6s ease-in-out infinite;
}


@keyframes ejscBlobOne {

    0%,
    100% {
        transform:
            translate3d(0,0,0)
            rotate(0deg)
            scale(1);
    }

    30% {
        transform:
            translate3d(35px,25px,0)
            rotate(5deg)
            scale(1.05);
    }

    60% {
        transform:
            translate3d(-15px,55px,0)
            rotate(-4deg)
            scale(.96);
    }

    80% {
        transform:
            translate3d(25px,15px,0)
            rotate(3deg)
            scale(1.03);
    }
}


@keyframes ejscBlobTwo {

    0%,
    100% {
        transform:
            translate3d(0,0,0)
            scale(1);
    }

    35% {
        transform:
            translate3d(-45px,-25px,0)
            scale(1.08);
    }

    70% {
        transform:
            translate3d(20px,-50px,0)
            scale(.94);
    }
}


@keyframes ejscBlobThree {

    0%,
    100% {
        transform:
            translate3d(0,0,0)
            rotate(0deg);
    }

    50% {
        transform:
            translate3d(-35px,35px,0)
            rotate(15deg);
    }
}


/* =========================================================
   FLOATING DOTS
========================================================= */

.ejsc-floating-dot {

    position: absolute;

    border-radius: 50%;

    background:
        #50acb6;

    box-shadow:
        0 0 0 5px rgba(80,172,182,.08),
        0 0 18px rgba(80,172,182,.18);

    pointer-events: none;

    will-change: transform;
}


.ejsc-dot-1 {
    width: 9px;
    height: 9px;
    left: 42%;
    top: 13%;

    animation:
        ejscDot1 4.5s ease-in-out infinite;
}


.ejsc-dot-2 {
    width: 14px;
    height: 14px;
    left: 47%;
    top: 42%;

    animation:
        ejscDot2 5.5s ease-in-out infinite;
}


.ejsc-dot-3 {
    width: 10px;
    height: 10px;
    right: 13%;
    top: 27%;

    animation:
        ejscDot3 4s ease-in-out infinite;
}


.ejsc-dot-4 {
    width: 13px;
    height: 13px;
    right: 8%;
    bottom: 29%;

    animation:
        ejscDot4 6s ease-in-out infinite;
}


.ejsc-dot-5 {
    width: 12px;
    height: 12px;
    left: 5%;
    bottom: 28%;

    animation:
        ejscDot5 5s ease-in-out infinite;
}


@keyframes ejscDot1 {

    0%,100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(0,-35px)
            scale(1.35);
    }
}


@keyframes ejscDot2 {

    0%,100% {
        transform:
            translate(0,0)
            scale(1);
    }

    40% {
        transform:
            translate(28px,-22px)
            scale(1.2);
    }

    70% {
        transform:
            translate(-15px,-42px)
            scale(.85);
    }
}


@keyframes ejscDot3 {

    0%,100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-25px,35px)
            scale(1.3);
    }
}


@keyframes ejscDot4 {

    0%,100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-30px,-38px)
            scale(1.3);
    }
}


@keyframes ejscDot5 {

    0%,100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(25px,-28px)
            scale(1.25);
    }
}


/* =========================================================
   CONTAINER
========================================================= */

.ejsc-hero-container {

    position: relative;

    z-index: 5;

    width:
        min(
            1180px,
            calc(100% - 60px)
        );

    min-height: 700px;

    margin: auto;

    padding-top: 115px;

    padding-bottom: 270px;

    display: grid;

    grid-template-columns:
        minmax(0,1fr)
        minmax(0,1fr);

    gap: 55px;

    align-items: center;
}


/* =========================================================
   LEFT MOTION
========================================================= */

.ejsc-hero-left {

    animation:
        ejscLeftMotion 5s ease-in-out infinite;

    will-change:
        transform;
}


@keyframes ejscLeftMotion {

    0%,
    100% {
        transform:
            translateY(0);
    }

    35% {
        transform:
            translateY(-7px);
    }

    70% {
        transform:
            translateY(3px);
    }
}


/* =========================================================
   BADGE
========================================================= */

.ejsc-badge {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding:
        9px 17px;

    margin-bottom: 27px;

    border:
        1px solid
        rgba(60,166,178,.30);

    border-radius: 999px;

    background:
        rgba(215,242,244,.82);

    color: #183043;

    font-size: 13px;

    font-weight: 600;

    box-shadow:
        0 8px 20px
        rgba(55,160,172,.08);

    animation:
        ejscBadgeMotion 3.2s ease-in-out infinite;
}


@keyframes ejscBadgeMotion {

    0%,100% {
        transform:
            translateY(0)
            scale(1);
    }

    50% {
        transform:
            translateY(-6px)
            scale(1.015);
    }
}


.ejsc-badge-star {

    color:
        #2999a5;

    font-size: 17px;

    animation:
        ejscStarMotion 2s ease-in-out infinite;
}


@keyframes ejscStarMotion {

    0%,100% {
        transform:
            rotate(0deg)
            scale(1);
    }

    50% {
        transform:
            rotate(25deg)
            scale(1.3);
    }
}


/* =========================================================
   TITLE
========================================================= */

.ejsc-title {

    margin:
        0 0 27px;

    max-width: 650px;

    font-family:
        "Inter",
        Arial,
        sans-serif;

    font-size:
        clamp(
            48px,
            5.1vw,
            72px
        );

    line-height: 1.04;

    letter-spacing: -3px;

    font-weight: 800;

    animation:
        ejscTitleMotion 4.5s ease-in-out infinite;
}


@keyframes ejscTitleMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-6px);
    }
}


.ejsc-title span {

    display: block;

    color: #3198a4;

    background:
        linear-gradient(
            90deg,
            #258f9c,
            #58b9c2,
            #258f9c,
            #70c8cf
        );

    background-size: 300% auto;

    -webkit-background-clip: text;

    background-clip: text;

    -webkit-text-fill-color: transparent;

    animation:
        ejscTextGradient 3.5s linear infinite;
}


@keyframes ejscTextGradient {

    0% {
        background-position:
            0% center;
    }

    100% {
        background-position:
            300% center;
    }
}


/* =========================================================
   DESCRIPTION
========================================================= */

.ejsc-description {

    max-width: 610px;

    margin:
        0 0 31px;

    color: #4e667d;

    font-size: 17px;

    line-height: 1.8;
}


/* =========================================================
   BUTTONS
========================================================= */

.ejsc-buttons {

    display: flex;

    align-items: center;

    gap: 13px;

    flex-wrap: wrap;
}


.ejsc-btn-primary,
.ejsc-btn-secondary {

    min-width: 158px;

    height: 53px;

    padding:
        0 21px;

    border-radius: 11px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    font-size: 14px;

    font-weight: 700;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}


.ejsc-btn-primary {

    gap: 12px;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #56b8c2,
            #369ca8
        );

    box-shadow:
        0 12px 28px
        rgba(55,161,172,.28);

    animation:
        ejscButtonMotion 2.8s ease-in-out infinite;
}


@keyframes ejscButtonMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-7px);
    }
}


.ejsc-btn-primary:hover {

    transform:
        translateY(-9px)
        scale(1.04);

    box-shadow:
        0 20px 40px
        rgba(55,161,172,.38);
}


.ejsc-btn-primary svg {

    width: 20px;
    height: 20px;

    animation:
        ejscArrowButton 1.8s ease-in-out infinite;
}


@keyframes ejscArrowButton {

    0%,100% {
        transform:
            translateX(0);
    }

    50% {
        transform:
            translateX(7px);
    }
}


.ejsc-btn-secondary {

    color: #1c3348;

    background:
        rgba(255,255,255,.88);

    border:
        1px solid
        #cfe2e5;

    animation:
        ejscSecondaryMotion 3.5s ease-in-out infinite;
}


@keyframes ejscSecondaryMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-4px);
    }
}


.ejsc-btn-secondary:hover {

    transform:
        translateY(-7px);

    background:
        #ffffff;

    border-color:
        #8bcbd1;

    box-shadow:
        0 14px 28px
        rgba(50,140,151,.12);
}


/* =========================================================
   RIGHT
========================================================= */

.ejsc-hero-right {

    position: relative;

    min-height: 590px;

    display: flex;

    justify-content: flex-end;

    align-items: flex-start;

    animation:
        ejscRightMotion 6s ease-in-out infinite;

    will-change:
        transform;
}


@keyframes ejscRightMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-10px);
    }
}


/* =========================================================
   STAT CARD
========================================================= */

.ejsc-stat-card {

    position: relative;

    z-index: 10;

    width: 100%;

    max-width: 540px;

    padding: 29px;

    border:
        1px solid
        rgba(205,228,232,.95);

    border-radius: 27px;

    background:
        rgba(255,255,255,.94);

    backdrop-filter:
        blur(20px);

    box-shadow:
        0 30px 65px
        rgba(36,83,107,.13);

    animation:
        ejscCardMotion 4.5s ease-in-out infinite;

    will-change:
        transform;
}


@keyframes ejscCardMotion {

    0%,100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    35% {
        transform:
            translateY(-9px)
            rotate(.3deg);
    }

    70% {
        transform:
            translateY(3px)
            rotate(-.25deg);
    }
}


.ejsc-stat-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 22px;
}


.ejsc-stat-header h3 {

    margin: 0;

    color: #172a40;

    font-size: 17px;

    font-weight: 700;
}


.ejsc-live {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: #41657a;

    font-size: 12px;
}


.ejsc-live span {

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #42a9b4;

    box-shadow:
        0 0 10px
        rgba(66,169,180,.65);

    animation:
        ejscLiveMotion 1.2s ease-in-out infinite;
}


@keyframes ejscLiveMotion {

    0%,100% {
        transform:
            scale(1);

        box-shadow:
            0 0 0 3px
            rgba(66,169,180,.12),
            0 0 10px
            rgba(66,169,180,.30);
    }

    50% {
        transform:
            scale(1.55);

        box-shadow:
            0 0 0 8px
            rgba(66,169,180,.04),
            0 0 18px
            rgba(66,169,180,.55);
    }
}


/* =========================================================
   STAT GRID
========================================================= */

.ejsc-stat-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 14px;
}


.ejsc-stat-box {

    min-height: 128px;

    padding: 19px;

    display: flex;

    align-items: center;

    gap: 15px;

    border:
        1px solid
        #e3eef0;

    border-radius: 18px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.98),
            rgba(241,250,251,.90)
        );

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;

    will-change:
        transform;
}


.ejsc-stat-box:nth-child(1) {

    animation:
        ejscStatOne 3.5s ease-in-out infinite;
}


.ejsc-stat-box:nth-child(2) {

    animation:
        ejscStatTwo 4s ease-in-out infinite;
}


.ejsc-stat-box:nth-child(3) {

    animation:
        ejscStatThree 4.5s ease-in-out infinite;
}


.ejsc-stat-box:nth-child(4) {

    animation:
        ejscStatFour 3.8s ease-in-out infinite;
}


@keyframes ejscStatOne {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-8px);
    }
}


@keyframes ejscStatTwo {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(7px);
    }
}


@keyframes ejscStatThree {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-6px);
    }
}


@keyframes ejscStatFour {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(8px);
    }
}


.ejsc-stat-box:hover {

    transform:
        translateY(-10px)
        scale(1.03) !important;

    border-color:
        rgba(77,175,185,.40);

    box-shadow:
        0 18px 35px
        rgba(44,116,132,.13);
}


/* =========================================================
   STAT ICON
========================================================= */

.ejsc-stat-icon {

    flex:
        0 0 55px;

    width: 55px;
    height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 16px;

    color: #46a9b4;

    background:
        linear-gradient(
            145deg,
            #d9f3f5,
            #f1fafb
        );

    box-shadow:
        inset 0 0 0 1px
        rgba(72,173,183,.08);

    animation:
        ejscIconMotion 2.8s ease-in-out infinite;
}


@keyframes ejscIconMotion {

    0%,100% {
        transform:
            rotate(0deg)
            scale(1);
    }

    50% {
        transform:
            rotate(5deg)
            scale(1.09);
    }
}


.ejsc-stat-icon svg {

    width: 28px;
    height: 28px;
}


.ejsc-stat-number {

    margin-bottom: 7px;

    color: #172a40;

    font-size: 27px;

    line-height: 1;

    font-weight: 800;

    animation:
        ejscNumberMotion 2.5s ease-in-out infinite;
}


@keyframes ejscNumberMotion {

    0%,100% {
        transform:
            scale(1);

        color:
            #172a40;
    }

    50% {
        transform:
            scale(1.05);

        color:
            #278f9c;
    }
}


.ejsc-stat-label {

    color: #526a80;

    font-size: 13px;
}


/* =========================================================
   ILLUSTRATION
========================================================= */

.ejsc-illustration {

    position: absolute;

    z-index: 4;

    width: 470px;

    height: 285px;

    right: -5px;

    bottom: -55px;

    pointer-events: none;
}


.ejsc-illustration-glow {

    position: absolute;

    right: 5px;

    bottom: 0;

    width: 410px;

    height: 110px;

    border-radius: 50%;

    background:
        rgba(86,194,204,.32);

    filter:
        blur(20px);

    animation:
        ejscGlowMotion 3.5s ease-in-out infinite;
}


@keyframes ejscGlowMotion {

    0%,100% {
        transform:
            scale(1);

        opacity:
            .55;
    }

    50% {
        transform:
            scale(1.18);

        opacity:
            .95;
    }
}


/* =========================================================
   LAPTOP
========================================================= */

.ejsc-laptop {

    position: absolute;

    right: 85px;

    bottom: 5px;

    width: 245px;

    height: 165px;

    animation:
        ejscLaptopMotion 3.8s ease-in-out infinite;

    will-change:
        transform;
}


@keyframes ejscLaptopMotion {

    0%,100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    25% {
        transform:
            translateY(-7px)
            rotate(-1deg);
    }

    50% {
        transform:
            translateY(-15px)
            rotate(-1.5deg);
    }

    75% {
        transform:
            translateY(-6px)
            rotate(-.5deg);
    }
}


/* =========================================================
   SCREEN
========================================================= */

.ejsc-screen {

    position: absolute;

    left: 20px;

    top: 0;

    width: 205px;

    height: 128px;

    padding: 7px;

    border:
        7px solid
        #f7fbfc;

    border-radius:
        14px
        14px
        6px
        6px;

    background:
        linear-gradient(
            135deg,
            #73cbd0,
            #40a5b1
        );

    box-shadow:
        0 14px 30px
        rgba(51,140,153,.24);
}


.ejsc-screen-logo {

    margin: 8px;

    color: #ffffff;

    font-size: 13px;

    font-weight: 800;

    animation:
        ejscLogoMotion 2s ease-in-out infinite;
}


@keyframes ejscLogoMotion {

    0%,100% {
        opacity:
            1;

        transform:
            translateX(0);
    }

    50% {
        opacity:
            .65;

        transform:
            translateX(4px);
    }
}


.ejsc-screen-line {

    width: 50px;

    height: 4px;

    margin:
        5px 8px;

    border-radius: 99px;

    background:
        rgba(255,255,255,.70);
}


.ejsc-screen-line.small {

    width: 32px;

    opacity: .55;
}


/* =========================================================
   CHART
========================================================= */

.ejsc-chart {

    position: absolute;

    right: 14px;

    bottom: 13px;

    width: 64px;

    height: 45px;

    display: flex;

    align-items: flex-end;

    gap: 4px;
}


.ejsc-chart span {

    display: block;

    width: 9px;

    border-radius:
        3px 3px 0 0;

    background:
        rgba(255,255,255,.88);

    transform-origin:
        bottom;

    animation:
        ejscChartMotion 1.7s ease-in-out infinite;
}


.ejsc-chart span:nth-child(1) {
    height: 15px;
}


.ejsc-chart span:nth-child(2) {
    height: 24px;
    animation-delay: .2s;
}


.ejsc-chart span:nth-child(3) {
    height: 32px;
    animation-delay: .4s;
}


.ejsc-chart span:nth-child(4) {
    height: 41px;
    animation-delay: .6s;
}


@keyframes ejscChartMotion {

    0%,100% {
        transform:
            scaleY(.65);
    }

    50% {
        transform:
            scaleY(1.05);
    }
}


/* =========================================================
   LAPTOP BASE
========================================================= */

.ejsc-laptop-base {

    position: absolute;

    left: 0;

    bottom: 0;

    width: 245px;

    height: 27px;

    border-radius:
        4px
        4px
        21px
        21px;

    background:
        linear-gradient(
            180deg,
            #ffffff,
            #d8ebed
        );

    box-shadow:
        0 10px 18px
        rgba(45,117,132,.16);
}


.ejsc-trackpad {

    position: absolute;

    left: 97px;

    bottom: 8px;

    width: 50px;

    height: 8px;

    border-radius: 5px;

    background:
        #c4dfe2;
}


/* =========================================================
   PLANT
========================================================= */

.ejsc-plant {

    position: absolute;

    left: 15px;

    bottom: 5px;

    width: 115px;

    height: 160px;

    transform-origin:
        bottom center;

    animation:
        ejscPlantMotion 3.8s ease-in-out infinite;
}


@keyframes ejscPlantMotion {

    0%,100% {
        transform:
            rotate(0deg);
    }

    25% {
        transform:
            rotate(3deg);
    }

    50% {
        transform:
            rotate(-3.5deg);
    }

    75% {
        transform:
            rotate(2deg);
    }
}


/* =========================================================
   POT
========================================================= */

.ejsc-pot {

    position: absolute;

    left: 35px;

    bottom: 0;

    width: 55px;

    height: 58px;

    border-radius:
        6px 6px 18px 18px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #dceff1
        );

    box-shadow:
        0 10px 18px
        rgba(42,112,126,.12);
}


/* =========================================================
   STEM
========================================================= */

.ejsc-stem {

    position: absolute;

    left: 61px;

    bottom: 48px;

    width: 4px;

    height: 75px;

    border-radius: 99px;

    background:
        #55aeb1;
}


/* =========================================================
   LEAVES
========================================================= */

.ejsc-leaf {

    position: absolute;

    width: 49px;

    height: 25px;

    border-radius:
        100% 0 100% 0;

    background:
        linear-gradient(
            135deg,
            #70cfc4,
            #42a6a2
        );

    transform-origin:
        right bottom;
}


.leaf-1 {

    left: 58px;

    bottom: 105px;

    transform:
        rotate(-42deg);

    animation:
        ejscLeaf1Motion 2.5s ease-in-out infinite;
}


.leaf-2 {

    left: 14px;

    bottom: 92px;

    transform:
        rotate(26deg)
        scale(.88);

    animation:
        ejscLeaf2Motion 3s ease-in-out infinite;
}


.leaf-3 {

    left: 55px;

    bottom: 78px;

    transform:
        rotate(-60deg)
        scale(.76);

    animation:
        ejscLeaf3Motion 2.8s ease-in-out infinite;
}


.leaf-4 {

    left: 25px;

    bottom: 115px;

    transform:
        rotate(10deg)
        scale(.65);

    animation:
        ejscLeaf4Motion 2.2s ease-in-out infinite;
}


@keyframes ejscLeaf1Motion {

    0%,100% {
        transform:
            rotate(-42deg);
    }

    50% {
        transform:
            rotate(-55deg);
    }
}


@keyframes ejscLeaf2Motion {

    0%,100% {
        transform:
            rotate(26deg)
            scale(.88);
    }

    50% {
        transform:
            rotate(14deg)
            scale(.93);
    }
}


@keyframes ejscLeaf3Motion {

    0%,100% {
        transform:
            rotate(-60deg)
            scale(.76);
    }

    50% {
        transform:
            rotate(-48deg)
            scale(.82);
    }
}


@keyframes ejscLeaf4Motion {

    0%,100% {
        transform:
            rotate(10deg)
            scale(.65);
    }

    50% {
        transform:
            rotate(23deg)
            scale(.72);
    }
}


/* =========================================================
   BOOKS
========================================================= */

.ejsc-books {

    position: absolute;

    right: 0;

    bottom: 0;

    width: 125px;

    height: 95px;

    animation:
        ejscBooksMotion 4.2s ease-in-out infinite;
}


@keyframes ejscBooksMotion {

    0%,100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    50% {
        transform:
            translateY(-14px)
            rotate(2deg);
    }
}


.ejsc-book {

    position: absolute;

    right: 0;

    width: 115px;

    height: 23px;

    border-radius: 4px;

    box-shadow:
        0 7px 10px
        rgba(50,120,130,.10);
}


.book-1 {

    bottom: 0;

    background:
        #dceff0;
}


.book-2 {

    bottom: 23px;

    width: 102px;

    right: 8px;

    background:
        #64b9bd;
}


.book-3 {

    bottom: 46px;

    width: 112px;

    right: 2px;

    background:
        #eff8f8;
}


/* =========================================================
   ARROW
========================================================= */

.ejsc-curved-arrow {

    position: absolute;

    z-index: 8;

    right: -5px;

    top: 42px;

    width: 300px;

    overflow: visible;

    animation:
        ejscArrowMotion 3.5s ease-in-out infinite;

    transform-origin:
        center;
}


@keyframes ejscArrowMotion {

    0%,100% {
        transform:
            translateY(0)
            translateX(0)
            rotate(0deg);
    }

    30% {
        transform:
            translateY(-8px)
            translateX(5px)
            rotate(1deg);
    }

    60% {
        transform:
            translateY(5px)
            translateX(-4px)
            rotate(-1deg);
    }
}


/* =========================================================
   FEATURE BAR
========================================================= */

.ejsc-feature-wrapper {

    position: absolute;

    z-index: 20;

    left: 50%;

    bottom: 35px;

    width:
        min(
            1180px,
            calc(100% - 60px)
        );

    transform:
        translateX(-50%);
}


.ejsc-feature-bar {

    width: 100%;

    min-height: 160px;

    padding:
        25px 40px;

    display: grid;

    grid-template-columns:
        repeat(4,1fr);

    align-items: center;

    gap: 30px;

    border:
        1px solid
        rgba(210,231,234,.95);

    border-radius: 28px;

    background:
        rgba(255,255,255,.93);

    backdrop-filter:
        blur(18px);

    box-shadow:
        0 22px 50px
        rgba(36,83,107,.11);

    animation:
        ejscFeatureBarMotion 5s ease-in-out infinite;
}


@keyframes ejscFeatureBarMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-7px);
    }
}


.ejsc-feature {

    min-width: 0;

    display: flex;

    align-items: center;

    gap: 17px;

    transition:
        transform .3s ease;

    animation:
        ejscFeatureMotion 4s ease-in-out infinite;
}


.ejsc-feature:nth-child(1) {
    animation-delay: 0s;
}


.ejsc-feature:nth-child(2) {
    animation-delay: .4s;
}


.ejsc-feature:nth-child(3) {
    animation-delay: .8s;
}


.ejsc-feature:nth-child(4) {
    animation-delay: 1.2s;
}


@keyframes ejscFeatureMotion {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-6px);
    }
}


.ejsc-feature:hover {

    transform:
        translateY(-10px)
        scale(1.02);
}


/* =========================================================
   FEATURE ICON
========================================================= */

.ejsc-feature-icon {

    flex:
        0 0 58px;

    width: 58px;

    height: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    border:
        1px solid
        rgba(71,174,185,.22);

    border-radius: 50%;

    color:
        #42a8b3;

    background:
        linear-gradient(
            145deg,
            #dff5f6,
            #f9fcfc
        );

    box-shadow:
        0 8px 18px
        rgba(62,163,174,.08);

    animation:
        ejscFeatureIconMotion 2.8s ease-in-out infinite;
}


.ejsc-feature:nth-child(2)
.ejsc-feature-icon {

    animation-delay:
        .5s;
}


.ejsc-feature:nth-child(3)
.ejsc-feature-icon {

    animation-delay:
        1s;
}


.ejsc-feature:nth-child(4)
.ejsc-feature-icon {

    animation-delay:
        1.5s;
}


@keyframes ejscFeatureIconMotion {

    0%,100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    50% {
        transform:
            translateY(-7px)
            rotate(7deg);
    }
}


.ejsc-feature-icon svg {

    width: 28px;

    height: 28px;
}


.ejsc-feature h4 {

    margin:
        0 0 7px;

    color:
        #172a40;

    font-size:
        16px;

    font-weight:
        700;
}


.ejsc-feature p {

    max-width:
        180px;

    margin:
        0;

    color:
        #526a80;

    font-size:
        12px;

    line-height:
        1.7;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .ejsc-title {
        font-size: 56px;
    }

    .ejsc-hero-container {
        gap: 30px;
    }

    .ejsc-illustration {

        transform:
            scale(.85);

        transform-origin:
            bottom right;
    }

    .ejsc-feature-bar {

        padding:
            24px;
    }
}


@media (max-width: 900px) {

    .ejsc-hero {

        min-height:
            auto;

        padding-bottom:
            35px;
    }


    .ejsc-hero-container {

        min-height:
            auto;

        padding-top:
            105px;

        padding-bottom:
            40px;

        grid-template-columns:
            1fr;

        gap:
            45px;
    }


    .ejsc-title {

        max-width:
            700px;

        font-size:
            55px;
    }


    .ejsc-hero-right {

        min-height:
            600px;

        justify-content:
            center;
    }


    .ejsc-stat-card {

        max-width:
            650px;
    }


    .ejsc-illustration {

        right:
            50%;

        bottom:
            -25px;

        transform:
            translateX(50%)
            scale(.85);

        transform-origin:
            bottom center;
    }


    .ejsc-feature-wrapper {

        position:
            relative;

        left:
            auto;

        bottom:
            auto;

        width:
            min(
                calc(100% - 40px),
                700px
            );

        margin:
            0 auto;

        transform:
            none;
    }


    .ejsc-feature-bar {

        grid-template-columns:
            1fr 1fr;
    }
}


@media (max-width: 640px) {

    .ejsc-hero-container {

        width:
            calc(100% - 30px);

        padding-top:
            95px;
    }


    .ejsc-title {

        font-size:
            43px;

        line-height:
            1.06;

        letter-spacing:
            -2px;
    }


    .ejsc-description {

        font-size:
            15px;
    }


    .ejsc-buttons {

        width:
            100%;
    }


    .ejsc-btn-primary,
    .ejsc-btn-secondary {

        flex:
            1;

        min-width:
            140px;
    }


    .ejsc-stat-card {

        padding:
            20px;

        border-radius:
            22px;
    }


    .ejsc-stat-grid {

        grid-template-columns:
            1fr;
    }


    .ejsc-stat-box {

        min-height:
            90px;
    }


    .ejsc-hero-right {

        min-height:
            670px;
    }


    .ejsc-illustration {

        bottom:
            -5px;

        transform:
            translateX(50%)
            scale(.68);
    }


    .ejsc-feature-wrapper {

        width:
            calc(100% - 30px);
    }


    .ejsc-feature-bar {

        grid-template-columns:
            1fr;

        gap:
            20px;

        padding:
            25px;
    }


    .ejsc-feature p {

        max-width:
            100%;
    }
}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .ejsc-hero *,
    .ejsc-hero *::before,
    .ejsc-hero *::after {

        animation-duration:
            0.01ms !important;

        animation-iteration-count:
            1 !important;

        transition-duration:
            0.01ms !important;
    }
}

</style>

<!-- =========================================================
     SECTION : LAYANAN KAMI
     VERSION : REVISED / SAFE / BALANCED
     DESIGN  : EJSC BAKORWIL
========================================================= -->

<section class="ejsc-services">

    <!-- =====================================================
         BACKGROUND
    ====================================================== -->

    <div class="ejsc-orb ejsc-orb-1"></div>
    <div class="ejsc-orb ejsc-orb-2"></div>
    <div class="ejsc-orb ejsc-orb-3"></div>

    <div class="ejsc-grid-lines"></div>

    <!-- FLOATING PARTICLES -->

    <span class="ejsc-particle ejsc-particle-1"></span>
    <span class="ejsc-particle ejsc-particle-2"></span>
    <span class="ejsc-particle ejsc-particle-3"></span>
    <span class="ejsc-particle ejsc-particle-4"></span>
    <span class="ejsc-particle ejsc-particle-5"></span>
    <span class="ejsc-particle ejsc-particle-6"></span>
    <span class="ejsc-particle ejsc-particle-7"></span>
    <span class="ejsc-particle ejsc-particle-8"></span>


    <!-- =====================================================
         CONTAINER
    ====================================================== -->

    <div class="ejsc-services-container">


        <!-- =================================================
             HEADER
        ================================================== -->

        <header class="ejsc-services-header">

            <!-- SMALL LABEL -->

            <div class="ejsc-mini-label">

                <span class="ejsc-mini-dot"></span>

                <span>PROGRAM &amp; LAYANAN EJSC</span>

            </div>


            <!-- MAIN TITLE -->

            <h2 class="ejsc-main-title">

                LAYANAN
                <span>KAMI</span>

            </h2>


            <!-- DECORATIVE LINE -->

            <div class="ejsc-title-line">

                <span class="ejsc-line"></span>

                <span class="ejsc-line-center"></span>

                <span class="ejsc-line"></span>

            </div>


            <!-- SUBTITLE -->

            <p class="ejsc-main-subtitle">

                Solusi untuk Setiap Kebutuhan

            </p>


            <!-- DESCRIPTION -->

            <p class="ejsc-header-description">

                Temukan mentor, talenta, dan peluang kolaborasi
                terbaik untuk mengembangkan potensi dan mewujudkan
                setiap kebutuhan Anda.

            </p>

        </header>



        <!-- =================================================
             SERVICES
        ================================================== -->

        <div class="ejsc-services-grid">


            <!-- =================================================
                 MENTOR
            ================================================== -->

            <article class="ejsc-service-card ejsc-card-mentor">

                <div class="ejsc-card-glow"></div>


                <!-- DECORATIVE CIRCLES -->

                <div class="ejsc-deco-circle ejsc-circle-1"></div>
                <div class="ejsc-deco-circle ejsc-circle-2"></div>
                <div class="ejsc-deco-circle ejsc-circle-3"></div>


                <!-- NUMBER -->

                <div class="ejsc-card-number">
                    01
                </div>


                <!-- ICON -->

                <div class="ejsc-icon-wrapper">

                    <div class="ejsc-icon-ring"></div>

                    <div class="ejsc-service-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857
                                M17 20H7m10 0v-2
                                c0-.656-.126-1.283-.356-1.857
                                M7 20H2v-2
                                a3 3 0 015.356-1.857
                                M7 20v-2
                                c0-.656.126-1.283.356-1.857
                                m0 0a5.002 5.002 0 019.288 0
                                M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3
                                a2 2 0 11-4 0 2 2 0 014 0z
                                M7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />

                        </svg>

                    </div>

                </div>


                <!-- CONTENT -->

                <div class="ejsc-card-content">

                    <span class="ejsc-card-label">
                        BIMBINGAN &amp; PENGEMBANGAN
                    </span>

                    <h3>
                        Mentor
                    </h3>

                    <p>
                        Temukan mentor berpengalaman di berbagai bidang
                        untuk membimbing pengembangan karier dan skill Anda.
                    </p>

                </div>


                <!-- LINK -->

                <a
                    href="{{ route('mentor') }}"
                    class="ejsc-service-link"
                >

                    <span>
                        Lihat Mentor
                    </span>

                    <span class="ejsc-arrow">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                d="M5 12h14"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                            <path
                                d="M13 6l6 6-6 6"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>

                    </span>

                </a>


                <!-- BOTTOM WAVE -->

                <div class="ejsc-card-wave"></div>

            </article>



            <!-- =================================================
                 TALENTA
            ================================================== -->

            <article class="ejsc-service-card ejsc-card-talenta">

                <div class="ejsc-card-glow"></div>


                <div class="ejsc-deco-circle ejsc-circle-1"></div>
                <div class="ejsc-deco-circle ejsc-circle-2"></div>
                <div class="ejsc-deco-circle ejsc-circle-3"></div>


                <div class="ejsc-card-number">
                    02
                </div>


                <!-- ICON -->

                <div class="ejsc-icon-wrapper">

                    <div class="ejsc-icon-ring"></div>

                    <div class="ejsc-service-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.9"
                                d="M13 10V3L4 14h7v7l9-11h-7z"
                            />

                        </svg>

                    </div>

                </div>


                <!-- CONTENT -->

                <div class="ejsc-card-content">

                    <span class="ejsc-card-label">
                        POTENSI &amp; KOMPETENSI
                    </span>

                    <h3>
                        Talenta
                    </h3>

                    <p>
                        Jelajahi talenta terbaik dengan keahlian dan
                        potensi luar biasa yang siap berkontribusi
                        untuk Anda.
                    </p>

                </div>


                <!-- LINK -->

                <a
                    href="{{ route('talenta') }}"
                    class="ejsc-service-link"
                >

                    <span>
                        Lihat Talenta
                    </span>

                    <span class="ejsc-arrow">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                d="M5 12h14"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                            <path
                                d="M13 6l6 6-6 6"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>

                    </span>

                </a>


                <div class="ejsc-card-wave"></div>

            </article>



            <!-- =================================================
                 CLIENT
            ================================================== -->

            <article class="ejsc-service-card ejsc-card-client">

                <div class="ejsc-card-glow"></div>


                <div class="ejsc-deco-circle ejsc-circle-1"></div>
                <div class="ejsc-deco-circle ejsc-circle-2"></div>
                <div class="ejsc-deco-circle ejsc-circle-3"></div>


                <div class="ejsc-card-number">
                    03
                </div>


                <!-- ICON -->

                <div class="ejsc-icon-wrapper">

                    <div class="ejsc-icon-ring"></div>

                    <div class="ejsc-service-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M21 13.255A23.931 23.931 0 0112 15
                                c-3.183 0-6.22-.62-9-1.745
                                M16 6V4a2 2 0 00-2-2h-4
                                a2 2 0 00-2 2v2
                                m4 6h.01
                                M5 20h14a2 2 0 002-2V8
                                a2 2 0 00-2-2H5
                                a2 2 0 00-2 2v10
                                a2 2 0 002 2z"
                            />

                        </svg>

                    </div>

                </div>


                <!-- CONTENT -->

                <div class="ejsc-card-content">

                    <span class="ejsc-card-label">
                        KOLABORASI &amp; PELUANG
                    </span>

                    <h3>
                        Client
                    </h3>

                    <p>
                        Terhubung dengan client yang membutuhkan layanan
                        dan keahlian terbaik untuk proyek Anda.
                    </p>

                </div>


                <!-- LINK -->

                <a
                    href="{{ route('client') }}"
                    class="ejsc-service-link"
                >

                    <span>
                        Lihat Client
                    </span>

                    <span class="ejsc-arrow">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >

                            <path
                                d="M5 12h14"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                            <path
                                d="M13 6l6 6-6 6"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>

                    </span>

                </a>


                <div class="ejsc-card-wave"></div>

            </article>

        </div>

    </div>

</section>



<style>

/* =========================================================
   EJSC SERVICES
   SAFE / SCOPED VERSION
========================================================= */


/* =========================================================
   RESET
========================================================= */

.ejsc-services,
.ejsc-services *,
.ejsc-services *::before,
.ejsc-services *::after {

    box-sizing: border-box;

}


/* =========================================================
   MAIN SECTION
========================================================= */

.ejsc-services {

    --ejsc-primary: #0b969f;
    --ejsc-primary-light: #55c5c8;
    --ejsc-dark: #102c49;
    --ejsc-text: #405a75;

    position: relative;

    width: 100%;

    padding: 85px 0 100px;

    overflow: hidden;

    background:
        radial-gradient(
            circle at 8% 10%,
            rgba(74,194,199,.13),
            transparent 25%
        ),
        radial-gradient(
            circle at 92% 75%,
            rgba(67,183,193,.10),
            transparent 27%
        ),
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fafdfe 48%,
            #f2fafb 100%
        );

    color: var(--ejsc-dark);

}


/* =========================================================
   CONTAINER
========================================================= */

.ejsc-services-container {

    position: relative;

    z-index: 10;

    width: min(
        1160px,
        calc(100% - 50px)
    );

    margin: 0 auto;

}


/* =========================================================
   BACKGROUND ORBS
========================================================= */

.ejsc-orb {

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    filter: blur(3px);

    opacity: .55;

    animation:
        ejscOrbFloat
        12s
        ease-in-out
        infinite;

}


.ejsc-orb-1 {

    width: 420px;
    height: 420px;

    left: -230px;
    top: 80px;

    background:
        radial-gradient(
            circle,
            rgba(72,191,198,.18),
            transparent 70%
        );

}


.ejsc-orb-2 {

    width: 500px;
    height: 500px;

    right: -280px;
    top: 260px;

    background:
        radial-gradient(
            circle,
            rgba(78,193,201,.16),
            transparent 70%
        );

    animation-delay: -4s;

}


.ejsc-orb-3 {

    width: 350px;
    height: 350px;

    left: 42%;
    bottom: -230px;

    background:
        radial-gradient(
            circle,
            rgba(87,204,207,.13),
            transparent 70%
        );

    animation-delay: -7s;

}


@keyframes ejscOrbFloat {

    0%,
    100% {

        transform:
            translate3d(0,0,0)
            scale(1);

    }

    50% {

        transform:
            translate3d(35px,-25px,0)
            scale(1.06);

    }

}


/* =========================================================
   GRID
========================================================= */

.ejsc-grid-lines {

    position: absolute;

    inset: 0;

    pointer-events: none;

    opacity: .22;

    background-image:

        linear-gradient(
            rgba(67,171,180,.055) 1px,
            transparent 1px
        ),

        linear-gradient(
            90deg,
            rgba(67,171,180,.055) 1px,
            transparent 1px
        );

    background-size: 55px 55px;

    -webkit-mask-image:
        linear-gradient(
            to bottom,
            transparent,
            black 20%,
            black 75%,
            transparent
        );

    mask-image:
        linear-gradient(
            to bottom,
            transparent,
            black 20%,
            black 75%,
            transparent
        );

}


/* =========================================================
   PARTICLES
========================================================= */

.ejsc-particle {

    position: absolute;

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #55bfc3;

    box-shadow:
        0 0 0 5px rgba(85,191,195,.07),
        0 0 18px rgba(85,191,195,.30);

    animation:
        ejscParticleMove
        7s
        ease-in-out
        infinite;

}


.ejsc-particle-1 {
    left: 9%;
    top: 25%;
}

.ejsc-particle-2 {
    left: 18%;
    top: 70%;
    animation-delay: -2s;
}

.ejsc-particle-3 {
    left: 34%;
    top: 14%;
    animation-delay: -4s;
}

.ejsc-particle-4 {
    left: 52%;
    top: 82%;
    animation-delay: -1s;
}

.ejsc-particle-5 {
    right: 13%;
    top: 20%;
    animation-delay: -3s;
}

.ejsc-particle-6 {
    right: 8%;
    top: 62%;
    animation-delay: -5s;
}

.ejsc-particle-7 {
    left: 46%;
    top: 36%;
    animation-delay: -6s;
}

.ejsc-particle-8 {
    right: 30%;
    top: 9%;
    animation-delay: -1.5s;
}


@keyframes ejscParticleMove {

    0%,
    100% {

        transform:
            translate(0,0)
            scale(1);

        opacity: .25;

    }

    25% {

        transform:
            translate(15px,-20px)
            scale(1.35);

        opacity: .8;

    }

    50% {

        transform:
            translate(-8px,-40px)
            scale(.8);

        opacity: 1;

    }

    75% {

        transform:
            translate(-18px,-15px)
            scale(1.15);

        opacity: .45;

    }

}


/* =========================================================
   HEADER
========================================================= */

.ejsc-services-header {

    position: relative;

    text-align: center;

    margin-bottom: 58px;

    animation:
        ejscHeaderEnter
        .9s
        cubic-bezier(.2,.8,.2,1)
        both;

}


@keyframes ejscHeaderEnter {

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
   MINI LABEL
========================================================= */

.ejsc-mini-label {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 8px 15px;

    margin-bottom: 17px;

    border: 1px solid #d4ecee;

    border-radius: 999px;

    background: #f1fafb;

    color: #487083;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: 1.45px;

    box-shadow:
        0 7px 20px rgba(46,137,146,.05);

}


.ejsc-mini-dot {

    width: 7px;
    height: 7px;

    flex: 0 0 7px;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #5bd0d0,
            #07959e
        );

    box-shadow:
        0 0 0 4px
        rgba(62,190,195,.09);

    animation:
        ejscMiniDot
        2s
        ease-in-out
        infinite;

}


@keyframes ejscMiniDot {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.3);
    }

}


/* =========================================================
   MAIN TITLE
   REVISED: SMALLER & MORE BALANCED
========================================================= */

.ejsc-main-title {

    margin: 0;

    font-family:
        "Inter",
        "Poppins",
        Arial,
        sans-serif;

    /*
     * Sebelumnya max 82px.
     * Sekarang dibuat lebih kecil agar
     * lebih seimbang dengan section lain.
     */

    font-size:
        clamp(
            40px,
            5vw,
            58px
        );

    line-height: 1;

    letter-spacing: -2.5px;

    font-weight: 900;

    color: #102b48;

}


.ejsc-main-title span {

    display: inline-block;

    margin-left: 5px;

    background:
        linear-gradient(
            100deg,
            #087f89 0%,
            #13a6ad 25%,
            #55c8ca 50%,
            #07929b 75%,
            #087f89 100%
        );

    background-size: 300% auto;

    -webkit-background-clip: text;

    background-clip: text;

    -webkit-text-fill-color: transparent;

    animation:
        ejscTitleFlow
        5s
        linear
        infinite;

}


@keyframes ejscTitleFlow {

    from {
        background-position: 0% center;
    }

    to {
        background-position: 300% center;
    }

}


/* =========================================================
   TITLE LINE
========================================================= */

.ejsc-title-line {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    margin: 18px 0 15px;

}


.ejsc-line {

    width: 45px;

    height: 2px;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #55bdc1
        );

}


.ejsc-line:last-child {

    background:
        linear-gradient(
            90deg,
            #55bdc1,
            transparent
        );

}


.ejsc-line-center {

    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #39adb4;

    box-shadow:
        0 0 0 5px
        rgba(57,173,180,.08),
        0 0 15px
        rgba(57,173,180,.25);

    animation:
        ejscCenterPulse
        2s
        ease-in-out
        infinite;

}


@keyframes ejscCenterPulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.3);
    }

}


/* =========================================================
   SUBTITLE
========================================================= */

.ejsc-main-subtitle {

    margin: 0 0 7px;

    color: #173653;

    font-size:
        clamp(
            19px,
            2.5vw,
            25px
        );

    line-height: 1.3;

    font-weight: 700;

    letter-spacing: -.3px;

}


.ejsc-header-description {

    max-width: 650px;

    margin: 0 auto;

    color: #526d85;

    font-size: 15px;

    line-height: 1.75;

}


/* =========================================================
   SERVICES GRID
========================================================= */

.ejsc-services-grid {

    display: grid;

    grid-template-columns:
        repeat(3,minmax(0,1fr));

    gap: 24px;

    align-items: stretch;

}


/* =========================================================
   CARD
========================================================= */

.ejsc-service-card {

    --accent: #11a0a8;
    --accent-soft: rgba(17,160,168,.11);

    position: relative;

    min-height: 455px;

    padding: 36px 32px 32px;

    overflow: hidden;

    /*
     * BORDER DIPERKUAT
     */

    border: 1px solid #c9e4e7;

    border-radius: 26px;

    background:
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fbfefe 100%
        );

    /*
     * Border luar + shadow agar
     * sisi card tetap terlihat jelas.
     */

    box-shadow:
        0 0 0 1px rgba(255,255,255,.8) inset,
        0 12px 35px rgba(31,105,117,.08);

    transform:
        translateY(0);

    transition:
        transform .45s cubic-bezier(.2,.8,.2,1),
        box-shadow .45s ease,
        border-color .45s ease;

    animation:
        ejscCardFloat
        6s
        ease-in-out
        infinite;

}


.ejsc-card-mentor {

    --accent: #0d9ca5;
    --accent-soft: rgba(13,156,165,.11);

}


.ejsc-card-talenta {

    --accent: #2b9fd0;
    --accent-soft: rgba(43,159,208,.11);

    animation-delay: -2s;

}


.ejsc-card-client {

    --accent: #d99b17;
    --accent-soft: rgba(217,155,23,.12);

    animation-delay: -4s;

}


/* =========================================================
   CARD FLOAT
========================================================= */

@keyframes ejscCardFloat {

    0%,
    100% {

        transform:
            translateY(0);

    }

    50% {

        transform:
            translateY(-6px);

    }

}


/* =========================================================
   CARD HOVER
========================================================= */

.ejsc-service-card:hover {

    animation-play-state: paused;

    transform:
        translateY(-10px);

    border-color:
        var(--accent);

    box-shadow:
        0 0 0 1px var(--accent-soft),
        0 22px 50px rgba(25,108,120,.14);

}


/* =========================================================
   CARD GLOW
========================================================= */

.ejsc-card-glow {

    position: absolute;

    width: 220px;
    height: 220px;

    top: -120px;
    right: -90px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            var(--accent-soft),
            transparent 68%
        );

    transition:
        transform .7s ease;

}


.ejsc-service-card:hover
.ejsc-card-glow {

    transform:
        scale(1.55);

}


/* =========================================================
   DECORATIVE CIRCLES
========================================================= */

.ejsc-deco-circle {

    position: absolute;

    border-radius: 50%;

    border:
        1px solid
        var(--accent-soft);

    pointer-events: none;

}


.ejsc-circle-1 {

    width: 115px;
    height: 115px;

    right: -40px;
    top: 50px;

    animation:
        ejscCircleRotate
        12s
        linear
        infinite;

}


.ejsc-circle-2 {

    width: 72px;
    height: 72px;

    right: 22px;
    top: 72px;

    background:
        var(--accent-soft);

    animation:
        ejscCirclePulse
        5s
        ease-in-out
        infinite;

}


.ejsc-circle-3 {

    width: 10px;
    height: 10px;

    right: 102px;
    top: 55px;

    background:
        var(--accent);

    border: 0;

    box-shadow:
        0 0 0 6px
        var(--accent-soft);

    animation:
        ejscSmallOrbit
        4s
        ease-in-out
        infinite;

}


@keyframes ejscCircleRotate {

    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }

}


@keyframes ejscCirclePulse {

    0%,
    100% {

        transform: scale(1);

        opacity: .5;

    }

    50% {

        transform: scale(1.12);

        opacity: 1;

    }

}


@keyframes ejscSmallOrbit {

    0%,
    100% {
        transform: translate(0,0);
    }

    50% {
        transform: translate(-10px,8px);
    }

}


/* =========================================================
   CARD NUMBER
========================================================= */

.ejsc-card-number {

    position: absolute;

    top: 22px;
    left: 25px;

    color:
        var(--accent);

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 1px;

    opacity: .55;

}


/* =========================================================
   ICON WRAPPER
========================================================= */

.ejsc-icon-wrapper {

    position: relative;

    width: 92px;
    height: 92px;

    margin-bottom: 30px;

}


.ejsc-icon-ring {

    position: absolute;

    inset: -7px;

    border-radius: 24px;

    border:
        1px dashed
        var(--accent-soft);

    animation:
        ejscRingSpin
        12s
        linear
        infinite;

}


@keyframes ejscRingSpin {

    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }

}


/* =========================================================
   ICON
========================================================= */

.ejsc-service-icon {

    position: relative;

    z-index: 2;

    width: 92px;
    height: 92px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 23px;

    color:
        var(--accent);

    background:
        #ffffff;

    border:
        1px solid
        var(--accent-soft);

    box-shadow:
        0 12px 25px
        rgba(42,137,148,.09);

    animation:
        ejscIconFloat
        4.5s
        ease-in-out
        infinite;

}


.ejsc-service-icon svg {

    width: 46px;
    height: 46px;

    animation:
        ejscIconPulse
        3.5s
        ease-in-out
        infinite;

}


@keyframes ejscIconFloat {

    0%,
    100% {

        transform:
            translateY(0)
            rotate(0deg);

    }

    50% {

        transform:
            translateY(-5px)
            rotate(2deg);

    }

}


@keyframes ejscIconPulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.06);
    }

}


/* =========================================================
   CARD CONTENT
========================================================= */

.ejsc-card-content {

    position: relative;

    z-index: 4;

}


.ejsc-card-label {

    display: block;

    margin-bottom: 8px;

    color:
        var(--accent);

    font-size: 9px;

    font-weight: 800;

    letter-spacing: 1.3px;

    opacity: .9;

}


.ejsc-card-content h3 {

    margin: 0 0 12px;

    color:
        #112e4b;

    font-family:
        "Inter",
        "Poppins",
        Arial,
        sans-serif;

    font-size: 29px;

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -.7px;

}


.ejsc-card-content p {

    max-width: 365px;

    margin: 0;

    color:
        #4b657d;

    font-size: 14px;

    line-height: 1.75;

}


/* =========================================================
   LINK
========================================================= */

.ejsc-service-link {

    position: absolute;

    z-index: 8;

    left: 32px;
    bottom: 28px;

    display: inline-flex;

    align-items: center;

    gap: 10px;

    color:
        var(--accent);

    text-decoration: none;

    font-size: 13px;

    font-weight: 800;

    transition:
        color .3s ease;

}


.ejsc-arrow {

    width: 31px;
    height: 31px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        var(--accent-soft);

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        background .35s ease;

}


.ejsc-arrow svg {

    width: 16px;
    height: 16px;

    transition:
        transform .35s ease;

}


.ejsc-service-link:hover
.ejsc-arrow {

    transform:
        translateX(4px)
        scale(1.05);

    background:
        var(--accent);

}


.ejsc-service-link:hover
.ejsc-arrow svg {

    color: #ffffff;

    transform:
        translateX(2px);

}


/* =========================================================
   BOTTOM WAVE
========================================================= */

.ejsc-card-wave {

    position: absolute;

    width: 290px;
    height: 165px;

    right: -90px;
    bottom: -105px;

    border-radius:
        50% 50% 0 0;

    background:
        linear-gradient(
            135deg,
            transparent 5%,
            var(--accent-soft),
            rgba(255,255,255,.25)
        );

    transform:
        rotate(-12deg);

    transition:
        transform .6s ease;

}


.ejsc-service-card:hover
.ejsc-card-wave {

    transform:
        rotate(-5deg)
        translate(-12px,-7px)
        scale(1.06);

}


/* =========================================================
   MOVING SHINE
========================================================= */

.ejsc-service-card::before {

    content: "";

    position: absolute;

    z-index: 6;

    top: -40%;

    left: -100%;

    width: 55%;

    height: 180%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.65),
            transparent
        );

    transform:
        rotate(18deg);

    pointer-events: none;

    animation:
        ejscShine
        9s
        ease-in-out
        infinite;

}


.ejsc-card-talenta::before {
    animation-delay: -3s;
}


.ejsc-card-client::before {
    animation-delay: -6s;
}


@keyframes ejscShine {

    0% {
        left: -100%;
    }

    25% {
        left: 140%;
    }

    100% {
        left: 140%;
    }

}


/* =========================================================
   TABLET / SMALL LAPTOP
========================================================= */

@media (max-width: 1050px) {

    .ejsc-services {

        padding:
            75px 0 90px;

    }


    .ejsc-services-container {

        width:
            min(
                920px,
                calc(100% - 40px)
            );

    }


    .ejsc-services-grid {

        gap: 18px;

    }


    .ejsc-service-card {

        min-height: 445px;

        padding:
            34px 27px 30px;

    }


    .ejsc-icon-wrapper,
    .ejsc-service-icon {

        width: 86px;
        height: 86px;

    }


    .ejsc-service-icon {

        border-radius: 21px;

    }


    .ejsc-service-icon svg {

        width: 43px;
        height: 43px;

    }


    .ejsc-card-content h3 {

        font-size: 27px;

    }


    .ejsc-card-content p {

        font-size: 13.5px;

    }


    .ejsc-service-link {

        left: 27px;

    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 800px) {

    .ejsc-services {

        padding:
            70px 0 80px;

    }


    .ejsc-services-header {

        margin-bottom: 45px;

    }


    .ejsc-services-grid {

        grid-template-columns: 1fr;

    }


    .ejsc-service-card {

        width: 100%;

        max-width: 600px;

        min-height: 410px;

        margin: 0 auto;

        padding: 35px;

    }


    .ejsc-icon-wrapper,
    .ejsc-service-icon {

        width: 90px;
        height: 90px;

    }


    .ejsc-card-content p {

        max-width: 510px;

    }


    .ejsc-service-link {

        left: 35px;

    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 600px) {

    .ejsc-services {

        padding:
            60px 0 70px;

    }


    .ejsc-services-container {

        width:
            calc(100% - 30px);

    }


    /* ---------------------------------------------
       TITLE MOBILE
    --------------------------------------------- */

    .ejsc-main-title {

        font-size:
            clamp(
                34px,
                10.5vw,
                46px
            );

        letter-spacing:
            -2px;

    }


    .ejsc-main-title span {

        margin-left:
            3px;

    }


    .ejsc-main-subtitle {

        font-size:
            19px;

    }


    .ejsc-header-description {

        font-size:
            13.5px;

        line-height:
            1.7;

    }


    .ejsc-services-header {

        margin-bottom:
            38px;

    }


    .ejsc-mini-label {

        font-size:
            9px;

        padding:
            7px 12px;

    }


    /* ---------------------------------------------
       CARD
    --------------------------------------------- */

    .ejsc-service-card {

        min-height:
            405px;

        padding:
            32px 24px 28px;

        border-radius:
            23px;

    }


    .ejsc-icon-wrapper,
    .ejsc-service-icon {

        width:
            82px;

        height:
            82px;

    }


    .ejsc-service-icon {

        border-radius:
            19px;

    }


    .ejsc-service-icon svg {

        width:
            40px;

        height:
            40px;

    }


    .ejsc-card-content h3 {

        font-size:
            25px;

    }


    .ejsc-card-content p {

        font-size:
            13.5px;

        line-height:
            1.72;

    }


    .ejsc-service-link {

        left:
            24px;

        bottom:
            24px;

        font-size:
            13px;

    }


    .ejsc-card-number {

        right:
            22px;

        left:
            auto;

    }


    .ejsc-circle-1 {

        right:
            -55px;

    }


    .ejsc-line {

        width:
            35px;

    }

}


/* =========================================================
   VERY SMALL MOBILE
========================================================= */

@media (max-width: 380px) {

    .ejsc-services-container {

        width:
            calc(100% - 24px);

    }


    .ejsc-main-title {

        font-size:
            34px;

    }


    .ejsc-main-subtitle {

        font-size:
            18px;

    }


    .ejsc-service-card {

        padding:
            30px 21px 26px;

    }


    .ejsc-service-link {

        left:
            21px;

    }

}


/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .ejsc-services *,
    .ejsc-services *::before,
    .ejsc-services *::after {

        animation-duration:
            .01ms !important;

        animation-iteration-count:
            1 !important;

        transition-duration:
            .01ms !important;

    }

}

</style>
{{-- =========================================================
    HOW IT WORKS
========================================================= --}}
<section class="how-it-works-section relative overflow-hidden">

    {{-- BACKGROUND DECORATION --}}
    <div class="how-blob blob-one"></div>
    <div class="how-blob blob-two"></div>
    <div class="how-blob blob-three"></div>
    <div class="how-blob blob-four"></div>

    {{-- Background rings --}}
    <div class="how-ring ring-one"></div>
    <div class="how-ring ring-two"></div>

    {{-- Floating particles --}}
    <span class="floating-dot dot-1"></span>
    <span class="floating-dot dot-2"></span>
    <span class="floating-dot dot-3"></span>
    <span class="floating-dot dot-4"></span>
    <span class="floating-dot dot-5"></span>
    <span class="floating-dot dot-6"></span>
    <span class="floating-dot dot-7"></span>
    <span class="floating-dot dot-8"></span>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- HEADER --}}
        <div class="text-center how-header">

            <div class="section-badge">
                <span class="badge-dot"></span>

                <span>
                    CARA KERJA
                </span>
            </div>

            <h2 class="how-title">
                Cara <span>Kerja</span>
            </h2>

            <div class="title-decoration">
                <span></span>
                <i></i>
            </div>

            <p class="how-subtitle">
                Langkah mudah untuk memulai bersama kami
            </p>

        </div>


        {{-- STEPS --}}
        <div class="steps-wrapper">

            {{-- CONNECTING LINE --}}
            <div class="steps-line">

                <div class="line-base"></div>
                <div class="moving-line"></div>
                <div class="line-glow"></div>

            </div>


            {{-- STEP 1 --}}
            <div class="step-card step-1">

                <div class="step-orbit orbit-1"></div>

                <div class="step-number">
                    <span>1</span>
                </div>

                <div class="step-icon">

                    <div class="icon-glow"></div>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>

                </div>

                <h3>
                    Daftar
                </h3>

                <p>
                    Buat akun dan lengkapi profil Anda
                </p>

                <div class="step-pulse"></div>

            </div>


            {{-- STEP 2 --}}
            <div class="step-card step-2">

                <div class="step-orbit orbit-2"></div>

                <div class="step-number">
                    <span>2</span>
                </div>

                <div class="step-icon">

                    <div class="icon-glow"></div>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M12 2v20"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H7"/>
                    </svg>

                </div>

                <h3>
                    Pilih
                </h3>

                <p>
                    Pilih mentor, talenta, atau client sesuai kebutuhan
                </p>

                <div class="step-pulse"></div>

            </div>


            {{-- STEP 3 --}}
            <div class="step-card step-3">

                <div class="step-orbit orbit-3"></div>

                <div class="step-number">
                    <span>3</span>
                </div>

                <div class="step-icon">

                    <div class="icon-glow"></div>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>

                </div>

                <h3>
                    Terhubung
                </h3>

                <p>
                    Mulai kolaborasi dan komunikasi langsung
                </p>

                <div class="step-pulse"></div>

            </div>


            {{-- STEP 4 --}}
            <div class="step-card step-4">

                <div class="step-orbit orbit-4"></div>

                <div class="step-number">
                    <span>4</span>
                </div>

                <div class="step-icon">

                    <div class="icon-glow"></div>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M3 3v18h18"/>
                        <path d="M7 16l4-5 3 3 5-7"/>
                    </svg>

                </div>

                <h3>
                    Berkembang
                </h3>

                <p>
                    Kembangkan karier dan bisnis bersama kami
                </p>

                <div class="step-pulse"></div>

            </div>

        </div>

    </div>
</section>



{{-- =========================================================
    CTA SECTION
========================================================= --}}
<section class="cta-section relative overflow-hidden">

    {{-- Decorative background --}}
    <div class="cta-orb cta-orb-1"></div>
    <div class="cta-orb cta-orb-2"></div>
    <div class="cta-orb cta-orb-3"></div>
    <div class="cta-orb cta-orb-4"></div>

    <div class="cta-wave"></div>

    <span class="cta-dot cta-dot-1"></span>
    <span class="cta-dot cta-dot-2"></span>
    <span class="cta-dot cta-dot-3"></span>
    <span class="cta-dot cta-dot-4"></span>
    <span class="cta-dot cta-dot-5"></span>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

        <div class="cta-content">

            <div class="cta-badge">

                <span></span>

                MULAI BERSAMA KAMI

            </div>


            <h2>
                Siap <span>Memulai?</span>
            </h2>


            <div class="cta-line">
                <span></span>
                <i></i>
            </div>


            <p>
                Bergabunglah dengan ribuan pengguna yang telah
                merasakan manfaat platform kami
            </p>


            <div class="cta-buttons">

                <a
                    href="{{ route('kelola.mentor') }}"
                    class="cta-primary"
                >

                    <span>
                        Kelola Data
                    </span>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                    <div class="button-shine"></div>

                </a>


                <a
                    href="{{ route('client') }}"
                    class="cta-secondary"
                >

                    <span>
                        Hubungi Kami
                    </span>

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </a>

            </div>

        </div>

    </div>
</section>



{{-- =========================================================
    CSS
========================================================= --}}
<style>

/* =========================================================
   COLOR SYSTEM
   Biru telur asin / seafoam yang lebih cerah
========================================================= */

:root {

    --egg-dark:
        #176b68;

    --egg-primary:
        #2aa9a2;

    --egg-light:
        #65d6d0;

    --egg-soft:
        #bcefeb;

    --egg-pale:
        #e9fbfa;

    --egg-white:
        #f8ffff;

    --egg-text:
        #214d5a;

    --egg-muted:
        #587782;

}


/* =========================================================
   RESET
========================================================= */

.how-it-works-section *,
.cta-section * {
    box-sizing: border-box;
}


/* =========================================================
   HOW IT WORKS
========================================================= */

.how-it-works-section {

    position: relative;

    padding: 110px 0 125px;

    overflow: hidden;

    background:

        radial-gradient(
            circle at 7% 20%,
            rgba(101,214,208,.18),
            transparent 28%
        ),

        radial-gradient(
            circle at 92% 65%,
            rgba(78,195,190,.15),
            transparent 30%
        ),

        radial-gradient(
            circle at 50% 115%,
            rgba(188,239,235,.30),
            transparent 34%
        ),

        linear-gradient(
            180deg,
            #f5fffe 0%,
            #ffffff 46%,
            #f3fcfb 100%
        );

    isolation: isolate;
}


/* =========================================================
   BACKGROUND BLOBS
========================================================= */

.how-blob {

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    filter: blur(4px);

    z-index: -2;

    opacity: .85;
}


.blob-one {

    width: 320px;
    height: 320px;

    left: -160px;
    top: 70px;

    background:
        rgba(101,214,208,.17);

    animation:
        blobFloatOne
        8s
        ease-in-out
        infinite;
}


.blob-two {

    width: 270px;
    height: 270px;

    right: -130px;
    bottom: 70px;

    background:
        rgba(78,195,190,.14);

    animation:
        blobFloatTwo
        10s
        ease-in-out
        infinite;
}


.blob-three {

    width: 160px;
    height: 160px;

    left: 47%;
    top: -80px;

    background:
        rgba(188,239,235,.20);

    animation:
        blobFloatThree
        7s
        ease-in-out
        infinite;
}


.blob-four {

    width: 120px;
    height: 120px;

    right: 18%;
    bottom: 8%;

    background:
        rgba(42,169,162,.09);

    animation:
        blobFloatFour
        6s
        ease-in-out
        infinite;
}


/* =========================================================
   RINGS
========================================================= */

.how-ring {

    position: absolute;

    border-radius: 50%;

    border:
        1px solid
        rgba(42,169,162,.12);

    pointer-events: none;

    z-index: -1;
}


.ring-one {

    width: 420px;
    height: 420px;

    left: -250px;
    top: 35%;

    animation:
        ringRotate
        20s
        linear
        infinite;
}


.ring-two {

    width: 300px;
    height: 300px;

    right: -170px;
    top: 18%;

    animation:
        ringRotateReverse
        16s
        linear
        infinite;
}


/* =========================================================
   FLOATING DOTS
========================================================= */

.floating-dot {

    position: absolute;

    display: block;

    width: 11px;
    height: 11px;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            rgba(42,169,162,.65),
            rgba(101,214,208,.20)
        );

    box-shadow:
        0 0 20px
        rgba(42,169,162,.22);

    pointer-events: none;

    z-index: -1;
}


.dot-1 {
    left: 18%;
    top: 12%;
    animation: dotPathOne 5s ease-in-out infinite;
}

.dot-2 {
    left: 73%;
    top: 17%;
    width: 8px;
    height: 8px;
    animation: dotPathTwo 7s ease-in-out infinite;
}

.dot-3 {
    left: 10%;
    bottom: 20%;
    width: 9px;
    height: 9px;
    animation: dotPathThree 6s ease-in-out infinite;
}

.dot-4 {
    right: 15%;
    bottom: 25%;
    animation: dotPathFour 8s ease-in-out infinite;
}

.dot-5 {
    left: 42%;
    bottom: 10%;
    width: 7px;
    height: 7px;
    animation: dotPathFive 4s ease-in-out infinite;
}

.dot-6 {
    right: 35%;
    top: 8%;
    width: 7px;
    height: 7px;
    animation: dotPathSix 5s ease-in-out infinite;
}

.dot-7 {
    left: 30%;
    top: 40%;
    width: 6px;
    height: 6px;
    animation: dotPathSeven 6s ease-in-out infinite;
}

.dot-8 {
    right: 28%;
    bottom: 14%;
    width: 6px;
    height: 6px;
    animation: dotPathEight 5s ease-in-out infinite;
}


/* =========================================================
   HEADER
========================================================= */

.how-header {

    margin-bottom: 75px;

    animation:
        headerFloat
        5s
        ease-in-out
        infinite;
}


/* =========================================================
   BADGE
========================================================= */

.section-badge {

    display: inline-flex;

    align-items: center;

    gap: 10px;

    padding: 10px 20px;

    border-radius: 999px;

    background:
        rgba(233,251,250,.92);

    border:
        1px solid
        rgba(42,169,162,.18);

    color:
        #38636b;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 1.1px;

    box-shadow:
        0 8px 25px
        rgba(42,169,162,.08);

    backdrop-filter:
        blur(8px);

    animation:
        badgePulse
        3s
        ease-in-out
        infinite;
}


.badge-dot {

    width: 9px;
    height: 9px;

    border-radius: 50%;

    background:
        #2aa9a2;

    box-shadow:
        0 0 0 5px
        rgba(42,169,162,.11);

    animation:
        dotPulse
        2s
        ease-in-out
        infinite;
}


/* =========================================================
   TITLE
========================================================= */

.how-title {

    margin-top: 28px;

    font-size:
        clamp(42px, 5vw, 68px);

    line-height: 1.05;

    font-weight: 800;

    letter-spacing: -2.5px;

    color:
        #244e5a;

    text-shadow:
        0 3px 20px
        rgba(42,169,162,.06);
}


.how-title span {

    display: inline-block;

    background:
        linear-gradient(
            90deg,
            #247c79,
            #2aa9a2,
            #65d6d0,
            #247c79
        );

    background-size: 300% auto;

    -webkit-background-clip: text;
    background-clip: text;

    color: transparent;

    animation:
        gradientMove
        4s
        linear
        infinite;
}


/* =========================================================
   TITLE DECORATION
========================================================= */

.title-decoration {

    margin:
        24px auto 22px;

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 10px;
}


.title-decoration span {

    display: block;

    width: 68px;
    height: 5px;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            #2aa9a2,
            #8ae3de,
            #2aa9a2
        );

    background-size: 200% 100%;

    animation:
        gradientMove
        3s
        linear
        infinite;
}


.title-decoration i {

    width: 8px;
    height: 8px;

    border-radius: 50%;

    background:
        #2aa9a2;

    box-shadow:
        0 0 15px
        rgba(42,169,162,.45);

    animation:
        dotPulse
        1.8s
        ease-in-out
        infinite;
}


/* =========================================================
   SUBTITLE
========================================================= */

.how-subtitle {

    max-width: 650px;

    margin: auto;

    color:
        #587782;

    font-size: 18px;

    line-height: 1.8;
}


/* =========================================================
   STEPS
========================================================= */

.steps-wrapper {

    position: relative;

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 35px;
}


/* =========================================================
   CONNECTING LINE
========================================================= */

.steps-line {

    position: absolute;

    left: 10%;
    right: 10%;

    top: 38px;

    height: 3px;

    z-index: 0;
}


.line-base {

    position: absolute;

    inset: 0;

    border-radius: 999px;

    background:
        rgba(42,169,162,.13);
}


.moving-line {

    position: absolute;

    top: 0;
    left: -15%;

    width: 18%;
    height: 100%;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #2aa9a2,
            #8ae3de,
            #2aa9a2,
            transparent
        );

    box-shadow:
        0 0 20px
        rgba(42,169,162,.55);

    animation:
        lineTravel
        3.5s
        linear
        infinite;
}


.line-glow {

    position: absolute;

    top: -4px;

    left: 0;

    width: 100%;
    height: 11px;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(42,169,162,.13),
            transparent
        );

    filter: blur(4px);

    animation:
        lineGlow
        3s
        ease-in-out
        infinite;
}


/* =========================================================
   STEP CARD
========================================================= */

.step-card {

    position: relative;

    z-index: 2;

    text-align: center;

    padding: 5px 15px 10px;

    animation:
        stepFloat
        4.2s
        ease-in-out
        infinite;

    transition:
        transform .4s ease;
}


.step-1 {
    animation-delay: 0s;
}

.step-2 {
    animation-delay: .55s;
}

.step-3 {
    animation-delay: 1.1s;
}

.step-4 {
    animation-delay: 1.65s;
}


.step-card:hover {

    animation-play-state:
        paused;

    transform:
        translateY(-10px);
}


/* =========================================================
   STEP ORBIT
========================================================= */

.step-orbit {

    position: absolute;

    width: 104px;
    height: 104px;

    left: 50%;
    top: -14px;

    margin-left: -52px;

    border:
        1px dashed
        rgba(42,169,162,.18);

    border-radius: 50%;

    pointer-events: none;

    animation:
        orbitRotate
        9s
        linear
        infinite;
}


.step-orbit::after {

    content: "";

    position: absolute;

    width: 7px;
    height: 7px;

    top: 5px;
    left: 50%;

    margin-left: -3.5px;

    border-radius: 50%;

    background:
        #2aa9a2;

    box-shadow:
        0 0 14px
        rgba(42,169,162,.55);
}


/* =========================================================
   STEP NUMBER
========================================================= */

.step-number {

    position: relative;

    width: 76px;
    height: 76px;

    margin: 0 auto 22px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 24px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.98),
            rgba(235,252,250,.94)
        );

    border:
        1px solid
        rgba(42,169,162,.18);

    color:
        #247c79;

    font-size: 25px;

    font-weight: 800;

    box-shadow:
        0 15px 35px
        rgba(42,169,162,.11),

        inset 0 1px 0
        rgba(255,255,255,.95);

    z-index: 3;

    animation:
        numberBounce
        3.2s
        ease-in-out
        infinite;

    transition:
        transform .4s ease,
        box-shadow .4s ease;
}


.step-number span {

    position: relative;

    z-index: 2;

    animation:
        numberScale
        3.2s
        ease-in-out
        infinite;
}


.step-number::before {

    content: "";

    position: absolute;

    inset: -7px;

    border-radius: 28px;

    border:
        1px solid
        rgba(42,169,162,.13);

    animation:
        ringPulse
        2.8s
        ease-in-out
        infinite;
}


.step-number::after {

    content: "";

    position: absolute;

    width: 10px;
    height: 10px;

    top: 8px;
    right: 9px;

    border-radius: 50%;

    background:
        rgba(101,214,208,.75);

    box-shadow:
        0 0 14px
        rgba(101,214,208,.60);

    animation:
        tinyOrbit
        3s
        ease-in-out
        infinite;
}


.step-card:hover .step-number {

    transform:
        translateY(-10px)
        scale(1.1);

    box-shadow:
        0 25px 50px
        rgba(42,169,162,.22);
}


/* =========================================================
   STEP ICON
========================================================= */

.step-icon {

    position: relative;

    width: 54px;
    height: 54px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 18px;

    color:
        #247c79;

    background:
        linear-gradient(
            135deg,
            rgba(213,247,244,.95),
            rgba(232,250,249,.90)
        );

    border:
        1px solid
        rgba(42,169,162,.10);

    box-shadow:
        0 10px 25px
        rgba(42,169,162,.10);

    animation:
        iconFloat
        3s
        ease-in-out
        infinite;
}


.step-icon::before {

    content: "";

    position: absolute;

    inset: -4px;

    border-radius: 21px;

    border:
        1px solid
        rgba(42,169,162,.10);

    animation:
        iconRing
        2.5s
        ease-in-out
        infinite;
}


.step-icon svg {

    position: relative;

    z-index: 2;

    width: 28px;
    height: 28px;

    animation:
        iconRotate
        5s
        ease-in-out
        infinite;
}


.icon-glow {

    position: absolute;

    width: 20px;
    height: 20px;

    border-radius: 50%;

    background:
        rgba(101,214,208,.32);

    filter:
        blur(8px);

    animation:
        iconGlow
        2.5s
        ease-in-out
        infinite;
}


/* =========================================================
   STEP TEXT
========================================================= */

.step-card h3 {

    margin: 0 0 10px;

    font-size: 19px;

    font-weight: 700;

    color:
        #244e5a;

    animation:
        textLift
        4s
        ease-in-out
        infinite;
}


.step-card p {

    max-width: 230px;

    margin: auto;

    color:
        #587782;

    font-size: 14px;

    line-height: 1.8;
}


/* =========================================================
   STEP PULSE
========================================================= */

.step-pulse {

    position: absolute;

    left: 50%;
    top: 28px;

    width: 76px;
    height: 76px;

    margin-left: -38px;

    border-radius: 24px;

    border:
        1px solid
        rgba(42,169,162,.14);

    pointer-events: none;

    animation:
        stepPulse
        3s
        ease-out
        infinite;
}


.step-2 .step-pulse {
    animation-delay: .75s;
}

.step-3 .step-pulse {
    animation-delay: 1.5s;
}

.step-4 .step-pulse {
    animation-delay: 2.25s;
}


/* =========================================================
   CTA
========================================================= */

.cta-section {

    position: relative;

    padding: 120px 0;

    isolation: isolate;

    background:

        radial-gradient(
            circle at 12% 50%,
            rgba(101,214,208,.28),
            transparent 30%
        ),

        radial-gradient(
            circle at 88% 50%,
            rgba(78,195,190,.22),
            transparent 30%
        ),

        linear-gradient(
            110deg,
            #e3f8f6,
            #effcfb,
            #f9ffff
        );

    border-top:
        1px solid
        rgba(42,169,162,.06);
}


/* =========================================================
   CTA WAVE
========================================================= */

.cta-wave {

    position: absolute;

    left: -10%;
    bottom: -80px;

    width: 120%;
    height: 160px;

    border-radius: 50% 50% 0 0;

    background:
        rgba(255,255,255,.35);

    filter: blur(1px);

    animation:
        waveMove
        8s
        ease-in-out
        infinite;

    z-index: -1;
}


/* =========================================================
   CTA CONTENT
========================================================= */

.cta-content {

    animation:
        ctaFloat
        5s
        ease-in-out
        infinite;
}


/* =========================================================
   CTA BADGE
========================================================= */

.cta-badge {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 9px 19px;

    border-radius: 999px;

    background:
        rgba(255,255,255,.82);

    border:
        1px solid
        rgba(42,169,162,.13);

    color:
        #38636b;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 1px;

    box-shadow:
        0 10px 30px
        rgba(42,169,162,.08);

    backdrop-filter:
        blur(8px);

    animation:
        badgePulse
        3s
        ease-in-out
        infinite;
}


.cta-badge span {

    width: 9px;
    height: 9px;

    border-radius: 50%;

    background:
        #2aa9a2;

    box-shadow:
        0 0 14px
        rgba(42,169,162,.55);

    animation:
        dotPulse
        2s
        infinite;
}


/* =========================================================
   CTA TITLE
========================================================= */

.cta-section h2 {

    margin-top: 25px;

    font-size:
        clamp(40px,5vw,62px);

    font-weight: 800;

    letter-spacing: -2.5px;

    color:
        #244e5a;
}


.cta-section h2 span {

    display: inline-block;

    background:
        linear-gradient(
            90deg,
            #247c79,
            #2aa9a2,
            #65d6d0,
            #247c79
        );

    background-size: 300% auto;

    -webkit-background-clip: text;
    background-clip: text;

    color: transparent;

    animation:
        gradientMove
        4s
        linear
        infinite;
}


/* =========================================================
   CTA LINE
========================================================= */

.cta-line {

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 9px;

    margin: 22px auto;
}


.cta-line span {

    width: 65px;
    height: 4px;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            #2aa9a2,
            #8ae3de,
            #2aa9a2
        );

    background-size: 200%;

    animation:
        gradientMove
        3s
        linear
        infinite;
}


.cta-line i {

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background:
        #2aa9a2;

    box-shadow:
        0 0 14px
        rgba(42,169,162,.48);

    animation:
        dotPulse
        2s
        infinite;
}


/* =========================================================
   CTA DESCRIPTION
========================================================= */

.cta-section p {

    max-width: 650px;

    margin: auto;

    color:
        #587782;

    font-size: 18px;

    line-height: 1.8;
}


/* =========================================================
   CTA BUTTONS
========================================================= */

.cta-buttons {

    display: flex;

    justify-content: center;
    align-items: center;

    gap: 16px;

    margin-top: 35px;

    flex-wrap: wrap;
}


.cta-primary,
.cta-secondary {

    position: relative;

    overflow: hidden;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 10px;

    min-width: 165px;

    padding: 15px 25px;

    border-radius: 14px;

    text-decoration: none;

    font-weight: 700;

    transition:
        transform .35s ease,
        box-shadow .35s ease;
}


/* PRIMARY */

.cta-primary {

    color: white;

    background:
        linear-gradient(
            135deg,
            #247c79,
            #2aa9a2,
            #4ccbc4
        );

    background-size: 200% 200%;

    box-shadow:
        0 12px 30px
        rgba(42,169,162,.24);

    animation:
        buttonGradient
        5s
        ease
        infinite;
}


/* SECONDARY */

.cta-secondary {

    color:
        #247c79;

    background:
        rgba(255,255,255,.84);

    border:
        1px solid
        rgba(42,169,162,.22);

    box-shadow:
        0 10px 25px
        rgba(42,169,162,.08);

    animation:
        secondaryBreath
        4s
        ease-in-out
        infinite;
}


.cta-primary svg,
.cta-secondary svg {

    width: 19px;
    height: 19px;

    transition:
        transform .3s ease;
}


.button-shine {

    position: absolute;

    top: -50%;
    left: -120%;

    width: 60%;
    height: 200%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.48),
            transparent
        );

    transform: rotate(20deg);

    animation:
        buttonShine
        4.5s
        ease-in-out
        infinite;

    pointer-events: none;
}


.cta-primary:hover,
.cta-secondary:hover {

    transform:
        translateY(-7px)
        scale(1.03);
}


.cta-primary:hover svg,
.cta-secondary:hover svg {

    transform:
        translateX(5px);
}


.cta-primary:hover {

    box-shadow:
        0 20px 45px
        rgba(42,169,162,.32);
}


/* =========================================================
   CTA ORBS
========================================================= */

.cta-orb {

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    filter: blur(1px);
}


.cta-orb-1 {

    width: 270px;
    height: 270px;

    left: -100px;
    top: 20px;

    background:
        rgba(101,214,208,.15);

    animation:
        orbFloat
        9s
        ease-in-out
        infinite;
}


.cta-orb-2 {

    width: 200px;
    height: 200px;

    right: -60px;
    bottom: 20px;

    background:
        rgba(42,169,162,.12);

    animation:
        orbFloatReverse
        7s
        ease-in-out
        infinite;
}


.cta-orb-3 {

    width: 85px;
    height: 85px;

    left: 20%;
    bottom: 20px;

    background:
        rgba(188,239,235,.30);

    animation:
        orbSmallFloat
        5s
        ease-in-out
        infinite;
}


.cta-orb-4 {

    width: 55px;
    height: 55px;

    right: 25%;
    top: 20px;

    background:
        rgba(101,214,208,.15);

    animation:
        orbSmallFloatReverse
        4s
        ease-in-out
        infinite;
}


/* =========================================================
   CTA DOTS
========================================================= */

.cta-dot {

    position: absolute;

    width: 10px;
    height: 10px;

    border-radius: 50%;

    background:
        rgba(42,169,162,.32);

    box-shadow:
        0 0 15px
        rgba(42,169,162,.18);

    pointer-events: none;
}


.cta-dot-1 {
    left: 20%;
    top: 20%;
    animation: dotPathOne 5s infinite;
}

.cta-dot-2 {
    right: 20%;
    top: 25%;
    animation: dotPathTwo 7s infinite reverse;
}

.cta-dot-3 {
    left: 30%;
    bottom: 20%;
    animation: dotPathThree 6s infinite;
}

.cta-dot-4 {
    right: 30%;
    bottom: 15%;
    animation: dotPathFour 4s infinite reverse;
}

.cta-dot-5 {
    left: 50%;
    top: 15%;
    width: 6px;
    height: 6px;
    animation: dotPathFive 5s infinite;
}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes stepFloat {

    0%, 100% {
        transform: translateY(0);
    }

    25% {
        transform: translateY(-5px);
    }

    50% {
        transform: translateY(-13px);
    }

    75% {
        transform: translateY(-4px);
    }
}


@keyframes numberBounce {

    0%, 100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    25% {
        transform:
            translateY(-4px)
            rotate(-2deg);
    }

    50% {
        transform:
            translateY(-8px)
            rotate(2deg);
    }

    75% {
        transform:
            translateY(-3px)
            rotate(-1deg);
    }
}


@keyframes numberScale {

    0%, 100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.08);
    }
}


@keyframes iconFloat {

    0%, 100% {
        transform:
            translateY(0)
            rotate(0deg);
    }

    25% {
        transform:
            translateY(-4px)
            rotate(-3deg);
    }

    50% {
        transform:
            translateY(-8px)
            rotate(3deg);
    }

    75% {
        transform:
            translateY(-3px)
            rotate(-1deg);
    }
}


@keyframes iconRotate {

    0%, 100% {
        transform:
            rotate(0deg)
            scale(1);
    }

    50% {
        transform:
            rotate(3deg)
            scale(1.08);
    }
}


@keyframes iconGlow {

    0%, 100% {
        opacity: .35;
        transform: scale(.8);
    }

    50% {
        opacity: .90;
        transform: scale(1.35);
    }
}


@keyframes iconRing {

    0%, 100% {
        opacity: .25;
        transform: scale(1);
    }

    50% {
        opacity: .80;
        transform: scale(1.12);
    }
}


@keyframes stepPulse {

    0% {
        opacity: 0;
        transform: scale(.8);
    }

    35% {
        opacity: .5;
    }

    100% {
        opacity: 0;
        transform: scale(1.35);
    }
}


@keyframes tinyOrbit {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    25% {
        transform:
            translate(4px,-3px)
            scale(1.1);
    }

    50% {
        transform:
            translate(0,-5px)
            scale(.85);
    }

    75% {
        transform:
            translate(-4px,-2px)
            scale(1.1);
    }
}


@keyframes orbitRotate {

    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}


@keyframes lineTravel {

    0% {
        left: -20%;
    }

    100% {
        left: 110%;
    }
}


@keyframes lineGlow {

    0%, 100% {
        opacity: .25;
    }

    50% {
        opacity: .85;
    }
}


@keyframes textLift {

    0%, 100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-2px);
    }
}


@keyframes headerFloat {

    0%, 100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-5px);
    }
}


@keyframes ctaFloat {

    0%, 100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-7px);
    }
}


@keyframes badgePulse {

    0%, 100% {

        transform: translateY(0);

        box-shadow:
            0 8px 25px
            rgba(42,169,162,.06);
    }

    50% {

        transform: translateY(-4px);

        box-shadow:
            0 15px 35px
            rgba(42,169,162,.13);
    }
}


@keyframes dotPulse {

    0%, 100% {
        opacity: .55;
        transform: scale(1);
    }

    50% {
        opacity: 1;
        transform: scale(1.4);
    }
}


@keyframes ringPulse {

    0%, 100% {
        opacity: .20;
        transform: scale(1);
    }

    50% {
        opacity: .75;
        transform: scale(1.1);
    }
}


@keyframes gradientMove {

    0% {
        background-position: 0% 50%;
    }

    100% {
        background-position: 300% 50%;
    }
}


@keyframes buttonGradient {

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


@keyframes buttonShine {

    0% {
        left: -120%;
    }

    35% {
        left: 140%;
    }

    100% {
        left: 140%;
    }
}


@keyframes secondaryBreath {

    0%, 100% {

        box-shadow:
            0 10px 25px
            rgba(42,169,162,.06);
    }

    50% {

        box-shadow:
            0 15px 35px
            rgba(42,169,162,.13);
    }
}


@keyframes blobFloatOne {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1)
            rotate(0deg);
    }

    50% {
        transform:
            translate(45px,-30px)
            scale(1.1)
            rotate(12deg);
    }
}


@keyframes blobFloatTwo {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(-40px,-35px)
            scale(1.14);
    }
}


@keyframes blobFloatThree {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(35px,25px)
            scale(1.12);
    }
}


@keyframes blobFloatFour {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-20px,-30px);
    }
}


@keyframes ringRotate {

    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}


@keyframes ringRotateReverse {

    from {
        transform: rotate(360deg);
    }

    to {
        transform: rotate(0deg);
    }
}


/* =========================================================
   PARTICLE PATHS
========================================================= */

@keyframes dotPathOne {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    25% {
        transform:
            translate(12px,-18px)
            scale(1.15);
    }

    50% {
        transform:
            translate(-5px,-34px)
            scale(.9);
    }

    75% {
        transform:
            translate(-15px,-12px)
            scale(1.08);
    }
}


@keyframes dotPathTwo {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-25px,30px);
    }
}


@keyframes dotPathThree {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(25px,-25px)
            scale(1.3);
    }
}


@keyframes dotPathFour {

    0%, 100% {
        transform:
            translate(0,0);
    }

    25% {
        transform:
            translate(-15px,-10px);
    }

    50% {
        transform:
            translate(-30px,-35px);
    }

    75% {
        transform:
            translate(-10px,-50px);
    }
}


@keyframes dotPathFive {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(18px,-20px);
    }
}


@keyframes dotPathSix {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-20px,15px);
    }
}


@keyframes dotPathSeven {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(20px,20px)
            scale(1.4);
    }
}


@keyframes dotPathEight {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-25px,-18px);
    }
}


/* =========================================================
   CTA ORB ANIMATION
========================================================= */

@keyframes orbFloat {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(40px,-35px)
            scale(1.1);
    }
}


@keyframes orbFloatReverse {

    0%, 100% {
        transform:
            translate(0,0)
            scale(1);
    }

    50% {
        transform:
            translate(-35px,-30px)
            scale(1.12);
    }
}


@keyframes orbSmallFloat {

    0%, 100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-28px);
    }
}


@keyframes orbSmallFloatReverse {

    0%, 100% {
        transform:
            translate(0,0);
    }

    50% {
        transform:
            translate(-20px,25px);
    }
}


@keyframes waveMove {

    0%, 100% {
        transform:
            translateX(0)
            scaleX(1);
    }

    50% {
        transform:
            translateX(35px)
            scaleX(1.03);
    }
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .how-it-works-section {
        padding: 90px 0 100px;
    }

    .how-header {
        margin-bottom: 60px;
    }

    .steps-wrapper {
        gap: 25px;
    }

    .steps-line {
        left: 8%;
        right: 8%;
    }

    .step-card {
        padding-left: 5px;
        padding-right: 5px;
    }

    .step-card p {
        font-size: 13px;
    }

    .cta-section {
        padding: 100px 0;
    }
}


/* =========================================================
   MOBILE TABLET
========================================================= */

@media (max-width: 768px) {

    .how-it-works-section {
        padding: 80px 0;
    }

    .how-header {
        margin-bottom: 55px;
    }

    .how-title {
        font-size: 44px;
    }

    .steps-wrapper {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 60px 20px;
    }

    .steps-line {
        display: none;
    }

    .step-orbit {
        display: none;
    }

    .step-number {

        width: 68px;
        height: 68px;
    }

    .step-pulse {

        width: 68px;
        height: 68px;

        margin-left: -34px;

        top: 26px;
    }

    .cta-section {
        padding: 85px 0;
    }

    .cta-section h2 {
        font-size: 44px;
    }
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .how-it-works-section {
        padding: 70px 0;
    }

    .section-badge {

        font-size: 11px;

        padding: 9px 15px;
    }

    .how-title {

        font-size: 38px;

        letter-spacing: -1.8px;
    }

    .how-subtitle {
        font-size: 16px;
    }

    .steps-wrapper {

        grid-template-columns: 1fr;

        gap: 55px;
    }

    .step-card p {

        max-width: 280px;

        font-size: 14px;
    }

    .cta-section {
        padding: 75px 0;
    }

    .cta-section h2 {
        font-size: 38px;
    }

    .cta-section p {
        font-size: 16px;
    }

    .cta-buttons {
        flex-direction: column;
    }

    .cta-primary,
    .cta-secondary {

        width: 100%;

        max-width: 280px;
    }

    .how-ring {
        opacity: .5;
    }
}


/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .how-it-works-section *,
    .how-it-works-section *::before,
    .how-it-works-section *::after,
    .cta-section *,
    .cta-section *::before,
    .cta-section *::after {

        animation-duration:
            .01ms !important;

        animation-iteration-count:
            1 !important;

        scroll-behavior:
            auto !important;
    }
}

</style>



{{-- =========================================================
    LEAFLET / QGIS SCRIPT
========================================================= --}}
@section('scripts')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

    let qgisMap = null;

    let geoLayer = null;


    // =====================================================
    // INITIALIZE MAP
    // =====================================================

    function initQGISMap() {

        if (qgisMap) return;


        const mapElement =
            document.getElementById('qgis-map');


        if (!mapElement) return;


        qgisMap = L.map(
            'qgis-map',
            {

                center:
                    [-8.0, 113.8],

                zoom:
                    8,

                scrollWheelZoom:
                    true

            }
        );


        // =================================================
        // OPEN STREET MAP
        // =================================================

        L.tileLayer(

            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

            {

                maxZoom:
                    18,

                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">' +
                    'OpenStreetMap</a> contributors'

            }

        ).addTo(qgisMap);


        setTimeout(

            function () {

                qgisMap.invalidateSize();

            },

            300

        );

    }



    // =====================================================
    // LOAD QGIS DATA
    // =====================================================

    function loadQGISData() {

        initQGISMap();


        if (!qgisMap) {

            console.error(
                'Elemen #qgis-map tidak ditemukan.'
            );

            return;

        }


        const geoJsonPath =
            '/maps/bakorwil.geojson';


        fetch(geoJsonPath)

            .then(

                function (res) {

                    if (!res.ok) {

                        throw new Error(
                            'File GeoJSON belum tersedia'
                        );

                    }

                    return res.json();

                }

            )

            .then(

                function (data) {

                    // Hapus layer lama

                    if (geoLayer) {

                        qgisMap.removeLayer(
                            geoLayer
                        );

                    }


                    // Buat GeoJSON

                    geoLayer =
                        L.geoJSON(

                            data,

                            {

                                style: {

                                    color:
                                        '#ffffff',

                                    weight:
                                        2,

                                    fillColor:
                                        '#2aa9a2',

                                    fillOpacity:
                                        0.58

                                },


                                onEachFeature:

                                    function (
                                        feature,
                                        layer
                                    ) {

                                        const props =
                                            feature.properties || {};


                                        const name =
                                            props.NAME ||
                                            props.name ||
                                            'Wilayah';


                                        const type =
                                            props.TYPE ||
                                            props.type ||
                                            '';


                                        layer.bindPopup(

                                            `<strong>
                                                ${name}
                                            </strong>

                                            ${
                                                type
                                                ? '<br><small>' +
                                                  type +
                                                  '</small>'
                                                : ''
                                            }`

                                        );


                                        // =================================
                                        // HOVER
                                        // =================================

                                        layer.on(

                                            'mouseover',

                                            function () {

                                                layer.setStyle({

                                                    fillColor:
                                                        '#f3b64b',

                                                    fillOpacity:
                                                        0.82,

                                                    weight:
                                                        3

                                                });

                                            }

                                        );


                                        layer.on(

                                            'mouseout',

                                            function () {

                                                geoLayer.resetStyle(
                                                    layer
                                                );

                                            }

                                        );


                                        // =================================
                                        // CLICK
                                        // =================================

                                        layer.on(

                                            'click',

                                            function () {

                                                const nameElement =
                                                    document.getElementById(
                                                        'qgis-info-name'
                                                    );


                                                const typeElement =
                                                    document.getElementById(
                                                        'qgis-info-type'
                                                    );


                                                const descElement =
                                                    document.getElementById(
                                                        'qgis-info-desc'
                                                    );


                                                const infoElement =
                                                    document.getElementById(
                                                        'qgis-info'
                                                    );


                                                if (nameElement) {

                                                    nameElement.textContent =
                                                        name;

                                                }


                                                if (typeElement) {

                                                    typeElement.textContent =
                                                        type;

                                                }


                                                if (descElement) {

                                                    descElement.textContent =
                                                        props.DESCRIPTION ||
                                                        props.desc ||
                                                        'Detail wilayah belum tersedia.';

                                                }


                                                if (infoElement) {

                                                    infoElement.classList.remove(
                                                        'hidden'
                                                    );

                                                }

                                            }

                                        );

                                    }

                            }

                        ).addTo(qgisMap);


                    // =============================================
                    // SESUAIKAN POSISI MAP
                    // =============================================

                    if (
                        geoLayer.getBounds().isValid()
                    ) {

                        qgisMap.fitBounds(
                            geoLayer.getBounds()
                        );

                    }


                    // =============================================
                    // HILANGKAN PLACEHOLDER
                    // =============================================

                    const placeholder =
                        document.getElementById(
                            'gis-placeholder'
                        );


                    if (placeholder) {

                        placeholder.style.display =
                            'none';

                    }

                }

            )


            .catch(

                function (err) {

                    console.error(
                        'Gagal memuat peta:',
                        err
                    );


                    alert(

                        'Gagal memuat peta: ' +
                        err.message +
                        '\n\n' +
                        'Tempatkan file GeoJSON hasil ekspor QGIS di:' +
                        '\npublic/maps/bakorwil.geojson'

                    );

                }

            );

    }

</script>

@endsection