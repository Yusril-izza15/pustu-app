<?php

namespace App\Models;

/**
 * Path   : app/Models/Queue.php
 * Status : GANTI — tulis ulang full file ini
 * Ubahan : Menambahkan accessor getFormattedNomorAttribute()
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'tanggal',
        'nomor_antrian',
        'status',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'nomor_antrian' => 'integer',
    ];

    // -------------------------------------------------------
    // KONSTANTA STATUS
    // -------------------------------------------------------

    public const STATUS_MENUNGGU  = 'menunggu';
    public const STATUS_DIPANGGIL = 'dipanggil';
    public const STATUS_SELESAI   = 'selesai';

    public const DAFTAR_STATUS = [
        self::STATUS_MENUNGGU,
        self::STATUS_DIPANGGIL,
        self::STATUS_SELESAI,
    ];

    // -------------------------------------------------------
    // ACCESSOR
    // -------------------------------------------------------

    /**
     * Format nomor antrian menjadi: A-001, A-002, dst.
     * Aman jika nomor_antrian null → mengembalikan '-'
     *
     * Penggunaan di Blade: {{ $queue->formatted_nomor }}
     */
    public function getFormattedNomorAttribute(): string
    {
        if ($this->nomor_antrian === null || $this->nomor_antrian === 0) {
            return '-';
        }

        return 'A-' . str_pad((string) $this->nomor_antrian, 3, '0', STR_PAD_LEFT);
    }

    // -------------------------------------------------------
    // RELASI
    // -------------------------------------------------------

    /**
     * Antrian ini milik satu pasien.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Antrian ini milik satu dokter.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Antrian ini terkait dengan satu jadwal.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    // -------------------------------------------------------
    // SCOPE
    // -------------------------------------------------------

    /**
     * Filter antrian berdasarkan tanggal.
     */
    public function scopeByTanggal($query, string $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    /**
     * Filter antrian berdasarkan dokter.
     */
    public function scopeByDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Hanya antrian dengan status menunggu.
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    // -------------------------------------------------------
    // HELPER
    // -------------------------------------------------------

    /**
     * Style CSS untuk badge status di view.
     */
    public function statusStyle(): array
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => [
                'bg'     => '#fefce8',
                'color'  => '#92400e',
                'border' => '#fde68a',
                'dot'    => '#f59e0b',
            ],
            self::STATUS_DIPANGGIL => [
                'bg'     => '#eff6ff',
                'color'  => '#1d4ed8',
                'border' => '#bfdbfe',
                'dot'    => '#3b82f6',
            ],
            self::STATUS_SELESAI   => [
                'bg'     => '#f0fdfa',
                'color'  => '#0d9488',
                'border' => '#a7f3d0',
                'dot'    => '#0d9488',
            ],
            default => [
                'bg'     => '#f8fafc',
                'color'  => '#94a3b8',
                'border' => '#e2e8f0',
                'dot'    => '#94a3b8',
            ],
        };
    }

    /**
     * Label status dalam Bahasa Indonesia.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => 'Menunggu',
            self::STATUS_DIPANGGIL => 'Dipanggil',
            self::STATUS_SELESAI   => 'Selesai',
            default                => ucfirst($this->status),
        };
    }
}
