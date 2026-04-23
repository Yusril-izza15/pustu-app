@extends('layouts.app')
{{--
    Path   : resources/views/doctors/create.blade.php
    Status : FILE BARU
--}}

@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')
@section('page-subtitle', 'Daftarkan dokter baru ke sistem')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('doctors.index') }}">Data Dokter</a>
        <span class="breadcrumb-sep">›</span>
        <span>Tambah Dokter Baru</span>
    </div>

    <div style="max-width:580px;">
        <div class="card">

            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"
                         style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Form Tambah Dokter
                </span>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('doctors.store') }}">
                    @csrf

                    @include('doctors._form')

                    <hr class="form-divider">

                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                            </svg>
                            Simpan Dokter
                        </button>
                        <a href="{{ route('doctors.index') }}" class="btn btn-ghost">Batal</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
