<?php

namespace App\Http\Requests;

/**
 * Path   : app/Http/Requests/StoreScheduleRequest.php
 * Status : FILE BARU
 */

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
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
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Hanya cek jika field utama sudah valid
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $bentrok = $this->cekBentrok();

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
     * Cek apakah jadwal baru bertabrakan dengan jadwal yang sudah ada.
     *
     * Logika bentrok:
     * jadwal baru bentrok jika:
     *   jam_mulai_baru < jam_selesai_lama
     *   DAN jam_selesai_baru > jam_mulai_lama
     *
     * @return Schedule|null — jadwal yang bentrok, atau null jika aman
     */
    private function cekBentrok(): ?Schedule
    {
        $query = Schedule::with('doctor')
            ->where('doctor_id', $this->doctor_id)
            ->where('is_active', true)
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai);

        // Jika tanggal diisi → cek jadwal khusus di tanggal yang sama
        if ($this->tanggal) {
            $query->where('tanggal', $this->tanggal);
        } else {
            // Jadwal rutin → cek hari yang sama, tanpa tanggal
            $query->whereNull('tanggal')
                  ->where('hari', $this->hari);
        }

        return $query->first();
    }
}
