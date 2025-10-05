@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Employee Attendance</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Management</li>
                            <li class="breadcrumb-item active">Student Attendance</li>
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
                        <form action="{{ route('atmgt/employee') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Employee Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            <option value="0" @selected($type == '0')>Academic</option>
                                            <option value="1" @selected($type == '1')>Non-Academic</option>
                                            <option value="2" @selected($type == '2')>Others</option>
                                            <option value="3" @selected($type == '3')>Academic & Non-Academic</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date" value="{{ $date }}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                        <a href="{{ route('atmgt/employee') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if($flag == 1)
                        @if($new_entry == 1)
                        <div class="table-responsive p-2 table-bordered">
                            <form class="form-prevent" action="{{ route('atmgt/employee/store') }}" method="POST">
                                <input type="hidden" name="date" value="{{ Helper::encrypt_decrypt('encrypt',$date) }}">
                                @csrf
                                <table class="table table-hover text-nowrap" id="dataTable">
                                    <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <td colspan="6" class="font-weight-bold text-maroon">
                                            Date - {{ $date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 45%">Name</th>
                                        <th style="width: 25%">Designation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($employee_list as $i)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <select name="status[{{ $i->employee_id }}]" style="border: 1px solid #ddd;border-radius: 5px;padding: 2px">
                                                <option value="P">Present</option>
                                                <option value="A">Absent</option>
                                            </select>
                                        </td>
                                        <td>{{ $i->employee_id }}</td>
                                        <td>{{ $i->first_name ?? '' }} {{ $i->last_name ?? '' }}</td>
                                        <td>{{ $i->designation_info->name ?? '' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-danger">No records</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                @if($employee_list->isNotEmpty())
                                    <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">SUBMIT</button>
                                @endif
                            </form>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="alert alert-primary">
                                <span>Attendance records already exist for date - {{ $date }}. Update if needed</span>
                            </div>
                        </div>
                        <div class="table-responsive p-2 table-bordered">
                            <form action="{{ route('atmgt/employee/delete') }}" onclick="return confirm('Are you sure you want to delete this record?')" method="POST">
                                @csrf
                                <input type="hidden" name="date" value="{{ Helper::encrypt_decrypt('encrypt',$date) }}">
                                <button type="submit" class="btn btn-danger font-weight-bold mb-1"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                            <form class="form-prevent" action="{{ route('atmgt/employee/update') }}" method="POST">
                                <input type="hidden" name="date" value="{{ Helper::encrypt_decrypt('encrypt',$date) }}">
                                @csrf
                                <table class="table table-hover text-nowrap" id="dataTable">
                                    <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <td colspan="6" class="font-weight-bold text-maroon">
                                            Date - {{ $date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 45%">Name</th>
                                        <th style="width: 25%">Designation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($record_list as $i)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <select name="status[{{ $i->id }}]" style="border: 1px solid #ddd;border-radius: 5px;padding: 2px">
                                                    <option value="P" @selected($i->status == 'P')>Present</option>
                                                    <option value="A" @selected($i->status == 'A')>Absent</option>
                                                </select>
                                            </td>
                                            <td>{{ $i->employee_id }}</td>
                                            <td>{{ $i->employee_info->first_name ?? '' }} {{ $i->employee_info->last_name ?? '' }}</td>
                                            <td>{{ $i->employee_info->designation_info->name ?? '' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-danger">No records</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                @if($employee_list->isNotEmpty())
                                    <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">UPDATE</button>
                                @endif
                            </form>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#attendance-management').addClass('menu-open');
        $('#employee-attendance').addClass('active');
    </script>
@endsection
