@extends('layouts.main')

@section('title', 'Input Absensi')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Absensi: {{ $assignment->subject->subject_name }} - {{ $assignment->classroom->class_name }}
        </h6>
        <span class="badge badge-primary">Guru: {{ $teacher->teacher_name }}</span>
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

        <!-- Form Filter Tanggal -->
        <form action="{{ route('teacher.absen', $assignment->id) }}" method="GET" class="mb-4" id="formDate">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="font-weight-bold small">Pilih Tanggal Absen:</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="document.getElementById('formDate').submit()">
                </div>
                <div class="col-md-9 text-right small text-muted align-self-center">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Data yang sudah terisi akan otomatis terpilih. Anda dapat mengubah status kapan saja.
                </div>
            </div>
        </form>

        <form action="{{ route('teacher.absen.simpan') }}" method="POST">
            @csrf
            
            <input type="hidden" name="classroom_id" value="{{ $assignment->classroom_id }}">
            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            <input type="hidden" name="subject_name" value="{{ $assignment->subject->subject_name }}">
            <input type="hidden" name="attendance_date" value="{{ $date }}">

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center" width="300">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                        @php
                            // Cek apakah siswa sudah punya data absen di tanggal ini
                            $currentStatus = $existingAttendance[$student->id] ?? 'H'; // Default Hadir jika baru
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $student->student_name }}</div>
                                <div class="small text-muted">{{ $student->nisn }}</div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success btn-sm {{ $currentStatus == 'H' ? 'active' : '' }}" title="Hadir">
                                        <input type="radio" name="status[{{ $student->id }}]" value="H" {{ $currentStatus == 'H' ? 'checked' : '' }}> H
                                    </label>
                                    <label class="btn btn-outline-warning btn-sm {{ $currentStatus == 'S' ? 'active' : '' }}" title="Sakit">
                                        <input type="radio" name="status[{{ $student->id }}]" value="S" {{ $currentStatus == 'S' ? 'checked' : '' }}> S
                                    </label>
                                    <label class="btn btn-outline-info btn-sm {{ $currentStatus == 'I' ? 'active' : '' }}" title="Izin">
                                        <input type="radio" name="status[{{ $student->id }}]" value="I" {{ $currentStatus == 'I' ? 'checked' : '' }}> I
                                    </label>
                                    <label class="btn btn-outline-danger btn-sm {{ $currentStatus == 'A' ? 'active' : '' }}" title="Alpa">
                                        <input type="radio" name="status[{{ $student->id }}]" value="A" {{ $currentStatus == 'A' ? 'checked' : '' }}> A
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada siswa di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary shadow-sm px-4">
                    <i class="fas fa-save fa-sm mr-2"></i> Simpan / Perbarui Absensi
                </button>
                <span class="ml-3 small text-muted italic">*Mengklik simpan akan memperbarui data untuk tanggal <strong>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</strong></span>
            </div>
        </form>
    </div>
</div>
@endsection