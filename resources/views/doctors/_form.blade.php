{{--
    Path   : resources/views/doctors/_form.blade.php
    Status : FILE BARU
    Catatan: Ini partial — TIDAK pakai @extends. Dipanggil dengan @include.
--}}

{{-- Nama Dokter --}}
<div class="form-group">
    <label class="form-label" for="nama">
        Nama Dokter <span style="color:var(--red)">*</span>
    </label>
    <input
        type="text"
        id="nama"
        name="nama"
        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
        value="{{ old('nama', $doctor->nama ?? '') }}"
        placeholder="Contoh: dr. Budi Santoso"
        autofocus
    >
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Spesialis --}}
<div class="form-group">
    <label class="form-label" for="spesialis">
        Spesialis <span style="color:var(--red)">*</span>
    </label>
    <input
        type="text"
        id="spesialis"
        name="spesialis"
        class="form-control {{ $errors->has('spesialis') ? 'is-invalid' : '' }}"
        value="{{ old('spesialis', $doctor->spesialis ?? '') }}"
        placeholder="Contoh: Umum, Gigi, Anak, Kandungan"
    >
    @error('spesialis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Nomor HP --}}
<div class="form-group">
    <label class="form-label" for="no_hp">Nomor HP</label>
    <input
        type="text"
        id="no_hp"
        name="no_hp"
        class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
        value="{{ old('no_hp', $doctor->no_hp ?? '') }}"
        placeholder="Contoh: 081234567890 (opsional)"
    >
    @error('no_hp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Status Aktif --}}
<div class="form-group">
    <label class="form-label">Status Dokter</label>
    <label style="display:flex; align-items:center; gap:10px; cursor:pointer; width:fit-content;">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            style="width:18px; height:18px; accent-color:var(--primary); cursor:pointer;"
            {{ old('is_active', $doctor->is_active ?? true) ? 'checked' : '' }}
        >
        <span style="font-size:.9rem; color:var(--text);">
            Dokter aktif (bisa menerima jadwal & antrian)
        </span>
    </label>
    <div style="font-size:.75rem; color:var(--text-muted); margin-top:4px;">
        Nonaktifkan jika dokter sedang cuti atau tidak berpraktik.
    </div>
</div>
