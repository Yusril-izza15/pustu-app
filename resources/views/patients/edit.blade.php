@extends('layouts.app')
{{-- Path: resources/views/patients/edit.blade.php --}}

@section('title', 'Edit Pasien')
@section('page-title', 'Edit Data Pasien')
@section('page-subtitle', 'Perbarui informasi pasien')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('patients.index') }}">Data Pasien</a>
        <span class="breadcrumb-sep">›</span>
        <span>Edit: {{ $patient->nama }}</span>
    </div>

    <div style="max-width:640px;">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit Data Pasien
                </span>
            </div>
            <div class="card-body">

                {{-- No Rekam Medis (hanya tampil, tidak bisa diubah) --}}
                <div class="form-group">
                    <span class="form-label">No. Rekam Medis</span>
                    <div class="rm-badge-static">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                        </svg>
                        {{ $patient->no_rekam_medis }}
                    </div>
                    <div style="font-size:.75rem; color:var(--text-muted); margin-top:5px;">
                        Nomor rekam medis tidak dapat diubah setelah dibuat.
                    </div>
                </div>

                <form method="POST" action="{{ route('patients.update', $patient) }}">
                    @csrf
                    @method('PUT')
                    @include('patients._form')
                    <hr class="form-divider">
                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
