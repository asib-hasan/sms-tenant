@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Salary Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Accounts</li>
                            <li class="breadcrumb-item active">Payment Summary</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('genacc/salary/payment') }}">Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Summary</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('genacc/salary/payment/summary') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6 form-group">
                                                        <label class="form-label">Session</label>
                                                        <select name="session_id" class="form-control select2" style="width: 100%" required>
                                                            <option value="">Select</option>
                                                            @foreach($session_list as $i)
                                                                <option @selected($session_id==$i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <button type="submit" class="btn btn-primary font-weight-bold btn-custom mt-3">SEARCH</button>
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
                        <div class="card">
                            <span>
                                <a target="_blank" class="font-weight-bold ml-2" href="{{ route('genacc/print/salary/payment/summary?session_id=' . $session_id) }}">
                                    <i class="fas fa-file-pdf" style="color: red; font-weight: bold;"></i> PDF
                                </a>
                            </span>
                            <div class="card-body table-responsive p-2 table-bordered">
                                <table class="table table-hover text-nowrap">
                                    @php
                                        $total_amount = 0;
                                    @endphp
                                    <tr>
                                        <th colspan="2" style="background-color: #ddd">Salary Payment - {{ \App\Models\SessionModel::getName($session_id) }}</th>
                                    </tr>
                                    @foreach($month_list as $month)
                                        @php
                                            $total_payment = \App\Models\EmployeeSalaryModel::where('month',$month->id)->where('session_id',$session_id)->sum('paid_amount');
                                            $total_amount += $total_payment;
                                        @endphp
                                        <tr>
                                            <td>{{ $month->name }}</td>
                                            <td>{{ $total_payment }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td>Total</td>
                                        <td>{{ $total_amount }} ({{ \App\Helpers\Helper::numberToWords($total_amount) }})</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#student-accounts').addClass('menu-open');
        $('#fees-collection').addClass('active');
    </script>
@endsection
