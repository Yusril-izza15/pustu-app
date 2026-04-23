@extends('layouts.compro')
{{-- Path: resources/views/compro/jadwal.blade.php --}}

@section('title', 'Jadwal Dokter — SIPUSTU')
@section('meta-desc', 'Jadwal lengkap praktek dokter di Puskesmas Pembantu SIPUSTU.')

@section('extra-head')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        padding: 72px 0 56px; color: white; text-align: center;
    }
    .page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 900; margin-bottom: 12px; }
    .page-hero p  { font-size: 1.05rem; opacity: .85; max-width: 560px; margin: 0 auto; }

    .hari-filter {
        display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 28px;
    }

    .hari-btn {
        padding: 7px 16px; border-radius: 30px;
        border: 1.5px solid var(--border); background: white;
        font-size: .82rem; font-weight: 600; color: var(--text-soft);
        cursor: pointer; transition: all .2s;
    }
    .hari-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-lt); }
    .hari-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

    .info-box {
        display: flex; align-items: flex-start; gap: 12px;
        background: var(--primary-lt); border: 1px solid var(--primary-mid);
        border-radius: 10px; padding: 14px 18px;
        font-size: .875rem; color: var(--primary-dark);
        margin-bottom: 24px;
    }
    .info-box svg { width: 18px; height: 18px; fill: var(--primary); flex-shrink: 0; margin-top: 1px; }

    .time-badge {
        display: inline-flex; align-items: center;
        background: var(--primary-lt); color: var(--primary);
        border: 1px solid var(--primary-mid);
        border-radius: 6px; padding: 3px 10px;
        font-size: .82rem; font-weight: 700; font-family: monospace;
    }
</style>
@endsection

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="section-tag" style="display:inline-flex; margin-bottom:16px; background:rgba(255,255,255,.15); border-color:rgba(255,255,255,.25); color:white;">
                Jadwal Dokter
            </div>
            <h1>Jadwal Praktek Dokter</h1>
            <p>Pastikan Anda datang sesuai jadwal untuk mendapatkan pelayanan terbaik.</p>
        </div>
    </div>

    <section class="section section-white">
        <div class="container">

            <div class="info-box aos">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                <div>
                    <strong>Informasi Jadwal:</strong> Jadwal dapat berubah sewaktu-waktu. Jadwal khusus (tanggal tertentu) memiliki prioritas di atas jadwal rutin. Silakan hubungi kami untuk konfirmasi.
                </div>
            </div>

            {{-- Filter hari --}}
            <div class="hari-filter aos">
                <button class="hari-btn active" data-filter="semua" type="button">Semua Hari</button>
                <button class="hari-btn" data-filter="Senin"   type="button">Senin</button>
                <button class="hari-btn" data-filter="Selasa"  type="button">Selasa</button>
                <button class="hari-btn" data-filter="Rabu"    type="button">Rabu</button>
                <button class="hari-btn" data-filter="Kamis"   type="button">Kamis</button>
                <button class="hari-btn" data-filter="Jumat"   type="button">Jumat</button>
                <button class="hari-btn" data-filter="Sabtu"   type="button">Sabtu</button>
                <button class="hari-btn" data-filter="Minggu"  type="button">Minggu</button>
            </div>

            @if ($schedules->isEmpty())
                <div style="text-align:center; padding:64px 20px; color:var(--text-muted);">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:48px;height:48px;opacity:.25;margin:0 auto 16px;">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    <p style="font-size:1.1rem; font-weight:600; margin-bottom:8px;">Belum ada jadwal dokter</p>
                    <p style="font-size:.875rem;">Jadwal akan ditampilkan di sini setelah administrator menginput data.</p>
                </div>
            @else
                <div class="table-wrap aos">
                    <table id="jadwal-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Dokter</th>
                                <th>Spesialis</th>
                                <th>Hari</th>
                                <th>Tanggal Khusus</th>
                                <th>Jam Praktek</th>
                                <th style="text-align:center;">Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $item)
                                <tr data-hari="{{ $item->hari }}">
                                    <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                                    <td style="font-weight:700;">
                                        {{-- Null-safe: doctor mungkin sudah dihapus dari database --}}
                                        {{ optional($item->doctor)->nama ?? '-' }}
                                    </td>
                                    <td style="color:var(--text-soft);">
                                        {{ optional($item->doctor)->spesialis ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-green">{{ $item->hari }}</span>
                                    </td>
                                    <td style="font-size:.85rem; color:var(--text-soft);">
                                        @if ($item->tanggal)
                                            {{ $item->tanggal->format('d M Y') }}
                                        @else
                                            <span style="color:var(--text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="time-badge">
                                            {{ substr($item->jam_mulai, 0, 5) }}
                                            –
                                            {{ substr($item->jam_selesai, 0, 5) }}
                                        </span>
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($item->tanggal)
                                            <span class="badge badge-orange">⭐ Khusus</span>
                                        @else
                                            <span class="badge badge-blue">🔄 Rutin</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </section>

@endsection

@section('extra-script')
<script>
(function () {
    // Filter tabel jadwal berdasarkan hari yang dipilih
    var filterBtns = document.querySelectorAll('.hari-btn');
    var tableRows  = document.querySelectorAll('#jadwal-table tbody tr');

    if (!filterBtns.length || !tableRows.length) return;

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-filter');

            // Update active button
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            // Filter rows
            tableRows.forEach(function (row) {
                if (filter === 'semua' || row.getAttribute('data-hari') === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
})();
</script>
@endsection
