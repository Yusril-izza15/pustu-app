<?php

namespace App\Models;

/**
 * Path   : app/Models/Doctor.php
 * Status : GANTI — tulis ulang full file ini
 * Ubahan : Menambahkan relasi hasMany ke Queue
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'nama',
        'spesialis',
        'no_hp',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // -------------------------------------------------------
    // SCOPE
    // -------------------------------------------------------

    /**
     * Hanya dokter yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // -------------------------------------------------------
    // RELASI
    // -------------------------------------------------------

    /**
     * Satu dokter memiliki banyak jadwal praktek.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Hanya jadwal aktif milik dokter ini.
     */
    public function activeSchedules(): HasMany
    {
        return $this->hasMany(Schedule::class)->where('is_active', true);
    }

    /**
     * Satu dokter memiliki banyak antrian.
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class);
    }
}
