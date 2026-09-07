@extends('layouts.app')

@section('title', 'Fasilitas - EJSC Bakorwil')

@section('content')

<div class="fasilitas-page">

    <!-- HERO -->
    <section class="fasilitas-hero py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 bg-white/70 px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                ✦ Fasilitas Kami
            </span>
            <h1 class="hero-title text-4xl font-bold mb-4">
                Fasilitas <span>EJSC Bakorwil</span>
            </h1>
            <p class="hero-description text-lg max-w-2xl mx-auto">
                Sarana dan prasarana yang kami sediakan untuk mendukung kegiatan mentoring,
                pelatihan, dan pengembangan talenta secara maksimal.
            </p>
        </div>
    </section>

    <!-- LIST FASILITAS -->
    <section class="fasilitas-list-section py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                @php
                    $fasilitasList = [
                        [
                            'nama' => 'Conference Room',
                            'deskripsi' => 'Ruang konferensi yang nyaman untuk seminar, presentasi, dan kegiatan kolaborasi berskala besar.',
                            'kategori' => 'Ruang',
                            'image' => 'resources/images/coference room.jpeg',
                        ],
                        [
                            'nama' => 'Coworking Space',
                            'deskripsi' => 'Area kerja terbuka yang mendukung produktivitas, networking, dan kolaborasi talenta serta client.',
                            'kategori' => 'Ruang',
                            'image' => 'resources/images/cowork.jpeg',
                        ],
                        [
                            'nama' => 'Meeting Room',
                            'deskripsi' => 'Ruang meeting yang tenang untuk rapat, diskusi tim, dan pertemuan dengan mitra.',
                            'kategori' => 'Ruang',
                            'image' => 'resources/images/meeting room.jpeg',
                        ],
                    ];
                @endphp

                @foreach ($fasilitasList as $item)
                    <button type="button" class="fasilitas-card text-left" data-fasilitas-open data-fasilitas-name="{{ $item['nama'] }}" data-fasilitas-category="{{ $item['kategori'] }}" data-fasilitas-description="{{ $item['deskripsi'] }}" data-fasilitas-image="{{ Vite::asset($item['image']) }}">
                        <div class="fasilitas-image-wrap">
                            <img src="{{ Vite::asset($item['image']) }}" alt="{{ $item['nama'] }}" class="fasilitas-image">
                            <span class="fasilitas-image-badge">{{ $item['kategori'] }}</span>
                        </div>
                        <div class="fasilitas-card-body">
                            <h3>{{ $item['nama'] }}</h3>
                            <p>{{ $item['deskripsi'] }}</p>
                            <div class="fasilitas-card-footer">
                                <span class="fasilitas-badge">{{ $item['kategori'] }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach

            </div>

        </div>
    </section>

</div>

<div class="fasilitas-modal" data-fasilitas-modal aria-hidden="true">
    <div class="fasilitas-modal-backdrop" data-fasilitas-close></div>
    <div class="fasilitas-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="fasilitas-modal-title">
        <button type="button" class="fasilitas-modal-close" data-fasilitas-close aria-label="Tutup detail fasilitas">&times;</button>
        <img src="" alt="" class="fasilitas-modal-image" data-fasilitas-modal-image>
        <div class="fasilitas-modal-content">
            <span class="fasilitas-badge" data-fasilitas-modal-category></span>
            <h2 id="fasilitas-modal-title" data-fasilitas-modal-name></h2>
            <p data-fasilitas-modal-description></p>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.querySelector('[data-fasilitas-modal]');
        if (!modal) return;

        const image = modal.querySelector('[data-fasilitas-modal-image]');
        const name = modal.querySelector('[data-fasilitas-modal-name]');
        const category = modal.querySelector('[data-fasilitas-modal-category]');
        const description = modal.querySelector('[data-fasilitas-modal-description]');

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('fasilitas-modal-open');
        }

        document.querySelectorAll('[data-fasilitas-open]').forEach(function (card) {
            card.addEventListener('click', function () {
                image.src = card.dataset.fasilitasImage;
                image.alt = card.dataset.fasilitasName;
                name.textContent = card.dataset.fasilitasName;
                category.textContent = card.dataset.fasilitasCategory;
                description.textContent = card.dataset.fasilitasDescription;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('fasilitas-modal-open');
            });
        });

        modal.querySelectorAll('[data-fasilitas-close]').forEach(function (element) {
            element.addEventListener('click', closeModal);
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeModal();
        });
    });
</script>
@endsection