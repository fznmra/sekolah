@php
    // Inisialisasi nama default menggunakan username
    $displayName = auth()->user()->username;

    // Logika jika yang login adalah GURU
    if (auth()->user()->role == 'guru') {
        $teacher = \App\Models\Teacher::where('user_id', auth()->id())->first();
        $displayName = $teacher ? $teacher->teacher_name : auth()->user()->username;
    } 
    // Logika jika yang login adalah ORANG TUA
    elseif (auth()->user()->role == 'orang_tua') {
        $children = \App\Models\Student::where('parent_id', auth()->id())->pluck('student_name')->toArray();
        if (count($children) > 0) {
            // Menggabungkan nama anak jika lebih dari satu, misal: Ortu: Andi, Budi
            $displayName = "Wali dari: " . implode(', ', $children);
        } else {
            $displayName = "Orang Tua";
        }
    }
@endphp

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ $displayName }} 
                    <span class="badge badge-primary ml-1 text-uppercase" style="font-size: 0.65rem;">
                        {{ auth()->user()->role }}
                    </span>
                </span>
                <img class="img-profile rounded-circle"
                    src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=random">
            </a>
            
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil Saya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar Aplikasi
                </a>
            </div>
        </li>

    </ul>

</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Keluar" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>