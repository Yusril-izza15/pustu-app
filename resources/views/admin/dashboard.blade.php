@extends('layouts.app')
{{--
    Path   : resources/views/admin/dashboard.blade.php
    Status : GANTI — tulis ulang full file ini
    Ubahan : Statistik real dari database
--}}

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')

@php
    use Carbon\Carbon;
    use App\Models\Patient;
    use App\Models\Doctor;
    use App\Models\Queue;

    $today = Carbon::now('Asia/Jakarta')->toDateString();

    $totalPasien       = Patient::count();
    $pasienHariIni     = Patient::whereDate('created_at', $today)->count();
    $totalDokterAktif  = Doctor::where('is_active', true)->count();
    $antrianHariIni    = Queue::where('tanggal', $today)->count();
    $antrianMenunggu   = Queue::where('tanggal', $today)->where('status', 'menunggu')->count();
    $antrianSelesai    = Queue::where('tanggal', $today)->where('status', 'selesai')->count();
    $antrianDipanggil  = Queue::where('tanggal', $today)->where('status', 'dipanggil')->count();
@endphp

    {{-- ===== STAT CARDS ===== --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon teal">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $totalPasien }}</div>
            <div class="stat-label">Total Pasien</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $pasienHariIni }}</div>
            <div class="stat-label">Pasien Daftar Hari Ini</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon teal">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $totalDokterAktif }}</div>
            <div class="stat-label">Dokter Aktif</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 15h16v-2H4v2zm0 4h16v-2H4v2zm0-8h16V9H4v2zm0-6v2h16V5H4z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $antrianHariIni }}</div>
            <div class="stat-label">Antrian Hari Ini</div>
        </div>

    </div>

    {{-- ===== ANTRIAN HARI INI BREAKDOWN + AKSES CEPAT ===== --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

        {{-- Breakdown antrian --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Status Antrian Hari Ini</span>
                <a href="{{ route('queues.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body" style="padding:16px 20px;">
                <div style="display:flex; flex-direction:column; gap:10px;">

                    {{-- Menunggu --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#fefce8; border:1px solid #fde68a; border-radius:8px;">
                        <span style="font-size:.875rem; font-weight:600; color:#92400e;">⏳ Menunggu</span>
                        <span style="font-size:1.4rem; font-weight:800; color:#f59e0b; font-family:monospace;">{{ $antrianMenunggu }}</span>
                    </div>

                    {{-- Dipanggil --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px;">
                        <span style="font-size:.875rem; font-weight:600; color:#1d4ed8;">📣 Dipanggil</span>
                        <span style="font-size:1.4rem; font-weight:800; color:#3b82f6; font-family:monospace;">{{ $antrianDipanggil }}</span>
                    </div>

                    {{-- Selesai --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#f0fdfa; border:1px solid #a7f3d0; border-radius:8px;">
                        <span style="font-size:.875rem; font-weight:600; color:#0f766e;">✅ Selesai</span>
                        <span style="font-size:1.4rem; font-weight:800; color:#0d9488; font-family:monospace;">{{ $antrianSelesai }}</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Akses cepat --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Akses Cepat</span>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:10px;">
                <a href="{{ route('queues.create') }}" class="btn btn-primary" style="justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Ambil Antrian Baru
                </a>
                <a href="{{ route('queues.index') }}" class="btn btn-ghost" style="justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 15h16v-2H4v2zm0 4h16v-2H4v2zm0-8h16V9H4v2zm0-6v2h16V5H4z"/></svg>
                    Monitor Antrian
                </a>
                <a href="{{ route('queues.display') }}" target="_blank" class="btn btn-ghost" style="justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/></svg>
                    Buka Display Antrian
                </a>
                <a href="{{ route('patients.create') }}" class="btn btn-ghost" style="justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    Tambah Pasien Baru
                </a>
            </div>
        </div>

    </div>

    {{-- Info Akun --}}
    <div class="card" style="max-width:480px;">
        <div class="card-header">
            <span class="card-title">Informasi Akun</span>
            <span class="badge badge-role">{{ ucfirst(Auth::user()->role) }}</span>
        </div>
        <div class="card-body">
            <table style="width:100%; font-size:.875rem; border-collapse:collapse;">
                <tr>
                    <td style="padding:8px 0; color:var(--text-muted); width:120px; border-bottom:1px solid var(--border);">Nama</td>
                    <td style="padding:8px 0; font-weight:600; border-bottom:1px solid var(--border);">{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:var(--text-muted); border-bottom:1px solid var(--border);">Email</td>
                    <td style="padding:8px 0; border-bottom:1px solid var(--border);">{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:var(--text-muted);">Status</td>
                    <td style="padding:8px 0; color:var(--primary); font-weight:600;">● Aktif</td>
                </tr>
            </table>
        </div>
    </div>

@endsection
