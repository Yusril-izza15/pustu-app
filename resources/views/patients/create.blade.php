@extends('layouts.app')
{{-- Path: resources/views/patients/create.blade.php --}}

@section('title', 'Tambah Pasien')
@section('page-title', 'Tambah Pasien')
@section('page-subtitle', 'Isi formulir untuk mendaftarkan pasien baru')

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('patients.index') }}">Data Pasien</a>
        <span class="breadcrumb-sep">›</span>
        <span>Tambah Pasien Baru</span>
    </div>

    <div style="max-width:640px;">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;vertical-align:middle;margin-right:6px;color:var(--primary);">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Form Pendaftaran Pasien
                </span>
            </div>
            <div class="card-body">

                {{-- RM Auto Info --}}
                <div class="rm-notice">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    No. Rekam Medis akan di-generate otomatis oleh sistem saat data disimpan.
                </div>

                <form method="POST" action="{{ route('patients.store') }}">
                    @csrf
                    @include('patients._form')
                    <hr class="form-divider">
                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                            Simpan Pasien
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
