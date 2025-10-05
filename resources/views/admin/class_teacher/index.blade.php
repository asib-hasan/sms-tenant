@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header print-none">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Class Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Management</li>
                            <li class="breadcrumb-item active">Student List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    @include('components.alert')
                    <div class="card">
                        <form action="{{ route('acmgt/class/teacher') }}" method="GET">
                            @csrf
                            <div class="card-body print-none">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="Name">Session</label>
                                        <select class="form-control select2" name="session_id" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-3 col-md-2">
                                        <button class="btn btn-primary btn-custom mt-3" type="submit">SEARCH</button>
                                        <a href="{{ route('acmgt/class/teacher') }}" class="btn btn-success font-weight-bold mt-3" type="button">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if ($flag==1)
                        <div class="card">
                            <div class="card-body table-responsive p-2 table-bordered">
                                <form class="form-prevent" action="{{ route('acmgt/class/teacher/update') }}" method="POST">
                                    <input type="hidden" name="session_id" value="{{ $session_id }}">
                                    @csrf
                                    <table class="table table-hover text-nowrap" id="dataTable">
                                        <thead style="background-color: #EAEAEA">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 20%">Class</th>
                                            <th style="width: 50%">Teacher</th>
                                            <th style="width: 25%">Status</th>
                                        </tr>
                                        <tbody>
                                        @foreach($class_list as $i)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $i->name }}</td>
                                                <td>
                                                    @php $is_found = 0; @endphp
                                                    <select name="class_teacher[{{ $i->id }}]" class="select2 w-100" style="border:1px solid #ddd;border-radius: 5px">
                                                        <option value="">Select</option>
                                                        @foreach($teacher_list as $teacher)
                                                            <option value="{{ $teacher->employee_id }}" @if(isset($ct[$i->id]) && $ct[$i->id]==$teacher->employee_id) selected @php $is_found = 1; @endphp @endif>{{ $teacher->first_name }} {{ $teacher->last_name }} ({{ $teacher->employee_id }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    @if($is_found == 0)
                                                        <span class="badge bg-secondary">Not Selected</span>
                                                    @else
                                                        <span class="badge badge-success"><i class="fa fa-check-circle"></i> Selected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="form-prevent-multiple-submit btn btn-success btn-custom">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#academic-management').addClass('menu-open');
        $('#class-teacher').addClass('active');
    </script>
@endsection
