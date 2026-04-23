<?php

namespace App\Http\Requests;

/**
 * Artisan : php artisan make:request StoreDoctorRequest
 * Path    : app/Http/Requests/StoreDoctorRequest.php
 * Status  : FILE BARU
 */

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'      => ['required', 'string', 'max:100'],
            'spesialis' => ['required', 'string', 'max:100'],
            'no_hp'     => ['nullable', 'string', 'max:20'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'      => 'Nama dokter wajib diisi.',
            'nama.max'           => 'Nama dokter maksimal 100 karakter.',
            'spesialis.required' => 'Spesialis dokter wajib diisi.',
            'spesialis.max'      => 'Spesialis maksimal 100 karakter.',
            'no_hp.max'          => 'Nomor HP maksimal 20 karakter.',
        ];
    }

    /**
     * Pastikan is_active selalu ada nilainya (checkbox tidak terkirim = false).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
