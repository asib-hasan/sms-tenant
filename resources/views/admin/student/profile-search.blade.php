@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header print-none">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('stdmgt/student/profile') }}" target="_blank" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Enter Student ID</label>
                                                        <input type="text" name="student_id" value="{{ '20240026' }}" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Session</label>
                                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                                        <option value="">Select</option>
                                                        @foreach($session_list AS $session)
                                                            <option value="{{ $session->id }}" @selected($session->is_current == 0)>{{ $session->name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-2 font-weight-bold">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.alert')
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#student-management').addClass('menu-open');
        $('#student-profile').addClass('active');
    </script>
@endsection
