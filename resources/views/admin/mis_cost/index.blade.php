@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Miscellaneous Cost</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Accounts</li>
                        <li class="breadcrumb-item active">Miscellaneous Cost</li>
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
                @can('misc_add', 65)
                <div class="card-header">
                    <a href="{{ route('genacc/miscellaneous/cost/add') }}">
                        <button class="btn btn-primary btn-custom"><i class="fa fa-plus mr-2"></i>Add New</button>
                    </a>
                </div>
                @endcan
                <div class="">
                    <form action="{{ route('genacc/miscellaneous/cost') }}" method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="form-label">Select Head</label>
                                    <select class="form-control select2" name="ac_head_id" style="width: 100%">
                                    <option value="">Select</option>
                                        @foreach ($ac_head_list as $i)
                                            <option value="{{ $i->id }}" @selected($ac_head_id==$i->id)>{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                <div class="form-group col-md-3">
                                    <label>Receipt No.</label>
                                    <input type="text" class="form-control" value="{{ $receipt_no }}" name="receipt_no" placeholder="Search by receipt">
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary btn-custom" type="submit" style="margin-top:30px;">SEARCH</button>
                                    <a href="{{ route('genacc/miscellaneous/cost') }}" class="btn btn-success font-weight-bold" style="margin-top: 30px;">RESET</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive p-2">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead style="background-color: #EAEAEA">
                            <tr>
                                <th>Serial</th>
                                <th>Head Name</th>
                                <th>Amount</th>
                                <th>Receipt No.</th>
                                <th>Date</th>
                                <th>Note</th>
                                @if(Helper::canAny(auth()->user(),[66, 67]))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalRecords = $cost_list->total();
                                $perPage = $cost_list->perPage();
                                $currentPage = $cost_list->currentPage();
                                $startingSerial = $totalRecords - ($currentPage - 1) * $perPage;
                            @endphp
                            @foreach ($cost_list as $i)
                            @php
                            $serial = $startingSerial--;
                            @endphp
                                <tr>
                                    <td>{{$serial}}</td>
                                    <td>{!! $i->ac_head_info->name !!}</td>
                                    <td>{{number_format($i->amount,2)}}</td>
                                    <td>{{$i->receipt_no}}</td>
                                    <td>{{$i->date}}</td>
                                    <td>{!! $i->note !!}</td>
                                    @if(Helper::canAny(auth()->user(),[66, 67]))
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-custom fa fa-ellipsis-v"></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                @can('misc_edit', 66)
                                                <a href="{{ route('genacc/miscellaneous/cost/edit', ['id' => Helper::encrypt_decrypt('encrypt', $i->id)]) }}"
                                                   class="dropdown-item">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @endcan
                                                @can('misc_delete', 67)
                                                <form action="{{ route('genacc/miscellaneous/cost/delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt', $i->id) }}">
                                                    <button type="submit" class="dropdown-item">
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
                            <td style="text-align:left" colspan="6" class="font-weight-bold">{{ number_format($totalCost,2) }}/-<br>In words:
                            @php
                            echo Helper::numberToWords($totalCost) . ' Tk. only';
                            @endphp
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pl-2 pt-1 rounded-0" style="overflow-x:auto;">
                    {{ $cost_list->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script>
    $('#general-accounts').addClass('menu-open');
    $('#misc-cost').addClass('active');
</script>
@endsection
