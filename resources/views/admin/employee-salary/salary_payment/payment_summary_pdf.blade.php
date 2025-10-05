<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Salary Payment Summary</title>
    <style>
        body {
            margin: 5px 5px 5px 5px;
            font-size: 10px;
        }
    </style>
</head>
<body>
<main>
    <table style="width: 100%;">
        <thead>
        <tr>
            <th style="font-size: 12px; padding: 5px;">
                <img src="{{ asset($school_info->logo_transparent) }}" alt="Logo" style="object-fit: fill; width: 50px; padding-bottom: 10px"/><br>
                {{ $school_info->name }}<br>
                <span style="font-size: 12px">Salary Payment Summary - {{ \App\Models\SessionModel::getName($session_id) }}</span><br>
            </th>
        </tr>
        </thead>
    </table>
    @php
        ini_set('max_execution_time', 120000000000000);
        ini_set('memory_limit', '5120M');
    @endphp
    <table style="width: 100%;border: 1px solid black;border-collapse: collapse">
        @php $total_amount = 0; @endphp
        @foreach($month_list as $month)
            @php
                $total_payment = \App\Models\EmployeeSalaryModel::where('month',$month->id)->where('session_id',$session_id)->sum('paid_amount');
                $total_amount += $total_payment;
            @endphp
            <tr>
                <th class="table-th-width-60" style="border: 1px solid black;padding: 4px;text-align: left;width: 50%;">{{ $month->name }}</th>
                <th class="table-th-width-30" style="border: 1px solid black;padding: 4px;text-align: left;width: 50%;">{{ $total_payment }}</th>
            </tr>
        @endforeach
        <tr>
            <th class="table-th-width-60" style="border: 1px solid black;padding: 4px;text-align: left;width: 50%;font-weight: bold; background-color: #ddd">Total</th>
            <th class="table-th-width-30" style="border: 1px solid black;padding: 4px;text-align: left;width: 50%;font-weight: bold; background-color: #ddd">{{ $total_amount }} ({{ \App\Helpers\Helper::numberToWords($total_amount) }})</th>
        </tr>
    </table>
</main>
</body>
</html>
