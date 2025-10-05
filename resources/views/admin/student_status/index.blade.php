@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">HR Management</li>
                            <li class="breadcrumb-item active">Student Status</li>
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
                                            <a class="nav-link" href="{{ route('hrmgt/student/status/inactive/records') }}">Inactive Records</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('hrmgt/student/status') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label>Session</label>
                                                        <select name="session_id" id="session_wise_all_student" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach($session_list as $i)
                                                                <option value="{{ $i->id }}" @selected($session_id == $i->id)>{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Student</label>
                                                        <select id="all_student_load" class="form-control select2" style="width: 100%" name="student_id" required>
                                                            <option value="">Select</option>
                                                            @foreach ($student_list as $i)
                                                                <option @selected($i->student_id == $student_id) value="{{ $i->student_id }}">{{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }} [{{ $i->student_id }}]</option>
                                                            @endforeach
                                                        </select>
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
                                                @if ($student_reg_info->student_info->photo != null)
                                                    <img src = "{{ asset('uploads/students/'. $student_reg_info->student_info->photo)}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @else
                                                    <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @endif
                                            </div>
                                            <div class="col-md-9 mt-4">
                                                <table class="table table-bordered table-responsive-lg">
                                                    <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Name</td>
                                                        <td>{{ $student_reg_info->student_info->first_name }} {{ $student_reg_info->student_info->last_name }}</td>
                                                        <td class="font-weight-bold">Class</td>
                                                        <td>{{ $student_reg_info->class_info->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Roll</td>
                                                        <td>{{ $student_reg_info->roll_no }}</td>
                                                        <td class="font-weight-bold">Email</td>
                                                        <td>{!! $student_reg_info->student_info->email !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Gender</td>
                                                        <td>{{ $student_reg_info->student_info->gender }}</td>
                                                        <td class="font-weight-bold">Phone</td>
                                                        <td>{{ $student_reg_info->student_info->mobile }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="form-prevent" action="{{ route('hrmgt/student/status/update') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$student_reg_info->id) }}" name="student_reg_id">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="" class="form-label">Status</label>
                                        <select name="status" id="status" onchange="update_status()" class="form-control">
                                            <option value="0" @selected($student_reg_info->status == 0)>Active</option>
                                            <option value="1" @selected($student_reg_info->status == 1)>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Date</label>
                                        <input type="date" id="inactive" name="inactive_date" value="{{ $student_reg_info->inactive_date }}" class="form-control" @disabled($student_reg_info->status == 0)>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <button type="submit" class="form-class-multiple-submit btn btn-primary btn-custom mt-3">UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#hr-management').addClass('menu-open');
        $('#student-status').addClass('active');
    </script>
    <script>
        function update_status() {
            const status = document.getElementById("status").value;
            const inactive_date = document.getElementById("inactive");

            if (status == "1") {
                inactive_date.disabled = false;
                inactive_date.required = true;
            } else {
                inactive_date.disabled = true;
                inactive_date.required = false;
                inactive_date.value = "";
            }
        }
    </script>
@endsection
