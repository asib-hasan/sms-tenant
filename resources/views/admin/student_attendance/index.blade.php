@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student Attendance</h1>
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
                        <form action="{{route('atmgt/student')}}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Class</label>
                                        <select name="class_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option @selected($class_id==$i->class_id) value="{{ $i->class_id }}">{{ $i->class_info->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Session</label>
                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option @selected($session_id==$i->session_id) value="{{ $i->session_id }}">{{ $i->session_info->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Month</label>
                                        <select name="month_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($month_list as $i)
                                                <option @selected($month_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                        <a href="{{ route('atmgt/student') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if($flag == 1)
                        <div class="table-responsive p-2 table-bordered">
                            <a href="{{ route('atmgt/student/entry', [
                                    'class_id' => $class_id,
                                    'session_id' => $session_id,
                                    'month_id' => $month_id
                                ]) }}" target="_blank" class="font-weight-bold">
                                <i class="fa fa-plus"></i> New Entry
                            </a>

                            <a href="{{ route('atmgt/print/attendance/sheet', [
                                'class_id' => $class_id,
                                'session_id' => $session_id,
                                'month' => $month_id
                            ]) }}" target="_blank" class="font-weight-bold ml-2">
                            <i class="fa fa-print"></i> Print Attendance Sheet
                            </a>

                            <table class="table table-hover text-nowrap">
                                <thead style="background-color: #EAEAEA">
                                <tr>
                                    <td colspan="6" class="font-weight-bold">Records</td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($record_list as $i)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $i->date }}</td>
                                        <td>{{ $i->present }}</td>
                                        <td>{{ $i->absent }}</td>
                                        <td>{{ $i->present + $i->absent }}</td>
                                        <td>
                                            <a class="simple-button" target="_blank"
                                               href="{{ route('atmgt/student/entry/edit', [
                                                   'class_id' => $class_id,
                                                   'session_id' => $session_id,
                                                   'date' => $i->date,
                                                   'month_id' => $month_id
                                               ]) }}">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a class="simple-button text-danger"
                                               onclick="return confirm('Are you sure to delete?');"
                                               href="{{ route('atmgt/student/entry/delete', [
                                                   'class_id' => $class_id,
                                                   'session_id' => $session_id,
                                                   'date' => $i->date,
                                                   'month_id' => $month_id
                                               ]) }}">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger">No records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        @endif
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
