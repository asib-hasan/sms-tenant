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
                            <li class="breadcrumb-item active">Edit Employee</li>
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
                                <h3 class="card-title font-weight-bold">Edit Employee</h3>
                            </div>
                            <form class="form-prevent" method="post" action="{{ route('empmgt/employee/update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$employee_info->id)}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="Name">First Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="first_name" value="{{  $employee_info->first_name }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" value="{{  $employee_info->last_name }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Gender<span style="color: red">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="male" @selected($employee_info->gender=='male')>Male</option>
                                                <option value="female" @selected($employee_info->gender=='female')>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="designation">Designation<span style="color: red">*</span></label>
                                            <select name="designation_id" class="form-control select2" style="width: 100%" required>
                                                <option value="">Select</option>
                                                @foreach ($designation_list as $i)
                                                <option value="{{ $i->id }}" @selected($employee_info->designation_id==$i->id)>{{ $i->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="Name">Joining Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="joiningdate" value="{{ $employee_info->joiningdate }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="Name">Mobile Number<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="phone" value="{{ $employee_info->phone }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-label">Photo</label>
                                            <img src="{{ asset('uploads/teachers/' . $employee_info->image) }}" class="img-fluid" height="28px" width="28x">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input">
                                                    <label class="custom-file-label">Choose image</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="Name">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{  $employee_info->address }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="Name">National ID</label>
                                            <input type="text" class="form-control" name="national_id" value="{{  $employee_info->national_id }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Blood Group</label>
                                            <input type="text" class="form-control" name="blood_group" value="{{ $employee_info->blood_group }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Employee Type<span style="color: red">*</span></label>
                                            <select class="form-control" name="type" id="isTeacher" required>
                                                <option value="">Select</option>
                                                <option value="0" @selected($employee_info->type==0)>Academic</option>
                                                <option value="1" @selected($employee_info->type==1)>Administrative</option>
                                                <option value="2" @selected($employee_info->type==2)>Others</option>
                                                <option value="3" @selected($employee_info->type==3)>Academic & Administrative</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" name="email" value="{{ $employee_info->email }}">
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
            $('#employee-list').addClass('active');
        </script>
    @endsection
