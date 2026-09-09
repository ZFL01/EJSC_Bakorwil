@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-card { max-width: 850px; margin: 0 auto; overflow: hidden; border: 1px solid #dceef0; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px rgba(25, 91, 102, 0.08); }
    .profile-hero { position: relative; min-height: 128px; overflow: hidden; display: flex; align-items: center; padding: 22px 32px; background: linear-gradient(112deg, #1199b4 0%, #36bdc4 52%, #62d2be 100%); }
    .profile-hero::before { content: ''; position: absolute; width: 330px; height: 185px; right: 50px; top: -104px; border-radius: 50%; background: rgba(148, 224, 194, 0.55); transform: rotate(-18deg); }
    .profile-hero::after { content: ''; position: absolute; width: 340px; height: 170px; right: -54px; bottom: -133px; border-radius: 50%; background: rgba(19, 142, 169, 0.65); transform: rotate(-17deg); }
    .profile-leaves { position: absolute; z-index: 1; right: 27px; bottom: 9px; width: 86px; height: 72px; opacity: 0.72; animation: profile-leaves-sway 8s ease-in-out infinite; }
    .profile-leaves svg { display: block; width: 100%; height: 100%; }
    @keyframes profile-leaves-sway { 0%, 100% { transform: rotate(-1deg); } 50% { transform: rotate(1deg); } }
    .profile-hero-content { position: relative; z-index: 1; display: flex; align-items: center; gap: 22px; }
    .profile-avatar { width: 88px; height: 88px; flex: 0 0 88px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 3px solid rgba(255, 255, 255, 0.9); border-radius: 50%; background: rgba(255, 255, 255, 0.2); color: #fff; box-shadow: 0 2px 6px rgba(0, 71, 92, 0.18); }
    .profile-body { padding: 21px 24px 19px; }
    .profile-columns { display: grid; grid-template-columns: 1fr 1.15fr; }
    .profile-column { min-height: 220px; padding: 0 28px 0 0; }
    .profile-column + .profile-column { padding: 0 0 0 28px; border-left: 1px solid #cfe8ec; }
    .profile-section-title { display: flex; align-items: center; gap: 14px; margin-bottom: 15px; color: #10294e; font-size: 18px; font-weight: 700; }
    .profile-section-icon { display: inline-flex; width: 34px; height: 34px; align-items: center; justify-content: center; border-radius: 50%; }
    .profile-section-icon.account { color: #087b96; background: #d9f3f5; }
    .profile-section-icon.document { color: #258c5b; background: #e1f4d8; }
    .profile-details { display: grid; gap: 15px; }
    .profile-details dt { margin-bottom: 2px; color: #286185; font-size: 14px; }
    .profile-details dd { color: #10294e; font-size: 14px; font-weight: 600; line-height: 1.35; }
    .profile-actions { display: flex; align-items: center; gap: 16px; margin-top: 1px; }
    .profile-action { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 37px; padding: 7px 16px; border: 1px solid transparent; border-radius: 9px; font-size: 14px; font-weight: 600; transition: background-color 0.2s ease, border-color 0.2s ease; }
    .profile-action.primary { color: #fff; background: #079aaa; }
    .profile-action.primary:hover { background: #087f91; }
    .profile-action.secondary { color: #174d70; border-color: #cbe3e8; background: #f4fafb; }
    .profile-action.secondary:hover { background: #e8f5f7; }
    @media (max-width: 640px) {
        .profile-hero { min-height: 116px; padding: 18px 20px; }
        .profile-avatar { width: 72px; height: 72px; flex-basis: 72px; }
        .profile-hero-content { gap: 14px; }
        .profile-body { padding: 20px; }
        .profile-columns { display: block; }
        .profile-column, .profile-column + .profile-column { min-height: auto; padding: 0 0 22px; border: 0; }
        .profile-column + .profile-column { padding-top: 22px; border-top: 1px solid #cfe8ec; }
        .profile-actions { flex-wrap: wrap; }
    }
</style>

<div class="px-4 py-8 sm:px-6 lg:px-8">
    <div class="profile-card">
        <div class="profile-hero">
            <div class="profile-leaves" aria-hidden="true">
                <svg
    class="flower-decoration"
    viewBox="0 0 220 240"
    xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true"
>
    <defs>
        <!-- Warna bunga -->
        <linearGradient id="petalGradient" x1="70" y1="20" x2="160" y2="135">
            <stop offset="0%" stop-color="#FFF7E6" />
            <stop offset="100%" stop-color="#FFD58A" />
        </linearGradient>

        <!-- Warna daun -->
        <linearGradient id="leafGradient" x1="20" y1="65" x2="180" y2="220">
            <stop offset="0%" stop-color="#A9F6E4" />
            <stop offset="100%" stop-color="#19BFA5" />
        </linearGradient>

        <linearGradient id="centerGradient" x1="90" y1="80" x2="135" y2="130">
            <stop offset="0%" stop-color="#FFCD5E" />
            <stop offset="100%" stop-color="#F59E0B" />
        </linearGradient>

        <!-- Bayangan halus -->
        <filter id="softShadow" x="-30%" y="-30%" width="160%" height="160%">
            <feDropShadow
                dx="0"
                dy="7"
                stdDeviation="6"
                flood-color="#0A8E7A"
                flood-opacity="0.18"
            />
        </filter>
    </defs>

    <!-- Batang utama besar -->
    <path
        d="M108 233C108 199 109 169 108 139C107 111 108 90 111 71"
        fill="none"
        stroke="#35C7AD"
        stroke-width="12"
        stroke-linecap="round"
    />

    <!-- Daun kiri bawah besar -->
    <path
        d="M102 202
           C61 202 25 179 18 134
           C61 129 98 155 102 202Z"
        fill="url(#leafGradient)"
    />

    <!-- Daun kanan bawah besar -->
    <path
        d="M114 183
           C122 140 157 112 203 119
           C192 163 155 187 114 183Z"
        fill="url(#leafGradient)"
    />

    <!-- Daun kiri atas besar -->
    <path
        d="M105 151
           C72 150 45 128 41 92
           C77 89 104 116 105 151Z"
        fill="url(#leafGradient)"
    />

    <!-- Daun kanan atas besar -->
    <path
        d="M114 139
           C119 105 146 82 181 86
           C176 121 147 141 114 139Z"
        fill="url(#leafGradient)"
    />

    <!-- Bunga besar -->
    <g filter="url(#softShadow)">
        <!-- Kelopak atas -->
        <path
            d="M110 77
               C80 59 79 24 108 10
               C135 26 137 59 110 77Z"
            fill="url(#petalGradient)"
        />

        <!-- Kelopak kanan atas -->
        <path
            d="M126 84
               C124 52 151 31 181 43
               C179 76 155 94 126 84Z"
            fill="url(#petalGradient)"
        />

        <!-- Kelopak kanan bawah -->
        <path
            d="M130 102
               C159 84 190 101 188 132
               C158 145 133 131 130 102Z"
            fill="url(#petalGradient)"
        />

        <!-- Kelopak kiri bawah -->
        <path
            d="M96 104
               C88 135 57 146 34 126
               C37 95 66 84 96 104Z"
            fill="url(#petalGradient)"
        />

        <!-- Kelopak kiri atas -->
        <path
            d="M95 84
               C65 91 42 69 51 39
               C82 34 101 55 95 84Z"
            fill="url(#petalGradient)"
        />

        <!-- Tengah bunga -->
        <circle
            cx="111"
            cy="95"
            r="23"
            fill="url(#centerGradient)"
        />

        <circle
            cx="111"
            cy="95"
            r="12"
            fill="#FFF4D8"
            opacity="0.9"
        />
    </g>
</svg>
            </div>
            <div class="profile-hero-content">
                <div class="profile-avatar">
                    @if($user->profile_photo_src)
                        <img src="{{ $user->profile_photo_src }}" alt="" class="w-full h-full object-cover" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                        <svg class="hidden h-12 w-12" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/></svg>
                    @else
                        <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/></svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-[25px] font-bold leading-tight text-white">{{ $user->name }}</h1>
                    <p class="mt-1 text-base text-white">{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>

        <div class="profile-body">
            <div class="profile-columns">
                <div class="profile-column">
                    <h3 class="profile-section-title">
                        <span class="profile-section-icon account"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 20v-1a4 4 0 0 0-8 0v1m4-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg></span>
                        Informasi Akun
                    </h3>
                    <dl class="profile-details">
                        <div>
                            <dt>Email</dt>
                            <dd>{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt>Peran</dt>
                            <dd>{{ ucfirst($user->role) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="profile-column">
                    <h3 class="profile-section-title">
                        <span class="profile-section-icon document"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l4 4v14H7V3Zm7 0v5h4M10 12h5m-5 3h5"/></svg></span>
                        Profil
                    </h3>
                    @if($profile)
                        @if($user->isClient())
                            <dl class="profile-details">
                                <div>
                                    <dt class="text-sm text-gray-500">Nama UKM</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->nama_ukm }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Jenis Produk</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->nama_produk }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Status</dt>
                                    <dd class="text-sm font-medium {{ $profile->status === 'aktif' ? 'text-emerald-600' : 'text-gray-600' }}">{{ ucfirst($profile->status) }}</dd>
                                </div>
                            </dl>
                        @elseif($user->isMentor())
                            <dl class="profile-details">
                                <div>
                                    <dt class="text-sm text-gray-500">Keahlian</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->keahlian }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Pengalaman</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->pengalaman ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Ketersediaan</dt>
                                    <dd class="text-sm font-medium {{ $profile->is_available ? 'text-emerald-600' : 'text-amber-600' }}">{{ $profile->is_available ? 'Available' : 'Unavailable' }}</dd>
                                </div>
                            </dl>
                        @elseif($user->isTalent())
                            <dl class="profile-details">
                                <div>
                                    <dt class="text-sm text-gray-500">Keahlian</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->keahlian }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Status Pekerjaan</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ ucfirst($profile->status_pekerjaan ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Mentor</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->mentor->nama ?? '-' }}</dd>
                                </div>
                            </dl>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">Profil belum lengkap.</p>
                    @endif
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="profile-action primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.86 3.49 3.65 3.65M4 20l3.95-.8L19.5 7.65a2.58 2.58 0 0 0-3.65-3.65L4.3 15.55 4 20Z"/></svg>
                    Edit Profil
                </a>
                <a href="{{ route('public.index') }}" class="profile-action secondary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m6-6-6 6 6 6"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection