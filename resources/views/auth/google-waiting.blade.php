<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Menunggu Persetujuan - EJSC Bakorwil Jember</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    {{-- Material Icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custom CSS --}}
    @vite(['resources/css/google-waiting.css'])
</head>

<body>

    <div class="container">

        {{-- Icon with pulse --}}
        <div class="icon-wrapper pulse-icon">
            <span class="material-symbols-outlined">hourglass_top</span>
        </div>

        {{-- Status Badge --}}
        <div class="status-badge">
            <span class="dot"></span>
            Menunggu Persetujuan
        </div>

        {{-- Title --}}
        <h1 class="title">Pendaftaran Terkirim!</h1>

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

                    <span>
                        Admin telah diberi notifikasi dan akan meninjau pendaftaran Anda.
                    </span>
                </div>

                <div class="feature-item">
                    <span class="icon">
                        <span class="material-symbols-outlined">schedule</span>
                    </span>

                    <span>
                        Proses persetujuan biasanya cepat. Anda belum dapat login sebelum disetujui.
                    </span>
                </div>

                <div class="feature-item">
                    <span class="icon">
                        <span class="material-symbols-outlined">login</span>
                    </span>

                    <span>
                        Setelah disetujui, cukup <strong>Login dengan Google</strong> lagi dan Anda langsung masuk — tanpa perlu memilih peran lagi.
                    </span>
                </div>

            </div>

            <div class="feature-item">
                <span style="text-align: center; width: 100%;">
                    Hubungi Admin
                    <br>

                    <a
                        href="https://wa.me/6287838522297"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="
                            display: inline-block;
                            color: #fff;
                            background: #25D366;
                            font-weight: 700;
                            text-decoration: none;
                            padding: 4px 10px;
                            border-radius: 6px;
                            margin-top: 5px;
                        "
                    >
                        WhatsApp Admin
                    </a>
                </span>
            </div>

            {{-- Button --}}
            <a href="{{ route('login') }}" class="btn-primary" style="margin-top: 20px;">
                Kembali ke Halaman Login
            </a>

        </div>

        {{-- Footer --}}
        <p class="footer">
            EJSC Bakorwil Jember — Kolaborasi Tanpa Batas
        </p>

    </div>

</body>

</html>