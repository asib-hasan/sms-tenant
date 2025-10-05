@extends('layout.sidebar')
@section('content')
@cannot('student_dues_edit', 55)
<style>
    .dis-none{
        display: none;
    }
</style>
@endcannot
@cannot('student_dues_delete', 56)
<style>
    .delete-none{
        display: none;
    }
</style>
@endcannot
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Student Dues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Accounts</li>
                        <li class="breadcrumb-item active">Student Dues</li>
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
                                        <a class="nav-link active" href="#">By Student</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('stdacc/dues/class')}}">By Class</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('stdacc/dues/report')}}">Dues Report</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-pane fade show active">
                                  <div class="container">
                                      <form action="{{ route('stdacc/dues/student') }}" method="get">
                                        @csrf
                                        <div class="row mt-0 pt-0">
                                            <div class="col-md-6">
                                                <label for="">Enter Student ID</label>
                                                <input type="text" name="student_id" value="{{ $student_id != "" ? $student_id : '20250005'}}" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Session</label>
                                                <select name="session_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($session_list as $i)
                                                    <option value="{{$i->id}}" @selected($session_id == $i->id || ($i->is_current == 0 && $session_id == null))>{{$i->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-custom font-weight-bold mt-3 ml-2">Search</button>
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
                        <div class="pdf-button font-weight-bold"><i class="fa fa-file-pdf"></i> PDF</div>
                    </div>
                </div> --}}

                <div class="row">
                    @foreach($month_list as $mnt)
                    <div class="col-12 rounded">
                        <div class="card mt-2">
                            @php
                            $fees_list = Helper::findFeesByStudent($mnt->id,$session_id, $student_id);
                            $cnt = $total = $amount_after_waiver = $paid_amount = $due = 0;
                            @endphp
                            <div class="card-body p-2">
                                <form action="{{ route('stdacc/dues/delete') }}" method="POST">
                                @csrf
                                <button type="submit" style="opacity: 90%;display:none" class="btn btn-danger font-weight-bold mb-2" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i> Delete</button>
                                <div class="table-responsive-lg text-nowrap">
                                    <table class="table table-bordered myTable">
                                        <tbody>
                                            <thead class="font-weight-bold">
                                            <tr style="background-color: #ddd">
                                                <th colspan="12">{{ $mnt->name }}</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 10px" class="delete-none"><input class="form-group selectAll" type="checkbox" id="select-all"></th>
                                                <td>#</td>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Class</td>
                                                <td>Account<br>Head</td>
                                                <td>Amount</td>
                                                <td>Waiver(%)</td>
                                                <td>Amount<br>After Waiver</td>
                                                <td>Paid<br>Amount</td>
                                                <td>Due</td>
                                                <td class="dis-none">Action</td>
                                            </tr>
                                            </thead>
                                            @foreach ($fees_list as $i)
                                            <tr>
                                                <td class="delete-none"><input type="checkbox" class="checkbox" class="checkbox" name="selected_dues[]" value="{{ $i->id }}"></td>
                                                <td>{{ ++$cnt }}</td>
                                                <td>{{ $i->student_id }}</td>
                                                <td>{!! wordwrap($i->student_info->first_name . ' ' . $i->student_info->last_name , 15, "<br>\n", true)!!}</td>
                                                <td>{{ $i->class_info->name ?? '' }}</td>
                                                <td>{{ $i->ac_head_info->name }}</td>
                                                <td>{{ number_format($i->amount,2) }}</td>
                                                <td>{{ number_format($i->waiver,2)}}</td>
                                                <td>{{ number_format($i->amount_after_waiver,2) }}</td>
                                                <td>{{ number_format($i->paid_amount,2) }}</td>
                                                <td>{{ number_format($i->due,2) }}</td>
                                                <td class="dis-none"><button type="button" onclick="editStudentDues({{ $i->id }})" data-toggle="modal" data-target="#modal-default"
                                                    class="btn btn-primary btn-custom icon-btn a-btn-slide-text">
                                                    <span class="fas fa-edit" aria-hidden="true"></span>
                                                    <span><strong>Edit</strong></span>
                                                    </button>
                                                </td>
                                                @php
                                                $total+=$i->amount;
                                                $amount_after_waiver +=$i->amount_after_waiver;
                                                $paid_amount += $i->paid_amount;
                                                $due += $i->due;
                                                @endphp
                                            </tr>
                                            @endforeach
                                            @if($fees_list->count() > 0)
                                            <tr class="font-weight-bold">
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>Sub Total</td>
                                                <td>{{ number_format($total,2) }}</td>
                                                <td>-</td>
                                                <td>{{ number_format($amount_after_waiver,2) }}</td>
                                                <td>{{ number_format($paid_amount,2) }}</td>
                                                <td>{{ number_format($due,2)  }}</td>
                                                <td class="dis-none">-</td>
                                            </tr>
                                            @else
                                                <tr>
                                                    <td colspan="12" class="text-danger">No records</td>
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
          <h4 class="modal-title font-weight-bold">Update Dues</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('stdacc/dues/update') }}" class="form-group" method="POST">
        @csrf
        <div class="modal-body">
            <label for="">Student Name</label>
            <input type="text" class="form-control" value="" name="" id="student-name" readonly>
            <label for="">ID</label>
            <input type="hidden" value="" name="dues_id" id="dues_id">
            <input type="text" class="form-control" value="" name="" id="student-id" readonly>
            <label for="">Class</label>
            <input type="text" class="form-control" value="" name="" id="student-class" readonly>
            <label for="">Account Head</label>
            <input type="text" class="form-control" value="" name="" id="head-name" readonly>
            <label for="">Amount</label>
            <input type="text" class="form-control" value="" name="amount" id="amount">
            <label for="">Waiver(%)</label>
            <input type="text" class="form-control" value="" name="waiver" id="waiver">
            <label for="">Amount After Waiver</label>
            <input type="text" class="form-control" value="" name="amount_after_waiver" id="amount-aw" readonly>
            <label for="">Paid Amount</label>
            <input type="text" class="form-control" value="" name="" id="paid-amount" readonly>
            <label for="">Due</label>
            <input type="text" class="form-control" value="" name="due" id="due" readonly>
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
    $('#student-accounts').addClass('menu-open');
    $('#student-dues').addClass('active');
</script>
<script>
    function editStudentDues(data){
        var studentId = data;
        $.ajax({
            type: 'POST',
            route: "{{ route('find-dues', ['id' => ':id']) }}".replace(':id', studentId),
            data: {
                '_token': '{{ csrf_token() }}',
            },
            success: function(response) {
                updateModal(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching student dues: ' + error);
            }
        });
       function updateModal(studentDues) {
            $('#student-name').val(studentDues.student_info.first_name + ' '+ studentDues.student_info.last_name);
            $('#student-id').val(studentDues.student_id);
            $('#student-class').val(studentDues.student_reg_info.class_info.name);
            $('#head-name').val(studentDues.ac_head_info.name);
            $('#amount').val(formatNumber(studentDues.amount));
            $('#waiver').val(formatNumber(studentDues.waiver));
            $('#amount-aw').val(formatNumber(studentDues.amount_after_waiver));
            $('#paid-amount').val(formatNumber(studentDues.paid_amount));
            $('#due').val(formatNumber(studentDues.due));
            $('#dues_id').val(studentDues.id);
       }
       function formatNumber(number) {
            return parseFloat(number).toFixed(2);
       }
       $('#waiver').on('input', function() {
            var waiverValue = $(this).val();
            var paid_amount = $('#paid-amount').val();
            $('#waiver').blur(function() {
                if ($(this).val() === '') {
                    $(this).val(parseFloat(0).toFixed(2));
                    waiverValue = $(this).val();
                    var amount = parseFloat($('#amount').val());
                    var waiverPercentage = parseFloat(waiverValue);
                    if (!isNaN(amount) && !isNaN(waiverPercentage)) {
                        var amountAfterWaiver = amount - (amount * (waiverPercentage / 100));
                        $('#amount-aw').val(amountAfterWaiver.toFixed(2));
                        $('#due').val((amountAfterWaiver-paid_amount).toFixed(2));
                    }
                }
            });
            var amount = parseFloat($('#amount').val());
            var waiverPercentage = parseFloat(waiverValue);
            if (!isNaN(amount) && !isNaN(waiverPercentage)) {
                var amountAfterWaiver = amount - (amount * (waiverPercentage / 100));
                $('#amount-aw').val(amountAfterWaiver.toFixed(2));
                $('#due').val((amountAfterWaiver-paid_amount).toFixed(2));
            }
        });

        $('#amount').on('input', function() {
            var amount = parseFloat($(this).val());
            var waiverPercentage = parseFloat($('#waiver').val());
            var paid_amount = parseFloat($('#paid-amount').val());

            if (isNaN(waiverPercentage)) waiverPercentage = 0;

            var amountAfterWaiver = amount - (amount * (waiverPercentage / 100));
            $('#amount-aw').val(amountAfterWaiver.toFixed(2));
            $('#due').val((amountAfterWaiver - paid_amount).toFixed(2));
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
