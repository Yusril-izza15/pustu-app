<?php

namespace App\Http\Requests;

/**
 * Path   : app/Http/Requests/StoreQueueRequest.php
 * Status : FILE BARU
 */

use Illuminate\Foundation\Http\FormRequest;

class StoreQueueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'doctor_id'  => ['required', 'integer', 'exists:doctors,id'],
            // schedule_id TIDAK ada di sini karena diisi otomatis oleh controller
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Pasien wajib dipilih.',
            'patient_id.exists'   => 'Pasien tidak ditemukan di database.',
            'doctor_id.required'  => 'Dokter wajib dipilih.',
            'doctor_id.exists'    => 'Dokter tidak ditemukan di database.',
        ];
    }
}
