@extends('layouts.admin')

@section('title', 'Detail Client')
@section('header', 'Detail Client (UMKM)')

@section('content')
<div class="max-w-4xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $client->nama_ukm }}</h3>
            <p class="text-sm text-gray-500">Nama Produk: {{ $client->nama_produk ?? '-' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $client->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($client->status) }}
            </span>
            <a href="{{ route('admin.clients.edit', $client->id_client) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition">
                Edit
            </a>
            <a href="{{ route('admin.clients.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Informasi Umum</h4>
            <dl class="space-y-2 text-sm">
                <div>
                    <dt class="text-xs text-gray-400">Nama User</dt>
                    <dd class="font-medium text-gray-800">{{ $client->user->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Email</dt>
                    <dd class="font-medium text-gray-800">{{ $client->user->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Deskripsi Usaha</dt>
                    <dd class="text-gray-700">{{ $client->deskripsi_usaha ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-rose-50/50 p-4 rounded-xl border border-rose-100">
            <h4 class="text-sm font-bold text-rose-800 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                <span>🔒 Data Sensitif (Admin Only)</span>
            </h4>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs text-rose-500">No. WhatsApp</dt>
                    <dd class="font-semibold text-gray-800">{{ $client->no_hp }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500">Alamat Lengkap</dt>
                    <dd class="text-gray-800">{{ $client->alamat_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-rose-500 mb-1">Foto Logo/Produk</dt>
                    <dd>
                        @if($client->foto_logo)
                            <a href="{{ asset('storage/' . $client->foto_logo) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-rose-600 underline hover:text-rose-800">
                                Lihat Foto
                            </a>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    @if($client->foto_logo)
        <div class="border-t pt-4">
            <h4 class="text-sm font-bold text-gray-700 mb-2">Foto Logo / Produk</h4>
            <img src="{{ asset('storage/' . $client->foto_logo) }}" alt="Foto Logo" class="max-h-60 rounded-lg border object-cover">
        </div>
    @endif
</div>
@endsection