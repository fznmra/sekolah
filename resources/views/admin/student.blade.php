@extends('layouts.main')

@section('title', 'Data Siswa')

@section('content')

<div class="row">
<!-- Kolom Kiri: Form Tambah Siswa -->
<div class="col-md-4">
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Tambah Siswa Baru</h6>
</div>
<div class="card-body">
<form action="{{ route('admin.siswa.store') }}" method="POST">
@csrf

                <div class="form-group">
                    <label>Nama Lengkap Siswa</label>
                    <input type="text" name="student_name" class="form-control" placeholder="Masukkan nama siswa" required>
                </div>

                <div class="form-group">
                    <label>NISN (Akan jadi ID Login Ortu)</label>
                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan nomor NISN" required>
                </div>

                <div class="form-group">
                    <label>Pilih Kelas</label>
                    <select name="classroom_id" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classrooms as $cls)
                            <option value="{{ $cls->id }}">{{ $cls->class_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="alert alert-info small">
                    <i class="fas fa-info-circle"></i> Password default untuk akun Orang Tua adalah: <strong>123456</strong>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Daftarkan Siswa</button>
            </form>
        </div>
    </div>
</div>

<!-- Kolom Kanan: Tabel Daftar Siswa -->
<div class="col-md-8">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Seluruh Siswa</h6>
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

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->nisn }}</td>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->classroom->class_name ?? 'Tanpa Kelas' }}</td>
                            <td>
                                <form action="{{ route('admin.siswa.delete', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa dan akun orang tuanya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
@endsection