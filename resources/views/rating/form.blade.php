<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

    <div class="mb-5">
        <h3 class="text-lg font-bold text-[#0e4f81]">
            Berikan Penilaian
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Bagikan pengalaman Anda mengenai profil ini.
        </p>
    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200
                    text-green-700 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if(session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200
                    text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Error validasi --}}
    @if($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200
                    text-red-700 px-4 py-3 text-sm">

            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form action="{{ route('rating.store') }}" method="POST">
        @csrf

        {{-- Target rating --}}
        <input
            type="hidden"
            name="rateable_type"
            value="{{ $rateableType }}"
        >

        <input
            type="hidden"
            name="rateable_id"
            value="{{ $rateableId }}"
        >

        {{-- Rating --}}
        <div class="mb-5">

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Rating
            </label>

            <div class="flex gap-2">

                @for($i = 1; $i <= 5; $i++)

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="rating"
                            value="{{ $i }}"
                            class="sr-only peer"
                            required
                        >

                        <span
                            class="text-3xl text-gray-300
                                   peer-checked:text-yellow-400
                                   transition"
                        >
                            ★
                        </span>

                    </label>

                @endfor

            </div>

        </div>

        {{-- Komentar --}}
        <div class="mb-5">

            <label
                for="comment"
                class="block text-sm font-semibold text-gray-700 mb-2"
            >
                Komentar
            </label>

            <textarea
                id="comment"
                name="comment"
                rows="4"
                maxlength="1000"
                placeholder="Tulis pengalaman Anda..."
                class="w-full border border-gray-200 rounded-xl px-4 py-3
                       text-sm focus:outline-none
                       focus:ring-2 focus:ring-[#56b8c2]
                       focus:border-transparent"
            >{{ old('comment') }}</textarea>

            <p class="text-xs text-gray-400 mt-1">
                Maksimal 1000 karakter.
            </p>

        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="w-full bg-[#0e4f81] hover:bg-[#0b416a]
                   text-white font-semibold py-3 rounded-xl
                   transition"
        >
            Kirim Penilaian
        </button>

    </form>

</div>