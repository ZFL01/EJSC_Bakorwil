<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu Persetujuan - EJSC Bakorwil Jember</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/github-waiting.css'])
</head>
<body>

    {{-- Background Decorative Elements --}}
    <div class="background-decor">
        <div class="dot-grid"></div>
        <div class="wave-1"></div>
        <div class="wave-2"></div>
    </div>

    <div class="container">

        {{-- Icon dengan Pulse --}}
        <div class="icon-wrapper">
            <span class="github-icon">
                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/>
                </svg>
            </span>
        </div>

        {{-- Status Badge --}}
        <div class="status-badge">
            <span class="dot"></span>
            Menunggu Persetujuan
        </div>

        {{-- Title --}}
        <h1 class="title">Pendaftaran Terkirim! 🎉</h1>
        <p class="subtitle">
            Terima kasih, <strong>{{ $nama }}</strong>!
        </p>

        {{-- Card --}}
        <div class="card">

            {{-- Info Box --}}
            <div class="info-box">
                <p>
                    Akun Anda sebagai <span class="highlight">{{ $role }}</span>
                    dengan email <span class="highlight">{{ $email }}</span>
                    saat ini <strong>menunggu persetujuan admin</strong>.
                </p>
            </div>

            {{-- Feature List --}}
            <div class="feature-list">
                <div class="feature-item">
                    <span class="icon">
                        <span class="material-symbols-outlined">check_circle</span>
                    </span>
                    <span>Admin telah diberi notifikasi dan akan meninjau pendaftaran Anda.</span>
                </div>
                <div class="feature-item">
                    <span class="icon">
                        <span class="material-symbols-outlined">schedule</span>
                    </span>
                    <span>Proses persetujuan biasanya cepat. Anda belum dapat login sebelum disetujui.</span>
                </div>
                <div class="feature-item">
                    <span class="icon">
                        <span class="material-symbols-outlined">login</span>
                    </span>
                    <span>Setelah disetujui, cukup <strong>Login dengan GitHub</strong> lagi dan Anda langsung masuk — tanpa perlu memilih peran lagi.</span>
                </div>
            </div>

            {{-- Button --}}
            <a href="{{ route('login') }}" class="btn-primary">
                Kembali ke Halaman Login
            </a>

        </div>

        {{-- Footer --}}
        <div class="footer-wrapper">
            <p class="footer">
                EJSC Bakorwil Jember — Kolaborasi Tanpa Batas
            </p>
        </div>

    </div>

</body>
</html>