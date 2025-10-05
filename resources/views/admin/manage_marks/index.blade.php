@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Manage Marks</h1>
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 ml-0">
                            @include('components.alert')
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('rgmt/manage/marks/search') }}" method="GET">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Session</label>
                                                <select name="session_id" class="form-control select2" id="session_id" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                        <option value="{{ $i->id }}" @selected($session_id == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Class</label>
                                                <select name="class_id" class="form-control select2" id="class_id" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    @foreach ($class_list as $i)
                                                        <option value="{{ $i->id }}" @selected($class_id == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Exam</label>
                                                <select name="exam_id" class="form-control select2" id="exam_id" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    @foreach($exam_list as $i)
                                                        <option value="{{ $i->id }}" @selected($exam_id == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 mt-4">
                                                <button type="submit" class="mt-2 btn btn-primary btn-custom">Search</button>
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
                            <table class="table table-bordered table-responsive-lg text-nowrap">
                                <thead style="background-color: rgb(231, 231, 231)">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 25%">Subject</th>
                                        <th style="width: 40%;">Teacher</th>
                                        <th style="width: 15%">Is Submitted?</th>
                                        <th style="width: 15%">Is Published?</th>
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($assign_subject_list as $i)
                                    @php
                                        $assigned_teacher_info = \App\Models\AssignTeacherModel::where('class_id',$class_id)->where('session_id',$session_id)->where('subject_id',$i->subject_id)->where('exam_id',$exam_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $i->subject_info->name }}</td>
                                        <td>
                                            @if ($assigned_teacher_info != null && $assigned_teacher_info->employee_info != null && $assigned_teacher_info->employee_info->first_name != null)
                                            {{ $assigned_teacher_info->employee_info->first_name . ' ' . $assigned_teacher_info->employee_info->last_name }}<br>({{ $assigned_teacher_info->teacher_user_id }})
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            @if ($assigned_teacher_info && $assigned_teacher_info->employee_info!="")
                                            @if ($assigned_teacher_info && $assigned_teacher_info->is_mark_locked==1)
                                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Yes</span>
                                            @else
                                                <span class="badge bg-info"><i class="fas fa-times-circle"></i> No</span>
                                            @endif
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>
                                            @if ($assigned_teacher_info && $assigned_teacher_info->employee_info!="")
                                            @if ($assigned_teacher_info && $assigned_teacher_info->is_published==1)
                                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Yes</span>
                                            @else
                                            <span class="badge bg-info"><i class="fas fa-times-circle"></i> No</span>
                                            @endif
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>
                                        @if ($assigned_teacher_info && $assigned_teacher_info->employee_info)
                                        @if ($assigned_teacher_info && $assigned_teacher_info->is_mark_locked==0)
                                        <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-lock-{{ $assigned_teacher_info->id }}" class="simple-button"><i class="fas fa-lock"></i> Lock</a>
                                        <div class="modal fade" id="modal-lock-{{ $assigned_teacher_info->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('rgmt/manage/marks/lock') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$assigned_teacher_info->id)}}">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title font-weight-bold text-maroon">Lock Mark</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-wrap"><b>**</b>Once you lock mark, teacher unable to update any of student mark for subject '{{$i->subject_info->name}}'<b>**</b></p>
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
                                        @else
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-unlock-{{ $assigned_teacher_info->id }}" class="simple-button"><i class="fas fa-unlock"></i> Unlock</a>
                                        <div class="modal fade" id="modal-unlock-{{ $assigned_teacher_info->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('rgmt/manage/marks/unlock') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt',$assigned_teacher_info->id) }}">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title font-weight-bold text-maroon">Unlock Mark</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-wrap"><b>**</b>Once you unlock mark, teacher able to update student's mark for subject '{{ $i->subject_info->name }}'<b>**</b></p>
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
                                        <br>
                                        @if ($assigned_teacher_info->is_published==0)
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-publish-{{ $assigned_teacher_info->id }}" class="simple-button"><i class="fas fa-upload"></i>Publish</a><br>
                                        <div class="modal fade" id="modal-publish-{{ $assigned_teacher_info->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('rgmt/manage/marks/publish')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$assigned_teacher_info->id)}}">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title font-weight-bold text-maroon">Publish Mark</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-wrap"><b>**</b>Once you publish mark, students are able to see their result<b>**</b></p>
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
                                        @else
                                        <a href="" data-toggle="modal" data-target="#modal-unpublish-{{ $assigned_teacher_info->id }}" class="simple-button"><i class="fas fa-undo"></i>Unpublish</a><br>
                                        <div class="modal fade" id="modal-unpublish-{{ $assigned_teacher_info->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('rgmt/manage/marks/unpublish') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{Helper::encrypt_decrypt('encrypt',$assigned_teacher_info->id)}}">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title font-weight-bold text-maroon">Unpublish Mark</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-wrap"><b>**</b>Once you unpublish mark, students are unable to see their result<b>**</b></p>
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
                                            <a href="{{ route('rgmt/manage/marks/review', ['at' => Helper::encrypt_decrypt('encrypt', $assigned_teacher_info->id)]) }}"
                                               target="_blank" class="simple-button">
                                                <i class="fas fa-clipboard"></i> Review Marks
                                            </a>
                                        @else
                                        --
                                        @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-danger" colspan="6">No records</td>
                                    </tr>
                                    @endforelse
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
        $('#result-management').addClass('menu-open');
        $('#manage-marks').addClass('active');
    </script>

@endsection
