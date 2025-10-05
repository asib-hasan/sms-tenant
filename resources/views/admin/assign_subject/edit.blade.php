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
          <div class="alert alert-success">
            {{Session::get('success')}}
          </div>
          @endif
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title font-weight-bold">Edit Assign Subject</h3>
            </div>

            <form method="post" action="{{route('admin/assign_subject/edit/'.$getRecord->id)}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <div class="form-group">
                    <label for="Name">Class</label>
                    <select class="form-control" name="class_id" required>
                      <option value="">Select Class</option>
                      @foreach ($getClass as $i)
                      <option {{($getRecord->class_id==$i->id)?'selected':''}} value="{{$i->id}}">{{$i->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Subject Name</label>

                  @foreach ($getSubject as $i)
                  @php
                  $checked = '';
                  @endphp
                  @foreach ($getAssignSubjectID as $x)
                  @if ($x->subject_id == $i->id)
                  @php
                  $checked = 'checked';
                  @endphp
                  @endif
                  @endforeach
                  <div>
                    <label style="font-weight: normal">
                      <input {{$checked}} type="checkbox" value="{{$i->id}}" name="subject_id[]"> {{$i->name}}
                    </label>
                  </div>
                  @endforeach
                </div>

                <button type="submit" class="btn btn-primary btn-custom">UPDATE</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection
