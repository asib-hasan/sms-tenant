@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Attendance Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Management</li>
                            <li class="breadcrumb-item active">Attendance Report</li>
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
                                            <a class="nav-link active" href="{{ route('atmgt/report/student') }}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('atmgt/report/employee') }}">By Employee</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('atmgt/report/student') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="form-group col-md-6">
                                                        <label for="Name">Student ID</label>
                                                        <input type="text" name="student_id" class="form-control" value="{{ $student_id }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="Name">From Date</label>
                                                        <input type="date" name="from_date" class="form-control" value="{{ $from_date }}" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="Name">To Date</label>
                                                        <input type="date" name="to_date" class="form-control" value="{{ $to_date }}" required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary mt-3 btn-custom">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($flag==1)
                            <div class="col-md-12">
                                <div class="card">
{{--                                <span>--}}
{{--                                    <a target="_blank" class="font-weight-bold ml-2" href="{{ route('atmgt/report/print/student?student_id=' . $student_id . '&from_date=' . $from_date . '&to_date=' . $to_date) }}">--}}
{{--                                        <i class="fas fa-file-pdf" style="color: red; font-weight: bold;"></i> PDF--}}
{{--                                    </a>--}}
{{--                                </span>--}}
                                    <div class="card-body table-responsive p-2 table-bordered">
                                        <table class="table table-hover text-nowrap" id="dataTable">
                                            <tbody>
                                            <tr>
                                                <th style="background-color: #ddd" colspan="2">Student Information</th>
                                            </tr>
                                            <tr>
                                                <td>Name <br>
                                                    <b>{{ $student_info->first_name }} {{ $student_info->last_name }}</b>
                                                </td>
                                                <td>ID <br> <b>{{ $student_info->student_id }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Class <br>
                                                    <b>{{ $student_reg_info ? $student_reg_info->class_info->name : '--' }}</b>
                                                </td>
                                                <td>Session <br>
                                                    <b>{{ $student_reg_info != null ? $student_reg_info->session_info->name ?? '' : '--' }}</b>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        {{--                                    For manual attendance --}}
                                        {{--                                    <table class="mt-3 table table-hover text-nowrap" id="dataTable">--}}
                                        {{--                                        <thead style="background-color: #EAEAEA">--}}
                                        {{--                                        <tr>--}}
                                        {{--                                            <th>#</th>--}}
                                        {{--                                            <th>Date</th>--}}
                                        {{--                                            <th>Day</th>--}}
                                        {{--                                            <th>Status</th>--}}
                                        {{--                                            <th>Remarks</th>--}}
                                        {{--                                        </tr>--}}
                                        {{--                                        </thead>--}}
                                        {{--                                        <tbody>--}}
                                        {{--                                        @php--}}
                                        {{--                                            $startDate = \Carbon\Carbon::parse($from_date);--}}
                                        {{--                                            $endDate = \Carbon\Carbon::parse($to_date);--}}
                                        {{--                                            $index = 0;--}}
                                        {{--                                            $weekDays = \App\Models\WeekDaysModel::all()->keyBy('number');--}}
                                        {{--                                        @endphp--}}
                                        {{--                                        @while ($startDate->lte($endDate))--}}
                                        {{--                                            @php--}}
                                        {{--                                                $week_day = $startDate->dayOfWeek;--}}
                                        {{--                                                $off_day = $weekDays[$week_day] ?? null;--}}
                                        {{--                                                $attendance_info = $attendance_records->where('student_id',$student_id)->where('date',$startDate->format('Y-m-d'))->first();--}}
                                        {{--                                                $holiday_info = \App\Models\HolidayModel::where('date',$startDate->format('Y-m-d'))->first();--}}
                                        {{--                                            @endphp--}}
                                        {{--                                            @if($off_day && $off_day->is_active == 1)--}}
                                        {{--                                                @php $startDate->addDay(); @endphp--}}
                                        {{--                                                @continue--}}
                                        {{--                                            @endif--}}
                                        {{--                                            <tr>--}}
                                        {{--                                                <td> {{ ++$index }}</td>--}}
                                        {{--                                                <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $startDate->format('Y-m-d') }}</td>--}}
                                        {{--                                                <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $startDate->format('D') }}</td>--}}
                                        {{--                                                <td>{{  $attendance_info->status ?? '--' }}</td>--}}
                                        {{--                                                <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $holiday_info ? $holiday_info->name : '' }}</td>--}}
                                        {{--                                                @php--}}
                                        {{--                                                    $startDate->addDay();--}}
                                        {{--                                                @endphp--}}
                                        {{--                                            </tr>--}}
                                        {{--                                        @endwhile--}}
                                        {{--                                        </tbody>--}}
                                        {{--                                    </table>--}}

                                        <table class="mt-3 table table-hover text-nowrap" id="dataTable">
                                            <thead style="background-color: #EAEAEA">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>In Time</th>
                                                <td>Out Time</td>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $startDate = \Carbon\Carbon::parse($from_date);
                                                $endDate = \Carbon\Carbon::parse($to_date);
                                                $index = 0;
                                                $weekDays = \App\Models\WeekDaysModel::all()->keyBy('number');
                                            @endphp
                                            @while ($startDate->lte($endDate))
                                                @php
                                                    $week_day = $startDate->dayOfWeek;
                                                    $off_day = $weekDays[$week_day] ?? null;
                                                    $attendance_info = $attendance_records->where('user_id',$student_id)->where('date',$startDate->format('Y-m-d'))->first();
                                                    $holiday_info = \App\Models\HolidayModel::where('date',$startDate->format('Y-m-d'))->first();
                                                @endphp
                                                @if($off_day && $off_day->is_active == 1)
                                                    @php $startDate->addDay(); @endphp
                                                    @continue
                                                @endif
                                                <tr>
                                                    <td> {{ ++$index }}</td>
                                                    <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $startDate->format('Y-m-d') }}</td>
                                                    <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $startDate->format('D') }}</td>
                                                    <td>{{  $attendance_info->check_in ?? '--' }}</td>
                                                    <td>{{ $attendance_info->check_out ?? '--' }}</td>
                                                    <td class="{{ $holiday_info ? 'text-danger' : '' }}">{{ $holiday_info ? $holiday_info->name : '' }}</td>
                                                    @php
                                                        $startDate->addDay();
                                                    @endphp
                                                </tr>
                                            @endwhile
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
        </section>
    </div>
    <script>
        $('#attendance-management').addClass('menu-open');
        $('#attendance-report').addClass('active');
    </script>
@endsection
