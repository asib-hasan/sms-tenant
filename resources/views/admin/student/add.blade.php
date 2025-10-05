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
                            <li class="breadcrumb-item active">New Admission</li>
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
                                <h3 class="card-title font-weight-bold">New Admission</h3>
                            </div>
                            <form action="{{ route('stdmgt/student/store') }}" class="form-prevent" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0">Personal Information:</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">First Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('first_name') }}" name="first_name" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Last Name</label>
                                            <input type="text" class="form-control" value="{{ old('last_name') }}" name="last_name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ old('name_bangla') }}" name="name_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Blood Group</label>
                                            <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Nationality</label>
                                            <input type="text" class="form-control" name="nationality" value="{{ old('nationality') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Religion</label>
                                            <input type="text" class="form-control" name="religion" value="{{ old('religion') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Gender <span style="color: red">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="male" @selected(old('gender') == 'male')>Male</option>
                                                <option value="female" @selected(old('gender') == 'female')>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-label">Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="photo" class="custom-file-input">
                                                    <label class="custom-file-label">Choose image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob">
                                        </div>
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0"> Contact Information:</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Father name</label>
                                            <input type="text" class="form-control" value="{{ old('father') }}" name="father" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">পিতার নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ old('father_bangla') }}" name="father_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Mother name</label>
                                            <input type="text" class="form-control" value="{{ old('mother') }}" name="mother" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">মাতার নাম (বাংলায় লিখুন)</label>
                                            <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^ঀ-৿\s-]/g, '')" value="{{ old('mother_bangla') }}" name="mother_bangla">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                        </div>
                                        <div class="col-12">
                                            <h4 class="font-weight-bold mb-3 mt-3" style="font-size:20px;color:#5B84B0">Academic Information (New Registration):</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Admission Number</label>
                                            <input type="text" class="form-control" name="admission_number">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Session <span style="color: red">*</span></label>
                                            <select name="session_id" class="form-control" required>
                                                <option value="">Select</option>
                                                @foreach($session_list as $session)
                                                    <option value="{{ $session->id }}" @selected($session->is_current == 0)>{{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Admission Date <span style="color: red">*</span></label>
                                            <input type="date" id="today" class="form-control" name="admission_date" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Class <span style="color: red">*</span></label>
                                            <select class="form-control select2" name="class_id" style="width:100%" required>
                                                <option value="">Select</option>
                                                @foreach($class_list as $class)
                                                    <option value="{{ $class->id }}" @selected(old('class_id')==$class->id)>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Shift <span style="color: red">*</span></label>
                                            <select class="form-control select2" name="shift" style="width:100%" required>
                                                <option value="">Select</option>
                                                <option value="0" @selected(old('shift') == '0')>Morning</option>
                                                <option value="1" @selected(old('shift') == '1')>Day</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">Roll Number</label>
                                            <input type="text" class="form-control" value="{{ old('roll_no') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="roll_no">
                                        </div>
                                    </div>
                                    <button type="submit" class="form-prevent-multiple-submit btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#student-management').addClass('menu-open');
                $('#new-admission').addClass('active');
            </script>
            <script>
                var today = new Date();
                var formattedDate = today.toISOString().substr(0, 10);
                document.getElementById("today").value = formattedDate;
            </script>
        </section>
    @endsection
