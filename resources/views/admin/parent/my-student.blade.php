@extends('layout.sidebar')
@section('content')
@php
    use \App\Model\Student;
@endphp

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Parent Student List </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Simple Tables</li>
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
                        <h3 class="card-title">Search Student to Assign </h3>
                    </div>
                    <form action="" method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>ID</label>
                                    <input type="text" class="form-control" name="id" value="{{Request::get('id')}}"
                                    placeholder="Search by id">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{Request::get('name')}}"
                                    placeholder="Search by name">
                                </div>

                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary" type="submit" style="margin-top:30px;">Search</button>
                                    <a href="{{route('admin/parent/my-student',['parent_id'=> $parentId])}}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            @if (Request::get('name') || Request::get('id'))
                            <div class="card-header">
                                <h3 class="card-title">Search Result</h3>
                            </div>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                              @foreach ($getRecord as $i)

                                  <tr>
                                      <td>{{$i->id}}</td>
                                      <td><img src="{{ asset('uploads/students/'. $i->photo)}}" height="40px" width="50px"></td>
                                      <td>{{$i->first_name}} {{$i->last_name}}</td>
                                      <td>{{$i->gender}}</td>
                                      <td>{{$i->created_at}}</td>
                                      <td>

                                        @if(\App\Models\Student::where('parent_id', $parentId)->where('id',$i->id)->exists())
                                            <button class="btn btn-success">Already assigned</button>
                                        @else
                                            <a href="{{route('admin/parent/assign',['student_id'=> $i->id,'parent_id'=> $parentId])}}" class="btn btn-danger">Assign student</a>
                                        @endif

                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <div class="card-header">
                                <h3 class="card-title">Parent Student List</h3>
                            </div>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($AssignedStudent as $i)
                                  <tr>
                                      <td>{{$i->id}}</td>
                                      <td><img src="{{ asset('uploads/students/'. $i->photo)}}" height="40px" width="50px"></td>
                                      <td>{{$i->first_name}} {{$i->last_name}}</td>

                                      <td>{{$i->gender}}</td>
                                      <td>{{$i->created_at}}</td>
                                      <td>
                                        <a  href="{{route('admin/parent/assigned/delete/'.$i->id)}}"class="btn btn-danger">Delete</a>
                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>

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
