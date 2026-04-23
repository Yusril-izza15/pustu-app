<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Artisan : php artisan make:model Schedule -m
     * Path    : database/migrations/xxxx_xx_xx_create_schedules_table.php
     * Status  : FILE BARU
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel doctors
            $table->foreignId('doctor_id')
                  ->constrained('doctors')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Hari praktek (Senin–Minggu)
            $table->enum('hari', [
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
            ]);

            // Tanggal khusus — jika diisi, jadwal ini bersifat JADWAL KHUSUS
            // Jika NULL → jadwal rutin mingguan
            $table->date('tanggal')->nullable();

            // Waktu praktek
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // Status aktif
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Index untuk mempercepat query pengecekan bentrok
            $table->index(['doctor_id', 'hari']);
            $table->index(['doctor_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
