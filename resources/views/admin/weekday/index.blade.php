@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Week Days</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">HR Management</li>
                            <li class="breadcrumb-item active">Week Days</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card">
                        <div class="card-body table-responsive p-2">
                            <form action="{{ route('hrmgt/week/days/update') }}" method="POST">
                                @csrf
                                <table class="table no-border font-weight-bold">
                                    <thead>
                                    <tr class="border bg-secondary">
                                        <th style="width: 20%">Day</th>
                                        <th style="width: 80%;">Off/On</th>
                                    </tr>
                                    </thead>
                                    <tbody class="border">
                                    @foreach($weekdays_list as $i)
                                        <tr>
                                            <td>{{ $i->name }}</td>
                                            <td>
                                                <input type="checkbox" name="{{ $i->name }}" @checked($i->is_active == 0) data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-primary btn-custom mt-3">UPDATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $('#hr-management').addClass('menu-open');
        $("#weekdays").addClass('active');
    </script>
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>
@endsection
