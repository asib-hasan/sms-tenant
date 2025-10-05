@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Assign Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Academic Management</li>
                            <li class="breadcrumb-item active">Assign Teacher</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 ml-0">
                            @include('components.alert')
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('acmgt/assign/teacher') }}" method="GET">
                                        <div class="row">
                                            @csrf
                                            <div class="col-md-4 form-group">
                                                <label class="form-label">Class</label>
                                                <select name="class_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="">Select</option>
                                                    @foreach ($class_list as $i)
                                                        <option @selected($class_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="form-label">Session</label>
                                                <select name="session_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                        <option @selected($session_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <button type="submit" class="mt-2 btn btn-primary btn-custom">SEARCH</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($flag == 1)
                        <div class="card">
                            <div class="table-responsive p-2">
                                <table class="table table-bordered table-hover text-nowrap">
                                    <tbody>
                                    @foreach($assigned_exam_list as $exam)
                                    <tr>
                                        <td colspan="3" class="font-italic font-weight-bold bg-gradient-cyan">
                                            {{ $exam->exam_info->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 30%">Subject</th>
                                        <th style="width: 50%">Teacher</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                    @forelse ($assigned_subject_list as $subject)
                                        @php
                                        $assigned_teacher_info = \App\Models\AssignTeacherModel::where('session_id',$session_id)
                                                                                                ->where('class_id',$class_id)
                                                                                                ->where('subject_id',$subject->subject_id)
                                                                                                ->first();
                                        $mark_info = \App\Models\MarksModel::where('session_id',$session_id)
                                                                            ->where('class_id',$class_id)
                                                                            ->where('subject_id',$subject->subject_id)
                                                                            ->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $subject->subject_info->name ?? '' }}</td>
                                            <td>
                                                @if($assigned_teacher_info == null)
                                                <span class="badge bg-cyan">Not assigned</span>
                                                @else
                                                {{ $assigned_teacher_info->employee_info->first_name ?? '' }} {{ $assigned_teacher_info->employee_info->last_name ?? '' }} <span class="text-muted font-weight-bold">[{{ $assigned_teacher_info->teacher_user_id }}]</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#assign-teacher-{{ $subject->id }}" class="simple-button"><i class="fas fa-pencil"></i> Edit</a>
                                                <div class="modal fade" id="assign-teacher-{{ $subject->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('acmgt/assign/teacher/update') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="class_id" value="{{ Helper::encrypt_decrypt('encrypt',$class_id) }}">
                                                                <input type="hidden" name="session_id" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}">
                                                                <input type="hidden" name="subject_id" value="{{ Helper::encrypt_decrypt('encrypt',$subject->subject_id) }}">
                                                                <input type="hidden" name="exam_id" value="{{ Helper::encrypt_decrypt('encrypt',$exam->exam_id) }}">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title font-weight-bold">Update Teacher</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-md-12">
                                                                        @if($mark_info == null)
                                                                        @if($assigned_teacher_info)
                                                                        <label>Teacher</label>
                                                                        <select name="teacher_id" class="form-control select2" style="width: 100%">
                                                                            <option value="0">None</option>
                                                                            @foreach($teacher_list as $teacher)
                                                                                <option value="{{ $teacher->id }}" @selected($assigned_teacher_info && $assigned_teacher_info->teacher_id_primary == $teacher->id)>{{ $teacher->first_name }} {{ $teacher->last_name }} [{{ $teacher->employee_id }}]</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <small class="text-muted font-weight-bold">[Select 'None' to unassign]</small>
                                                                        @else
                                                                        <label>Teacher</label>
                                                                        <select name="teacher_id" class="form-control select2" style="width: 100%" required>
                                                                            <option value="">Select</option>
                                                                            @foreach($teacher_list as $teacher)
                                                                                <option value="{{ $teacher->id }}" @selected($assigned_teacher_info && $assigned_teacher_info->teacher_id_primary == $teacher->id)>{{ $teacher->first_name }} {{ $teacher->last_name }} [{{ $teacher->employee_id }}]</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @endif
                                                                        @else
                                                                            <div class="alert" role="alert" style="text-align: center;background-color: #ef8e8e">
                                                                                <p class="text-wrap">The teacher has already inserted marks. Assigned <br> teacher cannot be modified or deleted.</p>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if($mark_info == null)
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                                                </div>
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-danger font-weight-bold">No records</td>
                                        </tr>
                                    @endforelse
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#academic-management').addClass('menu-open');
        $('#assign-teacher').addClass('active');
    </script>
@endsection
