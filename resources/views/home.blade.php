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
     HERO SECTION — EJSC BAKORWIL
     VERSION REVISED — STAT CARD HOVER FIX
========================================================= -->

<section class="ejsc-hero">

    <!-- ================= BACKGROUND ================= -->

    <div class="ejsc-bg-shape ejsc-bg-shape-1"></div>
    <div class="ejsc-bg-shape ejsc-bg-shape-2"></div>
    <div class="ejsc-bg-shape ejsc-bg-shape-3"></div>

    <div class="ejsc-floating-dot ejsc-dot-1"></div>
    <div class="ejsc-floating-dot ejsc-dot-2"></div>
    <div class="ejsc-floating-dot ejsc-dot-3"></div>
    <div class="ejsc-floating-dot ejsc-dot-4"></div>
    <div class="ejsc-floating-dot ejsc-dot-5"></div>


    <!-- ================= MAIN ================= -->

    <div class="ejsc-hero-container">

        <!-- ================= LEFT ================= -->

        <div class="ejsc-hero-left">

            <div class="ejsc-badge">
                <span>Platform Resmi EJSC Bakorwil</span>
            </div>

            <h1 class="ejsc-title">
                Menghubungkan
                <span>Mentor, Talenta &amp;</span>
                Client
            </h1>

            <p class="ejsc-description">
                Platform terpercaya untuk menemukan mentor berpengalaman,
                mengembangkan talenta terbaik, dan menghubungkan dengan
                client yang tepat.
            </p>

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


        <!-- ================= RIGHT ================= -->

        <div class="ejsc-hero-right">


            <!-- ================= STAT CARD ================= -->

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
                            <div class="ejsc-stat-number">150+</div>
                            <div class="ejsc-stat-label">Mentor</div>
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
                            <div class="ejsc-stat-number">500+</div>
                            <div class="ejsc-stat-label">Talenta</div>
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
                            <div class="ejsc-stat-number">80+</div>
                            <div class="ejsc-stat-label">Client</div>
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
                            <div class="ejsc-stat-number">98%</div>
                            <div class="ejsc-stat-label">Kepuasan</div>
                        </div>

                    </div>

                </div>

            </div>


            <!-- ================= ILLUSTRATION ================= -->

            <div class="ejsc-illustration">

                <div class="ejsc-illustration-glow"></div>


                <!-- ================= BOOKS ================= -->

                <div class="ejsc-books">

                    <div class="ejsc-book book-1"></div>
                    <div class="ejsc-book book-2"></div>
                    <div class="ejsc-book book-3"></div>

                </div>


                <!-- ================= PLANT ================= -->

                <div class="ejsc-plant">

                    <div class="ejsc-plant-stem stem-main"></div>
                    <div class="ejsc-plant-stem stem-left"></div>
                    <div class="ejsc-plant-stem stem-right"></div>

                    <div class="ejsc-leaf leaf-1">
                        <span></span>
                    </div>

                    <div class="ejsc-leaf leaf-2">
                        <span></span>
                    </div>

                    <div class="ejsc-leaf leaf-3">
                        <span></span>
                    </div>

                    <div class="ejsc-leaf leaf-4">
                        <span></span>
                    </div>

                    <div class="ejsc-leaf leaf-5">
                        <span></span>
                    </div>

                    <div class="ejsc-pot">
                        <div class="ejsc-pot-rim"></div>
                        <div class="ejsc-pot-shadow"></div>
                    </div>

                </div>


                <!-- ================= LAPTOP ================= -->

                <div class="ejsc-laptop">

                    <div class="ejsc-laptop-screen">

                        <div class="ejsc-camera"></div>

                        <div class="ejsc-screen-content">

                            <div class="ejsc-screen-top">

                                <div class="ejsc-screen-logo">
                                    EJSC
                                </div>

                                <div class="ejsc-screen-dot"></div>

                            </div>

                            <div class="ejsc-screen-line"></div>
                            <div class="ejsc-screen-line small"></div>

                            <div class="ejsc-mini-cards">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                            <div class="ejsc-chart">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                        </div>

                    </div>

                    <div class="ejsc-laptop-base">
                        <div class="ejsc-trackpad"></div>
                    </div>

                    <div class="ejsc-laptop-bottom-glow"></div>

                </div>


                <!-- ================= ARROW ================= -->

                <svg
                    class="ejsc-curved-arrow"
                    viewBox="0 0 300 190"
                    fill="none"
                >

                    <path
                        class="ejsc-arrow-path"
                        d="M30 150
                           C105 168,
                           205 142,
                           195 77
                           C190 49,
                           215 30,
                           258 37"
                        stroke="#11c5d0"
                        stroke-width="7"
                        stroke-linecap="round"
                    />

                    <path
                        d="M248 24L270 37L251 55"
                        stroke="#11c5d0"
                        stroke-width="7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </div>

        </div>

    </div>


    <!-- ================= FEATURE BAR ================= -->

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


<style>

/* =========================================================
   RESET
========================================================= */

.ejsc-hero,
.ejsc-hero * {
    box-sizing: border-box;
}

.ejsc-hero a {
    text-decoration: none;
}

.ejsc-hero {
    position: relative;
    width: 100%;
    min-height: 1530px;
    overflow: hidden;
    color: #102f4a;

    background:
        radial-gradient(
            circle at 2% 8%,
            rgba(0,221,229,.28),
            transparent 20%
        ),
        radial-gradient(
            circle at 96% 18%,
            rgba(100,222,230,.25),
            transparent 24%
        ),
        radial-gradient(
            circle at 73% 61%,
            rgba(47,211,220,.17),
            transparent 25%
        ),
        radial-gradient(
            circle at 15% 78%,
            rgba(107,226,232,.16),
            transparent 25%
        ),
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f8fdfe 38%,
            #f1fbfc 70%,
            #e9fafd 100%
        );
}


/* =========================================================
   BACKGROUND BLOBS
========================================================= */

.ejsc-bg-shape {
    position: absolute;
    pointer-events: none;
    z-index: 0;
    will-change: transform;
}

.ejsc-bg-shape-1 {
    width: 390px;
    height: 300px;
    left: -170px;
    top: -120px;
    border-radius: 45% 55% 60% 40%;

    background:
        radial-gradient(
            ellipse at center,
            #13d7dc 0%,
            #27cbd5 35%,
            rgba(62,215,221,.55) 65%,
            rgba(62,215,221,0) 100%
        );

    filter: blur(2px);
    opacity: .95;

    animation:
        ejscBlobOne 8s ease-in-out infinite;
}

.ejsc-bg-shape-2 {
    width: 420px;
    height: 270px;
    right: -145px;
    top: 45px;
    border-radius: 60% 35% 60% 40%;

    background:
        linear-gradient(
            135deg,
            rgba(183,243,247,.20),
            rgba(54,211,220,.40)
        );

    filter: blur(1px);
    opacity: .9;

    animation:
        ejscBlobTwo 9s ease-in-out infinite;
}

.ejsc-bg-shape-3 {
    width: 600px;
    height: 300px;
    right: -220px;
    bottom: 250px;
    border-radius: 50%;

    background:
        radial-gradient(
            ellipse at center,
            rgba(28,216,222,.30),
            rgba(80,222,228,.12) 55%,
            transparent 72%
        );

    filter: blur(12px);

    animation:
        ejscBlobThree 8s ease-in-out infinite;
}

@keyframes ejscBlobOne {
    0%,100% {
        transform:
            translate3d(0,0,0)
            rotate(-18deg)
            scale(1);
    }

    50% {
        transform:
            translate3d(30px,25px,0)
            rotate(-10deg)
            scale(1.08);
    }
}

@keyframes ejscBlobTwo {
    0%,100% {
        transform:
            translate3d(0,0,0)
            rotate(-25deg)
            scale(1);
    }

    50% {
        transform:
            translate3d(-30px,30px,0)
            rotate(-18deg)
            scale(1.07);
    }
}

@keyframes ejscBlobThree {
    0%,100% {
        transform:
            translate3d(0,0,0)
            scale(1);
    }

    50% {
        transform:
            translate3d(-35px,-25px,0)
            scale(1.12);
    }
}


/* =========================================================
   FLOATING DOTS
========================================================= */

.ejsc-floating-dot {
    position: absolute;
    border-radius: 50%;
    z-index: 1;

    background:
        radial-gradient(
            circle at 30% 25%,
            #b8fbfc,
            #18cbd3 55%,
            #08aebc 100%
        );

    box-shadow:
        0 0 0 4px rgba(14,201,210,.07),
        0 5px 16px rgba(11,192,202,.22);

    pointer-events: none;

    animation:
        ejscDotFloat 5s ease-in-out infinite;
}

.ejsc-dot-1 {
    width: 9px;
    height: 9px;
    left: 37%;
    top: 4%;
}

.ejsc-dot-2 {
    width: 15px;
    height: 15px;
    left: 52%;
    top: 8%;
    animation-delay: .8s;
}

.ejsc-dot-3 {
    width: 10px;
    height: 10px;
    right: 16%;
    top: 7%;
    animation-delay: 1.4s;
}

.ejsc-dot-4 {
    width: 13px;
    height: 13px;
    right: 8%;
    bottom: 29%;
    animation-delay: 2s;
}

.ejsc-dot-5 {
    width: 13px;
    height: 13px;
    left: 6%;
    bottom: 34%;
    animation-delay: 2.6s;
}

@keyframes ejscDotFloat {
    0%,100% {
        transform:
            translate3d(0,0,0)
            scale(1);
        opacity: .8;
    }

    50% {
        transform:
            translate3d(12px,-20px,0)
            scale(1.22);
        opacity: 1;
    }
}


/* =========================================================
   MAIN CONTAINER
========================================================= */

.ejsc-hero-container {
    position: relative;
    z-index: 5;

    width:
        min(940px, calc(100% - 90px));

    min-height: 1080px;

    margin: 0 auto;

    padding-top: 280px;
    padding-bottom: 360px;

    display: grid;

    grid-template-columns:
        minmax(0,1.05fr)
        minmax(0,.95fr);

    gap: 48px;

    align-items: start;
}


/* =========================================================
   LEFT CONTENT
========================================================= */

.ejsc-hero-left {
    padding-top: 27px;

    animation:
        ejscLeftFloat 6s ease-in-out infinite;
}

@keyframes ejscLeftFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-6px);
    }
}


/* =========================================================
   BADGE
========================================================= */

.ejsc-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;

    min-height: 43px;

    padding: 0 17px;

    margin-bottom: 42px;

    border: 1px solid #0fc9d3;
    border-radius: 13px;

    background: rgba(255,255,255,.72);

    color: #08aabb;

    font-size: 13px;
    font-weight: 700;

    box-shadow:
        0 8px 25px rgba(15,198,208,.06);

    animation:
        ejscBadgePulse 4s ease-in-out infinite;
}

.ejsc-badge-star {
    color: #0cc3ce;
    font-size: 23px;
    line-height: 1;

    animation:
        ejscStarSpin 5s ease-in-out infinite;
}

@keyframes ejscBadgePulse {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-3px);
    }
}

@keyframes ejscStarSpin {
    0%,80%,100% {
        transform: rotate(0deg) scale(1);
    }

    90% {
        transform: rotate(15deg) scale(1.12);
    }
}


/* =========================================================
   TITLE
========================================================= */

.ejsc-title {
    margin: 0 0 29px;

    max-width: 500px;

    font-family:
        "Inter",
        "Poppins",
        Arial,
        sans-serif;

    font-size:
        clamp(48px,5.2vw,58px);

    line-height: 1.18;
    letter-spacing: -2.6px;
    font-weight: 800;

    color: #102f4a;

    animation:
        ejscTitleFloat 5s ease-in-out infinite;
}

.ejsc-title span {
    display: block;

    color: #10b9c5;

    background:
        linear-gradient(
            110deg,
            #08aeba 0%,
            #13c7d0 35%,
            #ffffff 48%,
            #ffffff 52%,
            #13c7d0 65%,
            #09afbb 100%
        );

    background-size: 250% 100%;
    background-position: 200% 0;

    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;

    animation: ejscTextShimmer 4s ease-in-out infinite;
}

@keyframes ejscTextShimmer {

    0% {
        background-position: 200% 0;
    }

    35% {
        background-position: -20% 0;
    }

    100% {
        background-position: -20% 0;
    }
}

@keyframes ejscTitleFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-4px);
    }
}


/* =========================================================
   DESCRIPTION
========================================================= */

.ejsc-description {
    max-width: 485px;

    margin: 0 0 44px;

    color: #4d6b87;

    font-size: 15.5px;
    line-height: 2;
    font-weight: 400;
}


/* =========================================================
   BUTTONS
========================================================= */

.ejsc-buttons {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.ejsc-btn-primary,
.ejsc-btn-secondary {
    height: 57px;
    padding: 0 28px;

    border-radius: 12px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    font-size: 15px;
    font-weight: 700;

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        background .3s ease;
}

.ejsc-btn-primary {
    min-width: 188px;
    gap: 16px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #11c1cc,
            #06aeb9
        );

    box-shadow:
        0 13px 28px
        rgba(7,187,199,.25);

    animation:
        ejscButtonFloat 4s ease-in-out infinite;
}

.ejsc-btn-primary:hover {
    transform: translateY(-6px);

    box-shadow:
        0 20px 38px
        rgba(7,187,199,.34);
}

.ejsc-btn-primary svg {
    width: 22px;
    height: 22px;

    animation:
        ejscArrowButton 1.8s ease-in-out infinite;
}

@keyframes ejscButtonFloat {
    0%,100% {
        box-shadow:
            0 13px 28px
            rgba(7,187,199,.25);
    }

    50% {
        box-shadow:
            0 18px 34px
            rgba(7,187,199,.34);
    }
}

@keyframes ejscArrowButton {
    0%,100% {
        transform: translateX(0);
    }

    50% {
        transform: translateX(5px);
    }
}

.ejsc-btn-secondary {
    min-width: 168px;

    color: #087f91;

    background: rgba(255,255,255,.90);

    border: 1px solid #08bdca;
}

.ejsc-btn-secondary:hover {
    transform: translateY(-6px);

    color: #fff;
    background: #10b9c5;

    box-shadow:
        0 15px 30px
        rgba(8,185,198,.20);
}


/* =========================================================
   RIGHT
========================================================= */

.ejsc-hero-right {
    position: relative;

    min-height: 680px;

    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
}


/* =========================================================
   STAT CARD — FLOAT + HOVER
========================================================= */

.ejsc-stat-card {
    position: relative;
    z-index: 10;

    width: 100%;
    max-width: 420px;

    padding: 34px 31px 32px;

    border: 1px solid rgba(220,238,241,.95);
    border-radius: 26px;

    background: rgba(255,255,255,.96);

    box-shadow:
        0 25px 65px rgba(44,93,117,.10),
        0 5px 18px rgba(0,180,194,.05);

    animation:
        ejscCardFloat 5s ease-in-out infinite;

    transition:
        transform .35s ease,
        box-shadow .35s ease,
        filter .35s ease;
}


/* =========================================================
   CARD FLOAT
========================================================= */

@keyframes ejscCardFloat {

    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-8px);
    }
}


/* =========================================================
   CARD HOVER
========================================================= */

.ejsc-stat-card:hover {

    transform: translateY(-16px);

    box-shadow:
        0 38px 80px rgba(44,93,117,.16),
        0 12px 30px rgba(0,180,194,.12);

    filter: brightness(1.015);

    animation-play-state: paused;
}


/* =========================================================
   STAT HEADER
========================================================= */

.ejsc-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 34px;
}

.ejsc-stat-header h3 {
    margin: 0;

    color: #102d49;

    font-size: 16px;
    font-weight: 800;
}

.ejsc-live {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    color: #365873;

    font-size: 11px;
}

.ejsc-live span {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #12c6d0;

    box-shadow:
        0 0 0 4px
        rgba(18,198,208,.10);

    animation:
        ejscLivePulse 1.5s ease-in-out infinite;
}

@keyframes ejscLivePulse {
    0%,100% {
        transform: scale(1);
        opacity: 1;
    }

    50% {
        transform: scale(1.45);
        opacity: .6;
    }
}


/* =========================================================
   STAT GRID
========================================================= */

.ejsc-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 13px;
}

.ejsc-stat-box {
    min-height: 108px;
    padding: 17px;

    display: flex;
    align-items: center;
    gap: 16px;

    border: 1px solid #dcecf0;
    border-radius: 12px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #fbfeff
        );

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;

    animation:
        ejscStatBoxFloat 5s ease-in-out infinite;
}

.ejsc-stat-box:nth-child(2) {
    animation-delay: .3s;
}

.ejsc-stat-box:nth-child(3) {
    animation-delay: .6s;
}

.ejsc-stat-box:nth-child(4) {
    animation-delay: .9s;
}

@keyframes ejscStatBoxFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-3px);
    }
}

.ejsc-stat-box:hover {
    transform: translateY(-7px);

    border-color: #8bdfe5;

    box-shadow:
        0 13px 28px
        rgba(22,177,188,.10);
}


/* =========================================================
   STAT ICON
========================================================= */

.ejsc-stat-icon {
    flex: 0 0 48px;

    width: 48px;
    height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #0cbac5;
}

.ejsc-stat-icon svg {
    width: 42px;
    height: 42px;

    animation:
        ejscIconFloat 4s ease-in-out infinite;
}

@keyframes ejscIconFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-3px);
    }
}


/* =========================================================
   STAT NUMBER
========================================================= */

.ejsc-stat-number {
    margin-bottom: 7px;

    color: #0bb2bf;

    font-size: 26px;
    line-height: 1;
    font-weight: 800;
}

.ejsc-stat-label {
    color: #385a75;
    font-size: 13px;
}


/* =========================================================
   ILLUSTRATION
========================================================= */

.ejsc-illustration {
    position: absolute;
    z-index: 4;

    width: 580px;
    height: 390px;

    right: -85px;
    bottom: -55px;

    pointer-events: none;
}


/* =========================================================
   GLOW
========================================================= */

.ejsc-illustration-glow {
    position: absolute;

    left: 25px;
    bottom: 0;

    width: 570px;
    height: 195px;

    border-radius: 50%;

    background:
        radial-gradient(
            ellipse at center,
            rgba(9,210,218,.48),
            rgba(18,209,217,.23) 45%,
            rgba(18,209,217,0) 75%
        );

    filter: blur(12px);

    animation:
        ejscGlowMotion 4s ease-in-out infinite;
}

@keyframes ejscGlowMotion {
    0%,100% {
        transform: scale(1);
        opacity: .72;
    }

    50% {
        transform: scale(1.09);
        opacity: 1;
    }
}


/* =========================================================
   LAPTOP
========================================================= */

.ejsc-laptop {
    position: absolute;

    right: 105px;
    bottom: 42px;

    width: 330px;
    height: 220px;

    transform: translateY(0);

    filter:
        drop-shadow(
            0 18px 15px
            rgba(18,96,115,.17)
        );

    animation:
        ejscLaptopFloat 4.8s ease-in-out infinite;

    transform-origin: center bottom;
}

@keyframes ejscLaptopFloat {

    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-13px);
    }
}


/* =========================================================
   LAPTOP SCREEN
========================================================= */

.ejsc-laptop-screen {
    position: absolute;

    left: 32px;
    top: 0;

    width: 270px;
    height: 170px;

    padding: 9px;

    border: 9px solid #12344d;
    border-bottom: 5px solid #0e2d45;

    border-radius:
        15px
        15px
        6px
        6px;

    background:
        linear-gradient(
            135deg,
            #17d2d5,
            #08afb9
        );

    box-shadow:
        inset 0 0 0 1px rgba(255,255,255,.20),
        0 10px 22px rgba(7,91,107,.24);

    overflow: hidden;
}

.ejsc-camera {
    position: absolute;

    top: -6px;
    left: 50%;

    width: 5px;
    height: 5px;

    transform: translateX(-50%);

    border-radius: 50%;

    background: #6b929e;
}

.ejsc-laptop-screen::after {
    content: "";

    position: absolute;

    top: -50%;
    left: -80%;

    width: 55%;
    height: 200%;

    transform: rotate(22deg);

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.16),
            transparent
        );

    animation:
        ejscScreenShine 5s ease-in-out infinite;
}

@keyframes ejscScreenShine {
    0%,65% {
        left: -80%;
    }

    100% {
        left: 160%;
    }
}


/* =========================================================
   SCREEN CONTENT
========================================================= */

.ejsc-screen-content {
    position: relative;
    z-index: 2;

    width: 100%;
    height: 100%;
}

.ejsc-screen-top {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin: 8px 10px 8px;
}

.ejsc-screen-logo {
    color: #fff;

    font-size: 23px;
    font-weight: 800;
    letter-spacing: -.5px;
}

.ejsc-screen-dot {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #bfffff;

    box-shadow:
        0 0 0 4px
        rgba(255,255,255,.12);

    animation:
        ejscScreenDot 1.6s ease-in-out infinite;
}

@keyframes ejscScreenDot {
    0%,100% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: .55;
        transform: scale(.7);
    }
}


/* =========================================================
   SCREEN LINES
========================================================= */

.ejsc-screen-line {
    width: 105px;
    height: 7px;

    margin: 6px 10px;

    border-radius: 99px;

    background: rgba(255,255,255,.78);
}

.ejsc-screen-line.small {
    width: 78px;
    opacity: .58;
}


/* =========================================================
   MINI CARDS
========================================================= */

.ejsc-mini-cards {
    display: flex;

    gap: 5px;

    margin:
        12px 10px 0;
}

.ejsc-mini-cards div {
    width: 29px;
    height: 18px;

    border-radius: 4px;

    background:
        rgba(255,255,255,.18);

    border:
        1px solid
        rgba(255,255,255,.15);

    animation:
        ejscMiniCardPulse 2.5s ease-in-out infinite;
}

.ejsc-mini-cards div:nth-child(2) {
    animation-delay: .3s;
}

.ejsc-mini-cards div:nth-child(3) {
    animation-delay: .6s;
}

@keyframes ejscMiniCardPulse {
    0%,100% {
        opacity: .55;
        transform: translateY(0);
    }

    50% {
        opacity: 1;
        transform: translateY(-2px);
    }
}


/* =========================================================
   CHART
========================================================= */

.ejsc-chart {
    position: absolute;

    right: 15px;
    bottom: 13px;

    width: 82px;
    height: 62px;

    display: flex;
    align-items: flex-end;
    justify-content: flex-end;

    gap: 5px;
}

.ejsc-chart span {
    display: block;

    width: 11px;

    border-radius:
        3px 3px 0 0;

    background: #fff;

    transform-origin: bottom;

    animation:
        ejscChartMotion 1.8s ease-in-out infinite;
}

.ejsc-chart span:nth-child(1) {
    height: 20px;
}

.ejsc-chart span:nth-child(2) {
    height: 31px;
    animation-delay: .15s;
}

.ejsc-chart span:nth-child(3) {
    height: 44px;
    animation-delay: .3s;
}

.ejsc-chart span:nth-child(4) {
    height: 53px;
    animation-delay: .45s;
}

.ejsc-chart span:nth-child(5) {
    height: 38px;
    animation-delay: .6s;
}

@keyframes ejscChartMotion {
    0%,100% {
        transform: scaleY(.75);
        opacity: .75;
    }

    50% {
        transform: scaleY(1);
        opacity: 1;
    }
}


/* =========================================================
   LAPTOP BASE
========================================================= */

.ejsc-laptop-base {
    position: absolute;

    left: 0;
    bottom: 0;

    width: 330px;
    height: 38px;

    border-radius:
        4px
        4px
        28px
        28px;

    background:
        linear-gradient(
            180deg,
            #ffffff,
            #cfecef
        );

    box-shadow:
        0 13px 20px
        rgba(31,111,127,.18);
}

.ejsc-trackpad {
    position: absolute;

    left: 132px;
    bottom: 10px;

    width: 68px;
    height: 11px;

    border: 1px solid #c0dfe3;
    border-radius: 5px;

    background: #e6f4f5;
}

.ejsc-laptop-bottom-glow {
    position: absolute;

    left: 70px;
    bottom: -5px;

    width: 190px;
    height: 12px;

    border-radius: 50%;

    background:
        rgba(9,190,201,.22);

    filter: blur(8px);

    animation:
        ejscLaptopGlow 4.8s ease-in-out infinite;
}

@keyframes ejscLaptopGlow {
    0%,100% {
        transform: scaleX(1);
        opacity: .5;
    }

    50% {
        transform: scaleX(.8);
        opacity: .25;
    }
}


/* =========================================================
   PLANT
========================================================= */

.ejsc-plant {
    position: absolute;

    left: 20px;
    bottom: 35px;

    width: 170px;
    height: 235px;

    transform-origin: bottom center;

    animation:
        ejscPlantSway 5s ease-in-out infinite;
}

@keyframes ejscPlantSway {
    0%,100% {
        transform: rotate(0deg);
    }

    50% {
        transform: rotate(1.8deg);
    }
}


/* =========================================================
   POT
========================================================= */

.ejsc-pot {
    position: absolute;

    left: 52px;
    bottom: 0;

    width: 76px;
    height: 73px;

    border-radius:
        9px
        9px
        23px
        23px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #d5edef
        );

    box-shadow:
        0 15px 20px
        rgba(28,111,126,.16);

    animation:
        ejscPotFloat 5s ease-in-out infinite;
}

.ejsc-pot-rim {
    position: absolute;

    top: -8px;
    left: 2px;

    width: 72px;
    height: 18px;

    border-radius: 50%;

    background:
        linear-gradient(
            180deg,
            #eaf8f9,
            #cce6e8
        );

    box-shadow:
        inset 0 -3px 4px
        rgba(45,130,137,.10);
}

.ejsc-pot-shadow {
    position: absolute;

    left: 13px;
    bottom: 11px;

    width: 50px;
    height: 9px;

    border-radius: 50%;

    background:
        rgba(52,129,137,.09);

    filter: blur(4px);
}

@keyframes ejscPotFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-2px);
    }
}


/* =========================================================
   PLANT STEMS
========================================================= */

.ejsc-plant-stem {
    position: absolute;

    width: 5px;

    border-radius: 99px;

    background:
        linear-gradient(
            90deg,
            #238f91,
            #20c3b3
        );

    transform-origin: bottom center;
}

.stem-main {
    left: 87px;
    bottom: 61px;
    height: 143px;
    transform: rotate(1deg);
}

.stem-left {
    left: 72px;
    bottom: 64px;
    height: 103px;
    transform: rotate(-22deg);
}

.stem-right {
    left: 94px;
    bottom: 63px;
    height: 116px;
    transform: rotate(24deg);
}


/* =========================================================
   MONSTERA LEAVES
========================================================= */

.ejsc-leaf {
    position: absolute;

    width: 72px;
    height: 48px;

    border-radius:
        85%
        15%
        85%
        15%;

    background:
        linear-gradient(
            135deg,
            #31d0b9 0%,
            #12b09f 55%,
            #078e8c 100%
        );

    box-shadow:
        inset -6px -6px 12px
        rgba(0,90,93,.13),

        0 5px 10px
        rgba(17,130,130,.10);

    transform-origin: bottom right;

    overflow: hidden;
}

.ejsc-leaf::before {
    content: "";

    position: absolute;

    left: 8px;
    bottom: 10px;

    width: 58px;
    height: 2px;

    border-radius: 99px;

    background:
        rgba(220,255,248,.35);

    transform: rotate(-22deg);
}

.ejsc-leaf span {
    position: absolute;

    width: 8px;
    height: 22px;

    border-radius: 50%;

    background:
        rgba(232,255,249,.20);

    transform: rotate(25deg);
}

.leaf-1 {
    left: 76px;
    bottom: 157px;

    transform:
        rotate(-35deg)
        scale(1.05);

    animation:
        ejscLeafOne 4s ease-in-out infinite;
}

.leaf-2 {
    left: 10px;
    bottom: 128px;

    transform:
        rotate(27deg)
        scale(.96);

    animation:
        ejscLeafTwo 4.4s ease-in-out infinite;
}

.leaf-3 {
    left: 78px;
    bottom: 103px;

    transform:
        rotate(-59deg)
        scale(.86);

    animation:
        ejscLeafThree 3.8s ease-in-out infinite;
}

.leaf-4 {
    left: 18px;
    bottom: 171px;

    transform:
        rotate(9deg)
        scale(.76);

    animation:
        ejscLeafFour 4.2s ease-in-out infinite;
}

.leaf-5 {
    left: 98px;
    bottom: 132px;

    transform:
        rotate(42deg)
        scale(.70);

    animation:
        ejscLeafFive 4.6s ease-in-out infinite;
}

@keyframes ejscLeafOne {
    0%,100% {
        transform:
            rotate(-35deg)
            scale(1.05);
    }

    50% {
        transform:
            rotate(-41deg)
            scale(1.08);
    }
}

@keyframes ejscLeafTwo {
    0%,100% {
        transform:
            rotate(27deg)
            scale(.96);
    }

    50% {
        transform:
            rotate(20deg)
            scale(1);
    }
}

@keyframes ejscLeafThree {
    0%,100% {
        transform:
            rotate(-59deg)
            scale(.86);
    }

    50% {
        transform:
            rotate(-52deg)
            scale(.91);
    }
}

@keyframes ejscLeafFour {
    0%,100% {
        transform:
            rotate(9deg)
            scale(.76);
    }

    50% {
        transform:
            rotate(17deg)
            scale(.80);
    }
}

@keyframes ejscLeafFive {
    0%,100% {
        transform:
            rotate(42deg)
            scale(.70);
    }

    50% {
        transform:
            rotate(35deg)
            scale(.75);
    }
}


/* =========================================================
   BOOKS
========================================================= */

.ejsc-books {
    position: absolute;

    right: -15px;
    bottom: 40px;

    width: 150px;
    height: 115px;

    animation:
        ejscBooksMotion 5s ease-in-out infinite;
}

@keyframes ejscBooksMotion {
    0%,100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-8px);
    }
}

.ejsc-book {
    position: absolute;

    right: 0;

    height: 27px;

    border-radius: 4px;

    box-shadow:
        0 7px 10px
        rgba(24,111,125,.13);
}

.book-1 {
    bottom: 0;
    width: 140px;

    background:
        linear-gradient(
            90deg,
            #0ea9b4,
            #4acdd2
        );
}

.book-2 {
    bottom: 27px;
    width: 126px;
    right: 7px;

    background: #fff;

    border:
        1px solid
        #b7e3e6;
}

.book-3 {
    bottom: 54px;
    width: 138px;
    right: 2px;

    background:
        linear-gradient(
            90deg,
            #18bdc6,
            #7ce0e2
        );
}

.book-3::after {
    content: "";

    position: absolute;

    left: 15px;
    top: 8px;

    width: 70px;
    height: 3px;

    border-radius: 99px;

    background:
        rgba(255,255,255,.65);
}


/* =========================================================
   CURVED ARROW
========================================================= */

.ejsc-curved-arrow {
    position: absolute;

    z-index: 8;

    right: -20px;
    top: 100px;

    width: 300px;
    height: 190px;

    overflow: visible;

    animation:
        ejscArrowFloat 4s ease-in-out infinite;
}

.ejsc-arrow-path {
    stroke-dasharray: 420;
    stroke-dashoffset: 420;

    animation:
        ejscArrowDraw 4s ease-in-out infinite;
}

@keyframes ejscArrowFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-8px);
    }
}

@keyframes ejscArrowDraw {
    0% {
        stroke-dashoffset: 420;
        opacity: .35;
    }

    45% {
        stroke-dashoffset: 0;
        opacity: 1;
    }

    75%,100% {
        stroke-dashoffset: 0;
        opacity: 1;
    }
}


/* =========================================================
   FEATURE WRAPPER
========================================================= */

.ejsc-feature-wrapper {
    position: absolute;

    z-index: 20;

    left: 50%;
    bottom: 78px;

    width:
        min(940px, calc(100% - 90px));

    transform:
        translateX(-50%);
}


/* =========================================================
   FEATURE BAR
========================================================= */

.ejsc-feature-bar {
    position: relative;

    width: 100%;
    min-height: 315px;

    padding: 50px 42px;

    display: grid;

    grid-template-columns:
        repeat(4,1fr);

    align-items: center;

    border:
        1px solid
        rgba(213,236,239,.98);

    border-radius: 28px;

    background:
        rgba(255,255,255,.96);

    box-shadow:
        0 25px 60px
        rgba(44,92,112,.10),

        0 8px 20px
        rgba(24,184,194,.04);

    backdrop-filter:
        blur(20px);

    animation:
        ejscFeatureBarFloat 6s ease-in-out infinite;
}

@keyframes ejscFeatureBarFloat {
    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-5px);
    }
}


/* =========================================================
   FEATURE
========================================================= */

.ejsc-feature {
    position: relative;

    min-width: 0;
    min-height: 205px;

    padding: 0 28px;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    text-align: center;
}


/* =========================================================
   DIVIDERS
========================================================= */

.ejsc-feature:not(:last-child)::after {
    content: "";

    position: absolute;

    right: 0;
    top: 8px;

    width: 1px;
    height: calc(100% - 16px);

    background: #dcebed;
}


/* =========================================================
   FEATURE ICON
========================================================= */

.ejsc-feature-icon {
    width: 88px;
    height: 88px;

    margin-bottom: 24px;

    display: flex;
    align-items: center;
    justify-content: center;

    border:
        1px solid
        rgba(16,198,208,.27);

    border-radius: 50%;

    color: #0dbac5;

    background:
        linear-gradient(
            145deg,
            #fff,
            #f8feff
        );

    box-shadow:
        0 9px 24px
        rgba(16,190,201,.08),

        inset 0 0 0 5px
        rgba(16,198,208,.025);

    animation:
        ejscFeatureIconFloat 4s ease-in-out infinite;
}

.ejsc-feature:nth-child(2) .ejsc-feature-icon {
    animation-delay: .4s;
}

.ejsc-feature:nth-child(3) .ejsc-feature-icon {
    animation-delay: .8s;
}

.ejsc-feature:nth-child(4) .ejsc-feature-icon {
    animation-delay: 1.2s;
}

@keyframes ejscFeatureIconFloat {
    0%,100% {
        transform:
            translateY(0)
            scale(1);
    }

    50% {
        transform:
            translateY(-7px)
            scale(1.04);
    }
}

.ejsc-feature-icon svg {
    width: 42px;
    height: 42px;

    animation:
        ejscFeatureSvg 4s ease-in-out infinite;
}

@keyframes ejscFeatureSvg {
    0%,100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.07);
    }
}


/* =========================================================
   FEATURE TITLE
========================================================= */

.ejsc-feature h4 {
    margin: 0 0 12px;

    color: #0bb2be;

    font-size: 17px;
    font-weight: 800;
}


/* =========================================================
   FEATURE TEXT
========================================================= */

.ejsc-feature p {
    max-width: 190px;

    margin: 0;

    color: #526f89;

    font-size: 13px;
    line-height: 1.8;
}


/* =========================================================
   RESPONSIVE 1100
========================================================= */

@media (max-width:1100px) {

    .ejsc-hero {
        min-height: 1450px;
    }

    .ejsc-hero-container {
        width: calc(100% - 60px);

        grid-template-columns:
            1fr 1fr;

        gap: 30px;

        padding-top: 230px;
    }

    .ejsc-title {
        font-size: 48px;
    }

    .ejsc-stat-card {
        max-width: 390px;
    }

    .ejsc-illustration {
        transform: scale(.88);
        transform-origin: bottom right;

        right: -80px;
    }

    .ejsc-feature-wrapper {
        width: calc(100% - 60px);
    }

    .ejsc-feature-bar {
        padding: 40px 25px;
    }

    .ejsc-feature {
        padding: 0 17px;
    }
}


/* =========================================================
   RESPONSIVE 900
========================================================= */

@media (max-width:900px) {

    .ejsc-hero {
        min-height: auto;
        padding-bottom: 50px;
    }

    .ejsc-hero-container {
        min-height: auto;

        width: calc(100% - 50px);

        padding-top: 170px;
        padding-bottom: 60px;

        grid-template-columns: 1fr;

        gap: 70px;
    }

    .ejsc-hero-left {
        padding-top: 0;
    }

    .ejsc-title {
        max-width: 650px;
        font-size: 56px;
    }

    .ejsc-description {
        max-width: 600px;
    }

    .ejsc-hero-right {
        min-height: 680px;
        justify-content: center;
    }

    .ejsc-stat-card {
        max-width: 620px;
    }

    .ejsc-illustration {
        right: 50%;
        bottom: -30px;

        transform:
            translateX(50%)
            scale(.9);

        transform-origin:
            bottom center;
    }

    .ejsc-feature-wrapper {
        position: relative;

        left: auto;
        bottom: auto;

        width: calc(100% - 50px);

        margin: 0 auto;

        transform: none;
    }

    .ejsc-feature-bar {
        grid-template-columns: 1fr 1fr;
        min-height: 400px;
    }

    .ejsc-feature {
        min-height: 175px;
    }

    .ejsc-feature:nth-child(2)::after,
    .ejsc-feature:nth-child(3)::after {
        display: none;
    }

    .ejsc-feature:nth-child(1),
    .ejsc-feature:nth-child(2) {
        border-bottom:
            1px solid #dcebed;
    }
}


/* =========================================================
   RESPONSIVE 640
========================================================= */

@media (max-width:640px) {

    .ejsc-bg-shape-1 {
        width: 280px;
        height: 230px;

        left: -145px;
        top: -80px;
    }

    .ejsc-bg-shape-2 {
        width: 300px;
        height: 210px;

        right: -160px;
    }

    .ejsc-hero-container {
        width: calc(100% - 30px);

        padding-top: 110px;
        padding-bottom: 30px;

        gap: 55px;
    }

    .ejsc-badge {
        margin-bottom: 30px;

        font-size: 11px;
        padding: 0 13px;
    }

    .ejsc-title {
        font-size: 41px;

        line-height: 1.12;
        letter-spacing: -1.8px;

        margin-bottom: 23px;
    }

    .ejsc-description {
        font-size: 14px;
        line-height: 1.85;

        margin-bottom: 30px;
    }

    .ejsc-buttons {
        width: 100%;
        gap: 10px;
    }

    .ejsc-btn-primary,
    .ejsc-btn-secondary {
        flex: 1;

        min-width: 0;
        height: 53px;

        padding: 0 14px;

        font-size: 13px;
    }

    .ejsc-stat-card {
        padding: 23px 18px;
        border-radius: 22px;
    }

    .ejsc-stat-header {
        margin-bottom: 23px;
    }

    .ejsc-stat-header h3 {
        font-size: 15px;
    }

    .ejsc-live {
        font-size: 10px;
    }

    .ejsc-stat-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .ejsc-stat-box {
        min-height: 85px;
        padding: 14px;
    }

    .ejsc-stat-number {
        font-size: 23px;
    }

    .ejsc-stat-icon {
        flex-basis: 45px;
        width: 45px;
        height: 45px;
    }

    .ejsc-stat-icon svg {
        width: 36px;
        height: 36px;
    }

    .ejsc-hero-right {
        min-height: 600px;
    }

    .ejsc-illustration {
        width: 580px;
        height: 360px;

        right: 50%;
        bottom: -10px;

        transform:
            translateX(50%)
            scale(.58);
    }

    .ejsc-feature-wrapper {
        width: calc(100% - 30px);
    }

    .ejsc-feature-bar {
        grid-template-columns: 1fr;

        min-height: auto;

        padding: 25px 20px;

        gap: 0;

        border-radius: 23px;
    }

    .ejsc-feature {
        min-height: 190px;
        padding: 25px 15px;

        border-bottom:
            1px solid #dcebed;
    }

    .ejsc-feature:last-child {
        border-bottom: none;
    }

    .ejsc-feature:not(:last-child)::after {
        display: none;
    }

    .ejsc-feature-icon {
        width: 72px;
        height: 72px;

        margin-bottom: 17px;
    }

    .ejsc-feature-icon svg {
        width: 35px;
        height: 35px;
    }

    .ejsc-feature h4 {
        font-size: 16px;
    }

    .ejsc-feature p {
        max-width: 260px;
        font-size: 12px;
    }

    .ejsc-dot-1,
    .ejsc-dot-2 {
        display: none;
    }
}


/* =========================================================
   RESPONSIVE 430
========================================================= */

@media (max-width:430px) {

    .ejsc-title {
        font-size: 37px;
    }

    .ejsc-badge {
        max-width: 100%;
        white-space: nowrap;
    }

    .ejsc-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .ejsc-btn-primary,
    .ejsc-btn-secondary {
        width: 100%;
        flex: none;
    }

    .ejsc-hero-right {
        min-height: 540px;
    }

    .ejsc-illustration {
        transform:
            translateX(50%)
            scale(.47);

        bottom: -5px;
    }

    .ejsc-stat-card {
        width: 100%;
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


/* =========================================================
   HIDE PLANT & ARROW
========================================================= */

.ejsc-plant,
.ejsc-curved-arrow {
    display: none !important;
}

.ejsc-stat-label {
    position: relative;
    animation: none !important;
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

    /* BACKGROUND BIRU CERAH */

    background:

        radial-gradient(
            circle at 5% 8%,
            rgba(67, 197, 211, 0.32),
            transparent 28%
        ),

        radial-gradient(
            circle at 95% 25%,
            rgba(62, 190, 207, 0.24),
            transparent 30%
        ),

        radial-gradient(
            circle at 50% 105%,
            rgba(74, 202, 211, 0.20),
            transparent 32%
        ),

        linear-gradient(
            145deg,
            #ffffff 0%,
            #f7fdfe 42%,
            #eaf9fb 100%
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
========================================================= */

.ejsc-main-title {

    margin: 0;

    font-family:
        "Inter",
        "Poppins",
        Arial,
        sans-serif;

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

    border: 1px solid #c9e4e7;

    border-radius: 26px;

    background:
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fbfefe 100%
        );

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

    --accent: #35BFD1;
    --accent-soft: rgba(53,191,209,.11);

}


.ejsc-card-talenta {

    --accent: #B9E52D;
    --accent-soft: rgba(185,229,45,.12);

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
    CSS : CARA KERJA
    TEXT STEP DIKUNCI / TIDAK BERGERAK
    ANIMASI ELEMEN LAIN TETAP AKTIF
========================================================= --}}
<style>

/* =========================================================
   COLOR SYSTEM
========================================================= */

.how-it-works-section {

    --how-dark: #087f89;
    --how-primary: #16b8c0;
    --how-light: #67dce0;
    --how-soft: #b8eef1;
    --how-pale: #e3f9fa;
    --how-white: #f8ffff;
    --how-text: #245b66;
    --how-muted: #5f7f87;
}


/* =========================================================
   RESET
========================================================= */

.how-it-works-section * {
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
            circle at 8% 18%,
            rgba(74, 207, 215, .16),
            transparent 25%
        ),

        radial-gradient(
            circle at 92% 72%,
            rgba(37, 190, 201, .13),
            transparent 27%
        ),

        linear-gradient(
            180deg,
            #eefdfe 0%,
            #f8ffff 38%,
            #ffffff 68%,
            #eefbfc 100%
        );

    isolation: isolate;
}


/* =========================================================
   BACKGROUND BLOBS
   DIBUAT LEBIH SEDIKIT & LEBIH HALUS
========================================================= */

.how-blob {

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    filter: blur(8px);

    z-index: -2;

    opacity: .38;
}


.blob-one {

    width: 320px;
    height: 320px;

    left: -160px;
    top: 70px;

    background:
        rgba(53, 201, 211, .16);

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
        rgba(41, 191, 202, .12);

    animation:
        blobFloatTwo
        10s
        ease-in-out
        infinite;
}


/* Blob tambahan dibuat sangat samar */

.blob-three {

    width: 160px;
    height: 160px;

    left: 47%;
    top: -80px;

    background:
        rgba(105, 220, 225, .07);

    opacity: .18;

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
        rgba(62, 202, 211, .05);

    opacity: .12;

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
        rgba(50, 190, 201, .10);

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
            rgba(34, 190, 202, .55),
            rgba(112, 224, 228, .15)
        );

    box-shadow:
        0 0 20px
        rgba(35, 190, 202, .18);

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
        rgba(227,249,250,.92);

    border:
        1px solid
        rgba(42,190,201,.16);

    color:
        #3e7079;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 1.1px;

    box-shadow:
        0 8px 25px
        rgba(42,190,201,.06);

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
        #20b9c1;

    box-shadow:
        0 0 0 5px
        rgba(32,185,193,.10);

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
        #245967;

    text-shadow:
        0 3px 20px
        rgba(38,190,201,.06);
}


.how-title span {

    display: inline-block;

    background:
        linear-gradient(
            90deg,
            #087f89,
            #18b9c1,
            #69dce0,
            #087f89
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
            #19b9c1,
            #8ae5e8,
            #19b9c1
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
        #19b9c1;

    box-shadow:
        0 0 15px
        rgba(25,185,193,.40);

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
        #5c7c84;

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
        rgba(35,190,201,.12);
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
            #1bbac2,
            #9be8eb,
            #1bbac2,
            transparent
        );

    box-shadow:
        0 0 20px
        rgba(27,186,194,.45);

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
            rgba(35,190,201,.11),
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

    animation: none !important;

    transition: none;
}


.step-1,
.step-2,
.step-3,
.step-4 {
    animation: none !important;
}


.step-card:hover {

    animation: none !important;

    transform: none !important;
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
        rgba(35,190,201,.16);

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
        #20bac2;

    box-shadow:
        0 0 14px
        rgba(32,186,194,.50);
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
            rgba(226,249,250,.94)
        );

    border:
        1px solid
        rgba(35,190,201,.17);

    color:
        #15949d;

    font-size: 25px;

    font-weight: 800;

    box-shadow:
        0 15px 35px
        rgba(35,190,201,.10),

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
        rgba(35,190,201,.12);

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
        rgba(103,220,224,.70);

    box-shadow:
        0 0 14px
        rgba(103,220,224,.55);

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
        rgba(35,190,201,.20);
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
        #15949d;

    background:
        linear-gradient(
            135deg,
            rgba(215,246,247,.95),
            rgba(239,252,252,.90)
        );

    border:
        1px solid
        rgba(35,190,201,.10);

    box-shadow:
        0 10px 25px
        rgba(35,190,201,.09);

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
        rgba(35,190,201,.09);

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
        rgba(103,220,224,.28);

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
        #315f68;

    animation: none !important;

    transform: none !important;

    transition: none !important;
}


.step-card p {

    max-width: 230px;

    margin: auto;

    color:
        #63838a;

    font-size: 14px;

    line-height: 1.8;

    animation: none !important;

    transform: none !important;

    transition: none !important;
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
        rgba(35,190,201,.13);

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
   ANIMATIONS
========================================================= */

@keyframes stepFloat {
    0%, 100% { transform: translateY(0); }
    25% { transform: translateY(-5px); }
    50% { transform: translateY(-13px); }
    75% { transform: translateY(-4px); }
}


@keyframes numberBounce {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    25% {
        transform: translateY(-4px) rotate(-2deg);
    }
    50% {
        transform: translateY(-8px) rotate(2deg);
    }
    75% {
        transform: translateY(-3px) rotate(-1deg);
    }
}


@keyframes numberScale {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}


@keyframes iconFloat {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    25% {
        transform: translateY(-4px) rotate(-3deg);
    }
    50% {
        transform: translateY(-8px) rotate(3deg);
    }
    75% {
        transform: translateY(-3px) rotate(-1deg);
    }
}


@keyframes iconRotate {
    0%, 100% {
        transform: rotate(0deg) scale(1);
    }
    50% {
        transform: rotate(3deg) scale(1.08);
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
        transform: translate(0,0) scale(1);
    }
    25% {
        transform: translate(4px,-3px) scale(1.1);
    }
    50% {
        transform: translate(0,-5px) scale(.85);
    }
    75% {
        transform: translate(-4px,-2px) scale(1.1);
    }
}


@keyframes orbitRotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


@keyframes lineTravel {
    0% { left: -20%; }
    100% { left: 110%; }
}


@keyframes lineGlow {
    0%, 100% { opacity: .25; }
    50% { opacity: .85; }
}


@keyframes textLift {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}


@keyframes headerFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}


@keyframes badgePulse {
    0%, 100% {
        transform: translateY(0);
        box-shadow:
            0 8px 25px
            rgba(35,190,201,.06);
    }
    50% {
        transform: translateY(-4px);
        box-shadow:
            0 15px 35px
            rgba(35,190,201,.12);
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
    0% { background-position: 0% 50%; }
    100% { background-position: 300% 50%; }
}


@keyframes blobFloatOne {
    0%, 100% {
        transform: translate(0,0) scale(1) rotate(0deg);
    }
    50% {
        transform: translate(45px,-30px) scale(1.1) rotate(12deg);
    }
}


@keyframes blobFloatTwo {
    0%, 100% {
        transform: translate(0,0) scale(1);
    }
    50% {
        transform: translate(-40px,-35px) scale(1.14);
    }
}


@keyframes blobFloatThree {
    0%, 100% {
        transform: translate(0,0) scale(1);
    }
    50% {
        transform: translate(35px,25px) scale(1.12);
    }
}


@keyframes blobFloatFour {
    0%, 100% {
        transform: translate(0,0);
    }
    50% {
        transform: translate(-20px,-30px);
    }
}


@keyframes ringRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}


@keyframes ringRotateReverse {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}


/* =========================================================
   PARTICLE PATHS
========================================================= */

@keyframes dotPathOne {
    0%, 100% {
        transform: translate(0,0) scale(1);
    }
    25% {
        transform: translate(12px,-18px) scale(1.15);
    }
    50% {
        transform: translate(-5px,-34px) scale(.9);
    }
    75% {
        transform: translate(-15px,-12px) scale(1.08);
    }
}


@keyframes dotPathTwo {
    0%, 100% {
        transform: translate(0,0);
    }
    50% {
        transform: translate(-25px,30px);
    }
}


@keyframes dotPathThree {
    0%, 100% {
        transform: translate(0,0) scale(1);
    }
    50% {
        transform: translate(25px,-25px) scale(1.3);
    }
}


@keyframes dotPathFour {
    0%, 100% {
        transform: translate(0,0);
    }
    25% {
        transform: translate(-15px,-10px);
    }
    50% {
        transform: translate(-30px,-35px);
    }
    75% {
        transform: translate(-10px,-50px);
    }
}


@keyframes dotPathFive {
    0%, 100% {
        transform: translate(0,0);
    }
    50% {
        transform: translate(18px,-20px);
    }
}


@keyframes dotPathSix {
    0%, 100% {
        transform: translate(0,0);
    }
    50% {
        transform: translate(-20px,15px);
    }
}


@keyframes dotPathSeven {
    0%, 100% {
        transform: translate(0,0) scale(1);
    }
    50% {
        transform: translate(20px,20px) scale(1.4);
    }
}


@keyframes dotPathEight {
    0%, 100% {
        transform: translate(0,0);
    }
    50% {
        transform: translate(-25px,-18px);
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
        animation: none !important;
        transform: none !important;
    }

    .step-card p {
        font-size: 13px;
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

    .step-card {
        animation: none !important;
        transform: none !important;
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

    .step-card {
        animation: none !important;
        transform: none !important;
    }

    .step-card h3,
    .step-card p {
        animation: none !important;
        transform: none !important;
    }

    .step-card p {

        max-width: 280px;

        font-size: 14px;
    }

    .how-ring {
        opacity: .5;
    }
}


/* =========================================================
   FINAL TEXT LOCK
========================================================= */

.how-it-works-section .step-card h3,
.how-it-works-section .step-card p {

    animation: none !important;

    transform: none !important;

    transition: none !important;
}


.how-it-works-section .step-card {

    animation: none !important;

    transform: none !important;
}


/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .how-it-works-section *,
    .how-it-works-section *::before,
    .how-it-works-section *::after {

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
    CTA / SIAP MEMULAI
    CSS DIPISAH DARI CARA KERJA
    WARNA DISESUAIKAN DENGAN CARA KERJA
    ANIMASI TETAP
========================================================= --}}

<section class="cta-section relative overflow-hidden">

    {{-- =====================================================
         DECORATIVE BACKGROUND
    ====================================================== --}}

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


    {{-- =====================================================
         CONTAINER
    ====================================================== --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

        <div class="cta-content">


            {{-- =================================================
                 BADGE
            ================================================== --}}

            <div class="cta-badge">

                <span></span>

                MULAI BERSAMA KAMI

            </div>


            {{-- =================================================
                 TITLE
            ================================================== --}}

            <h2>
                Siap <span>Memulai?</span>
            </h2>


            {{-- =================================================
                 DECORATIVE LINE
            ================================================== --}}

            <div class="cta-line">

                <span></span>

                <i></i>

            </div>


            {{-- =================================================
                 DESCRIPTION
            ================================================== --}}

            <p>
                Bergabunglah dengan ribuan pengguna yang telah
                merasakan manfaat platform kami
            </p>


            {{-- =================================================
                 BUTTONS
            ================================================== --}}

            <div class="cta-buttons">


                {{-- =================================================
                     PRIMARY BUTTON
                ================================================== --}}

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
                        aria-hidden="true"
                    >

                        <path d="M5 12h14"/>

                        <path d="m13 6 6 6-6 6"/>

                    </svg>

                    <div class="button-shine"></div>

                </a>


                {{-- =================================================
                     SECONDARY BUTTON
                ================================================== --}}

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
                        aria-hidden="true"
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
    CSS : SIAP MEMULAI
    KHUSUS CTA
    TIDAK DIGABUNG DENGAN CSS CARA KERJA
========================================================= --}}

<style>

/* =========================================================
   CTA RESET
========================================================= */

.cta-section *,
.cta-section *::before,
.cta-section *::after {

    box-sizing: border-box;

}


/* =========================================================
   CTA SECTION
   BIRU MUDA / TOSCA CERAH
========================================================= */

.cta-section {

    position: relative;

    padding: 120px 0;

    overflow: hidden;

    isolation: isolate;

    background:

        linear-gradient(
            110deg,
            #aeeaf1 0%,
            #bceff4 35%,
            #d2f5f7 70%,
            #e5fafb 100%
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

    border-radius:
        50% 50% 0 0;

    background:
        rgba(255,255,255,.35);

    filter:
        blur(1px);

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


/* =========================================================
   BADGE DOT
========================================================= */

.cta-badge span {

    width: 9px;

    height: 9px;

    flex-shrink: 0;

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
        clamp(40px, 5vw, 62px);

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -2.5px;

    color:
        #244e5a;

}


/* =========================================================
   CTA TITLE COLOR
========================================================= */

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

    background-size:
        300% auto;

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


/* =========================================================
   CTA LINE LEFT / RIGHT
========================================================= */

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

    background-size:
        200%;

    animation:
        gradientMove
        3s
        linear
        infinite;

}


/* =========================================================
   CTA LINE CENTER
========================================================= */

.cta-line i {

    width: 7px;

    height: 7px;

    flex-shrink: 0;

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
   CTA BUTTON WRAPPER
========================================================= */

.cta-buttons {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 16px;

    margin-top: 35px;

    flex-wrap: wrap;

}


/* =========================================================
   BOTH BUTTONS
========================================================= */

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


/* =========================================================
   PRIMARY BUTTON
========================================================= */

.cta-primary {

    color:
        #ffffff;

    background:
        linear-gradient(
            135deg,
            #247c79,
            #2aa9a2,
            #4ccbc4
        );

    background-size:
        200% 200%;

    box-shadow:
        0 12px 30px
        rgba(42,169,162,.24);

    animation:
        buttonGradient
        5s
        ease
        infinite;

}


/* =========================================================
   SECONDARY BUTTON
========================================================= */

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


/* =========================================================
   BUTTON ICON / PANAH
========================================================= */

.cta-primary svg,
.cta-secondary svg {

    width: 19px;

    height: 19px;

    flex-shrink: 0;

    transition:
        transform .3s ease;

}


/* =========================================================
   PANAH BERGERAK SAAT HOVER
========================================================= */

.cta-primary:hover svg,
.cta-secondary:hover svg {

    transform:
        translateX(5px);

}


/* =========================================================
   BUTTON SHINE
========================================================= */

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

    transform:
        rotate(20deg);

    animation:
        buttonShine
        4.5s
        ease-in-out
        infinite;

    pointer-events: none;

}


/* =========================================================
   BUTTON HOVER
========================================================= */

.cta-primary:hover,
.cta-secondary:hover {

    transform:
        translateY(-7px)
        scale(1.03);

}


/* =========================================================
   PRIMARY HOVER SHADOW
========================================================= */

.cta-primary:hover {

    box-shadow:
        0 20px 45px
        rgba(42,169,162,.32);

}


/* =========================================================
   CTA ORBS
   DIKURANGI AGAR TIDAK TERLALU BANYAK BUBBLE
========================================================= */

.cta-orb {

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    filter:
        blur(2px);

}


/* =========================================================
   ORB 1
   BUBBLE KIRI - HALUS
========================================================= */

.cta-orb-1 {

    width: 230px;

    height: 230px;

    left: -110px;

    top: 20px;

    background:
        rgba(255,255,255,.12);

    animation:
        orbFloat
        9s
        ease-in-out
        infinite;

}


/* =========================================================
   ORB 2
   BUBBLE KANAN - HALUS
========================================================= */

.cta-orb-2 {

    width: 170px;

    height: 170px;

    right: -80px;

    bottom: 20px;

    background:
        rgba(42,169,162,.07);

    animation:
        orbFloatReverse
        7s
        ease-in-out
        infinite;

}


/* =========================================================
   ORB 3
   BUBBLE KECIL - SANGAT HALUS
========================================================= */

.cta-orb-3 {

    width: 55px;

    height: 55px;

    left: 20%;

    bottom: 20px;

    background:
        rgba(255,255,255,.10);

    animation:
        orbSmallFloat
        5s
        ease-in-out
        infinite;

}


/* =========================================================
   ORB 4
   BUBBLE KECIL - SANGAT HALUS
========================================================= */

.cta-orb-4 {

    width: 40px;

    height: 40px;

    right: 25%;

    top: 20px;

    background:
        rgba(255,255,255,.09);

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


/* =========================================================
   DOT 1
========================================================= */

.cta-dot-1 {

    left: 20%;

    top: 20%;

    animation:
        dotPathOne
        5s
        infinite;

}


/* =========================================================
   DOT 2
========================================================= */

.cta-dot-2 {

    right: 20%;

    top: 25%;

    animation:
        dotPathTwo
        7s
        infinite
        reverse;

}


/* =========================================================
   DOT 3
========================================================= */

.cta-dot-3 {

    left: 30%;

    bottom: 20%;

    animation:
        dotPathThree
        6s
        infinite;

}


/* =========================================================
   DOT 4
========================================================= */

.cta-dot-4 {

    right: 30%;

    bottom: 15%;

    animation:
        dotPathFour
        4s
        infinite
        reverse;

}


/* =========================================================
   DOT 5
========================================================= */

.cta-dot-5 {

    left: 50%;

    top: 15%;

    width: 6px;

    height: 6px;

    animation:
        dotPathFive
        5s
        infinite;

}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes ctaFloat {

    0%, 100% {

        transform:
            translateY(0);

    }

    50% {

        transform:
            translateY(-7px);

    }

}


@keyframes badgePulse {

    0%, 100% {

        transform:
            translateY(0);

        box-shadow:
            0 8px 25px
            rgba(42,169,162,.06);

    }

    50% {

        transform:
            translateY(-4px);

        box-shadow:
            0 15px 35px
            rgba(42,169,162,.13);

    }

}


@keyframes dotPulse {

    0%, 100% {

        opacity: .55;

        transform:
            scale(1);

    }

    50% {

        opacity: 1;

        transform:
            scale(1.4);

    }

}


@keyframes gradientMove {

    0% {

        background-position:
            0% 50%;

    }

    100% {

        background-position:
            300% 50%;

    }

}


@keyframes buttonGradient {

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


@keyframes buttonShine {

    0% {

        left:
            -120%;

    }

    35% {

        left:
            140%;

    }

    100% {

        left:
            140%;

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


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .cta-section {

        padding:
            100px 0;

    }

}


/* =========================================================
   MOBILE TABLET
========================================================= */

@media (max-width: 768px) {

    .cta-section {

        padding:
            85px 0;

    }

    .cta-section h2 {

        font-size:
            44px;

    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .cta-section {

        padding:
            75px 0;

    }

    .cta-section h2 {

        font-size:
            38px;

    }

    .cta-section p {

        font-size:
            16px;

    }

    .cta-buttons {

        flex-direction:
            column;

    }

    .cta-primary,
    .cta-secondary {

        width:
            100%;

        max-width:
            280px;

    }

}


/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

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