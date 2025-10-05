@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student ID Card</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">ID Card</li>
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
                        <form action="{{ route('stdmgt/id-card/student/generate') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="Name">Student ID</label>
                                        <input type="text" class="form-control" value="{{ '20240026' }}" name="student_id" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Session</label>
                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach($session_list as $i)
                                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom font-weight-bold" type="submit" style="margin-top:30px;">GENERATE</button>
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
        $('#student-management').addClass('menu-open');
        $('#student-id-card').addClass('active');
    </script>
@endsection
