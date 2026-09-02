"@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-[0_12px_32px_rgba(15,23,42,0.08)] border border-slate-200 rounded-2xl overflow-hidden">
        <div class="px-6 py-6 border-b border-slate-200 bg-gradient-to-r from-[#f0fbfc] to-white">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#56b8c2]">Profil</p>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-slate-800">Edit Profil</h2>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-[#ecfeff] text-[#0f766e] px-3 py-1.5 text-xs font-medium border border-[#b7ebee]">
                    <span class="h-2 w-2 rounded-full bg-[#14b8c4]"></span>
                    Update data akun
                </div>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <section class="space-y-4">
                <div class="flex items-center gap-2 text-slate-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <h3 class="text-lg font-bold text-slate-800">Informasi Akun</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20V7a2 2 0 012-2h10a2 2 0 012 2v13M9 9h6M9 13h6"/></svg>
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                    </div>
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm-8 0V7a4 4 0 118 0v5"/></svg>
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                    </div>
                    <div class="md:col-span-1">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 mb-2">
                            <svg class="h-4 w-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12"/></svg>
                            Foto Profil
                        </label>
                        @if($user->profile_photo_src)
                            <p class="text-[11px] text-slate-500 mb-2">Foto saat ini: <a href="{{ $user->profile_photo_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                        @endif
                        <label class="group flex items-center justify-center w-full h-12 border-2 border-dashed border-[#bfe9ed] rounded-xl bg-[#f8fdfd] cursor-pointer transition-all duration-200 hover:border-[#56b8c2] hover:bg-[#effbfc] hover:shadow-sm">
                            <div class="flex items-center gap-2.5 px-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 12m4-4v12"/></svg>
                                </span>
                                <div class="text-left leading-tight">
                                    <div class="text-sm font-medium text-[#1f7a81]">Pilih foto</div>
                                    <div class="text-[10px] text-slate-500">JPG, PNG max 2MB</div>
                                </div>
                            </div>
                            <input type="file" name="profile_photo" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </section>

            @if($profile)
                @if($user->isClient())
                    <section class="space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16v10H4zM9 11h6"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data UKM</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama UKM</label>
                                <input type="text" name="nama_ukm" value="{{ old('nama_ukm', $profile->nama_ukm) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk', $profile->nama_produk) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Usaha</label>
                            <textarea name="deskripsi_usaha" rows="3"
                                      class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">{{ old('deskripsi_usaha', $profile->deskripsi_usaha) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Logo UKM</label>
                            @if($profile->foto_logo)
                                <p class="text-xs text-slate-500 mb-1">Logo saat ini:
                                    <a href="{{ $profile->foto_logo_src ?: '#' }}" target="_blank" class="text-[#0f766e] underline">Lihat</a>
                                </p>
                            @endif
                            <input type="file" name="foto_logo" accept="image/jpeg,image/png"
                                   class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                        </div>
                    </section>
                @elseif($user->isMentor())
                    <section class="space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data Mentor</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Keahlian</label>
                                <input type="text" name="keahlian" value="{{ old('keahlian', $profile->keahlian) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Expertise Tags</label>
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
                                <label class="block text-sm font-medium text-slate-700 mb-2">Status Ketersediaan</label>
                                <select name="is_available" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                                    <option value="1" {{ old('is_available', $profile->is_available ? '1' : '0') == '1' ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ old('is_available', $profile->is_available ? '1' : '0') == '0' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">CV Mentor</label>
                                @if($profile->cv_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="group flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-[#bfe9ed] rounded-2xl bg-[#f8fdfd] cursor-pointer transition-all duration-200 hover:border-[#56b8c2] hover:bg-[#effbfc] hover:shadow-sm">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload CV</div>
                                            <div class="text-[10px] text-slate-500">PDF, DOC, DOCX</div>
                                        </div>
                                    </div>
                                    <input type="file" name="url_cv" accept=".pdf,.doc,.docx" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </section>
                @elseif($user->isTalent())
                    <section class="space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-center gap-2 text-slate-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ecfeff] text-[#0f766e]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m4-2a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">Data Talent</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Keahlian</label>
                                <input type="text" name="keahlian" value="{{ old('keahlian', $profile->keahlian) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Skill Tags</label>
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
                                <label class="block text-sm font-medium text-slate-700 mb-2">Status Pekerjaan</label>
                                <select name="status_pekerjaan" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">
                                    <option value="belum bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'belum bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                                    <option value="bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                    <option value="magang" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'magang' ? 'selected' : '' }}>Magang</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">CV Talent</label>
                                @if($profile->cv_src)
                                    <p class="text-[11px] text-slate-500 mb-2">File saat ini: <a href="{{ $profile->cv_src }}" target="_blank" class="text-[#56b8c2] underline">Lihat</a></p>
                                @endif
                                <label class="group flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-[#bfe9ed] rounded-2xl bg-[#f8fdfd] cursor-pointer transition-all duration-200 hover:border-[#56b8c2] hover:bg-[#effbfc] hover:shadow-sm">
                                    <div class="flex items-center gap-3 text-center">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#56b8c2] text-white shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828A4 4 0 1011.172 3l-6.586 6.586a6 6 0 108.485 8.485L20 15"/></svg>
                                        </span>
                                        <div class="text-left">
                                            <div class="text-sm font-medium text-[#1f7a81]">Upload CV</div>
                                            <div class="text-[10px] text-slate-500">PDF, DOC, DOCX</div>
                                        </div>
                                    </div>
                                    <input type="file" name="url_cv" accept=".pdf,.doc,.docx" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </section>
                @endif
            @endif

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-medium transition shadow-sm">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-xl text-sm font-semibold transition shadow-md shadow-[#56b8c2]/20">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection"