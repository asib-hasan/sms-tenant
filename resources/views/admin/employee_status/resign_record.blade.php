@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Employee Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">HR Management</li>
                            <li class="breadcrumb-item active">Employee Status</li>
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
                                            <a class="nav-link" href="{{ route('hrmgt/employee/status') }}">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Resigned Record</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{route('hrmgt/employee/status/resigned/records')}}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label>Select Year</label>
                                                        <select name="year" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @for($i = date('Y') + 1; $i>=date('Y')-5; $i--)
                                                                <option value="{{ $i }}" @selected($year == $i)>{{ $i }}</option>
                                                            @endfor
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
                                        <th style="width: 20%">Designation</th>
                                        <th style="width: 20%">Resigned Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($resigned_list as $i)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $i->employee_id }}</td>
                                    <td>{{ $i->first_name }} {{ $i->last_name }}</td>
                                    <td>{{ $i->designation_info->name }}</td>
                                    <td>{{ $i->resigned_date }}</td>
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
        $('#employee-status').addClass('active');
    </script>
@endsection
