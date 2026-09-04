<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Peran - EJSC Bakorwil Jember</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    {{-- Material Icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/linkedin-role.css'])
</head>
<body>

    {{-- Background Decorative Elements --}}
    <div class="background-decor">
        <div class="dot-grid"></div>
        <div class="wave-1"></div>
        <div class="wave-2"></div>
        <div class="shape-1"></div>
        <div class="shape-2"></div>
    </div>

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="icon-wrapper">
                <span class="linkedin-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </span>
            </div>
            <h1>Lengkapi Pendaftaran</h1>
            <p class="subtitle">
                Halo, <strong>{{ $linkedinName }}</strong>
                <span class="email">({{ $linkedinEmail }})</span>
                <span class="note">✨ Pilih peran yang Anda inginkan. Akun Anda akan <strong>menunggu persetujuan admin</strong> sebelum dapat digunakan.</span>
            </p>
        </div>

        {{-- Card --}}
        <div class="card">

            {{-- LinkedIn Info --}}
            @if (!empty($linkedinAvatar) || !empty($linkedinHeadline))
            <div class="linkedin-info">
                @if (!empty($linkedinAvatar))
                <div class="avatar">
                    <img src="{{ $linkedinAvatar }}" alt="Avatar LinkedIn">
                </div>
                @endif
                <div class="info">
                    <span class="name">{{ $linkedinName }}</span>
                    @if (!empty($linkedinHeadline))
                    <span class="headline">{{ $linkedinHeadline }}</span>
                    @endif
                </div>
            </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert-error">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('linkedin.complete') }}" id="role-form">
                @csrf

                <div class="role-list">

                    @php
                        $roles = [
                            'mentor' => [
                                'icon' => 'school',
                                'judul' => 'Mentor',
                                'deskripsi' => 'Membimbing dan melatih talenta'
                            ],
                            'talenta' => [
                                'icon' => 'emoji_events',
                                'judul' => 'Talenta',
                                'deskripsi' => 'Menunjukkan kemampuan & portofolio'
                            ],
                            'client' => [
                                'icon' => 'business_center',
                                'judul' => 'Client',
                                'deskripsi' => 'Mencari mentor dan talenta'
                            ],
                        ];
                    @endphp

                    @foreach ($roles as $role => $info)
                        <label class="role-card">
                            <input type="radio"
                                   name="role"
                                   value="{{ $role }}"
                                   {{ old('role') === $role ? 'checked' : '' }}
                                   required>
                            <span class="role-icon">
                                <span class="material-symbols-outlined">{{ $info['icon'] }}</span>
                            </span>
                            <span class="role-info">
                                <span class="role-name">{{ $info['judul'] }}</span>
                                <span class="role-desc">{{ $info['deskripsi'] }}</span>
                            </span>
                        </label>
                    @endforeach

                </div>

                <button type="submit" class="btn-primary" id="submit-btn">
                    <span class="material-symbols-outlined">send</span>
                    Daftar &amp; Kirim ke Admin
                </button>
            </form>

            {{-- Cancel Button --}}
            <form method="POST" action="{{ route('linkedin.cancel') }}">
                @csrf
                <button type="submit" class="btn-cancel">
                    Batalkan pendaftaran
                </button>
            </form>

        </div>

    </div>

    {{-- JavaScript --}}
    <script>
        (function() {
            'use strict';

            const cards = document.querySelectorAll('.role-card');
            const submitBtn = document.getElementById('submit-btn');

            // Highlight card yang dipilih
            cards.forEach(function(card) {
                const radio = card.querySelector('input[type="radio"]');

                radio.addEventListener('change', function() {
                    cards.forEach(function(c) {
                        c.classList.remove('selected');
                    });
                    if (this.checked) {
                        card.classList.add('selected');
                    }
                });

                // Inisialisasi jika sudah checked
                if (radio.checked) {
                    card.classList.add('selected');
                }
            });

            // Disable submit jika belum ada role yang dipilih
            function checkSelection() {
                const selected = document.querySelector('input[name="role"]:checked');
                if (submitBtn) {
                    submitBtn.disabled = !selected;
                }
            }

            // Event listener untuk semua radio
            document.querySelectorAll('input[name="role"]').forEach(function(radio) {
                radio.addEventListener('change', checkSelection);
            });

            // Initial check
            checkSelection();

        })();
    </script>

</body>
</html>