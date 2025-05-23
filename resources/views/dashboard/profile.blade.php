<!DOCTYPE html>
<html lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('images/icon.webp') }}" type="image/gif" sizes="16x16">
    <meta name="description" content="" />

    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" /> --}}
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('layouts/dashboard/css/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('layouts/dashboard/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('layouts/dashboard/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('layouts/dashboard/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('layouts/dashboard/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('layouts/dashboard/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('layouts/dashboard/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('layouts/dashboard/js/config.js') }}"></script>

    <style>
        .bg-menu-theme .menu-inner>.menu-item.active>.menu-link {
            background-color: rgba(53, 78, 51, 0.16) !important;
            color: #354e33;
        }

        .bg-menu-theme .menu-inner>.menu-item.active:before {
            background-color: #354e33;
        }

        .app-brand .layout-menu-toggle {
            background-color: #354e33 !important;
        }

        .form-check-input:disabled {
            opacity: 1;
        }

        .form-check-input[disabled]~.form-check-label,
        .form-check-input:disabled~.form-check-label {
            opacity: 1;
        }

        img.profile_picture {
            width: 175px;
            height: 175px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('partials.sidebar-dashboard')

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
                        <h5 class="mb-0">Profil Admin</h5>

                        <div class="avatar avatar-online">
                            <img src="{{ asset('../storage/' . auth()->user()->profile_picture) }}" alt class="w-px-40 rounded-circle object-fit-cover" />
                        </div>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-12 mb-4 order-0">
                                <div class="card h-100 d-flex align-items-center justify-content-center">

                                    @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show col-lg-11 my-4 mx-4" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <div class="d-flex align-items-center row">
                                        <div class="col-sm-4 text-center">
                                            <div class="card-body px-0 px-md-4">
                                                <img src="{{ asset('../storage/' . $admin->profile_picture) }}" height="175" class="profile_picture rounded-circle" />
                                            </div>
                                            <div class="d-flex pb-4 gap-2 justify-content-center">
                                                <form action="/dashboard/profile/{{ auth()->user()->username }}" method="post" class="ms-2">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" onclick="return confirm('Apakah kamu yakin akan menghapus akun kamu?')">
                                                        <i class="bx bx-trash me-2"></i>
                                                        <div data-i18n="Delete Account">Hapus Akun</div>
                                                    </button>
                                                </form>                                                
                                                <a href="/dashboard/profile/{{ auth()->user()->username }}/edit" class="btn btn-primary"><i class="bx bx-edit me-2"></i>Edit Akun</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" class="form-control disabled" id="username" name="username" value="{{ $admin->username }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $admin->name }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="phone" class="form-label">No. HP</label>
                                                            <input type="phone" class="form-control" id="phone" name="phone" value="{{ $admin->phone_number }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="gender" class="form-label">Jenis Kelamin</label>
                                                            <input type="text" class="form-control" id="gender" name="gender" value="{{ $admin->gender }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="date_joined" class="form-label">Tanggal Bergabung</label>
                                                            <input type="text" class="form-control" id="date_joined" name="date_joined" value="{{ $admin->created_at->format('d/m/Y') }}" readonly>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('layouts/dashboard/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('layouts/dashboard/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('layouts/dashboard/js/bootstrap.js') }}"></script>
    <script src="{{ asset('layouts/dashboard/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('layouts/dashboard/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('layouts/dashboard/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('layouts/dashboard/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('layouts/dashboard/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>