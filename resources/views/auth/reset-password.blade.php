<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - EJSC Bakorwil</title>
    <meta name="description" content="Atur ulang password akun kamu.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        html, body {
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        .form-input {
            width: 100%;
            padding: 0.65rem 0.75rem 0.65rem 2.5rem;
            background: #f9fafb;
            border-radius: 0.6rem;
            border: 1px solid #e5e7eb;
            outline: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            color: #111827;
        }

        .form-input:focus {
            background: #ffffff;
            border-color: #35BFD1;
            box-shadow: 0 0 0 3px rgba(53, 191, 209, 0.12);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.3rem;
            display: block;
        }

        .mobile-container {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            background:
                radial-gradient(circle at 12% 18%, rgba(180, 242, 248, 0.70), transparent 28%),
                radial-gradient(circle at 88% 78%, rgba(128, 226, 238, 0.55), transparent 30%),
                radial-gradient(circle at 50% 100%, rgba(190, 241, 247, 0.45), transparent 35%),
                linear-gradient(135deg, #72d6e3 0%, #45c5d6 45%, #8ddfe9 100%);
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            pointer-events: none;
        }
        .bubble-1 { width: 220px; height: 220px; top: -60px; left: -60px; }
        .bubble-2 { width: 130px; height: 130px; bottom: -40px; right: 10%; }
        .bubble-3 { width: 260px; height: 260px; bottom: -90px; left: -70px; }
    </style>
</head>

<body class="antialiased bg-white">
<main class="relative pt-20 md:pt-24 pb-10 min-h-screen flex items-center justify-center px-3 sm:px-4 md:px-6 mobile-container overflow-hidden">

        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>

        <!-- Card -->
        <div class="relative z-10 w-full max-w-[440px] flex flex-col bg-white rounded-2xl overflow-hidden shadow-2xl border border-white/20">

            <!-- Top Accent / Branding -->
            <div class="relative h-32 md:h-36">
                <img alt="EJSC Reset Password"
                     class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop&crop=center"
                     style="object-fit: cover;">
                <div class="absolute inset-0"
                     style="background: linear-gradient(135deg, rgba(53,191,209,0.92), rgba(21,149,167,0.92));">
                </div>
                <div class="relative h-full flex flex-col items-center justify-center px-6 text-center">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}"
                         alt="EJSC Bakorwil"
                         class="h-14 md:h-16 w-auto mb-1.5 brightness-0 invert">
                    <p class="text-xs md:text-sm text-white/90">
                        Buat password baru untuk akun kamu
                    </p>
                </div>
            </div>

            <!-- Reset Password Form -->
            <div class="w-full px-6 md:px-8 py-6 md:py-7">

                <div class="mb-5 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#effcff] flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[#35BFD1]" style="font-size: 22px;">
                            lock_reset
                        </span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 mb-1">
                            Reset Password
                        </h1>
                        <p class="text-sm text-gray-500">
                            Masukkan email dan password baru kamu.
                        </p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-lg mb-4">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-base">
                                check_circle
                            </span>
                            <p class="text-xs text-emerald-700">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('password.store') }}"
                      class="flex flex-col gap-4">

                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Field -->
                    <div>
                        <label class="form-label" for="email">
<!-- Password Field -->
                    <div>
                        <label class="form-label" for="password">
                            Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">
                                lock
                            </span>
                            <input class="form-input"
                                   id="password"
                                   name="password"
                                   placeholder="Minimal 8 karakter"
                                   required
                                   type="password"
                                   autocomplete="new-password">
                        </div>

                        @error('password')
                            <p class="text-xs text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="form-label" for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">
                                lock
                            </span>
                            <input class="form-input"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   required
                                   type="password"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="w-full text-white font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98] py-2.5 text-sm flex items-center justify-center gap-1.5"
                            style="background: linear-gradient(135deg, #35BFD1, #1595A7);"
                            type="submit">
                        <span class="material-symbols-outlined text-[18px]">
                            save
                        </span>
                        Simpan Password Baru
                    </button>

                    <!-- Back to Login Link -->
                    <p class="text-center text-sm text-gray-600 pt-1">
                        <a class="font-medium hover:underline inline-flex items-center gap-1"
                           href="{{ route('login') }}"
                           style="color: #35BFD1;">
                            <span class="material-symbols-outlined text-[16px]">
                                arrow_back
                            </span>
                            Kembali ke Masuk
                        </a>
                    </p>

                </form>

            </div>

        </div>

    </main>

</body>
</html>
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 material-symbols-outlined text-[18px]">
                                mail
                            </span>
                            <input class="form-input"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $email) }}"
                                   placeholder="nama@email.com"
                                   required
                                   autofocus
                                   type="email">
                        </div>

                        @error('email')
                            <p class="text-xs text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>