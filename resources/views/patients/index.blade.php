@extends('layouts.app')
{{-- Path: resources/views/patients/index.blade.php --}}

@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')
@section('page-subtitle', 'Kelola seluruh data pasien Puskesmas Pembantu')

@section('content')

    <div class="card">

        {{-- Header: search + tombol tambah --}}
        <div class="card-header" style="flex-wrap:wrap; gap:12px;">
            <form method="GET" action="{{ route('patients.index') }}" class="search-bar">
                <div class="search-input-wrap">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari nama / no. rekam medis..."
                        value="{{ $search }}"
                    >
                </div>
                <button type="submit" class="btn btn-ghost">Cari</button>
                @if ($search)
                    <a href="{{ route('patients.index') }}" class="btn btn-ghost">✕ Reset</a>
                @endif
            </form>

            <a href="{{ route('patients.create') }}" class="btn btn-primary" style="margin-left:auto;">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah Pasien
            </a>
        </div>

        {{-- Info total --}}
        @if ($search)
            <div style="padding:10px 20px; font-size:.8rem; color:var(--text-muted); border-bottom:1px solid var(--border);">
                Ditemukan <strong>{{ $patients->total() }}</strong> pasien untuk "<strong>{{ $search }}</strong>"
            </div>
        @endif

        {{-- Tabel --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>No. Rekam Medis</th>
                        <th>Nama Pasien</th>
                        <th>JK</th>
                        <th>Tanggal Lahir</th>
                        <th>No. HP</th>
                        <th style="text-align:center; width:110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td style="color:var(--text-muted); font-size:.8rem;">
                                {{ ($patients->currentPage() - 1) * $patients->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <span class="badge badge-rm">{{ $patient->no_rekam_medis }}</span>
                            </td>
                            <td style="font-weight:600;">{{ $patient->nama }}</td>
                            <td>
                                @if ($patient->jenis_kelamin === 'L')
                                    <span class="badge badge-lk">Laki-laki</span>
                                @else
                                    <span class="badge badge-pr">Perempuan</span>
                                @endif
                            </td>
                            <td style="color:var(--text-soft); font-size:.85rem;">
                                {{ $patient->tanggal_lahir->format('d M Y') }}
                            </td>
                            <td style="color:var(--text-muted); font-size:.85rem;">
                                {{ $patient->no_hp ?? '—' }}
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:6px; justify-content:center;">
                                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warn btn-sm">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}"
                                          onsubmit="return confirm('Hapus pasien {{ addslashes($patient->nama) }}?')">
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
                                        <path d="M20 6h-2.18c.07-.44.18-.88.18-1.33C18 2.53 15.84.5 13.16.5c-1.52 0-2.8.72-3.65 1.81L9 3l-.5-.69C7.65 1.22 6.37.5 4.84.5 2.16.5 0 2.53 0 4.67c0 .45.11.89.18 1.33H0v2h20V6z"/>
                                    </svg>
                                    <p>
                                        @if ($search)
                                            Tidak ada pasien dengan kata kunci "<strong>{{ $search }}</strong>"
                                        @else
                                            Belum ada data pasien.
                                        @endif
                                    </p>
                                    @if (!$search)
                                        <a href="{{ route('patients.create') }}" class="btn btn-primary">
                                            Tambah Pasien Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($patients->hasPages())
            <div class="pagination-wrap">
                <span>
                    Menampilkan {{ $patients->firstItem() }}–{{ $patients->lastItem() }}
                    dari <strong>{{ $patients->total() }}</strong> pasien
                </span>
                {{ $patients->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="padding:12px 20px; font-size:.8rem; color:var(--text-muted); border-top:1px solid var(--border);">
                Total <strong>{{ $patients->total() }}</strong> pasien
            </div>
        @endif

    </div>

@endsection
