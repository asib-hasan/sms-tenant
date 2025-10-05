@extends('layout.sidebar')
@section('content')
    <style>
        @import route('https://fonts.googleapis.com/css?family=Quicksand&display=swap');
        .alert {
            width: 50%;
            margin: 20px auto;
            padding: 30px;
            position: relative;
            border-radius: 5px;
            box-shadow: 0 0 15px 5px #ccc;
            background-color:  #1ad669;
        }

        .close {
            position: absolute;
            width: 30px;
            height: 30px;
            opacity: 0.5;
            border-width: 1px;
            border-style: solid;
            border-radius: 50%;
            right: 15px;
            top: 25px;
            text-align: center;
            font-size: 1.6em;
            cursor: pointer;
        }
        .success-font{
            font-family:Quicksand;
            font-weight: bold;
        }

        @mixin alert($name, $bgColor) {
            $accentColor: darken($bgColor, 50);

            .#{$name} {
                background-color:#{$bgColor};
                border-left: 5px solid $accentColor;

                .close {
                    border-color: $accentColor;
                    color: $accentColor;
                }
            }
        }



    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Fee Structure</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Accounts Management</li>
                            <li class="breadcrumb-item active">Generate Student Fee</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                        <div class="alert success-alert">
                            <h4 class="success-font">{{ Session::get('success') }}</h4>
                            <a class="close">&times;</a>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="col-sm-12">
                                <a href="{{ route('admin/student_fee/add') }}">
                                    <i class="fa fa-plus-square" style="font-size:30px;color:#4D2C78"></i>                                </a>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card">

                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="ac_head_name"
                                                value="{{ Request::get('ac_head_name') }}" placeholder="Enter name">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Class</label>
                                            <input type="text" class="form-control" name="class_name"
                                                 placeholder="Class Name">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <button class="btn btn-primary" type="submit"
                                                style="margin-top:30px;">Search</button>
                                            <a href="{{ route('admin/student_fee/list') }}" class="btn btn-success"
                                                style="margin-top: 30px;">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <style>
                            td,
                            th {
                                border: 1px solid #ddd;
                                text-align: center;
                            }
                        </style>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Month</th>
                                        <th>Status</th>
                                        <th>Class</th>
                                        <th>Amount</th>
                                        <th>Waiver(%)</th>
                                        <th>New Amount</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getRecord as $i)
                                        <tr>
                                            <td>{{ $i->ac_head_name }}</td>
                                            <td>{{ $i->session }}</td>
                                            <td>{{ $i->month }}</td>
                                            <td>
                                                @if ($i->status == 0)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $i->class_name }}</td>
                                            <td>{{ $i->amount }}</td>
                                            <td>{{ $i->waiver }}</td>
                                            <td>{{ $i->amount_after_waiver }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>
                                                <a href="{{ route('admin/student_fee/edit/' . $i->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a
                                                    href="{{ route('admin/student_fee/delete/' . $i->id) }}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (empty(Request::get('name')))
                                <div style="padding: 10px;float: right">
                                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
    </div>
    </section>
    </div>
    <script>
        $(".close").click(function() {
            $(this)
                .parent(".alert")
                .fadeOut();
        });
    </script>
@endsection
