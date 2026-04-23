<?php

namespace App\Http\Controllers;

/**
 * Path   : app/Http/Controllers/ScheduleController.php
 * Status : FILE BARU
 */

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar jadwal dokter.
     *
     * Sorting:
     * 1. Hari diurutkan manual: Senin → Minggu
     * 2. Lalu jam_mulai ASC
     *
     * MySQL tidak mendukung ORDER BY FIELD() via Eloquent,
     * sehingga kita gunakan FIELD() dengan orderByRaw.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // Query dasar
        $query = Schedule::with('doctor')
            ->when($search, function ($q, $search) {
                $q->whereHas('doctor', function ($dq) use ($search) {
                    $dq->where('nama', 'like', "%{$search}%");
                })->orWhere('hari', 'like', "%{$search}%");
            })
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai', 'asc');

        $schedules = $query->paginate(15)->withQueryString();

        return view('schedules.index', compact('schedules', 'search'));
    }

    /**
     * Tampilkan form tambah jadwal baru.
     */
    public function create(): View
    {
        // Hanya dokter aktif yang boleh dipilih
        $doctors = Doctor::active()->orderBy('nama')->get();

        return view('schedules.create', compact('doctors'));
    }

    /**
     * Simpan jadwal baru ke database.
     */
    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        Schedule::create($request->validated());

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit jadwal.
     */
    public function edit(Schedule $schedule): View
    {
        $doctors = Doctor::active()->orderBy('nama')->get();

        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    /**
     * Update data jadwal.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule): RedirectResponse
    {
        $schedule->update($request->validated());

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal dokter berhasil diperbarui.');
    }

    /**
     * Hapus jadwal dari database.
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal dokter berhasil dihapus.');
    }

    /**
     * show() diperlukan oleh resource controller tapi tidak digunakan aktif.
     */
    public function show(Schedule $schedule): View
    {
        return view('schedules.edit', compact('schedule'));
    }
}
