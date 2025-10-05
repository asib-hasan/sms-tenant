@extends('layout.sidebar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Accounts</li>
              <li class="breadcrumb-item active">Add Miscellaneous Cost</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
            @include('components.alert')
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Add Miscellaneous Cost</h3>
                </div>
                <form method="post" action="{{route('genacc/miscellaneous/cost/store')}}" enctype="multipart/form-data">
                 @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="ac_head">Select Head</label>
                      <select id="fees-head" class="form-control select2" name="ac_head_id" style="width: 100%" required>
                        <option value="">Select</option>
                        @foreach ($ac_head_list as $i)
                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                        @endforeach
                      </select>
                    </div>

                  <div class="form-group">
                      <label for="Name">Amount</label>
                      <input type="text" class="form-control" name="amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                   </div>

                  <div class="form-group">
                    <label for="Name">Receipt No.(If available)</label>
                    <input type="text" class="form-control" id="name" name="receipt_no">
                  </div>

                  <div class="form-group">
                    <label for="Name">Date</label>
                    <input type="date" id="today" value="" class="form-control"  name="date" required>
                  </div>

                  <div class="form-group">
                    <label for="Name">Note</label>
                    <input type="text" class="form-control" id="name" name="note">
                  </div>
                <button type="submit" class="btn btn-primary btn-custom">SUBMIT</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
    <script>
      $('#general-accounts').addClass('menu-open');
      $('#misc-cost').addClass('active');
    </script>
    <script>
      var today = new Date();
      var formattedDate = today.toISOString().substr(0, 10);
      document.getElementById("today").value = formattedDate;
  </script>
@endsection

