<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPUSTU') — Sistem Informasi Puskesmas Pembantu</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:     #0d9488;
            --primary-dk:  #0f766e;
            --primary-lt:  #f0fdfa;
            --primary-mid: #ccfbf1;
            --accent:      #14b8a6;
            --text:        #1e293b;
            --text-soft:   #64748b;
            --text-muted:  #94a3b8;
            --border:      #e2e8f0;
            --bg:          #f8fafc;
            --white:       #ffffff;
            --red:         #ef4444;
            --red-lt:      #fef2f2;
            --yellow:      #f59e0b;
            --blue:        #3b82f6;
            --blue-lt:     #eff6ff;
            --sidebar-w:        240px;
            --sidebar-w-collapsed: 70px;
            --topbar-h:    60px;
            --transition:  all 0.25s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 15px;
            color: var(--text);
            background: var(--bg);
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }

        /* =============================================
           SHELL
           ============================================= */
        .shell { display: flex; min-height: 100vh; }

        /* =============================================
           OVERLAY (mobile)
           ============================================= */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 90;
        }

        .sidebar-overlay.visible { display: block; }

        /* =============================================
           SIDEBAR
           ============================================= */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            overflow: hidden;
            transition: var(--transition);
        }

        /* ---- Collapsed state ---- */
        .sidebar.collapsed {
            width: var(--sidebar-w-collapsed);
        }

        /* ---- Logo ---- */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 17px;
            height: var(--topbar-h);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-icon svg { width: 20px; height: 20px; fill: white; }

        .logo-text { overflow: hidden; }
        .logo-text strong {
            font-size: .95rem;
            color: var(--primary);
            display: block;
            white-space: nowrap;
        }
        .logo-text span { font-size: .7rem; color: var(--text-muted); white-space: nowrap; }

        /* ---- Nav ---- */
        .sidebar-nav {
            flex: 1;
            padding: 10px 8px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-label {
            font-size: .66rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 10px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: var(--transition);
        }

        .sidebar.collapsed .nav-label { opacity: 0; height: 0; padding: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--text-soft);
            font-size: .875rem;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }

        .nav-item:hover { background: var(--primary-lt); color: var(--primary); }
        .nav-item.active { background: var(--primary-lt); color: var(--primary); font-weight: 600; }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: .7;
            transition: var(--transition);
        }

        .nav-item.active svg,
        .nav-item:hover svg { opacity: 1; }

        /* nav-text — disembunyikan saat collapse */
        .nav-text {
            transition: var(--transition);
            overflow: hidden;
        }

        .sidebar.collapsed .nav-text { display: none; }

        /* Tooltip saat collapsed */
        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 11px;
        }

        /* ---- Footer sidebar ---- */
        .sidebar-footer {
            padding: 12px 14px;
            border-top: 1px solid var(--border);
            background: var(--bg);
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
            overflow: hidden;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; overflow: hidden; }
        .user-info .uname {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-info .urole {
            font-size: .7rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .sidebar.collapsed .user-info { display: none; }
        .sidebar.collapsed .btn-logout-text { display: none; }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            margin-top: 8px;
            padding: 7px 10px;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: .8rem;
            color: var(--text-soft);
            transition: var(--transition);
            white-space: nowrap;
            overflow: hidden;
        }

        .btn-logout:hover { background: var(--red-lt); color: var(--red); border-color: #fecaca; }
        .btn-logout svg { width: 14px; height: 14px; flex-shrink: 0; }

        .sidebar.collapsed .btn-logout { justify-content: center; }

        /* =============================================
           MAIN WRAP
           ============================================= */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: var(--transition);
        }

        .main-wrap.collapsed { margin-left: var(--sidebar-w-collapsed); }

        /* =============================================
           TOPBAR
           ============================================= */
        .topbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 16px;
        }

        /* Hamburger tombol toggle */
        .btn-toggle {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-soft);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .btn-toggle:hover { background: var(--primary-lt); color: var(--primary); border-color: var(--accent); }
        .btn-toggle svg { width: 18px; height: 18px; }

        .topbar-titles { flex: 1; }
        .topbar-title { font-size: 1.05rem; font-weight: 700; color: var(--text); }
        .topbar-subtitle { font-size: .78rem; color: var(--text-muted); margin-top: 1px; }

        /* =============================================
           PAGE CONTENT
           ============================================= */
        .page-content { flex: 1; padding: 28px; }

        /* =============================================
           FLASH ALERT
           ============================================= */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: .875rem;
            margin-bottom: 20px;
        }

        .alert-success { background: var(--primary-lt); border: 1px solid var(--primary-mid); color: var(--primary-dk); }
        .alert-error   { background: var(--red-lt);     border: 1px solid #fecaca;            color: #b91c1c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            opacity: .5;
            font-size: 1rem;
            line-height: 1;
            padding: 0 2px;
        }
        .alert-close:hover { opacity: 1; }

        /* =============================================
           CARD
           ============================================= */
        .card { background: var(--white); border: 1px solid var(--border); border-radius: 12px; }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .card-title { font-size: .95rem; font-weight: 700; color: var(--text); }
        .card-body { padding: 20px; }

        /* =============================================
           BUTTONS
           ============================================= */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: .85rem;
            font-weight: 600;
            border: 1px solid transparent;
            transition: var(--transition);
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-primary { background: var(--primary); color: white; border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dk); border-color: var(--primary-dk); }
        .btn-ghost   { background: none; color: var(--text-soft); border-color: var(--border); }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }
        .btn-danger  { background: none; color: var(--red); border-color: #fecaca; }
        .btn-danger:hover { background: var(--red-lt); }
        .btn-warn    { background: #fef9c3; color: #92400e; border-color: #fde68a; }
        .btn-warn:hover { background: #fef08a; }
        .btn-sm { padding: 5px 10px; font-size: .78rem; border-radius: 6px; }
        .btn svg { width: 15px; height: 15px; }

        /* =============================================
           TABLE — upgraded with border + zebra + hover
           ============================================= */
        .table-wrap {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(0,0,0,.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 10px 14px;
            background: #f1f5f9;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-muted);
            border: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 10px 14px;
            border: 1px solid var(--border);
            font-size: .875rem;
            vertical-align: middle;
        }

        /* Zebra stripes */
        tbody tr:nth-child(even) td { background: #f9fafb; }
        tbody tr:nth-child(odd)  td { background: var(--white); }

        /* Hover row */
        tbody tr:hover td { background: #ecfdf5; }

        /* =============================================
           FORM
           ============================================= */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: .9rem;
            font-family: inherit;
            color: var(--text);
            background: var(--white);
            outline: none;
            transition: var(--transition);
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(20,184,166,.12);
        }
        .form-control.is-invalid { border-color: var(--red); }
        textarea.form-control { resize: vertical; }
        select.form-control { cursor: pointer; }
        .invalid-feedback { color: var(--red); font-size: .78rem; margin-top: 4px; }
        .radio-group { display: flex; gap: 20px; }
        .radio-item { display: flex; align-items: center; gap: 6px; font-size: .9rem; cursor: pointer; }
        .radio-item input { accent-color: var(--primary); width: 16px; height: 16px; }
        .error-text { color: var(--red); font-size: .78rem; margin-top: 4px; display: block; }

        /* =============================================
           BADGES
           ============================================= */
        .badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: .73rem; font-weight: 700; letter-spacing: .3px; }
        .badge-rm   { background: var(--blue-lt); color: #1d4ed8; }
        .badge-lk   { background: #dbeafe; color: #1d4ed8; }
        .badge-pr   { background: #fce7f3; color: #9d174d; }
        .badge-role { background: var(--primary-lt); color: var(--primary); }

        /* =============================================
           SEARCH BAR
           ============================================= */
        .search-bar { display: flex; gap: 8px; flex-wrap: wrap; }
        .search-input-wrap { position: relative; flex: 1; max-width: 320px; }
        .search-input-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted); }
        .search-input {
            width: 100%;
            padding: 8px 12px 8px 34px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: .875rem;
            font-family: inherit;
            outline: none;
            transition: var(--transition);
        }
        .search-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(20,184,166,.12); }

        /* =============================================
           PAGINATION
           ============================================= */
        .pagination-wrap {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .8rem;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 10px;
        }
        nav[aria-label="Pagination Navigation"] { display: inline-flex; }
        .pagination { display: flex; gap: 4px; list-style: none; }
        .page-item .page-link {
            display: flex; align-items: center; justify-content: center;
            min-width: 32px; height: 32px; padding: 0 8px;
            border: 1px solid var(--border); border-radius: 6px;
            font-size: .8rem; color: var(--text-soft); background: var(--white); transition: var(--transition);
        }
        .page-item .page-link:hover { background: var(--primary-lt); color: var(--primary); border-color: var(--accent); }
        .page-item.active .page-link { background: var(--primary); color: white; border-color: var(--primary); font-weight: 700; }
        .page-item.disabled .page-link { opacity: .4; pointer-events: none; }

        /* =============================================
           STAT CARDS
           ============================================= */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; }
        .stat-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .stat-icon svg { width: 18px; height: 18px; }
        .stat-icon.teal   { background: var(--primary-lt); color: var(--primary); }
        .stat-icon.blue   { background: var(--blue-lt);    color: var(--blue); }
        .stat-icon.yellow { background: #fffbeb;           color: var(--yellow); }
        .stat-val   { font-size: 1.6rem; font-weight: 700; color: var(--text); line-height: 1; }
        .stat-label { font-size: .75rem; color: var(--text-muted); margin-top: 4px; font-weight: 500; }

        /* =============================================
           EMPTY STATE
           ============================================= */
        .empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }
        .empty-state svg { width: 40px; height: 40px; margin-bottom: 12px; opacity: .4; }
        .empty-state p { font-size: .9rem; margin-bottom: 12px; }

        /* =============================================
           BREADCRUMB
           ============================================= */
        .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: .8rem; color: var(--text-muted); margin-bottom: 16px; flex-wrap: wrap; }
        .breadcrumb a { color: var(--primary); }
        .breadcrumb-sep { color: var(--border); }

        /* =============================================
           MISC
           ============================================= */
        .rm-notice {
            display: flex; align-items: center; gap: 8px;
            background: var(--primary-lt); border: 1px dashed var(--accent);
            border-radius: 8px; padding: 10px 14px;
            font-size: .82rem; color: var(--primary-dk); margin-bottom: 20px;
        }
        .rm-notice svg { width: 15px; height: 15px; flex-shrink: 0; }
        .rm-badge-static {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--primary-lt); border: 1px solid var(--primary-mid);
            border-radius: 8px; padding: 7px 14px;
            font-size: .9rem; font-weight: 700; color: var(--primary); letter-spacing: .5px;
        }
        .form-divider { border: none; border-top: 1px solid var(--border); margin: 24px 0; }

        /* =============================================
           RESPONSIVE — MOBILE
           ============================================= */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                width: var(--sidebar-w) !important;
            }

            .main-wrap,
            .main-wrap.collapsed {
                margin-left: 0 !important;
            }

            .stats-grid { grid-template-columns: 1fr 1fr; }

            .page-content { padding: 16px; }
        }
    </style>
</head>
<body>

{{-- Overlay untuk mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<div class="shell">

    {{-- =============================================
         SIDEBAR
         ============================================= --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm-1 10V9H9V7h2V5h2v2h2v2h-2v3h-2z"/>
                </svg>
            </div>
            <div class="logo-text">
                <strong>SIPUSTU</strong>
                <span>Puskesmas Pembantu</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>

            {{-- Dashboard --}}
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        <span class="nav-text">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('staff.dashboard') }}"
                       class="nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        <span class="nav-text">Dashboard</span>
                    </a>
                @endif
            @endauth

            {{-- Data Pasien --}}
            <a href="{{ route('patients.index') }}"
               class="nav-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
                <span class="nav-text">Data Pasien</span>
            </a>

            {{-- Data Dokter --}}
            <a href="{{ route('doctors.index') }}"
               class="nav-item {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
                <span class="nav-text">Data Dokter</span>
            </a>

            {{-- Jadwal Dokter --}}
            <a href="{{ route('schedules.index') }}"
               class="nav-item {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                <span class="nav-text">Jadwal Dokter</span>
            </a>

            {{-- Antrian --}}
            <a href="{{ route('queues.index') }}"
               class="nav-item {{ request()->routeIs('queues.index') || request()->routeIs('queues.create') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 15h16v-2H4v2zm0 4h16v-2H4v2zm0-8h16V9H4v2zm0-6v2h16V5H4z"/>
                </svg>
                <span class="nav-text">Antrian</span>
            </a>

            {{-- Display Antrian --}}
            <a href="{{ route('queues.display') }}"
               target="_blank"
               class="nav-item {{ request()->routeIs('queues.display') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/>
                </svg>
                <span class="nav-text">Display Antrian</span>
            </a>

        </nav>

        {{-- User info + Logout --}}
        @auth
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="uname">{{ Auth::user()->name }}</div>
                    <div class="urole">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    <span class="btn-logout-text">Keluar</span>
                </button>
            </form>
        </div>
        @endauth

    </aside>

    {{-- =============================================
         MAIN WRAP
         ============================================= --}}
    <div class="main-wrap" id="main-wrap">

        {{-- Topbar --}}
        <header class="topbar">

            {{-- Hamburger toggle --}}
            <button class="btn-toggle" id="btn-toggle" type="button" aria-label="Toggle sidebar">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                </svg>
            </button>

            <div class="topbar-titles">
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-subtitle">@yield('page-subtitle', 'Sistem Informasi Puskesmas Pembantu')</div>
            </div>

        </header>

        {{-- Page content --}}
        <main class="page-content">

            {{-- Flash sukses --}}
            @if (session('success'))
                <div class="alert alert-success" id="flash-alert">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.remove()" type="button">✕</button>
                </div>
            @endif

            {{-- Flash error --}}
            @if (session('error'))
                <div class="alert alert-error" id="flash-alert">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.remove()" type="button">✕</button>
                </div>
            @endif

            @yield('content')

        </main>

    </div>{{-- /main-wrap --}}

</div>{{-- /shell --}}

<script>
(function () {
    'use strict';

    var LS_KEY    = 'sidebar_state';
    var sidebar   = document.getElementById('sidebar');
    var mainWrap  = document.getElementById('main-wrap');
    var btnToggle = document.getElementById('btn-toggle');
    var overlay   = document.getElementById('sidebar-overlay');

    // Jika elemen tidak ditemukan, berhenti — tidak error
    if (!sidebar || !mainWrap || !btnToggle) return;

    /* ------------------------------------------------
       Cek apakah layar mobile
    ------------------------------------------------ */
    function isMobile() {
        return window.innerWidth <= 768;
    }

    /* ------------------------------------------------
       Apply state berdasarkan kondisi saat ini
    ------------------------------------------------ */
    function applyState(state) {
        if (isMobile()) {
            // Mobile: abaikan localStorage, pakai sistem overlay
            sidebar.classList.remove('collapsed', 'mobile-open');
            mainWrap.classList.remove('collapsed');
            if (overlay) overlay.classList.remove('visible');
            return;
        }

        if (state === 'collapsed') {
            sidebar.classList.add('collapsed');
            mainWrap.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            mainWrap.classList.remove('collapsed');
        }
    }

    /* ------------------------------------------------
       Toggle sidebar
    ------------------------------------------------ */
    function toggleSidebar() {
        if (isMobile()) {
            // Mobile: toggle overlay & mobile-open
            var isOpen = sidebar.classList.contains('mobile-open');
            if (isOpen) {
                sidebar.classList.remove('mobile-open');
                if (overlay) overlay.classList.remove('visible');
            } else {
                sidebar.classList.add('mobile-open');
                if (overlay) overlay.classList.add('visible');
            }
            return;
        }

        // Desktop: toggle collapsed
        var isCollapsed = sidebar.classList.contains('collapsed');
        var newState = isCollapsed ? 'expand' : 'collapsed';

        applyState(newState);

        try {
            localStorage.setItem(LS_KEY, newState);
        } catch (e) {
            // localStorage tidak tersedia — lanjut tanpa simpan
        }
    }

    /* ------------------------------------------------
       Load state dari localStorage saat halaman dibuka
    ------------------------------------------------ */
    function loadState() {
        var saved;
        try {
            saved = localStorage.getItem(LS_KEY);
        } catch (e) {
            saved = null;
        }

        // Default: expand
        applyState(saved === 'collapsed' ? 'collapsed' : 'expand');
    }

    /* ------------------------------------------------
       Event listeners
    ------------------------------------------------ */
    btnToggle.addEventListener('click', toggleSidebar);

    // Klik overlay (mobile) → tutup sidebar
    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('visible');
        });
    }

    // Resize: re-apply state agar tidak salah posisi
    window.addEventListener('resize', function () {
        loadState();
    });

    /* ------------------------------------------------
       Init saat halaman load
    ------------------------------------------------ */
    loadState();

    /* ------------------------------------------------
       Auto-dismiss flash alert setelah 4 detik
    ------------------------------------------------ */
    var flash = document.getElementById('flash-alert');
    if (flash) {
        setTimeout(function () {
            flash.style.transition = 'opacity .5s';
            flash.style.opacity    = '0';
            setTimeout(function () {
                if (flash && flash.parentNode) flash.parentNode.removeChild(flash);
            }, 500);
        }, 4000);
    }

})();
</script>

</body>
</html>
