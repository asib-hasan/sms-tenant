@extends('layout.sidebar_student')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Exam Result</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Exam Result</li>
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
                                            <a class="nav-link active" href="#">By Class</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('std/exam/result') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Class</label>
                                                        <select name="class_id" class="select2 form-control" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach($class_list as $i)
                                                                <option value="{{ $i->class_id }}" @selected($class_id == $i->class_id)>{{ $i->class_info->name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Exam</label>
                                                        <select name="exam_id" class="select2 form-control" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach($exam_list as $i)
                                                                <option value="{{ $i->id }}" @selected($exam_id == $i->id)>{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
                                                        <button type="submit" class="mt-3 btn btn-primary btn-custom">SEARCH</button>
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
                                            @if ($result!='Failed')
                                                <td>{{ number_format($grade,2) }}</td>
                                            @else
                                                <td>0.00</td>
                                            @endif
                                            <th colspan="2"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-lg table-bordered">
                                    <table class="table table-hover table-responsive-lg text-nowrap">
                                        <thead>
                                        <tr style="background: #ECECEC">
                                            <th colspan="4">Grade Sheet</th>
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
                                            @php $data = Helper::getResult($student_reg_info->student_id, $i->class_id, $i->subject_id, $session_id, $exam_id); @endphp
                                            <tr>
                                                <td>{{ $i->subject_info->name }}</td>
                                                @if ($data!=null && $data->mark!=null && $data->is_published!=0)
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
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#std-exam-result').addClass('active');
    </script>
@endsection
