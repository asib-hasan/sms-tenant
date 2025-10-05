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
                                            <a class="nav-link" href="{{ route('stdmgt/registration/by/class') }}">By Class</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Update Reg.</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdmgt/registration/report') }}">Report</a>
                                        </li> --}}
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('stdmgt/registration/update') }}" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Class</label>
                                                        <select name="class_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach ($class_list as $i)
                                                            <option @selected($class_id==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Session</label>
                                                        <select name="session_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                            <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
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
                            <h3 class="card-title font-weight-bold">Update Registration</h3>
                        </div>
                        <form class="form-prevent" action="{{ route('stdmgt/registration/update/post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="session_id" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}">
                            <div class="table-responsive p-2">
                                <table class="table table-hover text-nowrap table-bordered">
                                    <thead style="background: #ddd">
                                        <tr>
                                            <th colspan="7">Class & Session ~ {{ $class }} ({{ $session }})</th>
                                        </tr>
                                    </thead>
                                    <thead style="background: #ddd">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>ID</th>
                                            <th>Registration No.</th>
                                            <th>Class</th>
                                            <th>Roll No.</th>
                                            <th>Shift</th>
                                            <th>Reg. Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($student_list as $i)
                                        <tr>
                                            <td>{{ $i->student_info->first_name }} {{ $i->student_info->last_name }}</td>
                                            <td>{{ $i->student_info->student_id }}</td>
                                            <td>{{ $i->reg_no }}</td>
                                            <td>
                                                {{ $i->class_info->name ?? '' }}
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $i->roll_no }}" name="students[{{ $i->id }}][roll_no]" class="form-control">
                                            </td>
                                            <td>
                                                <select class="form-control select2" name="students[{{ $i->id }}][shift]" style="width: 100%">
                                                    <option value="">Select</option>
                                                    <option value="0" @selected($i->shift==0)>Morning</option>
                                                    <option value="1" @selected($i->shift==1)>Day</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" value="{{ $i->reg_date }}" name="students[{{ $i->id }}][date]">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-maroon font-weight-bold" colspan="7">No records</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @if (!$student_list->isEmpty())
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
