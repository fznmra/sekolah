@extends('layouts.main')

@section('title', 'Input Nilai Siswa')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Input Nilai: {{ $assignment->subject->subject_name }} - {{ $assignment->classroom->class_name }}
        </h6>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Filter Kategori Nilai -->
        <form action="{{ route('teacher.nilai', $assignment->id) }}" method="GET" class="mb-4" id="formFilter">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="font-weight-bold">Kategori Nilai:</label>
                    <select name="category" class="form-control" onchange="document.getElementById('formFilter').submit();">
                        <option value="tugas" {{ $category == 'tugas' ? 'selected' : '' }}>Tugas / Nilai Harian</option>
                        <option value="mid" {{ $category == 'mid' ? 'selected' : '' }}>UTS (Ujian Tengah Semester)</option>
                        <option value="akhir" {{ $category == 'akhir' ? 'selected' : '' }}>UAS (Ujian Akhir Semester)</option>
                    </select>
                </div>
                <div class="col-md-8 text-right small text-muted">
                    *Nilai akan otomatis terisi jika sudah pernah diinput sebelumnya.
                </div>
            </div>
        </form>

        <form action="{{ route('teacher.nilai.simpan') }}" method="POST">
            @csrf
            
            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            <input type="hidden" name="subject_id" value="{{ $assignment->subject_id }}">
            <input type="hidden" name="category" value="{{ $category }}">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th class="text-center" width="200">Skor (0 - 100)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->nisn }}</td>
                            <td>{{ $student->student_name }}</td>
                            <td class="text-center">
                                <!-- Input Number dengan nilai lama jika ada -->
                                <input type="number" 
                                       name="score[{{ $student->id }}]" 
                                       class="form-control text-center mx-auto" 
                                       style="max-width: 100px;" 
                                       min="0" max="100" 
                                       value="{{ $existingGrades[$student->id] ?? '' }}" 
                                       placeholder="...">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada siswa di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success shadow-sm px-5">
                    <i class="fas fa-save mr-2"></i> Simpan / Perbarui Semua Nilai
                </button>
            </div>
        </form>
    </div>
</div>
@endsection