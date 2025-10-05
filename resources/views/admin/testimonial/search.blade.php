@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Testimonial</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Reports Management</li>
                            <li class="breadcrumb-item active">Testimonial</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card">
                        <form action="{{ route('admin/testimonial/generate') }}" method="GET">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="Name">Student ID</label>
                                        <input type="text" class="form-control" name="student_id" value="{{ '20250005' }}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Exam</label>
                                        <select name="exam" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            <option value="SSC">SSC</option>
                                            <option value="HSC">HSC</option>
                                            <option value="Class One">Class One</option>
                                            <option value="Class Two">Class Two</option>
                                            <option value="Class Three">Class Three</option>
                                            <option value="Class Four">Class Four</option>
                                            <option value="Class Five">Class Five</option>
                                            <option value="Class Six">Class Six</option>
                                            <option value="Class Seven">Class Seven</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="educationBoards">Select Education Board:</label>
                                        <select id="educationBoards" name="board" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            <option value="Board of Intermediate and Secondary Education, Barisal">Board of Intermediate and Secondary Education, Barisal</option>
                                            <option value="Board of Intermediate and Secondary Education, Chattogram">Board of Intermediate and Secondary Education, Chattogram</option>
                                            <option value="Board of Intermediate and Secondary Education, Cumilla">Board of Intermediate and Secondary Education, Cumilla</option>
                                            <option value="Board of Intermediate and Secondary Education, Dhaka">Board of Intermediate and Secondary Education, Dhaka</option>
                                            <option value="Board of Intermediate and Secondary Education, Dinajpur">Board of Intermediate and Secondary Education, Dinajpur</option>
                                            <option value="Board of Intermediate and Secondary Education, Jashore">Board of Intermediate and Secondary Education, Jashore</option>
                                            <option value="Board of Intermediate and Secondary Education, Mymensingh">Board of Intermediate and Secondary Education, Mymensingh</option>
                                            <option value="Board of Intermediate and Secondary Education, Rajshahi">Board of Intermediate and Secondary Education, Rajshahi</option>
                                            <option value="Board of Intermediate and Secondary Education, Sylhet">Board of Intermediate and Secondary Education, Sylhet</option>
                                            <option value="Bangladesh Madrasah Education Board">Bangladesh Madrasah Education Board</option>
                                            <option value="Bangladesh Technical Education Board">Bangladesh Technical Education Board</option>
                                            <option value="Self">Self</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Roll Number</label>
                                        <input type="text" class="form-control" name="roll_number" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Registration Number</label>
                                        <input type="text" class="form-control" name="reg_number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Session</label>
                                        <input type="text" class="form-control" name="session_name" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Result</label>
                                        <input type="text" class="form-control" name="result" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Group</label>
                                        <select class="form-control" name="group" id="">
                                            <option value="">Select</option>
                                            <option value="science">Science</option>
                                            <option value="commerce">Commerce</option>
                                            <option value="arts">Arts</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit">GENERATE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $('#report-management').addClass('menu-open');
        $('#testimonial').addClass('active');
    </script>

@endsection
