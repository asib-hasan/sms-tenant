@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><b>Review Marks</b></h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Result Management</li>
                            <li class="breadcrumb-item active">Manage Marks</li>
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
                        <div class="table-responsive p-2">
                            <div class="table-responsive-lg table-bordered">
                                <table class="table table-hover text-nowrap">
                                    <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <td colspan="4"><b>Exam Information</b></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Exam name</td>
                                        <td>{{ $exam_name }}</td>
                                        <td>Class</td>
                                        <td>{{ $class_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Session</td>
                                        <td>{{ $session_name }}</td>
                                        <td>Subject</td>
                                        <td>{{ $subject_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Teacher</td>
                                        <td>{{ $teacher_info->first_name }} {{ $teacher_info->last_name }}[{{ $teacher_info->employee_id }}]</td>
                                        <td>Designation</td>
                                        <td>{{ $teacher_info->designation_info->name ?? '' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <div class="table-responsive-lg table-bordered p-2">
                                <form class="form-prevent" action="{{ route('rgmt/manage/marks/review/update') }}" method="POST">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$class_id) }}" name="class_id">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}" name="session_id">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$exam_id) }}" name="exam_id">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$subject_id) }}" name="subject_id">
                                    @csrf
                                    <table class="table table-hover text-nowrap">
                                        <thead style="background-color: #EAEAEA">
                                        <tr>
                                            <th>SL.</th>
                                            <th>Roll</th>
                                            <th>Student Name</th>
                                            <th>Obtained Marks</th>
                                            <th>Grade Point</th>
                                            <th>Letter Grade</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($getStudent as $key => $student)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $student->roll_no }}</td>
                                                <td>{{ $student->student_info->first_name ?? '' }} {{ $student->student_info->last_name ?? '' }} <br><b>ID:{{ $student->student_id }}</b></td>
                                                <td>
                                                    <input type="number" class="form-control" name="marks[{{ $student->student_id }}]" step="0.1" value="{{ isset($StudentMark[$student->student_id]) ? $StudentMark[$student->student_id] : '' }}" max="100">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" value="{{ isset($GradePoint[$student->student_id]) ? number_format($GradePoint[$student->student_id],2) : '' }}" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ isset($LetterGrade[$student->student_id]) ? $LetterGrade[$student->student_id] : '' }}" disabled>
                                                </td>
                                                @if (isset($GradePoint[$student->student_id]))
                                                    @if ($GradePoint[$student->student_id] == 0.00)
                                                        <td style="font-weight: bold;color:red">fail</td>
                                                    @elseif ($GradePoint[$student->student_id] > 0.00)
                                                        <td style="font-weight: bold;color:rgb(37, 191, 37)">pass</td>
                                                    @else
                                                        <td style="font-weight: bold;color:#0F3850">N/A</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary btn-custom form-prevent-multiple-submit">UPDATE MARKS</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#result-management').addClass('menu-open');
        $('#manage-marks').addClass('active');
    </script>
@endsection
