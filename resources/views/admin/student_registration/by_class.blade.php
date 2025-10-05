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
                                            <a class="nav-link" href="{{ route('stdmgt/registration/by/student') }}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">By Class</a>
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
                                            <form action="{{ route('stdmgt/registration/by/class') }}" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">Class</label>
                                                        <select name="class_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach ($class_list as $i)
                                                            <option @selected($class_id==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">Session From</label>
                                                        <select name="session_id_from" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                            <option @selected($session_id_from==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">Session To</label>
                                                        <select name="session_id_to" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                            <option @selected($session_id_to==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <button type="submit" class="mt-3 btn btn-primary btn-custom mt-2">SEARCH</button>
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
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">New Registration</h3>
                        </div>
                        <form class="form-prevent" action="{{ route('stdmgt/registration/by/class/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="session_id_to" value="{{ Helper::encrypt_decrypt('encrypt',$session_id_to) }}">
                            <div class="table-responsive p-2">
                                <table class="table table-hover text-nowrap table-bordered">
                                    <thead style="background: #ddd">
                                        <tr class="text-maroon font-weight-bold">
                                            <th colspan="3">Class - {{ $class }} | Session - {{ $session_from }}</th>
                                            <th colspan="6">Session - {{ $session_to }}</th>
                                        </tr>
                                    </thead>
                                    <thead style="background: #ddd">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>ID</th>
                                            <th>Roll No.</th>
                                            <th colspan="5">New registration info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $is_found = 0; @endphp
                                        @forelse ($student_list as $i)
                                        <tr>
                                            <td>{{ $i->student_info->first_name }} {{ $i->student_info->last_name }}</td>
                                            <td>{{ $i->student_info->student_id }}</td>
                                            <td>{{ $i->roll_no }}</td>
                                            @php
                                                $reg_info = \App\Models\StudentRegistrationModel::where('student_id',$i->student_id)->where('session_id',$session_id_to)->exists();
                                            @endphp
                                            @if ($reg_info != "")
                                            <td colspan="6" class="font-weight-bold"><span class="badge badge-secondary">Already Registered</span></td>
                                            @else
                                            @php $is_found = 1; @endphp
                                            <input type="hidden" name="students[{{ $i->student_id }}][std_id]" value="{{ $i->student_info->id }}">
                                            <td>
                                                <label>Session</label>
                                                <input type="text" class="form-control" disabled value="{{ $session_to }}">
                                            </td>
                                            <td>
                                                <label for="Name">Class</label>
                                                <select name="students[{{ $i->student_id }}][class_id]" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach ($class_list as $cls)
                                                    <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <label>Roll No.</label>
                                                <input type="text" name="students[{{ $i->student_id }}][roll_no]" class="form-control">
                                            </td>
                                            <td>
                                                <label>Shift</label>
                                                <select class="form-control select2" name="students[{{ $i->student_id }}][shift]" style="width: 100%">
                                                    <option value="">Select</option>
                                                    <option value="0">Morning</option>
                                                    <option value="1">Day</option>
                                                </select>
                                            </td>
                                            <td>
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="students[{{ $i->student_id }}][date]">
                                            </td>
                                            @endif
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="font-weight-bold text-maroon" colspan="7">No records</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @if (!$student_list->isEmpty() && $is_found != 0)
                                <button type="submit" class="btn btn-primary form-prevent-multiple-submit btn-custom">SUBMIT</button>
                                @endif
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
