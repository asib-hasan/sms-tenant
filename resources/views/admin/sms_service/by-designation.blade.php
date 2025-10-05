@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Send SMS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">SMS Service</li>
                        <li class="breadcrumb-item active">Send SMS</li>
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
                                        <a class="nav-link" href="{{ route('send-sms/by/student') }}">By Student</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/employee') }}">By Employee</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/class') }}">By Class</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">By Designation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('send-sms/by/number') }}">By Number</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('send-sms/by/designation') }}" method="get">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="form-group col-md-6">
                                                <label for="Name">Designation</label>
                                                <select class="form-control select2" name="designation_id" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                   @foreach ($designation_list as $i)
                                                       <option @selected($designation_id==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                   @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-3">
                                                <button class="btn btn-primary mt-3 btn-custom">SEARCH</button>
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
                <form action="{{ route('send-sms/designation/send') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-bordered table-responsive-lg">
                                        <tbody >
                                            <thead>
                                                <td><input type="checkbox" class="checkbox" id="select-all"></td>
                                                <td class="font-weight-bold">ID</td>
                                                <td class="font-weight-bold">Name</td>
                                                <td class="font-weight-bold">Class</td>
                                                <td class="font-weight-bold">Phone</td>
                                            </thead>
                                            @foreach ($employee_list as $employee)
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" name="numbers[]" value="{{ $employee->phone }}"></td>
                                                <td>{{ $employee->employee_id }}</td>
                                                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                                <td>{{ $employee->designation_info->name ?? '' }}</td>
                                                <td>{!! $employee->phone !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card p-3">
                    <div class="col-lg-6">
                        <label for="sms_text" class="form-label">SMS Text</label>
                        <textarea name="sms_text" id="sms_text" class="form-control" rows="7" aria-valuetext="Please clear this SMS. Write your message here. This is for demo only." required>Please clear this SMS. Write your message here. This is for demo only.</textarea>
                        <button type="submit" class="btn btn-primary btn-custom mt-2">SEND SMS</button>
                    </div>
                </div>
                </form>
                @endif
            </div>
        </div>
    </section>
</div>
<script>
    $('#sms-service').addClass('menu-open');
    $('#send-sms').addClass('active');
</script>
<script>
    $(document).ready(function() {
        $("#success-alert").fadeTo(1000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        $('#select-all').click(function() {
            var isChecked = $(this).is(':checked');
            $('.checkbox').prop('checked', isChecked);
        });
        $('.checkbox').click(function() {
            if (!$(this).is(':checked')) {
                $('#select-all').prop('checked', false);
            }
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select-all').prop('checked', true);
            }
        });
    });
</script>
@endsection
