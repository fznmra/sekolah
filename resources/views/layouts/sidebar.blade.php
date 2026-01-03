<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand / Logo Sekolah -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SISFO AKADEMIK</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- ==========================================
         MENU KHUSUS ADMIN (MASTER DATA)
    =========================================== -->
    @if(auth()->user()->role == 'admin')
    <div class="sidebar-heading">Master Data Admin</div>

    <li class="nav-item {{ request()->is('admin/kelas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kelas') }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Kelas</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/mapel*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.mapel') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Mapel</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/guru*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.guru') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Data Guru</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/siswa*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.siswa') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('admin/plotting*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.plotting') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Plotting Guru</span>
        </a>
    </li>
    @endif


    <!-- ==========================================
         MENU KHUSUS GURU (AKADEMIK)
    =========================================== -->
    @if(auth()->user()->role == 'guru')
    <div class="sidebar-heading">Menu Akademik Guru</div>

    @php
        // Ambil data guru dan daftar kelas yang diajar
        $teacher = \App\Models\Teacher::where('user_id', auth()->id())->first();
        $my_classes = $teacher ? \App\Models\TeacherAssignment::where('teacher_id', $teacher->id)->with(['classroom', 'subject'])->get() : [];
    @endphp

    <!-- Dropdown Input Absensi -->
    <li class="nav-item {{ request()->is('teacher/absensi*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('teacher/absensi*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseAbsen">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Input Absensi</span>
        </a>
        <div id="collapseAbsen" class="collapse {{ request()->is('teacher/absensi*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Kelas:</h6>
                @forelse($my_classes as $cls)
                    <a class="collapse-item {{ request()->fullUrl() == route('teacher.absen', $cls->id) ? 'active' : '' }}" 
                       href="{{ route('teacher.absen', $cls->id) }}">
                        {{ $cls->classroom->class_name }} - {{ $cls->subject->subject_name }}
                    </a>
                @empty
                    <span class="collapse-item">Belum ada plotting</span>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Dropdown Input Nilai -->
    <li class="nav-item {{ request()->is('teacher/nilai*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('teacher/nilai*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseNilai">
            <i class="fas fa-fw fa-edit"></i>
            <span>Input Nilai</span>
        </a>
        <div id="collapseNilai" class="collapse {{ request()->is('teacher/nilai*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Kelas:</h6>
                @forelse($my_classes as $cls)
                    <a class="collapse-item {{ request()->fullUrl() == route('teacher.nilai', $cls->id) ? 'active' : '' }}" 
                       href="{{ route('teacher.nilai', $cls->id) }}">
                        {{ $cls->classroom->class_name }} - {{ $cls->subject->subject_name }}
                    </a>
                @empty
                    <span class="collapse-item">Belum ada plotting</span>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Dropdown Rekap Nilai (ABC) -->
    <li class="nav-item {{ request()->is('teacher/rekap-nilai*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('teacher/rekap-nilai*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseRekap">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Rekap Nilai (ABC)</span>
        </a>
        <div id="collapseRekap" class="collapse {{ request()->is('teacher/rekap-nilai*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Kelas:</h6>
                @forelse($my_classes as $cls)
                    <a class="collapse-item {{ request()->fullUrl() == route('teacher.rekap', $cls->id) ? 'active' : '' }}" 
                       href="{{ route('teacher.rekap', $cls->id) }}">
                        {{ $cls->classroom->class_name }} - {{ $cls->subject->subject_name }}
                    </a>
                @empty
                    <span class="collapse-item">Belum ada plotting</span>
                @endforelse
            </div>
        </div>
    </li>
    @endif


    <!-- ==========================================
         MENU KHUSUS ORANG TUA (MONITORING)
    =========================================== -->
    @if(auth()->user()->role == 'orang_tua')
    <div class="sidebar-heading">Menu Orang Tua</div>

    <li class="nav-item {{ request()->is('parent/monitoring*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('parent.monitoring') }}">
            <i class="fas fa-fw fa-eye"></i>
            <span>Monitoring Anak</span>
        </a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>