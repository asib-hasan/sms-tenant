@extends('layout.sidebar')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold">Last 100 Activity</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Developer Console</li>
                        <li class="breadcrumb-item active">Activity Log</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap">
                                        <thead>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 95%">User Activity</th>
                                        </thead>
                                        @php
                                            $total = count($activity_list);
                                        @endphp
                                        @foreach ($activity_list as $i)
                                        @php
                                            $user_info =  \App\Models\TeacherModel::where('employee_id',$i->user_id)->select('first_name','last_name')->first();
                                        @endphp
                                        <tr>
                                            <td style="font-size: 13px">{{ $total-($loop->index) }}</td>
                                            <td style="font-size: 13px">
                                                {{ $i->user_id }} <span class="text-maroon font-weight-bold">[{{ $user_info->first_name }} {{ $user_info->last_name }}]</span><br>
                                                {{ $i->activity }}<span class="text-primary font-weight-bold"> [{{ $i->created_at->format('M j, Y g:i A') }}]</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
   $('#developer-console').addClass('menu-open');
   $('#activity-log').addClass('active');
</script>
@endsection
