@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Setup Permissions</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">HRM Setup</li>
                        <li class="breadcrumb-item active">Setup Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('components.alert')
                <div class="card">
                    <form action="{{ route('permission/setup') }}" method="GET">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Search Employee</label>
                                    <input type="text" class="form-control" value="{{ $employee_id }}" name="employee_id" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                    <a href="{{ route('permission/setup') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @if($flag == 1)
                @php
                    $user = \App\Models\User::findOrfail($user_id);
                @endphp
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-4">
                                        @if ($employee_info->image!="")
                                        <img src = "{{ asset('uploads/teachers/'. $employee_info->image) }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @else
                                        <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @endif
                                    </div>
                                    <div class="col-md-9 mt-4">
                                        <table class="table table-bordered table-responsive-lg">
                                            <tbody>
                                                <tr>
                                                    <td class="font-weight-bold">Name</td>
                                                    <td>{{ $employee_info->first_name }} {{ $employee_info->last_name }}</td>
                                                    <td class="font-weight-bold">Designation</td>
                                                    <td>{{ $employee_info->designation_info->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">ID</td>
                                                    <td>{{ $employee_info->employee_id }}</td>
                                                    <td class="font-weight-bold">Email</td>
                                                    <td>{!! $employee_info->email !!}</td>

                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Gender</td>
                                                    <td>{{ $employee_info->gender }}</td>
                                                    <td class="font-weight-bold">Phone</td>
                                                    <td>{{ $employee_info->phone }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <form class="form-prevent" action="{{ route('permission/save') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$user_id) }}" name="user_id">

                        <div class="p-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="checkAll">
                                <label class="form-check-label font-weight-bold" for="checkAll">
                                    SELECT ALL
                                </label>
                            </div>
                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Dashboard</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]" type="checkbox" value="76"  {{ $user->hasPermission($user_id, 76) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Total Students
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]"  type="checkbox" value="77"  {{ $user->hasPermission($user_id, 77) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Total Teachers
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]"  type="checkbox" value="78"  {{ $user->hasPermission($user_id, 78) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Fees Collection
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]"  type="checkbox" value="79"  {{ $user->hasPermission($user_id, 79) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Class Wise Students
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]"  type="checkbox" value="91"  {{ $user->hasPermission($user_id, 91) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Estimated Fee
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]"  type="checkbox" value="90"  {{ $user->hasPermission($user_id, 90) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Attendance Percentage
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> HRM Setup</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input"  type="checkbox" name="checked_module[]" value="1"  {{$user->hasModule($user_id, 1) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is Module Enabled?
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]" value="1" type="checkbox" value="1"  {{$user->hasPermission($user_id, 1) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Setup Permissions
                                    </label>
                                </div>
                            </ul>
                            <p class="font-weight-bold mt-3 m-0"><i class="fa-solid fa-arrow-right"></i> Global Settings</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input"  type="checkbox" name="checked_module[]" value="2"  {{$user->hasModule($user_id, 2) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is Module Enabled?
                                    </label>
                                </div>
                                <p class="mt-2 mb-0 font-weight-bold"><i>Session</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_file[]" type="checkbox" value="2"  {{$user->hasPermission($user_id, 2) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="3"  {{$user->hasPermission($user_id, 3) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="4"  {{$user->hasPermission($user_id, 4) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="5"  {{$user->hasPermission($user_id, 5) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Designation</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="6"  {{$user->hasPermission($user_id, 6) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="7"  {{$user->hasPermission($user_id, 7) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="8"  {{$user->hasPermission($user_id, 8) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="9"  {{$user->hasPermission($user_id, 9) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select ID Card</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="10"  {{ $user->hasPermission($user_id, 10) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Select ID Card
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Academic Settings</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]"  value="3"  {{ $user->hasModule($user_id, 3) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Class</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="12"  {{$user->hasPermission($user_id, 12) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="13"  {{$user->hasPermission($user_id, 13) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="14"  {{$user->hasPermission($user_id, 14) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="15"  {{$user->hasPermission($user_id, 15) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Exam</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="16"  {{$user->hasPermission($user_id, 16) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="17"  {{ $user->hasPermission($user_id, 17) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="18"  {{ $user->hasPermission($user_id, 18) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="19"  {{$user->hasPermission($user_id, 19) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Grade</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="20"  {{$user->hasPermission($user_id, 20) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <p class="mt-2 mb-0 font-weight-bold"><i>Subject</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="24"  {{$user->hasPermission($user_id, 24) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="25"  {{$user->hasPermission($user_id, 25) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="26"  {{$user->hasPermission($user_id, 26) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="27"  {{$user->hasPermission($user_id, 27) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Accounts Settings</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="4"  {{$user->hasModule($user_id, 4) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Account Head</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="32"  {{$user->hasPermission($user_id, 32) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="33"  {{$user->hasPermission($user_id, 33) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="34"  {{$user->hasPermission($user_id, 34) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="35"  {{$user->hasPermission($user_id, 35) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Academic Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="13"  {{$user->hasModule($user_id, 13) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 font-weight-bold mb-0"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="29"  {{$user->hasPermission($user_id, 29) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Assign Subject
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="30"  {{ $user->hasPermission($user_id, 30) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Assign Exam
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="31"  {{ $user->hasPermission($user_id, 31) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Assign Teacher
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="83"  {{ $user->hasPermission($user_id, 83) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Class Teacher
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Student Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="5"  {{$user->hasModule($user_id, 5) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 font-weight-bold mb-0"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="36"  {{$user->hasPermission($user_id, 36) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="37"  {{$user->hasPermission($user_id, 37) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        New Admission
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="38"  {{$user->hasPermission($user_id, 38) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit Student
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="84"  {{ $user->hasPermission($user_id, 84) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Student Registration
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="40"  {{$user->hasPermission($user_id, 40) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Student Profile
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="41"  {{ $user->hasPermission($user_id, 41) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        ID Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="92"  {{ $user->hasPermission($user_id, 92) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete Registration
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Employee Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="6"  {{$user->hasModule($user_id, 6) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="42"  {{$user->hasPermission($user_id, 42) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="43"  {{$user->hasPermission($user_id, 43) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="44"  {{$user->hasPermission($user_id, 44) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="45"  {{$user->hasPermission($user_id, 45) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="46"  {{$user->hasPermission($user_id, 46) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Employee Profile
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="47"  {{ $user->hasPermission($user_id, 47) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        ID Card
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> HR Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="16"  {{ $user->hasModule($user_id, 16) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 font-weight-bold mb-0"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="85"  {{ $user->hasPermission($user_id, 85) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Employee Status
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="85"  {{ $user->hasPermission($user_id, 85) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Student Status
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="93"  {{ $user->hasPermission($user_id, 93) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Week Days
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="94"  {{ $user->hasPermission($user_id, 94) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Declare Holiday
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Result Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" name="checked_module[]" type="checkbox" value="7"  {{ $user->hasModule($user_id, 7) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="28"  {{ $user->hasPermission($user_id, 28) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Manage Marks
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="48"  {{$user->hasPermission($user_id, 48) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Mark Entry
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="49"  {{$user->hasPermission($user_id, 49) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Student Result
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Student Accounts</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="8"  {{$user->hasModule($user_id, 8) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="50"  {{$user->hasPermission($user_id, 50) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Fee Structure
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="51"  {{$user->hasPermission($user_id, 51) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Apply Waiver
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="52"  {{$user->hasPermission($user_id, 52) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Fees Collection
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="53"  {{$user->hasPermission($user_id, 53) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Transaction History
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Student Dues</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="54"  {{$user->hasPermission($user_id, 54) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="55"  {{$user->hasPermission($user_id, 55) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="56"  {{$user->hasPermission($user_id, 56) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> General Accounts</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="9"  {{$user->hasModule($user_id, 9) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="57"  {{$user->hasPermission($user_id, 57) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Create Employee Salary
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="58"  {{$user->hasPermission($user_id, 58) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Salary Payment
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="59"  {{$user->hasPermission($user_id, 59) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Transaction History
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="60"  {{$user->hasPermission($user_id, 60) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Balance Sheet
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Salary Report</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="61"  {{$user->hasPermission($user_id, 61) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="62"  {{$user->hasPermission($user_id, 62) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="63"  {{$user->hasPermission($user_id, 63) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Miscellaneous Cost</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="64"  {{$user->hasPermission($user_id, 64) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="65"  {{$user->hasPermission($user_id, 65) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="66"  {{$user->hasPermission($user_id, 66) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="67"  {{$user->hasPermission($user_id, 67) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Investment/Donation</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="68"  {{$user->hasPermission($user_id, 68) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="69"  {{$user->hasPermission($user_id, 69) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Add
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="70"  {{$user->hasPermission($user_id, 70) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Edit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="71"  {{ $user->hasPermission($user_id, 71) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Delete
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="89"  {{ $user->hasPermission($user_id, 89) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Print Voucher
                                    </label>
                                </div>

                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Attendance Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="14"  {{ $user->hasModule($user_id, 14) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="86"  {{ $user->hasPermission($user_id, 81) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Student Attendance
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="96"  {{ $user->hasPermission($user_id, 96) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Employee Attendance
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="95"  {{ $user->hasPermission($user_id, 95) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Attendance Report
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="81"  {{$user->hasPermission($user_id, 81) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Daily Summary
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Report Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="10"  {{$user->hasModule($user_id, 10) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="72"  {{$user->hasPermission($user_id, 72) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Attendance Sheet
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="73"  {{$user->hasPermission($user_id, 73) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Admit Card
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> Support Management</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="11"  {{$user->hasModule($user_id, 11) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="74"  {{$user->hasPermission($user_id, 74) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Account Recovery
                                    </label>
                                </div>
                            </ul>

                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> SMS Service</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="12"  {{$user->hasModule($user_id, 12) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="75"  {{$user->hasPermission($user_id, 75) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Send SMS
                                    </label>
                                </div>
                            </ul>
                            <p class="font-weight-bold m-0"><i class="fa-solid fa-arrow-right"></i> System Settings</p>
                            <ul>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_module[]" value="17"  {{ $user->hasModule($user_id, 17) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Is module enabled?
                                    </label>
                                </div>

                                <p class="mt-2 mb-0 font-weight-bold"><i>Select</i></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checked_file[]" value="88"  {{ $user->hasPermission($user_id, 88) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Activity Log
                                    </label>
                                </div>
                            </ul>
                            <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">UPDATE</button>
                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </section>

    <script>
         $('#hrm-setup').addClass('menu-open');
         $("#setup-permission").addClass('active');
    </script>

    <script>
        document.getElementById('checkAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    @endsection
