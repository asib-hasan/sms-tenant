@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><b>Mark Entry</b></h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Result Management</li>
                            <li class="breadcrumb-item active">Mark Entry</li>
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
                            <div class="table-responsive-lg table-bordered p-2">
                                <table class="table table-hover text-nowrap">
                                    <thead style="background-color: #EAEAEA">
                                        <tr>
                                            <td colspan="4"><b>Exam Information</b>
                                                @if ($is_mark_locked==1)
                                                <a href="return:0" class="simple-button float-right"><i class="fas fa-lock"></i>Mark Locked</a>
                                                @else
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#lock-mark" class="simple-button float-right"><i class="fas fa-unlock"></i>Lock Mark</a>
                                                <div class="modal fade" id="lock-mark">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('rgmt/mark/entry/lock') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="class_id" value="{{ Helper::encrypt_decrypt('encrypt',$class_id) }}">
                                                                <input type="hidden" name="subject_id" value="{{ Helper::encrypt_decrypt('encrypt',$subject_id) }}">
                                                                <input type="hidden" name="session_id" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}">
                                                                <input type="hidden" name="exam_id" value="{{ Helper::encrypt_decrypt('encrypt',$exam_id) }}">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title font-weight-bold text-maroon">Lock Mark</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="text-wrap"><b>**</b>Once you lock your mark, you won't able to update again<b>**</b></p>
                                                                    <h3 class="font-weight-bold">Are You Sure?</h3>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
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
                                    </tbody>
                                </table>
                                <a href="{{ route('rmgt/mark/entry/search') }}">
                                <button class="btn btn-primary btn-custom">BACK TO SEARCH</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <div class="table-responsive-lg table-bordered p-2">
                                <form class="form-prevent" action="{{ route('rmgt/mark/entry/apply') }}" method="POST">
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
                                                        <input type="number" class="form-control" name="marks[{{ $student->student_id }}]" step="0.1" value="{{ isset($StudentMark[$student->student_id]) ? $StudentMark[$student->student_id] : '' }}" max="100" @disabled($is_mark_locked==1)>
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
                                    <button type="submit" @if ($is_mark_locked==1) style="display: none" @endif class="btn btn-primary btn-custom form-prevent-multiple-submit">SAVE MARKS</button>
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
        $("#mark-entry").addClass('active');
    </script>
@endsection
