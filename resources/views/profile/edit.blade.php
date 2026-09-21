@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
@php
    /* Kelas bersama untuk semua field agar konsisten di HP maupun layar lebar:
       - min-h-[46px] : area sentuh nyaman di HP (standar minimal ~44px)
       - text-base    : 16px di HP -> iOS Safari tidak auto-zoom saat field difokus
       - sm:text-sm   : dipadatkan lagi sejak layar >=640px
       - sm:px-4      : padding field sedikit lebih lega di layar besar */
    $fldClass = 'w-full min-h-[46px] rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-base text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] sm:text-sm';
    $lblClass = 'block text-sm font-medium text-slate-700 mb-2';

    /* Satu gaya kotak unggah (putus-putus) untuk foto profil, logo, KTP, BUTAP, dan CV. */
    $dropClass = 'group flex h-full w-full min-h-[118px] cursor-pointer flex-col items-center justify-center gap-1.5 rounded-2xl border-2 border-dashed border-[#bfe9ed] bg-[#f8fdfd] px-3 py-4 text-center transition-all duration-200 hover:border-[#56b8c2] hover:bg-[#effbfc] hover:shadow-sm focus-within:border-[#56b8c2] focus-within:ring-2 focus-within:ring-[#56b8c2]/30';

    // Pintasan bagian form (sesuai role) untuk chip navigasi di bawah judul.
    $navItems = [['id' => 'bagian-akun', 'label' => 'Akun', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z']];
    $profilSection = $user->isClient() ? 'Data UKM' : ($user->isMentor() ? 'Data Mentor' : 'Data Talent');
    $profilIcon = 'M12 14l9-5-9-5-9 5 9 5z';
    if ($profile) {
        $navItems[] = ['id' => 'bagian-profil', 'label' => $profilSection, 'icon' => $profilIcon];
    }
@endphp

<div class="mx-auto w-full max-w-6xl px-3 py-5 sm:px-6 sm:py-8 lg:px-8 2xl:max-w-7xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-[0_12px_32px_rgba(15,23,42,0.08)]">
        <div class="rounded-t-2xl border-b border-slate-200 bg-gradient-to-r from-[#f0fbfc] to-white px-4 py-5 sm:px-6 sm:py-6">
            <div class="flex flex-wrap items-center justify-between gap-3 sm:gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#56b8c2]">Profil</p>
                    <h2 class="mt-1.5 text-xl font-bold text-slate-800 sm:mt-2 sm:text-2xl lg:text-3xl">Edit Profil</h2>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#b7ebee] bg-[#ecfeff] px-3 py-1.5 text-xs font-medium text-[#0f766e]">
                    <span class="h-2 w-2 rounded-full bg-[#14b8c4]"></span>
                    Update data akun
                </div>
            </div>

            {{-- Pintasan antar bagian: di HP bisa digeser ke samping, di layar lebar berbaris rapi --}}
            <nav class="-mx-4 mt-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0"
                 aria-label="Pintasan bagian formulir">
                @foreach($navItems as $nav)
                    <a href="#{{ $nav['id'] }}"
                       class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm transition hover:border-[#56b8c2] hover:text-[#0f766e] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $nav['icon'] }}"/>
                        </svg>
                        {{ $nav['label'] }}
                    </a>
                @endforeach
                <span class="hidden items-center gap-1.5 rounded-full bg-[#e0f7fa] px-3 py-1.5 text-xs font-medium text-[#0f766e] sm:inline-flex">
                    {{ ucfirst($user->role ?? 'pengguna') }}
                </span>
            </nav>
        </div>

        @if($errors->any())
            <div class="px-4 pt-5 sm:px-8 sm:pt-6">
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
                    <p class="font-semibold mb-1 flex items-center gap-2">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                        Terjadi masalah saat menyimpan:
                    </p>
                    <ul class="ml-6 list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form id="form-profil" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-4 sm:space-y-8 sm:p-8">
            @csrf
            @method('PUT')

            <section id="bagian-akun" class="scroll-mt-24 space-y-4">
                <div class="flex items-center gap-2 text-slate-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <h3 class="text-lg font-bold text-slate-800">Informasi Akun</h3>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 md:grid-cols-3">
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20V7a2 2 0 012-2h10a2 2 0 012 2v13M9 9h6M9 13h6"/></svg>
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="{{ $fldClass }}">
                    </div>
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm-8 0V7a4 4 0 118 0v5"/></svg>
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="{{ $fldClass }}">
                    </div>
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12"/></svg>
                            Foto Profil
                        </label>
                        @if($user->profile_photo_src)
                            <p class="text-[11px] text-slate-500 mb-2">Foto saat ini: <a href="{{ $user->profile_photo_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                        @endif
                        <label class="{{ $dropClass }}" data-drop>
                            @if($user->profile_photo_src)
                                <img data-drop-preview src="{{ $user->profile_photo_src }}" alt="Foto profil"
                                     class="h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                            @else
                                <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                            @endif
                            <span class="flex items-center gap-2.5">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12"/></svg>
                                </span>
                                <span class="text-left leading-tight">
                                    <span class="block text-sm font-medium text-[#1f7a81]">Pilih foto</span>
                                    <span class="block text-[10px] text-slate-500">JPG, PNG max 2MB</span>
                                </span>
                            </span>
                            <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                            <input type="file" name="profile_photo" accept="image/*" class="sr-only">
                        </label>
                    </div>
                </div>
            </section>

            @if($profile)
                @if($user->isClient())
                    <section id="bagian-profil" class="scroll-mt-24 space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16v10H4zM9 11h6"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data UKM</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 xl:grid-cols-3">
                            <div>
                                <label class="{{ $lblClass }}">Nama UKM</label>
                                <input type="text" name="nama_ukm" value="{{ old('nama_ukm', $profile->nama_ukm) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Jenis Produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk', $profile->nama_produk) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">No WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Wilayah/Domisili</label>
                                <select name="id_wilayah" id="id_wilayah" required
                                        class="{{ $fldClass }}">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    @foreach(App\Models\Wilayah::orderBy('nama_wilayah')->get() as $wilayah)
                                        <option value="{{ $wilayah->id_wilayah }}" {{ old('id_wilayah', $profile->id_wilayah) == $wilayah->id_wilayah ? 'selected' : '' }}>
                                            {{ $wilayah->nama_wilayah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Domisili (Kecamatan/Desa)</label>
                                <input type="text" name="domisili" value="{{ old('domisili', $profile->domisili) }}" required
                                       class="{{ $fldClass }}" placeholder="Contoh: Kec. Kaliwates, Jember">
                            </div>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="{{ $fldClass }} min-h-[92px] resize-y">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Deskripsi Usaha</label>
                            <textarea name="deskripsi_usaha" rows="3"
                                      class="{{ $fldClass }} min-h-[104px] resize-y">{{ old('deskripsi_usaha', $profile->deskripsi_usaha) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
                            <div>
                                <label class="{{ $lblClass }}">Perizinan</label>
                                <select name="perizinan"
                                        class="{{ $fldClass }}">
                                    <option value="">-- Pilih Perizinan (opsional) --</option>
                                    @foreach(['NIB','SIUP','Halal','Sertifikat','PIP','KBLI','PL','SBU','BPOM'] as $izinOption)
                                        <option value="{{ $izinOption }}" {{ old('perizinan', $profile->perizinan) === $izinOption ? 'selected' : '' }}>{{ $izinOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Media Sosial</label>
                                <input type="text" name="sosial_media" value="{{ old('sosial_media', $profile->sosial_media) }}" placeholder="Instagram, Tiktok, Facebook"
                                       class="{{ $fldClass }}">
                            </div>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Logo UKM</label>
                            @if($profile->foto_logo)
                                <p class="text-xs text-slate-500 mb-1">Logo saat ini:
                                    <a href="{{ $profile->foto_logo_src ?: '#' }}" target="_blank" class="text-[#0f766e] underline">Lihat</a>
                                </p>
                            @endif
                            <label class="{{ $dropClass }}" data-drop>
                                @if($profile->foto_logo_src)
                                    <img data-drop-preview src="{{ $profile->foto_logo_src }}" alt="Logo UKM"
                                         class="h-12 w-12 rounded-xl object-contain shadow-sm ring-2 ring-white">
                                @else
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-xl object-contain shadow-sm ring-2 ring-white">
                                @endif
                                <span class="flex items-center gap-2.5">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12"/></svg>
                                    </span>
                                    <span class="text-left leading-tight">
                                        <span class="block text-sm font-medium text-[#1f7a81]">Pilih logo</span>
                                        <span class="block text-[10px] text-slate-500">JPG, PNG</span>
                                    </span>
                                </span>
                                <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                <input type="file" name="foto_logo" accept="image/jpeg,image/png" class="sr-only">
                            </label>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Link Google Drive</label>
                            @if($profile->gdrive_src)
                                <p class="text-[11px] text-slate-500 mb-2">Link saat ini: <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#56b8c2] underline">Buka Google Drive</a></p>
                            @endif
                            <input type="text" name="url_gdrive" value="{{ old('url_gdrive', $profile->url_gdrive) }}" placeholder="https://drive.google.com/drive/folders/..."
                                   class="{{ $fldClass }}">
                            <p class="text-[11px] text-slate-500 mt-1">Tempel link folder/file Google Drive Anda agar bisa dibuka langsung. Kosongkan jika tidak ada.</p>
                        </div>
                    </section>
                @elseif($user->isMentor())
                    <section id="bagian-profil" class="scroll-mt-24 space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data Mentor</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 xl:grid-cols-3">
                            <div>
                                <label class="{{ $lblClass }}">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $profile->nama) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                            @include('partials._bidang-keahlian', [
                                'bkFieldKey' => 'bidang-keahlian-mentor-profile',
                                'bkValue' => $profile->keahlian ?? null,
                                'bkModel' => 'mentor',
                                'bkLabel' => 'Keahlian',
                                'bkLabelClass' => $lblClass,
                                'bkInputClass' => $fldClass,
                            ])
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Expertise Tags</label>
                                <div class="flex flex-wrap gap-2 rounded-xl border border-slate-200 bg-slate-50 p-2 shadow-sm focus-within:border-[#56b8c2] focus-within:ring-2 focus-within:ring-[#56b8c2]/30">
                                    @php
                                        $mentorTags = isset($profile->expertise_tags) ? $profile->expertise_tags : [];
                                        $mentorTags = is_array($mentorTags) ? $mentorTags : explode(',', (string) $mentorTags);
                                    @endphp
                                    @foreach(array_filter(array_map('trim', $mentorTags)) as $tag)
                                        <span class="inline-flex items-center rounded-full bg-[#e0f7fa] text-[#0f766e] px-2.5 py-1 text-xs font-medium border border-[#bfe9ed]">{{ $tag }}</span>
                                    @endforeach
                                    <input type="text" name="expertise_tags" value="{{ old('expertise_tags', isset($profile->expertise_tags) ? implode(', ', $profile->expertise_tags) : '') }}" placeholder="Digital Marketing, SEO" class="min-w-[120px] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-slate-700 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Pengalaman</label>
                                <input type="text" name="pengalaman" value="{{ old('pengalaman', $profile->pengalaman) }}" placeholder="10+ tahun"
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Wilayah/Domisili</label>
                                <select name="id_wilayah" id="id_wilayah_mentor" required
                                        class="{{ $fldClass }}">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    @foreach(App\Models\Wilayah::orderBy('nama_wilayah')->get() as $wilayah)
                                        <option value="{{ $wilayah->id_wilayah }}" {{ old('id_wilayah', $profile->id_wilayah) == $wilayah->id_wilayah ? 'selected' : '' }}>
                                            {{ $wilayah->nama_wilayah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Domisili (Kecamatan/Desa)</label>
                                <input type="text" name="domisili" value="{{ old('domisili', $profile->domisili) }}" required
                                       class="{{ $fldClass }}" placeholder="Contoh: Kec. Kaliwates, Jember">
                            </div>

                             <div>
                                <label class="{{ $lblClass }}">Sosial Media</label>
                                <input type="text" name="sosial_media" value="{{ old('sosial_media', $profile->sosial_media) }}" placeholder="Instagram, Tiktok, Facebook"
                                       class="{{ $fldClass }}">
                            </div>
                        </div>


                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5">
                            <div>
                                <label class="{{ $lblClass }}">Foto KTP</label>
                                @if($profile->ktp_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->ktp_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="{{ $dropClass }}" data-drop>
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload KTP</div>
                                            <div class="text-[10px] text-slate-500">JPG, PNG</div>
                                        </div>
                                    </div>
                                    <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                    <input type="file" name="url_foto_ktp" accept="image/jpeg,image/png" class="sr-only">
                                </label>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">CV Mentor</label>
                                @if($profile->cv_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="{{ $dropClass }}" data-drop>
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload CV</div>
                                            <div class="text-[10px] text-slate-500">PDF, DOC, DOCX</div>
                                        </div>
                                    </div>
                                    <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                    <input type="file" name="url_cv" accept=".pdf,.doc,.docx" class="sr-only">
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Link Google Drive</label>
                            @if($profile->gdrive_src)
                                <p class="text-[11px] text-slate-500 mb-2">Link saat ini: <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#56b8c2] underline">Buka Google Drive</a></p>
                            @endif
                            <input type="text" name="url_gdrive" value="{{ old('url_gdrive', $profile->url_gdrive) }}" placeholder="https://drive.google.com/drive/folders/..."
                                   class="{{ $fldClass }}">
                            <p class="text-[11px] text-slate-500 mt-1">Tempel link folder/file Google Drive Anda agar bisa dibuka langsung. Kosongkan jika tidak ada.</p>
                        </div>

                        <div>
                            <label class="{{ $lblClass }}">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="{{ $fldClass }} min-h-[92px] resize-y">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </section>
                @elseif($user->isTalent())
                    <section id="bagian-profil" class="scroll-mt-24 space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m4-2a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data Talent</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 xl:grid-cols-3">
                            @include('partials._bidang-keahlian', [
                                'bkFieldKey' => 'bidang-keahlian-talent-profile',
                                'bkValue' => $profile->keahlian ?? null,
                                'bkLabelClass' => $lblClass,
                                'bkInputClass' => $fldClass,
                            ])
                            <div>
                                <label class="{{ $lblClass }}">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Skill Tags</label>
                                <div class="flex flex-wrap gap-2 rounded-xl border border-slate-200 bg-slate-50 p-2 shadow-sm focus-within:border-[#56b8c2] focus-within:ring-2 focus-within:ring-[#56b8c2]/30">
                                    @php
                                        $talentTags = isset($profile->skill_tags) ? $profile->skill_tags : [];
                                        $talentTags = is_array($talentTags) ? $talentTags : explode(',', (string) $talentTags);
                                    @endphp
                                    @foreach(array_filter(array_map('trim', $talentTags)) as $tag)
                                        <span class="inline-flex items-center rounded-full bg-[#e0f7fa] text-[#0f766e] px-2.5 py-1 text-xs font-medium border border-[#bfe9ed]">{{ $tag }}</span>
                                    @endforeach
                                    <input type="text" name="skill_tags" value="{{ old('skill_tags', isset($profile->skill_tags) ? implode(', ', $profile->skill_tags) : '') }}" placeholder="UI/UX, Figma" class="min-w-[120px] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-slate-700 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $profile->nama) }}" required
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Status Pekerjaan</label>
                                <select name="status_pekerjaan" class="{{ $fldClass }}">
                                    <option value="belum bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'belum bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                                    <option value="bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                    <option value="magang" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'magang' ? 'selected' : '' }}>Magang</option>
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Pengalaman</label>
                                <input type="text" name="pengalaman" value="{{ old('pengalaman', $profile->pengalaman) }}" placeholder="Fresh Graduate"
                                       class="{{ $fldClass }}">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Mentor (Opsional)</label>
                                <select name="mentor_id" class="{{ $fldClass }}">
                                    <option value="">-- Tidak Ada Mentor --</option>
                                    @foreach($mentors ?? [] as $mentor)
                                        <option value="{{ $mentor->id_mentor }}" {{ old('mentor_id', $profile->mentor_id) == $mentor->id_mentor ? 'selected' : '' }}>{{ $mentor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Wilayah/Domisili</label>
                                <select name="id_wilayah" id="id_wilayah_talent" required
                                        class="{{ $fldClass }}">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    @foreach(App\Models\Wilayah::orderBy('nama_wilayah')->get() as $wilayah)
                                        <option value="{{ $wilayah->id_wilayah }}" {{ old('id_wilayah', $profile->id_wilayah) == $wilayah->id_wilayah ? 'selected' : '' }}>
                                            {{ $wilayah->nama_wilayah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Domisili (Kecamatan/Desa)</label>
                                <input type="text" name="domisili" value="{{ old('domisili', $profile->domisili) }}" required
                                       class="{{ $fldClass }}" placeholder="Contoh: Kec. Kaliwates, Jember">
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Sosial Media</label>
                                <input type="text" name="sosial_media" value="{{ old('sosial_media', $profile->sosial_media) }}" placeholder="Instagram"
                                       class="{{ $fldClass }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 md:grid-cols-3">
                            <div>
                                <label class="{{ $lblClass }}">Foto KTP</label>
                                @if($profile->ktp_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->ktp_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="{{ $dropClass }}" data-drop>
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload KTP</div>
                                            <div class="text-[10px] text-slate-500">JPG, PNG</div>
                                        </div>
                                    </div>
                                    <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                    <input type="file" name="url_foto_ktp" accept="image/jpeg,image/png" class="sr-only">
                                </label>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">Foto Buku Tabungan</label>
                                @if($profile->butap_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->butap_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="{{ $dropClass }}" data-drop>
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload Buku Tabungan</div>
                                            <div class="text-[10px] text-slate-500">JPG, PNG</div>
                                        </div>
                                    </div>
                                    <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                    <input type="file" name="url_butap" accept="image/jpeg,image/png" class="sr-only">
                                </label>
                            </div>
                            <div>
                                <label class="{{ $lblClass }}">CV Talent</label>
                                @if($profile->cv_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="{{ $dropClass }}" data-drop>
                                    <img data-drop-preview alt="" class="hidden h-12 w-12 rounded-full object-cover shadow-sm ring-2 ring-white">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload CV</div>
                                            <div class="text-[10px] text-slate-500">PDF, DOC, DOCX</div>
                                        </div>
                                    </div>
                                    <span data-drop-name class="hidden w-full truncate text-[10px] font-medium text-[#0f766e]"></span>
                                    <input type="file" name="url_cv" accept=".pdf,.doc,.docx" class="sr-only">
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $lblClass }}">Link Google Drive</label>
                            @if($profile->gdrive_src)
                                <p class="text-[11px] text-slate-500 mb-2">Link saat ini: <a href="{{ $profile->gdrive_src }}" target="_blank" rel="noopener" class="text-[#56b8c2] underline">Buka Google Drive</a></p>
                            @endif
                            <input type="text" name="url_gdrive" value="{{ old('url_gdrive', $profile->url_gdrive) }}" placeholder="https://drive.google.com/drive/folders/..."
                                   class="{{ $fldClass }}">
                            <p class="text-[11px] text-slate-500 mt-1">Tempel link folder/file Google Drive Anda agar bisa dibuka langsung. Kosongkan jika tidak ada.</p>
                        </div>

                        <div>
                            <label class="{{ $lblClass }}">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="{{ $fldClass }} min-h-[92px] resize-y">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </section>
                @endif
            @endif

            {{-- Bar aksi: menempel di dasar layar saat menggulir, sehingga tombol
                 Simpan selalu terjangkau di HP maupun di monitor 1080p. --}}
            <div class="sticky bottom-0 z-20 -mx-4 border-t border-slate-200 bg-white/85 px-4 py-3 backdrop-blur sm:-mx-8 sm:px-8 sm:py-4">
                <div class="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-3">
                    <p data-form-state class="hidden items-center gap-2 text-xs font-medium text-amber-600" aria-live="polite">
                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                        Ada perubahan yang belum disimpan
                    </p>
                    <div class="flex gap-3 sm:ml-auto">
                        <a href="{{ route('profile.show') }}"
                           class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 sm:flex-none">Batal</a>
                        <button type="submit"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#56b8c2] px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-[#56b8c2]/20 transition hover:bg-[#3d9aa3] focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/40 focus:ring-offset-2 sm:flex-none">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span data-save-label>Simpan</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const form = document.getElementById('form-profil');
        if (!form) return;

        /* 1. Status "belum disimpan": muncul begitu ada perubahan + penjaga saat
              menutup/meninggalkan halaman sebelum menyimpan. */
        const state = form.querySelector('[data-form-state]');
        const saveLabel = form.querySelector('[data-save-label]');
        let dirty = false;
        let leaving = false;

        const markDirty = () => {
            if (dirty) return;
            dirty = true;
            state?.classList.remove('hidden');
            state?.classList.add('flex');
        };

        form.addEventListener('input', markDirty);
        form.addEventListener('change', markDirty);
        form.addEventListener('submit', () => {
            leaving = true;
            if (saveLabel) saveLabel.textContent = 'Menyimpan...';
            form.querySelectorAll('button[type="submit"]').forEach((btn) => {
                btn.classList.add('pointer-events-none', 'opacity-80');
            });
        });
        window.addEventListener('beforeunload', (event) => {
            if (dirty && !leaving) event.preventDefault();
        });

        /* 2. Kotak unggah: tampilkan nama + ukuran berkas, dan pratinjau untuk gambar. */
        const humanSize = (bytes) => bytes >= 1048576
            ? (bytes / 1048576).toFixed(1) + ' MB'
            : Math.max(1, Math.round(bytes / 1024)) + ' KB';

        form.querySelectorAll('input[type="file"]').forEach((input) => {
            input.addEventListener('change', () => {
                const box = input.closest('[data-drop]');
                const nameEl = box?.querySelector('[data-drop-name]');
                const previewEl = box?.querySelector('[data-drop-preview]');
                const file = input.files?.[0];

                if (!file) return;

                if (nameEl) {
                    nameEl.textContent = `${file.name} • ${humanSize(file.size)}`;
                    nameEl.classList.remove('hidden');
                }
                if (previewEl && file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    previewEl.onload = () => URL.revokeObjectURL(url);
                    previewEl.src = url;
                    previewEl.classList.remove('hidden');
                }
            });
        });

        /* 3. Textarea tumbuh mengikuti panjang isi (maksimal 420px lalu di-scroll). */
        const autoGrow = (el) => {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight + 2, 420) + 'px';
        };
        form.querySelectorAll('textarea').forEach((el) => {
            autoGrow(el);
            el.addEventListener('input', () => autoGrow(el));
        });
    })();
</script>
@endsection