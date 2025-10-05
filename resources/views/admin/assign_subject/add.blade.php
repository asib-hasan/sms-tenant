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
              <li class="breadcrumb-item active">Assign Subject</li>
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

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Assign Subject</h3>
                </div>
                <form method="post" action="{{route('admin/assign_subject/save')}}" enctype="multipart/form-data">
                 @csrf
                  <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="Name">Class</label>
                            <select class="form-control" name="class_id" required >
                                <option value="">Select Class</option>
                                @foreach ($getClass as $i)
                                    <option value="{{$i->id}}">{{$i->name}}</option>
                                @endforeach
                            </select>
                          </div>
                    </div>

                    <div class="form-group">
                        <label for="">Subject Name</label>

                        @foreach ($getSubject as $i)
                            <div>
                                <label style="font-weight: normal">
                                    <input type="checkbox" value="{{$i->id}}" name="subject_id[]">  {{$i->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                  <!-- /.card-body -->
                    <button type="submit" class="btn btn-primary btn-custom font-weight-bold">ASSIGN</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
