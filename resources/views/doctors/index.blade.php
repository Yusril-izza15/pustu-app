@extends('layouts.app')
{{--
    Path   : resources/views/doctors/index.blade.php
    Status : FILE BARU
--}}

@section('title', 'Data Dokter')
@section('page-title', 'Data Dokter')
@section('page-subtitle', 'Kelola data dokter Puskesmas Pembantu')

@section('content')

    <div class="card">

        {{-- ===== HEADER: Search + Tombol Tambah ===== --}}
        <div class="card-header" style="flex-wrap:wrap; gap:12px;">

            <form method="GET" action="{{ route('doctors.index') }}" class="search-bar">
                <div class="search-input-wrap">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari nama / spesialis..."
                        value="{{ $search }}"
                    >
                </div>
                <button type="submit" class="btn btn-ghost">Cari</button>
                @if ($search)
                    <a href="{{ route('doctors.index') }}" class="btn btn-ghost">✕ Reset</a>
                @endif
            </form>

            <a href="{{ route('doctors.create') }}" class="btn btn-primary" style="margin-left:auto;">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah Dokter
            </a>

        </div>

        {{-- Info hasil pencarian --}}
        @if ($search)
            <div style="padding:10px 20px; font-size:.8rem; color:var(--text-muted); border-bottom:1px solid var(--border);">
                Ditemukan <strong>{{ $doctors->total() }}</strong> dokter
                untuk "<strong>{{ $search }}</strong>"
            </div>
        @endif

        {{-- ===== TABEL ===== --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Dokter</th>
                        <th>Spesialis</th>
                        <th>No. HP</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center; width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td style="color:var(--text-muted); font-size:.8rem;">
                                {{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}
                            </td>

                            <td>
                                <div style="font-weight:600; color:var(--text);">{{ $doctor->nama }}</div>
                            </td>

                            <td>
                                <span style="
                                    display:inline-block;
                                    background:#f0fdfa;
                                    color:#0d9488;
                                    border:1px solid #ccfbf1;
                                    border-radius:20px;
                                    padding:2px 10px;
                                    font-size:.78rem;
                                    font-weight:600;
                                ">
                                    {{ $doctor->spesialis }}
                                </span>
                            </td>

                            <td style="color:var(--text-muted); font-size:.875rem;">
                                {{ $doctor->no_hp ?? '—' }}
                            </td>

                            <td style="text-align:center;">
                                @if ($doctor->is_active)
                                    <span style="
                                        display:inline-flex; align-items:center; gap:4px;
                                        background:#f0fdfa; color:#0d9488;
                                        border:1px solid #a7f3d0;
                                        border-radius:20px; padding:3px 10px;
                                        font-size:.75rem; font-weight:700;
                                    ">
                                        <span style="width:6px;height:6px;background:#0d9488;border-radius:50%;display:inline-block;"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span style="
                                        display:inline-flex; align-items:center; gap:4px;
                                        background:#f8fafc; color:#94a3b8;
                                        border:1px solid #e2e8f0;
                                        border-radius:20px; padding:3px 10px;
                                        font-size:.75rem; font-weight:700;
                                    ">
                                        <span style="width:6px;height:6px;background:#94a3b8;border-radius:50%;display:inline-block;"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td style="text-align:center;">
                                <div style="display:flex; gap:6px; justify-content:center;">
                                    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warn btn-sm">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('doctors.destroy', $doctor) }}"
                                        onsubmit="return confirm('Yakin hapus dokter {{ addslashes($doctor->nama) }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                                    </svg>
                                    <p>
                                        @if ($search)
                                            Tidak ada dokter dengan kata kunci "<strong>{{ $search }}</strong>"
                                        @else
                                            Belum ada data dokter.
                                        @endif
                                    </p>
                                    @if (!$search)
                                        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                                            Tambah Dokter Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== PAGINATION ===== --}}
        @if ($doctors->hasPages())
            <div class="pagination-wrap">
                <span>
                    Menampilkan {{ $doctors->firstItem() }}–{{ $doctors->lastItem() }}
                    dari <strong>{{ $doctors->total() }}</strong> dokter
                </span>
                {{ $doctors->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="padding:12px 20px; font-size:.8rem; color:var(--text-muted); border-top:1px solid var(--border);">
                Total <strong>{{ $doctors->total() }}</strong> dokter
            </div>
        @endif

    </div>

@endsection
