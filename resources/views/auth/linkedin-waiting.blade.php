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
    @vite(['resources/css/linkedin-waiting.css'])
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
            <span class="linkedin-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
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
                    <span>Setelah disetujui, cukup <strong>Login dengan LinkedIn</strong> lagi dan Anda langsung masuk — tanpa perlu memilih peran lagi.</span>
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