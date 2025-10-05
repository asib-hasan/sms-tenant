<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial Certificate</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    @page {
        margin: 0px;
        size: 639pt 507.2pt;
    }

    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        background-color: #f9f9f9;
    }

    .certificate {
        border: 10px solid #004d40;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        box-sizing: border-box;
    }

    .certificate::before {
        content: '';

        border: 5px dashed #ffeb3b;
        pointer-events: none;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    header h1 {
        margin: 0;
        font-size: 24px;
        color: #004d40;
    }

    header h2 {
        margin: 5px 0;
        font-size: 20px;
        color: #004d40;
    }

    header p {
        margin: 2px 0;
        font-size: 14px;
        color: #004d40;
    }

    main {
        padding: 20px;
    }

    main h2 {
        text-align: center;
        font-size: 22px;
        color: #004d40;
        margin-bottom: 20px;
    }

    .ref-date {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .ref-date p {
        margin: 0;
        font-size: 14px;
        color: #004d40;
    }

    main p {
        margin: 10px 0;
        font-size: 16px;
        line-height: 1.6;
    }

    main p strong {
        font-weight: bold;
    }

    .footer {
        margin-top: 40px;
    }

    .footer p {
        margin: 5px 0;
        font-size: 14px;
    }

    .signature {
        margin-top: 50px;
    }
</style>
<body>
    <div class="certificate">
        <header>
            <img src="{{ asset($school_info->logo_transparent) }}" alt="" height=50px" width="auto">
            <h1>{{ $school_info->name }}</h1>
            <p>{{ $school_info->address }}</p>
        </header>
        <main>
            <h2>Testimonial</h2>
            <div class="ref-date">
                <p>Date: <strong>{{ $today_date }}</strong></p>
            </div>
            <p>This is to certify that <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>, daughter of <strong>{{$student->father}}</strong> and <strong>{{$student->mother}}</strong> passed the <strong>{{$exam}}</strong> Examination in
            {{$pass_year}} from this institution @if($board!='Self') under the {{$board}}@endif,bearing Roll No. <strong>{{$roll_number}}</strong> and Registration No. <strong>{{$reg_number}}</strong> and obtained Grade Point Average <strong>{{$result}}</strong> out of 5.00 @if($group!="")</strong> in <strong>{{$group}}</strong>@endif. Her date of birth is <strong>{{$student->dob}}</strong>.</p>
            <p>To the best of my knowledge she did not take part in any activities subversive of the state or discipline. Her conduct and character are good.</p>
            <p>I wish her every success in life.</p>
            <div class="footer">
                <p>Principal</p>
                <p>{{ $school_info->name }}</p>
                <p>{{ $school_info->name }}</p>
            </div>
        </main>
    </div>
</body>
</html>
