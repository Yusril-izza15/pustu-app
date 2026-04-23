@extends('layouts.app')
{{--
    Path   : resources/views/queues/create.blade.php
    Status : FILE BARU
--}}

@section('title', 'Ambil Antrian')
@section('page-title', 'Ambil Nomor Antrian')
@section('page-subtitle', 'Daftarkan pasien ke antrian dokter hari ini')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('queues.index') }}">Antrian</a>
        <span class="breadcrumb-sep">›</span>
        <span>Ambil Antrian</span>
    </div>

    <div style="max-width:600px;">

        {{-- Info waktu sekarang --}}
        <div style="
            display:flex; align-items:center; gap:10px;
            background:#f0fdfa; border:1px solid #ccfbf1;
            border-radius:10px; padding:12px 16px;
            font-size:.85rem; color:#0f766e;
            margin-bottom:20px;
        ">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;flex-shrink:0;">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>
            </svg>
            <span>
                Waktu saat ini:
                <strong>{{ $now->isoFormat('dddd, D MMMM Y') }}</strong>
                — <strong>{{ $now->format('H:i') }} WIB</strong>
            </span>
        </div>

        <div class="card">

            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"
                         style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                    Form Pengambilan Antrian
                </span>
            </div>

            <div class="card-body">

                {{-- Error validasi --}}
                @if ($errors->any())
                    <div style="
                        background:#fef2f2; border:1px solid #fecaca;
                        border-radius:10px; padding:14px 16px;
                        margin-bottom:20px; font-size:.875rem;
                    ">
                        <div style="font-weight:700; color:#b91c1c; margin-bottom:6px;">
                            ⚠️ Terdapat kesalahan:
                        </div>
                        <ul style="color:#b91c1c; padding-left:18px; line-height:1.8;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('queues.store') }}">
                    @csrf

                    {{-- Pilih Pasien --}}
                    <div class="form-group">
                        <label class="form-label" for="patient_id">
                            Pasien <span style="color:var(--red)">*</span>
                        </label>
                        <select
                            id="patient_id"
                            name="patient_id"
                            class="form-control {{ $errors->has('patient_id') ? 'is-invalid' : '' }}"
                        >
                            <option value="">— Pilih Pasien —</option>
                            @foreach ($patients as $patient)
                                <option
                                    value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                >
                                    {{ $patient->no_rekam_medis }} — {{ $patient->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Dokter --}}
                    <div class="form-group">
                        <label class="form-label" for="doctor_id">
                            Dokter <span style="color:var(--red)">*</span>
                        </label>

                        @if ($doctors->isEmpty())
                            <div style="
                                background:#fef9c3; border:1px solid #fde68a;
                                border-radius:8px; padding:12px 16px;
                                font-size:.875rem; color:#92400e;
                            ">
                                ⚠️ Tidak ada dokter yang memiliki jadwal aktif saat ini ({{ $now->format('H:i') }} WIB).
                                Silakan periksa jadwal dokter atau coba lagi nanti.
                            </div>
                        @else
                            <select
                                id="doctor_id"
                                name="doctor_id"
                                class="form-control {{ $errors->has('doctor_id') ? 'is-invalid' : '' }}"
                            >
                                <option value="">— Pilih Dokter —</option>
                                @foreach ($doctors as $doctor)
                                    <option
                                        value="{{ $doctor->id }}"
                                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                    >
                                        {{ $doctor->nama }} — {{ $doctor->spesialis }}
                                    </option>
                                @endforeach
                            </select>
                            <div style="font-size:.75rem; color:var(--text-muted); margin-top:4px;">
                                Hanya menampilkan dokter yang memiliki jadwal aktif saat ini.
                            </div>
                        @endif

                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div style="
                        background:#f0f9ff; border:1px solid #bae6fd;
                        border-radius:8px; padding:12px 16px;
                        font-size:.8rem; color:#0369a1;
                        line-height:1.7; margin-bottom:20px;
                    ">
                        <strong>ℹ️ Catatan:</strong><br>
                        • Nomor antrian akan digenerate otomatis oleh sistem.<br>
                        • Satu pasien hanya boleh mengambil satu antrian per dokter per hari.<br>
                        • Jadwal khusus (tanggal tertentu) diprioritaskan di atas jadwal rutin mingguan.
                    </div>

                    <hr class="form-divider">

                    <div style="display:flex; gap:10px;">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            {{ $doctors->isEmpty() ? 'disabled' : '' }}
                            style="{{ $doctors->isEmpty() ? 'opacity:.5; cursor:not-allowed;' : '' }}"
                        >
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            Ambil Nomor Antrian
                        </button>
                        <a href="{{ route('queues.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
