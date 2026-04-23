<?php

namespace App\Models;

/**
 * Path   : app/Models/Schedule.php
 * Status : FILE BARU
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'hari',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    // -------------------------------------------------------
    // KONSTANTA — urutan hari untuk sorting
    // -------------------------------------------------------

    public const URUTAN_HARI = [
        'Senin'   => 1,
        'Selasa'  => 2,
        'Rabu'    => 3,
        'Kamis'   => 4,
        'Jumat'   => 5,
        'Sabtu'   => 6,
        'Minggu'  => 7,
    ];

    public const DAFTAR_HARI = [
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
    ];

    // -------------------------------------------------------
    // RELASI
    // -------------------------------------------------------

    /**
     * Jadwal ini milik satu dokter.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    // -------------------------------------------------------
    // HELPER
    // -------------------------------------------------------

    /**
     * Apakah jadwal ini bersifat JADWAL KHUSUS (tanggal diisi)?
     */
    public function isKhusus(): bool
    {
        return $this->tanggal !== null;
    }

    /**
     * Label jenis jadwal untuk ditampilkan di view.
     */
    public function jenisLabel(): string
    {
        return $this->isKhusus() ? 'Khusus' : 'Rutin';
    }

    // -------------------------------------------------------
    // SCOPE
    // -------------------------------------------------------

    /**
     * Hanya jadwal yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Hanya jadwal rutin (tanggal NULL).
     */
    public function scopeRutin($query)
    {
        return $query->whereNull('tanggal');
    }

    /**
     * Hanya jadwal khusus (tanggal TIDAK NULL).
     */
    public function scopeKhusus($query)
    {
        return $query->whereNotNull('tanggal');
    }
}
