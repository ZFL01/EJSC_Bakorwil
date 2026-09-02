@if ($u->status === 'pending')
    <form action="{{ route('admin.users.approve', $u) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Setujui</button>
    </form>
    <form action="{{ route('admin.users.reject', $u) }}" method="POST" class="inline ml-1"
          onsubmit="return confirm('Tolak dan hapus akun {{ $u->email }}?');">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Tolak</button>
    </form>
@elseif ($u->status === 'aktif')
    <form action="{{ route('admin.users.deactivate', $u) }}" method="POST" class="inline"
          onsubmit="return confirm('Nonaktifkan akun {{ $u->email }}?');">
        @csrf
        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Nonaktifkan</button>
    </form>
@else
    <form action="{{ route('admin.users.activate', $u) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Aktifkan</button>
    </form>
@endif
<form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline ml-1"
      onsubmit="return confirm('Hapus PERMANEN akun {{ $u->email }}? Tindakan ini tidak dapat dibatalkan.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Hapus</button>
</form>
