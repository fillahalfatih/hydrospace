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
            <form id="formAuthentication" class="mb-3" action="/profil/{{ auth()->user()->username }}" method="post" enctype="multipart/form-data">
              @method('put')
              @csrf
              <div class="col d-flex flex-column w-75 mb-3 mx-auto mx-lg-0">
                <img id="profileImagePreview" src="{{ asset('../storage/' . $customer->profile_picture) }}" alt="" class="rounded-circle mx-auto mx-lg-0 mb-3" style="width: 140px; height: 140px; object-fit: cover;">
                <input type="file" name="profile_picture" id="profile_picture" class="form-control mx-auto @error('profile_picture') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                @error('profile_picture')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
                <div id="rulesProfileImage" class="form-text">Silakan unggah gambar profil dengan format file gambar (jpeg, png, jpg, gif) dan ukuran maksimum 5 MB</div>
              </div>
              <div class="row g-2 mb-3">
                <div class="col-lg-6">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email', $customer->email) }}"
                    required
                    autofocus />
                  @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-lg-6">
                  <label for="username" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    value="{{ old('username', $customer->username) }}"
                    placeholder="Masukkan username"
                    required />
                  @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="row g-2 mb-3">
                <div class="col-lg-6">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input
                    type="text"
                    class="form-control @error('username') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
                    placeholder="Masukkan nama lengkap"
                    required />
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="col-lg-3">
                  <label for="gender" class="form-label">Jenis Kelamin</label>
                  <div class="d-flex gap-3">
                    <div class="form-check">
                      <input
                        name="gender"
                        class="form-check-input"
                        type="radio"
                        value="Pria"
                        id="Pria"
                        {{ old('gender', $customer->gender) == 'Pria' ? 'checked' : '' }} />
                      <label class="form-check-label" for="Pria"> Pria </label>
                    </div>
                    <div class="form-check">
                      <input
                        name="gender"
                        class="form-check-input"
                        type="radio"
                        value="Wanita"
                        id="Wanita"
                        {{ old('gender', $customer->gender) == 'Wanita' ? 'checked' : '' }} />
                      <label class="form-check-label" for="Wanita"> Wanita </label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <label for="phone_number" class="form-label">Nomor Handphone</label>
                  <input
                    type="number"
                    class="form-control @error('phone_number') is-invalid @enderror"
                    id="phone_number"
                    name="phone_number"
                    value="{{ old('phone_number', $customer->phone_number) }}"
                    placeholder="Cth: 081234567890"
                    required />
                  @error('phone_number')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
              <div class="address">
                <div class="row g-3 mb-3">
                  <div class="col-lg-6">
                    <label for="province" class="form-label">Provinsi</label>
                    <select class="form-select @error('province') is-invalid @enderror" id="province" name="province" onchange="loadCities(this.value)">
                      <option selected disabled>Pilih Provinsi</option>
                      @foreach ($provinces as $province)
                      <option value="{{ $province->id }}" {{ old('province', $customer->province) == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('province')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-lg-6">
                    <label for="city" class="form-label">Kota</label>
                    <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" onchange="loadDistricts(this.value)">
                      <option selected disabled>Pilih Kota</option>
                      @foreach ($cities as $city)
                      <option value="{{ $city->id }}" {{ old('city', $customer->city) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('city')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row g-3 mb-3">
                  <div class="col-lg-6">
                    <label for="district" class="form-label">Kecamatan</label>
                    <select class="form-select @error('district') is-invalid @enderror" id="district" name="district" onchange="loadVillages(this.value)">
                      <option selected disabled>Pilih Kecamatan</option>
                      @foreach ($districts as $district)
                      <option value="{{ $district->id }}" {{ old('district', $customer->district) == $district->id ? 'selected' : '' }}>
                        {{ $district->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('district')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-lg-6">
                    <label for="village" class="form-label">Kelurahan</label>
                    <select class="form-select @error('village') is-invalid @enderror" id="village" name="village">
                      <option selected disabled>Pilih Kelurahan</option>
                      @foreach ($villages as $village)
                      <option value="{{ $village->id }}" {{ old('village', $customer->village) == $village->id ? 'selected' : '' }}>
                        {{ $village->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('village')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label for="full_address" class="form-label">Alamat Lengkap</label>
                  <textarea class="form-control" id="full_address" name="full_address" rows="3" style="min-height: 200px;" placeholder="Masukkan alamat lengkap Anda, termasuk patokan, gang, nomor rumah, hingga link Google Maps jika tersedia. 
Contoh: Jl. Merdeka No. 10, Gang Mawar, RT 02 RW 01, Kelurahan Harmoni, Kota Bogor. Dekat Indomaret, seberang Masjid Al-Falah (https://maps.app.goo.gl/xyz123)" required>{{ old('full_address', $customer->full_address) }}</textarea>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit" onclick="return confirm('Apakah kamu yakin akan mengubah profil Kamu?')">Simpan Perubahan</button>
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
  <!-- <script src="{{ asset('js/designesia.js') }}"></script> -->

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

    function loadCities(provinceId) {
      // Reset Kota, Kecamatan, dan Kelurahan
      let citySelect = document.getElementById('city');
      let districtSelect = document.getElementById('district');
      let villageSelect = document.getElementById('village');

      citySelect.innerHTML = '<option selected disabled>Pilih Kota</option>';
      districtSelect.innerHTML = '<option selected disabled>Pilih Kecamatan</option>';
      villageSelect.innerHTML = '<option selected disabled>Pilih Kelurahan</option>';

      // Fetch data kota berdasarkan provinsi
      fetch(`/get-cities/${provinceId}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(city => {
            citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
          });
        })
        .catch(error => console.error('Error:', error));
    }

    function loadDistricts(cityId) {
      // Reset Kecamatan dan Kelurahan
      let districtSelect = document.getElementById('district');
      let villageSelect = document.getElementById('village');

      districtSelect.innerHTML = '<option selected disabled>Pilih Kecamatan</option>';
      villageSelect.innerHTML = '<option selected disabled>Pilih Kelurahan</option>';

      // Fetch data kecamatan berdasarkan kota
      fetch(`/get-districts/${cityId}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(district => {
            districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
          });
        })
        .catch(error => console.error('Error:', error));
    }

    function loadVillages(districtId) {
      // Reset Kelurahan
      let villageSelect = document.getElementById('village');
      villageSelect.innerHTML = '<option selected disabled>Pilih Kelurahan</option>';

      // Fetch data kelurahan berdasarkan kecamatan
      fetch(`/get-villages/${districtId}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(village => {
            villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
          });
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
</body>

</html>