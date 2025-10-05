@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">Student Registration</li>
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
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdmgt/registration/by/class') }}">By Class</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdmgt/registration/update') }}">Update Reg.</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdmgt/registration/report') }}">Report</a>
                                        </li> --}}
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('stdmgt/registration/by/student') }}" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 form-group">
                                                        <label for="">Enter Student ID</label>
                                                        <input type="text" name="student_id" value="{{ $student_id != "" ? $student_id : '20240026' }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">Session</label>
                                                        <select name="session_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                            <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-2">SEARCH</button>
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
                                            @if ($student_info->photo != '')
                                                <img src = "{{ asset('uploads/students/' . $student_info->photo) }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                            @else
                                                <img src = "{{ asset('photos/user.png') }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                            @endif
                                        </div>
                                        <div class="col-md-9 mt-4">
                                            <table class="table table-bordered table-responsive-lg text-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Name</td>
                                                        <td>{{ $student_info->first_name }} {{ $student_info->last_name }}</td>
                                                        <td class="font-weight-bold">Email</td>
                                                        <td>{{ $student_info->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Religion</td>
                                                        <td>{{ $student_info->religion }}</td>
                                                        <td class="font-weight-bold">Phone</td>
                                                        <td>{!! $student_info->mobile !!}</td>

                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Gender</td>
                                                        <td>{{ $student_info->gender }}</td>
                                                        <td class="font-weight-bold">Blood Group</td>
                                                        <td>{{ $student_info->blood_group }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead style="background: #ddd">
                                    <tr>
                                        <th colspan="2">Registration information @if($student_reg_info !="")<a href="javascript:void(0)" data-toggle="modal" data-target="#edit_reg" class="simple-button" style="float:right"><i class="fa fa-pencil"></i>Edit</a>@endif</th>
                                        @if($student_reg_info !="")
                                        <div class="modal fade" id="edit_reg">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title font-weight-bold">Update Registration</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('stdmgt/registration/by/student/update') }}" class="form-group" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt',$student_reg_info->id) }}">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Name</label>
                                                                    <input type="text" class="form-control" value="{{ $student_info->first_name }} {{ $student_info->last_name }}" @disabled(true)>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Student ID</label>
                                                                    <input type="text" class="form-control" value="{{ $student_reg_info->student_id }}" @disabled(true)>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Session</label>
                                                                    <input type="text" class="form-control" value="{{ $student_reg_info->session_info->name ?? '' }}" @disabled(true)>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Class<span style="color: red">*</span></label>
                                                                    <select name="class_id" class="form-control select2" style="width:100%" required>
                                                                        <option value="">Select</option>
                                                                        @foreach($class_list AS $class)
                                                                            <option value="{{ $class->id }}" @selected($class->id == $student_reg_info->class_id)>{{ $class->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Roll No.</label>
                                                                    <input type="text" class="form-control" name="roll_no" value="{{ $student_reg_info->roll_no }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Shift<span style="color: red">*</span></label>
                                                                    <select class="form-control" name="shift" required>
                                                                        <option value="">Select</option>
                                                                        <option value="0" @selected($student_reg_info->shift == 0)>Morning</option>
                                                                        <option value="1" @selected($student_reg_info->shift == 1)>Day</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="Name">Registration Date<span style="color: red">*</span></label>
                                                                    <input type="date" class="form-control" name="reg_date" value="{{ $student_reg_info->reg_date }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                                            <button type="submit" class="btn btn-primary btn-custom">SAVE</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </tr>
                                </thead>
                                @if($student_reg_info !="")
                                <tbody>
                                    <tr>
                                        <td><b>Session</b><br>{{ $student_reg_info->session_info->name }}</td>
                                        <td><b>Registration No.</b> <br>{{ $student_reg_info->reg_no }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Class</b> <br>{{ $student_reg_info->class_info->name }}</td>
                                        <td><b>Roll No.</b> <br> {{ $student_reg_info->roll_no }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Shift</b> <br>{{ ($student_reg_info->shift==0)?'Morning':'Day' }}</td>
                                        <td><b>Registration Date</b> <br>{{ $student_reg_info->reg_date }}</td>
                                    </tr>
                                </tbody>
                                @else
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-maroon" colspan="2">No registration infomation found</td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">New Registration</h3>
                        </div>
                        <form class="form-prevent" action="{{ route('stdmgt/registration/by/student/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ Helper::encrypt_decrypt('encrypt',$student_id) }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Name">Session<span style="color: red">*</span></label>
                                        <select class="form-control" name="session_id" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->id }}" @selected(old('session_id') == $i->id)> {{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Class<span style="color: red">*</span></label>
                                        <select class="form-control select2" name="class_id" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option value="{{ $i->id }}" @selected(old('class_id') == $i->id)>{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Roll No.</label>
                                        <input type="text" class="form-control" name="roll_no" value="{{ old('roll_no') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Shift<span style="color: red">*</span></label>
                                        <select class="form-control" name="shift" required>
                                            <option value="">Select</option>
                                            <option value="0">Morning</option>
                                            <option value="1">Day</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Registration Date<span style="color: red">*</span></label>
                                        <input type="date" class="form-control" id="today" name="reg_date" value="{{ old('reg_date') }}" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary form-prevent-multiple-submit btn-custom">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#student-management').addClass('menu-open');
        $('#student-reg').addClass('active');
    </script>
    <script>
        var today = new Date();
        var formattedDate = today.toISOString().substr(0, 10);
        document.getElementById("today").value = formattedDate;
    </script>
@endsection
