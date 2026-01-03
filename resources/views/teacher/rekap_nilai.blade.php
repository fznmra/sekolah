@extends('layouts.main')

@section('title', 'Dashboard Rekap Nilai')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rekap Nilai: {{ $assignment->subject->subject_name }} ({{ $assignment->classroom->class_name }})</h1>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Predikat Nilai Murid</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>NISN</th>
                                <th>Nama Murid</th>
                                <th>Rata-rata Skor</th>
                                <th>Predikat (Huruf)</th>
                                <th>Status Kelulusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekap as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item['nisn'] }}</td>
                                <td><strong>{{ $item['name'] }}</strong></td>
                                <td class="text-center">{{ $item['average'] }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item['color'] }} px-4 py-2" style="font-size: 1rem;">
                                        {{ $item['letter'] }}
                                    </span>
                                </td>
                                <td class="text-center text-uppercase font-weight-bold">
                                    @if($item['letter'] == 'D')
                                        <span class="text-danger">Perlu Remedial</span>
                                    @else
                                        <span class="text-success">Lulus</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-body font-italic small">
                <strong>Ketentuan Penilaian:</strong><br>
                - A (Sangat Baik): 85 - 100<br>
                - B (Baik): 75 - 84<br>
                - C (Cukup): 60 - 74<br>
                - D (Kurang): < 60
            </div>
        </div>
    </div>
</div>
@endsection