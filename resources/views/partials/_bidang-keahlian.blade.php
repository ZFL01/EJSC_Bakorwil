@php
    /* Variabel opsional:
       - $bkFieldKey  : string unik untuk id/JS (default: acak)
       - $bkValue     : nilai keahlian saat ini (satu atau banyak, dipisah koma)
       - $bkModel     : class model pemilik helper ('talent'|'mentor', default: talent)
       - $bkOptions   : daftar saran (default: dari model)
       - $bkLabel     : teks label (default: "Bidang Keahlian")
       - $bkInputClass: class tailwind untuk KOTAK field
       - $bkLabelClass: class tailwind untuk <label>
       - $bkWrapClass : class pembungkus grid item

       Field "Bidang Keahlian" memakai SATU field, tetapi nilainya boleh
       LEBIH DARI SATU. Setiap nilai tampil sebagai chip di dalam kotak field,
       sementara <input type="hidden" name="keahlian"> menyimpan seluruh nilai
       (dipisah koma, mis. "Desain, Video") untuk dikirim ke server. */
    $bkFieldKey = $bkFieldKey ?? 'bidang-keahlian-'.(\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6)));
    $bkRaw = old('keahlian', $bkValue ?? '');
    $bkRaw = is_array($bkRaw) ? implode(', ', $bkRaw) : (string) $bkRaw;
    $bkModelClass = ($bkModel ?? 'talent') === 'mentor' ? \App\Models\Mentor::class : \App\Models\Talent::class;
    $bkValues = $bkModelClass::keahlianList($bkRaw);
    $bkValueKeys = array_map('mb_strtolower', $bkValues);
    $bkWrapClass = $bkWrapClass ?? '';
    $bkLabel = $bkLabel ?? 'Bidang Keahlian';
    $bkLabelClass = $bkLabelClass ?? 'block text-xs font-semibold text-gray-600 mb-1';
    $bkInputClass = $bkInputClass ?? 'w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]';
    // Kotak field dibuat flex agar chip dan input mengetik bisa sejajar.
    $bkBoxClass = trim(preg_replace('/\bw-full\b/', '', $bkInputClass).' flex w-full flex-wrap items-center gap-1.5');
    $bkChipClass = 'inline-flex max-w-full items-center gap-1 rounded-full border border-[#bfe9ed] bg-[#e0f7fa] px-2 py-0.5 text-xs font-medium text-[#0f766e]';
    $bkCloseClass = 'flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-[#0f766e]/70 transition hover:bg-[#bfe9ed] hover:text-[#0f766e]';
    $bkTickClass = 'h-4 w-4 shrink-0 text-[#56b8c2]';
    $bkOptions = $bkOptions ?? $bkModelClass::BIDANG_KEAHLIAN_OPTIONS;
    $bkSeparator = ', ';
@endphp

<div class="{{ trim($bkWrapClass.' relative') }}" data-bidang-combobox>
    <label class="{{ $bkLabelClass }}" for="{{ $bkFieldKey }}">{{ $bkLabel }}</label>

    <div class="{{ $bkBoxClass }}" data-bidang-box>
        @foreach($bkValues as $bkItem)
            <span data-bidang-chip data-bidang-value="{{ $bkItem }}" class="{{ $bkChipClass }}">
                <span class="truncate">{{ $bkItem }}</span>
                <button type="button" data-bidang-remove aria-label="Hapus {{ $bkItem }}" class="{{ $bkCloseClass }}">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </span>
        @endforeach

        <input type="text"
               id="{{ $bkFieldKey }}"
               placeholder="Pilih atau ketik bidang keahlian..."
               autocomplete="off"
               role="combobox"
               aria-expanded="false"
               aria-autocomplete="list"
               aria-controls="{{ $bkFieldKey }}-list"
               data-bidang-input
               class="min-w-[140px] flex-1 border-0 bg-transparent p-1 text-sm text-inherit focus:outline-none">

        <button type="button"
                data-bidang-toggle
                tabindex="-1"
                aria-label="Tampilkan pilihan bidang keahlian"
                class="{{ $bkCloseClass }} ml-auto h-5 w-5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>

    {{-- Satu-satunya field yang dikirim ke server; berisi seluruh nilai, dipisah koma. --}}
    <input type="hidden" name="keahlian" value="{{ implode($bkSeparator, $bkValues) }}"
           data-bidang-hidden>

    <p class="mt-1 text-[11px] text-slate-400" data-bidang-help>
        Boleh lebih dari satu. Pilih dari daftar atau ketik lalu tekan Enter/koma.
    </p>

    <div data-bidang-panel
         class="absolute inset-x-0 z-30 mt-1 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
        <ul id="{{ $bkFieldKey }}-list" role="listbox" data-bidang-list class="max-h-56 overflow-y-auto py-1">
            @foreach($bkOptions as $bkOption)
                <li>
                    <button type="button"
                            role="option"
                            aria-selected="{{ in_array(mb_strtolower($bkOption), $bkValueKeys, true) ? 'true' : 'false' }}"
                            data-bidang-option="{{ $bkOption }}"
                            class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-[#effbfc] hover:text-[#1f7a81]">
                        <span data-bidang-tick class="{{ $bkTickClass }} {{ in_array(mb_strtolower($bkOption), $bkValueKeys, true) ? '' : 'invisible' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        {{ $bkOption }}
                    </button>
                </li>
            @endforeach
        </ul>
        <p data-bidang-hint class="hidden border-t border-slate-100 bg-slate-50 px-3 py-2 text-[11px] text-slate-500">
            Tidak ada di daftar? Ketikan tetap disimpan apa adanya.
        </p>
    </div>
    <script>
        (function () {
            const wrap = document.currentScript.closest('[data-bidang-combobox]');
            if (!wrap) return;

            const box = wrap.querySelector('[data-bidang-box]');
            const input = wrap.querySelector('[data-bidang-input]');
            const hidden = wrap.querySelector('[data-bidang-hidden]');
            const toggle = wrap.querySelector('[data-bidang-toggle]');
            const panel = wrap.querySelector('[data-bidang-panel]');
            const hint = wrap.querySelector('[data-bidang-hint]');
            const options = Array.from(wrap.querySelectorAll('[data-bidang-option]'));
            const separator = @json($bkSeparator);

            if (!box || !input || !hidden || !panel) return;

            // Semua nilai yang sudah dipilih (satu sumber kebenaran di sisi JS).
            let values = Array.from(wrap.querySelectorAll('[data-bidang-chip]'))
                .map((chip) => chip.dataset.bidangValue);

            const chipClass = '{{ $bkChipClass }}';
            const closeClass = '{{ $bkCloseClass }}';
            const closeIcon = '<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';

            const sama = (a, b) => a.trim().toLowerCase() === b.trim().toLowerCase();

            /* Sinkronkan daftar nilai ke input hidden & tandai opsi yang aktif. */
            const sync = () => {
                hidden.value = values.join(separator);

                options.forEach((option) => {
                    const aktif = values.some((value) => sama(value, option.dataset.bidangOption));
                    option.setAttribute('aria-selected', aktif ? 'true' : 'false');
                    option.querySelector('[data-bidang-tick]').classList.toggle('invisible', !aktif);
                });
            };

            /* Bangun ulang chip dari daftar nilai (dipakai saat tambah/hapus). */
            const renderChips = () => {
                wrap.querySelectorAll('[data-bidang-chip]').forEach((chip) => chip.remove());

                values.forEach((value) => {
                    const chip = document.createElement('span');
                    chip.className = chipClass;
                    chip.dataset.bidangChip = '';
                    chip.dataset.bidangValue = value;

                    const text = document.createElement('span');
                    text.className = 'truncate';
                    text.textContent = value;

                    const close = document.createElement('button');
                    close.type = 'button';
                    close.className = closeClass;
                    close.setAttribute('aria-label', 'Hapus ' + value);
                    close.innerHTML = closeIcon;
                    close.addEventListener('click', () => removeValue(value));

                    chip.append(text, close);
                    box.insertBefore(chip, input);
                });

                sync();
            };

            const addValue = (value) => {
                value = value.replace(/\s+/g, ' ').trim();

                if (value === '') return;
                if (values.some((item) => sama(item, value))) return;

                values.push(value);
                renderChips();
            };

            const removeValue = (value) => {
                values = values.filter((item) => item !== value);
                renderChips();
            };

            const open = () => {
                panel.classList.remove('hidden');
                input.setAttribute('aria-expanded', 'true');
            };

            const close = () => {
                panel.classList.add('hidden');
                input.setAttribute('aria-expanded', 'false');
            };

            /*
             * Saring saran sesuai ketikan. Bila tidak ada yang cocok, tampilkan
             * keterangan bahwa nilai bebas tetap boleh disimpan.
             */
            const filter = () => {
                const term = input.value.trim().toLowerCase();
                let shown = 0;

                options.forEach((option) => {
                    const match = term === '' || option.dataset.bidangOption.toLowerCase().includes(term);

                    option.parentElement.classList.toggle('hidden', !match);

                    if (match) shown += 1;
                });

                if (hint) hint.classList.toggle('hidden', shown !== 0);
            };

            /* Tambahkan nilai lalu kosongkan input. Panel dibiarkan terbuka agar
               pengguna bisa memilih beberapa bidang sekaligus. */
            const commit = (value) => {
                addValue(value);
                input.value = '';
                input.setCustomValidity('');
                filter();
                open();
            };

            options.forEach((option) => {
                // Biarkan fokus tetap di input saat opsi dipilih.
                option.addEventListener('mousedown', (event) => event.preventDefault());
                option.addEventListener('click', () => commit(option.dataset.bidangOption));
            });

            input.addEventListener('focus', () => {
                open();
                filter();
            });

            input.addEventListener('input', () => {
                // Ketikan baru membatalkan pesan "belum ada bidang keahlian".
                input.setCustomValidity('');
                open();
                filter();
            });

            input.addEventListener('keydown', (event) => {
                if (event.key === ',' || event.key === 'Enter') {
                    event.preventDefault();
                    commit(input.value);
                } else if (event.key === 'Escape') {
                    close();
                } else if (event.key === 'Backspace' && input.value === '' && values.length > 0) {
                    // Backspace saat input kosong menghapus chip terakhir.
                    removeValue(values[values.length - 1]);
                } else if (event.key === 'ArrowDown' && panel.classList.contains('hidden')) {
                    event.preventDefault();
                    open();
                    filter();
                }
            });

            // Teks yang masih diketik (belum di-Enter) tetap ikut tersimpan.
            // Bila belum ada satu bidang pun, form ditahan + pesan ditampilkan
            // (input hidden tidak ikut validasi bawaan browser).
            input.form?.addEventListener('submit', (event) => {
                if (input.value.trim() !== '') addValue(input.value);

                if (values.length === 0) {
                    event.preventDefault();
                    input.setCustomValidity('Pilih minimal satu bidang keahlian.');
                    input.reportValidity();
                    open();
                    filter();
                } else {
                    input.setCustomValidity('');
                }
            });

            if (toggle) {
                toggle.addEventListener('click', () => {
                    if (panel.classList.contains('hidden')) {
                        open();
                        filter();
                        input.focus();
                    } else {
                        close();
                    }
                });
            }

            document.addEventListener('click', (event) => {
                if (!wrap.contains(event.target)) close();
            });

            // Nilai dari server (mis. hasil old input) dirender ulang jadi chip.
            renderChips();
        })();
    </script>

</div>
