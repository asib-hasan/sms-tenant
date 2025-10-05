@extends('layout.sidebar_student')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="font-weight-bold mr-2">My Subjects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">Student Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card p-3 card-dashboard">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>SUBJECT</th>
                            <th>TEACHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($flag == 1)
                        @foreach($subject_list as $i)
                            @php
                                $teacher_info = \App\Models\AssignTeacherModel::where('class_id',$i->class_id)
                                                                            ->where('subject_id',$i->subject_id)
                                                                            ->where('session_id',$i->session_id)
                                                                            ->orderByDesc('id')
                                                                            ->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $i->subject_info->name }}</td>
                                <td>{{ $teacher_info->employee_info->first_name ?? '-' }} {{ $teacher_info->employee_info->last_name ?? '' }}</td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="3">No Records</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#std-subject').addClass('active');
    </script>
@endsection
