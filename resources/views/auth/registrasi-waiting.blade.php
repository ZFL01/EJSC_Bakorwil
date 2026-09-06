<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Terkirim - EJSC Bakorwil Jember</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eefcfe, #fff 50%, #e6f9fb);
            padding: 24px;
            position: relative;
            overflow: hidden
        }

        .background-decor {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none
        }

        .dot-grid {
            position: absolute;
            top: -40px;
            right: -40px;
            width: 280px;
            height: 280px;
            background-image: radial-gradient(circle, rgba(53, 191, 209, .18) 2px, transparent 2px);
            background-size: 18px 18px;
            border-radius: 50%
        }

        .wave-1,
        .wave-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(50px);
            opacity: .5
        }

        .wave-1 {
            width: 380px;
            height: 380px;
            background: #b6edf4;
            top: -120px;
            left: -80px
        }

        .wave-2 {
            width: 340px;
            height: 340px;
            background: #c4f2f7;
            bottom: -120px;
            right: -60px
        }

        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 460px;
            width: 100%
        }

        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 84px;
            height: 84px;
            border-radius: 24px;
            background: linear-gradient(135deg, #35BFD1, #1595A7);
            box-shadow: 0 14px 34px rgba(53, 191, 209, .35);
            animation: float 3s ease-in-out infinite
        }

        .icon-wrapper .material-symbols-outlined {
            color: #fff;
            font-size: 44px
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-8px)
            }
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            padding: 7px 16px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid #e2f4f6;
            color: #0f7a8a;
            font-size: .8rem;
            font-weight: 700
        }

        .status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse 1.6s ease-in-out infinite
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1)
            }

            50% {
                opacity: .4;
                transform: scale(.7)
            }
        }

        .title {
            margin-top: 18px;
            font-size: 1.7rem;
            font-weight: 800;
            color: #0f172a
        }

        .subtitle {
            margin-top: 8px;
            color: #475569;
            font-size: 1rem
        }

        .card {
            margin-top: 24px;
            background: #fff;
            border: 1px solid #eef2f6;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, .07)
        }

        .info-box {
            background: #f0fbfd;
            border: 1px solid #d7f1f5;
            border-radius: 12px;
            padding: 16px;
            color: #334155;
            font-size: .92rem;
            line-height: 1.6
        }

        .info-box .highlight {
            font-weight: 700;
            color: #1595A7
        }

        .feature-list {
            list-style: none;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #475569;
            font-size: .88rem;
            line-height: 1.5;
            text-align: left
        }

        .feature-item .icon {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 10px;
            background: #effcff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #35BFD1
        }

        .feature-item .icon .material-symbols-outlined {
            font-size: 18px
        }

        .feature-item strong {
            color: #0f172a
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 14px;
            padding: 13px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: .95rem;
            transition: transform .15s ease, box-shadow .15s ease
        }

        .btn:first-of-type {
            margin-top: 24px
        }

        .btn .material-symbols-outlined {
            font-size: 18px
        }

        .btn-primary {
            background: linear-gradient(135deg, #35BFD1, #1595A7);
            color: #fff;
            box-shadow: 0 10px 24px rgba(21, 149, 167, .3)
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(21, 149, 167, .38)
        }

        .btn-secondary {
            background: #fff;
            color: #1595A7;
            border: 1px solid #cbeef2
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            background: #f0fbfd
        }

        .footer {
            margin-top: 28px;
            color: #94a3b8;
            font-size: .82rem
        }

        @media(max-width:480px) {
            .title {
                font-size: 1.4rem
            }

            .card {
                padding: 20px
            }

            .icon-wrapper {
                width: 70px;
                height: 70px
            }
        }
    </style>
</head>

<body>
    <div class="background-decor">
        <div class="dot-grid"></div>
        <div class="wave-1"></div>
        <div class="wave-2"></div>
    </div>
    <div class="container">
        <div class="icon-wrapper"><span class="material-symbols-outlined">assignment_turned_in</span></div>
        <div class="status-badge"><span class="dot"></span>Menunggu Persetujuan</div>
        <h1 class="title">Pendaftaran Terkirim! 🎉</h1>
        <p class="subtitle">Terima kasih, <strong>{{ $nama }}</strong>!</p>
        <div class="card">
            <div class="info-box">
                <p>Akun Anda sebagai <span class="highlight">{{ $role }}</span> dengan email <span class="highlight">{{ $email }}</span> saat ini <strong>menunggu persetujuan admin</strong>.</p>
            </div>
            <div class="feature-list">
                <div class="feature-item"><span class="icon"><span class="material-symbols-outlined">check_circle</span></span><span>Admin telah diberi notifikasi dan akan meninjau pendaftaran Anda.</span></div>
                <div class="feature-item"><span class="icon"><span class="material-symbols-outlined">schedule</span></span><span>Proses persetujuan biasanya cepat. Anda belum dapat login sebelum disetujui.</span></div>
                <div class="feature-item"><span class="icon"><span class="material-symbols-outlined">login</span></span><span>Setelah disetujui, cukup <strong>Login dengan Email &amp; Password</strong> yang sudah Anda daftarkan.</span></div>
            </div>
            <a href="{{ route('public.index') }}" class="btn btn-secondary"><span class="material-symbols-outlined">home</span>Kembali ke Beranda</a>
            <a href="{{ route('login') }}" class="btn btn-primary"><span class="material-symbols-outlined">login</span>Ke Halaman Login</a>
        </div>
        <p class="footer">EJSC Bakorwil Jember — Kolaborasi Tanpa Batas</p>
    </div>
</body>

</html>