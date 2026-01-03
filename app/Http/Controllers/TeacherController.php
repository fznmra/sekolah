<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\TeacherAssignment;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Menampilkan halaman input absensi dengan data yang sudah terisi
     */
    public function inputAbsen(Request $request, $assignment_id)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
        
        $assignment = TeacherAssignment::where('id', $assignment_id)
            ->where('teacher_id', $teacher->id)
            ->with(['classroom', 'subject'])
            ->firstOrFail();

        // Mengambil tanggal dari filter, default adalah hari ini
        $date = $request->query('date', date('Y-m-d'));

        $students = Student::where('classroom_id', $assignment->classroom_id)
            ->orderBy('student_name', 'asc')
            ->get();

        // Ambil data absensi yang sudah ada pada tanggal dan mapel ini
        // Kita gunakan pluck untuk mendapatkan array [student_id => status]
        $existingAttendance = Attendance::where('classroom_id', $assignment->classroom_id)
            ->where('subject_name', $assignment->subject->subject_name)
            ->where('attendance_date', $date)
            ->pluck('status', 'student_id');

        return view('teacher.absensi_grid', compact('assignment', 'students', 'teacher', 'date', 'existingAttendance'));
    }

    /**
     * Menyimpan atau memperbarui data absensi secara massal
     */
    public function simpanAbsen(Request $request)
    {
        $request->validate([
            'status' => 'required|array',
            'attendance_date' => 'required|date',
        ]);

        foreach ($request->status as $student_id => $status_value) {
            // updateOrCreate akan mencari data yang ada, jika ketemu akan diupdate,
            // jika tidak ada maka akan dibuat baru (berguna untuk koreksi absen)
            Attendance::updateOrCreate(
                [
                    'student_id'      => $student_id,
                    'attendance_date' => $request->attendance_date,
                    'classroom_id'    => $request->classroom_id,
                    'subject_name'    => $request->subject_name,
                ],
                [
                    'teacher_id' => $request->teacher_id,
                    'status'     => $status_value,
                ]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil diperbarui untuk tanggal ' . $request->attendance_date);
    }

    // --- FITUR NILAI (Tetap sesuai versi kategori sebelumnya) ---

    public function inputNilai(Request $request, $assignment_id)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
        $assignment = TeacherAssignment::where('id', $assignment_id)
            ->where('teacher_id', $teacher->id)
            ->with(['classroom', 'subject'])
            ->firstOrFail();

        $category = $request->query('category', 'tugas');
        $students = Student::where('classroom_id', $assignment->classroom_id)->orderBy('student_name', 'asc')->get();
        $existingGrades = Grade::where('subject_id', $assignment->subject_id)->where('category', $category)->pluck('score', 'student_id');

        return view('teacher.nilai_grid', compact('assignment', 'students', 'teacher', 'category', 'existingGrades'));
    }

    public function simpanNilai(Request $request)
    {
        $request->validate(['score' => 'required|array', 'category' => 'required']);
        foreach ($request->score as $student_id => $score_value) {
            if ($score_value !== null && $score_value !== '') {
                Grade::updateOrCreate(
                    ['student_id' => $student_id, 'subject_id' => $request->subject_id, 'category' => $request->category],
                    ['teacher_id' => $request->teacher_id, 'score' => $score_value]
                );
            }
        }
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }

    public function rekapNilai($assignment_id)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
        $assignment = TeacherAssignment::where('id', $assignment_id)->where('teacher_id', $teacher->id)->with(['classroom', 'subject'])->firstOrFail();
        $students = Student::where('classroom_id', $assignment->classroom_id)->orderBy('student_name', 'asc')->get();
        $allGrades = Grade::where('subject_id', $assignment->subject_id)->get();

        $rekap = [];
        foreach ($students as $student) {
            $studentGrades = $allGrades->where('student_id', $student->id);
            $average = $studentGrades->count() > 0 ? $studentGrades->avg('score') : 0;
            $letter = $average >= 85 ? 'A' : ($average >= 75 ? 'B' : ($average >= 60 ? 'C' : 'D'));
            $color = $average >= 85 ? 'success' : ($average >= 75 ? 'primary' : ($average >= 60 ? 'warning' : 'danger'));
            
            $rekap[] = ['name' => $student->student_name, 'nisn' => $student->nisn, 'average' => round($average, 2), 'letter' => $letter, 'color' => $color];
        }
        return view('teacher.rekap_nilai', compact('assignment', 'rekap', 'teacher'));
    }
}