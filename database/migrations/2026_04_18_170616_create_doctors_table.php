<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Artisan : php artisan make:migration create_doctors_table
     * Path    : database/migrations/xxxx_xx_xx_create_doctors_table.php
     * Status  : FILE BARU
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('spesialis', 100);
            $table->string('no_hp', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
