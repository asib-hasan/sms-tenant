@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Student Dues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Accounts</li>
                        <li class="breadcrumb-item active">Student Dues</li>
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
                                        <a class="nav-link" href="{{ route('stdacc/dues/student') }}">By Student</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('stdacc/dues/class') }}">By Class</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Dues Report</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('stdacc/dues/report') }}" method="get">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="col-md-6 form-group">
                                                <label>Class <span class="text-danger">*</span></label>
                                                <select name="class_id" class="form-control select2" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    @foreach ($class_list as $i)
                                                        <option value="{{ $i->id }}" @selected($class_id == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>AC Head</label>
                                                <select name="ac_head_id" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($ac_head_list as $i)
                                                        <option value="{{ $i->id }}" @selected($ac_head_id == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>From</label>
                                                <select name="from_month" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($month_list as $i)
                                                    <option value="{{ $i->id }}" @selected($from_month == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>To</label>
                                                <select name="to_month" class="form-control select2" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($month_list as $i)
                                                        <option value="{{ $i->id }}" @selected($to_month == $i->id)>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Session <span class="text-danger">*</span></label>
                                                <select name="session_id" class="form-control select2" style="width: 100%" required>
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                        <option value="{{ $i->id }}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{$i->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <button type="submit" class="btn btn-primary btn-custom font-weight-bold mt-3">SEARCH</button>
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
                                    <table class="table table-bordered table-hover text-nowrap table-sm myTable">
                                        <tr>
                                            <th colspan="6" style="background-color: #ddd; color: #a81700">Class: {{ \App\Models\ClassModel::getName($class_id) }} | Session: {{ \App\Models\SessionModel::getName($session_id) }}</th>
                                        </tr>
                                        @php
                                        $total_amount = $total_waiver_amount = $total_amount_aw = $total_paid_amount = $total_due = 0;
                                        @endphp
                                        @foreach($month_list as $mn)
                                        @if($months[$mn->id])
                                        @php $fees_head_list = \App\Models\StudentDuesModel::where('session_id', $session_id)->where('class_id',$class_id)->where('month',$mn->id)->distinct()->get(['ac_head_id']); @endphp

                                        <tr>
                                            <th colspan="6" style="background-color: #ddd">{{ $mn->name }}</th>
                                        </tr>
                                        <tr>
                                            <th>Account Head</th>
                                            <th>Amount</th>
                                            <th>Waiver Amount</th>
                                            <th>Amount (AW)</th>
                                            <th>Paid Amount</th>
                                            <th>Due</th>
                                        </tr>
                                            @if($ac_head_id == null)
                                            @forelse($fees_head_list as $fees_head)
                                            <tr>
                                                @php
                                                $dues_info = \App\Models\StudentDuesModel::where('ac_head_id',$fees_head->ac_head_id)->where('session_id',$session_id)->where('class_id',$class_id)->where('month',$mn->id)->get();
                                                $amount = $dues_info->sum('amount');
                                                $waiver_amount = $amount - $dues_info->sum('amount_after_waiver');
                                                $amount_aw = $amount - $waiver_amount;
                                                $paid_amount = $dues_info->sum('paid_amount');
                                                $due = $dues_info->sum('due');
                                                $total_amount += $amount;
                                                $total_waiver_amount += $waiver_amount;
                                                $total_amount_aw += $amount_aw;
                                                $total_paid_amount += $paid_amount;
                                                $total_due += $due;
                                                @endphp
                                                <td>{{ $fees_head->ac_head_info->name ?? '' }}</td>
                                                <td>{{ $amount }}</td>
                                                <td>{{ $waiver_amount }}</td>
                                                <td>{{ $amount_aw }}</td>
                                                <td>{{ $paid_amount }}</td>
                                                <td>{{ $due }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td class="text-danger" colspan="6">No records</td>
                                            </tr>
                                            @endforelse
                                            @else
                                            @php
                                                $fees_head_list = \App\Models\StudentDuesModel::where('session_id', $session_id)->where('class_id',$class_id)->where('month',$mn->id)->distinct()->get(['ac_head_id']);
                                                $dues_info = \App\Models\StudentDuesModel::where('ac_head_id',$ac_head_id)->where('session_id',$session_id)->where('class_id',$class_id)->where('month',$mn->id)->get();
                                                $amount = $dues_info->sum('amount');
                                                $waiver_amount = $amount - $dues_info->sum('amount_after_waiver');
                                                $amount_aw = $amount - $waiver_amount;
                                                $paid_amount = $dues_info->sum('paid_amount');
                                                $due = $dues_info->sum('due');
                                                $total_amount += $amount;
                                                $total_waiver_amount += $waiver_amount;
                                                $total_amount_aw += $amount_aw;
                                                $total_paid_amount += $paid_amount;
                                                $total_due += $due;
                                            @endphp
                                            @if($fees_head_list->pluck('ac_head_id')->intersect($dues_info->pluck('ac_head_id'))->isNotEmpty())
                                            <tr>
                                                <td>{{ \App\Models\ACHeadModel::getName($ac_head_id) }}</td>
                                                <td>{{ $amount }}</td>
                                                <td>{{ $waiver_amount }}</td>
                                                <td>{{ $amount_aw }}</td>
                                                <td>{{ $paid_amount }}</td>
                                                <td>{{ $due }}</td>
                                            </tr>
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-danger">No records</td>
                                                </tr>
                                            @endif
                                           @endif
                                       @endif
                                      @endforeach
                                        <tr class="font-weight-bold">
                                            <td class="text-right">Total</td>
                                            <td>{{ $total_amount }}</td>
                                            <td>{{ $total_waiver_amount }}</td>
                                            <td>{{ $total_amount_aw }}</td>
                                            <td>{{ $total_paid_amount }}</td>
                                            <td>{{ $total_due }}</td>
                                        </tr>
                                    </table>
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
    $('#student-accounts').addClass('menu-open');
    $('#student-dues').addClass('active');
</script>

<script>

</script>
@endsection
