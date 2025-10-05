@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header print-none">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Employee Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Employee Management</li>
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
                                            <form action="{{ route('empmgt/profile') }}" target="_blank" method="GET">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label>Enter Employee ID</label>
                                                        <input type="text" name="employee_id" class="form-control" value="{{ '240026' }}" required>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
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
        $('#employee-management').addClass('menu-open');
        $('#emp-profile').addClass('active');
    </script>
@endsection
