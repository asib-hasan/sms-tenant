@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Employee Management</li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('components.alert')
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">New Employee</h3>
                        </div>
                        <form method="post" class="form-prevent" action="{{ route('empmgt/employee/store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Name">First Name<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Gender<span style="color: red">*</span></label>
                                        <select class="form-control" name="gender" required>
                                            <option value="">Select</option>
                                            <option @selected(old('gender')=='male') value="male">Male</option>
                                            <option @selected(old('gender')=='female') value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="designation">Designation<span style="color: red">*</span></label>
                                        <select name="designation_id" class="form-control select2" style="width:100%" required>
                                            <option value="">Select</option>
                                            @foreach ($designation_list as $i)
                                            <option @selected(old('designation_id')==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Joining Date<span style="color: red">*</span></label>
                                        <input type="date" class="form-control" name="joiningdate" value="{{ old('joiningdate') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Mobile Number<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input">
                                                <label class="custom-file-label">Choose image</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Name">National ID</label>
                                        <input type="text" class="form-control" name="national_id" value="{{ old('national_id') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Blood Group</label>
                                        <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Name">Employee Type<span style="color: red">*</span></label>
                                        <select class="form-control" name="type" id="isTeacher" required>
                                            <option value="">Select</option>
                                            <option @selected(old('type')=='0') value="0">Academic</option>
                                            <option @selected(old('type')=='1') value="1">Administrative</option>
                                            <option @selected(old('type')=='2') value="2">Others</option>
                                            <option @selected(old('type')=='3') value="3">Academic & Administrative</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" name="email" value="{{old('email')}}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#employee-management').addClass('menu-open');
        $('#add-new-employee').addClass('active');
    </script>
    @endsection
