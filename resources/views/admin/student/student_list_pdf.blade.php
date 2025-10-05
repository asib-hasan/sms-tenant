<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Student List</title>
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
                <span style="font-size: 12px">Student List - {{ $session_name }}</span><br>
            </th>
        </tr>
        </thead>
    </table>
    @php
        ini_set('max_execution_time', 120000000000000);
        ini_set('memory_limit', '5120M');
    @endphp
    <table style="width: 100%;border: 1px solid black;border-collapse: collapse">
        <thead>
        <tr>
            <th class="table-th-width-60" style="border: 1px solid black;padding: 4px;text-align: left;width: 5%;font-weight: bold">SL</th>
            <th class="table-th-width-30" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">Photo</th>
            <th class="table-th-width-30" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">ID</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">Reg. No</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 20%;font-weight: bold">Name</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">Gender</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">Class</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 10%;font-weight: bold">Roll No.</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 15%;font-weight: bold">Contact</th>
        </tr>
        </thead>
        <tbody>
        @forelse($student_list AS $i)
            <tr>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 5%">{{ $loop->index + 1 }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">
                    @if($i->student_info->photo != null)
                        <img height="50px" width="50px" src="{{ asset('uploads/students/'. $i->student_info->photo) }}" alt="" />
                    @else
                        <img height="50px" width="50px" src="{{ asset('photos/user.png') }}" alt="" />
                    @endif
                </td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">{{ $i->student_id }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">{{ $i->reg_no }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 30%">{{ $i->student_info->first_name }} {{ $i->student_info->last_name }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">{{ $i->student_info->gender }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">{{ $i->class_info->name ?? '' }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 10%">{{ $i->roll_no }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 15%">{{ $i->student_info->mobile ?? '' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="border: 1px solid black;padding: 4px;text-align: left;width: 100%">No Records</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</main>
</body>
</html>
