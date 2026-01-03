@extends('layouts.main')

@section('title', 'Monitoring Kehadiran Anak')

@section('content')
<div class="row">
    <!-- Ringkasan Data Anak -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Anak</div>
                        @foreach($children as $child)
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $child->student_name }}</div>
                            <div class="text-muted small">NISN: {{ $child->nisn }}</div>
                            <div class="text-muted small">Kelas: {{ $child->classroom->class_name ?? '-' }}</div>
                            <hr>
                        @endforeach
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-child fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Rekap Kehadiran -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Kehadiran Harian</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Nama Anak</th>
                        <th>Mata Pelajaran</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->attendance_date)->format('d F Y') }}</td>
                        <td>{{ $row->student->student_name }}</td>
                        <td>{{ $row->subject_name }}</td>
                        <td class="text-center">
                            @if($row->status == 'H')
                                <span class="badge badge-success px-3">Hadir</span>
                            @elseif($row->status == 'S')
                                <span class="badge badge-warning px-3">Sakit</span>
                            @elseif($row->status == 'I')
                                <span class="badge badge-info px-3">Izin</span>
                            @else
                                <span class="badge badge-danger px-3">Alpa</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500">Belum ada data kehadiran untuk anak Anda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection