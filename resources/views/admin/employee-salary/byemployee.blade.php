@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Salary Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Accounts</li>
                            <li class="breadcrumb-item active">Salary Structure</li>
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
                                            <a class="nav-link active" href="{{ route('genacc/salary/structure/employee') }}">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('genacc/salary/structure/designation') }}">By Designation</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('genacc/salary/structure/employee') }}" method="get">
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
                                                    <div class="col-md-6 form-group">
                                                        <label for="fees-head" class="form-label">Session</label>
                                                        <select class="form-control select2" name="session_id" style="width: 100%;" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                                <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
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
                </div>
            </div>
        </section>
        <section class="content">
            @if ($flag==1)
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
                                                <td>{!! wordwrap($employee_info->email, 20, "<br>\n", true)!!}</td>

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
            @endif
            @if($flag==1)
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card">
                            <div class="card-header">
                                <h5 style="font-weight: bold">
                                    Salary Information
                                    <a style="font-size: 15px; float: right" target="_blank"
                                       href="{{ route('genacc/salary/report/employee', [
                                           'employee_id' => $employee_id,
                                           'session_id' => $session_id
                                       ]) }}">
                                        <i class="fa fa-eye"></i> View Details
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body pt-0">
                                <form class="form-prevent" action="{{ route('genacc/salary/structure/employee/apply') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$employee_info->id) }}" name="employee_id">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}" name="session_id">
                                    <label for="fees-head" class="form-label">Session</label>
                                    <select class="form-control" name="session_id" disabled>
                                        <option value="">Select</option>
                                        @foreach ($session_list as $i)
                                            <option value="{{ $i->id }}" @selected($session_id == $i->id)>{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Select Head</label>
                                    <select class="form-control select2" name="ac_head_id" style="width: 100%" required>
                                        <option value="">Select</option>
                                        @foreach ($ac_head_list as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>

                                    <label for="months">Months</label>
                                    <select class="form-control" name="months[]" id="months" multiple required>
                                        @foreach($month_list as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label">Amount</label>
                                    <input class="form-control" type="number" step="0.01" name="amount" required>
                                    <button type="submit" class="form-prevent-multiple-submit btn btn-primary btn-custom mt-3">GENERATE/UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
         </div>
    <script>
        $('#general-accounts').addClass('menu-open');
        $('#salary-structure').addClass('active');
     </script>
@endsection

