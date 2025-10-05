@extends('layout.sidebar')
@section('content')
<style>

    .profile-img img {
        width: 150px;
        height: 150px;
        border-radius: 10px;
    }

    .proile-rating span {
        color: #495057;
        font-size: 15px;
        font-weight: 600;
    }



    .profile-head .nav-tabs .nav-link {
        font-weight: 600;
        border: none;

    }

    .profile-head .nav-tabs .nav-link.active {
        border: none;
        border-bottom: 2px solid #0062cc;
    }

    .profile-tab label {
        font-weight: 600;
    }

</style>
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
                        <li class="breadcrumb-item active">Student Management</li>
                        <li class="breadcrumb-item active">Student Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row p-2">
        <div class="col-md-9">
            <div class="card">
                <div class="emp-profile ml-3 mb-3 p-3">
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
                                @if($student_reg_info->status == 0)
                                    <span class="badge bg-success">Active</span>
                                @elseif($student_reg_info->status == 1)
                                    <span class="badge bg-warning">Inactive</span>
                                @endif
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
                                    <table class="table table-bordered">
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
                                        <style>
                                            .table tr td {
                                                width: 50%;
                                            }
                                            .table td{
                                                font-weight: bold;
                                                color: #0062cc;
                                            }
                                        </style>
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
        <div class="col-md-3">
            <div class="card p-2">
                <h4 class="text-center bg-info font-weight-bold">Class Teacher</h4>
                @if($teacher_info != "")
                <div class="text-center" style="border: 1px solid #ddd">
                    @if($teacher_info->image)
                        <img src="{{ asset('photos/user.png') }}" height="150px" width="150px" alt="img">
                    @else
                        <img src="{{ asset('uploads/teachers/' . $teacher_info->image) }}" height="150px" width="150px" style="border-radius: 50%; border: 2px solid black"  alt="">
                    @endif
                    <ul class="list-unstyled mt-2">
                        <li>{{ $teacher_info->first_name }} {{ $teacher_info->last_name }}</li>
                        <li><i>{{ $teacher_info->designation_info->name ?? '' }}</i></li>
                        <li><b>Contact:</b> <br>{{ $teacher_info->phone }}</li>
                        <li><b>Email:</b> {{ $teacher_info->email }}</li>
                        <li><b>Joining Date:</b> <br>{{ $teacher_info->joiningdate }}</li>
                    </ul>
                </div>
                @else
                    <div style="text-align:center; margin-bottom: 100px">
                        <span class="badge bg-secondary">No class teacher assigned</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
<script>
    $('#student-management').addClass('menu-open');
    $('#student-profile').addClass('active');
</script>
@endsection
