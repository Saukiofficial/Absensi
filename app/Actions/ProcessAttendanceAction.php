<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Attendance;
use App\Jobs\SendWhatsappNotification;
use Carbon\Carbon;

class ProcessAttendanceAction
{
    /**
     * Process an attendance record.
     *
     * @param string $identifier Can be card_uid or fingerprint_id
     * @param string $method 'rfid' or 'fingerprint'
     * @param string $deviceId
     * @return array
     */
    public function execute(string $identifier, string $method, string $deviceId): array
    {
        // Mencari siswa berdasarkan metode absensi yang digunakan (RFID atau fingerprint)
        $query = User::student();
        if ($method === 'fingerprint') {
            $query->where('fingerprint_id', $identifier);
        } else {
            // Default ke RFID jika metode tidak dispesifikasikan sebagai fingerprint
            $query->where('card_uid', $identifier);
        }

        // Mengambil data siswa beserta relasi wali muridnya untuk efisiensi
        $student = $query->with('guardian')->first();

        // Jika siswa tidak ditemukan, kembalikan pesan error
        if (!$student) {
            return ['success' => false, 'message' => 'Siswa dengan ID tersebut tidak ditemukan.'];
        }

        // Menentukan status absensi (masuk atau pulang)
        $today = Carbon::today();
        $lastAttendance = Attendance::where('user_id', $student->id)
            ->whereDate('recorded_at', $today)
            ->latest('recorded_at')
            ->first();

        $status = 'in'; // Default status adalah 'masuk'
        // Jika sudah ada absensi hari ini dan status terakhirnya adalah 'masuk',
        // maka absensi kali ini dianggap 'pulang'
        if ($lastAttendance && $lastAttendance->status === 'in') {
            $status = 'out';
        }

        // Membuat catatan absensi baru di database
        $attendance = Attendance::create([
            'user_id' => $student->id,
            'card_uid' => $identifier, // Menyimpan identifier yang digunakan (bisa UID kartu atau ID sidik jari)
            'device_id' => $deviceId,
            'method' => $method,
            'status' => $status,
            'recorded_at' => now(),
        ]);

        // Mengirim notifikasi WhatsApp ke wali murid jika ada
        if ($student->guardian && $student->guardian->guardian_phone) {
            $action = ($status === 'in') ? 'masuk' : 'pulang';
            $message = "Halo {$student->guardian->name}, putra/putri Anda {$student->name} sudah {$action} sekolah pada jam " . $attendance->recorded_at->format('H:i');

            // Mengirim tugas pengiriman notifikasi ke dalam antrian (queue)
            SendWhatsappNotification::dispatch($student, $student->guardian, $message);
        }

        // Menyiapkan pesan balasan untuk API/Simulator
        $actionText = ($status === 'in') ? 'masuk' : 'pulang';
        $finalMessage = "Absensi {$actionText} untuk {$student->name} berhasil dicatat pada jam " . $attendance->recorded_at->format('H:i:s');

        return ['success' => true, 'message' => $finalMessage];
    }
}

