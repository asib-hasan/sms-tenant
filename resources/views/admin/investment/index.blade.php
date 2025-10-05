@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Investment/Donation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Accounting Section</li>
                            <li class="breadcrumb-item active">Investment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card">
                        @can('invest_add', 69)
                        <div class="card-header">
                            <div class="col-sm-12">
                                <a href="{{ route('genacc/investment/add') }}">
                                    <button class="btn btn-primary btn-custom"><i class="fa fa-plus mr-2"></i>Add New</button>
                                </a>
                            </div>
                        </div>
                        @endcan
                        <form action="{{ route('genacc/investment') }}" method="GET">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Inv./Donor Name</label>
                                        <input value="{{ $name }}" type="text" class="form-control" name="name" placeholder="Search by Investor/Donor name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Voucher ID.</label>
                                        <input value="{{ $voucher_id }}" type="text" class="form-control" name="voucher_id" placeholder="Search by vouchar id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px">SEARCH</button>
                                        <a href="{{ route('genacc/investment') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive p-2">
                            <table class="table table-bordered table-hover text-nowrap">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 25%">Inv./Donor</th>
                                        <th style="width: 10%">Type</th>
                                        <th style="width: 10%">Amount</th>
                                        <th style="width: 10%">Payment Type</th>
                                        <th style="width: 5%">Pay Date</th>
                                        <th style="width: 10%">Voucher ID.</th>
                                        <th style="width: 15%">Note</th>
                                        @if(Helper::canAny(auth()->user(),[70, 71]))
                                        <th style="width: 10%">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalRecords = $investment_list->total();
                                        $perPage = $investment_list->perPage();
                                        $currentPage = $investment_list->currentPage();
                                        $startingSerial = $totalRecords - ($currentPage - 1) * $perPage;
                                    @endphp
                                    @foreach ($investment_list as $i)
                                        <tr>
                                            <td>{{ $startingSerial-- }}</td>
                                            <td>{!! $i->name !!}</td>
                                            <td>{{ $i->type == 0 ? 'Individual' : 'Organization' }}</td>
                                            <td>{{ number_format($i->amount, 2) }}</td>
                                            <td>{{ $i->payment_type == '0' ? 'Cash' : ($i->payment_type == 1 ? 'Check' : ($i->payment_type == 2 ? 'Bank Transfer' : 'Mobile Banking')) }}</td>
                                            <td>{{ $i->date }}</td>
                                            <td>{{ str_pad($i->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{!! $i->note !!}</td>
                                            @if(Helper::canAny(auth()->user(),[70, 71]))
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"></button>
                                                    <div class="dropdown-menu" role="menu">
                                                        @can('invest_edit', 70)
                                                        <a class="dropdown-item hover"
                                                           href="{{ route('genacc/investment/edit', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        @endcan
                                                        @can('invest_voucher', 89)
                                                        <a class="dropdown-item hover" target="_blank"
                                                           href="{{ route('genacc/investment/print/voucher', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}">
                                                            <i class="fa fa-file"></i> Voucher
                                                        </a>
                                                        @endcan
                                                        @can('invest_delete',71)
                                                        <form action="{{ route('genacc/investment/delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt', $i->id) }}">
                                                            <button type="submit" class="dropdown-item hover">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="font-weight-bold">Total: </td>
                                        <td style="text-align:left" colspan="8" class="font-weight-bold">
                                            {{ number_format($totalCost, 2) }}/-<br>In words:
                                            @php
                                                echo Helper::numberToWords($totalCost) . ' Tk. only';
                                            @endphp
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="width: 100%;overflow-x:auto;">
                            {{ $investment_list->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#general-accounts').addClass('menu-open');
        $('#investment').addClass('active');
    </script>
@endsection
