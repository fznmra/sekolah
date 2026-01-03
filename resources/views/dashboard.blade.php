@extends('layouts.main')

@section('title', 'Beranda Utama')

@section('content')
<!-- Welcome Banner Modern -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white shadow border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold">
                            Selamat Datang, 
                            @if(auth()->user()->role == 'guru') Pak/Bu @elseif(auth()->user()->role == 'orang_tua') Wali dari @endif 
                            {{ $displayName }}! 👋
                        </h2>
                        <p class="lead mb-0 opacity-75">
                            Anda login sebagai <strong>{{ strtoupper(auth()->user()->role) }}</strong>. 
                            Pantau dan kelola data akademik dengan mudah di sini.
                        </p>
                    </div>
                    <div class="col-md-4 text-right d-none d-md-block">
                        <i class="fas fa-university fa-5x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Statistik Sekolah -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Murid</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-graduate fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_guru }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kelas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_kelas }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-door-open fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Mata Pelajaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_mapel }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-book fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Konten Dinamis -->
    <div class="col-lg-8">
        @if(auth()->user()->role == 'guru')
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Mengajar Anda</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($my_assignments as $assign)
                            <tr>
                                <td><strong>{{ $assign->subject->subject_name }}</strong></td>
                                <td>Kelas {{ $assign->classroom->class_name }}</td>
                                <td>
                                    <a href="{{ route('teacher.absen', $assign->id) }}" class="btn btn-sm btn-primary rounded-pill">Input Absen</a>
                                    <a href="{{ route('teacher.nilai', $assign->id) }}" class="btn btn-sm btn-outline-info rounded-pill ml-1">Input Nilai</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4">Anda belum mendapatkan jadwal mengajar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->role == 'orang_tua')
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bell mr-2"></i>Laporan Kehadiran Anak Hari Ini</h6>
            </div>
            <div class="card-body">
                @forelse($today_attendance as $att)
                <div class="d-flex align-items-center p-3 mb-2 border rounded bg-light">
                    <div class="mr-3">
                        @if($att->status == 'H')
                            <div class="icon-circle bg-success text-white"><i class="fas fa-check"></i></div>
                        @else
                            <div class="icon-circle bg-danger text-white"><i class="fas fa-times"></i></div>
                        @endif
                    </div>
                    <div>
                        <div class="small text-muted">{{ $att->subject_name }}</div>
                        <span class="font-weight-bold text-dark">{{ $att->student->student_name }}</span> 
                        dinyatakan 
                        <span class="badge badge-{{ $att->status == 'H' ? 'success' : 'danger' }}">
                            {{ $att->status == 'H' ? 'Hadir' : 'Tidak Hadir' }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <img src="https://ui-avatars.com/api/?name=Empty&background=f8f9fc&color=d1d3e2" class="mb-3 rounded-circle" width="80">
                    <p class="text-muted">Belum ada data absensi untuk anak Anda hari ini.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endif

        @if(auth()->user()->role == 'admin')
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-tools fa-4x text-gray-200 mb-4"></i>
                <h5 class="text-dark font-weight-bold">Mode Administrator Aktif</h5>
                <p class="text-muted px-lg-5">Gunakan menu di samping untuk mengelola Master Data Guru, Siswa, dan Kelas. Pastikan data Plotting Guru sudah sesuai dengan jadwal pelajaran sekolah.</p>
                <a href="{{ route('admin.guru') }}" class="btn btn-primary px-4 shadow-sm">Kelola Data Guru</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Mading & Waktu -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-body text-center bg-light rounded shadow-inner">
                <h1 class="display-3 font-weight-bold text-primary mb-0">{{ date('d') }}</h1>
                <div class="text-uppercase font-weight-bold text-muted">{{ date('F Y') }}</div>
                <div class="h5 mt-2 text-dark">{{ date('l') }}</div>
                <div class="badge badge-primary px-3 py-2 mt-2" id="clock">00:00:00</div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase small">Mading Sekolah</h6>
            </div>
            <div class="card-body small">
                <div class="mb-3 border-left-info pl-3">
                    <div class="font-weight-bold text-info">Ujian Tengah Semester</div>
                    <div class="text-muted small">Mulai tanggal 15 Maret 2026. Mohon persiapkan perangkat ajar.</div>
                </div>
                <div class="mb-3 border-left-warning pl-3">
                    <div class="font-weight-bold text-warning">Rapat Guru</div>
                    <div class="text-muted small">Sabtu depan di Ruang Guru lantai 2. Agenda: Kurikulum baru.</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ":" + 
                     now.getMinutes().toString().padStart(2, '0') + ":" + 
                     now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock').innerText = time;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endpush
@endsection