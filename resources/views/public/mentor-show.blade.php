@extends('layouts.app')

@section(
    'title',
    'Profil Mentor - ' . ($mentor->nama ?? 'Mentor')
)

@section('content')

<div class="min-h-screen bg-[#f8feff] py-12">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">


        <!-- BACK -->

        <a
            href="{{ route('mentor') }}"
            class="
                inline-flex
                items-center
                gap-2
                mb-8
                text-[#16b8c4]
                font-medium
                hover:text-[#159da8]
            "
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="
                        M15 19l-7-7
                        7-7
                    "
                />

            </svg>

            Kembali ke Mentor

        </a>


        <!-- PROFILE -->

        <div
            class="
                bg-white
                rounded-3xl
                shadow-xl
                border
                border-[#dceff2]
                overflow-hidden
            "
        >


            <!-- HEADER -->

            <div
                class="
                    p-8
                    md:p-10
                    bg-gradient-to-br
                    from-[#dffbfc]
                    via-white
                    to-[#f3feff]
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        md:flex-row
                        items-center
                        md:items-start
                        gap-6
                    "
                >

                    @php

                        $nama =
                            $mentor->nama
                            ?? 'Mentor';

                        $avatar =
                            collect(
                                preg_split(
                                    '/\s+/',
                                    trim($nama)
                                )
                            )
                            ->filter()
                            ->take(2)
                            ->map(
                                fn($word) =>
                                strtoupper(
                                    substr(
                                        $word,
                                        0,
                                        1
                                    )
                                )
                            )
                            ->implode('');

                    @endphp


                    <div
                        class="
                            w-28
                            h-28
                            rounded-3xl
                            bg-gradient-to-br
                            from-[#20c4ce]
                            to-[#159da8]
                            text-white
                            flex
                            items-center
                            justify-center
                            text-3xl
                            font-bold
                            shadow-lg
                        "
                    >
                        {{ $avatar ?: 'ME' }}
                    </div>


                    <div
                        class="
                            text-center
                            md:text-left
                        "
                    >

                        <span
                            class="
                                inline-block
                                px-3
                                py-1
                                rounded-full
                                bg-[#dcf8fa]
                                text-[#138d98]
                                text-sm
                                font-medium
                                mb-3
                            "
                        >
                            Mentor
                        </span>


                        <h1
                            class="
                                text-3xl
                                md:text-4xl
                                font-bold
                                text-[#12344d]
                            "
                        >
                            {{ $nama }}
                        </h1>


                        <p
                            class="
                                mt-2
                                text-lg
                                font-medium
                                text-[#16aeb9]
                            "
                        >
                            {{ $mentor->keahlian ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            <!-- CONTENT -->

            <div class="p-8 md:p-10">

                <h2
                    class="
                        text-2xl
                        font-bold
                        text-[#12344d]
                        mb-6
                    "
                >
                    Informasi Mentor
                </h2>


                <div
                    class="
                        grid
                        md:grid-cols-2
                        gap-5
                    "
                >

                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Nama
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->nama ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Jenis Kelamin
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->jenis_kelamin ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Domisili
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->domisili ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->keahlian ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Pengalaman
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{
                                $mentor->pengalaman
                                ?? '-'
                            }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Email
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                                break-all
                            "
                        >
                            {{ $mentor->email ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            No. WhatsApp
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->no_wa ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Alamat Lengkap
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->alamat_lengkap ?? '-' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Status
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-green-600
                            "
                        >
                            Aktif
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Portofolio
                        </p>

                        @if(!empty($mentor->portofolio_src))

                            <a
                                href="{{ $mentor->portofolio_src }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#16b8c4]
                                    hover:underline
                                    break-all
                                "
                            >
                                Lihat Portofolio
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#12344d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            CV / Resume
                        </p>

                        @if(!empty($mentor->cv_src))

                            <a
                                href="{{ $mentor->cv_src }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#16b8c4]
                                    hover:underline
                                    break-all
                                "
                            >
                                Lihat CV
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#12344d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Google Drive
                        </p>

                        @if(!empty($mentor->gdrive_src))

                            <a
                                href="{{ $mentor->gdrive_src }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    mt-1
                                    inline-block
                                    font-semibold
                                    text-[#16b8c4]
                                    hover:underline
                                    break-all
                                "
                            >
                                Buka Google Drive
                            </a>

                        @else

                            <p
                                class="
                                    mt-1
                                    font-semibold
                                    text-[#12344d]
                                "
                            >
                                -
                            </p>

                        @endif

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Tag Keahlian
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            @if(!empty($mentor->expertise_tags))
                                {{ implode(', ', $mentor->expertise_tags) }}
                            @else
                                -
                            @endif
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Ketersediaan
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                {{
                                    $mentor->is_available === null
                                        ? 'text-[#78909c]'
                                        : ($mentor->is_available ? 'text-green-600' : 'text-[#78909c]')
                                }}
                            "
                        >
                            {{
                                $mentor->is_available === null
                                    ? '-'
                                    : ($mentor->is_available ? 'Tersedia' : 'Tidak Tersedia')
                            }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            bg-[#f8feff]
                            p-5
                        "
                    >

                        <p
                            class="
                                text-sm
                                text-[#78909c]
                            "
                        >
                            Jumlah Mentee
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->jumlah_mentee ?? '0' }}
                        </p>

                    </div

                    >
                      <div
                        class="rounded-2xl bg-[#f8feff] p-5"
                    >
                        <p
                            class="
                                text-sm
                                text-[#78909c]"
                        >
                            Sosial Media
                        </p>

                        <p
                            class="
                                mt-1
                                font-semibold
                                text-[#12344d]
                            "
                        >
                            {{ $mentor->sosial_media ?? '-' }}
                        </p>

                    </div>

                </div>

                <div class="mt-8">

                    <h2
                        class="
                            text-xl
                            font-bold
                            text-[#12344d]
                            mb-3
                        "
                    >
                        Tentang Mentor
                    </h2>

                    <p
                        class="
                            text-[#64748b]
                            leading-relaxed
                        "
                    >
                        {{ $mentor->bio ?? 'Belum ada deskripsi tentang mentor ini.' }}
                    </p>

                </div>

                {{-- =========================================================
                     RATING & ULASAN MENTOR
                     ========================================================= --}}
                @php
                    $mentorRatings = $mentor->ratings ?? collect();
                    $mentorRatingCount = $mentorRatings->count();
                    $mentorRatingAverage = $mentorRatingCount > 0
                        ? $mentorRatings->avg('rating')
                        : 0;

                    $currentClientId = null;

                    if (auth()->check()) {
                        $currentClientId = \App\Models\Client::where(
                            'id_user',
                            auth()->user()->id_user
                        )->value('id_client');
                    }

                    $hasRatedMentor = $currentClientId
                        ? $mentorRatings->contains(
                            fn ($rating) => (int) $rating->client_id === (int) $currentClientId
                        )
                        : false;
                @endphp

                <div class="mt-10">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-[#12344d]">
                                Rating &amp; Ulasan Mentor
                            </h2>
                            <p class="text-sm text-[#78909c] mt-1">
                                Ulasan dari Client yang telah memberikan penilaian.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 rounded-2xl bg-[#f8feff] px-5 py-3">
                            <span class="text-3xl text-amber-400">★</span>
                            <div>
                                <p class="text-2xl font-bold text-[#12344d] leading-none">
                                    {{ number_format((float) $mentorRatingAverage, 1) }}
                                </p>
                                <p class="text-xs text-[#78909c] mt-1">
                                    {{ $mentorRatingCount }} ulasan
                                </p>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-5 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @auth
                        @if ($currentClientId)
                            @if ($hasRatedMentor)
                                <div class="mb-7 rounded-2xl bg-[#f8feff] border border-[#dceff2] p-5">
                                    <p class="font-semibold text-[#12344d]">
                                        Terima kasih, Anda sudah memberikan rating untuk mentor ini.
                                    </p>
                                    <p class="text-sm text-[#78909c] mt-1">
                                        Satu Client hanya dapat memberikan satu rating untuk setiap profil.
                                    </p>
                                </div>
                            @else
                                <form
                                    action="{{ route('rating.store') }}"
                                    method="POST"
                                    class="mb-8 rounded-2xl bg-white border border-[#dceff2] p-6 md:p-7 shadow-sm"
                                >
                                    @csrf

                                    <input type="hidden" name="rateable_type" value="mentor">
                                    <input type="hidden" name="rateable_id" value="{{ $mentor->id_mentor }}">

                                    <div class="flex items-start gap-3 mb-6">
                                        <div class="w-10 h-10 rounded-full bg-[#e6f9fb] flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-[#16b8c4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-[#12344d] text-lg">
                                                Bagikan pengalaman Anda
                                            </h3>
                                            <p class="text-sm text-[#78909c] mt-0.5">
                                                Penilaian Anda membantu client lain menemukan mentor yang tepat.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- RATING BINTANG --}}
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-[#12344d] mb-2.5">
                                            Seberapa puas Anda dengan mentor ini?
                                        </label>

                                        <div class="rating-stars-mentor flex flex-row-reverse items-center justify-end gap-1">
                                            <input id="mentor-rating-5" type="radio" name="rating" value="5" class="peer/5 sr-only" required {{ (int) old('rating') === 5 ? 'checked' : '' }}>
                                            <label for="mentor-rating-5" class="rating-star-mentor cursor-pointer text-4xl text-slate-200 transition-all duration-150 hover:scale-110" aria-label="5 bintang">★</label>

                                            <input id="mentor-rating-4" type="radio" name="rating" value="4" class="peer/4 sr-only" required {{ (int) old('rating') === 4 ? 'checked' : '' }}>
                                            <label for="mentor-rating-4" class="rating-star-mentor cursor-pointer text-4xl text-slate-200 transition-all duration-150 hover:scale-110" aria-label="4 bintang">★</label>

                                            <input id="mentor-rating-3" type="radio" name="rating" value="3" class="peer/3 sr-only" required {{ (int) old('rating') === 3 ? 'checked' : '' }}>
                                            <label for="mentor-rating-3" class="rating-star-mentor cursor-pointer text-4xl text-slate-200 transition-all duration-150 hover:scale-110" aria-label="3 bintang">★</label>

                                            <input id="mentor-rating-2" type="radio" name="rating" value="2" class="peer/2 sr-only" required {{ (int) old('rating') === 2 ? 'checked' : '' }}>
                                            <label for="mentor-rating-2" class="rating-star-mentor cursor-pointer text-4xl text-slate-200 transition-all duration-150 hover:scale-110" aria-label="2 bintang">★</label>

                                            <input id="mentor-rating-1" type="radio" name="rating" value="1" class="peer/1 sr-only" required {{ (int) old('rating') === 1 ? 'checked' : '' }}>
                                            <label for="mentor-rating-1" class="rating-star-mentor cursor-pointer text-4xl text-slate-200 transition-all duration-150 hover:scale-110" aria-label="1 bintang">★</label>
                                        </div>

                                        <p id="mentor-rating-label" class="mt-2 text-sm font-medium text-[#78909c] h-5">
                                            @if(old('rating'))
                                                @php
                                                    $oldRatingLabels = [
                                                        1 => 'Kurang memuaskan',
                                                        2 => 'Cukup',
                                                        3 => 'Baik',
                                                        4 => 'Sangat baik',
                                                        5 => 'Luar biasa!',
                                                    ];
                                                @endphp
                                                {{ $oldRatingLabels[(int) old('rating')] ?? '' }}
                                            @endif
                                        </p>
                                    </div>

                                    {{-- KOMENTAR --}}
                                    <div class="mb-5">
                                        <label for="mentor-comment" class="block text-sm font-medium text-[#12344d] mb-2">
                                            Ceritakan pengalaman Anda <span class="text-[#78909c] font-normal">(opsional)</span>
                                        </label>
                                        <textarea
                                            id="mentor-comment"
                                            name="comment"
                                            rows="4"
                                            maxlength="1000"
                                            placeholder="Apa yang membuat Anda puas? Bagaimana kualitas bimbingannya? Tulis di sini..."
                                            class="w-full rounded-xl border border-[#d6e8eb] bg-[#fbfeff] px-4 py-3 text-sm text-[#12344d] placeholder:text-[#a0b4bd] outline-none focus:ring-2 focus:ring-[#20c4ce] focus:border-transparent transition resize-none"
                                        >{{ old('comment') }}</textarea>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 border-t border-[#eaf5f7]">
                                        <p class="text-xs text-[#94a3b8]">
                                            Rating dapat diubah selama belum dikirim.
                                        </p>
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#16b8c4] px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-[#159da8] hover:shadow-md hover:shadow-[#16b8c4]/30 active:scale-[0.98]"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                            </svg>
                                            Kirim Penilaian
                                        </button>
                                    </div>
                                </form>

                                {{-- Script untuk rating interaktif --}}
                                <script>
                                    (function() {
                                        const stars = document.querySelectorAll('.rating-stars-mentor .rating-star-mentor');
                                        const label = document.getElementById('mentor-rating-label');
                                        const labels = {
                                            1: 'Kurang memuaskan',
                                            2: 'Cukup',
                                            3: 'Baik',
                                            4: 'Sangat baik',
                                            5: 'Luar biasa!'
                                        };

                                        const starsArr = Array.from(stars).reverse();

                                        function resetStars() {
                                            starsArr.forEach(s => {
                                                s.classList.remove('text-amber-400');
                                                s.classList.add('text-slate-200');
                                            });
                                        }

                                        function paintStars(count) {
                                            starsArr.forEach((s, i) => {
                                                if (i < count) {
                                                    s.classList.remove('text-slate-200');
                                                    s.classList.add('text-amber-400');
                                                } else {
                                                    s.classList.remove('text-amber-400');
                                                    s.classList.add('text-slate-200');
                                                }
                                            });
                                        }

                                        starsArr.forEach((star, index) => {
                                            star.addEventListener('mouseenter', () => {
                                                paintStars(index + 1);
                                                if (label) label.textContent = labels[index + 1] || '';
                                            });

                                            star.addEventListener('click', () => {
                                                paintStars(index + 1);
                                                if (label) label.textContent = labels[index + 1] || '';
                                            });
                                        });

                                        const container = document.querySelector('.rating-stars-mentor');
                                        if (container) {
                                            container.addEventListener('mouseleave', () => {
                                                const checked = document.querySelector('.rating-stars-mentor input:checked');
                                                if (checked) {
                                                    const val = parseInt(checked.value);
                                                    paintStars(val);
                                                    if (label) label.textContent = labels[val] || '';
                                                } else {
                                                    resetStars();
                                                    if (label) label.textContent = '';
                                                }
                                            });
                                        }

                                        const checked = document.querySelector('.rating-stars-mentor input:checked');
                                        if (checked) {
                                            paintStars(parseInt(checked.value));
                                        }
                                    })();
                                </script>
                            @endif
                        @else
                            <div class="mb-7 rounded-2xl bg-amber-50 border border-amber-200 p-5">
                                <p class="font-semibold text-amber-800">
                                    Rating hanya dapat diberikan oleh Client.
                                </p>
                                <p class="text-sm text-amber-700 mt-1">
                                    Akun Anda belum terdaftar sebagai Client.
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="mb-7 rounded-2xl bg-[#f8feff] border border-[#dceff2] p-5">
                            <p class="font-semibold text-[#12344d]">
                                Ingin memberikan rating untuk mentor ini?
                            </p>
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex mt-3 text-sm font-semibold text-[#16b8c4] hover:underline"
                            >
                                Login terlebih dahulu
                            </a>
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse ($mentorRatings as $rating)
                            <div class="rounded-2xl bg-white border border-[#dceff2] p-5 shadow-sm">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-[#12344d]">
                                            {{ $rating->client->nama_ukm ?? 'Client' }}
                                        </p>
                                        <p class="text-xs text-[#78909c] mt-1">
                                            {{ $rating->created_at?->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="text-amber-400 tracking-wide" aria-label="Rating {{ $rating->rating }} dari 5">
                                        {!! str_repeat('★', (int) $rating->rating) !!}<span class="text-slate-300">{!! str_repeat('★', max(0, 5 - (int) $rating->rating)) !!}</span>
                                    </div>
                                </div>

                                @if ($rating->comment)
                                    <p class="mt-4 text-sm text-[#64748b] leading-relaxed">
                                        {{ $rating->comment }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-2xl bg-[#f8feff] border border-dashed border-[#cfe5e8] p-6 text-center">
                                <p class="font-semibold text-[#12344d]">
                                    Belum ada rating atau komentar.
                                </p>
                                <p class="text-sm text-[#78909c] mt-1">
                                    Jadilah Client pertama yang memberikan penilaian untuk mentor ini.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection