{{--
    Path   : resources/views/schedules/_form.blade.php
    Status : FILE BARU
    Catatan: Ini partial — TIDAK pakai @extends. Dipanggil dengan @include.
--}}

{{-- Pilih Dokter --}}
<div class="form-group">
    <label class="form-label" for="doctor_id">
        Dokter <span style="color:var(--red)">*</span>
    </label>
    <select
        id="doctor_id"
        name="doctor_id"
        class="form-control {{ $errors->has('doctor_id') ? 'is-invalid' : '' }}"
    >
        <option value="">— Pilih Dokter —</option>
        @foreach ($doctors as $doctor)
            <option
                value="{{ $doctor->id }}"
                {{ old('doctor_id', $schedule->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}
            >
                {{ $doctor->nama }} — {{ $doctor->spesialis }}
            </option>
        @endforeach
    </select>
    @error('doctor_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div style="font-size:.75rem; color:var(--text-muted); margin-top:4px;">
        Hanya menampilkan dokter yang berstatus aktif.
    </div>
</div>

{{-- Hari --}}
<div class="form-group">
    <label class="form-label" for="hari">
        Hari Praktek <span style="color:var(--red)">*</span>
    </label>
    <select
        id="hari"
        name="hari"
        class="form-control {{ $errors->has('hari') ? 'is-invalid' : '' }}"
    >
        <option value="">— Pilih Hari —</option>
        @foreach (\App\Models\Schedule::DAFTAR_HARI as $hari)
            <option
                value="{{ $hari }}"
                {{ old('hari', $schedule->hari ?? '') === $hari ? 'selected' : '' }}
            >
                {{ $hari }}
            </option>
        @endforeach
    </select>
    @error('hari')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Tanggal Khusus --}}
<div class="form-group">
    <label class="form-label" for="tanggal">Tanggal Khusus</label>
    <input
        type="date"
        id="tanggal"
        name="tanggal"
        class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
        value="{{ old('tanggal', isset($schedule->tanggal) ? $schedule->tanggal->format('Y-m-d') : '') }}"
    >
    @error('tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div style="
        background:#fffbeb; border:1px solid #fde68a;
        border-radius:8px; padding:10px 14px;
        font-size:.78rem; color:#92400e; margin-top:8px;
        line-height:1.6;
    ">
        <strong>ℹ️ Keterangan Tanggal Khusus:</strong><br>
        • <strong>Dikosongkan</strong> → Jadwal ini bersifat <strong>RUTIN MINGGUAN</strong> setiap hari yang dipilih.<br>
        • <strong>Diisi</strong> → Jadwal ini bersifat <strong>KHUSUS</strong> dan berlaku hanya pada tanggal tersebut.<br>
        • Jadwal khusus memiliki <strong>prioritas lebih tinggi</strong> dibanding jadwal rutin.
    </div>
</div>

{{-- Jam Mulai & Jam Selesai --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

    <div class="form-group">
        <label class="form-label" for="jam_mulai">
            Jam Mulai <span style="color:var(--red)">*</span>
        </label>
        <input
            type="time"
            id="jam_mulai"
            name="jam_mulai"
            class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
            value="{{ old('jam_mulai', $schedule->jam_mulai ?? '') }}"
        >
        @error('jam_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="jam_selesai">
            Jam Selesai <span style="color:var(--red)">*</span>
        </label>
        <input
            type="time"
            id="jam_selesai"
            name="jam_selesai"
            class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
            value="{{ old('jam_selesai', $schedule->jam_selesai ?? '') }}"
        >
        @error('jam_selesai')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

{{-- Status Aktif --}}
<div class="form-group">
    <label class="form-label">Status Jadwal</label>
    <label style="display:flex; align-items:center; gap:10px; cursor:pointer; width:fit-content;">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            style="width:18px; height:18px; accent-color:var(--primary); cursor:pointer;"
            {{ old('is_active', $schedule->is_active ?? true) ? 'checked' : '' }}
        >
        <span style="font-size:.9rem; color:var(--text);">
            Jadwal aktif (terlihat di sistem antrian)
        </span>
    </label>
</div>
