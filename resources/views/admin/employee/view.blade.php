@extends('layout.sidebar')
@section('content')
<style>

    .profile-img img {
        width: 150px;
        height: 150px;
        border-radius: 10px;
    }

    .proile-rating span {
        color: #495057;
        font-size: 15px;
        font-weight: 600;
    }



    .profile-head .nav-tabs .nav-link {
        font-weight: 600;
        border: none;

    }

    .profile-head .nav-tabs .nav-link.active {
        border: none;
        border-bottom: 2px solid #0062cc;
    }

    .profile-tab label {
        font-weight: 600;
    }

</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold mr-2">Employee Profile</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Employee Management</li>
                        <li class="breadcrumb-item active">Employee Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="col-md-9">
        <div class="card">
            <div class="emp-profile ml-3 mb-3 p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img text-center">
                            @if ($employee_info->image=="")
                            <img class="img-bordered" src="{{ asset('photos/user.png')}}" alt="" />
                            @else
                            <img class="img-bordered" src="{{ asset('uploads/teachers/'. $employee_info->image) }}" alt="" />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                            <h4 class="font-weight-bold">{{ $employee_info->first_name }} {{ $employee_info->last_name }}</h4>
                            @if($employee_info->status == 0)
                                <span class="badge bg-success">Active</span>
                            @elseif($employee_info->status == 1)
                                <span class="badge bg-warning">Inactive</span>
                            @else
                                <span class="badge bg-cyan">Resigned</span>
                            @endif
                            <p class="proile-rating">Employee ID : <span>{{ $employee_info->employee_id }}</span></p>
                            <ul class="nav nav-tabs show" id="myTab" role="tablist" >
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">Personal Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                        aria-controls="contact" aria-selected="false">Contact Information</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Designation</th>
                                            <td>{{ $employee_info->designation_info->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Joining Date</th>
                                            <td>{{ $employee_info->joiningdate }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Type</th>
                                            <td colspan="2">
                                                {{
                                                    ($employee_info->type == 3) ? 'Academic & Administrative' :
                                                    (($employee_info->type == 2) ? 'Others' :
                                                    (($employee_info->type == 0) ? 'Academic' : 'Administrative'))
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Gender</th>
                                            <td>{{ $employee_info->gender }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">National ID</th>
                                            <td colspan="2">{{ $employee_info->national_id }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <table class="table table-bordered">
                                    <style>
                                        .table tr td {
                                            width: 50%;
                                        }
                                        .table td{
                                            font-weight: bold;
                                            color: #0062cc;
                                        }
                                    </style>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td colspan="2">{{ $employee_info->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td colspan="2">{{ $employee_info->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td colspan="2">{{ $employee_info->address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#employee-management').addClass('menu-open');
    $('#employee-list').addClass('active');
</script>
@endsection
