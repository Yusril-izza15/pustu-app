@extends('layouts.app')
{{--
    Path   : resources/views/doctors/edit.blade.php
    Status : FILE BARU
--}}

@section('title', 'Edit Dokter')
@section('page-title', 'Edit Data Dokter')
@section('page-subtitle', 'Perbarui informasi dokter')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('doctors.index') }}">Data Dokter</a>
        <span class="breadcrumb-sep">›</span>
        <span>Edit: {{ $doctor->nama }}</span>
    </div>

    <div style="max-width:580px;">
        <div class="card">

            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"
                         style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit Data Dokter
                </span>

                {{-- Badge status saat ini --}}
                @if ($doctor->is_active)
                    <span style="
                        background:#f0fdfa; color:#0d9488; border:1px solid #a7f3d0;
                        border-radius:20px; padding:3px 12px; font-size:.75rem; font-weight:700;
                    ">● Aktif</span>
                @else
                    <span style="
                        background:#f8fafc; color:#94a3b8; border:1px solid #e2e8f0;
                        border-radius:20px; padding:3px 12px; font-size:.75rem; font-weight:700;
                    ">● Nonaktif</span>
                @endif
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('doctors.update', $doctor) }}">
                    @csrf
                    @method('PUT')

                    @include('doctors._form')

                    <hr class="form-divider">

                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('doctors.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
