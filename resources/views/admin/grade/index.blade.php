@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Grade</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Academic Settings</li>
                            <li class="breadcrumb-item active">Grade</li>
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
                        <input class="form-control print-none rounded-0" type="text" id="searchInput" placeholder="Type anything to search">
                        <div class="table-responsive-lg table-bordered p-2">
                            <table class="table table-hover text-nowrap" id="dataTable">
                                <thead style="background-color: #EAEAEA">
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th style="width: 20%">Start Range</th>
                                        <th style="width: 20%">End Range</th>
                                        <th style="width: 20%">Point</th>
                                        <th style="width: 30%">Letter Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grade_list as $i)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $i->start_range }}</td>
                                            <td>{{ $i->end_range }}</td>
                                            <td>{{ number_format($i->point, 2) }}</td>
                                            <td>{{ $i->letter_grade }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
         $('#academic-settings').addClass('menu-open');
         $("#grade").addClass('active');
    </script>
    <script>
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterTable(searchTerm);
        });

        function filterTable(searchTerm) {
            $('#dataTable tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
