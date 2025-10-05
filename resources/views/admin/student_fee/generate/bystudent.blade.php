@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Fee Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Accounts</li>
                            <li class="breadcrumb-item active">Fee Structure</li>
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
                                            <a class="nav-link active" href="{{ route('stdacc/fee/structure/by/student') }}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdacc/fee/structure/by/class') }}">By Class</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('stdacc/fee/structure/by/school') }}">By Classes</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('stdacc/fee/structure/by/student') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 form-group">
                                                        <label>Session</label>
                                                        <select id="session_wise_active_student" class="form-control select2" name="session_id" style="width: 100%;" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                                <option @selected($session_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Student</label>
                                                        <select id="active_student_load" class="form-control select2" style="width: 100%" name="student_id" required>
                                                            <option value="">Select</option>
                                                            @foreach ($student_list as $i)
                                                                <option @selected($i->student_id == $student_id) value="{{ $i->student_id }}">{{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }} [{{ $i->student_id }}]</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-2">SEARCH</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @if ($flag==1)
            <div class="row">
                <div class="col-md-12 ml-0">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-3 text-center mt-4">
                                    @if ($student_reg_info->student_info->photo !== '')
                                        <img src = "{{ asset('uploads/students/' . $student_reg_info->student_info->photo) }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                    @else
                                        <img src = "{{ asset('photos/user.png') }}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                    @endif
                                </div>
                                <div class="col-md-9 mt-4">
                                    <table class="table table-bordered table-responsive-lg">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Name</td>
                                                <td>{{ $student_reg_info->student_info->first_name }} {{ $student_reg_info->student_info->last_name }}</td>
                                                <td class="font-weight-bold">Class</td>
                                                <td>{{ $student_reg_info->class_info->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Roll</td>
                                                <td>{{ $student_reg_info->roll_no }}</td>
                                                <td class="font-weight-bold">Phone</td>
                                                <td>{!! $student_reg_info->student_info->mobile !!}</td>

                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Gender</td>
                                                <td>{{ $student_reg_info->student_info->gender }}</td>
                                                <td class="font-weight-bold">Session</td>
                                                <td>{{ $student_reg_info->session_info->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($flag==1)
            <div class="row">
                <div class="col-md-12 ml-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="font-weight: bold"> Fees Information <a style="font-size: 15px;float: right" target="_blank" href="{{ route('stdacc/dues/student?student_id=' . $student_reg_info->student_id . '&session_id='. $session_id) }}"><i class="fa fa-eye"></i> View Details</a></h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('stdacc/fee/structure/apply/student') }}" class="form-prevent" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $student_reg_info->id }}" name="student_reg_id">
                                <input type="hidden" value="{{ $session_id }}" name="session_id">

                                <label>Session</label>
                                <select id="fees-head" class="form-control" name="session_id" disabled >
                                    <option value="">Select</option>
                                    @foreach ($session_list as $i)
                                        <option @selected($session_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>

                                <label>Fees Head</label>
                                <select class="form-control select2" style="width: 100%" name="ac_head_id" required>
                                    <option value="">Select</option>
                                    @foreach ($ac_head_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>

                                <label for="months">Months</label>
                                <select class="form-control" name="months[]" id="months" multiple required>
                                    @foreach($month_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>

                                <label for="waiver">Amount</label>
                                <input class="form-control" type="number" step="0.01" name="amount" required>
                                <button type="submit" class="btn btn-primary btn-custom mt-3 form-prevent-multiple-submit">GENERATE/UPDATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        </section>
    </div>

    <script>
        $('#student-accounts').addClass('menu-open');
        $('#fee-structure').addClass('active');
    </script>
@endsection
