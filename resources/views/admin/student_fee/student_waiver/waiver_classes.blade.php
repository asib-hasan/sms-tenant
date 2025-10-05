@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Apply Waiver</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Accounts</li>
                            <li class="breadcrumb-item active">Apply Waiver</li>
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
                                    <a class="nav-link" href="{{ route('stdacc/waiver/student') }}">By Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stdacc/waiver/class') }}">By Class</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('stdacc/waiver/classes') }}">By Classes</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <p class="text-danger" style="font-weight: bold">**This will apply to all students</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ml-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="font-weight: bold"> Waiver Information</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('stdacc/waiver/apply/classes') }}" method="POST">
                                @csrf
                                <label for="fees-head" class="form-label">Session</label>
                                <select id="fees-head" class="form-control" name="session_id" required>
                                    <option value="">Select</option>
                                    @foreach ($session_list as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                <label for="fees-head">Select Head</label>
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
                                <label for="waiver">Waiver</label>
                                    <select class="form-control" required name="waiver" id="waiver">
                                        <option value="">Select</option>
                                        <option value="0">0%</option>
                                        <option value="10">10%</option>
                                        <option value="20">20%</option>
                                        <option value="30">30%</option>
                                        <option value="40">40%</option>
                                        <option value="50">50%</option>
                                        <option value="60">60%</option>
                                        <option value="70">70%</option>
                                        <option value="80">80%</option>
                                        <option value="90">90%</option>
                                        <option value="100">100%</option>
                                        <option value="custom">Custom(In percentage)</option>
                                        <option value="custom_amount">Custom(In Amount)</option>
                                    </select>
                                    <input id="custom_waiver" name="custom_waiver" style="display:none" placeholder="Enter Custom waiver" type="number" step="0.1" class="form-control mt-3">
                                    <input id="custom_amount" name="custom_amount" style="display:none" placeholder="Enter amount, Amount will be converted in %" type="number" step="0.1" class="form-control mt-3">
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
        $('#apply-waiver').addClass('active');
    </script>

    <script>

        document.getElementById('waiver').addEventListener('change', function(e) {
            var customWaiverField = document.getElementById("custom_waiver");
            var customAmountField = document.getElementById("custom_amount");

            if (e.target.value === "custom") {
                customWaiverField.style.display = "block";
                customWaiverField.setAttribute("required", "required");
                customWaiverField.removeAttribute("disabled");

                customAmountField.style.display = "none";
                customAmountField.removeAttribute("required");
                customAmountField.setAttribute("disabled", "disabled");
            }
            else if (e.target.value === "custom_amount") {
                customWaiverField.style.display = "none";
                customWaiverField.removeAttribute("required");
                customWaiverField.setAttribute("disabled", "disabled");

                customAmountField.style.display = "block";
                customAmountField.setAttribute("required", "required");
                customAmountField.removeAttribute("disabled");
            }
            else {
                customWaiverField.style.display = "none";
                customWaiverField.removeAttribute("required");
                customWaiverField.setAttribute("disabled", "disabled");

                customAmountField.style.display = "none";
                customAmountField.removeAttribute("required");
                customAmountField.setAttribute("disabled", "disabled");
            }
        });

    </script>
@endsection
