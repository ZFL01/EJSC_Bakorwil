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
    @vite(['resources/css/google-role.css'])
</head>
<body>

    {{-- Background Decorative Elements --}}
    <div class="background-decor">
        <div class="dot-grid"></div>
        <div class="wave-1"></div>
        <div class="wave-2"></div>
    </div>

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="icon-wrapper">
                <span class="material-symbols-outlined">assignment_add</span>
            </div>
            <h1>Lengkapi Pendaftaran</h1>
            <p class="subtitle">
                Halo, <strong>{{ $googleName }}</strong>
                <span class="email">({{ $googleEmail }})</span>
                <span class="note">✨ Pilih peran yang Anda inginkan. Akun Anda akan <strong>menunggu persetujuan admin</strong> sebelum dapat digunakan.</span>
            </p>
        </div>

        {{-- Card --}}
        <div class="card">

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
            <form method="POST" action="{{ route('google.complete') }}" id="role-form">
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
                    <span class="material-symbols-outlined" style="font-size:1rem;vertical-align:middle;margin-right:0.5rem;">send</span>
                    Daftar &amp; Kirim ke Admin
                </button>
            </form>

            {{-- Cancel Button --}}
            <form method="POST" action="{{ route('google.cancel') }}">
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