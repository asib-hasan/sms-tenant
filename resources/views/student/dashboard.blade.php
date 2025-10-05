@extends('layout.sidebar_student')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-italic blinking">Welcome, {{ $student_info->first_name }} !</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="small-box bg-white rounded-0">
                        <div class="inner">
                            <h3>{{ $dues_pending }}</h3>
                            <p class="font-weight-bold">PENDING DUES [<span class="text-muted" style="font-size: 11px">Up to - {{ date('M Y') }}</span>]</p>
                        </div>
                        <div class="icon" style="color: #9DB2BF">
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                        </div>
                        <a class="small-box-footer" style="background-color: #7AA2E3"> <i class="fa-solid fa-bangladeshi-taka-sign"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-white rounded-0">
                        <div class="inner">
                            <h3>{{ 5 }}</h3>
                            <p class="font-weight-bold">CLASS MISSED [<span class="text-muted" style="font-size: 11px">This month</span>]</p>
                        </div>
                        <div class="icon" style="color: #9DB2BF">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <a class="small-box-footer" style="background-color: #7AA2E3"> <i class="fas fa-calendar-times"></i></a>
                    </div>
                </div>
            </div>
        <script>
            $('#dashboard').addClass('active');
        </script>
@endsection
