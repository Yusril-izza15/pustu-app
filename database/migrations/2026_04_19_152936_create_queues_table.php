<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Artisan : php artisan make:model Queue -m
     * Path    : database/migrations/xxxx_xx_xx_create_queues_table.php
     * Status  : FILE BARU
     */
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel patients
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Foreign key ke tabel doctors
            $table->foreignId('doctor_id')
                  ->constrained('doctors')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Foreign key ke tabel schedules
            // schedule_id DIISI OTOMATIS oleh sistem, bukan input bebas
            $table->foreignId('schedule_id')
                  ->constrained('schedules')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Tanggal antrian (default hari ini)
            $table->date('tanggal');

            // Nomor antrian — urutan per dokter per tanggal
            $table->unsignedInteger('nomor_antrian');

            // Status antrian
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])
                  ->default('menunggu');

            $table->timestamps();

            // UNIQUE — nomor antrian tidak boleh dobel untuk dokter + tanggal yang sama
            $table->unique(['doctor_id', 'tanggal', 'nomor_antrian'], 'uq_queue_doctor_tanggal_nomor');

            // Index untuk mempercepat query filter antrian harian
            $table->index(['tanggal', 'doctor_id']);
            $table->index(['patient_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
