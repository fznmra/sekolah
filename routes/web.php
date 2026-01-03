<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - SISFO AKADEMIK
|--------------------------------------------------------------------------
*/

// --- AKSES LOGIN (Hanya untuk Guest/Belum Login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

// --- AKSES SETELAH LOGIN (Memerlukan Autentikasi) ---
Route::middleware(['auth'])->group(function () {

    // Dashboard Utama (Melewati DashboardController untuk Statistik)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Proses Keluar (Logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- KELOMPOK FITUR ADMIN (MASTER DATA) ---
    // 1. Manajemen Kelas
    Route::get('/admin/kelas', [AdminController::class, 'indexClassroom'])->name('admin.kelas');
    Route::post('/admin/kelas', [AdminController::class, 'storeClassroom'])->name('admin.kelas.store');
    Route::delete('/admin/kelas/{id}', [AdminController::class, 'deleteClassroom'])->name('admin.kelas.delete');

    // 2. Manajemen Mata Pelajaran
    Route::get('/admin/mapel', [AdminController::class, 'indexSubject'])->name('admin.mapel');
    Route::post('/admin/mapel', [AdminController::class, 'storeSubject'])->name('admin.mapel.store');
    Route::delete('/admin/mapel/{id}', [AdminController::class, 'deleteSubject'])->name('admin.mapel.delete');

    // 3. Manajemen Guru (Input Guru & Akun)
    Route::get('/admin/guru', [AdminController::class, 'indexTeacher'])->name('admin.guru');
    Route::post('/admin/guru', [AdminController::class, 'storeTeacher'])->name('admin.guru.store');
    Route::delete('/admin/guru/{id}', [AdminController::class, 'deleteTeacher'])->name('admin.guru.delete');

    // 4. Manajemen Siswa (Input Siswa & Akun Ortu)
    Route::get('/admin/siswa', [AdminController::class, 'indexStudent'])->name('admin.siswa');
    Route::post('/admin/siswa', [AdminController::class, 'storeStudent'])->name('admin.siswa.store');
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'deleteStudent'])->name('admin.siswa.delete');

    // 5. Plotting Guru (Penugasan Mengajar)
    Route::get('/admin/plotting', [AdminController::class, 'indexAssignment'])->name('admin.plotting');
    Route::post('/admin/plotting', [AdminController::class, 'storeAssignment'])->name('admin.plotting.store');
    Route::delete('/admin/plotting/{id}', [AdminController::class, 'deleteAssignment'])->name('admin.plotting.delete');


    // --- KELOMPOK FITUR GURU (ABSENSI & NILAI) ---
    // Input Absensi
    Route::get('/teacher/absensi/{assignment_id}', [TeacherController::class, 'inputAbsen'])->name('teacher.absen');
    Route::post('/teacher/absensi/simpan', [TeacherController::class, 'simpanAbsen'])->name('teacher.absen.simpan');

    // Input Nilai (Mode Grid)
    Route::get('/teacher/nilai/{assignment_id}', [TeacherController::class, 'inputNilai'])->name('teacher.nilai');
    Route::post('/teacher/nilai/simpan', [TeacherController::class, 'simpanNilai'])->name('teacher.nilai.simpan');

    // Rekap Nilai (Predikat ABC)
    Route::get('/teacher/rekap-nilai/{assignment_id}', [TeacherController::class, 'rekapNilai'])->name('teacher.rekap');


    // --- KELOMPOK FITUR ORANG TUA (MONITORING) ---
    // Monitoring Kehadiran Anak
    Route::get('/parent/monitoring', [ParentController::class, 'index'])->name('parent.monitoring');

});