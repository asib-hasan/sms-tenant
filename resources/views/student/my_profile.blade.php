@extends('layout.sidebar_student')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="font-weight-bold mr-2">Student Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
        @if($flag == 1)
        <div class="row">
            <div class="col-md-12">
                @include('components.alert')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="emp-profile ml-3 mb-3 p-3">
                        <div class="text-right">
                            <a class="simple-button" data-toggle="modal" data-target="#change-password" href="javascript:void(0)"><i class="fa fa-pencil"></i> Change Password</a>
                            <div class="modal fade text-left" id="change-password">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('my-profile/change/password') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title font-weight-bold text-maroon">Change Password</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Current Password</label>
                                                    <input type="password" class="form-control" name="old_password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" minlength="8" name="new_password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-img text-center">
                                    @if($student_info->photo != null)
                                        <img class="img-bordered" src="{{ asset('uploads/students/'. $student_info->photo) }}" alt="" />
                                    @else
                                        <img class="img-bordered" src="{{ asset('photos/user.png') }}" alt="" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="profile-head">
                                    <h4 class="font-weight-bold">{{ $student_info->first_name }} {{ $student_info->last_name }}</h4>
                                    <p class="proile-rating">Student ID : <b>{{ $student_info->student_id }}</b> <br>Registration No : <b class="text-maroon">Not admitted yet</b></p>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist" >
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                               aria-controls="home" aria-selected="true">Academic</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                               aria-controls="profile" aria-selected="false">Personal Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                               aria-controls="contact" aria-selected="false">Contact Information</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-7">
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Session</th>
                                                <td>{{ 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Class</th>
                                                <td>{{ 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Roll</th>
                                                <td colspan="2">{{ 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Admission Number</th>
                                                <td colspan="2">{{ $student_info->admission_number }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-bordered ">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Gender</th>
                                                <td>{{ $student_info->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Blood Group</th>
                                                <td>{{ $student_info->blood_group }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Religion</th>
                                                <td colspan="2">{{ $student_info->religion }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Nationality</th>
                                                <td colspan="2">{{ $student_info->nationality }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Date of Birth</th>
                                                <td colspan="2">{{ $student_info->dob }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Father Name</th>
                                                <td>{{ $student_info->father }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mother Name</th>
                                                <td>{{ $student_info->mother }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone</th>
                                                <td colspan="2">{{ $student_info->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td colspan="2">{{ $student_info->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td colspan="2">{{ $student_info->address }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                @include('components.alert')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="emp-profile ml-3 mb-3 p-3">
                        <div class="text-right">
                            <a class="simple-button" data-toggle="modal" data-target="#change-password" href="javascript:void(0)"><i class="fa fa-pencil"></i> Change Password</a>
                            <div class="modal fade text-left" id="change-password">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('std/profile/change/password') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title font-weight-bold text-maroon">Change Password</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Current Password</label>
                                                    <input type="password" class="form-control" name="old_password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" minlength="8" name="new_password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-img text-center">
                                    @if($student_reg_info->student_info->photo != null)
                                        <img class="img-bordered" src="{{ asset('uploads/students/'. $student_reg_info->student_info->photo) }}" alt="" />
                                    @else
                                        <img class="img-bordered" src="{{ asset('photos/user.png') }}" alt="" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="profile-head">
                                    <h4 class="font-weight-bold">{{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</h4>
                                    <p class="proile-rating">Student ID : <b>{{ $student_reg_info->student_id }}</b> <br>Registration No : <b>{{ $student_reg_info->reg_no }}</b></p>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist" >
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                               aria-controls="home" aria-selected="true">Academic</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                               aria-controls="profile" aria-selected="false">Personal Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                               aria-controls="contact" aria-selected="false">Contact Information</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-7">
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Session</th>
                                                <td>{{ $student_reg_info->session_info->name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Class</th>
                                                <td>{{ $student_reg_info->class_info->name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Roll</th>
                                                <td colspan="2">{{ $student_reg_info->roll_no }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Admission Number</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->admission_number ?? '' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-bordered ">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Gender</th>
                                                <td>{{ $student_reg_info->student_info->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Blood Group</th>
                                                <td>{{ $student_reg_info->student_info->blood_group }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Religion</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->religion }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Nationality</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->nationality }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Date of Birth</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->dob }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Father Name</th>
                                                <td>{{ $student_reg_info->student_info->father }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mother Name</th>
                                                <td>{{ $student_reg_info->student_info->mother }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td colspan="2">{{ $student_reg_info->student_info->address }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($class_teacher == 1)
            <div class="col-md-3">
                <div class="card p-2">
                    <h4 class="text-center bg-info font-weight-bold">Class Teacher</h4>
                    <div class="text-center" style="border: 1px solid #ddd">
                        <img src="{{ asset('uploads/teachers/' . $teacher_info->image) }}" height="150px" width="150px" style="border-radius: 50%; border: 2px solid black"  alt="">
                        <ul class="list-unstyled mt-2">
                            <li>{{ $teacher_info->first_name }} {{ $teacher_info->last_name }}</li>
                            <li><i>{{ $teacher_info->designation_info->name ?? '' }}</i></li>
                            <li><b>Contact:</b> <br>{{ $teacher_info->phone }}</li>
                            <li><b>Email:</b> {{ $teacher_info->email }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        </section>
    </div>


    <script>
        $('#std-profile').addClass('active');
    </script>
@endsection
