<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Attendance::with('user')->whereHas('user', function ($q) {
            $q->where('role', 'siswa');
        });

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('recorded_at', [$startDate, $endDate]);
        }

        // Filter berdasarkan kelas
        if ($request->filled('class')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        // Ambil semua data absensi yang sudah difilter
        $attendances = $query->orderBy('recorded_at', 'desc')->get();

        // Kelompokkan data untuk ditampilkan per hari per siswa
        $groupedAttendances = $attendances->groupBy(function ($item) {
            return $item->recorded_at->format('Y-m-d') . '_' . $item->user_id;
        });

        $processedAttendances = [];
        foreach ($groupedAttendances as $key => $group) {
            $checkIn = $group->where('status', 'in')->first();
            $checkOut = $group->where('status', 'out')->last();
            $user = $group->first()->user;

            if ($user) {
                 $processedAttendances[] = [
                    'date' => $group->first()->recorded_at->translatedFormat('d F Y'),
                    'user_name' => $user->name,
                    'class' => $user->class,
                    'check_in' => $checkIn ? $checkIn->recorded_at->format('H:i:s') : null,
                    'check_out' => $checkOut ? $checkOut->recorded_at->format('H:i:s') : null,
                ];
            }
        }

        // Ambil daftar kelas unik untuk dropdown filter
        $classes = User::student()->select('class')->distinct()->pluck('class');

        return view('admin.attendances.index', [
            'attendances' => $processedAttendances,
            'classes' => $classes,
            'filters' => $request->only(['start_date', 'end_date', 'class']),
        ]);
    }
}

