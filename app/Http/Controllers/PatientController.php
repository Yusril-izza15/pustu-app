<?php

namespace App\Http\Controllers;

// Artisan: php artisan make:controller PatientController --resource
// Path: app/Http/Controllers/PatientController.php

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Daftar pasien dengan search & pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('no_rekam_medis', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // agar search tetap terbawa saat ganti halaman

        return view('patients.index', compact('patients', 'search'));
    }

    /**
     * Form tambah pasien baru.
     */
    public function create(): View
    {
        return view('patients.create');
    }

    /**
     * Simpan pasien baru ke database.
     */
    public function store(StorePatientRequest $request): RedirectResponse
    {
        // no_rekam_medis di-generate otomatis oleh Model (boot method)
        Patient::create($request->validated());

        return redirect()
            ->route('patients.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    /**
     * Detail pasien (opsional, bisa dihapus jika tidak dipakai).
     */
    public function show(Patient $patient): View
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Form edit data pasien.
     */
    public function edit(Patient $patient): View
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update data pasien.
     */
    public function update(UpdatePatientRequest $request, Patient $patient): RedirectResponse
    {
        // no_rekam_medis tidak ikut diupdate
        $patient->update($request->validated());

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Hapus pasien dari database.
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
