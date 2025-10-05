@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Attendance Sheet</h1>
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
                        <form action="{{ route('atmgt/print/attendance/sheet') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Class</label>
                                        <select name="class_id" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option value="{{ $i->class_id }}">{{ $i->class_info->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Session</label>
                                        <select name="session_id" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->session_id }}">{{ $i->session_info->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Month</label>
                                        <select name="month" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($month_list as $i)
                                                <option value="{{ $i->id }}">{{ $i->name }}</option>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#attendance-management').addClass('menu-open');
        $('#student-attendance-sheet').addClass('active');
    </script>
@endsection
