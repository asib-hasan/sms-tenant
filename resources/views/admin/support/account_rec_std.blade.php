@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Account Recovery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Support Management</li>
                            <li class="breadcrumb-item active">Account Recovery</li>
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
                                            <a class="nav-link" href="{{ route('spmgt/account/recovery/emp') }}">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">By Student</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('spmgt/account/recovery/std') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Enter Student ID</label>
                                                        <input type="text" name="student_id" value="{{ $student_id != "" ? $student_id : '20250005' }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-3 font-weight-bold">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($flag == 1)
                        <div class="row">
                            <div class="col-md-12 ml-0">
                                <div class="card bg-light ">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 text-center mt-4">
                                                @if ($student_info->photo != "")
                                                    <img src = "{{ asset('uploads/students/'. $student_info->photo)}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @else
                                                    <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @endif
                                            </div>
                                            <div class="col-md-9 mt-4">
                                                <table class="table table-bordered table-responsive-lg">
                                                    <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Name</td>
                                                        <td>{{ $student_info->first_name ?? '' }} {{ $student_info->last_name ?? ''}}</td>
                                                        <td class="font-weight-bold">DoB</td>
                                                        <td>{{ $student_info->dob }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">ID</td>
                                                        <td>{{ $student_id }}</td>
                                                        <td class="font-weight-bold">Father</td>
                                                        <td>{{ $student_info->father }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Blood Group</td>
                                                        <td>{{ $student_info->blood_group }}</td>
                                                        <td class="font-weight-bold">Phone</td>
                                                        <td>{{ $student_info->mobile ?? '' }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('spmgt/account/recovery/std/update') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $student_id }}" name="student_id">
                            <div class="card  p-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Set New Password</label>
                                    <input type="text" class="form-control" name="password" required minlength="8">
                                    <button type="submit" class="btn btn-primary btn-custom mt-3">UPDATE PASSWORD</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#support-management').addClass('menu-open');
        $('#account-recovery').addClass('active');
    </script>
@endsection
