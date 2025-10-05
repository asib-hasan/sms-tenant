@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">HR Management</li>
                            <li class="breadcrumb-item active">Student Status</li>
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
                                            <a class="nav-link" href="{{ route('hrmgt/student/status') }}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Inactive Records</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('hrmgt/student/status/inactive/records') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label>Session</label>
                                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Session</option>
                                                            @foreach($session_list as $i)
                                                                <option value="{{ $i->id }}" @selected($session_id == $i->id)>{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
                                                        <button type="submit" class="btn btn-primary mt-3 btn-custom mt-2 font-weight-bold">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($flag == 1)
                    <div class="card">
                        <div class="table-responsive p-2">
                            <table class="table table-hover text-nowrap table-bordered">
                                <thead style="background-color: #ddd">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 45%">Name</th>
                                        <th style="width: 20%">Class</th>
                                        <th style="width: 20%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($inactive_list as $i)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $i->student_id }}</td>
                                    <td>{{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }}</td>
                                    <td>{{ $i->class_info->name }}</td>
                                    <td>{{ $i->inactive_date }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="5">No records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#hr-management').addClass('menu-open');
        $('#student-status').addClass('active');
    </script>
@endsection
