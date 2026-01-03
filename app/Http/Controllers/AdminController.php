<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // --- 1. DATA KELAS ---
    public function indexClassroom() {
        $data = Classroom::all();
        return view('admin.classroom', compact('data'));
    }
    public function storeClassroom(Request $request) {
        Classroom::create($request->validate(['class_name' => 'required|unique:classrooms']));
        return back()->with('success', 'Kelas berhasil disimpan!');
    }
    public function deleteClassroom($id) {
        Classroom::destroy($id);
        return back()->with('success', 'Kelas dihapus!');
    }

    // --- 2. DATA MAPEL ---
    public function indexSubject() {
        $data = Subject::all();
        return view('admin.subject', compact('data'));
    }
    public function storeSubject(Request $request) {
        Subject::create($request->validate(['subject_name' => 'required|unique:subjects']));
        return back()->with('success', 'Mapel berhasil disimpan!');
    }
    public function deleteSubject($id) {
        Subject::destroy($id);
        return back()->with('success', 'Mapel dihapus!');
    }

    // --- 3. DATA GURU (Input Guru + Otomatis Buat Akun User) ---
    public function indexTeacher() {
        $data = Teacher::with('user')->get();
        return view('admin.teacher', compact('data'));
    }
    public function storeTeacher(Request $request) {
        $request->validate(['teacher_name' => 'required', 'nip' => 'required|unique:teachers', 'password' => 'required']);
        
        // Buat akun login dulu
        $user = User::create([
            'username' => $request->nip, // Username login pake NIP
            'password' => Hash::make($request->password),
            'role' => 'guru'
        ]);

        // Simpan data guru
        Teacher::create([
            'user_id' => $user->id,
            'teacher_name' => $request->teacher_name,
            'nip' => $request->nip
        ]);

        return back()->with('success', 'Guru berhasil didaftarkan!');
    }
    public function deleteTeacher($id) {
        $teacher = Teacher::findOrFail($id);
        User::destroy($teacher->user_id); // Hapus akun loginnya juga
        $teacher->delete();
        return back()->with('success', 'Data Guru dihapus!');
    }

    // --- 4. DATA SISWA (Input Siswa + Otomatis Akun Ortu) ---
    public function indexStudent() {
        $data = Student::with('classroom')->get();
        $classrooms = Classroom::all();
        return view('admin.student', compact('data', 'classrooms'));
    }
    public function storeStudent(Request $request) {
        $request->validate(['student_name' => 'required', 'nisn' => 'required|unique:students', 'classroom_id' => 'required']);
        
        // Buat akun Orang Tua (Username login pake NISN anak)
        $user = User::create([
            'username' => 'ortu_'.$request->nisn,
            'password' => Hash::make('123456'), // Password default ortu
            'role' => 'orang_tua'
        ]);

        Student::create([
            'classroom_id' => $request->classroom_id,
            'parent_id' => $user->id,
            'student_name' => $request->student_name,
            'nisn' => $request->nisn
        ]);

        return back()->with('success', 'Siswa berhasil didaftarkan!');
    }
    public function deleteStudent($id) {
        $student = Student::findOrFail($id);
        User::destroy($student->parent_id);
        $student->delete();
        return back()->with('success', 'Data Siswa dihapus!');
    }

    // --- 5. PLOTTING GURU (Assign Guru ke Kelas & Mapel) ---
    public function indexAssignment() {
        $data = TeacherAssignment::with(['teacher', 'classroom', 'subject'])->get();
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view('admin.assignment', compact('data', 'teachers', 'classrooms', 'subjects'));
    }
    public function storeAssignment(Request $request) {
        TeacherAssignment::create($request->all());
        return back()->with('success', 'Plotting Guru berhasil!');
    }
    public function deleteAssignment($id) {
        TeacherAssignment::destroy($id);
        return back()->with('success', 'Plotting dihapus!');
    }
}