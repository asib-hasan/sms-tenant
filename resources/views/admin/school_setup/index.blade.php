@extends('layout.sidebar')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold">School Setup</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">System Settings</li>
                            <li class="breadcrumb-item active">School Setup</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 ml-0">
                            @include('components.alert')
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('sst/school/setup/update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Name <span class="text-red">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{ $school_info->name }}" required>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Short Name <span class="text-red">*</span></label>
                                                <input type="text" name="short_name" class="form-control" value="{{ $school_info->short_name }}" required>
                                            </div>
                                            <div class="col-md-12 form-group mb-3">
                                                <label class="form-label">Address <span class="text-red">*</span></label>
                                                <input type="text" name="address" class="form-control" value="{{ $school_info->address }}" required>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Phone <span class="text-red">*</span></label>
                                                <input type="text" name="phone" class="form-control" value="{{ $school_info->phone }}" required>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $school_info->email }}">
                                            </div>
                                            <div class="col-md-12 form-group mb-3">
                                                <label class="form-label">Website</label>
                                                <input type="route" name="website" class="form-control" value="{{ $school_info->website }}">
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Logo (White BG) <span class="text-red">*</span></label>
                                                <input type="file" name="logo_circle" class="form-control" accept="image/*" onchange="previewImage(event, 'circlePreview')">

                                                @if($school_info->logo_circle)
                                                    <div class="mt-2">
                                                        <img id="circlePreview" src="{{ asset($school_info->logo_circle) }}" alt="Logo Circle" class="img-thumbnail" style="height:100px;">
                                                    </div>
                                                @else
                                                    <div class="mt-2">
                                                        <img id="circlePreview" class="img-thumbnail d-none" style="height:100px;">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-6 form-group mb-3">
                                                <label class="form-label">Logo (Transparent) <span class="text-red">*</span></label>
                                                <input type="file" name="logo_transparent" class="form-control" accept="image/*" onchange="previewImage(event, 'transparentPreview')">

                                                @if($school_info->logo_transparent)
                                                    <div class="mt-2">
                                                        <img id="transparentPreview" src="{{ asset($school_info->logo_transparent) }}" alt="Logo Transparent" class="img-thumbnail" style="height:100px;">
                                                    </div>
                                                @else
                                                    <div class="mt-2">
                                                        <img id="transparentPreview" class="img-thumbnail d-none" style="height:100px;">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-12 text-end mt-3">
                                                <button type="submit" class="btn btn-success btn-custom">Save</button>
                                            </div>
                                        </div>
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
        $('#developer-console').addClass('menu-open');
        $('#school-setup').addClass('active');
    </script>
    <script>
        function previewImage(event, previewId) {
            let reader = new FileReader();
            reader.onload = function(){
                let output = document.getElementById(previewId);
                output.src = reader.result;
                output.classList.remove("d-none");
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

@endsection
