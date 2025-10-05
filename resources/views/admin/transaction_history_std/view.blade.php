<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

<style>

    * {
        margin: 0;
        padding: 0;
    }
    body {
        font-weight: 400;
        font-size:11px;
    }

    main {
        padding-block: 2rem;
    }

    p {
        margin-bottom: 3px;
    }

    .container {
        max-width: 750px;
        margin: 0 auto;
    }

    .flex-between {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .flex-between>*:last-child {
        text-align: right;
    }

    .half-width {
        width: 50%;
        margin-left: auto;
    }

    .font-bold {
        font-weight: 700;
    }

    .mb-2 {
        display: block;
        margin-bottom: 0.5rem;
    }

    .mb-4 {
        display: block;
        margin-bottom: 1rem;
    }

    .mb-6 {
        display: block;
        margin-bottom: 1.5rem;
    }

    .p-2 {
        padding: 0.5rem;
    }

    .bill-to {
        margin-top: 1rem;
    }

    .bill-to>p:last-child {
        margin-bottom: 1.5rem;
    }

    .bill-to h3 {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .signature {
        margin-top: 1.5rem;
        margin-left:650px;
        display: inline-block;
        border-top: 1px solid black;
    }
    @page{
        width:595px;
        height:842px;
    }
</style>

<body>
    <main>
        <section class="section1">
            <div class="container">
            <span style="font-style: italic">Office Copy</span>
                <div class="flex-between">
                    <div class="mb-6">
                        <h1 class="mb-2">{{ $school_info->name }}</h1>
                        <p><span class="font-bold">Address:</span> {{ $school_info->address }}</p>
                        <p><span class="font-bold">Phone: </span> {{ $school_info->phone }}</p>
                        <p><span class="font-bold">Email:</span> {{ $school_info->email }}</p>
                    </div>
                    <div style="position:absolute;top:25px;left:658px">
                        <p class="font-bold">INVOICE NO.</p>
                        <span class="mb-4">INV - {{$invoice_info->invoice_no}}</span>
                        <p class="font-bold">Issue Date & Time</p>
                        <span class="mb-4">{{$invoice_info->created_at}}</span>
                    </div>
                </div>
                <hr>
                <div class="bill-to">
                    <h2 class="mb-2">Bill To</h2>
                    <h3>{{$student_info->first_name}} {{$student_info->last_name}}</h3>
                    <p>Student id: {{$invoice_info->id_number}}</p>
                    <p><span class="font-bold">Phone:</span> {{$student_info->mobile}}</p>
                    <p class="mb-6"><span class="font-bold">Email:</span> {{$student_info->email}}</p>
                    <hr>
                    <div class="font-bold p-2">
                        <p>DESCRIPTION <span style="padding-left:600px"> AMOUNT</span></p>
                    </div>
                    <hr>
                    @php
                        $total = 0;
                    @endphp
                    <div class="flex-between p-2">
                        <h4 style="margin-bottom:7px">Month/Session: {{ \App\Models\MonthsModel::getName($invoice_info->month) }}/{{ $invoice_info->session_info->name}}</h4>
                        @foreach ($getAmount as $i)
                        <span style="line-height: 0.7;font-style:italic"><b>{{$i->ac_head_info->name}} </b> <span style="text-align:right; display: block;font-style:normal;font-weight:bold">{{number_format($i->amount,2)}} Tk.</span></span>
                        @php
                            $total+=$i->amount;
                        @endphp
                        @endforeach
                        Bank Account No:  {{ $invoice_info->bank_account_no }} <br> Payment Type: {{$invoice_info->payment_type}} <br> {{ $invoice_info->note }}</span>
                    </div>
                    <hr>
                    <div class="half-width">
                        <div class="flex-between p-2">
                            <p class="font-bold">TOTAL - {{$total}}Tk.</p>

                        </div>
                    </div>
                    <p class="signature">Authorized Signature</p>
                </div>

            </div>

        </section>
       -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        <section class="section1">

            <div class="container">
            <span style="font-style: italic">Student Copy</span>
                @php
                    $total = 0;
                @endphp
                <div class="flex-between">
                    <div class="mb-6">
                        <h1 class="mb-2">{{ $school_info->name }}</h1>
                        <p><span class="font-bold">Address:</span> {{ $school_info->address }}</p>
                        <p><span class="font-bold">Phone: </span> {{ $school_info->phone }}</p>
                        <p><span class="font-bold">Email:</span> {{ $school_info->email }}</p>
                    </div>
                    <div style="position:relative;bottom:110px">
                        <p class="font-bold">INVOICE NO.</p>
                        <span class="mb-4">INV - {{$invoice_info->invoice_no}}</span>
                        <p class="font-bold">Issue Date & Time</p>
                        <span class="mb-4">{{$invoice_info->created_at}}</span>
                    </div>
                </div>
                <hr>
                <div class="bill-to">
                    <h2 class="mb-2">Bill To</h2>
                    <h3>{{ $student_info->first_name }} {{ $student_info->last_name }}</h3>
                    <p>Student id: {{ $invoice_info->id_number }}</p>
                    <p><span class="font-bold">Phone:</span> {{ $student_info->mobile }}</p>
                    <p class="mb-6"><span class="font-bold">Email:</span> {{ $student_info->email }}</p>
                    <hr>
                    <div class="font-bold p-2">
                        <p>DESCRIPTION <span style="padding-left:600px"> AMOUNT</span></p>
                    </div>
                    <hr>
                    <div class="flex-between p-2">
                        <h4 style="margin-bottom:7px;">Month/Session: {{ \App\Models\MonthsModel::getName($invoice_info->month) }}/{{ $invoice_info->session_info->name }}</h4>
                        @foreach ($getAmount as $i)
                        <span style="line-height: 0.7;font-style:italic"><b>{{ $i->ac_head_info->name }} </b> <span style="text-align:right; display: block;font-style:normal;font-weight:bold">{{ number_format($i->amount,2) }} Tk.</span></span>
                        @php
                            $total+=$i->amount;
                        @endphp
                        @endforeach
                        Bank Account No:  {{$invoice_info->bank_account_no}} <br> Payment Type: {{$invoice_info->payment_type}} <br> {{$invoice_info->note}}</span>
                    </div>
                    <hr>
                    <div class="half-width">
                        <div class="flex-between p-2">
                            <p class="font-bold">TOTAL - {{number_format($total,2)}}Tk.</p>
                        </div>
                    </div>
                    <p class="signature">Authorized Signature</p>
                </div>

            </div>

        </section>
    </main>
</body>

</html>
