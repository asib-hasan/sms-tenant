@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Logout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              @if(Session::has('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{Session::get('success')}}
                    </div>
                @endif
              <div class="card card-primary">
                <div class="card-header" >
                  <h3 class="card-title">Add New Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{route('admin/admin/save')}}" enctype="multipart/form-data">
                 @csrf
                  <div class="card-body">

                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{old('name')}}" name="name" placeholder="Enter name">
                        <div style="color: red">
                          {{$errors->first('name')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" value="{{old('email')}}" name="email" placeholder="Enter email">
                        <div style="color: red">
                          {{$errors->first('email')}}
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="Name">Photo</label>
                      <input type="file" class="form-control"
                           name="photo">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Make password">
                      <div style="color: red">
                        {{$errors->first('password')}}
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
