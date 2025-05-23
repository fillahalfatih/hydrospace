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
                        <h5 class="mb-0">Tambah Data Admin</h5>

                        <div class="avatar avatar-online">
                            <img src="{{ asset('../storage/' . auth()->user()->profile_picture) }}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <a href="javascript:history.back()" class="btn btn-primary">
                            <i class="bx bx-arrow-back me-2"></i>Kembali
                        </a>
                        <div class="authentication-wrapper authentication-basic container-p-y">
                            <div class="authentication-inner" style="max-width: 100%;">
                                <!-- Create Profile -->
                                <div class="card">
                                    <div class="card-body">
                                        <form id="formAuthentication" class="mb-3" action="/dashboard/admins" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="role" value="Admin">

                                            <div class="col d-flex flex-column w-75 mx-auto">
                                                <img id="profileImagePreview" src="{{ asset('assets/img/avatars/1.png') }}" alt="" class="rounded-circle mx-auto my-3" style="width: 140px; height: 140px; object-fit: cover;">
                                                <input type="file" name="profile_picture" id="profile_picture" class="form-control mx-auto @error('profile_picture') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                                                @error('profile_picture')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <div id="rulesProfileImage" class="form-text mb-4">Silakan unggah gambar profil dengan format file gambar (jpeg, png, jpg, gif) dan ukuran maksimum 5 MB</div>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-lg-6">
                                                    <label for="username" class="form-label @error('username') is-invalid @enderror">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required value="{{ old('username') }}" autofocus />
                                                    @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}" />
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-lg-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" required value="{{ old('email') }}" />
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" />
                                                    <div id="rulesPassword" class="form-text">Password harus memiliki panjang antara 3-8 karakter</div>
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="row g-2 mb-3">
                                                    <div class="col-lg-6">
                                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input name="gender" class="form-check-input" type="radio" value="Pria" id="Pria" {{ old('gender', 'Pria') == 'Pria' ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="Pria"> Pria </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input name="gender" class="form-check-input" type="radio" value="Wanita" id="Wanita" {{ old('gender', 'Pria') == 'Wanita' ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="Wanita"> Wanita </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="phone_number" class="form-label">Nomor Handphone</label>
                                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Cth: 081234567890" required value="{{ old('phone_number') }}" />
                                                        @error('phone_number')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary d-grid w-100" type="submit">Konfirmasi</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /Create Profile -->
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

    <script>
        // Menampilkan Preview Profile Image
        function previewImage(event) {
            var reader = new FileReader(); // Create FileReader object

            reader.onload = function() {
                var output = document.getElementById('profileImagePreview'); // Get the image preview element
                output.src = reader.result; // Set the src attribute with the file's data
            };

            reader.readAsDataURL(event.target.files[0]); // Read the file as a data URL
        }
    </script>
</body>

</html>