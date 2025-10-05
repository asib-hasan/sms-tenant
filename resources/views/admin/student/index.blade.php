@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header print-none">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Student</h1>
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
                        <form action="{{ route('stdmgt/student/search') }}" method="GET">
                            @csrf
                            <div class="card-body print-none">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>ID</label>
                                        <input type="text" class="form-control" name="student_id" value={{ isset($student_id) ? $student_id : '' }}>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Name">Class</label>
                                        <select class="form-control select2" name="class_id" style="width: 100%">
                                            <option value="">Select</option>
                                            @foreach ($class_list as $i)
                                                <option value="{{ $i->id }}" @selected(isset($class_id) && $class_id == $i->id)>{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="Name">Session</label>
                                        <select class="form-control select2" name="session_id" style="width: 100%" required>
                                            <option value="">Select</option>
                                            @foreach ($session_list as $i)
                                                <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                        <a href="{{ route('stdmgt/student') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if ($flag==1)
                    <div class="card">
                        <span>
                            <a target="_blank" class="font-weight-bold ml-2"
                               href="{{ route('stdmgt/student/list/pdf', [
                                   'class_id' => $class_id,
                                   'session_id' => $session_id,
                                   'student_id' => $student_id
                               ]) }}">
                                <i class="fas fa-file-pdf" style="color: red; font-weight: bold;"></i> PDF
                            </a>
                        </span>
                        <div class="card-body table-responsive p-2 table-bordered">
                            <table class="table table-hover text-nowrap" id="dataTable">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Class</th>
                                        <th>Roll</th>
                                        <th>Phone</th>
                                        @if (Helper::canAny(auth()->user(), [38, 40]))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student_list as $i)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                @if ($i->student_info->photo != '')
                                                    <img src="{{ asset('uploads/students/' . $i->student_info->photo) }}" height="50px" width="50x">
                                                @else
                                                    <img src="{{ asset('photos/user.png') }}" height="50px" width="auto">
                                                @endif
                                            </td>
                                            <td>{{ $i->student_info->first_name }} {{ $i->student_info->last_name }} <br>
                                                <strong> ID: </strong> {{ $i->student_id }}</td>
                                            <td>{{ $i->student_info->gender }}</td>
                                            <td>{{ $i->class_info->name }}</td>
                                            <td>{{ $i->roll_no }}</td>
                                            <th>{{ $i->student_info->mobile }}</th>
                                            @if (Helper::canAny(auth()->user(), [38, 40]))
                                                <td class="print-none">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button>
                                                        <div class="dropdown-menu" role="menu">
                                                            @can('std_edit', 38)
                                                                <a href="{{ route('stdmgt/student/edit',['id' => Helper::encrypt_decrypt('encrypt', $i->student_info->id)],) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                                                            @endcan
                                                            @can('std_profile', 40)
                                                                <a href="{{ route('stdmgt/student/view',['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}"
                                                                    class="dropdown-item"><i class="fa fa-eye"></i> View</a>
                                                            @endcan
                                                            {{-- <a href="{{route('stdmgt/student/delete/'.$i->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
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
        $('#student-management').addClass('menu-open');
        $('#student-list').addClass('active');
    </script>
@endsection
