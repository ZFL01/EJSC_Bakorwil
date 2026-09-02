<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu Persetujuan - EJSC Bakorwil Jember</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(53,191,209,.45); }
            70%  { box-shadow: 0 0 0 18px rgba(53,191,209,0); }
            100% { box-shadow: 0 0 0 0 rgba(53,191,209,0); }
        }
        .pulse-icon { animation: pulse-ring 2s infinite; }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-gray-100 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <div class="w-full max-w-md text-center">

        <!-- Ikon -->
        <div class="mx-auto w-20 h-20 rounded-full bg-[#effcfd] dark:bg-[#121212] border border-[#35BFD1]/30 flex items-center justify-center pulse-icon mb-5">
            <span class="material-symbols-outlined text-4xl text-[#239EAF]">hourglass_top</span>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pendaftaran Terkirim!</h1>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-3 leading-relaxed">
            Terima kasih, <span class="font-semibold">{{ $nama }}</span>! 🙌
        </p>

        <!-- Card -->
        <div class="bg-white dark:bg-[#121212] rounded-xl shadow-md border border-gray-100 dark:border-gray-800 p-6 mt-5 text-left">

            <div class="rounded-lg bg-[#effcfd] dark:bg-[#0f1e21] border border-[#35BFD1]/30 p-4">
                <p class="text-sm text-gray-700 dark:text-gray-200">
                    Akun Anda sebagai <span class="font-bold text-[#239EAF]">{{ $role }}</span>
                    dengan email <span class="font-semibold">{{ $email }}</span>
                    saat ini <strong>menunggu persetujuan admin</strong>.
                </p>
            </div>

            <ul class="mt-5 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-lg text-[#239EAF] mt-0.5">check_circle</span>
                    Admin telah diberi notifikasi dan akan meninjau pendaftaran Anda.
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-lg text-[#239EAF] mt-0.5">schedule</span>
                    Proses persetujuan biasanya cepat. Anda belum dapat login sebelum disetujui.
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-lg text-[#239EAF] mt-0.5">login</span>
                    Setelah disetujui, cukup <strong>Login dengan Google</strong> lagi di halaman ini
                    dan Anda langsung masuk — tanpa perlu memilih peran lagi.
                </li>
            </ul>

            <a href="{{ route('login') }}"
               class="mt-6 block w-full text-center text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm"
               style="background: linear-gradient(135deg, #35BFD1, #239EAF);">
                Kembali ke Halaman Login
            </a>
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-4">
            EJSC Bakorwil Jember — Kolaborasi Tanpa Batas
        </p>
    </div>
</body>
</html>
