@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Delete Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">Delete Registration</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">By Student</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('stdmgt/registration/delete') }}" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Enter Registration No</label>
                                                        <input type="text" name="reg_no" value="{{ $registration_no }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-3">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($flag==1)
                        <div class="row">
                            <div class="col-md-12 ml-0">
                                <div class="card bg-light ">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 text-center mt-4">
                                                @if ($reg_info->student_info->photo != '')
                                                    <img src = "{{ asset('uploads/students/' . $reg_info->student_info->photo) }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @else
                                                    <img src = "{{ asset('photos/user.png') }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @endif
                                            </div>
                                            <div class="col-md-9 mt-4 table-responsive">
                                                <table class="table table-bordered text-nowrap">
                                                    <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Name</td>
                                                        <td>{{ $reg_info->student_info->first_name }} {{ $reg_info->student_info->last_name }}</td>
                                                        <td class="font-weight-bold">Student ID</td>
                                                        <td>{{ $reg_info->student_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Registration No.</td>
                                                        <td>{{ $reg_info->reg_no }}</td>
                                                        <td class="font-weight-bold">Shift</td>
                                                        <td>{{ $reg_info->shift == 0 ? 'Morning':'Day' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Class</td>
                                                        <td>{{ $reg_info->class_info->name ?? '' }}</td>
                                                        <td class="font-weight-bold">Session</td>
                                                        <td>{{ $reg_info->session_info->name ?? '' }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('stdmgt/registration/delete/apply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reg_id" value="{{ Helper::encrypt_decrypt('encrypt',$reg_info->id) }}">
                            <div class="card p-2">
                                <div class="info-box bg-indigo">
                                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                    <div class="info-box-content">
                                        <h3 class="info-box-text text-warning font-weight-bold text-wrap">Read this before delete this student registration!</h3>
                                        <span class="info-box-number">Once you delete this student registration, all information related to this registration, including payment, results, attendance, account details, etc. will also be deleted, and no backup or rollback will be available.</span>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-danger font-weight-bold" onclick="return confirm('Are you sure you want to delete?');" type="submit">DELETE</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#student-management').addClass('menu-open');
        $('#registration-delete').addClass('active');
    </script>
@endsection
