<?php

namespace App\Http\Controllers;

/**
 * Artisan : php artisan make:controller DoctorController --resource
 * Path    : app/Http/Controllers/DoctorController.php
 * Status  : FILE BARU
 */

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    /**
     * Tampilkan daftar dokter dengan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $doctors = Doctor::query()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('spesialis', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('doctors.index', compact('doctors', 'search'));
    }

    /**
     * Tampilkan form tambah dokter baru.
     */
    public function create(): View
    {
        return view('doctors.create');
    }

    /**
     * Simpan dokter baru ke database.
     */
    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        Doctor::create($request->validated());

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit dokter.
     */
    public function edit(Doctor $doctor): View
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update data dokter.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update($request->validated());

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Hapus dokter dari database.
     */
    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }

    /**
     * show() tidak dipakai di proyek ini, tapi wajib ada di resource controller.
     */
    public function show(Doctor $doctor): View
    {
        return view('doctors.edit', compact('doctor'));
    }
}
