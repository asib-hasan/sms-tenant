@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6" >
                        <h1 style="font-weight: bold">Finance Report</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Accounts</li>
                            <li class="breadcrumb-item active">Finance Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('genacc/balance/sheet') }}" method="GET">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="Name">Type<span style="color:red">*</span></label>
                                    <select class="form-control" name="report_type" id="selectOption" required>
                                      <option value="">Select Type</option>
                                      <option @selected($report_type=='by_total') value="by-total">Total Report</option>
                                      <option @selected($report_type=='Custom') value="Custom">Custom Search</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="Name">From</label>
                                    <input type="date" name="from_date" value="{{ $from_date }}" class="form-control" id="date" @readonly($report_type == 'by_total')>
                                  </div>
                                  <div class="form-group col-md-3">
                                    <label for="Name">To</label>
                                    <input type="date" name="to_date" value="{{ $to_date }}"  class="form-control" id="date2" @readonly($report_type == 'by_total')>
                                  </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                    <a href="{{ route('genacc/balance/sheet') }}" class="btn btn-success" style="margin-top: 30px;font-weight:bold">RESET</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if($flag == 1)
                <div class="card">
                    <div class="card-body table-responsive p-2" >
                        <table class="table table-hover text-nowrap table-bordered" >
                            <thead style="background: #EAEAEA">
                                <tr>
                                    <th colspan="2">Income Overview</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Area</th>
                                    <th>Amount</th>
                                </tr>
                                <tr>
                                    <td>Student Fees Collection</td>
                                    <td>{{ number_format($StudentDuesCollection,2) }}</td>
                                </tr>
                                <tr>
                                    <td>Investment/Donation</td>
                                    <td>{{ number_format($investment,2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ number_format($investment+$StudentDuesCollection,2) }}</td>
                                </tr>

                            </tbody>
                        </table>
                        <div style="font-size: 13px" class="font-weight-bold text-center">**In words: {{ Helper::numberTowords($investment+$StudentDuesCollection) }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive p-2" >
                        <table class="table table-hover text-nowrap table-bordered" >
                            <thead style="background: #EAEAEA">
                                <tr>
                                    <th colspan="2">Expense Overview</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Area</th>
                                    <th>Amount</th>
                                </tr>
                                <tr>
                                    <td>Employee Salary</td>
                                    <td>{{ number_format($salary_expense,2) }}</td>
                                </tr>
                                <tr>
                                    <td>Miscellaneous Cost</td>
                                    <td>{{ number_format($misc_cost,2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ number_format($misc_cost+$salary_expense,2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="font-size: 13px" class="font-weight-bold text-center">**In words: {{ Helper::numberTowords($misc_cost+$salary_expense) }}</div>
                    </div>
                </div>
                @php
                    $final_amount = ($investment+$StudentDuesCollection)-($misc_cost+$salary_expense);
                @endphp
                <div class="card">
                    <div class="card-body table-responsive p-2" >
                        <table class="table table-hover text-nowrap table-bordered" >
                            <thead style="background: #EAEAEA">
                                <tr>
                                    <th colspan="3">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Income</th>
                                    <th>Expense</th>
                                    <th>Profit/Loss</th>
                                </tr>
                                <tr>
                                    <td>{{ number_format($investment+$StudentDuesCollection,2) }}</td>
                                    <td>{{ number_format($misc_cost+$salary_expense,2) }}</td>
                                    <td>{{ number_format($final_amount,2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="font-size: 13px" class="font-weight-bold text-center">**In words: {{ Helper::numberTowords(($final_amount<0)?-1*$final_amount: $final_amount) }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </section>
    </div>
    <script>
        $('#general-accounts').addClass('menu-open');
        $('#finance-report').addClass('active');
      </script>
    <script>
        $(document).ready(function() {
            $("#selectOption").on("change", function() {
                if ($(this).val() === "by-total") {
                    $("#date").prop("readonly", true);
                    $("#date2").prop("readonly", true);
                } else {
                    $("#date").prop("readonly", false);
                    $("#date2").prop("readonly", false);
                    $("#date").prop("required", true);
                    $("#date2").prop("required", true);
                }
            });
        });
    </script>

@endsection
