@extends('layouts.compro')
{{-- Path: resources/views/compro/tentang.blade.php --}}

@section('title', 'Tentang Kami — SIPUSTU')
@section('meta-desc', 'Kenali lebih jauh tentang Puskesmas Pembantu SIPUSTU, visi misi, dan tim kami.')

@section('extra-head')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        padding: 72px 0 56px;
        color: white; text-align: center;
    }
    .page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; margin-bottom: 12px; }
    .page-hero p  { font-size: 1.05rem; opacity: .85; max-width: 560px; margin: 0 auto; }

    .value-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 28px 24px;
        box-shadow: var(--shadow); text-align: center;
    }
    .value-icon {
        width: 56px; height: 56px; background: var(--primary-lt);
        border-radius: 16px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .value-icon svg { width: 28px; height: 28px; fill: var(--primary); }
    .value-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
    .value-card p  { font-size: .875rem; color: var(--text-soft); line-height: 1.7; }

    .profile-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 48px; align-items: center;
    }

    .profile-img {
        background: linear-gradient(135deg, var(--primary-lt), var(--primary-mid));
        border-radius: 20px; height: 360px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 16px; border: 1px solid var(--primary-mid);
    }

    .profile-img svg { width: 64px; height: 64px; fill: var(--primary); opacity: .6; }
    .profile-img span { font-size: .85rem; color: var(--primary); font-weight: 600; }

    .vm-box {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 24px;
        box-shadow: var(--shadow); margin-bottom: 16px;
    }

    .vm-box h3 {
        display: flex; align-items: center; gap: 10px;
        font-size: 1rem; font-weight: 700; color: var(--primary);
        margin-bottom: 12px;
    }

    .vm-box h3 svg { width: 18px; height: 18px; fill: var(--primary); }

    .vm-box p { font-size: .9rem; color: var(--text-soft); line-height: 1.75; }

    .vm-list { list-style: none; display: flex; flex-direction: column; gap: 8px; margin-top: 10px; }
    .vm-list li {
        display: flex; align-items: flex-start; gap: 10px;
        font-size: .9rem; color: var(--text-soft);
    }
    .vm-list li::before {
        content: '';
        width: 6px; height: 6px; background: var(--primary);
        border-radius: 50%; flex-shrink: 0; margin-top: 8px;
    }

    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
        .profile-img { height: 220px; }
    }
</style>
@endsection

@section('content')

    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="container">
            <div class="section-tag" style="display:inline-flex; margin-bottom:16px; background:rgba(255,255,255,.15); border-color:rgba(255,255,255,.25); color:white;">
                Tentang Kami
            </div>
            <h1>Mengenal SIPUSTU</h1>
            <p>Puskesmas Pembantu yang berdedikasi melayani kesehatan masyarakat dengan teknologi modern dan tenaga medis berpengalaman.</p>
        </div>
    </div>

    {{-- Profil --}}
    <section class="section section-white">
        <div class="container">
            <div class="profile-grid">
                <div class="profile-img aos">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm-1 10V9H9V7h2V5h2v2h2v2h-2v3h-2z"/>
                    </svg>
                    <span>Puskesmas Pembantu SIPUSTU</span>
                </div>
                <div class="aos" style="transition-delay:.1s;">
                    <div class="section-tag" style="margin-bottom:16px;">Profil Singkat</div>
                    <h2 class="section-title" style="text-align:left;">Melayani dengan<br>Sepenuh Hati</h2>
                    <p style="color:var(--text-soft); line-height:1.8; margin-bottom:20px;">
                        SIPUSTU — Sistem Informasi Puskesmas Pembantu hadir sebagai solusi kesehatan primer yang modern. Kami menggabungkan layanan medis berkualitas dengan teknologi informasi untuk memberikan pengalaman berobat yang lebih nyaman dan efisien.
                    </p>
                    <p style="color:var(--text-soft); line-height:1.8;">
                        Didukung oleh tim dokter berpengalaman, perawat terlatih, dan staf administratif yang ramah, kami berkomitmen untuk menjadi mitra kesehatan terpercaya bagi seluruh lapisan masyarakat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="section section-alt">
        <div class="container">
            <div class="section-header aos">
                <div class="section-tag">Landasan Kami</div>
                <h2 class="section-title">Visi & Misi</h2>
            </div>

            <div class="grid-2">
                <div class="aos" style="transition-delay:.05s;">
                    <div class="vm-box">
                        <h3>
                            <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            Visi
                        </h3>
                        <p>Menjadi pusat pelayanan kesehatan primer yang modern, terpercaya, dan mudah diakses oleh seluruh masyarakat menuju derajat kesehatan yang setinggi-tingginya.</p>
                    </div>
                    <div class="vm-box">
                        <h3>
                            <svg viewBox="0 0 24 24"><path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z"/></svg>
                            Nilai Utama
                        </h3>
                        <ul class="vm-list">
                            <li>Integritas dalam setiap pelayanan</li>
                            <li>Profesionalisme tenaga medis</li>
                            <li>Ketulusan dan empati kepada pasien</li>
                            <li>Inovasi teknologi untuk kemudahan akses</li>
                        </ul>
                    </div>
                </div>

                <div class="aos" style="transition-delay:.15s;">
                    <div class="vm-box" style="height:100%;">
                        <h3>
                            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                            Misi
                        </h3>
                        <ul class="vm-list">
                            <li>Memberikan pelayanan kesehatan primer yang berkualitas, merata, dan terjangkau.</li>
                            <li>Mengembangkan sistem informasi kesehatan yang terintegrasi dan efisien.</li>
                            <li>Meningkatkan kapasitas sumber daya manusia di bidang kesehatan secara berkelanjutan.</li>
                            <li>Mendorong peran aktif masyarakat dalam upaya promotif dan preventif kesehatan.</li>
                            <li>Membangun kemitraan strategis dengan berbagai pemangku kepentingan di bidang kesehatan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Nilai kami --}}
    <section class="section section-white">
        <div class="container">
            <div class="section-header aos">
                <div class="section-tag">Keunggulan</div>
                <h2 class="section-title">Mengapa Memilih Kami?</h2>
            </div>

            <div class="grid-3">
                <div class="value-card aos" style="transition-delay:.05s;">
                    <div class="value-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <h3>Tenaga Medis Terlatih</h3>
                    <p>Dokter dan tenaga kesehatan kami berpengalaman dan mengikuti standar kompetensi terkini.</p>
                </div>

                <div class="value-card aos" style="transition-delay:.12s;">
                    <div class="value-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 19H5V8h14v12z"/></svg>
                    </div>
                    <h3>Antrian Digital</h3>
                    <p>Sistem antrian berbasis teknologi yang transparan — tidak ada antre panjang, tidak ada kebingungan.</p>
                </div>

                <div class="value-card aos" style="transition-delay:.20s;">
                    <div class="value-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                    </div>
                    <h3>Aman & Terpercaya</h3>
                    <p>Data pasien dijaga dengan ketat dan seluruh prosedur mengikuti standar keselamatan yang berlaku.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
