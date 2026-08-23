"@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                </div>
            </div>

            @if($profile)
                @if($user->isClient())
                    <div class="border-t pt-4">
                        <h3 class="text-md font-bold text-gray-700 mb-4">Data UKM</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama UKM</label>
                                <input type="text" name="nama_ukm" value="{{ old('nama_ukm', $profile->nama_ukm) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk</label>
                                <input type="text" name="jenis_produk" value="{{ old('jenis_produk', $profile->jenis_produk) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Usaha</label>
                            <textarea name="deskripsi_usaha" rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">{{ old('deskripsi_usaha', $profile->deskripsi_usaha) }}</textarea>
                        </div>
                    </div>
                @elseif($user->isMentor())
                    <div class="border-t pt-4">
                        <h3 class="text-md font-bold text-gray-700 mb-4">Data Mentor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                                <input type="text" name="keahlian" value="{{ old('keahlian', $profile->keahlian) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expertise Tags</label>
                                <input type="text" name="expertise_tags" value="{{ old('expertise_tags', isset($profile->expertise_tags) ? implode(', ', $profile->expertise_tags) : '') }}"
                                       placeholder="Digital Marketing, SEO"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </div>
                @elseif($user->isTalent())
                    <div class="border-t pt-4">
                        <h3 class="text-md font-bold text-gray-700 mb-4">Data Talent</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                                <input type="text" name="keahlian" value="{{ old('keahlian', $profile->keahlian) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
                                <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Tags</label>
                                <input type="text" name="skill_tags" value="{{ old('skill_tags', isset($profile->skill_tags) ? implode(', ', $profile->skill_tags) : '') }}"
                                       placeholder="UI/UX, Figma"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pekerjaan</label>
                                <select name="status_pekerjaan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                                    <option value="belum bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'belum bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                                    <option value="bekerja" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                    <option value="magang" {{ old('status_pekerjaan', $profile->status_pekerjaan) === 'magang' ? 'selected' : '' }}>Magang</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat_lengkap" rows="2" required
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">{{ old('alamat_lengkap', $profile->alamat_lengkap) }}</textarea>
                        </div>
                    </div>
                @endif
            @endif

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection"