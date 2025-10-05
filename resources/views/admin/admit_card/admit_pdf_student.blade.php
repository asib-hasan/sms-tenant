<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .admit-card {
            width: 100%;
            border: 2px solid #000;
            padding: 2px;
            margin-top: 10px;
            font-size: 15px;
        }
        .header {
            text-align: center;
            background-color: #002776;
            color: #fff;
            padding: 5px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
        }

        .header img {
            width: 50px;
            position: absolute;
            left: 20px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content td {
            font-size: 11px;
            border: none;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
        }

        .signature-table td {
            font-size: 14px;
        }

        .admit-card-btn {
            text-align: center;
            margin: 10px 0;
        }

        .admit-card-btn button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="admit-card">
    <table style="width: 100%;">
        <tr>
            <td colspan="6" class="header">
                <img style="height: 50px;width: 50px;" src="{{ asset($school_info->logo_circle) }}" alt="">
                <h1>{{ $school_info->name }}</h1>
                <p>Address: {{ $school_info->address }}</p>
                <p>Phone: {{ $school_info->phone }} | Email: {{ $school_info->email }}</p>
            </td>
        </tr>
        <tr>
            <td style="font-size: 15px;font-weight: bold;padding-top: 20px;width: 20%">ID No: {{ $student_reg_info->student_id }}</td>
            <td colspan="2" class="admit-card-btn" style="padding-left: 70px">
                <button style="font-weight: bold">Admit Card</button>
            </td>
            <td style="text-align: right;">
                @if($student_reg_info->student_info && $student_reg_info->student_info->photo)
                <img style="height: 80px;width: 80px; border:1px solid black;padding:1px;" src="{{ asset('uploads/students/' . $student_reg_info->student_info->photo) }}" alt="">
                @else
                <img style="height: 80px;width: 80px; border:1px solid black;padding:1px;" src="{{ asset('photos/user.png') }}" alt="">
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 10%">Student Name:</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name ?? '' }}</td>
            <td style="width: 10%;white-space: nowrap">Father's Name:</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $student_reg_info->student_info->father ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 10%">Class:</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $student_reg_info->class_info->name ?? '' }}</td>
            <td style="width: 10%; white-space: nowrap">Mother's Name:</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $student_reg_info->student_info->mother ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 10%;">Session:</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $student_reg_info->session_info->name ?? '' }}</td>
            <td style="width: 10%;">Exam :</td>
            <td style="width: 40%;border-bottom: 1px solid black">{{ $exam_info->name }}</td>
        </tr>
    </table>
    <table class="signature-table">
        <tr>
            <td style="width: 30%; text-align: left;">
                <span style="border-top: 1px solid black; display: inline-block; padding-top: 2px;">
                    Responsible Teacher's Signature
                </span>
            </td>
            <td style="width: 30%; text-align: right;">
                <span style="border-top: 1px solid black; display: inline-block; padding-top: 2px;">
                    Principal's Signature
                </span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
