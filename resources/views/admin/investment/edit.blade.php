@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Accounts</li>
                            <li class="breadcrumb-item active">Investment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('components.alert')
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Update Investment/Donation</h3>
                            </div>
                            <form method="post" action="{{ route('genacc/investment/update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Helper::encrypt_decrypt('encrypt', $investment_info->id) }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Name">Name of Investor/Donor</label>
                                        <input type="text" value="{{ $investment_info->name }}" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Investor/Donor Type</label>
                                        <select name="type" class="form-control" id="">
                                            <option @selected($investment_info->type == 0) value="0">Individual</option>
                                            <option @selected($investment_info->type == 1) value="1">Organization</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Amount</label>
                                        <input type="text" value="{{ $investment_info->amount }}" class="form-control" name="amount" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Date</label>
                                        <input type="date" value="{{ $investment_info->date }}" class="form-control" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Payment Type</label>
                                        <select name="payment_type" class="form-control">
                                            <option value="0" @selected($investment_info->payment_type == '0')>Cash</option>
                                            <option value="1" @selected($investment_info->payment_type == '1')>Check</option>
                                            <option value="2" @selected($investment_info->payment_type == '2')>Bank Transfer</option>
                                            <option value="2" @selected($investment_info->payment_type == '3')>Mobile Banking</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Note</label>
                                        <input type="text" value="{{ $investment_info->note }}" class="form-control" id="name" name="note">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
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
