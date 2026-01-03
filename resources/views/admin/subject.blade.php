@extends('layouts.main')

@section('title', 'Data Mata Pelajaran')

@section('content')

<div class="row">
<!-- Kolom Kiri: Form Tambah Mapel -->
<div class="col-md-4">
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Tambah Mata Pelajaran</h6>
</div>
<div class="card-body">
<form action="{{ route('admin.mapel.store') }}" method="POST">
@csrf
<div class="form-group">
<label>Nama Mata Pelajaran</label>
<input type="text" name="subject_name" class="form-control" placeholder="Contoh: Matematika" required>
</div>
<button type="submit" class="btn btn-primary btn-block">Simpan Mapel</button>
</form>
</div>
</div>
</div>

<!-- Kolom Kanan: Tabel Daftar Mapel -->
<div class="col-md-8">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Seluruh Mata Pelajaran</h6>
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
                            <th>Nama Mata Pelajaran</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $sub)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sub->subject_name }}</td>
                            <td>
                                <form action="{{ route('admin.mapel.delete', $sub->id) }}" method="POST" onsubmit="return confirm('Hapus Mata Pelajaran ini?')">
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
                            <td colspan="3" class="text-center text-gray-500">Belum ada data mata pelajaran.</td>
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