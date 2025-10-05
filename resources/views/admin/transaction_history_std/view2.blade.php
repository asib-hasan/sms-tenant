<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-table td {
            padding: 5px;
            vertical-align: top;
            height: 15px;
        }
        .receipt {
            width: 100%;
        }
        .header {
            text-align: center;
        }
        .header img {
            height: 60px;
            width: auto;
        }
        .title {
            font-weight: bold;
            font-size: 14px;
        }
        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.details th, table.details td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .amount-in-words {
            margin-top: 10px;
        }
        .signature {
            margin-top: 60px;
            text-align: center;
        }
        .qr {
            text-align: center;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<table class="receipt-table">
    <tr>
        <td style="border: 1px solid black; border-right: 2px dotted black;">
            <div class="receipt">
                <div class="header">
                    <img src="{{ asset('photos/school_logo_with_bg.jpg') }}" alt="Logo" />
                    <p class="title">{{ $school_info->name }}</p>
                    <p style="margin-top: -10px">{{ $school_info->address }}, Phone: {{ $school_info->phone }}</p>
{{--                    <p>EIIN: 139019</p>--}}
                </div>
                <p>Payment Date: {{ \Carbon\Carbon::parse($invoice_info->date)->format('d/m/Y') }}</p>
                <p>Receipt for the Month: {{ \App\Models\MonthsModel::getName($invoice_info->month) }}/{{ $invoice_info->session_info->name }}</p>
                <p><strong>Student ID:</strong> {{ $student_reg_info->student_id }}</p>
                <p><strong>Student Name:</strong> {{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</p>
                <p><strong>Shift:</strong> {{ $student_reg_info->shift == '0' ? 'Morning' : 'Day' }} &nbsp; <strong>Class:</strong> {{ $student_reg_info->class_info->name ?? '' }} &nbsp; <strong>Roll:</strong> {{ $student_reg_info->roll_no }} </p>
                <table class="details">
                    <thead>
                    <tr>
                        <th>Fees Details</th>
                        <th>Taka</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 6; $total_amount = 0;@endphp
                    @foreach($amount_list as $am)
                        @php $count--; $total_amount += $am->amount; @endphp
                        <tr>
                            <td>{{ $am->ac_head_info->name ?? '' }}</td>
                            <td>{{ $am->amount }}/-</td>
                        </tr>
                    @endforeach
                    @while($count-- > 0)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endwhile
                    <tr>
                        <td><strong>Total Paid Amount</strong></td>
                        <td><strong>{{ $total_amount }}/-</strong></td>
                    </tr>
                    </tbody>
                </table>
                <p class="amount-in-words">Amount in Words: {{ \App\Helpers\Helper::numberToWords($total_amount) }} Tk. Only</p>
                <div class="signature">Receiver's Signature</div>
                <div class="qr">
                    <p>--- Please Don't Write or Stamp on Below Area ---</p>
                    <p>Invoice No. {{ $invoice_info->invoice_no }}</p>
                </div>
                <p>Student Copy</p>
            </div>
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
        <div class="receipt">
                <div class="header">
                    <img src="{{ asset('photos/school_logo_with_bg.jpg') }}" alt="Logo" />
                    <p class="title">{{ $school_info->name }}</p>
                    <p style="margin-top: -10px">{{ $school_info->address }}, Phone: {{ $school_info->phone }}</p>
                    {{--                    <p>EIIN: 139019</p>--}}
                </div>
                <p>Payment Date: {{ \Carbon\Carbon::parse($invoice_info->date)->format('d/m/Y') }}</p>
                <p>Receipt for the Month: {{ \App\Models\MonthsModel::getName($invoice_info->month) }}/{{ $invoice_info->session_info->name }}</p>
                <p><strong>Student ID:</strong> {{ $student_reg_info->student_id }}</p>
                <p><strong>Student Name:</strong> {{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</p>
                <p><strong>Shift:</strong> {{ $student_reg_info->shift == '0' ? 'Morning' : 'Day' }} &nbsp; <strong>Class:</strong> {{ $student_reg_info->class_info->name ?? '' }} &nbsp; <strong>Roll:</strong> {{ $student_reg_info->roll_no }} </p>
                <table class="details">
                    <thead>
                    <tr>
                        <th>Fees Details</th>
                        <th>Taka</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 6; $total_amount = 0;@endphp
                    @foreach($amount_list as $am)
                        @php $count--; $total_amount += $am->amount; @endphp
                        <tr>
                            <td>{{ $am->ac_head_info->name ?? '' }}</td>
                            <td>{{ $am->amount }}/-</td>
                        </tr>
                    @endforeach
                    @while($count-- > 0)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endwhile
                    <tr>
                        <td><strong>Total Paid Amount</strong></td>
                        <td><strong>{{ $total_amount }}/-</strong></td>
                    </tr>
                    </tbody>
                </table>
                <p class="amount-in-words">Amount in Words: One Thousand Two Hundred Taka Only</p>
                <div class="signature">Receiver's Signature</div>
                <div class="qr">
                    <p>--- Please Don't Write or Stamp on Below Area ---</p>
                    <p>Invoice No. {{ $invoice_info->invoice_no }}</p>
                </div>
                <p>Office Copy</p>
            </div>
        </td>
        <td style="border: 1px solid black; border-left: 2px dotted black;">
        <div class="receipt">
                <div class="header">
                    <img src="{{ asset('photos/school_logo_with_bg.jpg') }}" alt="Logo" />
                    <p class="title">{{ $school_info->name }}</p>
                    <p style="margin-top: -10px">{{ $school_info->address }}, Phone: {{ $school_info->phone }}</p>
                    {{--                    <p>EIIN: 139019</p>--}}
                </div>
                <p>Payment Date: {{ \Carbon\Carbon::parse($invoice_info->date)->format('d/m/Y') }}</p>
                <p>Receipt for the Month: {{ \App\Models\MonthsModel::getName($invoice_info->month) }}/{{ $invoice_info->session_info->name }}</p>
                <p><strong>Student ID:</strong> {{ $student_reg_info->student_id }}</p>
                <p><strong>Student Name:</strong> {{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</p>
                <p><strong>Shift:</strong> {{ $student_reg_info->shift == '0' ? 'Morning' : 'Day' }} &nbsp; <strong>Class:</strong> {{ $student_reg_info->class_info->name ?? '' }} &nbsp; <strong>Roll:</strong> {{ $student_reg_info->roll_no }} </p>
                <table class="details">
                    <thead>
                    <tr>
                        <th>Fees Details</th>
                        <th>Taka</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 6; $total_amount = 0;@endphp
                    @foreach($amount_list as $am)
                        @php $count--; $total_amount += $am->amount; @endphp
                        <tr>
                            <td>{{ $am->ac_head_info->name ?? '' }}</td>
                            <td>{{ $am->amount }}/-</td>
                        </tr>
                    @endforeach
                    @while($count-- > 0)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endwhile
                    <tr>
                        <td><strong>Total Paid Amount</strong></td>
                        <td><strong>{{ $total_amount }}/-</strong></td>
                    </tr>
                    </tbody>
                </table>
                <p class="amount-in-words">Amount in Words: One Thousand Two Hundred Taka Only</p>
                <div class="signature">Receiver's Signature</div>
                <div class="qr">
                    <p>--- Please Don't Write or Stamp on Below Area ---</p>
                    <p>Invoice No. {{ $invoice_info->invoice_no }}</p>
                </div>
                <p>Class Teacher Copy</p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
