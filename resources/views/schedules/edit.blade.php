@extends('layouts.app')
{{--
    Path   : resources/views/schedules/edit.blade.php
    Status : FILE BARU
--}}

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal Dokter')
@section('page-subtitle', 'Perbarui jadwal praktek dokter')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('schedules.index') }}">Jadwal Dokter</a>
        <span class="breadcrumb-sep">›</span>
        <span>Edit: {{ $schedule->doctor->nama }} — {{ $schedule->hari }}</span>
    </div>

    <div style="max-width:640px;">
        <div class="card">

            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"
                         style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit Jadwal Dokter
                </span>

                {{-- Badge jenis jadwal --}}
                @if ($schedule->isKhusus())
                    <span style="
                        background:#fff7ed; color:#c2410c; border:1px solid #fed7aa;
                        border-radius:20px; padding:3px 12px; font-size:.75rem; font-weight:700;
                    ">⭐ Jadwal Khusus</span>
                @else
                    <span style="
                        background:#f0f9ff; color:#0369a1; border:1px solid #bae6fd;
                        border-radius:20px; padding:3px 12px; font-size:.75rem; font-weight:700;
                    ">🔄 Jadwal Rutin</span>
                @endif
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('schedules.update', $schedule) }}">
                    @csrf
                    @method('PUT')

                    @include('schedules._form')

                    <hr class="form-divider">

                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
