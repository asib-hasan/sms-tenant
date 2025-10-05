@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><b>Mark Entry</b></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Result Management</li>
                            <li class="breadcrumb-item active">Mark Entry</li>
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
                        <form action="{{ route('rmgt/mark/entry') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Exam</label>
                                        <select class="form-control select2" name="exam_id" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($exam_list as $i)
                                                <option value="{{ $i->exam_id }}">{{ $i->exam_info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Class</label>
                                        <select class="form-control select2" name="class_id" id="class_select" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option value="{{ $i->class_id }}">{{ $i->class_info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Subject</label>
                                        <select class="form-control select2" name="subject_id" id="subject_select" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($subject_list as $i)
                                            <option value="{{ $i->subject_id }}">{{ $i->subject_info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Session</label>
                                        <select name="session_id" id="" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->session_id }}">{{ $i->session_info->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:20px;">SEARCH</button>
                                        <a href="{{ route('rmgt/mark/entry/search') }}" class="btn btn-success font-weight-bold" style="margin-top: 20px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    <script>
        $('#result-management').addClass('menu-open');
        $("#mark-entry").addClass('active');
    </script>

@endsection
