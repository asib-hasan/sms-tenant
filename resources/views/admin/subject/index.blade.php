@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Academic Settings</li>
                            <li class="breadcrumb-item active">Subject</li>
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
                        @can('subject_add', 25)
                            <div class="card-header">
                                <button data-toggle="modal" data-target="#modal-add" class="btn btn-primary btn-custom"><i class="fa fa-plus mr-2"></i>Add New</button>
                            </div>
                            <div class="modal fade" id="modal-add">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title font-weight-bold">Add Subject</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('subject/store') }}" class="form-group" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="Name">Subject Name</label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Name">Type</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <option value="0">Theory</option>
                                                        <option value="1">Practical</option>
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
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                                <button type="submit" class="btn btn-primary btn-custom">SAVE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <input class="form-control print-none rounded-0" type="text" id="searchInput"
                            placeholder="Type anything to search">
                        <div class="table-responsive-lg table-bordered p-2">
                            <table class="table table-hover text-nowrap" id="dataTable">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th>#</th>
                                        <th>Subject Name</th>
                                        <th>Type</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Status</th>
                                        @if (Helper::canAny(auth()->user(), [25, 26]))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subject_list as $i)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $i->name }}</td>
                                            <td>{{ $i->type == 0 ? 'Theory' : 'Practical' }}</td>
                                            <td>{{ $i->created_by }}</td>
                                            <td>{{ $i->updated_by }}</td>
                                            <td>
                                            @if ($i->status == 0)
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                                            @else
                                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                            @endif
                                            </td>
                                            @if (Helper::canAny(auth()->user(), [26, 27]))
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>

                                                    <div class="dropdown-menu" role="menu">
                                                        @can('subject_edit', 26)
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#modal-{{$i->id}}"><i class="fa fa-edit"></i> Edit</a>
                                                        @endcan
                                                        @can('subject_delete', 27)
                                                        <a class="dropdown-item" href="{{ route('subject/delete', ['id' => Helper::encrypt_decrypt('encrypt',$i->id)]) }}"
                                                           onclick="return confirm('Are you sure you want to delete this item?');">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                        @endcan
                                                    </div>
                                                    <div class="modal fade" id="modal-{{$i->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title font-weight-bold">Edit Subject</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('subject/update') }}" class="form-group" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt',$i->id) }}">
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="Name">Subject Name</label>
                                                                            <input type="text" class="form-control" name="name" value="{{ $i->name }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="Name">Type</label>
                                                                            <select name="type" class="form-control" required>
                                                                                <option value="">Select</option>
                                                                                <option value="0" @selected($i->type==0)>Theory</option>
                                                                                <option value="1" @selected($i->type==1)>Practical</option>
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
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                                                        <button type="submit" class="btn btn-primary btn-custom">SAVE</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
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
         $('#academic-settings').addClass('menu-open');
         $("#subject").addClass('active');
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
