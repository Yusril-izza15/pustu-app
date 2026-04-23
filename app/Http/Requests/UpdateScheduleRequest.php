<?php

namespace App\Http\Requests;

/**
 * Path   : app/Http/Requests/UpdateScheduleRequest.php
 * Status : FILE BARU
 */

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id'   => ['required', 'integer', 'exists:doctors,id'],
            'hari'        => [
                'required',
                Rule::in(Schedule::DAFTAR_HARI),
            ],
            'tanggal'     => ['nullable', 'date'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required'    => 'Dokter wajib dipilih.',
            'doctor_id.exists'      => 'Dokter tidak ditemukan di database.',
            'hari.required'         => 'Hari wajib dipilih.',
            'hari.in'               => 'Hari harus salah satu dari: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu.',
            'tanggal.date'          => 'Format tanggal tidak valid.',
            'jam_mulai.required'    => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM (contoh: 08:00).',
            'jam_selesai.required'  => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM (contoh: 12:00).',
            'jam_selesai.after'     => 'Jam selesai harus lebih besar dari jam mulai.',
        ];
    }

    /**
     * Normalisasi is_active dari checkbox.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * Validasi tambahan setelah rules() — cek bentrok jadwal.
     * Saat UPDATE, jadwal milik dirinya sendiri DIKECUALIKAN dari pengecekan.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            // Ambil ID jadwal yang sedang diedit dari route parameter
            $scheduleId = $this->route('schedule')->id;
            $bentrok    = $this->cekBentrok($scheduleId);

            if ($bentrok) {
                $validator->errors()->add(
                    'jam_mulai',
                    "Jadwal bentrok dengan jadwal yang sudah ada: " .
                    "{$bentrok->doctor->nama} — {$bentrok->hari} " .
                    "({$bentrok->jam_mulai} – {$bentrok->jam_selesai})."
                );
            }
        });
    }

    /**
     * Cek bentrok, kecualikan jadwal dengan ID yang sedang diedit.
     *
     * @param int $excludeId — ID jadwal yang sedang diedit
     * @return Schedule|null
     */
    private function cekBentrok(int $excludeId): ?Schedule
    {
        $query = Schedule::with('doctor')
            ->where('id', '!=', $excludeId)          // kecualikan diri sendiri
            ->where('doctor_id', $this->doctor_id)
            ->where('is_active', true)
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai);

        if ($this->tanggal) {
            $query->where('tanggal', $this->tanggal);
        } else {
            $query->whereNull('tanggal')
                  ->where('hari', $this->hari);
        }

        return $query->first();
    }
}
