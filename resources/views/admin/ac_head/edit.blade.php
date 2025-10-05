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
              <li class="breadcrumb-item active">Account Settings</li>
              <li class="breadcrumb-item active">AC Head</li>
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
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Edit AC Head</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{route('admin/ac_head/edit/'.$getRecord->id)}}" enctype="multipart/form-data">
                 @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="Name">AC Head Name</label>
                      <input type="text" class="form-control" id="name" value="{{$getRecord->name}}" name="name" placeholder="Enter class name">
                  </div>

                  <div class="form-group">
                    <label for="Name">Category</label>
                    <select class="form-control" name="category_type">
                      <option {{($getRecord->category_type=='income')?'selected':''}} value="income">Income</option>
                      <option {{($getRecord->category_type=='expense')?'selected':''}} value="expense">Expense</option>
                      <option {{($getRecord->category_type=='capital')?'selected':''}} value="capital">Capital</option>
                    </select>
                 </div>


                    <div class="form-group">
                      <label for="Name">Status</label>
                      <select class="form-control" name="status">
                        <option {{($getRecord->status==0)?'selected':''}} value="0">Active</option>
                        <option {{($getRecord->status==1)?'selected':''}} value="1">Inactive</option>
                      </select>
                    </div>
                  <!-- /.card-body -->
                    <button type="submit" class="btn btn-primary btn-custom">UPDATE</button>

                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
