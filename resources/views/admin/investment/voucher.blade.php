<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .container {
            padding: 20px;
            border: 1px solid #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header .logo {
            float: left;
            font-weight: bold;
        }
        .header .number {
            float: right;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        .section label {
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 2px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #ffff71;
        }
        .footer {
            text-align: right;
            margin-top: 50px;
        }
        .footer div {
            display: inline-block;
            width: 24%;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img style="height: 100px; width: 100px" src="{{ asset($school_info->logo_transparent) }}" alt="">
        </div>
        <h2 style="margin-right:70px">RECEIPT VOUCHER</h2>
        <div class="number">
            <p>Voucher ID: {{ str_pad($investment_info->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p>Date: {{ $investment_info->date }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Details -->
    <div class="section">
        <p><label>Received From:</label> {{ $investment_info->name }}</p>
    </div>

    <!-- Table -->
    <table class="table">
        <thead>
        <tr>
            <th>Particulars</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Investment / Donation</td>
            <td>{{ $investment_info->amount }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;font-weight: bold">Total: {{ $investment_info->amount }} /-</td>
        </tr>
        </tbody>
    </table>

    <div class="section">
        <p><label>Amount in words:</label> {{ \App\Helpers\Helper::numberToWords($investment_info->amount) }} Tk. Only</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>Received By</div>
    </div>
</div>
</body>
</html>
