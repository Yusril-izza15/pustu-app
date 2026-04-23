@extends('layouts.app')
{{--
    Path   : resources/views/schedules/index.blade.php
    Status : FILE BARU
--}}

@section('title', 'Jadwal Dokter')
@section('page-title', 'Jadwal Dokter')
@section('page-subtitle', 'Kelola jadwal praktek dokter Puskesmas Pembantu')

@section('content')

    <div class="card">

        {{-- ===== HEADER: Search + Tombol Tambah ===== --}}
        <div class="card-header" style="flex-wrap:wrap; gap:12px;">

            <form method="GET" action="{{ route('schedules.index') }}" class="search-bar">
                <div class="search-input-wrap">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari nama dokter / hari..."
                        value="{{ $search }}"
                    >
                </div>
                <button type="submit" class="btn btn-ghost">Cari</button>
                @if ($search)
                    <a href="{{ route('schedules.index') }}" class="btn btn-ghost">✕ Reset</a>
                @endif
            </form>

            <a href="{{ route('schedules.create') }}" class="btn btn-primary" style="margin-left:auto;">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah Jadwal
            </a>

        </div>

        {{-- Info hasil pencarian --}}
        @if ($search)
            <div style="padding:10px 20px; font-size:.8rem; color:var(--text-muted); border-bottom:1px solid var(--border);">
                Ditemukan <strong>{{ $schedules->total() }}</strong> jadwal
                untuk "<strong>{{ $search }}</strong>"
            </div>
        @endif

        {{-- ===== TABEL ===== --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Dokter</th>
                        <th>Hari</th>
                        <th>Tanggal Khusus</th>
                        <th>Jam Praktek</th>
                        <th style="text-align:center;">Jenis</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center; width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td style="color:var(--text-muted); font-size:.8rem;">
                                {{ ($schedules->currentPage() - 1) * $schedules->perPage() + $loop->iteration }}
                            </td>

                            {{-- Dokter --}}
                            <td>
                                <div style="font-weight:600; color:var(--text); font-size:.875rem;">
                                    {{ $schedule->doctor->nama }}
                                </div>
                                <div style="font-size:.75rem; color:var(--text-muted);">
                                    {{ $schedule->doctor->spesialis }}
                                </div>
                            </td>

                            {{-- Hari --}}
                            <td style="font-weight:600; font-size:.875rem;">
                                {{ $schedule->hari }}
                            </td>

                            {{-- Tanggal Khusus --}}
                            <td style="font-size:.85rem; color:var(--text-soft);">
                                @if ($schedule->tanggal)
                                    {{ $schedule->tanggal->format('d M Y') }}
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>

                            {{-- Jam Praktek --}}
                            <td>
                                <span style="
                                    font-family: monospace;
                                    font-size: .875rem;
                                    font-weight: 600;
                                    color: var(--primary-dk);
                                    background: var(--primary-lt);
                                    border: 1px solid var(--primary-mid);
                                    padding: 3px 10px;
                                    border-radius: 6px;
                                    white-space: nowrap;
                                ">
                                    {{ substr($schedule->jam_mulai, 0, 5) }}
                                    –
                                    {{ substr($schedule->jam_selesai, 0, 5) }}
                                </span>
                            </td>

                            {{-- Jenis Jadwal --}}
                            <td style="text-align:center;">
                                @if ($schedule->isKhusus())
                                    <span style="
                                        background:#fff7ed; color:#c2410c;
                                        border:1px solid #fed7aa;
                                        border-radius:20px; padding:3px 10px;
                                        font-size:.73rem; font-weight:700;
                                    ">⭐ Khusus</span>
                                @else
                                    <span style="
                                        background:#f0f9ff; color:#0369a1;
                                        border:1px solid #bae6fd;
                                        border-radius:20px; padding:3px 10px;
                                        font-size:.73rem; font-weight:700;
                                    ">🔄 Rutin</span>
                                @endif
                            </td>

                            {{-- Status Aktif --}}
                            <td style="text-align:center;">
                                @if ($schedule->is_active)
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

                            {{-- Aksi --}}
                            <td style="text-align:center;">
                                <div style="display:flex; gap:6px; justify-content:center;">
                                    <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-warn btn-sm">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('schedules.destroy', $schedule) }}"
                                        onsubmit="return confirm('Yakin hapus jadwal {{ addslashes($schedule->doctor->nama) }} — {{ $schedule->hari }}?')"
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
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                    </svg>
                                    <p>
                                        @if ($search)
                                            Tidak ada jadwal dengan kata kunci "<strong>{{ $search }}</strong>"
                                        @else
                                            Belum ada data jadwal dokter.
                                        @endif
                                    </p>
                                    @if (!$search)
                                        <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                                            Tambah Jadwal Pertama
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
        @if ($schedules->hasPages())
            <div class="pagination-wrap">
                <span>
                    Menampilkan {{ $schedules->firstItem() }}–{{ $schedules->lastItem() }}
                    dari <strong>{{ $schedules->total() }}</strong> jadwal
                </span>
                {{ $schedules->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="padding:12px 20px; font-size:.8rem; color:var(--text-muted); border-top:1px solid var(--border);">
                Total <strong>{{ $schedules->total() }}</strong> jadwal
            </div>
        @endif

    </div>

@endsection
