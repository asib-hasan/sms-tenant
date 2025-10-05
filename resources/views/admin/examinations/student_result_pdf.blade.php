<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Academic Report</title>
<style>


    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 5px;
        border:1px solid #ddd;
        border-radius: 10px;
    }

    h1 {
        color: black;
        font-size: 20px;
        margin-top: 0px;
    }

    h3 {
        color: black;
        font-size: 12px;
    }

    p {
        margin: 5px 0;
    }

    .info {
        margin-bottom: 20px;
    }

    .stamp {
        text-align: center;
    }

    .stamp ul{
        font-size: 11px;
        margin-top: -10px;
    }
    .result-table {
        width: 100%;
        border-collapse: collapse;
    }

    .result-table th, .result-table td {
        padding: 3px;
        text-align: center;
        border: 1.3px solid black;
    }

    .result-table th {
        background-color: #ddd;
        color: black;
    }

    .custom-table,td, tr{
        border:1px solid black;
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;

    }
    .custom-table td{
        padding: 2px;
    }
    .custom-table th{
        background-color: rgb(217, 217, 217);
    }
    .logo{
        width: auto;
        height: 110px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="stamp">
            <img class="logo" src="{{ asset($school_info->text_transparent) }}" alt="">
            <h1>{{ $school_info->name }}</h1>
            <ul>{{ $school_info->address }}</ul>
            <ul>Phone: {{ $school_info->phone }}, Email: <span>{{ $school_info->email }}</span></ul>
            <h3>{{ \App\Models\ExamModel::getName($exam_id) }} [Session: {{ \App\Models\SessionModel::getName($session_id) }}]</h3>
            <h2 style="font-style: italic;opacity: 40%">Academic Report</h2>
        </div>

        <div class="info">
            <table class="table custom-table">
                <tbody>
                <tr>
                  <th colspan="2" style="text-align: left;padding:3px">Student Information</th>
                </tr>
                  <tr>
                    <td><strong>Name:</strong> {{ $student_reg_info->student_info->first_name ?? '' }} {{ $student_reg_info->student_info->last_name }}</td>
                    <td><strong>Class:</strong> {{ $student_reg_info->class_info->name ?? '' }}</td>
                  </tr>
                  <tr>
                    <td><strong>Mother Name:</strong> {{ $student_reg_info->student_info->mother ?? '' }}</td>
                    <td><strong>Roll No:</strong> {{ $student_reg_info->roll_number }}</td>
                  </tr>
                  <tr>
                    <td><strong>Father Name:</strong> {{ $student_reg_info->student_info->father }}</td>
                    <td><strong>ID:</strong> {{ $student_reg_info->student_id }}</td>
                  </tr>
                </tbody>
              </table>
        </div>
        <div class="info">
            <table class="result-table">
                <tr>
                    <th>Subject</th>
                    <th>Mark Obtained</th>
                    <th>Grade Point</th>
                    <th>Letter Grade</th>
                </tr>
                @php
                    $total_grade_point = 0;
                @endphp
                @foreach ($assigned_subject_list as $as)
                @php
                    $result_info = Helper::getResult($student_reg_info->student_id, $as->class_id, $as->subject_id, $session_id, $exam_id);
                    $is_count = 1;
                @endphp
                <tr>
                    <td>{{ $as->subject_info->name ?? '' }}</td>
                    @if ($result_info != null && $result_info->mark !=null && $result_info->is_published != 0)
                        <td>{{ number_format($result_info->mark,2) }}</td>
                        <td>{{ number_format($result_info->grade_point,2) }}</td>
                        <td>{{ $result_info->letter_grade }}</td>
                    @else
                        {{ $is_count = 0 }}
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                @endforeach
                <tr>
                    <th style="font-style: italic">Result</th>
                    <th style="font-style: italic">Total</th>
                    <th style="font-style: italic">Grade Point Average</th>
                    <th style="font-style: italic">Letter Grade</th>
                </tr>
                <tr>
                    <td>{{ $result }}</td>
                    <td>{{ number_format($total_mark,2) }}</td>
                    <td>{{ number_format($gpa,2) }}</td>
                    <td>
                        {{ Helper::find_grade_from_point($gpa) }}
                    </td>
                </tr>
            </table>

            <table style="margin-top: 30px" class="result-table">
                <tr>
                    <th>Class Teacher Signature</th>
                    <th>Principal Signature</th>
                    <th>Guardian Signature</th>
                </tr>
                <tr>
                    <td style="padding: 25px"></td>
                    <td style="padding: 25px"></td>
                    <td style="padding: 25px"></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
