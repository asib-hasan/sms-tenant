@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Class</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Academic Settings</li>
                        <li class="breadcrumb-item active">Class</li>
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
                    @can('class_add', 13)
                    <div class="card-header">
                        <button data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-custom"><i class="fa fa-plus mr-2"></i>Add New</button>
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title font-weight-bold">Generate Class</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form method="post" action="{{ route('admin/class/store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="Name">Select Class</label>
                                            <select name="class" class="form-control" id="" required>
                                                <option value="">Select</option>
                                                <option value="Play">Play</option>
                                                <option value="Nursery">Nursery</option>
                                                <option value="One">One</option>
                                                <option value="Two">Two</option>
                                                <option value="Three">Three</option>
                                                <option value="Four">Four</option>
                                                <option value="Five">Five</option>
                                                <option value="Six">Six</option>
                                                <option value="Seven">Seven</option>
                                                <option value="Eight">Eight</option>
                                                <option value="Nine">Nine</option>
                                                <option value="Ten">Ten</option>
                                                <option value="Nurani">Nurani</option>
                                                <option value="Kitab">Kitab</option>
                                                <option value="Hefzo">Hefzo</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Name">Select Section</label>
                                            <select name="section" class="form-control" id="">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Name">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="0">Active</option>
                                                <option value="1">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-custom">GENERATE</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    <input class="form-control print-none rounded-0" type="text" id="searchInput" placeholder="Type anything to search">
                    <div class="table-responsive-lg table-bordered p-2">
                        <table class="table table-hover text-nowrap" id="dataTable">
                            <thead style="background-color: #EAEAEA">
                                <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    @if(Helper::canAny(auth()->user(),[14, 15]))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $i)
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
                                <td title="{{ $i->created_at }}">{{ $i->created_by }}</td>
                                <td title="{{ $i->updated_at }}">{{ $i->updated_by }}</td>
                                @if(Helper::canAny(auth()->user(),[14, 15]))
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                @can('class_edit', 14)
                                                <a class="dropdown-item" data-toggle="modal" data-target="#modal_{{$i->id}}" href="#"><i class="fa fa-edit"></i> Edit</a>
                                                @endcan
                                                @can('class_delete', 15)
                                                <a class="dropdown-item" href="{{ route('admin/class/delete', ['id' => Helper::encrypt_decrypt('encrypt',$i->id)]) }}"
                                                   onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                @endcan
                                            </div>
                                            <div class="modal fade" id="modal_{{$i->id}}">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h4 class="modal-title font-weight-bold">Update Status ({{$i->name}})</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <form action="{{ route('admin/class/update') }}" class="form-group" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$i->id)}}">
                                                        <div class="modal-body">
                                                            <select class="form-control" name="status">
                                                                <option @selected($i->status=='0') value="0">Active</option>
                                                                <option @selected($i->status=='1') value="1">Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                                            <button type="submit" class="btn btn-primary btn-custom">UPDATE</button>
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
     $("#class").addClass('active');
</script>
<script>
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
