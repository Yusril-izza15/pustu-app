@extends('layouts.compro')
{{-- Path: resources/views/compro/kontak.blade.php --}}

@section('title', 'Kontak — SIPUSTU')
@section('meta-desc', 'Hubungi Puskesmas Pembantu SIPUSTU. Alamat, telepon, dan email tersedia di sini.')

@section('extra-head')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        padding: 72px 0 56px; color: white; text-align: center;
    }
    .page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; margin-bottom: 12px; }
    .page-hero p  { font-size: 1.05rem; opacity: .85; max-width: 560px; margin: 0 auto; }

    .kontak-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 40px; align-items: start;
    }

    .kontak-info-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: var(--shadow);
    }

    .kontak-info-header {
        background: var(--primary); color: white;
        padding: 24px 28px;
    }

    .kontak-info-header h3 { font-size: 1.15rem; font-weight: 800; margin-bottom: 4px; }
    .kontak-info-header p  { font-size: .85rem; opacity: .8; }

    .kontak-info-body { padding: 24px 28px; }

    .kontak-item {
        display: flex; align-items: flex-start; gap: 16px;
        padding: 16px 0; border-bottom: 1px solid var(--border);
    }

    .kontak-item:last-child { border-bottom: none; }

    .kontak-icon {
        width: 44px; height: 44px;
        background: var(--primary-lt); border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .kontak-icon svg { width: 22px; height: 22px; fill: var(--primary); }

    .kontak-detail { flex: 1; min-width: 0; }
    .kontak-label { font-size: .75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 4px; }
    .kontak-value { font-size: .9rem; font-weight: 600; color: var(--text); line-height: 1.6; }
    .kontak-value a { color: var(--primary); }
    .kontak-value a:hover { text-decoration: underline; }

    /* Jam operasional di kontak */
    .jam-mini { display: flex; flex-direction: column; gap: 4px; }
    .jam-mini-row { display: flex; justify-content: space-between; font-size: .85rem; }
    .jam-mini-hari { color: var(--text-soft); }
    .jam-mini-waktu { font-weight: 700; color: var(--primary); font-family: monospace; font-size: .82rem; }

    /* Map */
    .map-wrap {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: var(--shadow);
    }

    .map-header { padding: 20px 24px; border-bottom: 1px solid var(--border); }
    .map-header h3 { font-size: 1rem; font-weight: 700; color: var(--text); }
    .map-header p  { font-size: .82rem; color: var(--text-muted); margin-top: 2px; }

    .map-container { position: relative; }

    .map-container iframe {
        width: 100%; height: 300px;
        border: none; display: block;
    }

    .map-container .map-overlay {
        position: absolute; bottom: 12px; right: 12px;
        background: white; border: 1px solid var(--border);
        border-radius: 8px; padding: 8px 14px;
        font-size: .78rem; color: var(--text-soft); font-weight: 600;
        box-shadow: var(--shadow);
    }

    @media (max-width: 768px) {
        .kontak-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="section-tag" style="display:inline-flex; margin-bottom:16px; background:rgba(255,255,255,.15); border-color:rgba(255,255,255,.25); color:white;">
                Hubungi Kami
            </div>
            <h1>Kontak & Lokasi</h1>
            <p>Kami siap membantu Anda. Temukan kami melalui informasi kontak di bawah ini.</p>
        </div>
    </div>

    <section class="section section-white">
        <div class="container">

            <div class="kontak-grid">

                {{-- Informasi Kontak --}}
                <div class="aos">
                    <div class="kontak-info-card">
                        <div class="kontak-info-header">
                            <h3>Informasi Kontak</h3>
                            <p>Hubungi kami melalui saluran berikut</p>
                        </div>
                        <div class="kontak-info-body">

                            <div class="kontak-item">
                                <div class="kontak-icon">
                                    <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                </div>
                                <div class="kontak-detail">
                                    <div class="kontak-label">Alamat</div>
                                    <div class="kontak-value">
                                        Jl. Kesehatan No. 1, Kelurahan Sehat,<br>
                                        Kecamatan Sejahtera, Kota Maju 12345
                                    </div>
                                </div>
                            </div>

                            <div class="kontak-item">
                                <div class="kontak-icon">
                                    <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                                </div>
                                <div class="kontak-detail">
                                    <div class="kontak-label">Telepon</div>
                                    <div class="kontak-value">
                                        <a href="tel:+6221000000">(021) 000-0000</a>
                                    </div>
                                </div>
                            </div>

                            <div class="kontak-item">
                                <div class="kontak-icon">
                                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                </div>
                                <div class="kontak-detail">
                                    <div class="kontak-label">Email</div>
                                    <div class="kontak-value">
                                        <a href="mailto:info@sipustu.id">info@sipustu.id</a>
                                    </div>
                                </div>
                            </div>

                            <div class="kontak-item">
                                <div class="kontak-icon">
                                    <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                                </div>
                                <div class="kontak-detail">
                                    <div class="kontak-label">Jam Pelayanan</div>
                                    <div class="kontak-value">
                                        <div class="jam-mini">
                                            <div class="jam-mini-row">
                                                <span class="jam-mini-hari">Senin — Jumat</span>
                                                <span class="jam-mini-waktu">07:30 – 14:00</span>
                                            </div>
                                            <div class="jam-mini-row">
                                                <span class="jam-mini-hari">Sabtu</span>
                                                <span class="jam-mini-waktu">07:30 – 12:00</span>
                                            </div>
                                            <div class="jam-mini-row">
                                                <span class="jam-mini-hari">Minggu & Libur</span>
                                                <span style="color:var(--text-muted); font-size:.82rem;">Tutup</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Peta --}}
                <div class="aos" style="transition-delay:.1s;">
                    <div class="map-wrap">
                        <div class="map-header">
                            <h3>Lokasi Puskesmas</h3>
                            <p>Temukan kami di peta — klik untuk membuka di Google Maps</p>
                        </div>
                        <div class="map-container">
                            {{--
                                iframe Google Maps tanpa API Key.
                                Ganti src dengan URL embed lokasi yang sesuai:
                                Buka maps.google.com → cari lokasi → Bagikan → Sematkan peta → salin src iframe
                            --}}
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.47230959478!2d106.7213626!3d-6.2146870!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                width="100%"
                                height="300"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Lokasi Puskesmas Pembantu SIPUSTU"
                            ></iframe>
                            <div class="map-overlay">📍 SIPUSTU</div>
                        </div>
                    </div>

                    {{-- Cara menuju --}}
                    <div style="
                        background:white; border:1px solid var(--border);
                        border-radius:var(--radius); padding:24px; margin-top:20px;
                        box-shadow:var(--shadow);
                    ">
                        <h3 style="font-size:1rem; font-weight:700; margin-bottom:14px; color:var(--text);">
                            🚗 Cara Menuju Lokasi
                        </h3>
                        <ul style="list-style:none; display:flex; flex-direction:column; gap:8px;">
                            <li style="display:flex;align-items:flex-start;gap:10px;font-size:.875rem;color:var(--text-soft);">
                                <span style="background:var(--primary);color:white;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">🚌</span>
                                Dari terminal bus: naik angkot ke Jl. Kesehatan ± 5 menit
                            </li>
                            <li style="display:flex;align-items:flex-start;gap:10px;font-size:.875rem;color:var(--text-soft);">
                                <span style="background:var(--primary);color:white;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">🏍</span>
                                Ojek online tersedia hingga depan puskesmas
                            </li>
                            <li style="display:flex;align-items:flex-start;gap:10px;font-size:.875rem;color:var(--text-soft);">
                                <span style="background:var(--primary);color:white;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">🅿</span>
                                Parkir kendaraan tersedia di depan gedung
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
