<?php

namespace App\Http\Controllers;

/**
 * Path   : app/Http/Controllers/QueueController.php
 * Status : GANTI — tulis ulang full file ini
 * Ubahan : Menambahkan method current() untuk API polling real-time
 */

use App\Http\Requests\StoreQueueRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QueueController extends Controller
{
    private const MAP_HARI = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ];

    // -------------------------------------------------------
    // CURRENT — API endpoint publik untuk polling real-time
    // Dipanggil oleh JavaScript di display.blade.php setiap 3 detik
    // Selalu return JSON valid, tidak pernah crash
    // -------------------------------------------------------

    public function current(): JsonResponse
    {
        try {
            $today = Carbon::now('Asia/Jakarta')->toDateString();

            // Eager load doctor untuk hindari N+1
            // Jika tidak ada antrian dipanggil → $data = null
            $data = Queue::with('doctor')
                ->where('status', Queue::STATUS_DIPANGGIL)
                ->where('tanggal', $today)
                ->orderBy('updated_at', 'desc')
                ->first();

            // Selalu return JSON valid — semua null jika tidak ada data
            return response()->json([
                'nomor'  => $data !== null ? ($data->formatted_nomor ?? null) : null,
                'dokter' => $data !== null ? optional($data->doctor)->nama : null,
                'status' => $data !== null ? $data->status : null,
                'pasien' => $data !== null ? optional($data->patient)->nama : null,
            ]);

        } catch (\Throwable $e) {
            // Jika ada error apapun → return null JSON, tidak crash halaman display
            return response()->json([
                'nomor'  => null,
                'dokter' => null,
                'status' => null,
                'pasien' => null,
                'error'  => 'server_error',
            ], 200); // Tetap 200 agar JS tidak melempar error
        }
    }

    // -------------------------------------------------------
    // DISPLAY — halaman publik TV / layar tunggu
    // -------------------------------------------------------

    public function display(): View
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $now   = Carbon::now('Asia/Jakarta');

        // Statistik hari ini — query dengan count(), aman jika tabel kosong
        $totalMenunggu  = Queue::where('tanggal', $today)
            ->where('status', Queue::STATUS_MENUNGGU)
            ->count();

        $totalDipanggil = Queue::where('tanggal', $today)
            ->where('status', Queue::STATUS_DIPANGGIL)
            ->count();

        $totalSelesai   = Queue::where('tanggal', $today)
            ->where('status', Queue::STATUS_SELESAI)
            ->count();

        // Antrian yang sedang dipanggil untuk server-side initial render
        // JavaScript akan polling dan update tanpa reload
        $currentQueue = Queue::with(['doctor', 'patient', 'schedule'])
            ->where('status', Queue::STATUS_DIPANGGIL)
            ->where('tanggal', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('queues.display', compact(
            'currentQueue',
            'totalMenunggu',
            'totalDipanggil',
            'totalSelesai',
            'today',
            'now'
        ));
    }

    // -------------------------------------------------------
    // INDEX
    // -------------------------------------------------------

    public function index(Request $request): View
    {
        $now          = Carbon::now('Asia/Jakarta');
        $tanggal      = $request->input('tanggal', $now->format('Y-m-d'));
        $filterDoktor = $request->input('doctor_id');

        $queues = Queue::with(['patient', 'doctor', 'schedule'])
            ->byTanggal($tanggal)
            ->when($filterDoktor, fn ($q) => $q->byDoctor((int) $filterDoktor))
            ->orderBy('nomor_antrian', 'asc')
            ->paginate(20)
            ->withQueryString();

        $doctors = Doctor::active()->orderBy('nama')->get();

        $stats = [
            'menunggu'  => Queue::byTanggal($tanggal)->where('status', Queue::STATUS_MENUNGGU)->count(),
            'dipanggil' => Queue::byTanggal($tanggal)->where('status', Queue::STATUS_DIPANGGIL)->count(),
            'selesai'   => Queue::byTanggal($tanggal)->where('status', Queue::STATUS_SELESAI)->count(),
        ];

        return view('queues.index', compact(
            'queues', 'doctors', 'tanggal', 'filterDoktor', 'stats'
        ));
    }

    // -------------------------------------------------------
    // CREATE
    // -------------------------------------------------------

    public function create(): View
    {
        $now     = Carbon::now('Asia/Jakarta');
        $tanggal = $now->format('Y-m-d');
        $hariEn  = $now->format('l');
        $hariId  = self::MAP_HARI[$hariEn] ?? $hariEn;
        $jam     = $now->format('H:i');

        $doctorIdsKhusus = Schedule::where('is_active', true)
            ->where('tanggal', $tanggal)
            ->where('jam_mulai', '<=', $jam)
            ->where('jam_selesai', '>=', $jam)
            ->pluck('doctor_id')
            ->toArray();

        $doctorIdsRutin = Schedule::where('is_active', true)
            ->whereNull('tanggal')
            ->where('hari', $hariId)
            ->where('jam_mulai', '<=', $jam)
            ->where('jam_selesai', '>=', $jam)
            ->pluck('doctor_id')
            ->toArray();

        $allDoctorIds = array_unique(array_merge($doctorIdsKhusus, $doctorIdsRutin));

        $doctors  = Doctor::active()->whereIn('id', $allDoctorIds)->orderBy('nama')->get();
        $patients = Patient::orderBy('nama')->get();

        return view('queues.create', compact('doctors', 'patients', 'now'));
    }

    // -------------------------------------------------------
    // STORE
    // -------------------------------------------------------

    public function store(StoreQueueRequest $request): RedirectResponse
    {
        $now       = Carbon::now('Asia/Jakarta');
        $tanggal   = $now->format('Y-m-d');
        $hariEn    = $now->format('l');
        $hariId    = self::MAP_HARI[$hariEn] ?? $hariEn;
        $jam       = $now->format('H:i');
        $doctorId  = (int) $request->doctor_id;
        $patientId = (int) $request->patient_id;

        $schedule = $this->cariJadwalValid($doctorId, $tanggal, $hariId, $jam);

        if ($schedule === null) {
            return back()->withInput()->withErrors([
                'doctor_id' => 'Dokter tidak memiliki jadwal aktif saat ini.',
            ]);
        }

        $sudahAntri = Queue::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($sudahAntri) {
            return back()->withInput()->withErrors([
                'patient_id' => 'Pasien ini sudah memiliki antrian untuk dokter tersebut hari ini.',
            ]);
        }

        try {
            $queue = DB::transaction(function () use ($patientId, $doctorId, $schedule, $tanggal) {
                $last      = Queue::where('doctor_id', $doctorId)
                    ->where('tanggal', $tanggal)
                    ->lockForUpdate()
                    ->max('nomor_antrian');
                $nomorBaru = ($last ?? 0) + 1;

                return Queue::create([
                    'patient_id'    => $patientId,
                    'doctor_id'     => $doctorId,
                    'schedule_id'   => $schedule->id,
                    'tanggal'       => $tanggal,
                    'nomor_antrian' => $nomorBaru,
                    'status'        => Queue::STATUS_MENUNGGU,
                ]);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors([
                'doctor_id' => 'Gagal menyimpan antrian. Silakan coba lagi.',
            ]);
        }

        return redirect()
            ->route('queues.index')
            ->with('success', "Antrian berhasil diambil! Nomor: {$queue->formatted_nomor}");
    }

    // -------------------------------------------------------
    // UPDATE STATUS
    // -------------------------------------------------------

    public function updateStatus(Request $request, Queue $queue): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', Queue::DAFTAR_STATUS)],
        ]);

        $queue->update(['status' => $request->status]);

        $label = match ($request->status) {
            Queue::STATUS_DIPANGGIL => "Pasien {$queue->patient->nama} dipanggil.",
            Queue::STATUS_SELESAI   => "Antrian {$queue->patient->nama} selesai.",
            default                 => 'Status antrian diperbarui.',
        };

        return back()->with('success', $label);
    }

    // -------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------

    public function destroy(Queue $queue): RedirectResponse
    {
        $queue->delete();
        return back()->with('success', 'Data antrian berhasil dihapus.');
    }

    // -------------------------------------------------------
    // HELPER
    // -------------------------------------------------------

    private function cariJadwalValid(int $doctorId, string $tanggal, string $hariId, string $jam): ?Schedule
    {
        $jadwalKhusus = Schedule::where('doctor_id', $doctorId)
            ->where('is_active', true)
            ->where('tanggal', $tanggal)
            ->where('jam_mulai', '<=', $jam)
            ->where('jam_selesai', '>=', $jam)
            ->first();

        if ($jadwalKhusus !== null) {
            return $jadwalKhusus;
        }

        $adaKhusus = Schedule::where('doctor_id', $doctorId)
            ->where('is_active', true)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($adaKhusus) {
            return null;
        }

        return Schedule::where('doctor_id', $doctorId)
            ->where('is_active', true)
            ->whereNull('tanggal')
            ->where('hari', $hariId)
            ->where('jam_mulai', '<=', $jam)
            ->where('jam_selesai', '>=', $jam)
            ->first();
    }
}
