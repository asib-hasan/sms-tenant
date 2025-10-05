@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="font-weight-bold">Student Result</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Marks Management</li>
                            <li class="breadcrumb-item active">Student Result</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">By Student</a>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('rmgt/result') }}" method="GET">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Student ID</label>
                                        <input type="text" class="form-control" name="student_id" placeholder="Enter Student Id" required value="{{ $student_id != "" ? $student_id : '20250005' }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Class</label>
                                        <select name="class_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option @selected($i->id == 22) value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Exam</label>
                                        <select name="exam_id" class="form-control select2" style="width:100%" required>
                                            <option value="">Select</option>
                                            @foreach ($exam_list as $i)
                                                <option @selected($i->id == 3) value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Session</label>
                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option @selected($i->id == 2) value="{{ $i->id }}">{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary btn-custom" type="submit">SEARCH</button>
                                        <a href="{{ route('rmgt/result') }}" class="btn btn-success font-weight-bold">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($flag==1)
                <div class="card">
                    <div class="table-responsive p-2">
                        <div class="table-responsive-lg table-bordered">
                            <table class="table table-hover text-nowrap" id="dataTable">
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;background-color:#ECECEC" colspan="4">Student's Name: {{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Class</th>
                                    <td>{{ $student_reg_info->class_info->name }}</td>
                                    <th>Roll</th>
                                    <td>{{ $student_reg_info->roll_no }}</td>
                                </tr>
                                <tr>
                                    <th>Exam</th>
                                    <td>{{ \App\Models\ExamModel::getName($exam_id) }}</td>
                                    <th>Session</th>
                                    <td>{{ \App\Models\SessionModel::getName($session_id) }}</td>
                                </tr>
                                <tr>
                                    <th>Result</th>
                                    <td>{{ $result }}</td>
                                    <th>Marks</th>
                                    <td>{{ $total_mark }}</td>
                                </tr>
                                <tr>
                                    <th>GPA</th>
                                    <td>{{ number_format($gpa,2) }}</td>
                                    <th colspan="2"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-nowrap">
                                <thead>
                                <tr style="background: #ECECEC">
                                    <th colspan="4">Grade Sheet
                                        <form action="{{ route('rmgt/print/result') }}" method="get" style="display: inline">
                                            <input type="hidden" name="student_id" value="{{ $student_reg_info->student_id }}">
                                            <input type="hidden" name="exam_id" value="{{ $exam_id }}">
                                            <input type="hidden" name="class_id" value="{{ $class_id }}">
                                            <input type="hidden" name="session_id" value="{{ $session_id }}">
                                            <button type="submit" class="pdf-button"><i class="fa-solid fa-file-pdf"></i>PDF</button>
                                        </form>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <th>Mark</th>
                                    <th>Letter Grade</th>
                                    <th>Point</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($assigned_subject_list as $i)
                                    @php $data = Helper::getResult($student_id, $i->class_id, $i->subject_id, $session_id, $exam_id); @endphp
                                    <tr>
                                        <td>{{ $i->subject_info->name ?? 'NA' }}</td>
                                        @if ($data != null && $data->mark!=null && $data->is_published!=0)
                                            <td>{{ number_format($data->mark,2) }}</td>
                                            <td>{{ $data->letter_grade }}</td>
                                            <td>{{ number_format($data->grade_point,2) }}</td>
                                        @else
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <script>
            $('#result-management').addClass('menu-open');
            $('#result-sheet').addClass('active');
        </script>
@endsection
