@extends('layouts.admin')

@section('title', 'Rating & Ulasan')

@section('content')

<style>
    :root {
        --brand-900: #0b3c5d;
        --brand-700: #0e4f81;
        --brand-500: #1a6ba8;
        --brand-300: #56b8c2;
        --brand-100: #e6f3f5;
        --ink-900: #111827;
        --ink-700: #374151;
        --ink-500: #6b7280;
        --line: #e5e7eb;
        --surface: #ffffff;
        --surface-soft: #fafbfc;
    }

    .page-enter {
        opacity: 0;
        transform: translateY(10px);
        animation: enter .45s cubic-bezier(.22,.61,.36,1) forwards;
    }

    .page-enter.d1 { animation-delay: .04s; }
    .page-enter.d2 { animation-delay: .10s; }
    .page-enter.d3 { animation-delay: .16s; }

    @keyframes enter {
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes softPulse {
        0%, 100% { opacity: .5; transform: scale(1); }
        50%      { opacity: 1;  transform: scale(1.05); }
    }

    .empty-star {
        animation: softPulse 2.6s ease-in-out infinite;
    }

    /* Kartu */
    .card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(16,24,40,.04);
    }

    .card-title {
        font-weight: 700;
        color: var(--brand-900);
        letter-spacing: -.01em;
    }

    .card-sub {
        color: var(--ink-500);
        font-size: 13px;
        margin-top: 2px;
    }

    /* Form control */
    .field-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--ink-700);
        margin-bottom: 6px;
    }

    .input,
    .select,
    .textarea {
        width: 100%;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 13.5px;
        color: var(--ink-900);
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        outline: none;
    }

    .input::placeholder,
    .textarea::placeholder {
        color: #9ca3af;
    }

    .input:hover,
    .select:hover,
    .textarea:hover {
        border-color: #cbd5e1;
    }

    .input:focus,
    .select:focus,
    .textarea:focus {
        border-color: var(--brand-300);
        box-shadow: 0 0 0 3px rgba(86,184,194,.18);
        background: #fff;
    }

    .select:disabled {
        background: var(--surface-soft);
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Tombol */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 600;
        padding: 11px 18px;
        border-radius: 10px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: transform .15s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease, border-color .2s ease;
        text-decoration: none;
        line-height: 1;
    }

    .btn:active { transform: translateY(1px); }

    .btn-primary {
        color: #fff;
        background: linear-gradient(180deg, var(--brand-500) 0%, var(--brand-700) 100%);
        box-shadow: 0 1px 2px rgba(11,60,93,.25);
    }

    .btn-primary:hover {
        background: linear-gradient(180deg, #1c74b3 0%, #0d4772 100%);
        box-shadow: 0 6px 16px -6px rgba(11,60,93,.45);
    }

    .btn-ghost {
        background: #fff;
        color: var(--ink-700);
        border-color: var(--line);
    }

    .btn-ghost:hover {
        border-color: #cbd5e1;
        color: var(--brand-700);
        background: #fafbfc;
    }

    .btn-danger {
        background: #fff;
        color: #dc2626;
        border-color: #fecaca;
        font-size: 12.5px;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .btn-danger:hover {
        background: #fef2f2;
        border-color: #fca5a5;
    }

    /* Tabel */
    .tbl { width: 100%; font-size: 13.5px; border-collapse: separate; border-spacing: 0; }

    .tbl thead th {
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--brand-900);
        background: #f7fafb;
        padding: 14px 20px;
        border-bottom: 1px solid var(--line);
        white-space: nowrap;
    }

    .tbl tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: top;
        color: var(--ink-700);
    }

    .tbl tbody tr:last-child td { border-bottom: none; }

    .tbl tbody tr {
        transition: background-color .2s ease;
    }

    .tbl tbody tr:hover {
        background: #fbfdfe;
    }

    /* Bintang */
    .star {
        font-size: 16px;
        line-height: 1;
        display: inline-block;
        transition: transform .18s ease;
    }
    .star.filled { color: #f59e0b; }
    .star.empty  { color: #e5e7eb; }
    tr:hover .star.filled { transform: scale(1.08); }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .badge-mentor  { background: #ecfeff; color: #0e7490; }
    .badge-talenta { background: #f0fdf4; color: #15803d; }

    .role-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        color: var(--brand-500);
        margin-top: 4px;
    }

    /* Rating picker */
    .rating-picker {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        padding: 6px 10px;
        background: var(--surface-soft);
        border: 1px solid var(--line);
        border-radius: 10px;
    }

    .rating-picker label {
        cursor: pointer;
        line-height: 1;
    }

    .rating-picker .rating-star {
        font-size: 26px;
        color: #d1d5db;
        transition: color .15s ease, transform .15s ease;
        display: inline-block;
    }

    .rating-picker label:hover .rating-star,
    .rating-picker label:hover ~ label .rating-star {
        /* di-handle JS, hover sederhana di sini */
    }

    .rating-picker .rating-star.active {
        color: #f59e0b;
        transform: scale(1.05);
    }

    /* Alert */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13.5px;
        margin-bottom: 20px;
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .001ms !important;
            transition-duration: .001ms !important;
        }
    }
</style>


<div class="p-6 max-w-[1200px] mx-auto">

    {{-- HEADER --}}
    <div class="page-enter flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-[22px] font-bold tracking-tight" style="color: var(--brand-900);">
                Rating &amp; Ulasan
            </h1>
            <p class="text-[13.5px] mt-1" style="color: var(--ink-500);">
                Kelola rating dan komentar dari Client, serta rating dari Admin untuk Mentor dan Talenta.
            </p>
        </div>

        <div class="hidden md:flex items-center gap-2 text-[12px] font-medium" style="color: var(--ink-500);">
            <span class="inline-block w-2 h-2 rounded-full" style="background: var(--brand-300);"></span>
            {{ $ratings->total() ?? 0 }} ulasan tercatat
        </div>
    </div>


    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="page-enter d1 alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- FORM RATING ADMIN --}}
    <div class="page-enter d1 card p-6 mb-5">
        <div class="flex items-start justify-between mb-5">
            <div>
                <h2 class="card-title text-[15px]">Berikan Rating</h2>
                <p class="card-sub">Admin dapat memberikan rating dan komentar kepada Talent atau Mentor.</p>
            </div>
        </div>

        <form action="{{ route('admin.ratings.store') }}" method="POST" id="admin-rating-form">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label for="rater_name" class="field-label">Nama Pemberi Rating</label>
                    <input
                        type="text"
                        id="rater_name"
                        name="rater_name"
                        value="{{ old('rater_name') }}"
                        required
                        maxlength="150"
                        placeholder="Contoh: Caca"
                        class="input"
                    >
                    @error('rater_name')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rateable_type" class="field-label">Pilih</label>
                    <select id="rateable_type" name="rateable_type" required class="select">
                        <option value="">Pilih Talent / Mentor</option>
                        <option value="talenta" {{ old('rateable_type') === 'talenta' ? 'selected' : '' }}>Talent</option>
                        <option value="mentor"  {{ old('rateable_type') === 'mentor'  ? 'selected' : '' }}>Mentor</option>
                    </select>
                    @error('rateable_type')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="rateable_id" id="rateable-label" class="field-label">Nama Talent / Mentor</label>
                    <select id="rateable_id" name="rateable_id" required disabled class="select">
                        <option value="">Pilih Talent / Mentor terlebih dahulu</option>
                    </select>
                    @error('rateable_id')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="field-label">Rating</label>
                    <div id="admin-rating-stars" class="rating-picker">
                        @for($i = 1; $i <= 5; $i++)
                            <label data-rating="{{ $i }}">
                                <input
                                    type="radio"
                                    name="rating"
                                    value="{{ $i }}"
                                    class="sr-only"
                                    {{ (int) old('rating') === $i ? 'checked' : '' }}
                                    required
                                >
                                <span class="rating-star {{ (int) old('rating') >= $i && old('rating') ? 'active' : '' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="admin-comment" class="field-label">Komentar</label>
                    <textarea
                        id="admin-comment"
                        name="comment"
                        rows="3"
                        maxlength="1000"
                        placeholder="Tulis komentar..."
                        class="textarea"
                    >{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-1.5 text-[12px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5 flex justify-end">
                <button type="submit" class="btn btn-primary">
                    Kirim Rating
                </button>
            </div>
        </form>
    </div>


    {{-- FILTER --}}
    <div class="page-enter d2 card p-5 mb-5">
        <form method="GET" action="{{ route('admin.ratings.index') }}" class="grid md:grid-cols-3 gap-4 items-end">

            <div>
                <label class="field-label">Target</label>
                <select name="type" class="select">
                    <option value="">Semua</option>
                    <option value="mentor"  {{ request('type') === 'mentor'  ? 'selected' : '' }}>Mentor</option>
                    <option value="talenta" {{ request('type') === 'talenta' ? 'selected' : '' }}>Talenta</option>
                </select>
            </div>

            <div>
                <label class="field-label">Rating</label>
                <select name="rating" class="select">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (string) request('rating') === (string) $i ? 'selected' : '' }}>
                            {{ $i }} Bintang
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Terapkan Filter</button>
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-ghost">Reset</a>
            </div>

        </form>
    </div>


    {{-- TABLE --}}
    <div class="page-enter d3 card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Pemberi Rating</th>
                        <th>Target</th>
                        <th class="text-center">Rating</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ratings as $rating)
                        <tr>
                            {{-- PEMBERI --}}
                            <td>
                                @if($rating->admin_id)
                                    <div class="font-semibold" style="color: var(--ink-900);">
                                        {{ $rating->rater_name ?? 'Admin' }}
                                    </div>
                                    <div class="role-tag">Admin</div>
                                @else
                                    <div class="font-semibold" style="color: var(--ink-900);">
                                        {{ $rating->client->nama_ukm ?? '-' }}
                                    </div>
                                    <div class="text-[12px] mt-0.5" style="color: var(--ink-500);">
                                        {{ $rating->client->email ?? '-' }}
                                    </div>
                                    <div class="text-[11px] mt-1" style="color: var(--ink-500);">Client</div>
                                @endif
                            </td>

                            {{-- TARGET --}}
                            <td>
                                @php
                                    $targetType = $rating->rateable_type === 'mentor' ? 'Mentor' : 'Talenta';
                                @endphp
                                <div class="font-semibold" style="color: var(--ink-900);">
                                    {{ $rating->rateable->nama ?? '-' }}
                                </div>
                                <span class="badge mt-1.5 {{ $rating->rateable_type === 'mentor' ? 'badge-mentor' : 'badge-talenta' }}">
                                    {{ $targetType }}
                                </span>
                            </td>

                            {{-- RATING --}}
                            <td class="text-center">
                                <div class="inline-flex items-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $rating->rating ? 'filled' : 'empty' }}">★</span>
                                    @endfor
                                </div>
                                <div class="text-[11.5px] mt-1" style="color: var(--ink-500);">
                                    {{ $rating->rating }}/5
                                </div>
                            </td>

                            {{-- KOMENTAR --}}
                            <td style="max-width: 360px;">
                                @if($rating->comment)
                                    <p class="leading-relaxed">{{ $rating->comment }}</p>
                                @else
                                    <span class="italic" style="color: #9ca3af;">Tidak ada komentar.</span>
                                @endif
                            </td>

                            {{-- TANGGAL --}}
                            <td class="whitespace-nowrap">
                                <div>{{ $rating->created_at->format('d M Y') }}</div>
                                <div class="text-[11.5px] mt-0.5" style="color: var(--ink-500);">
                                    {{ $rating->created_at->format('H:i') }}
                                </div>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <form
                                    method="POST"
                                    action="{{ route('admin.ratings.destroy', $rating) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus rating dan komentar ini?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="empty-star text-4xl mb-3 inline-block" style="color: #d1d5db;">★</div>
                                <p class="font-semibold" style="color: var(--ink-700);">Belum ada rating.</p>
                                <p class="text-[13px] mt-1" style="color: var(--ink-500);">
                                    Rating dari Client dan Admin akan muncul di halaman ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ratings->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid var(--line);">
                {{ $ratings->links() }}
            </div>
        @endif
    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeSelect   = document.getElementById('rateable_type');
    const targetSelect = document.getElementById('rateable_id');
    const targetLabel  = document.getElementById('rateable-label');
    const ratingLabels = document.querySelectorAll('#admin-rating-stars label');

    const mentors = @json($mentors->map(fn($m) => ['id' => $m->id_mentor, 'nama' => $m->nama])->values());
    const talents = @json($talents->map(fn($t) => ['id' => $t->id_talenta, 'nama' => $t->nama])->values());

    function paintStars(selected) {
        ratingLabels.forEach(function (item) {
            const value = parseInt(item.dataset.rating, 10);
            const star  = item.querySelector('.rating-star');
            star.classList.toggle('active', value <= selected);
        });
    }

    function loadTargets(type, selectedId = '') {
        targetSelect.innerHTML = '';

        if (!type) {
            targetSelect.disabled = true;
            targetSelect.innerHTML = '<option value="">Pilih Talent / Mentor terlebih dahulu</option>';
            targetLabel.textContent = 'Nama Talent / Mentor';
            return;
        }

        targetSelect.disabled = false;

        const map = {
            talenta: { data: talents, label: 'Nama Talent' },
            mentor:  { data: mentors, label: 'Nama Mentor' },
        };

        const conf = map[type] || { data: [], label: 'Nama Talent / Mentor' };
        targetLabel.textContent = conf.label;

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = `Pilih ${conf.label}`;
        targetSelect.appendChild(placeholder);

        conf.data.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.nama;
            if (String(selectedId) === String(item.id)) option.selected = true;
            targetSelect.appendChild(option);
        });
    }

    typeSelect.addEventListener('change', function () {
        loadTargets(this.value);
    });

    const oldType   = @json(old('rateable_type'));
    const oldTarget = @json(old('rateable_id'));

    if (oldType) loadTargets(oldType, oldTarget);

    // Init bintang dari old('rating')
    const checked = document.querySelector('#admin-rating-stars input:checked');
    if (checked) paintStars(parseInt(checked.value, 10));

    // Interaksi klik bintang
    ratingLabels.forEach(function (label) {
        const input = label.querySelector('input');
        input.addEventListener('change', function () {
            paintStars(parseInt(this.value, 10));
        });
    });

    // Hover preview sederhana
    ratingLabels.forEach(function (label) {
        label.addEventListener('mouseenter', function () {
            paintStars(parseInt(this.dataset.rating, 10));
        });
    });

    document.getElementById('admin-rating-stars').addEventListener('mouseleave', function () {
        const checked = document.querySelector('#admin-rating-stars input:checked');
        paintStars(checked ? parseInt(checked.value, 10) : 0);
    });

});
</script>

@endsection