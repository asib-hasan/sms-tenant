@extends('layout.sidebar')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Employee Salary</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Accounts</li>
                        <li class="breadcrumb-item active">Employee Salary</li>
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
                                        <a class="nav-link" href="{{route('genacc/salary/report/employee')}}">By Employee</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('genacc/salary/report/designation')}}">By Designation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Salary Report</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('genacc/salary/report/session') }}" method="GET">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="col-md-6 form-group">
                                                <label class="form-label">Designation <span class="text-danger">*</span></label>
                                                <select name="designation_id" class="form-control select2" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    <option value="-1" @selected($summery == 1)>All (Summary)</option>
                                                    @foreach ($designation_list as $i)
                                                        <option value="{{ $i->id }}" @selected($designation_id==$i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="fromMonth">From Month</label>
                                                <select name="fromMonth" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($month_list as $i)
                                                    <option value="{{ $i->id }}" @selected($fromMonth == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="toMonth">To </label>
                                                <select name="toMonth" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($month_list as $i)
                                                        <option value="{{ $i->id }}" @selected($toMonth == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="form-label">Session</label>
                                                <select name="session_id" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                        <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <button type="submit" class="btn btn-primary btn-custom font-weight-bold mt-3 ">Search</button>
                                            </div>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($flag==1)
                {{-- <div class="row">
                    <div class="col-sm-6">
                        <div class="pdf-button"><i class="fa fa-file-pdf"></i> PDF</div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-2">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    @if($summery == 0)
                                    <table class="table table-bordered table-hover text-nowrap table-sm">
                                        <tr>
                                            <th colspan="4" style="background-color: #ddd; color: #a81700">Designation: {{ \App\Models\DesignationModel::getName($designation_id) }} | Session: {{ \App\Models\SessionModel::getName($session_id) }}</th>
                                        </tr>
                                        @php
                                            $total_amount = $total_paid_amount = $total_payable_amount = 0;
                                        @endphp
                                        @foreach($month_list as $mn)
                                        @if($months[$mn->id])
                                        @php $salary_head_list = \App\Models\EmployeeSalaryModel::where('session_id', $session_id)->where('designation_id',$designation_id)->where('month',$mn->id)->distinct()->get(['ac_head_id']); @endphp
                                        <tr>
                                            <th colspan="4" style="background-color: #ddd">{{ $mn->name }}</th>
                                        </tr>
                                        <tr>
                                            <th>Account Head</th>
                                            <th>Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Payable Amount</th>
                                        </tr>
                                        @forelse($salary_head_list as $salary_head)
                                        <tr>
                                            @php
                                                $salary_info = \App\Models\EmployeeSalaryModel::where('ac_head_id',$salary_head->ac_head_id)->where('session_id',$session_id)->where('designation_id',$designation_id)->where('month',$mn->id)->get();
                                                $amount = $salary_info->sum('amount');
                                                $paid_amount = $salary_info->sum('paid_amount');
                                                $payable_amount = $salary_info->sum('payable_amount');
                                                $total_amount += $amount;
                                                $total_paid_amount += $paid_amount;
                                                $total_payable_amount += $payable_amount;
                                            @endphp
                                            <td>{{ $salary_head->ac_head_info->name ?? '' }}</td>
                                            <td>{{ $amount }}</td>
                                            <td>{{ $paid_amount }}</td>
                                            <td>{{ $payable_amount }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-danger" colspan="4">No records</td>
                                        </tr>
                                        @endforelse
                                        @endif
                                        @endforeach
                                        <tr class="font-weight-bold">
                                            <td class="text-right">Total</td>
                                            <td>{{ $total_amount }}</td>
                                            <td>{{ $total_paid_amount }}</td>
                                            <td>{{ $total_payable_amount }}</td>
                                        </tr>
                                    </table>
                                    @elseif($summery == 1)
                                    <table class="table table-bordered table-hover text-nowrap table-sm">
                                        <tr>
                                            <th colspan="4" style="background-color: #ddd; color: #a81700">Total Summary | Session: {{ \App\Models\SessionModel::getName($session_id) }}</th>
                                        </tr>
                                        @php
                                            $total_amount = $total_paid_amount = $total_payable_amount = 0;
                                        @endphp
                                        @foreach($month_list as $mn)
                                            @if($months[$mn->id])
                                                @php $salary_designation_list = \App\Models\EmployeeSalaryModel::where('session_id', $session_id)->where('month',$mn->id)->distinct()->get(['designation_id']); @endphp
                                                <tr>
                                                    <th colspan="4" style="background-color: #ddd">{{ $mn->name }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <th>Amount</th>
                                                    <th>Paid Amount</th>
                                                    <th>Payable Amount</th>
                                                </tr>
                                                @forelse($salary_designation_list as $salary_designation)
                                                    <tr>
                                                        @php
                                                            $salary_info = \App\Models\EmployeeSalaryModel::where('designation_id',$salary_designation->designation_id)->where('session_id',$session_id)->where('month',$mn->id)->get();
                                                            $amount = $salary_info->sum('amount');
                                                            $paid_amount = $salary_info->sum('paid_amount');
                                                            $payable_amount = $salary_info->sum('payable_amount');
                                                            $total_amount += $amount;
                                                            $total_paid_amount += $paid_amount;
                                                            $total_payable_amount += $payable_amount;
                                                        @endphp
                                                        <td>{{ $salary_designation->designation_info->name ?? '' }}</td>
                                                        <td>{{ $amount }}</td>
                                                        <td>{{ $paid_amount }}</td>
                                                        <td>{{ $payable_amount }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-danger" colspan="4">No records</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        @endforeach
                                        <tr class="font-weight-bold">
                                            <td class="text-right">Total</td>
                                            <td>{{ $total_amount }}</td>
                                            <td>{{ $total_paid_amount }}</td>
                                            <td>{{ $total_payable_amount }}</td>
                                        </tr>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
    $('#general-accounts').addClass('menu-open');
    $('#salary-report').addClass('active');
</script>
@endsection
