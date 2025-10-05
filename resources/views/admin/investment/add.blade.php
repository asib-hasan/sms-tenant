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
                                <h3 class="card-title font-weight-bold">Add Investment/Donation</h3>
                            </div>
                            <form method="post" action="{{ route('genacc/investment/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Name">Name of Investor/Donor</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Investor/Donor Type</label>
                                        <select name="type" class="form-control" id="">
                                            <option value="0">Individual</option>
                                            <option value="1">Organization</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Amount</label>
                                        <input type="text" class="form-control" name="amount" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Date</label>
                                        <input type="date" id="today" class="form-control" name="date" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Name">Payment Type</label>
                                        <select name="payment_type" class="form-control">
                                            <option value="0">Cash</option>
                                            <option value="1">Check</option>
                                            <option value="2">Bank Transfer</option>
                                            <option value="3">Mobile Banking</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Name">Note</label>
                                        <input type="text" class="form-control" name="note">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <script>
            $('#general-accounts').addClass('menu-open');
            $('#investment').addClass('active');
        </script>

        <script>
            var today = new Date();
            var formattedDate = today.toISOString().substr(0, 10);
            document.getElementById("today").value = formattedDate;
        </script>
    @endsection
