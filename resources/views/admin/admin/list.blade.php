@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Admin List</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <style>
            .add-new:hover{
                cursor: pointer;
            }
        </style>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success" id="success-alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="col-sm-12">
                                <a href="{{route('admin/admin/add')}}"><i class="fa fa-plus-square add-new" style="font-size:30px;color:#4D2C78"></i> </a>
                            </div>

                        </div>
                        @php
                            $cnt = 0;
                        @endphp
                        <!-- /.card-header -->
                        <style>
                            td,
                            th {
                                border: 1px solid #ddd;
                                text-align: center;
                            }
                        </style>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($getRecord as $i)
                                    @if ($i->email!='dev@mail.com')
                                        <tr>
                                            <td>{{ ++$cnt }}</td>
                                            <td>{{ $i->name }}</td>
                                            <td>{{ $i->email }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>

                                                <a href="{{route('admin/admin/edit/'.$i->id)}}" class="btn btn-primary icon-btn a-btn-slide-text">
                                                    <span class="fas fa-edit" aria-hidden="true"></span>
                                                    <span><strong>Edit</strong></span>
                                                </a>
                                                <a href="{{route('admin/admin/delete/'.$i->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-primary icon-btn a-btn-slide-text">
                                                   <span class="fas fa-trash" aria-hidden="true"></span>
                                                    <span><strong>Delete</strong></span>
                                                </a>


                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
    </div>
    </section>
    </div>

    <script>
        $(document).ready(function() {
            $("#success-alert").fadeTo(1000, 500).slideUp(500, function() {
                $("#success-alert").slideUp(500);
            });
        });


    </script>
@endsection
