<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ !empty($header_title) ? $header_title : 'My School' }}</title>
    @include('components.styles')
    @include('components.scripts')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('std/dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ route('logout') }}">
                        <i class="fa fa-sign-out"></i>
                        Log Out
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#020e41; ">
            <a href="{{ route('std/dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/school_image.png') }}" alt=" " class="brand-image img-circle elevation-3"
                    style="">
                <span class="brand-text font-weight-lightbrand-text font-weight-bold">MY MAHMCM</span>
            </a>
            <nav class="mt-2">
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            {{-- <img src="{{ asset('uploads/users/' . Auth::user()->photo) }}" class="img-circle elevation-2" alt="User Image"> --}}
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><i class="fa fa-user mr-2"></i> {{ Auth::user()->user_id }}</a>
                        </div>
                    </div>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion>
                        <li class="nav-item">
                            <a id="dashboard" href="{{ route('std/dashboard') }}"
                                class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="std-profile" href="{{ route('std/profile') }}"
                               class="nav-link">
                                <i class="nav-icon fa fa-user-circle"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="std-password" href="#"
                               class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="payment-details" href="{{ route('std/payment/details') }}"
                               class="nav-link">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Payment Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="std-exam-result" href="{{ route('std/exam/result') }}"
                               class="nav-link">
                                <i class="nav-icon fas fa-poll"></i>
                                <p>Exam Result</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="std-subject" href="{{ route('std/subjects') }}"
                               class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>My Subjects</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>
    </div>
    @yield('content')
</body>

</html>
