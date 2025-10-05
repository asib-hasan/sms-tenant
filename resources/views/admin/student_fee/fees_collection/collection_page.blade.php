@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Fees Collection</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Accounts</li>
                        <li class="breadcrumb-item active">Fees Collection</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    @php
    $preDefined = [];
    $total_due = 0;
    @endphp
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Collection</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('stdacc/fees/collection/summary') }}">Summary</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                    <div class="container">
                                        <form action="{{ route('stdacc/fees/collection') }}" method="get">
                                            @csrf
                                            <div class="row mt-0 pt-0">
                                                <div class="col-md-6 form-group">
                                                    <label>Session</label>
                                                    <select id="session_wise_active_student" class="form-control select2" name="session_id" style="width: 100%;" required>
                                                        <option value="">Select</option>
                                                        @foreach ($session_list as $i)
                                                            <option @selected($session_id == $i->id) value="{{ $i->id }}">{{ $i->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Student</label>
                                                    <select id="active_student_load" class="form-control select2" style="width: 100%" name="student_id" required>
                                                        <option value="">Select</option>
                                                        @foreach ($student_list as $i)
                                                            <option @selected($i->student_id == $student_id) value="{{ $i->student_id }}">{{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }} [{{ $i->student_id }}]</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="month">Month</label>
                                                    <select name="month" id="month" class="form-control select2" style="width: 100%">
                                                        @foreach($month_list as $i)
                                                            <option value="{{ $i->id }}" @selected($month == $i->id)>{{ $i->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary font-weight-bold btn-custom mt-3 ">SEARCH</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if (Session::has('paymentsuccess'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ Session::get('success') }}
                            @php
                                $invoice_id = \Illuminate\Support\Facades\Session::get('invoice_id');
                            @endphp
                            <a href="{{ route('stdacc/transaction/view', ['id' => Helper::encrypt_decrypt('encrypt',$invoice_id)]) }}" target="_blank" class="btn btn-info font-weight-bold text-decoration-none"><i class="fa fa-download"></i> Download Invoice</a>
                          </div>
                        @endif
                    </div>
                   <div class="col-md-12">
                    @include('components.alert')
                   </div>
                </div>
                @if($flag==1)
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-3 text-center mt-4">
                                        @if ($student_reg_info->student_info->photo != "")
                                        <img src = "{{ asset('uploads/students/'. $student_reg_info->student_info->photo)}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @else
                                        <img src = "{{ asset('photos/user.png')}}" alt="user-avatar" height="150px" width="150px" class="img-bordered img-circle">
                                        @endif
                                    </div>
                                    <div class="col-md-9 mt-4">
                                        <table class="table table-bordered table-responsive-lg">
                                            <tbody>
                                                <tr>
                                                    <td class="font-weight-bold">Name</td>
                                                    <td>{{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? ''}}</td>
                                                    <td class="font-weight-bold">Class</td>
                                                    <td>{{ $student_reg_info->class_info->name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">ID</td>
                                                    <td>{{ $student_reg_info->student_id }}</td>
                                                    <td class="font-weight-bold">Roll</td>
                                                    <td>{{ $student_reg_info->roll_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">Session</td>
                                                    <td>{{ $student_reg_info->session_info->name ?? '' }}</td>
                                                    <td class="font-weight-bold">Phone</td>
                                                    <td>{{ $student_reg_info->student_info->mobile ?? '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm text-nowrap">
                                                <tbody>
                                                <tr style="background-color: #6D7AE0;color:white;font-weight: bold">
                                                    <td colspan="6">Fees Overview - {{ \App\Models\MonthsModel::getName($month) }} ({{ $session_name }})</td>
                                                </tr>
                                                <tr class="font-weight-bold" style="background-color: #ddd;">
                                                    <td>Account Head</td>
                                                    <td>Amount</td>
                                                    <td>Waiver(%)</td>
                                                    <td>Amount AW</td>
                                                    <td>Paid Amount</td>
                                                    <td>Due</td>
                                                </tr>
                                                @foreach ($fees_list as $i)
                                                    <tr>
                                                        <td>{{ $i->ac_head_info->name }}</td>
                                                        <td>{{ number_format($i->amount,2) }}</td>
                                                        <td>{{ number_format($i->waiver,2) }}</td>
                                                        <td>{{ number_format($i->amount_after_waiver,2) }}</td>
                                                        <td>{{ number_format($i->paid_amount,2) }}</td>
                                                        <td>{{ number_format($i->due,2) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm text-nowrap">
                                                <tbody>
                                                    <tr style="background-color: #6D7AE0;color:white;font-weight: bold">
                                                        <td colspan="7">Payment History - {{ \App\Models\MonthsModel::getName($month) }} ({{ $session_name }})</td>
                                                    </tr>
                                                    <tr class="font-weight-bold" style="background-color: #ddd;">
                                                        <td style="width: 15%">Invoice No</td>
                                                        <td style="width: 10%">Amount</td>
                                                        <td style="width: 15%">Payment Type</td>
                                                        <td style="width: 15%">Date</td>
                                                        <td style="width: 15%">Note</td>
                                                        <td style="width: 10%">Collected By</td>
                                                        <td style="width: 20%">Action</td>
                                                    </tr>
                                                    @forelse ($invoice_list as $invoice)
                                                    <tr>
                                                        <td>{{ $invoice->invoice_no }}</td>
                                                        <td>{{ $invoice->amount }}</td>
                                                        <td>{{ $invoice->payment_type }}{{ ($i->bank_account_no) ? ' - ' . $i->bank_account_no:'' }}</td>
                                                        <td>{{ $invoice->date }}</td>
                                                        <td>{{ $invoice->note }}</td>
                                                        <td>{{ $invoice->created_by }}</td>
                                                        <td>
                                                            @php
                                                            $payment_details = \App\Models\IncomeStudentDuesModel::where('invoice_id',$invoice->id)->get();
                                                            @endphp
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#invoice-details-{{ $invoice->id }}" class="simple-button"><i class="fa fa-sticky-note"></i> Details</a>
                                                            <div class="modal fade" id="invoice-details-{{ $invoice->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4>Invoice Details</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body table-responsive">
                                                                            <table class="table table-bordered table-sm text-nowrap">
                                                                                <thead>
                                                                                <tr style="background-color: #ddd">
                                                                                    <th colspan="2">Basic Information</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>Invoice No</td>
                                                                                    <td>{{ $invoice->invoice_no }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Total Amount</td>
                                                                                    <td>{{ $invoice->amount }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Payment Type</td>
                                                                                    <td>{{ $invoice->payment_type }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Bank Account No.</td>
                                                                                    <td>{{ $invoice->bank_account_no }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Collected By</td>
                                                                                    <td>{{ $invoice->created_by }}</td>
                                                                                </tr>
                                                                                <tr style="background-color: #ddd;font-weight: bold">
                                                                                    <td colspan="2">Payment Areas and Amount</td>
                                                                                </tr>
                                                                                @foreach($payment_details as $pd)
                                                                                    <tr>
                                                                                        <td>{{ $pd->ac_head_info->name }}</td>
                                                                                        <td>{{ $pd->amount }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#invoice-edit-{{ $invoice->id }}"  class="simple-button"><i class="fa fa-pencil"></i> Edit</a>
                                                            <div class="modal fade" id="invoice-edit-{{ $invoice->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form action="{{ route('stdacc/fees/collection/invoice/update') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="invoice_id" value="{{ Helper::encrypt_decrypt('encrypt',$invoice->id) }}">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title font-weight-bold">Update Invoice - {{ $invoice->invoice_no }}</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">×</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label>Payment Type</label>
                                                                                        <select name="payment_type" class="form-control">
                                                                                            <option value="Cash" @selected($invoice->payment_type == 'Cash')>Cash</option>
                                                                                            <option value="Bank" @selected($invoice->payment_type == 'Bank')>Bank</option>
                                                                                            <option value="Mobile Banking" @selected($invoice->payment_type == 'Mobile Banking')>Mobile Banking</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Bank AC No. (Optional)</label>
                                                                                        <input type="text" class="form-control" name="bank_account_no" value="{{ $invoice->bank_account_no }}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Date</label>
                                                                                        <input type="date"  class=" form-control" name="date" value="{{ $invoice->date }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Note(Optional)</label>
                                                                                        <input type="text" class="form-control" name="note" value="{{ $invoice->note }}">
                                                                                    </div>
                                                                                    <label class="blinking text-info">Payment Details</label>
                                                                                    @php
                                                                                    $payable_list = \App\Models\StudentDuesModel::where('student_id',$student_id)->where('session_id',$session_id)->where('month',$month)->get();
                                                                                    @endphp
                                                                                    @foreach($payable_list as $pl)
                                                                                        @php
                                                                                        $payment_info = \App\Models\IncomeStudentDuesModel::where('dues_id',$pl->id)->where('invoice_id',$invoice->id)->first();
                                                                                        @endphp
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">{{ $pl->ac_head_info->name }}</label>
                                                                                            <input type="number" step="0.01" class="form-control" name="payment_details[{{ $pl->id }}]" value="{{ $payment_info->amount ?? '' }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <button type="submit" class="btn btn-primary btn-custom">UPDATE</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#invoice-delete-{{ $invoice->id }}" class="simple-button text-danger"><i class="fa fa-trash"></i> Delete</a>
                                                            <div class="modal fade" id="invoice-delete-{{ $invoice->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form action="{{ route('stdacc/fees/collection/invoice/delete') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="invoice_id" value="{{ Helper::encrypt_decrypt('encrypt',$invoice->id) }}">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title font-weight-bold text-maroon">Delete Invoice - {{ $invoice->invoice_no }}</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-wrap"><b>**</b>Once you delete invoice, All payment information related this invoice will be deleted'<b>**</b></p>
                                                                                <h3 class="font-weight-bold">Are You Sure?</h3>
                                                                            </div>
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-danger">No records</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 ml-0">
                        <div class="card bg-light ">
                            <div class="card-body pt-0">
                                <div class="row mb-3">
                                    <div class="col-md-12 mt-3">
                                        <form action="{{ route('stdacc/fees/collection/apply') }}" class="form-prevent" method="POST">
                                            @csrf
                                                <input type="hidden" name="student_id" value="{{ Helper::encrypt_decrypt('encrypt',$student_id) }}">
                                                <input type="hidden" name="session_id" value="{{ Helper::encrypt_decrypt('encrypt',$session_id) }}">
                                                <h4 class="font-weight-bold text-center mb-3">Fees Collection Form</h4>
                                                <table class="table table-bordered table-responsive-lg text-nowrap">
                                                    <tbody>
                                                        <tr class="font-weight-bold" style="background-color: #6D7AE0;color:white;">
                                                            <td>Account Head</td>
                                                            <td>Amount</td>
                                                            <td>Due</td>
                                                        </tr>
                                                        @foreach ($fees_list as $i)
                                                        <tr>
                                                            <td>{{ $i->ac_head_info->name ?? '' }}</td>
                                                            <td>
                                                                <input type="number" step="0.01" name="amounts[{{ $i->id }}]" id="amount-{{ $i->id }}" oninput="applyFees({{ $i->id }})" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="due-{{ $i->id }}" value="{{ number_format($i->due,2, '.', '') }}" readonly class="form-control">
                                                            </td>
                                                            @php
                                                                $preDefined[$i->id] = $i->due;
                                                                $total_due += $i->due;
                                                            @endphp
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td class="font-weight-bold">Total Paid</td>
                                                            <td class="font-weight-bold" id="total-paid">{{ number_format(0,2) }}</td>
                                                            <td class="font-weight-bold" id="total-due">{{ number_format($total_due,2, '.', '') }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Payment Type</label>
                                                    <select name="payment_type" class="form-control">
                                                        <option value="Cash">Cash</option>
                                                        <option value="Bank">Bank</option>
                                                        <option value="Mobile Banking">Mobile Banking</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Bank AC No. (Optional)</label>
                                                    <input type="text" class="form-control" name="bank_account_no">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Month</label>
                                                    <input type="text" value="{{ \App\Models\MonthsModel::getName($month) }}" class="form-control" readonly>
                                                    <input type="hidden" value="{{ $month }}" class="form-control" name="month">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Date</label>
                                                    <input type="date"  class="form-control" name="date" id="pay-date" required>
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Note(Optional)</label>
                                                    <input type="text" class="form-control" name="note">
                                                </div>
                                            </div>
                                            <footer class="footer text-right mt-3">
                                                <input type="checkbox" name="sms">
                                                <label class="form-label">Send SMS</label>
                                                <button class="submit btn btn-primary font-weight-bold btn-custom form-prevent-multiple-submit">SUBMIT</button>
                                            </footer>
                                        </form>
                                    </div>
                                </div>
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
    $('#student-accounts').addClass('menu-open');
    $('#fees-collection').addClass('active');
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function applyFees(id) {
        var preDefinedValues = {!! json_encode($preDefined) !!};
        var initialvalue = parseFloat(preDefinedValues[id]);
        var inputElement = document.getElementById('amount-' + id);
        var inputValue = parseFloat(inputElement.value) || 0;
        var dueElement = document.getElementById('due-' + id);
        var previousInputValue = parseFloat(inputElement.getAttribute('data-previous-value')) || 0;
        var previousDueValue = parseFloat(dueElement.getAttribute('data-previous-value')) || initialvalue;
        var totalPaidElement = document.getElementById('total-paid');
        var totalPaid = parseFloat(totalPaidElement.innerText) - previousInputValue;
        var totalDueElement = document.getElementById('total-due');
        var totalDue = parseFloat(totalDueElement.innerText) + previousInputValue;
        var updatedDueValue = initialvalue - inputValue;
        dueElement.value = updatedDueValue.toFixed(2);
        dueElement.setAttribute('data-previous-value', inputValue);
        totalPaid += inputValue;
        totalDue -= inputValue;
        totalPaidElement.innerText = totalPaid.toFixed(2);
        totalDueElement.innerText = totalDue.toFixed(2);
        inputElement.setAttribute('data-previous-value', inputValue);
    }
    $(".close").click(function() {
            $(this).parent(".alert").fadeOut();
    });
    var today = new Date();
    var formattedDate = today.toISOString().substr(0, 10);
    document.getElementById("pay-date").value = formattedDate;
</script>
@endsection
