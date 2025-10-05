@extends('layout.sidebar')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Send SMS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">SMS Service</li>
                        <li class="breadcrumb-item active">Send SMS</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('components.alert')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">By Student</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/employee') }}">By Employee</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/class') }}">By Class</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/designation') }}">By Designation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/number') }}">By Number</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('send-sms/by/student') }}" method="get">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="col-md-6">
                                                <label for="">Enter Student ID</label>
                                                <input type="text" name="student_id" value="{{ $student_id }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <button type="submit" class="btn btn-primary btn-custom mt-4 font-weight-bold">SEARCH</button>
                                            </div>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($flag == 1)
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-4">
                                        @if ($student_info->photo!="")
                                        <img src = "{{ asset('uploads/students/'. $student_info->photo)}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @else
                                        <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @endif
                                    </div>
                                    <div class="col-md-9 mt-4 table-responsive-lg">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="font-weight-bold">Name</td>
                                                    <td>{{ $student_info->first_name }} {{ $student_info->last_name }}</td>
                                                    <td class="font-weight-bold">Father Name</td>
                                                    <td>{{ $student_info->father }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Blood Group</td>
                                                    <td>{{ $student_info->blood }}</td>
                                                    <td class="font-weight-bold">Phone</td>
                                                    <td>{!! $student_info->mobile!!}</td>

                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Gender</td>
                                                    <td>{{ $student_info->gender }}</td>
                                                    <td class="font-weight-bold">Address</td>
                                                    <td>{{ $student_info->address }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{route('send-sms/student/send')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $student_info->student_id }}" name="student_id">
                    <div class="card p-3">
                        <div class="col-lg-6">
                            <label for="sms_text" class="form-label">SMS Text</label>
                            <textarea name="sms_text" id="sms_text" class="form-control" rows="7" aria-valuetext="Please clear this SMS. Write your message here. This is for demo only." required>Please clear this SMS. Write your message here. This is for demo only.</textarea>
                            <button type="submit" class="btn btn-primary btn-custom mt-2">SEND SMS</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </section>
</div>
<script>
    $('#sms-service').addClass('menu-open');
    $('#send-sms').addClass('active');
</script>
@endsection
