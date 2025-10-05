@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Admit Card</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                            <li class="breadcrumb-item active">Admit Card</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">By Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rpmgt/admit/card/by/class') }}">By Class</a>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('rpmgt/admit/card/print/student') }}" method="GET" target="_blank">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="Name">Student ID</label>
                                        <input type="text" class="form-control" name="student_id" value="{{ '20250005' }}" placeholder="Enter student id" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Exam</label>
                                        <select name="exam_id" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($exam_list as $i)
                                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Session</label>
                                        <select name="session_id" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">Generate</button>
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
        $('#report-management').addClass('menu-open');
        $('#admit-card').addClass('active');
    </script>
@endsection
