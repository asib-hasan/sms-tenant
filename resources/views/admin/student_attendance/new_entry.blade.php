@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Attendance Entry</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Management</li>
                            <li class="breadcrumb-item active">Student Attendance</li>
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
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead style="background-color: #ddd">
                                        <tr>
                                            <th colspan="2">Class Information</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><b>Class</b> <br>{{ $class_name }}</td>
                                            <td><b>Session</b> <br> {{ $session_name }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Total Student</b><br>{{ $student_list->count() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-2 table-bordered">
                            <form class="form-prevent" action="{{ route('atmgt/student/entry/store') }}" method="POST">
                                <input type="hidden" name="class_id" value="{{ Helper::encrypt_decrypt('encrypt',$class_id) }}">
                                <input type="hidden" name="session_id" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}">
                                <input type="hidden" name="month_id" value="{{ Helper::encrypt_decrypt('encrypt',$month_id) }}">
                                @csrf
                                <table class="table table-hover text-nowrap" id="dataTable">
                                    <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <td colspan="6" class="font-weight-bold">
                                            Select Date
                                            <input type="date" style="border: 1px solid #ddd;border-radius: 5px;padding: 2px" name="date" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 20%">ID</th>
                                        <th style="width: 45%">Name</th>
                                        <th style="width: 20%">Roll</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($student_list as $i)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <select name="status[{{ $i->student_id }}]" style="border: 1px solid #ddd;border-radius: 5px;padding: 2px">
                                                    <option value="P" @selected(old('status.' . $i->student_id) == 'P')>Present</option>
                                                    <option value="A" @selected(old('status.' . $i->student_id) == 'A')>Absent</option>
                                                </select>
                                            </td>
                                            <td>{{ $i->student_id }}</td>
                                            <td>{{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }}</td>
                                            <td>{{ $i->roll_no }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No records</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                @if($student_list->isNotEmpty())
                                    <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">SUBMIT</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#attendance-management').addClass('menu-open');
        $('#student-attendance').addClass('active');
    </script>
@endsection
