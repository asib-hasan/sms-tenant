@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Employee ID Card</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Employee Management</li>
                            <li class="breadcrumb-item active">ID Card</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('empmgt/id-card/employee/generate') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="Name">By Employee</label>
                                        <input type="text" class="form-control" name="employee_id" value="{{ '240026' }}" placeholder="Enter employee id" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom font-weight-bold" type="submit"
                                            style="margin-top:30px;">GENERATE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @include('components.alert')
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#employee-management').addClass('menu-open');
        $('#employee-id-card').addClass('active');
    </script>
@endsection
