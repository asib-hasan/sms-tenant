@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Transaction History(Std. Payment)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Accounts</li>
                            <li class="breadcrumb-item active">Transaction History</li>
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
                        <div class="card-header">
                            <form action="{{ route('stdacc/transaction/history') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Invoice No.</label>
                                        <input type="text" class="form-control" name="invoice_no" value="{{ $invoice_no }}" required>
                                    </div>
                                    <div class="col-auto mt-3 pr-0">
                                        <button class="btn btn-primary mt-3 btn-custom">SEARCH</button>
                                    </div>
                                    <div class="col-auto mt-3">
                                        <a class="btn btn-success mt-3 font-weight-bold" href="{{ route('stdacc/transaction/history') }}">RESET</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @php
                            $cnt = 0;
                        @endphp
                        @php $amount = 0; @endphp
                        <div class="card-body table-responsive p-2">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered text-nowrap" id="dataTable">
                                    <thead style="background-color: rgb(231, 231, 231)">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No.</th>
                                        <th>Student Id</th>
                                        <th>Amount</th>
                                        <th>Month/Session</th>
                                        <th>Issue Date & Time</th>
                                        <th>Collected By</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                       $serial = ($transaction_history->currentPage() - 1) * $transaction_history->perPage() + 1;
                                    @endphp
                                    @foreach ($transaction_history as $i)
                                        <tr>
                                            <td>{{ $serial++ }}</td>
                                            <td>{{ $i->invoice_no }}</td>
                                            <td>{{ $i->id_number }}</td>
                                            <td>{{number_format($i->amount,2)}}</td>
                                            <td>{{ \App\Models\MonthsModel::getName($i->month) }}/{{ $i->session_info->name }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>{{ $i->created_by }}</td>
                                            <td>{{ $i->note }}</td>
                                            <td>
                                                <a href="{{ route('stdacc/transaction/view', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}"
                                                   target="_blank" class="btn btn-primary btn-custom">
                                                    <span class="fas fa-eye" aria-hidden="true"></span>
                                                    <span><strong>View</strong></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="rounded-0 p-0 m-0">
                                {{ $transaction_history->links() }}
                            </div>
                            <div style="white-space:initial;font-weight:bold">
                                Total Amount = {{ $total_amount }}<br>
                                In words: {{ Helper::numberToWords($total_amount) }} Tk. Only
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $('#student-accounts').addClass('menu-open');
        $('#transaction-history-student').addClass('active');
    </script>

    <script>
        $('#searchInput').on('input', function () {
                var searchTerm = $(this).val().toLowerCase();
                filterTable(searchTerm);
            });

        function filterTable(searchTerm) {
            $('#dataTable tbody tr').each(function () {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
