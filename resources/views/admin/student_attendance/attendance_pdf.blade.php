<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Sheet</title>
    <link rel="stylesheet" href="style.css">

</head>

<style>

    * {
        margin: 0;
    }

    body {
        font-weight: 400;
        margin: 5px;
    }

    .name > td:first-child {
        width: 100px;
    }

    .main {
        font-size: 11px;
    }

    header div {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    header div h1 {
        font-weight: 600;
        margin-top: 1rem;
    }

    header div h3 {
        font-weight: 500;
        font-size: 1.1rem;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    table{
        width: 100%;
    }


    table thead {
        background-color: #ddd;
        color: black;
        border-color: black;
    }


    table .student-name,
    table tr td:first-child {
        min-width: 10rem;
        padding-inline: 1rem;
    }

    table .student-name,
    table td {
        padding-bottom: 1px;
        padding-top: 1px;
    }

    th,
    td {
        min-width: 1.5rem;
        padding-block: 5px;
    }
</style>

<body>
<header>
    <div>
        <h2>{{ $school_info->name }}</h2>
        <p>{{ $school_info->address }}</p>
        <h3>Attendance Sheet</h3>
    </div>
</header>
<main class="main">
    <table>
        <thead>
        <tr>
            <td colspan="10">Teacher Name:</td>
            <td colspan="10">Month: {{ $month }} - {{ $session_name }}</td>
            <td colspan="8">Class: {{ $class_name }}</td>
        </tr>
        <tr>
            <th rowspan="2" class="stduent-name">Student Name and Roll</th>
            <th colspan="25">Date of Attendance</th>
            <th colspan="2">Total</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>
            <th>19</th>
            <th>20</th>
            <th>21</th>
            <th>22</th>
            <th>23</th>
            <th>24</th>
            <th>25</th>
            <th>P</th>
            <th>A</th>
        </tr>
        </thead>
        <tbody>
        <tr class="date">
            <td>Date</td>
            @foreach($attendance_list as $i)
                <td class="date">
                    {{ \Carbon\Carbon::parse($i->date)->format('d') }}
                </td>

            @endforeach
            @php
            $total_attendance_count = count($attendance_list);
            @endphp
            @for($extra = 0; $extra <= 26 - $total_attendance_count; $extra++)
                <td></td>
            @endfor
        </tr>
        @foreach ($student_list as $i)
            <tr class="name">
                <td>
                    @if ($i->roll_no)
                        {{ $i->roll_no }}.
                    @endif
                    {{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }}</td>

                @php $total_absent = $total_present = 0; @endphp
                @foreach($attendance_list as $attendance)
                    @php
                    $attendance_info = \App\Models\StudentAttendanceModel::where('student_id',$i->student_id)->where('date',$attendance->date)->first();
                    $status = $attendance_info && $attendance_info->status == 'P' ? 'P' : 'A';
                    $status == 'P' ? $total_present++:$total_absent++;
                    @endphp
                    <td>{{ $attendance_info->status }}</td>
                @endforeach
                @for($extra = 0; $extra <= 24 - $total_attendance_count; $extra++)
                    <td></td>
                @endfor
                <td>{{ $total_present }}</td>
                <td>{{ $total_absent }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>

</html>
