@extends('layouts.app')

@section('title', 'Profil Mentor - ' . ($mentor->nama ?? 'Mentor'))

@section('content')

<style>

/* MENTOR DETAIL - EJSC */

.mentor-detail-page {
    min-height: 100vh;
    background: #f4f7f8;
    padding: 28px 20px 50px;
}

.mentor-detail-container {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
}

.mentor-back-wrapper {
    margin-bottom: 14px;
}

.mentor-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 13px;
    background: #ffffff;
    border: 1px solid #dfeaec;
    border-radius: 7px;
    color: #12344d;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 7px rgba(18,52,77,.04);
    transition: all .2s ease;
}

.mentor-back-btn:hover {
    color: #159da8;
    border-color: #b9e5e9;
    background: #f8fdfe;
    transform: translateX(-2px);
}

.mentor-back-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    background: #e8f8fa;
    color: #159da8;
    font-size: 12px;
    font-weight: 700;
}

/* profile header */

.mentor-profile-card {
    background: #fff;
    border: 1px solid #e6edf0;
    border-radius: 14px;
    padding: 28px 30px;
    box-shadow: 0 3px 12px rgba(18,52,77,.05);
    margin-bottom: 22px;
}

.mentor-profile-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
}

.mentor-profile-left {
    display: flex;
    align-items: center;
    gap: 18px;
    min-width: 0;
}

.mentor-photo {
    width: 112px;
    height: 112px;
    min-width: 112px;
    border-radius: 50%;
    background: linear-gradient(135deg,#dff8fa,#bdeef1);
    border: 5px solid #fff;
    box-shadow: 0 4px 15px rgba(18,52,77,.14);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #159da8;
    font-size: 32px;
    font-weight: 700;
}

.mentor-profile-info {
    min-width: 0;
}

.mentor-name-row {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 14px !important;
    margin: 0 !important;
    padding: 0 !important;
}

.mentor-profile-name {
    margin: 0 !important;
    padding: 0 !important;
    color: #12344d;
    font-size: 30px;
    line-height: 1.2;
    font-weight: 700;
    letter-spacing: -.3px;
}

.mentor-profile-badge {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 7px 14px !important;
    height: auto !important;
    margin: 0 !important;
    background: #e8f8fa;
    color: #159da8;
    border-radius: 999px;
    font-size: 12px !important;
    line-height: 1.2;
    font-weight: 600;
    white-space: nowrap;
    position: relative;
    top: 5px;
}

.mentor-profile-role {
    margin: 7px 0 11px;
    color: #159da8;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 500;
}

.mentor-mini-tags {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
}

.mentor-mini-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    min-height: 32px;
    background: #f5f9fa;
    border: 1px solid #dce9ed;
    border-radius: 999px;
    color: #607d8b;
    font-size: 12px;
    line-height: 1.3;
    font-weight: 500;
    white-space: nowrap;
}

.mentor-profile-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.mentor-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 20px;
    background: #ff9200;
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(255,146,0,.18);
    transition: .2s ease;
}

.mentor-btn-primary:hover {
    background: #ed8400;
    transform: translateY(-1px);
}

.mentor-btn-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dce7ea;
    border-radius: 7px;
    background: #fff;
    color: #78909c;
    text-decoration: none;
}

/* main grid */

.mentor-main-grid {
    display: grid;
    grid-template-columns: minmax(0,1.8fr) minmax(270px,.85fr);
    gap: 16px;
    align-items: start;
}

.mentor-left-column,
.mentor-right-column {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* card */

.mentor-card {
    background: #fff;
    border: 1px solid #e6edf0;
    border-radius: 14px;
    padding: 26px 28px;
    min-height: 170px;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 3px 12px rgba(18,52,77,.06);
}

.mentor-card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 16px;
    color: #12344d;
    font-size: 18px;
    line-height: 1.35;
    font-weight: 700;
}

.mentor-card-title-icon {
    width: 20px;
    height: 20px;
    min-width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #159da8;
    background: #e8f8fa;
    border-radius: 5px;
    font-size: 11px;
}

.mentor-card-text {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.7;
}

/* skills */

.mentor-skill-list {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 6px !important;
    width: 100% !important;
}

.mentor-skill {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: auto !important;
    max-width: max-content !important;
    flex: 0 0 auto !important;
    padding: 5px 9px;
    background: #effbfc;
    border: 1px solid #d9f0f2;
    border-radius: 999px;
    color: #159da8;
    font-size: 10px;
    line-height: 1.2;
    font-weight: 500;
    white-space: nowrap;
}

/* experience */

.mentor-experience {
    position: relative;
    padding-left: 22px;
}

.mentor-experience::before {
    content: "";
    position: absolute;
    left: 6px;
    top: 3px;
    bottom: 3px;
    width: 1px;
    background: #dce9ec;
}

.mentor-experience-item {
    position: relative;
    margin-bottom: 14px;
}

.mentor-experience-item:last-child {
    margin-bottom: 0;
}

.mentor-experience-item::before {
    content: "";
    position: absolute;
    left: -20px;
    top: 5px;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #20b6c1;
    border: 2px solid #e6f9fa;
}

.mentor-experience-title {
    margin: 0;
    color: #12344d;
    font-size: 14px;
    line-height: 1.4;
    font-weight: 700;
}

.mentor-experience-date {
    margin: 4px 0 6px;
    color: #159da8;
    font-size: 12px;
    line-height: 1.4;
    font-weight: 500;
}

.mentor-experience-text {
    margin: 0;
    color: #64748b;
    font-size: 13px;
    line-height: 1.6;
}

/* rating */

.mentor-rating-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.mentor-rating-average {
    display: flex;
    align-items: center;
    gap: 6px;
}

.mentor-rating-star {
    color: #ffb000;
    font-size: 18px;
}

.mentor-rating-number {
    color: #12344d;
    font-size: 16px;
    font-weight: 700;
}

.mentor-review {
    padding: 13px;
    border: 1px solid #e5edef;
    border-radius: 9px;
    margin-bottom: 9px;
}

.mentor-review:last-child {
    margin-bottom: 0;
}

.mentor-review-header {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.mentor-review-name {
    margin: 0;
    color: #12344d;
    font-size: 12px;
    line-height: 1.4;
    font-weight: 600;
}

.mentor-review-date {
    margin: 3px 0 0;
    color: #90a4ae;
    font-size: 11px;
}

.mentor-review-stars {
    color: #ffad00;
    font-size: 12px;
    letter-spacing: 1px;
}

.mentor-review-comment {
    margin: 8px 0 0;
    color: #64748b;
    font-size: 13px;
    line-height: 1.6;
}

/* info */

.mentor-info-list {
    display: flex;
    flex-direction: column;
    gap: 11px;
}

.mentor-info-row {
    display: flex;
    align-items: flex-start;
    gap: 9px;
}

.mentor-info-icon {
    width: 22px;
    height: 22px;
    min-width: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    background: #effbfc;
    color: #159da8;
    font-size: 11px;
}

.mentor-info-label {
    margin: 0;
    color: #78909c;
    font-size: 11px;
    line-height: 1.4;
}

.mentor-info-value {
    margin: 3px 0 0;
    color: #12344d;
    font-size: 12px;
    font-weight: 500;
    line-height: 1.5;
    word-break: break-word;
}

/* =========================================================
   DETAIL MENTOR
   ========================================================= */

.mentor-detail-section {
    background: #ffffff;
    border: 1px solid #e6edf0;
    border-radius: 14px;
    padding: 18px 20px;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 3px 12px rgba(18,52,77,.06);
}

.mentor-detail-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.mentor-detail-header-left {
    display: flex;
    align-items: center;
    gap: 9px;
}

.mentor-detail-header-line {
    width: 5px;
    height: 21px;
    background: #159da8;
    border-radius: 999px;
}

.mentor-detail-header-title {
    margin: 0;
    color: #12344d;
    font-size: 18px;
    line-height: 1.35;
    font-weight: 700;
}

.mentor-verified-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 12px;
    border: 1px solid #bcece7;
    border-radius: 999px;
    background: #f3fbfa;
    color: #159da8;
    font-size: 11px;
    font-weight: 500;
    white-space: nowrap;
}

/* 4 kotak detail */

.mentor-detail-section .mentor-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.mentor-detail-section .mentor-detail-item {
    position: relative;
    min-height: 100px;
    padding: 13px 14px;
    background: #ffffff;
    border: 1px solid #e5edf0;
    border-radius: 12px;
    box-sizing: border-box;
}

.mentor-detail-item-icon {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #effbfa;
    color: #159da8;
    font-size: 15px;
}

.mentor-detail-label {
    margin: 0 42px 8px 0;
    color: #78909c;
    font-size: 11px;
    line-height: 1.4;
}

.mentor-detail-section .mentor-detail-value {
    margin: 0;
    color: #12344d;
    font-size: 16px;
    font-weight: 700;
    line-height: 1.4;
    word-break: break-word;
}

.mentor-detail-subvalue {
    margin: 3px 0 0;
    color: #90a4ae;
    font-size: 11px;
    line-height: 1.4;
}

.mentor-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 9px;
    background: #effcf8;
    border: 1px solid #c6f2e2;
    border-radius: 999px;
    color: #0eaa73;
    font-size: 12px;
    line-height: 1.2;
    font-weight: 600;
}

.mentor-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #69d5b2;
}

.mentor-mentee-value {
    display: flex;
    align-items: baseline;
    gap: 5px;
}

.mentor-mentee-number {
    color: #12344d;
    font-size: 25px;
    line-height: 1;
    font-weight: 700;
}

.mentor-mentee-label {
    color: #526b7a;
    font-size: 12px;
    font-weight: 500;
}

/* =========================================================
   BERKAS & DOKUMEN
   ========================================================= */

.mentor-documents-card {
    background: #fff;
    border: 1px solid #e6edf0;
    border-radius: 14px;
    padding: 26px 28px;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 3px 12px rgba(18,52,77,.06);
}

.mentor-documents-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 16px;
}

.mentor-documents-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
    color: #12344d;
    font-size: 18px;
    line-height: 1.35;
    font-weight: 700;
}

.mentor-documents-count {
    color: #8da0b5;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}

.mentor-document-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px;
    background: #ffffff;
    border: 1px solid #e5edf0;
    border-radius: 12px;
    margin-bottom: 10px;
}

.mentor-document-item:last-child {
    margin-bottom: 0;
}

.mentor-document-left {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.mentor-document-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    background: #fff8e8;
    color: #ff9200;
}

.mentor-document-icon.cv {
    background: #fff0f2;
    color: #ff5265;
}

.mentor-document-icon svg {
    width: 21px;
    height: 21px;
}

.mentor-document-info {
    min-width: 0;
}

.mentor-document-name {
    margin: 0;
    color: #12344d;
    font-size: 14px;
    line-height: 1.4;
    font-weight: 600;
}

.mentor-document-status {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 3px 0 0;
    color: #8da0b5;
    font-size: 12px;
    line-height: 1.4;
}

.mentor-document-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #cbd5e1;
}

.mentor-document-preview {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 11px;
    border-radius: 9px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: .2s ease;
}

.mentor-document-preview:hover {
    background: #e8f8fa;
    color: #159da8;
}

.mentor-document-preview svg {
    width: 16px;
    height: 16px;
}

/* responsive */

@media (max-width:900px) {

    .mentor-main-grid {
        grid-template-columns: 1fr;
    }

    .mentor-right-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: start;
    }
}

@media (max-width:640px) {

    .mentor-detail-page {
        padding: 18px 12px 35px;
    }

    .mentor-profile-top {
        flex-direction: column;
        align-items: flex-start;
    }

    .mentor-profile-left {
        width: 100%;
    }

    .mentor-profile-actions {
        width: 100%;
    }

    .mentor-btn-primary {
        flex: 1;
    }

    .mentor-main-grid {
        grid-template-columns: 1fr;
    }

    .mentor-right-column {
        display: flex;
    }

    .mentor-detail-section .mentor-detail-grid {
        grid-template-columns: 1fr 1fr;
    }

    .mentor-card {
        padding: 22px 20px;
    }

    .mentor-detail-section {
        padding: 16px;
    }

    .mentor-detail-section .mentor-detail-item {
        min-height: 95px;
        padding: 12px;
    }

    .mentor-documents-card {
        padding: 22px 20px;
    }
}

@media (max-width:420px) {

    .mentor-profile-left {
        align-items: flex-start;
    }

    .mentor-photo {
        width: 72px;
        height: 72px;
        min-width: 72px;
        font-size: 20px;
    }

    .mentor-profile-name {
        font-size: 18px;
    }

    .mentor-profile-role {
        font-size: 8px;
    }

    .mentor-card-title {
        font-size: 18px;
    }

    .mentor-card-text {
        font-size: 14px;
    }

    .mentor-detail-section .mentor-detail-grid {
        grid-template-columns: 1fr;
    }

    .mentor-document-item {
        padding: 10px;
    }

    .mentor-document-name {
        font-size: 13px;
    }

    .mentor-document-preview {
        padding: 7px 9px;
    }
}

</style>

@php

    $nama = $mentor->nama ?? 'Mentor';

    $avatar = collect(
        preg_split('/\s+/', trim($nama))
    )
        ->filter()
        ->take(2)
        ->map(
            fn ($word) => strtoupper(
                substr($word, 0, 1)
            )
        )
        ->implode('');

    $mentorRatings = $mentor->ratings ?? collect();

    $mentorRatingCount = $mentorRatings->count();

    $mentorRatingAverage = $mentorRatingCount > 0
        ? $mentorRatings->avg('rating')
        : 0;

@endphp

<div class="mentor-detail-page">

    <div class="mentor-detail-container">

        <div class="mentor-back-wrapper">

            <a
                href="{{ route('mentor') }}"
                class="mentor-back-btn"
                style="display: inline-flex; transform: translateY(-10px); margin-bottom: 0;"
            >
                <span class="mentor-back-icon">
                    ←
                </span>

                <span>
                    Kembali ke Mentor
                </span>
            </a>

        </div>

        <div class="mentor-profile-card">

            <div class="mentor-profile-top">

                <div class="mentor-profile-left">

                    <div class="mentor-photo">
                        {{ $avatar ?: 'ME' }}
                    </div>

                    <div class="mentor-profile-info">

                        <div class="mentor-name-row">

                            <h1 class="mentor-profile-name">
                                {{ $nama }}
                            </h1>

                            <span class="mentor-profile-badge">
                                • Mentor
                            </span>

                        </div>

                        <p class="mentor-profile-role">
                            {{ $mentor->keahlian ?? 'Digital Marketing Expert' }}
                        </p>

                        <div class="mentor-mini-tags">

                            <span class="mentor-mini-tag">
                                {{ $mentor->domisili ?? 'Jember' }}
                            </span>

                            @if(!empty($mentor->jumlah_mentee))

                                <span class="mentor-mini-tag">
                                    {{ $mentor->jumlah_mentee }} Mentee
                                </span>

                            @endif

                            <span class="mentor-mini-tag">
                                {{ $mentor->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="mentor-profile-actions">

                    @if(!empty($mentor->no_wa))

                        @php

                            $whatsappNumber = preg_replace(
                                '/[^0-9]/',
                                '',
                                $mentor->no_wa
                            );

                            if (str_starts_with($whatsappNumber, '0')) {

                                $whatsappNumber =
                                    '62' .
                                    substr(
                                        $whatsappNumber,
                                        1
                                    );

                            }

                        @endphp

                        <a
                            href="https://wa.me/{{ $whatsappNumber }}"
                            target="_blank"
                            rel="noopener"
                            class="mentor-btn-primary"
                        >
                            <span>▣</span>
                            Hubungi Mentor
                        </a>

                    @endif

                </div>

            </div>

        </div>

        <div class="mentor-main-grid">

            {{-- =====================================================
                 KOLOM KIRI
                 ===================================================== --}}

            <div class="mentor-left-column">

                {{-- TENTANG --}}

                <div class="mentor-card">

                    <h2 class="mentor-card-title">

                        <span class="mentor-card-title-icon">
                            ♙
                        </span>

                        Tentang {{ $nama }}

                    </h2>

                    <p class="mentor-card-text">
                        {{ $mentor->bio ?? 'Belum ada deskripsi tentang mentor ini.' }}
                    </p>

                </div>

                {{-- INFORMASI MENTOR --}}

                <div class="mentor-detail-section">

                    <div class="mentor-detail-header">

                        <div class="mentor-detail-header-left">

                            <span class="mentor-detail-header-line"></span>

                            <h2 class="mentor-detail-header-title">
                                Informasi Mentor
                            </h2>

                        </div>

                        <span class="mentor-verified-badge">
                            Terverifikasi
                        </span>

                    </div>

                    <div class="mentor-detail-grid">

                        {{-- DOMISILI --}}

                        <div class="mentor-detail-item">

                            <div class="mentor-detail-item-icon">
                                   📍
                            </div>

                            <p class="mentor-detail-label">
                                Domisili
                            </p>

                            <p class="mentor-detail-value">
                                {{ $mentor->domisili ?? 'Jember' }}
                            </p>

                            <p class="mentor-detail-subvalue">
                                Jawa Timur, ID
                            </p>

                        </div>

                        {{-- STATUS --}}

                        <div class="mentor-detail-item">

                            <div class="mentor-detail-item-icon">
                                ✓
                            </div>

                            <p class="mentor-detail-label">
                                Status
                            </p>

                            <div class="mentor-status-badge">

                                <span class="mentor-status-dot"></span>

                                Aktif

                            </div>

                            <p class="mentor-detail-subvalue">
                                Tersedia untuk sesi
                            </p>

                        </div>

                        {{-- JUMLAH MENTEE --}}

                        <div class="mentor-detail-item">

                            <div class="mentor-detail-item-icon">
                                👥
                            </div>

                            <p class="mentor-detail-label">
                                Jumlah Mentee
                            </p>

                            <div class="mentor-mentee-value">

                                <span class="mentor-mentee-number">
                                    {{ $mentor->jumlah_mentee ?? '0' }}
                                </span>

                                <span class="mentor-mentee-label">
                                    Mentee
                                </span>

                            </div>

                            <p class="mentor-detail-subvalue">
                                Aktif bimbingan
                            </p>

                        </div>

                        {{-- JENIS KELAMIN --}}

                        <div class="mentor-detail-item">

                            <div class="mentor-detail-item-icon">
                                ♀
                            </div>

                            <p class="mentor-detail-label">
                                Jenis Kelamin
                            </p>

                            <p class="mentor-detail-value">
                                {{ $mentor->jenis_kelamin ?? '-' }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- ULASAN --}}

                <div class="mentor-card">

                    <div class="mentor-rating-summary">

                        <div>

                            <h2
                                class="mentor-card-title"
                                style="margin-bottom:3px;"
                            >

                                <span class="mentor-card-title-icon">
                                    ☆
                                </span>

                                Ulasan Mentee

                            </h2>

                        </div>

                        <div class="mentor-rating-average">

                            <span class="mentor-rating-star">
                                ★
                            </span>

                            <span class="mentor-rating-number">
                                {{ number_format((float)$mentorRatingAverage, 1) }}
                            </span>

                        </div>

                    </div>

                    @forelse($mentorRatings as $rating)

                        <div class="mentor-review">

                            <div class="mentor-review-header">

                                <div>

                                    <p class="mentor-review-name">
                                        {{ $rating->rater_name ?? $rating->client->nama_ukm ?? 'Admin' }}
                                    </p>

                                    <p class="mentor-review-date">
                                        {{ $rating->created_at?->format('d M Y') }}
                                    </p>

                                </div>

                                <div class="mentor-review-stars">

                                    {!! str_repeat('★', (int)$rating->rating) !!}

                                    <span style="color:#d9e3e6;">

                                        {!! str_repeat(
                                            '★',
                                            max(
                                                0,
                                                5 - (int)$rating->rating
                                            )
                                        ) !!}

                                    </span>

                                </div>

                            </div>

                            @if($rating->comment)

                                <p class="mentor-review-comment">
                                    "{{ $rating->comment }}"
                                </p>

                            @endif

                        </div>

                    @empty

                        <p class="mentor-card-text">
                            Belum ada ulasan dari mentee.
                        </p>

                    @endforelse

                </div>

            </div>

            {{-- =====================================================
                 KOLOM KANAN
                 ===================================================== --}}

            <div class="mentor-right-column">

                {{-- BIDANG KEAHLIAN --}}

                <div class="mentor-card">

                    <h2 class="mentor-card-title">

                        <span class="mentor-card-title-icon">
                            ◉
                        </span>

                        Bidang Keahlian

                    </h2>

                    @php

                        $expertise = !empty($mentor->expertise_tags)
                            ? $mentor->expertise_tags
                            : ($mentor->keahlian ?? '');

                        if (is_array($expertise)) {

                            $skills = $expertise;

                        } else {

                            $skills = preg_split(
                                '/\s*,\s*|\s*\|\s*/',
                                $expertise
                            );

                        }

                        $skills = collect($skills)
                            ->map(fn ($skill) => trim($skill))
                            ->filter()
                            ->values();

                    @endphp

                    <div class="mentor-skill-list">

                        @forelse($skills as $skill)

                            <span class="mentor-skill">
                                {{ $skill }}
                            </span>

                        @empty

                            <span class="mentor-skill">
                                {{ $mentor->keahlian ?? '-' }}
                            </span>

                        @endforelse

                    </div>

                </div>

                {{-- INFORMASI MENTORING --}}

                <div class="mentor-card">

                    <h2 class="mentor-card-title">

                        <span class="mentor-card-title-icon">
                            ▤
                        </span>

                        Informasi Mentoring

                    </h2>

                    <div class="mentor-info-list">

                        <div class="mentor-info-row">

                            <div class="mentor-info-icon">
                                ✓
                            </div>

                            <div>

                                <p class="mentor-info-label">
                                    Status mentor
                                </p>

                                <p class="mentor-info-value">
                                    {{ $mentor->is_available ? 'Tersedia untuk mentoring' : 'Tidak tersedia' }}
                                </p>

                            </div>

                        </div>

                        <div class="mentor-info-row">

                            <div class="mentor-info-icon">
                                ✉
                            </div>

                            <div>

                                <p class="mentor-info-label">
                                    Email
                                </p>

                                <p class="mentor-info-value">
                                    {{ $mentor->email ?? '-' }}
                                </p>

                            </div>

                        </div>

                        <div class="mentor-info-row">

                            <div class="mentor-info-icon">
                                ☎
                            </div>

                            <div>

                                <p class="mentor-info-label">
                                    WhatsApp
                                </p>

                                <p class="mentor-info-value">
                                    {{ $mentor->no_wa ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- BERKAS & DOKUMEN
                     POSISI: DI BAWAH INFORMASI MENTORING --}}

                <div class="mentor-documents-card">

                    <div class="mentor-documents-header">

                        <h2 class="mentor-documents-title">

                            <span class="mentor-card-title-icon">
                                ▤
                            </span>

                            Berkas & Dokumen

                        </h2>

                        <span class="mentor-documents-count">
                            2 Dokumen
                        </span>

                    </div>

                    {{-- PORTFOLIO --}}

                    <div class="mentor-document-item">

                        <div class="mentor-document-left">

                            <div class="mentor-document-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M9 6V4.8A1.8 1.8 0 0 1 10.8 3h2.4A1.8 1.8 0 0 1 15 4.8V6"/>
                                    <rect x="3" y="6" width="18" height="14" rx="2"/>
                                    <path d="M3 10h18"/>
                                    <path d="M10 14h4"/>
                                </svg>

                            </div>

                            <div class="mentor-document-info">

                                <p class="mentor-document-name">
                                    Portfolio
                                </p>

                                <p class="mentor-document-status">

                                    <span class="mentor-document-status-dot"></span>

                                    Belum dilampirkan (-)

                                </p>

                            </div>

                        </div>

                        <a
                            href="#"
                            class="mentor-document-preview"
                            title="Preview Portfolio"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>

                            Preview

                        </a>

                    </div>

                    {{-- CV / RESUME --}}

                    <div class="mentor-document-item">

                        <div class="mentor-document-left">

                            <div class="mentor-document-icon cv">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M6 3h8l5 5v13H6z"/>
                                    <path d="M14 3v5h5"/>
                                    <path d="M9 13h6"/>
                                    <path d="M9 17h6"/>
                                </svg>

                            </div>

                            <div class="mentor-document-info">

                                <p class="mentor-document-name">
                                    CV / Resume
                                </p>

                                <p class="mentor-document-status">

                                    <span class="mentor-document-status-dot"></span>

                                    Belum diunggah (-)

                                </p>

                            </div>

                        </div>

                        <a
                            href="#"
                            class="mentor-document-preview"
                            title="Preview CV / Resume"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>

                            Preview

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection