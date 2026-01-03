<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - SISFO AKADEMIK</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Background bertema sekolah menggunakan gambar lokal Anda */
        body.school-bg {
            background: linear-gradient(rgba(0, 78, 204, 0.7), rgba(0, 36, 91, 0.8)), 
                        url("{{ asset('gambar/sekolahhehe.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
        }

        .card-login {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            background-color: rgba(255, 255, 255, 0.95); /* Sedikit transparan agar terlihat modern */
        }

        .login-header-icon {
            font-size: 3rem;
            color: #4e73df;
            margin-bottom: 1rem;
        }

        /* Animasi halus saat hover pada tombol */
        .btn-user:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>
</head>

<body class="school-bg d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden shadow-lg my-5 card-login">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <div class="login-header-icon">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <h1 class="h4 text-gray-900 font-weight-bold mb-2">SISFO AKADEMIK</h1>
                                        <p class="text-muted mb-4 small">Selamat Datang! Silakan masuk ke akun Anda</p>
                                    </div>

                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('login.proses') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span>
                                                </div>
                                                <input type="text" name="username" class="form-control border-0 bg-light" placeholder="Username" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-primary"></i></span>
                                                </div>
                                                <input type="password" name="password" class="form-control border-0 bg-light" placeholder="Password" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block shadow-sm font-weight-bold">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk Ke Sistem
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <p class="mb-0 small text-muted font-italic">"Pendidikan adalah senjata paling ampuh untuk mengubah dunia."</p>
                                        <small class="text-primary font-weight-bold">Versi 1.0.0</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center text-white mt-2 small">
                    &copy; {{ date('Y') }} SISFO AKADEMIK - Semua Hak Dilindungi
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/sbadmin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>