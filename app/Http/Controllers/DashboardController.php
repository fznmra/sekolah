<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $displayName = $user->username; // Default: Username

        // Logika Mencari Nama Asli untuk Welcome Message
        if ($user->role == 'guru') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            $displayName = $teacher ? $teacher->teacher_name : $user->username;
        } elseif ($user->role == 'orang_tua') {
            $childrenNames = Student::where('parent_id', $user->id)->pluck('student_name')->toArray();
            $displayName = count($childrenNames) > 0 ? implode(', ', $childrenNames) : $user->username;
        }

        $data = [
            'displayName' => $displayName,
            'total_siswa' => Student::count(),
            'total_guru'  => Teacher::count(),
            'total_kelas' => Classroom::count(),
            'total_mapel' => Subject::count(),
        ];

        // Data spesifik untuk Guru
        if ($user->role == 'guru') {
            $teacher = Teacher::where('user_id', $user->id)->first();
            $data['my_assignments'] = TeacherAssignment::where('teacher_id', $teacher->id)
                                        ->with(['classroom', 'subject'])
                                        ->get();
        }

        // Data spesifik untuk Orang Tua
        if ($user->role == 'orang_tua') {
            $children = Student::where('parent_id', $user->id)->get();
            $data['my_children'] = $children;
            $data['today_attendance'] = Attendance::whereIn('student_id', $children->pluck('id'))
                                        ->where('attendance_date', date('Y-m-d'))
                                        ->with('student')
                                        ->get();
        }

        return view('dashboard', $data);
    }
}