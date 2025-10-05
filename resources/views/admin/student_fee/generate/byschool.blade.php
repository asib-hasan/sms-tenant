@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Fee Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Accounts</li>
                            <li class="breadcrumb-item active">Fee Structure</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stdacc/fee/structure/by/student') }}">By Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stdacc/fee/structure/by/class') }}">By Class</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('stdacc/fee/structure/by/school') }}">By Classes</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <p class="text-danger" style="font-weight: bold">**This will apply to all active students</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ml-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="font-weight: bold"> Fees Information</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('stdacc/fee/structure/apply/school') }}" method="POST">
                                @csrf
                                <label class="form-label">Session</label>
                                <select class="form-control" name="session_id" required>
                                    <option value="">Select</option>
                                    @foreach ($session_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                <label for="fees-head">Fees Head</label>
                                <select class="form-control select2" name="ac_head_id" style="width: 100%" required>
                                    <option value="">Select</option>
                                    @foreach ($ac_head_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                <label for="months">Months</label>
                                <select class="form-control" name="months[]" id="months" multiple required>
                                    @foreach($month_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                <label for="waiver">Amount</label>
                                <input class="form-control" type="number" step="0.1" name="amount" required>
                                <button type="submit" class="btn btn-primary btn-custom mt-3">GENERATE/UPDATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $('#student-accounts').addClass('menu-open');
        $('#fee-structure').addClass('active');
    </script>
@endsection
