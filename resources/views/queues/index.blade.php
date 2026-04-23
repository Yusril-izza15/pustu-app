@extends('layouts.app')
{{--
    Path   : resources/views/queues/index.blade.php
    Status : FILE BARU
--}}

@section('title', 'Antrian Pasien')
@section('page-title', 'Antrian Pasien')
@section('page-subtitle', 'Monitor dan kelola antrian pasien hari ini')

@section('content')

    {{-- ===== STAT CARDS ===== --}}
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); margin-bottom:20px;">

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $stats['menunggu'] }}</div>
            <div class="stat-label">Menunggu</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $stats['dipanggil'] }}</div>
            <div class="stat-label">Dipanggil</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon teal">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $stats['selesai'] }}</div>
            <div class="stat-label">Selesai</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#f3f4f6; color:#374151;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $stats['menunggu'] + $stats['dipanggil'] + $stats['selesai'] }}</div>
            <div class="stat-label">Total Antrian</div>
        </div>

    </div>

    {{-- ===== MAIN CARD ===== --}}
    <div class="card">

        {{-- Header: Filter + Tombol Tambah --}}
        <div class="card-header" style="flex-wrap:wrap; gap:12px;">

            <form method="GET" action="{{ route('queues.index') }}"
                  style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

                {{-- Filter Tanggal --}}
                <div>
                    <input
                        type="date"
                        name="tanggal"
                        class="search-input"
                        style="padding:7px 12px; font-size:.85rem;"
                        value="{{ $tanggal }}"
                    >
                </div>

                {{-- Filter Dokter --}}
                <div>
                    <select
                        name="doctor_id"
                        class="search-input"
                        style="padding:7px 12px; font-size:.85rem; min-width:180px;"
                    >
                        <option value="">Semua Dokter</option>
                        @foreach ($doctors as $doctor)
                            <option
                                value="{{ $doctor->id }}"
                                {{ $filterDoktor == $doctor->id ? 'selected' : '' }}
                            >
                                {{ $doctor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    Filter
                </button>

                <a href="{{ route('queues.index') }}" class="btn btn-ghost">Reset</a>

            </form>

            <a href="{{ route('queues.create') }}" class="btn btn-primary" style="margin-left:auto;">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Ambil Antrian
            </a>

        </div>

        {{-- ===== TABEL ===== --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px; text-align:center;">No. Antrian</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Jadwal</th>
                        <th>Tanggal</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center; width:200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($queues as $queue)
                        @php $style = $queue->statusStyle(); @endphp
                        <tr>

                            {{-- Nomor Antrian --}}
                            <td style="text-align:center;">
                                <span style="
                                    display:inline-flex; align-items:center; justify-content:center;
                                    width:40px; height:40px; border-radius:50%;
                                    background:var(--primary); color:white;
                                    font-weight:800; font-size:1rem;
                                ">
                                    {{ $queue->nomor_antrian }}
                                </span>
                            </td>

                            {{-- Pasien --}}
                            <td>
                                <div style="font-weight:600; font-size:.875rem;">{{ $queue->patient->nama }}</div>
                                <div style="font-size:.75rem; color:var(--text-muted);">
                                    {{ $queue->patient->no_rekam_medis }}
                                </div>
                            </td>

                            {{-- Dokter --}}
                            <td>
                                <div style="font-weight:600; font-size:.875rem;">{{ $queue->doctor->nama }}</div>
                                <div style="font-size:.75rem; color:var(--text-muted);">{{ $queue->doctor->spesialis }}</div>
                            </td>

                            {{-- Jadwal --}}
                            <td style="font-size:.82rem; color:var(--text-soft);">
                                {{ $queue->schedule->hari }}
                                <span style="font-family:monospace; color:var(--primary-dk);">
                                    {{ substr($queue->schedule->jam_mulai, 0, 5) }}–{{ substr($queue->schedule->jam_selesai, 0, 5) }}
                                </span>
                                @if ($queue->schedule->isKhusus())
                                    <span style="font-size:.7rem; color:#c2410c; font-weight:700;"> ⭐Khusus</span>
                                @endif
                            </td>

                            {{-- Tanggal --}}
                            <td style="font-size:.85rem; color:var(--text-soft);">
                                {{ \Carbon\Carbon::parse($queue->tanggal)->format('d M Y') }}
                            </td>

                            {{-- Status Badge --}}
                            <td style="text-align:center;">
                                <span style="
                                    display:inline-flex; align-items:center; gap:5px;
                                    background:{{ $style['bg'] }};
                                    color:{{ $style['color'] }};
                                    border:1px solid {{ $style['border'] }};
                                    border-radius:20px; padding:4px 12px;
                                    font-size:.75rem; font-weight:700;
                                    white-space:nowrap;
                                ">
                                    <span style="width:6px;height:6px;background:{{ $style['dot'] }};border-radius:50%;display:inline-block;"></span>
                                    {{ $queue->statusLabel() }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td style="text-align:center;">
                                <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">

                                    {{-- Tombol Panggil → hanya jika status = menunggu --}}
                                    @if ($queue->status === \App\Models\Queue::STATUS_MENUNGGU)
                                        <form method="POST" action="{{ route('queues.updateStatus', $queue) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button type="submit" class="btn btn-sm" style="
                                                background:#eff6ff; color:#1d4ed8;
                                                border:1px solid #bfdbfe; border-radius:6px;
                                                font-size:.75rem; font-weight:700;
                                                padding:5px 10px;
                                            ">
                                                📣 Panggil
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Selesai → hanya jika status = dipanggil --}}
                                    @if ($queue->status === \App\Models\Queue::STATUS_DIPANGGIL)
                                        <form method="POST" action="{{ route('queues.updateStatus', $queue) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-sm" style="
                                                background:#f0fdfa; color:#0d9488;
                                                border:1px solid #a7f3d0; border-radius:6px;
                                                font-size:.75rem; font-weight:700;
                                                padding:5px 10px;
                                            ">
                                                ✅ Selesai
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form
                                        method="POST"
                                        action="{{ route('queues.destroy', $queue) }}"
                                        onsubmit="return confirm('Yakin hapus antrian No.{{ $queue->nomor_antrian }} — {{ addslashes($queue->patient->nama) }}?')"
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
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                    </svg>
                                    <p>Belum ada antrian untuk tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong></p>
                                    <a href="{{ route('queues.create') }}" class="btn btn-primary">
                                        Ambil Antrian Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== PAGINATION ===== --}}
        @if ($queues->hasPages())
            <div class="pagination-wrap">
                <span>
                    Menampilkan {{ $queues->firstItem() }}–{{ $queues->lastItem() }}
                    dari <strong>{{ $queues->total() }}</strong> antrian
                </span>
                {{ $queues->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="padding:12px 20px; font-size:.8rem; color:var(--text-muted); border-top:1px solid var(--border);">
                Total <strong>{{ $queues->total() }}</strong> antrian
            </div>
        @endif

    </div>

@endsection
