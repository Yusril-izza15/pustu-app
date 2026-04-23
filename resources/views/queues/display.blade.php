<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--
        Path   : resources/views/queues/display.blade.php
        Status : GANTI — tulis ulang full file ini
        Akses  : Publik — tanpa login
        URL    : http://127.0.0.1:8000/antrian/display
        TIDAK ADA meta refresh — update via JavaScript polling setiap 3 detik
    --}}
    <title>Display Antrian — SIPUSTU</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:       #00ff88;
            --green-dim:   #00cc66;
            --green-glow:  rgba(0,255,136,.30);
            --green-faint: rgba(0,255,136,.07);
            --blue:        #38bdf8;
            --yellow:      #fbbf24;
            --bg:          #000000;
            --bg-panel:    #080f18;
            --bg-card:     #0d1a28;
            --border:      rgba(255,255,255,.07);
            --text:        #f1f5f9;
            --text-soft:   #94a3b8;
            --text-muted:  #334155;
        }

        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            user-select: none;
        }

        /* =============================================
           LAYOUT
           ============================================= */
        .screen {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-rows: 72px 1fr 52px;
        }

        /* =============================================
           HEADER
           ============================================= */
        .header {
            background: #060d16;
            border-bottom: 1px solid var(--border);
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #0d9488, #0f766e);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .brand-icon svg { width: 22px; height: 22px; fill: white; }

        .brand-name { font-size: 1.15rem; font-weight: 700; color: #14b8a6; letter-spacing: 1px; }
        .brand-sub  { font-size: .72rem; color: var(--text-soft); margin-top: 2px; }

        .header-right { text-align: right; }

        .clock {
            font-family: 'Orbitron', monospace;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--green);
            letter-spacing: 3px;
            line-height: 1;
            text-shadow: 0 0 16px var(--green-glow);
        }

        .date-str { font-size: .75rem; color: var(--text-soft); margin-top: 3px; }

        /* =============================================
           BODY — kiri + kanan
           ============================================= */
        .body {
            display: grid;
            grid-template-columns: 1fr 300px;
            overflow: hidden;
        }

        /* =============================================
           PANEL KIRI
           ============================================= */
        .panel-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 48px;
            position: relative;
            overflow: hidden;
        }

        .panel-main::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                0deg, transparent, transparent 2px,
                rgba(0,255,136,.010) 2px, rgba(0,255,136,.010) 4px
            );
            pointer-events: none;
        }

        .panel-main::after {
            content: '';
            position: absolute;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,255,136,.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Loading state */
        .state-loading {
            position: relative; z-index: 1;
            text-align: center;
        }

        .loading-spinner {
            width: 48px; height: 48px;
            border: 3px solid rgba(0,255,136,.15);
            border-top-color: var(--green);
            border-radius: 50%;
            animation: spin .8s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: .85rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Empty state */
        .state-empty {
            position: relative; z-index: 1;
            text-align: center;
            display: none;
        }

        .empty-ring {
            width: 260px; height: 260px;
            border-radius: 50%;
            border: 2px solid rgba(71,85,105,.2);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
        }

        .empty-dash {
            font-family: 'Orbitron', monospace;
            font-size: 3rem;
            color: var(--text-muted);
            opacity: .4;
        }

        .empty-title { font-size: 1.6rem; font-weight: 700; color: var(--text-muted); }
        .empty-sub   { font-size: .9rem; color: var(--text-muted); margin-top: 8px; }

        /* Active state — antrian dipanggil */
        .state-active {
            position: relative; z-index: 1;
            text-align: center;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .status-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0,255,136,.10);
            border: 1px solid rgba(0,255,136,.28);
            border-radius: 30px;
            padding: 6px 22px;
            font-size: .78rem; font-weight: 700;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--green);
            margin-bottom: 22px;
        }

        .blink-dot {
            width: 8px; height: 8px;
            background: var(--green); border-radius: 50%;
            animation: dotBlink 1s ease-in-out infinite;
        }

        @keyframes dotBlink { 0%,100%{opacity:1;} 50%{opacity:.15;} }

        .section-label {
            font-size: .8rem; font-weight: 700;
            letter-spacing: 5px; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 18px;
        }

        /* Nomor besar */
        .nomor-wrap { position: relative; display: flex; align-items: center; justify-content: center; margin-bottom: 28px; }

        .nomor-ring {
            position: absolute;
            width: 320px; height: 320px; border-radius: 50%;
            border: 2px solid var(--green-glow);
            animation: ringPulse 2.5s ease-in-out infinite;
        }

        .nomor-ring-outer {
            width: 380px; height: 380px;
            border-color: rgba(0,255,136,.12);
            animation-delay: .5s;
        }

        @keyframes ringPulse { 0%,100%{transform:scale(1);opacity:.7;} 50%{transform:scale(1.04);opacity:1;} }

        .nomor-box {
            position: relative;
            width: 280px; height: 280px;
            background: var(--bg-card); border-radius: 50%;
            border: 3px solid rgba(0,255,136,.28);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 60px rgba(0,255,136,.12), inset 0 0 40px rgba(0,255,136,.04);
        }

        /* ID untuk update via JS */
        #nomor-text {
            font-family: 'Orbitron', monospace;
            font-size: clamp(80px, 14vw, 140px);
            font-weight: 900;
            line-height: 1;
            color: var(--green);
            letter-spacing: -3px;
            text-shadow: 0 0 30px var(--green-glow), 0 0 60px rgba(0,255,136,.15);
        }

        /* Animasi pop saat nomor baru */
        #nomor-text.pop {
            animation: nomorPop .5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes nomorPop { 0%{transform:scale(1);opacity:.5;} 45%{transform:scale(1.18);opacity:1;} 100%{transform:scale(1);opacity:1;} }

        /* Info pasien & dokter */
        #patient-name {
            font-size: clamp(1.2rem, 2.2vw, 1.8rem);
            font-weight: 700; color: var(--text);
            margin-bottom: 12px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 80vw;
        }

        .doctor-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(56,189,248,.10);
            border: 1px solid rgba(56,189,248,.22);
            border-radius: 30px; padding: 8px 22px;
            font-size: clamp(.85rem, 1.1vw, 1rem);
            color: var(--blue); font-weight: 600;
        }

        .doctor-chip svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* =============================================
           PANEL KANAN
           ============================================= */
        .panel-side {
            background: var(--bg-panel);
            border-left: 1px solid var(--border);
            display: flex; flex-direction: column; overflow: hidden;
        }

        .side-block {
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .side-title {
            font-size: .65rem; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 14px;
        }

        .stat-row { display: flex; flex-direction: column; gap: 8px; }

        .stat-item {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--bg-card);
            border: 1px solid var(--border); border-radius: 10px;
            padding: 12px 16px;
        }

        .stat-item-label { font-size: .78rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
        .stat-item-value { font-family: 'Orbitron', monospace; font-size: 1.6rem; font-weight: 700; line-height: 1; }

        .stat-item.menunggu  .stat-item-label { color: rgba(251,191,36,.7); }
        .stat-item.menunggu  .stat-item-value { color: var(--yellow); text-shadow: 0 0 12px rgba(251,191,36,.3); }
        .stat-item.dipanggil .stat-item-label { color: rgba(56,189,248,.7); }
        .stat-item.dipanggil .stat-item-value { color: var(--blue); text-shadow: 0 0 12px rgba(56,189,248,.3); }
        .stat-item.selesai   .stat-item-label { color: rgba(0,255,136,.6); }
        .stat-item.selesai   .stat-item-value { color: var(--green); text-shadow: 0 0 12px var(--green-glow); }

        .total-block {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 4px;
        }

        .total-num {
            font-family: 'Orbitron', monospace;
            font-size: 2.8rem; font-weight: 700;
            color: #e2e8f0; line-height: 1;
        }

        .total-lbl {
            font-size: .65rem; letter-spacing: 2px;
            text-transform: uppercase; color: var(--text-muted); margin-top: 4px;
        }

        /* Koneksi status badge */
        .conn-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 0; font-size: .72rem;
        }

        .conn-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--green);
            animation: dotBlink 2s ease-in-out infinite;
        }

        .conn-dot.error { background: #f87171; animation: none; }
        .conn-text { color: var(--text-muted); }

        /* =============================================
           FOOTER
           ============================================= */
        .footer {
            background: #020609;
            border-top: 1px solid var(--border);
            padding: 0 48px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: .7rem; color: var(--text-muted);
        }

        .refresh-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.03);
            border: 1px solid var(--border); border-radius: 20px; padding: 4px 12px;
        }

        .refresh-dot {
            width: 5px; height: 5px; background: var(--green); border-radius: 50%;
            animation: dotBlink 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body>

{{--
    Data awal dari server untuk initial render.
    JavaScript akan mengambil alih dan polling setiap 3 detik.
--}}
@php
    $initNomor   = $currentQueue?->formatted_nomor ?? '';
    $initPasien  = $currentQueue !== null ? (optional($currentQueue->patient)->nama ?? '') : '';
    $initDokter  = $currentQueue !== null ? (optional($currentQueue->doctor)->nama ?? '') : '';
    $totalSemua  = $totalMenunggu + $totalDipanggil + $totalSelesai;
@endphp

<div class="screen">

    {{-- HEADER --}}
    <div class="header">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm-1 10V9H9V7h2V5h2v2h2v2h-2v3h-2z"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">SIPUSTU</div>
                <div class="brand-sub">Sistem Informasi Puskesmas Pembantu — Display Antrian Real-Time</div>
            </div>
        </div>
        <div class="header-right">
            <div class="clock" id="js-clock">{{ $now->format('H:i:s') }}</div>
            <div class="date-str">{{ $now->isoFormat('dddd, D MMMM Y') }} WIB</div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="body">

        {{-- PANEL KIRI --}}
        <div class="panel-main">

            {{-- State: Loading (tampil pertama kali sebelum JS jalan) --}}
            <div class="state-loading" id="state-loading">
                <div class="loading-spinner"></div>
                <div class="loading-text">Memuat data antrian...</div>
            </div>

            {{-- State: Tidak ada panggilan --}}
            <div class="state-empty" id="state-empty">
                <div class="empty-ring"><div class="empty-dash">—</div></div>
                <div class="empty-title">Belum Ada Panggilan</div>
                <div class="empty-sub">Sistem memperbarui data setiap 3 detik</div>
            </div>

            {{-- State: Ada antrian dipanggil --}}
            <div class="state-active" id="state-active">
                <div class="status-badge">
                    <span class="blink-dot"></span>
                    Silakan Masuk
                </div>
                <div class="section-label">Nomor Antrian</div>
                <div class="nomor-wrap">
                    <div class="nomor-ring nomor-ring-outer"></div>
                    <div class="nomor-ring"></div>
                    <div class="nomor-box">
                        <div id="nomor-text">{{ $initNomor ?: '—' }}</div>
                    </div>
                </div>
                <div id="patient-name">{{ $initPasien }}</div>
                <div class="doctor-chip">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10.5 13H8v-3h2.5V7.5h3V10H16v3h-2.5v2.5h-3V13zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                    <span id="doctor-name">{{ $initDokter }}</span>
                </div>
            </div>

        </div>

        {{-- PANEL KANAN --}}
        <div class="panel-side">

            {{-- Statistik --}}
            <div class="side-block">
                <div class="side-title">Statistik Hari Ini</div>
                <div class="stat-row">
                    <div class="stat-item menunggu">
                        <span class="stat-item-label">Menunggu</span>
                        <span class="stat-item-value" id="stat-menunggu">{{ $totalMenunggu }}</span>
                    </div>
                    <div class="stat-item dipanggil">
                        <span class="stat-item-label">Dipanggil</span>
                        <span class="stat-item-value" id="stat-dipanggil">{{ $totalDipanggil }}</span>
                    </div>
                    <div class="stat-item selesai">
                        <span class="stat-item-label">Selesai</span>
                        <span class="stat-item-value" id="stat-selesai">{{ $totalSelesai }}</span>
                    </div>
                </div>
            </div>

            {{-- Status koneksi --}}
            <div class="side-block">
                <div class="side-title">Status Sistem</div>
                <div class="conn-badge" id="conn-badge">
                    <span class="conn-dot" id="conn-dot"></span>
                    <span class="conn-text" id="conn-text">Menghubungkan...</span>
                </div>
            </div>

            {{-- Total --}}
            <div class="total-block">
                <div class="total-num" id="stat-total">{{ $totalSemua }}</div>
                <div class="total-lbl">Total Antrian Hari Ini</div>
            </div>

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <span>SIPUSTU — Puskesmas Pembantu &nbsp;|&nbsp; {{ $now->format('d/m/Y') }}</span>
        <div class="refresh-pill">
            <span class="refresh-dot"></span>
            Memperbarui real-time setiap 3 detik
        </div>
    </div>

</div>

<script>
(function () {
    'use strict';

    /* =============================================
       KONSTANTA & STATE
       ============================================= */
    var API_URL   = window.location.origin + '/api/antrian/current';
    var LS_KEY    = 'sipustu_last_called';
    var INTERVAL  = 3000; // ms

    // Guard anti double-speak
    var isSpeaking = false;

    // Apakah sudah ada interaksi user (untuk autoplay policy browser)
    var userInteracted = false;
    document.addEventListener('click', function () { userInteracted = true; }, { once: true });
    document.addEventListener('keydown', function () { userInteracted = true; }, { once: true });

    /* =============================================
       ELEMEN DOM
       ============================================= */
    var elLoading     = document.getElementById('state-loading');
    var elEmpty       = document.getElementById('state-empty');
    var elActive      = document.getElementById('state-active');
    var elNomor       = document.getElementById('nomor-text');
    var elPasien      = document.getElementById('patient-name');
    var elDokter      = document.getElementById('doctor-name');
    var elConnDot     = document.getElementById('conn-dot');
    var elConnText    = document.getElementById('conn-text');
    var elStatMenunggu  = document.getElementById('stat-menunggu');
    var elStatDipanggil = document.getElementById('stat-dipanggil');
    var elStatSelesai   = document.getElementById('stat-selesai');
    var elStatTotal     = document.getElementById('stat-total');
    var elClock         = document.getElementById('js-clock');

    /* =============================================
       JAM DIGITAL
       ============================================= */
    (function startClock() {
        function tick() {
            if (!elClock) return;
            var n  = new Date();
            var hh = String(n.getHours()).padStart(2,'0');
            var mm = String(n.getMinutes()).padStart(2,'0');
            var ss = String(n.getSeconds()).padStart(2,'0');
            elClock.textContent = hh + ':' + mm + ':' + ss;
        }
        tick();
        setInterval(tick, 1000);
    })();

    /* =============================================
       HELPER — tampilkan state
       ============================================= */
    function showState(name) {
        if (elLoading) elLoading.style.display = name === 'loading' ? 'block' : 'none';
        if (elEmpty)   elEmpty.style.display   = name === 'empty'   ? 'block' : 'none';
        if (elActive) {
            elActive.style.display = name === 'active' ? 'flex' : 'none';
        }
    }

    /* =============================================
       HELPER — update koneksi badge
       ============================================= */
    function setConn(ok) {
        if (!elConnDot || !elConnText) return;
        if (ok) {
            elConnDot.className  = 'conn-dot';
            elConnText.textContent = 'Terhubung — live';
        } else {
            elConnDot.className  = 'conn-dot error';
            elConnText.textContent = 'Koneksi terputus, mencoba ulang...';
        }
    }

    /* =============================================
       HELPER — animasi pop pada nomor
       ============================================= */
    function triggerPop() {
        if (!elNomor) return;
        elNomor.classList.remove('pop');
        void elNomor.offsetWidth; // force reflow
        elNomor.classList.add('pop');
        setTimeout(function () { elNomor.classList.remove('pop'); }, 600);
    }

    /* =============================================
       TEXT TO SPEECH
       ============================================= */
    function speak(nomor, dokter) {
        // Cek ketersediaan API
        if (!('speechSynthesis' in window)) {
            console.log('Speech not supported on this browser.');
            return;
        }

        // Validasi input
        if (!nomor || nomor === '' || nomor === '-' || nomor === null) {
            return;
        }

        // Guard anti double
        if (isSpeaking) {
            return;
        }

        var dokterText = (dokter && dokter !== '')
            ? dokter
            : 'dokter yang bertugas';

        var teks = 'Nomor ' + nomor + ' silakan masuk ke dokter ' + dokterText;

        function doSpeak(voices) {
            isSpeaking = true;

            // Cancel suara yang mungkin masih berjalan
            window.speechSynthesis.cancel();

            // Delay kecil agar cancel selesai sebelum speak baru
            setTimeout(function () {
                var utt = new SpeechSynthesisUtterance(teks);
                utt.lang   = 'id-ID';
                utt.rate   = 0.9;
                utt.pitch  = 1.0;
                utt.volume = 1.0;

                // Cari voice Indonesia
                var voiceId = null;
                if (voices && voices.length > 0) {
                    voiceId = voices.find(function (v) { return v.lang === 'id-ID'; });
                    if (!voiceId) {
                        voiceId = voices.find(function (v) {
                            return v.lang.toLowerCase().indexOf('id') === 0;
                        });
                    }
                }
                if (voiceId) utt.voice = voiceId;

                utt.onend = function ()   { isSpeaking = false; };
                utt.onerror = function (e) {
                    isSpeaking = false;
                    console.log('Speech error:', e.error);
                };

                window.speechSynthesis.speak(utt);
            }, 200);
        }

        var voices = window.speechSynthesis.getVoices();
        if (voices && voices.length > 0) {
            doSpeak(voices);
        } else {
            window.speechSynthesis.onvoiceschanged = function () {
                var v = window.speechSynthesis.getVoices();
                doSpeak(v);
                window.speechSynthesis.onvoiceschanged = null;
            };
        }
    }

    /* =============================================
       FETCH DATA dari API
       ============================================= */
    async function fetchData() {
        try {
            var res = await fetch(API_URL, {
                method: 'GET',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-store',
            });

            if (!res.ok) {
                setConn(false);
                return;
            }

            // Parse JSON — jika gagal parse, data = null, tidak crash
            var data = await res.json().catch(function () { return null; });
            if (!data) {
                setConn(false);
                return;
            }

            setConn(true);
            processData(data);

        } catch (e) {
            // Network error atau server mati — tampilkan error conn, jangan crash
            console.log('Fetch error:', e);
            setConn(false);
        }
    }

    /* =============================================
       PROSES DATA — deteksi perubahan, update UI
       ============================================= */
    function processData(data) {

        // Update statistik jika tersedia di response
        // (API current() tidak return stats, tapi siap jika ditambahkan)
        // Stats di-update oleh server-side initial render + ini hanya update nomor

        var nomor  = data?.nomor  ?? null;
        var dokter = data?.dokter ?? null;
        var pasien = data?.pasien ?? null;

        // ---- Jika tidak ada antrian dipanggil ----
        if (!nomor) {
            showState('empty');
            return;
        }

        // ---- Ada antrian — update UI ----
        showState('active');

        if (elNomor)  elNomor.textContent  = nomor;
        if (elPasien) elPasien.textContent = pasien || '';
        if (elDokter) elDokter.textContent = dokter || 'Dokter';

        // ---- Deteksi perubahan via localStorage ----
        var lastNomor = null;
        try {
            lastNomor = localStorage.getItem(LS_KEY);
        } catch (e) {
            // localStorage tidak tersedia — lanjut
        }

        if (lastNomor === null) {
            // First load — simpan nomor, JANGAN bunyi
            // (tidak tahu apakah ini perubahan atau load ulang biasa)
            try { localStorage.setItem(LS_KEY, nomor); } catch (e) {}
            return;
        }

        if (lastNomor !== nomor) {
            // Nomor BARU — animasi + suara + simpan
            try { localStorage.setItem(LS_KEY, nomor); } catch (e) {}
            triggerPop();

            // Suara hanya jalan setelah interaksi user ATAU force karena ada nomor baru
            // Browser modern memblokir autoplay — kita tetap coba, error ditangkap di onerror
            speak(nomor, dokter);
        }
        // Nomor sama → tidak lakukan apapun
    }

    /* =============================================
       INIT — jalankan segera lalu polling
       ============================================= */

    // Tampilkan loading saat pertama kali
    showState('loading');

    // Fetch pertama langsung
    fetchData();

    // Polling setiap 3 detik
    setInterval(fetchData, INTERVAL);

})();
</script>

</body>
</html>
