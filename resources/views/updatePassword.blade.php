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


  <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/styleProfile.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
  <!-- color scheme -->
  <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">

  <style>
    .form-control:disabled {
      color: #354e33;
      background-color: #fff;
      opacity: 1;
    }

    .form-select:disabled {
      color: #354e33;
      background-color: #fff;
    }

    .form-check-input[disabled]~.form-check-label,
    .form-check-input:disabled~.form-check-label {
      opacity: 1;
    }

    .form-check-input:disabled {
      opacity: 1;
    }

    .bg-menu-theme .menu-inner>.menu-item.active>.menu-link {
      background-color: rgba(53, 78, 51, 0.16) !important;
      color: #354e33;
    }

    .bg-menu-theme .menu-inner>.menu-item.active:before {
      background-color: #354e33;
    }

    .app-brand {
      align-items: start;
      gap: 16px;
    }

    .menu .app-brand.demo {
      height: auto;
    }

    .app-brand .layout-menu-toggle {
      background-color: #354e33 !important;
    }

    .back-link {
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 500px;
      color: white;
      text-decoration: none;
      font-size: 24px;
      border: 2px solid #354e33;
      transition: background 0.3s;
    }

    .back-link:hover {
      background-color: rgb(222, 222, 222);
    }

    .back-link i {
      font-size: 24px;
      color: #354e33;
    }
  </style>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      {{-- navbar --}}
      @include('partials.sidebarProfile')
      {{-- navbar end --}}

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav
          class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme d-xl-none"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right w-100 d-flex justify-content-between align-items-center" id="navbar-collapse">
            <h5 class="mb-0">Hai, {{ auth()->user()->username }}!</h5>

            <div class="avatar avatar">
              <img src="{{ asset('../storage/' . auth()->user()->profile_picture) }}" alt class="w-px-40 my-auto rounded-circle object-fit-cover" />
            </div>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container col-12 col-lg-8 mx-auto mx-lg-0 container-p-y mt-lg-5 mt-1">
            {{-- navbar --}}
            @include('partials.navbarProfile')
            {{-- navbar end --}}

            <h3 class="fw-bold mt-lg-5">{{ $active }}</h3>
            <p class="mb-4">Masukkan password lama dan password baru untuk memperbarui password kamu</p>

            @if(session()->has('false'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
              {{ session('false') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form id="formAuthentication" class="mb-3" action="/update-password/{{ auth()->user()->username }}" method="POST">
              @method('put')
              @csrf
              <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Masukkan password lama" required />
                @error('current_password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru" required />
                <div id="rulesPassword" class="form-text">Password harus memiliki panjang antara 3-8 karakter</div>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru" required />
                @error('confirm_password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="d-flex">
                <button class="btn btn-primary d-grid w-100" type="submit" onclick="return confirm('Apakah kamu yakin akan mengubah password kamu? Jika iya kamu akan diarahkan ke halaman Login untuk masuk kembali')">Konfirmasi</button>
              </div>
            </form>
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

  <!-- Javascript Files
    ================================================== -->
  <script src="{{ asset('js/plugins.js') }}"></script>
</body>

</html>