@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Employee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Employee Management</li>
                            <li class="breadcrumb-item active">Employee List</li>
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
                        <div class="card-header">
                            <a href="{{ route('empmgt/employee/add') }}">
                                <button class="btn-custom btn btn-primary"><i class="fa fa-plus"></i> Add New</button>
                            </a>
                        </div>
                        <form action="{{ route('empmgt/employee/search') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" name="employee_id" value="{{ $employee_id }}" placeholder="Search by id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $name }}" placeholder="Search by name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label">Designation</label>
                                        <select name="designation_id" class="form-control select2" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($designation_list as $i)
                                                <option @selected($designation_id==$i->id) value="{{$i->id}}">{{$i->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                        <a href="{{ route('empmgt/employee') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <span>
                            <a target="_blank" class="font-weight-bold ml-2" href="{{ route('empmgt/employee/list/pdf', [
                                'designation_id' => $designation_id,
                                'name' => $name,
                                'employee_id' => $employee_id
                            ]) }}">
                                <i class="fas fa-file-pdf" style="color: red; font-weight: bold;"></i> PDF
                            </a>
                        </span>

                        {{--                        <input class="form-control print-none rounded-0" type="text" id="searchInput" placeholder="Type anything to search">--}}
                        <div class="table-responsive p-2 table-bordered">
                            <table class="table table-hover text-nowrap" id="dataTable">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th style="width: 2%">#</th>
                                        <th style="width: 3%">Photo</th>
                                        <th style="width: 30%">Name</th>
                                        <th style="width: 25%">Email</th>
                                        <th style="width: 10%">Phone</th>
                                        <th style="width: 15%">Designation</th>
                                        <th style="width: 5%">Status</th>
                                        @if (Helper::canAny(auth()->user(), [44, 45, 46]))
                                            <th style="width: 10%">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee_list as $i)
                                        <tr>
                                            <th>{{ $loop->index + 1 }}</th>
                                            <td>
                                                @if ($i->image=="")
                                                <img src="{{ asset('photos/user.png') }}" height="40px" width="50px">
                                                @else
                                                <img src="{{ asset('uploads/teachers/' . $i->image) }}" height="40px" width="50px">
                                                @endif
                                            </td>
                                            <td>{{ $i->first_name }} {{ $i->last_name }}<br><strong>ID:</strong>{{ $i->employee_id }}</td>
                                            <td>{!! $i->email !!}</td>
                                            <td class="font-weight-bold">{{ $i->phone }}</td>
                                            <td>{{ $i->designation_info->name }}</td>
                                            <td>
                                                @if ($i->status == 0)
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                @elseif($i->status == 1)
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                                @elseif($i->status == 2)
                                                    <span class="badge bg-secondary text-dark"><i class="bi bi-person-dash me-1"></i> Resigned</span>
                                                @endif
                                            </td>
                                            @if (Helper::canAny(auth()->user(), [44, 45, 46]))
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button>
                                                        <div class="dropdown-menu" role="menu">
                                                            @can('emp_edit', 44)
                                                                <a class="dropdown-item" href="{{ route('empmgt/employee/edit', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endcan
                                                            @can('emp_profile', 46)
                                                                <a class="dropdown-item" href="{{ route('empmgt/employee/view', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}">
                                                                    <i class="fa fa-eye"></i> View Profile
                                                                </a>
                                                            @endcan
                                                            {{-- @can('emp_delete', 45)
                                                            <a class="dropdown-item"href="{{ route('admin/employee/delete/' . $i->id) }}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</a>
                                                            @endcan --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#employee-management').addClass('menu-open');
        $('#employee-list').addClass('active');
    </script>
    <script>
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterTable(searchTerm);
        });

        function filterTable(searchTerm) {
            $('#dataTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
