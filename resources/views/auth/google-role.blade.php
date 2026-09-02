<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Peran - EJSC Bakorwil Jember</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .role-card { transition: all 0.2s ease; cursor: pointer; }
        .role-card:hover { border-color: #35BFD1; box-shadow: 0 6px 18px rgba(53, 191, 209, 0.15); transform: translateY(-2px); }
        .role-card input:checked + .role-card-body { border-color: #35BFD1; background: #effcfd; }
        .role-card.selected { border-color: #35BFD1 !important; background: #effcfd; box-shadow: 0 0 0 2px rgba(53,191,209,.3); }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <div class="w-full max-w-md">

        <!-- Logo / Heading -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lengkapi Pendaftaran</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                Halo, <span class="font-semibold">{{ $googleName }}</span>
                <span class="text-gray-400 dark:text-gray-500">({{ $googleEmail }})</span>
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Pilih peran yang Anda inginkan. Akun Anda akan <strong>menunggu persetujuan admin</strong> sebelum dapat digunakan.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-[#121212] rounded-xl shadow-md border border-gray-100 dark:border-gray-800 p-6">

            @if (isset($errors) && $errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-2 rounded-lg mb-4">
                    <div class="flex items-start gap-1.5">
                        <span class="material-symbols-outlined text-red-500 text-base">error</span>
                        <ul class="text-xs text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('google.complete') }}" id="role-form">
                @csrf

                <div class="flex flex-col gap-3">

                    @foreach ([
                        'mentor'  => ['icon' => 'school',            'judul' => 'Mentor',  'deskripsi' => 'Membimbing dan melatih talenta'],
                        'talenta' => ['icon' => 'emoji_events',      'judul' => 'Talenta', 'deskripsi' => 'Menunjukkan kemampuan & portofolio'],
                        'client'  => ['icon' => 'business_center',   'judul' => 'Client',  'deskripsi' => 'Mencari mentor dan talenta'],
                    ] as $role => $info)
                        <label class="role-card flex items-center gap-3 border border-gray-200 rounded-lg p-3">
                            <input type="radio"
                                   name="role"
                                   value="{{ $role }}"
                                   class="w-4 h-4 text-[#35BFD1] focus:ring-[#35BFD1]"
                                   {{ old('role') === $role ? 'checked' : '' }}
                                   required>
                            <span class="material-symbols-outlined text-2xl text-[#35BFD1]">{{ $info['icon'] }}</span>
                            <span class="flex-1">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $info['judul'] }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $info['deskripsi'] }}</span>
                            </span>
                        </label>
                    @endforeach

                </div>

                <button type="submit"
                        class="mt-5 w-full text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm"
                        style="background: linear-gradient(135deg, #35BFD1, #239EAF);">

                    Daftar &amp; Kirim ke Admin

                </button>
            </form>

            <!-- Batal -->
            <form method="POST" action="{{ route('google.cancel') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-xs py-1.5">
                    Batalkan pendaftaran
                </button>
            </form>

        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-4">
            Catatan: akun admin tidak dapat didaftarkan melalui Google.
        </p>

    </div>

    <script>
        // Highlight kartu yang dipilih
        document.querySelectorAll('.role-card input[type="radio"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.role-card').forEach(function (card) {
                    card.classList.remove('selected');
                });
                radio.closest('.role-card').classList.add('selected');
            });
            if (radio.checked) {
                radio.closest('.role-card').classList.add('selected');
            }
        });
    </script>
</body>
</html>
