<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPUSTU') — Puskesmas Pembantu</title>
    <meta name="description" content="@yield('meta-desc', 'Puskesmas Pembantu — Melayani kesehatan masyarakat dengan sepenuh hati.')">
    {{-- Path: resources/views/layouts/compro.blade.php --}}
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #0d9488;
            --primary-dark: #0f766e;
            --primary-lt:   #f0fdfa;
            --primary-mid:  #ccfbf1;
            --accent:       #14b8a6;
            --bg:           #f8fafc;
            --white:        #ffffff;
            --text:         #1e293b;
            --text-soft:    #64748b;
            --text-muted:   #94a3b8;
            --border:       #e2e8f0;
            --red:          #ef4444;
            --blue:         #3b82f6;
            --yellow:       #f59e0b;
            --container:    1200px;
            --nav-h:        68px;
            --radius:       12px;
            --shadow:       0 2px 16px rgba(0,0,0,.07);
            --shadow-md:    0 8px 32px rgba(0,0,0,.10);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', sans-serif;
            font-size: 16px;
            line-height: 1.65;
            color: var(--text);
            background: var(--bg);
        }

        img { max-width: 100%; display: block; }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }

        /* =============================================
           CONTAINER
           ============================================= */
        .container {
            width: 100%;
            max-width: var(--container);
            margin: 0 auto;
            padding: 0 24px;
        }

        /* =============================================
           NAVBAR
           ============================================= */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 200;
            height: var(--nav-h);
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: background .3s ease, border-color .3s ease, box-shadow .3s ease;
        }

        /* Kelas ditambahkan via JS saat scroll > 40px */
        .navbar.scrolled {
            background: rgba(255,255,255,.97);
            border-bottom-color: var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            backdrop-filter: blur(8px);
        }

        .nav-inner {
            height: var(--nav-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .nav-logo {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logo svg { width: 22px; height: 22px; fill: white; }

        .nav-brand-text strong {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
            line-height: 1.1;
        }

        .nav-brand-text span {
            font-size: .68rem;
            color: var(--text-muted);
        }

        /* Menu desktop */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
        }

        .nav-menu a {
            display: block;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 500;
            color: var(--text-soft);
            transition: background .2s, color .2s;
            white-space: nowrap;
        }

        .nav-menu a:hover { background: var(--primary-lt); color: var(--primary); }
        .nav-menu a.active { background: var(--primary-lt); color: var(--primary); font-weight: 700; }

        /* CTA di navbar */
        .nav-cta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 9px;
            font-size: .875rem;
            font-weight: 600;
            border: 1.5px solid transparent;
            transition: all .2s;
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-primary { background: var(--primary); color: white; border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline { background: transparent; color: var(--primary); border-color: var(--primary); }
        .btn-outline:hover { background: var(--primary-lt); }
        .btn-lg { padding: 13px 28px; font-size: 1rem; border-radius: 10px; }
        .btn-sm { padding: 7px 14px; font-size: .82rem; }
        .btn svg { width: 16px; height: 16px; }

        /* Hamburger mobile */
        .nav-hamburger {
            display: none;
            width: 40px; height: 40px;
            align-items: center; justify-content: center;
            background: none;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            color: var(--text-soft);
            transition: all .2s;
        }

        .nav-hamburger:hover { background: var(--primary-lt); color: var(--primary); border-color: var(--accent); }
        .nav-hamburger svg { width: 20px; height: 20px; }

        /* Mobile dropdown */
        .nav-mobile {
            display: none;
            position: absolute;
            top: var(--nav-h);
            left: 0; right: 0;
            background: white;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            padding: 12px 24px 16px;
            flex-direction: column;
            gap: 2px;
        }

        .nav-mobile.open { display: flex; }

        .nav-mobile a {
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 500;
            color: var(--text-soft);
            transition: background .2s, color .2s;
        }

        .nav-mobile a:hover { background: var(--primary-lt); color: var(--primary); }
        .nav-mobile a.active { background: var(--primary-lt); color: var(--primary); font-weight: 700; }

        .nav-mobile-cta {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border);
        }

        .nav-mobile-cta .btn { flex: 1; justify-content: center; }

        /* =============================================
           MAIN
           ============================================= */
        main { min-height: calc(100vh - var(--nav-h) - 240px); }

        /* =============================================
           SECTION HELPERS
           ============================================= */
        .section { padding: 80px 0; }
        .section-sm { padding: 56px 0; }
        .section-alt { background: var(--bg); }
        .section-white { background: var(--white); }

        .section-header { text-align: center; margin-bottom: 52px; }
        .section-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--primary-lt); color: var(--primary);
            border: 1px solid var(--primary-mid);
            border-radius: 30px; padding: 5px 16px;
            font-size: .78rem; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            margin-bottom: 14px;
        }
        .section-tag svg { width: 13px; height: 13px; }

        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 800;
            color: var(--text);
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .section-sub {
            font-size: 1rem;
            color: var(--text-soft);
            max-width: 560px;
            margin: 0 auto;
        }

        /* =============================================
           CARD
           ============================================= */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* =============================================
           GRID HELPERS
           ============================================= */
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .grid-auto { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }

        /* =============================================
           TABLE
           ============================================= */
        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 12px 16px;
            background: #f1f5f9;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--text-muted);
            border: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 12px 16px;
            border: 1px solid var(--border);
            font-size: .9rem;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) td { background: #f9fafb; }
        tbody tr:nth-child(odd)  td { background: var(--white); }
        tbody tr:hover td { background: #ecfdf5; }

        /* =============================================
           BADGE
           ============================================= */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
        }

        .badge-green  { background: var(--primary-lt); color: var(--primary); border: 1px solid var(--primary-mid); }
        .badge-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-yellow { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-orange { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

        /* =============================================
           ANIMATE ON SCROLL
           ============================================= */
        .aos {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .aos.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* =============================================
           FOOTER
           ============================================= */
        .footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 56px 0 32px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand { margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
        .footer-logo {
            width: 38px; height: 38px; background: var(--primary);
            border-radius: 9px; display: flex; align-items: center; justify-content: center;
        }
        .footer-logo svg { width: 20px; height: 20px; fill: white; }
        .footer-brand-name { font-size: 1.05rem; font-weight: 800; color: white; }
        .footer-desc { font-size: .875rem; color: #94a3b8; line-height: 1.7; }

        .footer-col-title {
            font-size: .8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: #e2e8f0; margin-bottom: 16px;
        }

        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-links a {
            font-size: .875rem; color: #94a3b8;
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--accent); }

        .footer-bottom {
            border-top: 1px solid #1e293b;
            padding-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .82rem;
            color: #475569;
            flex-wrap: wrap;
            gap: 8px;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */
        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-menu, .nav-cta { display: none; }
            .nav-hamburger { display: flex; }

            .section { padding: 56px 0; }
            .section-sm { padding: 40px 0; }

            .grid-3, .grid-2 { grid-template-columns: 1fr; }
            .grid-auto { grid-template-columns: 1fr; }

            .footer-grid { grid-template-columns: 1fr 1fr; }
            .footer-bottom { flex-direction: column; text-align: center; }

            .section-title { font-size: 1.5rem; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 16px; }
            .footer-grid { grid-template-columns: 1fr; }
            .section { padding: 40px 0; }
        }
    </style>
    @yield('extra-head')
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-inner">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm-1 10V9H9V7h2V5h2v2h2v2h-2v3h-2z"/>
                    </svg>
                </div>
                <div class="nav-brand-text">
                    <strong>SIPUSTU</strong>
                    <span>Puskesmas Pembantu</span>
                </div>
            </a>

            {{-- Menu desktop --}}
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}"            class="{{ request()->routeIs('home')           ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('compro.tentang') }}"  class="{{ request()->routeIs('compro.tentang') ? 'active' : '' }}">Tentang</a></li>
                <li><a href="{{ route('compro.layanan') }}"  class="{{ request()->routeIs('compro.layanan') ? 'active' : '' }}">Layanan</a></li>
                <li><a href="{{ route('compro.jadwal') }}"   class="{{ request()->routeIs('compro.jadwal')  ? 'active' : '' }}">Jadwal</a></li>
                <li><a href="{{ route('compro.kontak') }}"   class="{{ request()->routeIs('compro.kontak')  ? 'active' : '' }}">Kontak</a></li>
            </ul>

            {{-- CTA desktop --}}
            <div class="nav-cta">
                <a href="{{ route('queues.display') }}" target="_blank" class="btn btn-outline btn-sm">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/></svg>
                    Antrian
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk</a>
                @endauth
            </div>

            {{-- Hamburger mobile --}}
            <button class="nav-hamburger" id="nav-hamburger" type="button" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="currentColor" id="hamburger-icon">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- Mobile dropdown --}}
    <div class="nav-mobile" id="nav-mobile">
        <a href="{{ route('home') }}"           class="{{ request()->routeIs('home')           ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('compro.tentang') }}" class="{{ request()->routeIs('compro.tentang') ? 'active' : '' }}">Tentang</a>
        <a href="{{ route('compro.layanan') }}" class="{{ request()->routeIs('compro.layanan') ? 'active' : '' }}">Layanan</a>
        <a href="{{ route('compro.jadwal') }}"  class="{{ request()->routeIs('compro.jadwal')  ? 'active' : '' }}">Jadwal</a>
        <a href="{{ route('compro.kontak') }}"  class="{{ request()->routeIs('compro.kontak')  ? 'active' : '' }}">Kontak</a>
        <div class="nav-mobile-cta">
            <a href="{{ route('queues.display') }}" target="_blank" class="btn btn-outline btn-sm">Antrian</a>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ===== MAIN ===== --}}
<main>
    @yield('content')
</main>

{{-- ===== FOOTER ===== --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Brand & deskripsi --}}
            <div>
                <div class="footer-brand">
                    <div class="footer-logo">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm-1 10V9H9V7h2V5h2v2h2v2h-2v3h-2z"/>
                        </svg>
                    </div>
                    <span class="footer-brand-name">SIPUSTU</span>
                </div>
                <p class="footer-desc">
                    Puskesmas Pembantu hadir untuk memberikan pelayanan kesehatan primer yang mudah diakses oleh seluruh masyarakat. Melayani dengan sepenuh hati.
                </p>
            </div>

            {{-- Navigasi --}}
            <div>
                <div class="footer-col-title">Navigasi</div>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('compro.tentang') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('compro.layanan') }}">Layanan</a></li>
                    <li><a href="{{ route('compro.jadwal') }}">Jadwal Dokter</a></li>
                    <li><a href="{{ route('compro.kontak') }}">Kontak</a></li>
                </ul>
            </div>

            {{-- Layanan --}}
            <div>
                <div class="footer-col-title">Layanan</div>
                <ul class="footer-links">
                    <li><a href="#">Pemeriksaan Umum</a></li>
                    <li><a href="#">Kesehatan Ibu & Anak</a></li>
                    <li><a href="#">Imunisasi</a></li>
                    <li><a href="#">Konseling Gizi</a></li>
                    <li><a href="#">P3K & Darurat</a></li>
                </ul>
            </div>

            {{-- Kontak cepat --}}
            <div>
                <div class="footer-col-title">Kontak</div>
                <ul class="footer-links">
                    <li style="display:flex;gap:8px;align-items:flex-start;">
                        <svg viewBox="0 0 24 24" fill="#94a3b8" style="width:14px;height:14px;flex-shrink:0;margin-top:3px;">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span style="font-size:.875rem;color:#94a3b8;">Jl. Kesehatan No. 1, Kelurahan Sehat, Kota Sejahtera</span>
                    </li>
                    <li style="display:flex;gap:8px;align-items:center;">
                        <svg viewBox="0 0 24 24" fill="#94a3b8" style="width:14px;height:14px;flex-shrink:0;">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        <a href="tel:+6221000000" style="font-size:.875rem;color:#94a3b8;">(021) 000-0000</a>
                    </li>
                    <li style="display:flex;gap:8px;align-items:center;">
                        <svg viewBox="0 0 24 24" fill="#94a3b8" style="width:14px;height:14px;flex-shrink:0;">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <a href="mailto:info@sipustu.id" style="font-size:.875rem;color:#94a3b8;">info@sipustu.id</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} SIPUSTU — Puskesmas Pembantu. Hak Cipta Dilindungi.</span>
            <span>Dibangun dengan ❤ untuk kesehatan masyarakat</span>
        </div>
    </div>
</footer>

<script>
(function () {
    'use strict';

    /* ---- Navbar scroll effect ---- */
    var navbar = document.getElementById('navbar');
    if (navbar) {
        function onScroll() {
            if (window.scrollY > 40) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll(); // init
    }

    /* ---- Mobile hamburger ---- */
    var hamburger = document.getElementById('nav-hamburger');
    var navMobile = document.getElementById('nav-mobile');

    if (hamburger && navMobile) {
        hamburger.addEventListener('click', function () {
            navMobile.classList.toggle('open');
        });

        // Tutup saat klik di luar
        document.addEventListener('click', function (e) {
            if (!navbar.contains(e.target)) {
                navMobile.classList.remove('open');
            }
        });
    }

    /* ---- Animate On Scroll (IntersectionObserver) ---- */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.aos').forEach(function (el) {
            observer.observe(el);
        });
    } else {
        // Fallback: langsung tampilkan semua
        document.querySelectorAll('.aos').forEach(function (el) {
            el.classList.add('visible');
        });
    }

})();
</script>

@yield('extra-script')
</body>
</html>
