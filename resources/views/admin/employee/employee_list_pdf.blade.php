<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Employee List</title>
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
                <span style="font-size: 12px">Employee List</span><br>
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
            <th class="table-th-width-30" style="border: 1px solid black;padding: 4px;text-align: left;width: 6%;font-weight: bold">ID</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 30%;font-weight: bold">Name</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 20%;font-weight: bold">Designation</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 24%;font-weight: bold">Email</th>
            <th class="table-th-width-10" style="border: 1px solid black;padding: 4px;text-align: left;width: 15%;font-weight: bold">Contact</th>
        </tr>
        </thead>
        <tbody>
        @forelse($employee_list AS $i)
            <tr>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 5%">{{ $loop->index + 1 }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 6%">{{ $i->employee_id }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 30%">{{ $i->first_name }} {{ $i->last_name }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 20%">{{ $i->designation_info->name ?? '' }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 24%">{{ $i->email }}</td>
                <td style="border: 1px solid black;padding: 4px;text-align: left;width: 15%">{{ $i->phone }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="border: 1px solid black;padding: 4px;text-align: left;width: 100%">No Records</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</main>
</body>
</html>
