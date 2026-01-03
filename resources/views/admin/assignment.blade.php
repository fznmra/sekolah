@extends('layouts.main')
@section('title', 'Plotting Guru')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tambah Plotting</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.plotting.store') }}" method="POST">
                    @csrf
                    <div class="form-group"><label>Pilih Guru</label>
                        <select name="teacher_id" class="form-control">@foreach($teachers as $t)<option value="{{$t->id}}">{{$t->teacher_name}}</option>@endforeach</select>
                    </div>
                    <div class="form-group"><label>Pilih Kelas</label>
                        <select name="classroom_id" class="form-control">@foreach($classrooms as $c)<option value="{{$c->id}}">{{$c->class_name}}</option>@endforeach</select>
                    </div>
                    <div class="form-group"><label>Pilih Mapel</label>
                        <select name="subject_id" class="form-control">@foreach($subjects as $s)<option value="{{$s->id}}">{{$s->subject_name}}</option>@endforeach</select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Simpan Plotting</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Data Plotting Mengajar</h6></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>Guru</th><th>Kelas</th><th>Mapel</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ $row->teacher->teacher_name }}</td><td>{{ $row->classroom->class_name }}</td><td>{{ $row->subject->subject_name }}</td>
                            <td><form action="{{ route('admin.plotting.delete', $row->id) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Hapus</button></form></td>
                        </tr>@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection