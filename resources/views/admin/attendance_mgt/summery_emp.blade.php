@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Daily Summary</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Management</li>
                            <li class="breadcrumb-item active">Daily Summary</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('atmgt/daily/summery/std')}}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{route('atmgt/daily/summery/emp')}}">By Employee</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <form action="{{ route('atmgt/daily/summery/emp') }}" method="get">
                                            @csrf
                                            <div class="row mt-0 pt-0">
                                                <div class="col-md-4">
                                                    <label for="">Select Date</label>
                                                    <input type="date" value="{{ $date }}" name="date" class="form-control" required>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <button type="submit" class="btn btn-primary btn-custom mt-4 font-weight-bold">SEARCH</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive mt-4">
                                            <table class="table table-bordered table-sm text-nowrap table-hover">
                                                <thead>
                                                <th style="background-color: rgb(231, 231, 231)" colspan="7">Date wise summery - {{ $date }}</th>
                                                </thead>
                                                <thead>

                                                <th style="width:5%">#</th>
                                                <th style="width:20%">ID</th>
                                                <th style="width:25%">Name</th>
                                                <th style="width:20%">Designation</th>
                                                <th style="width:10%">In Time</th>
                                                <th style="width:10%">Out Time</th>
                                                <th style="width:10%">Working Hours</th>
                                                </thead>
                                                <tbody>
                                                @forelse ($summery_list as $i)
                                                    @php
                                                        $checkIn = new \Carbon\Carbon($i->check_in);
                                                        $checkOut = new \Carbon\Carbon($i->check_out);
                                                        $duration = $checkOut->diff($checkIn)->format('%H:%I:%S');
                                                    @endphp
                                                    @php $user_info =  \App\Models\TeacherModel::where('employee_id',$i->user_id)->select('first_name','last_name','designation_id')->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->index+1 }}</td>
                                                        <td>{{ $i->user_id }}</td>
                                                        <td>{{ $user_info->first_name ?? '' }} {{ $user_info->last_name  ?? ''}}</td>
                                                        <td>{{ $user_info->designation_info->name ?? '' }}</td>
                                                        <td>{{ $checkIn->format('h:i A') }}</td>
                                                        <td>{{ ($i->check_out)?$checkOut->format('h:i A'):'' }}</td>
                                                        <td>{{ ($i->check_out)?$duration:'' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="font-weight-bold text-danger" colspan="7">No records</td>
                                                    </tr>
                                                @endforelse
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
        </section>
    </div>
    <script>
        $('#attendance-management').addClass('menu-open');
        $('#daily-summery').addClass('active');
    </script>
@endsection
