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
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">Edit Student</li>
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
                                <h3 class="card-title font-weight-bold">Edit Student</h3>
                            </div>
                            <form action="{{ route('stdmgt/student/update') }}" class="form-prevent" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$student_info->id)}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0"> Personal Information:</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">First Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ $student_info->first_name }}" name="first_name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Last Name</label>
                                            <input type="text" class="form-control" value="{{ $student_info->last_name }}" name="last_name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ $student_info->name_bangla }}" name="name_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Blood Group</label>
                                            <input type="text" class="form-control" name="blood_group" value="{{ $student_info->blood_group }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="Name">Nationality</label>
                                            <input type="text" class="form-control" name="nationality" value="{{ $student_info->nationality }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Religion</label>
                                            <input type="text" class="form-control" name="religion" value="{{ $student_info->religion }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Gender<span style="color: red">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option @selected($student_info->gender == 'male') value="male">Male</option>
                                                <option @selected($student_info->gender == 'female') value="female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Date of Birth</label>
                                            <input type="date" class="form-control" value="{{ $student_info->dob }}" name="dob">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Photo</label>
                                            <img src="{{ asset('uploads/students/' . $student_info->photo) }}" class="img-fluid" height="28px" width="28x">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="photo" class="custom-file-input">
                                                    <label class="custom-file-label">Choose image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0">Contact Information:</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Father name</label>
                                            <input type="text" class="form-control" value="{{ $student_info->father }}" name="father">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">পিতার নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ $student_info->father_bangla }}" name="father_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Mother name</label>
                                            <input type="text" class="form-control" value="{{ $student_info->mother }}" name="mother">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">মাতার নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ $student_info->mother_bangla }}" name="mother_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" value="{{ $student_info->mobile }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{ $student_info->email }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ $student_info->address }}">
                                        </div>
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0">Academic Information:</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Admission Number</label>
                                            <input type="text" class="form-control" value="{{ $student_info->admission_number }}" name="admission_number">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Admission Date</label>
                                            <input type="date" name="admission_date" value="{{ $student_info->admission_date }}" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="form-prevent-multiple-submit btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#student-management').addClass('menu-open');
        $('#student-list').addClass('active');
    </script>
@endsection
