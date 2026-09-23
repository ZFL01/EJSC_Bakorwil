@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    body {
        background: #f6f8fa !important;
    }

    .profile-page {
        min-height: calc(100vh - 64px);
        padding: 18px 24px 42px;
        background: #f6f8fa;
        color: #17344f;

        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* =========================================================
       BREADCRUMB
       ========================================================= */

    .profile-breadcrumb {
        width: 100%;
        max-width: 1040px;
        margin: 0 auto 14px;

        display: flex;
        align-items: center;
        gap: 9px;

        color: #83909a;
        font-size: 13px;
        font-weight: 400;
    }

    .profile-breadcrumb strong {
        color: #18364f;
        font-weight: 700;
    }

    /* =========================================================
       MAIN CARD
       ========================================================= */

    .profile-card {
        width: 100%;
        max-width: 1040px;
        margin: 0 auto;

        background: #ffffff;
        border: 1px solid #e7edf0;
        border-radius: 10px;

        overflow: visible;

        box-shadow:
            0 4px 14px rgba(24, 54, 79, 0.04);
    }

    /* =========================================================
       HERO
       ========================================================= */

   .profile-hero {
    position: relative;

    min-height: 100px;

     padding: 20px 60px 26px;

   margin-top: -32px;
    margin-left: -32px;
    margin-right: -32px;

    border-radius: 10px 10px 0 0;

    overflow: hidden;

    background:
        radial-gradient(
            circle at 88% 20%,
            rgba(54, 178, 168, 0.25),
            transparent 30%
        ),
        linear-gradient(
            110deg,
            #126a6d 0%,
            #087d7b 45%,
            #157e7b 100%
        );

    color: #ffffff;
}
    .profile-hero::after {
        content: "";

        position: absolute;
        inset: 0;

        pointer-events: none;

        background:
            radial-gradient(
                circle at 20% 120%,
                rgba(255,255,255,.05),
                transparent 35%
            ),
            linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.025)
            );
    }

    .profile-hero-content {
        position: relative;
        z-index: 2;
        transform: translateY(-8px);
    }

    .profile-label {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        margin-bottom: 5px;

        padding: 3px 8px;

        border-radius: 20px;

        background: rgba(0, 61, 64, .35);

        color: #d8ffff;

        font-size: 13px;
        font-weight: 700;
    }

    .profile-label::before {
        content: "";
        width: 4px;
        height: 4px;

        border-radius: 50%;

        background: #67d6ce;
    }

    .profile-hero h1 {
        margin: 0;

        color: #ffffff;

        font-size: 13px;
        line-height: 1.15;
        font-weight: 800;
    }

    .profile-hero-description {
        margin-top: 3px;

        color: rgba(255,255,255,.88);

        font-size: 13px;
        line-height: 1.4;
    }

    .profile-id {
        position: absolute;

        top: 17px;
        right: 20px;

        padding: 6px 10px;

        border-radius: 15px;

        background: rgba(255,255,255,.10);

        color: rgba(255,255,255,.8);

        font-size: 13px;
        font-weight: 600;
    }

    /* =========================================================
       IDENTITY BAR
       ========================================================= */

   .profile-identity {
    position: relative;

    min-height: 64px;

padding: 0 28px 60px 118px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #edf1f3;

    background: #ffffff;
}

    .profile-avatar {
        position: absolute;

        left: 28px;
        top: 12px;

        width: 100px;
        height: 100px;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        border: 3px solid #ffffff;
        border-radius: 10px;

        background:
            linear-gradient(
                145deg,
                #143c4d,
                #1c5960
            );

        color: #ffffff;

        box-shadow:
            0 3px 8px rgba(15, 45, 60, .18);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .profile-avatar svg {
        width: 40px;
        height: 40px;
    }
.profile-name-wrap {
    padding: 8px 0;
    margin-left: 20px;
    transform: translateY(30px);
}

    .profile-name {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .profile-name h2 {
        margin: 0;

        color: #18364f;

        font-size: 15px;
        line-height: 1.2;
        font-weight: 800;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;

        padding: 2px 6px;

        border-radius: 10px;

        background: #eaf4ff;

        color: #2877b7;

        font-size: 13px;
        font-weight: 700;
    }

    .verified-badge::before {
        content: "●";
        font-size: 13px;
    }

   .profile-subtitle {
    margin-top: 5px;

    color: #6b8a9a;

    font-size: 15px;
    font-weight: 500;
}

.profile-subtitle-dot {
    color: #7c8f98;
}

.profile-subtitle-role {
    display: block;

    color: #32c857;
    font-weight: 600;

    margin-bottom: 2px;
}

.profile-subtitle-skill {
    display: block;

    color: #6b8a9a;
    font-size: 15px;
    font-weight: 500;
}

    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        padding: 5px 9px;

        border-radius: 15px;

        background: #e9f8ef;

        color: #168348;

        font-size: 13px;
        font-weight: 700;
    }

    .profile-status::before {
        content: "";

        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: #1ca463;
    }

    /* =========================================================
       BODY
       ========================================================= */

    .profile-body {
        padding: 18px 28px 14px;
        background: #ffffff;
    }

    .profile-columns {
        display: grid;
        grid-template-columns: 1fr 1.18fr;
        gap: 30px;
         transform: translateY(25px);
    }

    .profile-column {
        min-width: 0;
    }

    .profile-column + .profile-column {
        padding-left: 30px;
        border-left: 1px solid #edf1f3;
    }

    /* =========================================================
       SECTION TITLE
       ========================================================= */

    .profile-section-title {
        display: flex;
        align-items: center;
        gap: 8px;

        margin: 0 0 14px;
        padding-bottom: 9px;

        border-bottom: 1px solid #edf1f3;

        color: #17364f;

        font-size: 13px;
        font-weight: 800;
    }

    .profile-section-icon {
        width: 20px;
        height: 20px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 5px;
    }

    .profile-section-icon.account {
        color: #129aa3;
        background: #effafa;
    }

    .profile-section-icon.document {
        color: #319b69;
        background: #eff9f1;
    }

    .profile-section-icon svg {
        width: 11px;
        height: 11px;
    }

    /* =========================================================
       INFORMATION BOX
       ========================================================= */

    .info-box {
        margin-bottom: 8px;
        padding: 13px 14px;

        border: 1px solid #edf1f3;
        border-radius: 7px;

        background: #fbfcfd;
    }

    .info-label {
        margin-bottom: 4px;

        color: #80909b;

        font-size: 11px;
        line-height: 1.2;
        font-weight: 600;

        text-transform: uppercase;
        letter-spacing: .25px;
    }

    .info-value {
        color: #243d51;
        font-family: 'inter', sans-serif;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 600;
        letter-spacing: 0.1px;
    }

    .info-value.light {
        font-weight: 400;
    }

    .info-value-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .copy-text {
        color: #3b8e83;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;
        user-select: none;

        transition: .2s ease;
    }

    .copy-text:hover {
        color: #23766d;
    }

    .standard-badge {
        display: inline-block;

        margin-left: 4px;
        padding: 2px 5px;

        border-radius: 3px;

        background: #dff5e7;

        color: #36915b;

        font-size: 13px;
        font-weight: 700;
    }

    /* =========================================================
       SKILLS
       ========================================================= */

    .skill-area {
        margin-bottom: 10px;
    }

    .skill-label {
        margin-bottom: 7px;

        color: #80909b;

        font-size: 11px;
        font-weight: 600;

        text-transform: uppercase;
    }

    .skill-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .skill-tag {
        display: inline-flex;
        align-items: center;

        padding: 4px 7px;

        border: 1px solid #d9eeee;
        border-radius: 5px;

        background: #effafa;

        color: #27817f;

        font-size: 13px;
        font-weight: 600;
    }

    /* =========================================================
       TWO SMALL CARDS
       ========================================================= */

    .profile-small-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;

        margin-bottom: 9px;
    }

    .profile-small-card {
        min-height: 56px;

        padding: 9px 10px;

        border: 1px solid #edf1f3;
        border-radius: 7px;

        background: #ffffff;
    }

    .profile-small-label {
        margin-bottom: 5px;

        color: #83909a;

        font-size: 11px;
        font-weight: 600;

        text-transform: uppercase;
    }

    .profile-small-value {
        color: #253f51;

        font-size: 13px;
        font-weight: 700;
    }

    .profile-small-value.muted {
        color: #88939b;
        font-style: italic;
        font-weight: 400;
    }

    .profile-small-description {
        margin-top: 4px;

        color: #8a969d;

        font-size: 13px;
        line-height: 1.35;
    }

    /* =========================================================
       PORTFOLIO
       ========================================================= */

    .portfolio-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;

        padding: 9px 10px;

        border: 1px solid #edf1f3;
        border-radius: 7px;

        background: #ffffff;
    }

    /* Seluruh kotak portfolio aktif sebagai link Google Drive */
  .portfolio-box-link {
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: .2s ease;
}

    .portfolio-box-link:hover {
        background: #f8fcfb;
    }

    .portfolio-box-link:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(42, 141, 131, .12);
    }

    .portfolio-left {
        display: flex;
        align-items: center;
        gap: 8px;

        min-width: 0;
    }

    .portfolio-icon {
        width: 20px;
        height: 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 20px;

        border-radius: 5px;

        background: #fff8e8;
        color: #c08b27;
    }

    .portfolio-icon svg {
        width: 18px;
        height: 18px;
    }

    .portfolio-title {
        color: #273f51;

        font-size: 13px;
        font-weight: 700;
    }

    .portfolio-description {
        margin-top: 2px;

        color: #8b969d;

        font-size: 13px;
    }

    .portfolio-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 5px 8px;

        border: 1px solid #d9ebe9;
        border-radius: 5px;

        background: #ffffff;

        color: #2a8d83;

        font-size: 13px;
        font-weight: 600;

        text-decoration: none;
        white-space: nowrap;
    }

    .portfolio-button:hover {
        background: #f2fbfa;
    }

    /* =========================================================
       ACTIONS
       ========================================================= */

    .profile-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-top: 16px;
        padding-top: 13px;

        border-top: 1px solid #edf1f3;

    transform: translateY(25px);
    }

    .profile-actions-left,
    .profile-actions-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        min-height: 28px;

        padding: 5px 10px;

        border: 1px solid #e2e9ec;
        border-radius: 6px;

        background: #ffffff;

        color: #456172;

        font-size: 13px;
        font-weight: 600;

        text-decoration: none;

        transition: .2s ease;
    }

    .profile-action:hover {
        background: #f7fafb;
    }

    .profile-action.primary {
        border-color: #16867f;

        background: #16867f;

        color: #ffffff;

        box-shadow: 0 3px 7px rgba(22, 134, 127, .18);
    }

    .profile-action svg {
        width: 10px;
        height: 10px;
    }

    /* =========================================================
       PRIVACY
       ========================================================= */

    .profile-privacy {
        width: 100%;
        max-width: 1040px;

        margin: 12px auto 0;
        padding: 8px 11px;

        display: flex;
        align-items: flex-start;
        gap: 7px;

        border: 1px solid #dfecef;
        border-radius: 6px;

        background: #f5f9fb;

        color: #6c7f8c;

        font-size: 13px;
        line-height: 1.45;
    }

    .profile-privacy svg {
        width: 11px;
        height: 11px;

        flex: 0 0 11px;

        color: #418fa2;
    }

    .profile-privacy strong {
        color: #3c6577;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 768px) {

        .profile-page {
            padding: 14px 12px 30px;
        }

        .profile-hero {
            padding: 20px 20px 2px;
        }

        .profile-id {
            display: none;
        }

        .profile-identity {
            padding-left: 112px;
            padding-right: 16px;
        }

        .profile-avatar {
            left: 18px;
            width: 68px;
            height: 68px;
            top: -23px;
        }

        .profile-body {
            padding: 16px;
        }

        .profile-columns {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .profile-column + .profile-column {
            padding-left: 0;
            padding-top: 20px;
            border-left: 0;
            border-top: 1px solid #edf1f3;
        }

        .profile-actions {
            flex-wrap: wrap;
            gap: 10px;
        }
    }

    @media (max-width: 480px) {

        .profile-name h2 {
            font-size: 13px;
        }

        .profile-subtitle {
            font-size: 13px;
        }

        .profile-status {
            font-size: 13px;
        }

        .profile-small-grid {
            grid-template-columns: 1fr;
        }

        .profile-actions,
        .profile-actions-left,
        .profile-actions-right {
            width: 100%;
        }

        .profile-actions {
            justify-content: space-between;
        }
    }
</style>


<div class="profile-page">

    {{-- =========================================================
         BREADCRUMB
         ========================================================= --}}


    {{-- =========================================================
         PROFILE CARD
         ========================================================= --}}
    <div class="profile-card">

        {{-- =====================================================
             HERO
             ====================================================== --}}
        <div class="profile-hero">

            <div class="profile-hero-content">

                <div class="profile-label">
                    Profil Talenta Resmi EJSC Bakorwil V Jember
                </div>

                <h1>
                    Ringkasan Profil Talenta
                </h1>

                <div class="profile-hero-description">
                    Data terverifikasi pada sistem manajemen talenta Millennial Job Center Jawa Timur.
                </div>

            </div>

            <div class="profile-id">
                ID Talenta:
                EJSC-TLN-2026-{{ str_pad($user->id ?? 0, 4, '0', STR_PAD_LEFT) }}
            </div>

        </div>


        {{-- =====================================================
             IDENTITY
             ====================================================== --}}
        <div class="profile-identity">

            <div class="profile-avatar">

                @if($user->profile_photo_src)

                    <img
                        src="{{ $user->profile_photo_src }}"
                        alt=""
                        onerror="
                            this.classList.add('hidden');
                            this.nextElementSibling.classList.remove('hidden');
                        "
                    >

                    <svg
                        class="hidden"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                    </svg>

                @else

                    <svg
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                    </svg>

                @endif

            </div>


           <div class="profile-name-wrap">

    <div class="profile-name">
        <h2>
            {{ $user->name }}
        </h2>

        <span class="verified-badge">
            Terverifikasi
        </span>
    </div>

    <div class="profile-subtitle">

        <span class="profile-subtitle-role">
            @if($user->role === 'mentor')
                Mentor MJC
            @elseif($user->role === 'client' || $user->role === 'klien')
                Klien MJC
            @else
                Talenta MJC
            @endif
        </span>

        <span class="profile-subtitle-skill">
            {{ $profile->keahlian ?? 'UI/UX Designer & Web Enthusiast' }}
        </span>

    </div>

</div>


            <div class="profile-status">

                @if($user->isTalent())

                    @if(($profile->status_pekerjaan ?? '') === 'mencari_kerja')
                        Status: Mencari Kerja (Open to Work)
                    @elseif(($profile->status_pekerjaan ?? '') === 'bekerja')
                        Status: Sedang Bekerja
                    @else
                        Status: {{ ucfirst(str_replace('_', ' ', $profile->status_pekerjaan ?? 'Mencari Kerja')) }}
                    @endif

                @else

                    Status: Aktif

                @endif

            </div>

        </div>


        {{-- =====================================================
             BODY
             ====================================================== --}}
        <div class="profile-body">

            <div class="profile-columns">

                {{-- =================================================
                     LEFT COLUMN
                     ================================================= --}}
                <div class="profile-column">

                    <h3 class="profile-section-title">

                        <span class="profile-section-icon account">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 20v-1a4 4 0 0 0-8 0v1m4-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"
                                />
                            </svg>

                        </span>

                        Informasi Akun

                    </h3>


                    {{-- EMAIL --}}
                    <div class="info-box">

                        <div class="info-label">
                            Alamat Surel (E-mail)
                        </div>

                        <div class="info-value-row">

                       <div
                        class="info-value"
                        id="profile-email"
                        style="font-weight: 400;"
                    >
                        {{ $user->email }}
                    </div>


                        </div>

                    </div>


                    {{-- PERAN --}}
                    <div class="info-box">

                        <div class="info-label">
                            Peran Akun
                        </div>

                        <div class="info-value">
    @if($user->role === 'mentor')
        Mentor Profesional
    @elseif($user->role === 'client' || $user->role === 'klien')
        Klien Profesional
    @else
        Talenta Profesional
    @endif


  
</div>

                    </div>


                    {{-- WILAYAH --}}
                    <div class="info-box">

                        <div class="info-label">
                            Wilayah Kerja Bakorwil
                        </div>

                        <div class="info-value">
                            Bakorwil V Jember (Jawa Timur)
                        </div>

                    </div>


                    {{-- TANGGAL --}}
                    <div class="info-box">

                        <div class="info-label">
                            Tanggal Bergabung
                        </div>

                        <div class="info-value">
                            {{ optional($user->created_at)->translatedFormat('F Y') ?? '-' }}
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT COLUMN
                     ================================================= --}}
                <div class="profile-column">

                    <h3 class="profile-section-title">

                        <span class="profile-section-icon document">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7 3h7l4 4v14H7V3Zm7 0v5h4M10 12h5m-5 3h5"
                                />
                            </svg>

                        </span>

                        Profil & Keahlian Profesional

                    </h3>


                    {{-- KEAHLIAN --}}
                    <div class="skill-area">

                        <div class="skill-label">
                            Keahlian & Kompetensi
                        </div>

                        <div class="skill-list">

                            @php
                                $skills = array_filter(
                                    array_map(
                                        'trim',
                                        preg_split(
                                            '/[,;|]/',
                                            $profile->keahlian ?? ''
                                        )
                                    )
                                );
                            @endphp

                            @forelse($skills as $skill)

                                <span class="skill-tag">
                                    {{ $skill }}
                                </span>

                            @empty

                                <span class="skill-tag">
                                    Belum diisi
                                </span>

                            @endforelse

                        </div>

                    </div>


                    {{-- STATUS + MENTOR --}}
                    <div class="profile-small-grid">

                        <div class="profile-small-card">

                            <div class="profile-small-label">
                                Status Ketenagakerjaan
                            </div>

                            <div class="profile-small-value">

                                @if(($profile->status_pekerjaan ?? '') === 'mencari_kerja')
                                    Mencari Kerja
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $profile->status_pekerjaan ?? '-')) }}
                                @endif

                            </div>

                            <div class="profile-small-description">
                                Siap ditempatkan pada project MJC atau mitra industri.
                            </div>

                        </div>


                        <div class="profile-small-card">

                            <div class="profile-small-label">
                                Mentor Pembimbing
                            </div>

                            @if($profile->mentor ?? false)

                                <div class="profile-small-value">
                                    {{ $profile->mentor->nama }}
                                </div>

                            @else

                                <div class="profile-small-value muted">
                                    Belum Ditentukan
                                </div>

                            @endif

                            <div class="profile-small-description">
                                Akan dikonsultasikan saat onboarding project.
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    {{-- =================================================
     PORTFOLIO GOOGLE DRIVE
     ================================================= --}}
@if(!empty($profile->gdrive_src))
    <a
        href="{{ $profile->gdrive_src }}"
        target="_blank"
        rel="noopener noreferrer"
        class="portfolio-box portfolio-box-link"
    >
        <div class="portfolio-left">

            <div class="portfolio-icon" aria-hidden="true">
                <svg
                    width="19"
                    height="19"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10.59 13.41a2 2 0 0 0 2.83 0l3.54-3.54a2 2 0 0 0-2.83-2.83l-1.29 1.29"
                        stroke="#EAB308"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M13.41 10.59a2 2 0 0 0-2.83 0l-3.54 3.54a2 2 0 0 0 2.83 2.83l1.29-1.29"
                        stroke="#EAB308"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>

            <div>
                <div class="portfolio-title">
                    Berkas Portofolio (Google Drive)
                </div>

                <div class="portfolio-description">
                    Lihat berkas portofolio di Google Drive
                </div>
            </div>

        </div>

        <div class="portfolio-button">
            Buka Google Drive
        </div>
    </a>

@else

    <a
        href="{{ route('profile.edit') }}"
        class="portfolio-box portfolio-box-link"
    >
        <div class="portfolio-left">

            <div class="portfolio-icon" aria-hidden="true">
                <svg
                    width="19"
                    height="19"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10.59 13.41a2 2 0 0 0 2.83 0l3.54-3.54a2 2 0 0 0-2.83-2.83l-1.29 1.29"
                        stroke="#EAB308"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M13.41 10.59a2 2 0 0 0-2.83 0l-3.54 3.54a2 2 0 0 0 2.83 2.83l1.29-1.29"
                        stroke="#EAB308"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>

            <div>
                <div class="portfolio-title">
                    Berkas Portofolio (Google Drive)
                </div>

                <div class="portfolio-description">
                    Tambahkan tautan Google Drive
                </div>
            </div>

        </div>

        <div class="portfolio-button">
            <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                style="margin-right: 5px;"
                aria-hidden="true"
            >
                <path
                    d="M12 5V19"
                    stroke="#2A8D83"
                    stroke-width="2"
                    stroke-linecap="round"
                />
                <path
                    d="M5 12H19"
                    stroke="#2A8D83"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>

            Tambah Tautan
        </div>

    </a>
@endif
                </div>

            </div>


            {{-- =====================================================
                 ACTION BUTTONS
                 ====================================================== --}}
            <div class="profile-actions">

                <div class="profile-actions-left">

                    <a
                        href="{{ route('public.index') }}"
                        class="profile-action"
                    >

                        <svg
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M19 12H5m6-6-6 6 6 6"
                            />
                        </svg>

                        Kembali ke Beranda

                    </a>

                </div>


                <div class="profile-actions-right">

                    <a
                        href="{{ route('profile.edit') }}"
                        class="profile-action primary"
                    >

                        <svg
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m16.86 3.49 3.65 3.65M4 20l3.95-.8L19.5 7.65a2.58 2.58 0 0 0-3.65-3.65L4.3 15.55 4 20Z"
                            />
                        </svg>

                        Edit Profil

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PRIVACY
         ========================================================= --}}
    <div class="profile-privacy">

        <svg
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <circle
                cx="12"
                cy="12"
                r="9"
                stroke-width="1.6"
            />

            <path
                stroke-linecap="round"
                stroke-width="1.6"
                d="M12 10v6m0-9h.01"
            />
        </svg>

        <div>

            <strong>
                Informasi Privasi & Validasi:
            </strong>

            Profil Anda ditampilkan pada direktori resmi East Java Super Corridor (EJSC).
            Pastikan alamat email dan keahlian selalu mutakhir agar mempermudah proses kurasi talent matching oleh Bakorwil V Jember.

        </div>

    </div>

</div>


{{-- =========================================================
     COPY EMAIL
     ========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const copyButton = document.getElementById('copy-email');
    const emailElement = document.getElementById('profile-email');

    if (!copyButton || !emailElement) {
        return;
    }

    async function copyEmail() {

        const email = emailElement.textContent.trim();

        if (!email) {
            return;
        }

        try {

            if (navigator.clipboard && window.isSecureContext) {

                await navigator.clipboard.writeText(email);

            } else {

                const textarea = document.createElement('textarea');

                textarea.value = email;

                textarea.style.position = 'fixed';
                textarea.style.left = '-999999px';
                textarea.style.top = '0';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);

                textarea.focus();
                textarea.select();
                textarea.setSelectionRange(0, textarea.value.length);

                document.execCommand('copy');

                textarea.remove();
            }

            const originalText = copyButton.innerHTML;

            copyButton.innerHTML = '✓ Tersalin';

            setTimeout(function () {
                copyButton.innerHTML = originalText;
            }, 1500);

        } catch (error) {

            console.error('Gagal menyalin email:', error);

            alert('Email gagal disalin. Silakan salin secara manual.');

        }
    }

    copyButton.addEventListener('click', copyEmail);

    copyButton.addEventListener('keydown', function (event) {

        if (event.key === 'Enter' || event.key === ' ') {

            event.preventDefault();

            copyEmail();
        }

    });

});
</script>

@endsection