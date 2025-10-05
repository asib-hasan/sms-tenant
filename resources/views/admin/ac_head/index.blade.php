@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Account Head</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                        <li class="breadcrumb-item active">Account Head</li>
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
                            <form method="post" action="{{ route('account/head/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Name">Account Head</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="Name">Category</label>
                                      <select class="form-control" name="category_type" required>
                                        <option value="">Select</option>
                                        <option value="0">Income</option>
                                        <option value="1">Expense</option>
                                      </select>
                                   </div>

                                    <div class="form-group">
                                      <label for="Name">Status</label>
                                      <select class="form-control" name="status" required>
                                        <option value="">Select</option>
                                        <option value="0">Active</option>
                                        <option value="1">Inactive</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                    <input class="form-control print-none rounded-0" type="text" id="searchInput" placeholder="Type anything to search">
                    <div class="card-body table-responsive-lg p-2 text-nowrap">
                        <table class="table table-bordered table-hover " id="dataTable">
                            <thead style="background-color: #EAEAEA">
                                <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Category Type</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($head_list as $i)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $i->name }}</td>
                                    <td>
                                        @if ($i->status==0)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                        @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ ($i->category_type==0)?'Income':'Expense' }}</td>

                                    <td>{{ $i->created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#modal-{{ $i->id }}" href="javascript:void(0)"><i class="fa fa-edit"></i> Edit</a>
                                                <a class="dropdown-item" href="{{ route('account/head/delete', ['id' => Helper::encrypt_decrypt('encrypt',$i->id)]) }}"
                                                   onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal-{{ $i->id }}">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h4 class="modal-title font-weight-bold">Edit Record</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <form method="post" action="{{ route('account/head/update') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$i->id) }}" name="id">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="Name">Account Head</label>
                                                            <input type="text" class="form-control" name="name" value="{{$i->name}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="Name">Category</label>
                                                          <select class="form-control" name="category_type" required>
                                                            <option value="">Select</option>
                                                            <option value="0" @selected($i->category_type==0)>Income</option>
                                                            <option value="1" @selected($i->category_type==1)>Expense</option>
                                                          </select>
                                                       </div>

                                                        <div class="form-group">
                                                          <label for="Name">Status</label>
                                                          <select class="form-control" name="status" required>
                                                            <option value="">Select</option>
                                                            <option value="0" @selected($i->status==0)>Active</option>
                                                            <option value="1" @selected($i->status==1)>Inactive</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                                    </div>
                                                </form>
                                              </div>
                                            </div>
                                        </div>
                                    </td>
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
    $('#accounts-settings').addClass('menu-open');
    $('#account-head').addClass('active');
</script>

<script>
    $('#searchInput').on('input', function () {
            var searchTerm = $(this).val().toLowerCase();
            filterTable(searchTerm);
        });
        function filterTable(searchTerm) {
            $('#dataTable tbody tr').each(function () {
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
