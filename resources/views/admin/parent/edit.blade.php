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
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Parent</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="{{ route('admin/parent/update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $getRecord->id }}" name="id">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="Name">First Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ $getRecord->first_name }}" placeholder="Enter first name">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="Name">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $getRecord->last_name }}"
                                                name="last_name" placeholder="Enter last name">
                                        </div>




                                        <div class="form-group col-6">
                                            <label for="Name">Gender<span style="color: red">*</span></label>
                                            <select class="form-control" name="gender">
                                                <option {{ $getRecord->gender == 'male' ? 'selected' : '' }} value="male">
                                                    Male</option>
                                                <option {{ $getRecord->gender == 'female' ? 'selected' : '' }} value="female">
                                                    Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="Name">Occupation<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="occupation"
                                                value="{{ $getRecord->occupation }}" placeholder="Enter occupation">
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="Name">Mobile Number</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $getRecord->phone }}" placeholder="Enter mobile number">
                                        </div>


                                        <div class="form-group col-6">
                                            <label for="Name">Photo</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="Name">Address</label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Enter address" value="{{ $getRecord->address }}">
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="Name">Status<span style="color: red">*</span></label>
                                            <select class="form-control" name="status">
                                                <option {{($getRecord->status==0)?'selected':''}} value="0">Active</option>
                                                <option {{($getRecord->status==0)?'selected':''}} value="1">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Email address<span
                                                    style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter email" value="{{ $getRecord->email }}">
                                            <div style="color: red">
                                                {{ $errors->first('email') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Password <span style="color: red">*</span> </label>
                                            <input type="text" class="form-control" name="password" id="password"
                                                placeholder="Make password">
                                            <span class="btn btn-secondary" onclick="randomPassword()">Generate
                                                Password</span>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->


                                    <button type="submit" class="btn btn-primary">Update</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var today = new Date();
                var formattedDate = today.toISOString().substr(0, 10);
                document.getElementById("today").value = formattedDate;

                function randomPassword() {
                    console.log('Hello');
                    var pass =
                        Math.random().toString(36).slice(2) +
                        Math.random().toString(36)
                        .toUpperCase().slice(2);

                    document.getElementById('password').value = pass;
                }
            </script>
        </section>
    @endsection
