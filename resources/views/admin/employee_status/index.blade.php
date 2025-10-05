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
                                            <a class="nav-link active" href="#">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('hrmgt/employee/status/resigned/records') }}">Resigned Record</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{route('hrmgt/employee/status')}}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 form-group">
                                                        <label for="">Employee</label>
                                                        <select name="employee_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach ($employee_list as $i)
                                                                <option @selected($employee_id==$i->employee_id) value="{{ $i->employee_id }}">{{ $i->first_name }} {{ $i->last_name }} [{{ $i->employee_id }}]</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-3 font-weight-bold">SEARCH</button>
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
                        <div class="row">
                            <div class="col-md-12 ml-0">
                                <div class="card bg-light ">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 text-center mt-4">
                                                @if ($employee_info->image!="")
                                                    <img src = "{{ asset('uploads/teachers/'. $employee_info->image)}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @else
                                                    <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                                @endif
                                            </div>
                                            <div class="col-md-9 mt-4">
                                                <table class="table table-bordered table-responsive-lg">
                                                    <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Name</td>
                                                        <td>{{ $employee_info->first_name }} {{ $employee_info->last_name }}</td>
                                                        <td class="font-weight-bold">Designation</td>
                                                        <td>{{ $employee_info->designation_info->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">ID</td>
                                                        <td>{{ $employee_info->employee_id }}</td>
                                                        <td class="font-weight-bold">Email</td>
                                                        <td>{!! $employee_info->email !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Gender</td>
                                                        <td>{{ $employee_info->gender }}</td>
                                                        <td class="font-weight-bold">Phone</td>
                                                        <td>{{ $employee_info->phone }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="form-prevent" action="{{ route('hrmgt/employee/status/update') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$employee_info->employee_id) }}" name="employee_id">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="" class="form-label">Status</label>
                                        <select name="status" id="status" onchange="update_status()" class="form-control">
                                            <option value="0" @selected($employee_info->status == 0)>Active</option>
                                            <option value="1" @selected($employee_info->status == 1)>Inactive</option>
                                            <option value="2" @selected($employee_info->status == 2)>Resigned</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Resign Date</label>
                                        <input type="date" id="resign_date" name="resign_date" value="{{ $employee_info->resigned_date }}" class="form-control" @disabled($employee_info->status == 0 || $employee_info->status == 1)>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <button type="submit" class="form-class-multiple-submit btn btn-primary btn-custom mt-3">UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#hr-management').addClass('menu-open');
        $('#employee-status').addClass('active');
    </script>
    <script>
        function update_status() {
            const status = document.getElementById("status").value;
            const resignDate = document.getElementById("resign_date");

            if (status == "2") {
                resignDate.disabled = false;
                resignDate.required = true;
            } else {
                resignDate.disabled = true;
                resignDate.required = false;
                resignDate.value = "";
            }
        }
    </script>
@endsection
