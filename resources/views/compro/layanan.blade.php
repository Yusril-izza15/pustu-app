@extends('layouts.compro')
{{-- Path: resources/views/compro/layanan.blade.php --}}

@section('title', 'Layanan — SIPUSTU')
@section('meta-desc', 'Lihat seluruh layanan kesehatan yang tersedia di Puskesmas Pembantu SIPUSTU.')

@section('extra-head')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        padding: 72px 0 56px; color: white; text-align: center;
    }
    .page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; margin-bottom: 12px; }
    .page-hero p  { font-size: 1.05rem; opacity: .85; max-width: 560px; margin: 0 auto; }

    .service-big-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 32px 28px;
        box-shadow: var(--shadow);
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex; gap: 22px; align-items: flex-start;
    }

    .service-big-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }

    .service-big-icon {
        width: 60px; height: 60px; border-radius: 16px;
        background: var(--primary-lt); display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .service-big-icon svg { width: 30px; height: 30px; fill: var(--primary); }

    .service-big-body h3 { font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
    .service-big-body p  { font-size: .875rem; color: var(--text-soft); line-height: 1.75; margin-bottom: 12px; }

    .service-tags { display: flex; gap: 6px; flex-wrap: wrap; }
    .service-tag-item {
        background: var(--primary-lt); color: var(--primary);
        border: 1px solid var(--primary-mid);
        border-radius: 20px; padding: 3px 10px;
        font-size: .72rem; font-weight: 700;
    }

    .jam-operasional {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 32px;
        box-shadow: var(--shadow);
    }

    .jam-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 12px 0; border-bottom: 1px solid var(--border);
        font-size: .9rem;
    }

    .jam-row:last-child { border-bottom: none; }
    .jam-hari { font-weight: 600; color: var(--text); }
    .jam-waktu { color: var(--primary); font-weight: 700; font-family: monospace; }
    .jam-libur { color: var(--text-muted); }

    @media (max-width: 640px) {
        .service-big-card { flex-direction: column; }
    }
</style>
@endsection

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="section-tag" style="display:inline-flex; margin-bottom:16px; background:rgba(255,255,255,.15); border-color:rgba(255,255,255,.25); color:white;">
                Layanan Kami
            </div>
            <h1>Layanan Kesehatan Lengkap</h1>
            <p>Kami menyediakan berbagai layanan kesehatan primer yang komprehensif untuk memenuhi kebutuhan Anda.</p>
        </div>
    </div>

    <section class="section section-white">
        <div class="container">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:40px;">

                <div class="service-big-card aos" style="transition-delay:.04s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>Pemeriksaan Umum</h3>
                        <p>Konsultasi dan pemeriksaan kesehatan oleh dokter umum. Meliputi anamnesis, pemeriksaan fisik, diagnosis, dan resep obat bila diperlukan.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">Konsultasi</span>
                            <span class="service-tag-item">Diagnosa</span>
                            <span class="service-tag-item">Resep</span>
                        </div>
                    </div>
                </div>

                <div class="service-big-card aos" style="transition-delay:.09s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>Kesehatan Ibu & Anak (KIA)</h3>
                        <p>Pelayanan antenatal care, pemeriksaan bayi baru lahir, imunisasi dasar lengkap, dan pemantauan tumbuh kembang anak.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">ANC</span>
                            <span class="service-tag-item">Imunisasi</span>
                            <span class="service-tag-item">Tumbang</span>
                        </div>
                    </div>
                </div>

                <div class="service-big-card aos" style="transition-delay:.14s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>P3K & Gawat Darurat</h3>
                        <p>Penanganan pertolongan pertama untuk cedera ringan, luka, dan kasus darurat medis yang memerlukan penanganan segera.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">Darurat</span>
                            <span class="service-tag-item">Luka</span>
                            <span class="service-tag-item">Stabilisasi</span>
                        </div>
                    </div>
                </div>

                <div class="service-big-card aos" style="transition-delay:.19s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>Konseling Gizi</h3>
                        <p>Edukasi dan konseling nutrisi untuk balita, ibu hamil, lansia, dan pasien dengan penyakit kronis seperti diabetes dan hipertensi.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">Nutrisi</span>
                            <span class="service-tag-item">Diet</span>
                            <span class="service-tag-item">Edukasi</span>
                        </div>
                    </div>
                </div>

                <div class="service-big-card aos" style="transition-delay:.24s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>Promosi Kesehatan</h3>
                        <p>Kegiatan penyuluhan kesehatan kepada masyarakat, posyandu, dan program preventif untuk meningkatkan kesadaran hidup sehat.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">Penyuluhan</span>
                            <span class="service-tag-item">Posyandu</span>
                            <span class="service-tag-item">Preventif</span>
                        </div>
                    </div>
                </div>

                <div class="service-big-card aos" style="transition-delay:.29s;">
                    <div class="service-big-icon">
                        <svg viewBox="0 0 24 24"><path d="M4 15h16v-2H4v2zm0 4h16v-2H4v2zm0-8h16V9H4v2zm0-6v2h16V5H4z"/></svg>
                    </div>
                    <div class="service-big-body">
                        <h3>Antrian Digital</h3>
                        <p>Sistem antrian berbasis teknologi yang memungkinkan pasien mengambil nomor antrian dan memantau status panggilan secara real-time.</p>
                        <div class="service-tags">
                            <span class="service-tag-item">Digital</span>
                            <span class="service-tag-item">Real-Time</span>
                            <span class="service-tag-item">Efisien</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Jam operasional --}}
            <div class="section-header aos" style="margin-top:60px; margin-bottom:32px;">
                <div class="section-tag">Operasional</div>
                <h2 class="section-title">Jam Pelayanan</h2>
            </div>

            <div style="max-width:600px; margin:0 auto;" class="aos">
                <div class="jam-operasional">
                    <div class="jam-row">
                        <span class="jam-hari">Senin — Jumat</span>
                        <span class="jam-waktu">07:30 — 14:00</span>
                    </div>
                    <div class="jam-row">
                        <span class="jam-hari">Sabtu</span>
                        <span class="jam-waktu">07:30 — 12:00</span>
                    </div>
                    <div class="jam-row">
                        <span class="jam-hari">Minggu</span>
                        <span class="jam-libur">Tutup</span>
                    </div>
                    <div class="jam-row">
                        <span class="jam-hari">Hari Libur Nasional</span>
                        <span class="jam-libur">Tutup (Darurat: hubungi IGD)</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
