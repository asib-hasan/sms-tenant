@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Salary Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Accounts</li>
                            <li class="breadcrumb-item active">Salary Structure</li>
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
                                            <a class="nav-link" href="{{ route('genacc/salary/structure/employee') }}">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('genacc/salary/structure/designation') }}">By Designation</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('genacc/salary/structure/designation') }}" method="GET">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Select Designation</label>
                                                        <select name="designation_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach ($designation_list as $item)
                                                                <option @selected(($flag==1) && $item->id == $designation_info->id) value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="fees-head" class="form-label">Session</label>
                                                        <select id="fees-head" class="form-control" name="session_id" required>
                                                            <option value="">Select</option>
                                                            @foreach ($session_list as $i)
                                                                <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-2">
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
                </div>
            </div>
        </section>
        <section class="content">
            @if ($flag==1)
                <div class="card">
                    <h5 class="card-header font-weight-bold">Designation Information</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><b>Designation</b></th>
                                        <th>{{ $designation_info->name }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>Total Employee</b></td>
                                        <td>{{ $total_employee }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if($flag==1)
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Salary Information<a style="font-size: 15px;float: right" target="_blank" href="{{ route('genacc/salary/report/designation',['designation_id' => $designation_id , 'session_id' => $session_id , 'month' => 1]) }}"><i class="fa fa-eye"></i> View Details</a></h5>
                            </div>
                            <div class="card-body pt-0">
                                <form class="form-prevent" action="{{ route('genacc/salary/structure/designation/apply') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$designation_id) }}" name="designation_id">
                                    <input type="hidden" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}" name="session_id">
                                    <label for="fees-head" class="form-label">Session</label>
                                    <select id="fees-head" class="form-control" name="session_id" disabled>
                                        <option value="">Select</option>
                                        @foreach ($session_list as $i)
                                            <option value="{{ $i->id }}" @selected($session_id == $i->id)>{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="mt-1">Select Head</label>
                                    <select class="form-control select2" name="ac_head_id" style="width: 100%" required>
                                        <option value="">Select</option>
                                        @foreach ($ac_head_list as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="mt-1">Months</label>
                                    <select class="form-control" name="months[]" id="months" multiple required>
                                        @foreach($month_list as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="mt-1">Amount</label>
                                    <input class="form-control" type="number" step="0.01" name="amount" required>
                                    <button type="submit" class="form-prevent-multiple-submit btn btn-primary btn-custom mt-3">GENERATE/UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </section>
        </div>
    <script>
       $('#general-accounts').addClass('menu-open');
       $('#salary-structure').addClass('active');
    </script>
@endsection
