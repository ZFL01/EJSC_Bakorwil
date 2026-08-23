@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#56b8c2] to-[#3d9aa3] px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-white/80">{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Role</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ ucfirst($user->role) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Profile Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Profil</h3>
                    @if($profile)
                        @if($user->isClient())
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm text-gray-500">Nama UKM</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->nama_ukm }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Jenis Produk</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->jenis_produk }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Status</dt>
                                    <dd class="text-sm font-medium {{ $profile->status === 'aktif' ? 'text-emerald-600' : 'text-gray-600' }}">{{ ucfirst($profile->status) }}</dd>
                                </div>
                            </dl>
                        @elseif($user->isMentor())
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm text-gray-500">Keahlian</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->keahlian }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Pengalaman</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->pengalaman ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Ketersediaan</dt>
                                    <dd class="text-sm font-medium {{ $profile->is_available ? 'text-emerald-600' : 'text-amber-600' }}">{{ $profile->is_available ? 'Available' : 'Unavailable' }}</dd>
                                </div>
                            </dl>
                        @elseif($user->isTalent())
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm text-gray-500">Keahlian</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->keahlian }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Status Pekerjaan</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ ucfirst($profile->status_pekerjaan ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Mentor</dt>
                                    <dd class="text-sm font-medium text-gray-800">{{ $profile->mentor->nama ?? '-' }}</dd>
                                </div>
                            </dl>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">Profil belum lengkap.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-4">
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">
                    Edit Profil
                </a>
                <a href="{{ route('public.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection