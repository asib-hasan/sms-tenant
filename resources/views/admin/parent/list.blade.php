@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Parent</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Parent</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-12">
                            <a href="{{ route('admin/parent/add') }}">
                                <i class="fa fa-plus-square" style="font-size:30px;color:#4D2C78"></i>
                            </a>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Occupation</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($getRecord as $i)
                                  <tr>
                                      <td>{{$i->id}}</td>
                                      <td><img src="{{ asset('uploads/parents/'. $i->image)}}" height="40px" width="50px"></td>
                                      <td>{{$i->first_name}} {{$i->last_name}}</td>
                                      <td>{{$i->email}}</td>
                                      <td>{{$i->Occupation}}</td>
                                      <td>{{$i->created_at}}</td>
                                      <td>
                                        <a href="{{route('admin/parent/edit/'.$i->id)}}" class="btn btn-primary">Edit</a>
                                        <a href="{{route('admin/parent/delete/'.$i->id)}}"class="btn btn-danger">Delete</a>
                                        <a href="{{route('admin/parent/my-student/'.$i->id)}}"class="btn btn-primary">My Student</a>

                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding: 10px;float: right">
                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    </section>
    </div>
@endsection
