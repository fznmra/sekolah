@extends('layouts.main')
@section('title', 'Data Guru')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Guru</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.guru.store') }}" method="POST">
                    @csrf
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="teacher_name" class="form-control" required></div>
                    <div class="form-group"><label>NIP (Akan jadi Username Login)</label><input type="text" name="nip" class="form-control" required></div>
                    <div class="form-group"><label>Password Login</label><input type="password" name="password" class="form-control" required></div>
                    <button type="submit" class="btn btn-primary btn-block">Daftarkan Guru</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>No</th><th>NIP</th><th>Nama</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($data as $i => $row)
                        <tr><td>{{ $i+1 }}</td><td>{{ $row->nip }}</td><td>{{ $row->teacher_name }}</td>
                            <td><form action="{{ route('admin.guru.delete', $row->id) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Hapus</button></form></td>
                        </tr>@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection