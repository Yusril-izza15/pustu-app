@extends('layouts.app')
{{--
    Path   : resources/views/schedules/create.blade.php
    Status : FILE BARU
--}}

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Dokter')
@section('page-subtitle', 'Tambahkan jadwal praktek dokter baru')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('schedules.index') }}">Jadwal Dokter</a>
        <span class="breadcrumb-sep">›</span>
        <span>Tambah Jadwal Baru</span>
    </div>

    <div style="max-width:640px;">
        <div class="card">

            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"
                         style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    Form Jadwal Dokter
                </span>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf

                    @include('schedules._form')

                    <hr class="form-divider">

                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                            </svg>
                            Simpan Jadwal
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
