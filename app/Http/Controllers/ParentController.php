<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    /**
     * Menampilkan rekap kehadiran anak
     */
    public function index()
    {
        // 1. Ambil data anak (Siswa) yang terhubung dengan akun Orang Tua ini
        // Menggunakan parent_id yang merujuk ke id di tabel users
        $children = Student::where('parent_id', Auth::id())
            ->with('classroom')
            ->get();

        // 2. Ambil semua ID anak untuk mencari absensinya
        $studentIds = $children->pluck('id');

        // 3. Ambil riwayat absensi dari anak-anak tersebut
        $attendances = Attendance::whereIn('student_id', $studentIds)
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('parent.monitoring', compact('children', 'attendances'));
    }
}