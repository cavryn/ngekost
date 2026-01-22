@extends('layouts.app')

@section('title', 'Admin - Laporan')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>🚨 Daftar Laporan</h3>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            ⬅️ Dashboard Admin
        </a>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>User</th>
                <th>Kontrakan</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $l)
            <tr>
                <td>{{ $l->user->email }}</td>
                <td>{{ $l->kontrakan->judul }}</td>
                <td>{{ $l->alasan }}</td>
                <td>
                    {{-- HAPUS KONTRAKAN --}}
                    <form method="POST"
                          action="{{ route('admin.kontrakan.hapus', $l->kontrakan->id) }}"
                          class="d-inline"
                          onsubmit="return confirm('Hapus kontrakan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            🗑️ Hapus Kontrakan
                        </button>
                    </form>

                    {{-- BLOKIR USER --}}
                    <form method="POST"
                          action="{{ route('admin.user.block', $l->user->id) }}"
                          class="d-inline"
                          onsubmit="return confirm('Blokir user ini?')">
                        @csrf
                        <button class="btn btn-warning btn-sm">
                            🚫 Blokir User
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">
                    Tidak ada laporan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
