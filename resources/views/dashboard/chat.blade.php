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

        .admin .profile-picture {
            background-color: #354e33;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 100px;
        }

        .admin .profile-picture img {
            width: 20px;
            object-fit: contain;
        }

        .chat-bubble.admin {
            background-color: #354e33;
            color: white;
            margin-left: auto;
            align-self: flex-end;
        }

        .chat-bubble.admin h5 {
            color: #354e33;
        }

        .user img {
            width: 40px;
            height: 40px;
            border-radius: 100px;
            object-fit: contain;
        }

        @media (min-width: 992px) {
            .h-lg-90 {
                height: 90% !important;
            }
        }

        /* Container Chatadmin styling */
        .chat-window {
            padding: 15px;
            height: 400px;
            border-radius: 10px;
            background-color: white;
            font-size: 16px;
        }

        .chat-window .chat {
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* Chat bubble styling */
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 15px;
            margin: 5px 0;
            /* Mengatur margin untuk jarak antar chat */
            max-width: 80%;
            display: inline-block;
        }

        .chat-bubble.user {
            background-color: #E1EBE2;
            color: #354e33;
            margin-right: auto;
            align-self: flex-start;
        }

        .chat-bubble.user h5 {
            color: #354e33;
        }

        /* Chatadmin styling Start */
        .chat-input {
            display: flex;
            padding-top: 10px;
        }

        .chat-input input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #354e33;
            border-radius: 5px;
            margin-right: 10px;
        }

        .chat-input button {
            background-color: #354e33;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #2E452C;
        }

        @media (max-width: 1024px) {

            /* Tablet ke bawah */
            .chatadmin {
                margin-top: 140px;
            }

            .chat-window {
                height: 600px;
            }
        }

        @media (min-width: 1024px) {

            .tab-content {
                height: 100% !important;
            }
        }

        /* Chatadmin styling End */
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
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
                        <h5 class="mb-0">{{ $active }}</h5>

                        <div class="avatar avatar-online">
                            <img src="{{ asset('../storage/' . auth()->user()->profile_picture) }}" alt class="w-px-40 rounded-circle object-fit-cover" />
                        </div>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl d-flex flex-column flex-lg-row gap-4 flex-grow-1 container-p-y" style="height: 90vh;">
                        <div class="card w-25 h-100 overflow-auto d-none d-lg-block">
                            <ul class="nav nav-pills flex-column" id="customer-tabs" role="tablist">
                                @foreach ($users as $user)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex align-items-center justify-content-start gap-4 py-3" href="{{ route('chat', ['user' => $user->id]) }}" style="transition: background-color 0.3s, color 0.3s;">
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                        <p class="mb-0 text-truncate" style="max-width: 95px !important"><span>@</span>{{ $user->username }}</p>
                                        @if($lastMessagesFromUsers[$user->id] ?? false)
                                        <div class="rounded-circle bg-danger ms-auto" style="width: 10px; height: 10px;"></div>
                                        @endif
                                    </a>
                                </li>
                                <style>
                                    .nav-link {
                                        border-left: 5px solid #ffffff00 !important;
                                    }

                                    .nav-link:hover {
                                        background-color: rgba(67, 89, 113, 0.04) !important;
                                        color: #454545 !important;
                                        border-left: 5px solid #354e33 !important;
                                    }

                                    .nav-link.active {
                                        background-color: rgba(53, 78, 51, 0.1) !important;
                                        color: #454545 !important;
                                        border-left: 5px solid #354e33 !important;
                                    }

                                    .nav-pills .nav-link.active,
                                    .nav-pills .nav-link.active:hover,
                                    .nav-pills .nav-link.active:focus {
                                        box-shadow: none;
                                    }
                                </style>
                                @endforeach
                            </ul>
                        </div>

                        <div class="w-100 d-block d-lg-none">
                            <select id="customer-select" class="form-select w-100" onchange="location.href=this.value;">
                                <option value="" selected disabled>Pilih pengguna untuk memulai chat</option>
                                @foreach ($users as $user)
                                <option value="{{ route('chat', ['user' => $user->id]) }}"><span>@</span>{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Chat Section -->
                        <div class="tab-content w-100 w-lg-75 h-75 p-0 flex-grow-1" id="customer-chats">
                            <div class="tab-pane fade show active h-100" id="default-chat" role="tabpanel">
                                <div class="card p-3 h-100 d-flex flex-column">
                                    <div class="chat-window d-flex flex-column flex-grow-1 overflow-auto">
                                        <div class="chat h-100 d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('images/dashboard/hero-dashboard.png') }}" style="max-height: 275px;" class="mb-4" />
                                            <p class="text-muted">Pilih pengguna untuk memulai percakapan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <script>
        document.getElementById('customer-select').addEventListener('change', function() {
            let selectedChat = this.value;

            // Menonaktifkan semua tab
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('show', 'active');
            });

            // Mengaktifkan tab yang dipilih dari dropdown
            document.getElementById(selectedChat).classList.add('show', 'active');
        });
    </script>

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