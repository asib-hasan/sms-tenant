<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee ID Card</title>
    <link rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @page {
        margin: 0px;
        size: 639pt 1014pt;
    }

    .id-card-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5in;
    }

    .id-card-container .card-img {
        width: 100%;
        height: 100%;
    }

    .id-card-container div:first-child {
        position: relative;
    }

    .id-card-container .employee-photo {
        position: absolute;
        left: 49%;
        transform: translateX(-50%);
        top: 15mm;
        margin-top: 313px;
        width: 3.4in;
        height: 3.5in;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        border: 7px solid #1089ff;
    }

    .id-card-container .employee-info {
        position: absolute;
        top: 200mm;
        left: 50%;
        transform: translateX(-50%);
        font-size: 38pt;
        font-weight: 700;
        text-align: center;
    }

    .school-logo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 15mm;
        height: 120px;
        width: 120px;
    }

    .school-info {
        position: absolute;
        top: 46mm;
        left: 50%;
        transform: translateX(-50%);
        font-size: 30pt;
        font-weight: 700;
        text-align: center;
        width: 80%;
        line-height: 1.2em;
        word-wrap: break-word;
    }

    .id-card-container .employee-info span {
        font-weight: 700;
    }

    .id-card-container .head-sign {
        position: absolute;
        right: 20mm;
        bottom: 85px;
        font-size: 25pt;
        font-weight: 700;
    }

    .id-card-container .head-sign img {
        width: 50mm;
        display: block;
        margin-inline: auto;
    }

    .id-card-container .head-sign span {
        display: block;
    }

    .id-card-container .head-sign .sign-line {
        width: 100%;
        height: 0.5px;
        background-color: black;
        margin-block: 2px;
    }

    .page-break {
        page-break-after: always;
    }

    .back-info {
        position: absolute;
        top: 80mm;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        width: 85%;
        font-size: 22pt;
        line-height: 1.4em;
        font-family: Arial, sans-serif;
    }

    .back-info .title {
        font-size: 26pt;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .back-info .note {
        margin-top: 100px;
        font-size: 20pt;
        font-style: italic;
    }
</style>

<body>
<div class="a4-page">
    <div class="id-card-container">
        <!-- Front Side -->
        <div>
            <img src="{{ asset('id_card_2/front.png') }}" alt="Front Part of ID Card" class="card-img">

            <img src="{{ asset('uploads/teachers/' . $employee_info->image) }}" alt="Employee Photo" class="employee-photo">

            <img src="{{ asset($school_info->logo_transparent) }}" alt="School Logo" class="school-logo">
            <span class="school-info">{!! $school_info->name !!}</span>
            <span class="school-info" style="font-style: italic; margin-top: 120px;opacity: 30%">EMPLOYEE ID CARD</span>

            <!-- Employee Info -->
            <div class="employee-info">
                <p>{{ $employee_info->first_name }} {{ $employee_info->last_name }}</p>
                <p>{{ $employee_info->employee_id }}</p>
                <p>{{ $employee_info->designation_info->name ?? '' }}</p>
                <p><span>Blood Group:</span> {{ $employee_info->blood_group }}</p>
            </div>

            <!-- Principal's Sign -->
            <div class="head-sign">
                <img src="{{ asset('id_card/signature.png') }}" alt="Sign">
                <span class="sign-line"></span>
                <span>Principal's Signature</span>
            </div>
        </div>

        <!-- Back Side -->
        <div class="page-break"></div>
        <div style="position: relative;">
            <img src="{{ asset('id_card_2/back.png') }}" alt="Rear Part of ID Card" class="card-img">

            <div class="back-info">
                <img src="{{ asset($school_info->logo_transparent) }}" alt="School Logo" style="height: 150px; width: 150px; margin: 0 auto 20px auto;">
                <div class="title">{{ $school_info->name }}</div>
                <p>{{ $school_info->address }}</p>
                <p>Phone: {{ $school_info->phone }}</p>
                <p>Email: {{ $school_info->email }}</p>
                <p>Website: {{ $school_info->website }}</p>

                <p class="note">If found, please return this card to the school authority</p>
            </div>
        </div>

    </div>
</div>
</body>
</html>
