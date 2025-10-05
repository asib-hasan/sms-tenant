@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Declare Holiday</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">HR Management</li>
                        <li class="breadcrumb-item active">Declare Holiday</li>
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
                        <button data-toggle="modal" data-target="#modal-add" class="btn btn-primary btn-custom"><i class="fa fa-plus mr-2"></i>Add New</button>
                    </div>
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title font-weight-bold">Add New</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method="post" action="{{ route('hrmgt/declare/holiday/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="Name">From Date</label>
                                        <input type="date" class="form-control" name="from_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">To Date</label>
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive-lg p-2 text-nowrap">
                        <form action="{{ route('hrmgt/declare/holiday') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label>Year</label>
                                    <select name="year" class="form-control">
                                        @for($i=date('Y'); $i>=2015; $i--)
                                            <option value="{{ $i }}" @selected($year == $i)>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button class="btn btn-success mt-3 font-weight-bold">FILTER</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-hover mt-2">
                            <thead style="background-color: #EAEAEA">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($holiday_list as $i)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $i->name }}</td>
                                    <td>{{ $i->from_date }}</td>
                                    <td>{{ $i->to_date }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item"
                                                   href="{{ route('hrmgt/declare/holiday/delete', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}"
                                                   onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-danger">No records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#hr-management').addClass('menu-open');
    $('#declare-holiday').addClass('active');
</script>
@endsection
