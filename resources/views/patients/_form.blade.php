{{-- Path: resources/views/patients/_form.blade.php --}}
{{-- Digunakan oleh create.blade.php dan edit.blade.php --}}
{{-- Tidak menggunakan @extends — ini partial, bukan halaman --}}

{{-- Nama --}}
<div class="form-group">
    <label class="form-label" for="nama">
        Nama Lengkap <span style="color:var(--red)">*</span>
    </label>
    <input
        type="text"
        id="nama"
        name="nama"
        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
        value="{{ old('nama', $patient->nama ?? '') }}"
        placeholder="Masukkan nama lengkap pasien"
        autofocus
    >
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Jenis Kelamin --}}
<div class="form-group">
    <label class="form-label">
        Jenis Kelamin <span style="color:var(--red)">*</span>
    </label>
    <div class="radio-group">
        <label class="radio-item">
            <input
                type="radio"
                name="jenis_kelamin"
                value="L"
                {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'L' ? 'checked' : '' }}
            >
            Laki-laki
        </label>
        <label class="radio-item">
            <input
                type="radio"
                name="jenis_kelamin"
                value="P"
                {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'P' ? 'checked' : '' }}
            >
            Perempuan
        </label>
    </div>
    @error('jenis_kelamin')
        <span class="error-text">{{ $message }}</span>
    @enderror
</div>

{{-- Tanggal Lahir --}}
<div class="form-group">
    <label class="form-label" for="tanggal_lahir">
        Tanggal Lahir <span style="color:var(--red)">*</span>
    </label>
    <input
        type="date"
        id="tanggal_lahir"
        name="tanggal_lahir"
        class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}"
        value="{{ old('tanggal_lahir', isset($patient->tanggal_lahir) ? $patient->tanggal_lahir->format('Y-m-d') : '') }}"
        max="{{ date('Y-m-d') }}"
    >
    @error('tanggal_lahir')
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
        value="{{ old('no_hp', $patient->no_hp ?? '') }}"
        placeholder="Contoh: 081234567890 (opsional)"
    >
    @error('no_hp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Alamat --}}
<div class="form-group">
    <label class="form-label" for="alamat">Alamat</label>
    <textarea
        id="alamat"
        name="alamat"
        class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
        rows="3"
        placeholder="Masukkan alamat lengkap (opsional)"
    >{{ old('alamat', $patient->alamat ?? '') }}</textarea>
    @error('alamat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
