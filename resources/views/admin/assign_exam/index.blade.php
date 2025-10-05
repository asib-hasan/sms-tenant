@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Assign Exam</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Academic Management</li>
                            <li class="breadcrumb-item active">Assign Exam</li>
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
                                    <form action="{{ route('acmgt/assign/exam') }}" method="GET">
                                        <div class="row">
                                            @csrf
                                            <div class="col-md-4 form-group">
                                                <label class="form-label">Class</label>
                                                <select name="class_id" class="form-control select2"  style="width: 100%" required>
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
                                                <button type="submit" class="mt-2 btn btn-primary btn-custom">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($flag == 1)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="table-responsive p-2">
                                        <table class="table table-bordered text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td style="background-color:rgb(231, 231, 231)" colspan="4"><b>Overview</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Class</b> <br>{{\App\Models\ClassModel::where('id',$class_id)->first()->name}}</td>
                                                    <td><b>Session</b><br>{{\App\Models\SessionModel::where('id',$session_id)->first()->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Assigned Exam</b><br>{{$total_exam}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('acmgt/assign/exam/update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 select2-purple">
                                            <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt', $session_id) }}" name="session_id">
                                            <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt', $class_id) }}" name="class_id">
                                            <label class="form-control-label text-lg">Select Exam</label>
                                            <select class="select2 form-control" name="exams[]" multiple="multiple" required>
                                                @foreach($exam_list as $i)
                                                    @php
                                                        $assigned_exam_info = \App\Models\AssignExamModel::where('session_id',$session_id)->where('class_id',$class_id)->where('exam_id',$i->id)->exists();
                                                    @endphp
                                                    @if($assigned_exam_info)
                                                    @continue
                                                    @endif
                                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <button onclick="return confirm('Are you sure to proceed?');" type="submit"  class="btn btn-primary btn-custom mt-2">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="table-responsive p-2">
                                <table class="table table-bordered text-nowrap table-hover">
                                    <thead style="background-color: #ddd">
                                    <tr>
                                        <th colspan="4" style="background-color: #ddd">Assigned Exam List</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 55%">Exam</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($assigned_exam_list as $i)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $i->exam_info->name }}</td>
                                            <td>
                                                <form action="{{ route('acmgt/assign/exam/delete', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Are you sure to delete it?');" style="margin: 0px;padding: 0px;" class="simple-button btn btn-link font-weight-bold">
                                                        <i class="fas fa-trash"></i>Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-danger">No records</td>
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
        $('#academic-management').addClass('menu-open');
        $('#assign-exam').addClass('active');
    </script>
@endsection
