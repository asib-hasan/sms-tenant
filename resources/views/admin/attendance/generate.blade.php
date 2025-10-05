<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Sheet</title>
    <link rel="stylesheet">

</head>

<style>

    * {
        margin: 0;
    }

    body {
        font-family: "Source Sans Pro";
        font-weight: 400;
        margin: 5px;
    }

    header,
    main {
        padding-inline: 1.5rem;
    }

    .date > td {
        height: 80px;
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

    header div div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    header div div p {
        min-width: 10rem;
        text-align: left;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    table {
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
        padding: 1px;
    }

    th,
    td {
        min-width: 2rem;
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
            <td colspan="10">Month:</td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($student_list as $i)
            <tr class="name">
                <td>
                    @if ($i->roll_no)
                        {{ $i->roll_no }}.
                    @endif
                    {{ $i->student_info->first_name ?? '' }} {{ $i->student_info->last_name ?? '' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>

</html>
