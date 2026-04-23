<?php

namespace App\Models;

/**
 * Path   : app/Models/Patient.php
 * Status : GANTI — tulis ulang full file ini
 * Ubahan : Menambahkan relasi hasMany ke Queue
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'no_rekam_medis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // -------------------------------------------------------
    // BOOT — auto generate no_rekam_medis
    // -------------------------------------------------------

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Patient $patient) {
            $patient->no_rekam_medis = static::generateNoRekamMedis();
        });
    }

    /**
     * Generate nomor rekam medis unik.
     * Format: RM-00001, RM-00002, dst.
     */
    public static function generateNoRekamMedis(): string
    {
        $last   = static::orderByDesc('id')->value('no_rekam_medis');
        $number = $last ? ((int) substr($last, 3)) + 1 : 1;

        return 'RM-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    // -------------------------------------------------------
    // RELASI
    // -------------------------------------------------------

    /**
     * Satu pasien memiliki banyak antrian.
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class);
    }
}
