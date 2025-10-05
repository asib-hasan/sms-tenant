@extends('layout.sidebar_student')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Payment Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Payment Details</li>
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
                                            <a class="nav-link active" href="#">By Class</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('std/payment/details') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Class</label>
                                                        <select name="class_id" class="select2 form-control" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach($class_list as $i)
                                                                <option value="{{ $i->class_id }}" @selected($class_id == $i->class_id)>{{ $i->class_info->name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-3">
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
                    @if($flag == 1)
                        <div class="row">
                            <div class="col-md-12">
                                    @foreach($months as $month)
                                    <div class="card rounded-0 p-2">
                                        <div class="card-header p-0">
                                            <h5 class="font-weight-bold text-muted d-inline-block">{{ $month }} - {{ \App\Models\SessionModel::getName($session_id) }}</h5>
                                        </div>
                                        <table>
                                            <tr>
                                                <th colspan="6" style="background-color: #506b8d;color: white">Dues Information</th>
                                            </tr>
                                        </table>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap table-hover">
                                            @php
                                                $_dues = \App\Models\StudentDuesModel::where('student_id',$student_id)->where('session_id', $session_id)->where('month',$month)->get();
                                                $dues_ids = \App\Models\StudentDuesModel::where('student_id',$student_id)->where('session_id', $session_id)->where('month',$month)->pluck('id')->toArray();
                                                $payment_details = \App\Models\IncomeStudentDuesModel::whereIn('dues_id',$dues_ids)->get();
                                            @endphp
                                            <tr>
                                                <th style="background: #ddd">Particular</th>
                                                <th style="background: #ddd">Amount</th>
                                                <th style="background: #ddd">Waiver</th>
                                                <th style="background: #ddd">Amount AW</th>
                                                <th style="background: #ddd">Paid Amount</th>
                                                <th style="background: #ddd">Due</th>
                                            </tr>
                                            @foreach($_dues AS $dues)
                                                <tr>
                                                    <td>{{ $dues->ac_head_info->name }}</td>
                                                    <td>{{ $dues->amount }}</td>
                                                    <td>{{ $dues->waiver }}</td>
                                                    <td>{{ $dues->amount_after_waiver }}</td>
                                                    <td>{{ $dues->paid_amount }}</td>
                                                    <td>{{ $dues->due }}</td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </div>
                                        <table class="mt-3">
                                            <tr style="background-color: #506b8d;color: white">
                                                <th colspan="6">Payment Information</th>
                                            </tr>
                                        </table>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap table-hover">
                                                <tr>
                                                    <th style="background: #ddd">Payment Date</th>
                                                    <th style="background: #ddd">Particular</th>
                                                    <th style="background: #ddd">Amount</th>
                                                    <th style="background: #ddd" colspan="2">Invoice No.</th>
                                                    <th style="background: #ddd">Payment Type</th>
                                                </tr>
                                                @forelse($payment_details as $i)
                                                    <tr>
                                                        <td>{{ $i->date }}</td>
                                                        <td>{{ $i->ac_head_info->name }}</td>
                                                        <td>{{ $i->amount }}</td>
                                                        <td colspan="2">{{ $i->invoice_info->invoice_no }}</td>
                                                        <td>{{ $i->invoice_info->payment_type }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="font-weight-bold text-maroon">No Records</td>
                                                    </tr>
                                                @endforelse
                                            </table>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#payment-details').addClass('active');
    </script>
@endsection
