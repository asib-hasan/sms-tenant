@extends('layout.sidebar')
@section('content')
    <style>
        .selected {
            border: 5px solid rgb(255, 200, 0) !important;
        }

        .card:hover {
            cursor: pointer;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">Select ID Card</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Global Settings</li>
                            <li class="breadcrumb-item active">ID Card Selection</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-sm-6">
                    @include('components.alert')
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('select-id-card/employee') }}">Employee</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane fade show active">
                                <div class="container mt-5">
                                    <form action="{{ route('select-id-card/student/update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 mb-4">
                                                <div class="card card_1 @if($value==1) selected  @endif" onclick="selectImage('card_1')">
                                                    <img style="border:2px solid black" src="{{ asset('id_card_sample/s1.png') }}" alt="img" class="card-img">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <div class="card card_2 @if($value==2) selected  @endif" onclick="selectImage('card_2')">
                                                    <img style="border:2px solid black" src="{{ asset('id_card_sample/s2.png') }}" alt="Front Part of ID Card" class="card-img">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <div class="card card_3 @if($value==3) selected  @endif" onclick="selectImage('card_3')">
                                                    <img style="border:2px solid black" src="{{ asset('id_card_sample/s3.png') }}" alt="Front Part of ID Card" class="card-img">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="selected_image" id="selected_image">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function selectImage(imageId) {
            var selectedCard = $('.' + imageId);
            if (imageId == 'card_1') {
                selectedCard.addClass('selected');
                $('.card_2').removeClass('selected');
                $('.card_3').removeClass('selected');
            } else if (imageId == 'card_2') {
                selectedCard.addClass('selected');
                $('.card_1').removeClass('selected');
                $('.card_3').removeClass('selected');
            } else {
                selectedCard.addClass('selected');
                $('.card_1').removeClass('selected');
                $('.card_2').removeClass('selected');
            }
            $('#selected_image').val(imageId);
        }
    </script>
    <script>
        $('#global-settings').addClass('menu-open');
        $('#select-id-card').addClass('active');
    </script>
@endsection
