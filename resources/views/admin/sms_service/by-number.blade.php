@extends('layout.sidebar')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Send SMS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">SMS Service</li>
                            <li class="breadcrumb-item active">Send SMS</li>
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
                                            <a class="nav-link" href="{{ route('send-sms/by/student') }}">By Student</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('send-sms/by/employee') }}">By Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('send-sms/by/class') }}">By Class</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('send-sms/by/designation') }}">By Designation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">By Number</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane fade show active">
                                        <div class="container">
                                            <form action="{{ route('send-sms/by/number') }}" method="get">
                                                @csrf
                                                <div class="row mt-0 pt-0">
                                                    <div class="col-md-6">
                                                        <label for="">Enter Total Number</label>
                                                        <input type="number" name="tm" value="{{ $total_number }}" max="30" min="1" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <button type="submit" class="btn btn-primary btn-custom mt-4 font-weight-bold">NEXT</button>
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
                            <div class="col-md-12 ml-0">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <form action="{{ route('send-sms/number/send') }}" method="POST">
                                            @csrf
                                            @for($i = 1; $i <= $total_number; $i++)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Input Number - {{ $i }}</label>
                                                    <input type="text" name="numbers[]" required maxlength="11" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                </div>
                                            </div>
                                            @endfor
                                            <div class="col-md-6">
                                                <label class="form-label">SMS Text</label>
                                                <textarea name="sms_text" id="sms_text" class="form-control" rows="7" aria-valuetext="Please clear this SMS. Write your message here. This is for demo only." required>Please clear this SMS. Write your message here. This is for demo only.</textarea>
                                                <button type="submit" class="btn btn-primary btn-custom mt-3">SEND SMS</button>
                                            </div>
                                        </form>
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
        $('#sms-service').addClass('menu-open');
        $('#send-sms').addClass('active');
    </script>
@endsection
