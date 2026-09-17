@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<style>
    /* =========================================================
       PROFILE PAGE — TEAL / GREEN LEAF AESTHETIC
       ========================================================= */

    .profile-page {
        position: relative;
        min-height: calc(100vh - 72px);
        overflow: hidden;
        padding: 24px 16px 48px;
        background: #39dacd;
    }

    /* =========================================================
       CARD
       ========================================================= */

    .profile-card {
        position: relative;
        z-index: 2;

        width: 100%;
        max-width: 850px;
        margin: 0 auto;

        overflow: hidden;

        border: 1px solid rgba(210, 230, 228, 0.9);
        border-radius: 16px;

        background: #ffffff;

        box-shadow:
            0 18px 45px rgba(20, 90, 95, 0.10),
            0 3px 12px rgba(20, 90, 95, 0.06);
    }

    /* =========================================================
       HERO
       ========================================================= */

    .profile-hero {
        position: relative;

        min-height: 128px;

        overflow: hidden;

        display: flex;
        align-items: center;

        padding: 22px 32px;

        isolation: isolate;

        background:
            radial-gradient(
                ellipse 75% 145% at 82% 5%,
                rgba(112, 210, 193, 0.95) 0%,
                rgba(112, 210, 193, 0.70) 28%,
                rgba(112, 210, 193, 0.25) 52%,
                rgba(112, 210, 193, 0) 74%
            ),
            radial-gradient(
                ellipse 58% 125% at 48% 110%,
                rgba(53, 193, 200, 0.82) 0%,
                rgba(53, 193, 200, 0.35) 44%,
                rgba(53, 193, 200, 0) 74%
            ),
            linear-gradient(
                110deg,
                #1596ad 0%,
                #1eabb9 25%,
                #2db9c0 48%,
                #43c2bd 70%,
                #60cab8 100%
            );
    }

    /* =========================================================
       GRADASI LEMBUT SEPERTI AWAN
       ========================================================= */

    .profile-hero::before {
        content: "";
        position: absolute;

        inset: -40% -10% -40% 20%;

        z-index: 1;

        pointer-events: none;

        background:
            radial-gradient(
                ellipse 70% 75% at 75% 18%,
                rgba(155, 225, 207, 0.38) 0%,
                rgba(155, 225, 207, 0.18) 34%,
                rgba(155, 225, 207, 0) 70%
            ),
            radial-gradient(
                ellipse 65% 70% at 40% 88%,
                rgba(93, 207, 203, 0.30) 0%,
                rgba(93, 207, 203, 0) 72%
            );

        filter: blur(20px);
    }

    /* =========================================================
       CAHAYA HALUS DI ATAS GRADASI
       ========================================================= */

    .profile-hero::after {
        content: "";
        position: absolute;

        inset: 0;

        z-index: 2;

        pointer-events: none;

        background:
            radial-gradient(
                ellipse 65% 110% at 72% 0%,
                rgba(255, 255, 255, 0.16) 0%,
                rgba(255, 255, 255, 0.07) 35%,
                rgba(255, 255, 255, 0) 70%
            );
    }

    /* =========================================================
       HERO CONTENT
       ========================================================= */

    .profile-hero-content {
        position: relative;
        z-index: 4;

        display: flex;
        align-items: center;

        gap: 22px;
    }

    /* =========================================================
       AVATAR
       ========================================================= */

    .profile-avatar {
        width: 88px;
        height: 88px;
        flex: 0 0 88px;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 3px solid rgba(255, 255, 255, 0.9);
        border-radius: 50%;

        background: rgba(255, 255, 255, 0.22);

        color: #ffffff;

        box-shadow:
            0 3px 9px rgba(10, 60, 65, 0.18);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* =========================================================
       HERO TYPOGRAPHY
       ========================================================= */

    .profile-hero h1 {
        margin: 0;

        color: #ffffff;

        font-size: 25px;
        font-weight: 700;

        line-height: 1.15;

        text-shadow: 0 1px 4px rgba(10, 60, 65, 0.15);
    }

    .profile-hero p {
        margin-top: 4px;

        color: rgba(255, 255, 255, 0.95);

        font-size: 16px;

        text-shadow: 0 1px 3px rgba(10, 60, 65, 0.12);
    }

    /* =========================================================
       BODY
       ========================================================= */

    .profile-body {
        padding: 21px 24px 19px;

        background: #ffffff;
    }

    /* =========================================================
       COLUMNS
       ========================================================= */

    .profile-columns {
        display: grid;
        grid-template-columns: 1fr 1.15fr;
    }

    .profile-column {
        min-height: 220px;

        padding: 0 28px 0 0;
    }

    .profile-column + .profile-column {
        padding: 0 0 0 28px;

        border-left: 1px solid #e6efee;
    }

    /* =========================================================
       SECTION TITLE
       ========================================================= */

    .profile-section-title {
        display: flex;
        align-items: center;

        gap: 14px;

        margin: 0 0 15px;

        color: #10365a;

        font-size: 18px;
        font-weight: 700;
    }

    /* =========================================================
       SECTION ICON
       ========================================================= */

    .profile-section-icon {
        display: inline-flex;

        width: 34px;
        height: 34px;

        flex: 0 0 34px;

        align-items: center;
        justify-content: center;

        border-radius: 50%;
    }

    .profile-section-icon.account {
        color: #1598ad;
        background: #d3f0f0;
    }

    .profile-section-icon.document {
        color: #3f9b52;
        background: #dcf0d6;
    }

    /* =========================================================
       DETAILS
       ========================================================= */

    .profile-details {
        display: grid;

        gap: 15px;

        margin: 0;
    }

    .profile-details dt {
        margin-bottom: 2px;

        color: #6b8a9a;

        font-size: 14px;
        font-weight: 400;
    }

    .profile-details dd {
        margin: 0;

        color: #10365a;

        font-size: 14px;
        font-weight: 600;

        line-height: 1.35;
    }

    /* =========================================================
       ACTIONS
       ========================================================= */

    .profile-actions {
        display: flex;
        align-items: center;

        gap: 16px;

        margin-top: 1px;
    }

    .profile-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        min-height: 37px;

        padding: 7px 16px;

        border: 1px solid transparent;
        border-radius: 9px;

        font-size: 14px;
        font-weight: 600;

        text-decoration: none;

        transition:
            transform 0.25s ease,
            background-color 0.25s ease,
            border-color 0.25s ease,
            box-shadow 0.25s ease;
    }

    .profile-action:hover {
        transform: translateY(-1px);
    }

    .profile-action.primary {
        color: #ffffff;

        background: linear-gradient(135deg, #1598ad, #17aab3);

        box-shadow: 0 5px 13px rgba(21, 152, 173, 0.28);
    }

    .profile-action.primary:hover {
        color: #ffffff;

        background: linear-gradient(135deg, #128a9d, #149ba4);

        box-shadow: 0 7px 16px rgba(21, 152, 173, 0.34);
    }

    .profile-action.secondary {
        color: #10365a;

        border-color: #cfe6e8;

        background: #eef8f8;
    }

    .profile-action.secondary:hover {
        color: #10365a;

        border-color: #b7dade;

        background: #e3f2f2;
    }

    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 640px) {

        .profile-page {
            padding: 18px 12px 32px;
        }

        .profile-card {
            border-radius: 13px;
        }

        .profile-hero {
            min-height: 116px;
            padding: 18px 20px;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            flex-basis: 72px;
        }

        .profile-hero-content {
            gap: 14px;
        }

        .profile-hero h1 {
            font-size: 22px;
        }

        .profile-hero p {
            font-size: 14px;
        }

        .profile-body {
            padding: 20px;
        }

        .profile-columns {
            display: block;
        }

        .profile-column,
        .profile-column + .profile-column {
            min-height: auto;
            padding: 0 0 22px;
            border: 0;
        }

        .profile-column + .profile-column {
            padding-top: 22px;
            border-top: 1px solid #e6efee;
        }

        .profile-actions {
            flex-wrap: wrap;
        }
    }
</style>


<div class="profile-page">

    {{-- =========================================================
         PROFILE CARD
         ========================================================= --}}

    <div class="profile-card">


        {{-- =====================================================
             HERO
             ====================================================== --}}
        <div class="profile-hero">


            {{-- =====================================================
                 HERO CONTENT
                 ====================================================== --}}
            <div class="profile-hero-content">

                <div class="profile-avatar">

                    @if($user->profile_photo_src)

                        <img
                            src="{{ $user->profile_photo_src }}"
                            alt=""
                            class="w-full h-full object-cover"
                            onerror="
                                this.classList.add('hidden');
                                this.nextElementSibling.classList.remove('hidden');
                            "
                        >

                        <svg
                            class="hidden h-12 w-12"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                        </svg>

                    @else

                        <svg
                            class="h-12 w-12"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                        </svg>

                    @endif

                </div>


                <div>

                    <h1 class="text-[25px] font-bold leading-tight text-white">
                        {{ $user->name }}
                    </h1>

                    <p class="mt-1 text-base text-white">
                        {{ ucfirst($user->role) }}
                    </p>

                </div>

            </div>

        </div>


        {{-- =========================================================
             PROFILE BODY
             ========================================================== --}}
        <div class="profile-body">

            <div class="profile-columns">


                {{-- =================================================
                     ACCOUNT
                     ================================================= --}}
                <div class="profile-column">

                    <h3 class="profile-section-title">

                        <span class="profile-section-icon account">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
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


                    <dl class="profile-details">

                        <div>

                            <dt>
                                E-mail
                            </dt>

                            <dd>
                                {{ $user->email }}
                            </dd>

                        </div>


                        <div>

                            <dt>
                                Peran
                            </dt>

                            <dd>
                                {{ ucfirst($user->role) }}
                            </dd>

                        </div>

                    </dl>

                </div>


                {{-- =================================================
                     PROFILE
                     ================================================= --}}
                <div class="profile-column">

                    <h3 class="profile-section-title">

                        <span class="profile-section-icon document">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7 3h7l4 4v14H7V3Zm7 0v5h4M10 12h5m-5 3h5"
                                />
                            </svg>

                        </span>

                        Profil

                    </h3>


                    @if($profile)


                        {{-- CLIENT --}}
                        @if($user->isClient())

                            <dl class="profile-details">

                                <div>
                                    <dt>Nama UKM</dt>
                                    <dd>{{ $profile->nama_ukm }}</dd>
                                </div>

                                <div>
                                    <dt>Jenis Produk</dt>
                                    <dd>{{ $profile->nama_produk }}</dd>
                                </div>

                                <div>
                                    <dt>Status</dt>
                                    <dd
                                        class="{{ $profile->status === 'aktif'
                                            ? 'text-emerald-600'
                                            : 'text-gray-500' }}"
                                    >
                                        {{ ucfirst($profile->status) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Link Google Drive</dt>
                                    <dd class="text-sm font-medium text-gray-800">
                                        @if($profile->gdrive_src)
                                            <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#079aaa] underline hover:text-[#087f91]">Buka Google Drive</a>
                                        @else
                                            <span class="font-normal text-gray-400">Belum diisi</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>


                        {{-- MENTOR --}}
                        @elseif($user->isMentor())

                            <dl class="profile-details">

                                <div>
                                    <dt>Keahlian</dt>
                                    <dd>{{ $profile->keahlian }}</dd>
                                </div>

                                <div>
                                    <dt>Pengalaman</dt>
                                    <dd>{{ $profile->pengalaman ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt>Ketersediaan</dt>
                                    <dd
                                        class="{{ $profile->is_available
                                            ? 'text-emerald-600'
                                            : 'text-amber-600' }}"
                                    >
                                        {{ $profile->is_available
                                            ? 'Available'
                                            : 'Unavailable' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Link Google Drive</dt>
                                    <dd class="text-sm font-medium text-gray-800">
                                        @if($profile->gdrive_src)
                                            <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#079aaa] underline hover:text-[#087f91]">Buka Google Drive</a>
                                        @else
                                            <span class="font-normal text-gray-400">Belum diisi</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>


                        {{-- TALENT --}}
                        @elseif($user->isTalent())

                            <dl class="profile-details">

                                <div>
                                    <dt>Keahlian</dt>
                                    <dd>{{ $profile->keahlian }}</dd>
                                </div>

                                <div>
                                    <dt>Status Pekerjaan</dt>
                                    <dd>{{ ucfirst($profile->status_pekerjaan ?? '-') }}</dd>
                                </div>

                                <div>
                                    <dt>Mentor</dt>
                                    <dd>{{ $profile->mentor->nama ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Link Google Drive</dt>
                                    <dd class="text-sm font-medium text-gray-800">
                                        @if($profile->gdrive_src)
                                            <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#079aaa] underline hover:text-[#087f91]">Buka Google Drive</a>
                                        @else
                                            <span class="font-normal text-gray-400">Belum diisi</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>

                        @endif


                    @else

                        <p class="text-sm text-gray-500">
                            Profil belum lengkap.
                        </p>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                 BUTTONS
                 ====================================================== --}}
            <div class="profile-actions">

                <a href="{{ route('profile.edit') }}" class="profile-action primary">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m16.86 3.49 3.65 3.65M4 20l3.95-.8L19.5 7.65a2.58 2.58 0 0 0-3.65-3.65L4.3 15.55 4 20Z"
                        />
                    </svg>

                    Edit Profil

                </a>


                <a href="{{ route('public.index') }}" class="profile-action secondary">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 12H5m6-6-6 6 6 6"
                        />
                    </svg>

                    Kembali ke Beranda

                </a>

            </div>

        </div>

    </div>

</div>

@endsection