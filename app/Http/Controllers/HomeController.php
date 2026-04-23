<?php

namespace App\Http\Controllers;

/**
 * Path   : app/Http/Controllers/HomeController.php
 * Status : FILE BARU
 */

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Halaman utama / beranda.
     * Menampilkan 3 jadwal terbaru sebagai preview.
     */
    public function index(): View
    {
        // Eager load doctor — null-safe di view
        // Jika tabel kosong → collection kosong, bukan error
        $schedules = Schedule::with('doctor')
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('compro.index', compact('schedules'));
    }

    /**
     * Halaman jadwal lengkap.
     */
    public function jadwal(): View
    {
        $schedules = Schedule::with('doctor')
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('compro.jadwal', compact('schedules'));
    }

    /**
     * Halaman tentang kami.
     */
    public function tentang(): View
    {
        return view('compro.tentang');
    }

    /**
     * Halaman layanan.
     */
    public function layanan(): View
    {
        return view('compro.layanan');
    }

    /**
     * Halaman kontak.
     */
    public function kontak(): View
    {
        return view('compro.kontak');
    }
}
