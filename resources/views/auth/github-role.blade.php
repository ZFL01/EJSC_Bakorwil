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
    @vite(['resources/css/github-role.css'])
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
                <span class="github-icon">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/>
                    </svg>
                </span>
            </div>
            <h1>Lengkapi Pendaftaran</h1>
            <p class="subtitle">
                Halo, <strong>{{ $githubName }}</strong>
                <span class="email">({{ $githubEmail }})</span>
                <span class="note">✨ Pilih peran yang Anda inginkan. Akun Anda akan <strong>menunggu persetujuan admin</strong> sebelum dapat digunakan.</span>
            </p>
        </div>

        {{-- Card --}}
        <div class="card">

            {{-- GitHub Info --}}
            @if (isset($githubAvatar) || isset($githubUsername))
            <div class="github-info">
                @if (isset($githubAvatar))
                <div class="avatar">
                    <img src="{{ $githubAvatar }}" alt="Avatar GitHub">
                </div>
                @endif
                <div class="info">
                    <span class="username">{{ $githubUsername ?? $githubName }}</span>
                    @if (isset($githubBio))
                    <span class="bio">{{ $githubBio }}</span>
                    @endif
                </div>
            </div>
            @endif

            {{-- Error Messages --}}
            @if (isset($errors) && $errors->any())
                <div class="alert-error">
                    <span class="material-symbols-outlined">error</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('github.complete') }}" id="role-form">
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
            <form method="POST" action="{{ route('github.cancel') }}">
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