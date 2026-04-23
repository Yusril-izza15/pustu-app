@extends('layouts.compro')
{{-- Path: resources/views/compro/index.blade.php --}}

@section('title', 'Beranda — SIPUSTU')
@section('meta-desc', 'Puskesmas Pembantu — Layanan kesehatan primer terpercaya untuk masyarakat.')

@section('extra-head')
<style>
    /* ===== HERO ===== */
    .hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 70% 60% at 80% 50%, rgba(255,255,255,.06) 0%, transparent 60%),
            url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .hero-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .hero-left { color: white; }

    .hero-tag {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 30px; padding: 6px 16px;
        font-size: .78rem; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase;
        color: rgba(255,255,255,.9);
        margin-bottom: 20px;
    }

    .hero-title {
        font-size: clamp(2rem, 4.5vw, 3.2rem);
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 18px;
        color: white;
    }

    .hero-title span { color: #a7f3d0; }

    .hero-desc {
        font-size: 1.05rem;
        color: rgba(255,255,255,.8);
        line-height: 1.75;
        margin-bottom: 32px;
        max-width: 480px;
    }

    .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; }

    .btn-hero-primary {
        background: white;
        color: var(--primary);
        border-color: white;
        padding: 13px 28px;
        font-size: 1rem;
        border-radius: 10px;
        font-weight: 700;
        transition: all .2s;
    }
    .btn-hero-primary:hover { background: #f0fdfa; }

    .btn-hero-outline {
        background: rgba(255,255,255,.12);
        color: white;
        border: 1.5px solid rgba(255,255,255,.4);
        padding: 13px 28px;
        font-size: 1rem;
        border-radius: 10px;
        font-weight: 700;
        transition: all .2s;
    }
    .btn-hero-outline:hover { background: rgba(255,255,255,.22); }

    .hero-stats {
        display: flex; gap: 32px; margin-top: 40px;
        padding-top: 28px;
        border-top: 1px solid rgba(255,255,255,.15);
    }

    .hero-stat-val {
        font-size: 1.8rem; font-weight: 900; color: white; line-height: 1;
    }
    .hero-stat-lbl { font-size: .78rem; color: rgba(255,255,255,.65); margin-top: 4px; }

    /* Ilustrasi kanan */
    .hero-right {
        display: flex; align-items: center; justify-content: center;
    }

    .hero-illus {
        width: 100%; max-width: 420px;
        aspect-ratio: 1;
        background: rgba(255,255,255,.08);
        border: 2px solid rgba(255,255,255,.12);
        border-radius: 28px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 20px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .hero-illus::before {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 50%);
    }

    .illus-icon {
        width: 80px; height: 80px;
        background: rgba(255,255,255,.15);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        position: relative; z-index: 1;
    }

    .illus-icon svg { width: 40px; height: 40px; fill: white; }

    .illus-text {
        text-align: center; position: relative; z-index: 1;
    }

    .illus-text strong { font-size: 1.5rem; font-weight: 900; color: white; display: block; }
    .illus-text span   { font-size: .85rem; color: rgba(255,255,255,.7); }

    .illus-chips {
        display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;
        position: relative; z-index: 1;
    }

    .illus-chip {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px; padding: 5px 14px;
        font-size: .78rem; color: white; font-weight: 600;
    }

    /* ===== LAYANAN CARD ===== */
    .service-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 28px 24px;
        box-shadow: var(--shadow);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,.10);
    }

    .service-icon {
        width: 52px; height: 52px;
        background: var(--primary-lt);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 18px;
    }

    .service-icon svg { width: 26px; height: 26px; fill: var(--primary); }

    .service-card h3 {
        font-size: 1.05rem; font-weight: 700;
        color: var(--text); margin-bottom: 10px;
    }

    .service-card p {
        font-size: .875rem; color: var(--text-soft); line-height: 1.7;
    }

    /* ===== JADWAL PREVIEW ===== */
    .schedule-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 20px 22px;
        display: flex; align-items: center; gap: 18px;
        box-shadow: var(--shadow);
        transition: transform .2s, box-shadow .2s;
    }

    .schedule-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .sched-day {
        width: 60px; height: 60px; border-radius: 12px;
        background: var(--primary-lt);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 1px solid var(--primary-mid);
    }

    .sched-day-name { font-size: .7rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: .5px; }
    .sched-day-num  { font-size: 1.4rem; font-weight: 900; color: var(--primary); line-height: 1; }

    .sched-info { flex: 1; min-width: 0; }
    .sched-doctor { font-weight: 700; font-size: .95rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sched-spec   { font-size: .8rem; color: var(--text-muted); margin-top: 2px; }
    .sched-time   { font-size: .82rem; color: var(--primary); font-weight: 600; margin-top: 6px; font-family: monospace; }

    /* ===== CTA SECTION ===== */
    .cta-section {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 20px; padding: 60px 48px;
        text-align: center; color: white; position: relative; overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='20' cy='20' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }

    .cta-section h2 { font-size: 2rem; font-weight: 900; margin-bottom: 12px; position: relative; }
    .cta-section p  { font-size: 1rem; opacity: .8; margin-bottom: 28px; position: relative; }
    .cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; position: relative; }

    @media (max-width: 768px) {
        .hero-inner { grid-template-columns: 1fr; gap: 40px; }
        .hero-right { display: none; }
        .hero { min-height: auto; padding: 80px 0; }
        .hero-stats { gap: 20px; }
        .cta-section { padding: 40px 24px; }
        .cta-section h2 { font-size: 1.5rem; }
    }
</style>
@endsection

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="container">
            <div class="hero-inner">

                <div class="hero-left">
                    <div class="hero-tag">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:12px;height:12px;">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Pelayanan Kesehatan Primer
                    </div>

                    <h1 class="hero-title">
                        Kesehatan Anda<br>
                        Adalah <span>Prioritas</span><br>
                        Kami
                    </h1>

                    <p class="hero-desc">
                        Puskesmas Pembantu hadir memberikan layanan kesehatan yang mudah diakses, terjangkau, dan berkualitas untuk seluruh masyarakat.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('compro.jadwal') }}" class="btn btn-hero-primary">
                            Lihat Jadwal Dokter
                        </a>
                        <a href="{{ route('compro.layanan') }}" class="btn btn-hero-outline">
                            Layanan Kami
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-val">24/7</div>
                            <div class="hero-stat-lbl">Layanan Darurat</div>
                        </div>
                        <div>
                            <div class="hero-stat-val">5+</div>
                            <div class="hero-stat-lbl">Dokter Spesialis</div>
                        </div>
                        <div>
                            <div class="hero-stat-val">100%</div>
                            <div class="hero-stat-lbl">Berpengalaman</div>
                        </div>
                    </div>
                </div>

                <div class="hero-right">
                    <div class="hero-illus">
                        <div class="illus-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                        </div>
                        <div class="illus-text">
                            <strong>SIPUSTU</strong>
                            <span>Sistem Informasi Puskesmas Pembantu</span>
                        </div>
                        <div class="illus-chips">
                            <span class="illus-chip">Antrian Digital</span>
                            <span class="illus-chip">Jadwal Dokter</span>
                            <span class="illus-chip">Real-Time</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== LAYANAN ===== --}}
    <section class="section section-white">
        <div class="container">
            <div class="section-header aos">
                <div class="section-tag">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    Layanan Kami
                </div>
                <h2 class="section-title">Apa yang Kami Sediakan?</h2>
                <p class="section-sub">Berbagai layanan kesehatan primer tersedia untuk memenuhi kebutuhan Anda dan keluarga.</p>
            </div>

            <div class="grid-3">
                <div class="service-card aos" style="transition-delay:.05s;">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                    </div>
                    <h3>Pemeriksaan Umum</h3>
                    <p>Konsultasi dan pemeriksaan kesehatan umum oleh dokter berpengalaman dengan sistem antrian digital yang efisien.</p>
                </div>

                <div class="service-card aos" style="transition-delay:.12s;">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                    </div>
                    <h3>Kesehatan Ibu & Anak</h3>
                    <p>Layanan KIA mencakup pemeriksaan kehamilan, imunisasi bayi, dan pemantauan tumbuh kembang anak.</p>
                </div>

                <div class="service-card aos" style="transition-delay:.20s;">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                    </div>
                    <h3>P3K & Gawat Darurat</h3>
                    <p>Penanganan pertolongan pertama dan kasus darurat dengan tenaga medis terlatih yang siap membantu kapanpun.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:36px;">
                <a href="{{ route('compro.layanan') }}" class="btn btn-outline">
                    Lihat Semua Layanan
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== PREVIEW JADWAL ===== --}}
    <section class="section section-alt">
        <div class="container">
            <div class="section-header aos">
                <div class="section-tag">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                    Jadwal Praktek
                </div>
                <h2 class="section-title">Jadwal Dokter Terkini</h2>
                <p class="section-sub">Cek jadwal dokter dan pastikan Anda datang tepat waktu.</p>
            </div>

            @if ($schedules->isEmpty())
                <div style="text-align:center; padding:48px 20px; color:var(--text-muted);">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:40px;height:40px;opacity:.3;margin:0 auto 12px;">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    <p>Belum ada jadwal tersedia saat ini.</p>
                </div>
            @else
                <div class="grid-3">
                    @foreach ($schedules as $item)
                        <div class="schedule-card aos" style="transition-delay:{{ $loop->index * 0.07 }}s;">
                            <div class="sched-day">
                                <span class="sched-day-name">{{ substr($item->hari, 0, 3) }}</span>
                                <span class="sched-day-num">{{ substr($item->hari, 0, 2) }}</span>
                            </div>
                            <div class="sched-info">
                                <div class="sched-doctor">
                                    {{-- Null-safe: doctor mungkin sudah dihapus --}}
                                    {{ optional($item->doctor)->nama ?? 'Dokter tidak tersedia' }}
                                </div>
                                <div class="sched-spec">
                                    {{ optional($item->doctor)->spesialis ?? '' }}
                                    @if ($item->tanggal)
                                        <span class="badge badge-orange" style="margin-left:4px;">Khusus</span>
                                    @endif
                                </div>
                                <div class="sched-time">
                                    {{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div style="text-align:center; margin-top:36px;">
                <a href="{{ route('compro.jadwal') }}" class="btn btn-primary">
                    Lihat Jadwal Lengkap
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== CTA SECTION ===== --}}
    <section class="section section-white">
        <div class="container">
            <div class="cta-section aos">
                <h2>Ambil Nomor Antrian Digital Sekarang</h2>
                <p>Tidak perlu antri lama — daftarkan kunjungan Anda melalui sistem antrian digital SIPUSTU.</p>
                <div class="cta-actions">
                    <a href="{{ route('compro.jadwal') }}" class="btn btn-hero-primary">
                        Cek Jadwal Dokter
                    </a>
                    <a href="{{ route('queues.display') }}" target="_blank" class="btn btn-hero-outline">
                        Lihat Antrian
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
