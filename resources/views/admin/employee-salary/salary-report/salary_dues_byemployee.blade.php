@extends('layout.sidebar')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Employee Salary</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Accounts</li>
                        <li class="breadcrumb-item active">Employee Salary</li>
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
                                        <a class="nav-link active" href="#">By Employee</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('genacc/salary/report/designation')}}">By Designation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('genacc/salary/report/session') }}">Salary Report</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('genacc/salary/report/employee') }}" method="GET">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="col-md-6">
                                                <label class="form-label">Enter Employee ID</label>
                                                <input type="text" name="employee_id" value="{{ $employee_id }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Session</label>
                                                <select name="session_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                    <option value={{ $i->id }} @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{ $i->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-3">
                                                <button type="submit" class="btn btn-primary btn-custom font-weight-bold mt-3">Search</button>
                                            </div>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($flag==1)
                {{-- <div class="row">
                    <div class="col-sm-6">
                        <div class="pdf-button"><i class="fa fa-file-pdf"></i> PDF</div>
                    </div>
                </div> --}}
                <div class="row">
                    @foreach($month_list as $mn)
                    <div class="col-12 rounded">
                        <div class="card mt-2">
                            @php
                            $salary_list = Helper::findSalaryByEmployee($mn->id,$session_id, $employee_id);
                            $cnt = $total = $payable_amount = $paid_amount = 0;
                            @endphp
                            <div class="card-body p-2">
                                <form action="{{ route('genacc/salary/report/delete') }}" method="POST">
                                @csrf
                                <button type="submit" style="opacity: 90%;display:none" class="btn btn-danger font-weight-bold mb-2" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i> Delete</button>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-bordered myTable">
                                        <tbody>
                                            <thead class="font-weight-bold">
                                            <tr>
                                                <th colspan="10" style="background-color: #ddd">{{ $mn->name }}</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 10px" class="print-none"><input class="form-group selectAll" type="checkbox" id="select-all"></th>
                                                <td>#</td>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Designation</td>
                                                <td>Account<br>Head</td>
                                                <td>Amount</td>
                                                <td>Paid<br>Amount</td>
                                                <td>Payable<br>Amount</td>
                                                <td>Action</td>
                                            </tr>
                                            </thead>
                                            @foreach($salary_list as $i)
                                            <tr>
                                                <td class="print-none"><input type="checkbox" class="checkbox" name="selected_salary[]" value="{{ $i->id }}"></td>
                                                <td>{{ ++$cnt }}</td>
                                                <td>{{ $i->employee_info->employee_id }}</td>
                                                <td>{!! $i->employee_info->first_name . ' ' . $i->employee_info->last_name !!}</td>
                                                <td>{{ $i->designation_info->name }}</td>
                                                <td>{{ $i->ac_head_info->name }}</td>
                                                <td>{{ number_format($i->amount,2) }}</td>
                                                <td>{{ number_format($i->paid_amount,2) }}</td>
                                                <td>{{ number_format($i->payable_amount,2) }}</td>
                                                <td>
                                                    <button type="button" onclick="editEmployeeDues({{$i->id}})" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-custom icon-btn a-btn-slide-text"><span class="fas fa-edit" aria-hidden="true"></span><span><strong>Edit</strong></span></button>
                                                </td>
                                                @php
                                                $total+=$i->amount;
                                                $paid_amount += $i->paid_amount;
                                                $payable_amount += $i->payable_amount;
                                                @endphp
                                            </tr>
                                            @endforeach
                                            @if($salary_list->count() > 0)
                                            <tr class="font-weight-bold">
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>Sub Total</td>
                                                <td>{{ number_format($total,2) }}</td>
                                                <td>{{ number_format($paid_amount,2) }}</td>
                                                <td>{{ number_format($payable_amount,2) }}</td>
                                                <td>-</td>
                                            </tr>
                                            @else
                                                <tr>
                                                    <td class="text-danger" colspan="10">No records</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title font-weight-bold">Update Salary</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('genacc/salary/report/update') }}" class="form-group" method="POST">
        @csrf
        <div class="modal-body">
            <label for="">Employee Name</label>
            <input type="text" class="form-control" value="" name="" id="employee-name" readonly>
            <label for="">Employee ID</label>
            <input type="text" class="form-control" value="" name="" id="employee-id" readonly>
            <input type="hidden" class="form-control" value="" name="salary_id" id="salary-id">
            <label for="">Designation</label>
            <input type="text" class="form-control" value="" name="" id="employee-designation" readonly>
            <label for="">Month</label>
            <input type="text" class="form-control" value="" name="" id="month" readonly>
            <label for="">Account Head</label>
            <input type="text" class="form-control" value="" name="" id="head-name" readonly>
            <label for="">Amount</label>
            <input type="text" class="form-control" value="" name="amount" id="amount" required>
            <label for="">Paid Amount</label>
            <input type="text" class="form-control" value="" name="" id="paid-amount" readonly>
            <label for="">Payable Amount</label>
            <input type="text" class="form-control" value="" name="payable_amount" id="payable-amount" readonly>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-custom">Save changes</button>
        </div>
        </form>

      </div>
    </div>
</div>
<script>
    $('#general-accounts').addClass('menu-open');
    $('#salary-report').addClass('active');
</script>
<script>

    function editEmployeeDues(data){
        var employeeId = data;
        $.ajax({
            type: 'POST',
            url: "{{ route('find-salary') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id': employeeId
            },
            success: function(response) {
                updateModal(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching salary: ' + error);
            }
        });

        function updateModal(employeeSalary) {
            $('#employee-name').val(employeeSalary.employee_info.first_name + ' ' + employeeSalary.employee_info.last_name);
            $('#employee-id').val(employeeSalary.employee_info.employee_id);
            $('#employee-designation').val(employeeSalary.designation_info.name);
            $('#head-name').val(employeeSalary.ac_head_info.name);
            $('#amount').val(formatNumber(employeeSalary.amount));
            $('#month').val(employeeSalary.month);
            $('#paid-amount').val(isNaN(employeeSalary.paid_amount) ? 0 : formatNumber(employeeSalary.paid_amount));
            $('#payable-amount').val(formatNumber(employeeSalary.payable_amount));
            $('#salary-id').val(employeeSalary.id);
       }
       function formatNumber(number) {
            return parseFloat(number).toFixed(2);
       }

       $('#amount').on('input', function() {
            var amount = parseFloat($(this).val());
            var paid_amount = parseFloat($('#paid-amount').val());

            if (!isNaN(amount) && !isNaN(paid_amount)) {
                $('#payable-amount').val((amount - paid_amount).toFixed(2));
            } else {
                $('#payable-amount').val('');
            }
        });
    }

    $(".myTable").each(function() {
        $(this).find(".selectAll").click(function() {
            $(this).closest("table").find(".checkbox").prop('checked', $(this).prop('checked'));
            updateButtonVisibility(); // Update button visibility
        });

        $(this).find(".checkbox").click(function() {
            $(this).closest("table").find(".selectAll").prop('checked', $(this).closest("table").find(
                ".checkbox:checked").length === $(this).closest("table").find(".checkbox").length);
            updateButtonVisibility(); // Update button visibility
        });

        function updateButtonVisibility() {
            if ($('.checkbox:checked').length > 0) {
                $('.btn-danger').css('display', 'block');
            } else {
                $('.btn-danger').css('display', 'none');
            }
        }
    });
</script>
@endsection
