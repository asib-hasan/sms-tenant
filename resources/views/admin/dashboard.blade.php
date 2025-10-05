 @extends('layout.sidebar')
@section('content')
<style>
    .small-box:hover {
        box-shadow: 0 0 11px rgba(33,33,33,.2);
    }
    html {
        scrollbar-width: none; /* Firefox */
    }

    body {
        -ms-overflow-style: none; /* IE and Edge */
    }

    body::-webkit-scrollbar {
        display: none; /* Chrome, Safari, and Opera */
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/tiny-calendar/css/tiny-calendar.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tiny-calendar/js/tiny-calendar.js"></script>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <span class="blinking font-weight-bold" style="font-family:Arial; font-size: 35px; color: #236633">السلام عليكم</span>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">

    <div class="row">
      @can('dash_student', 76)
      <div class="col-lg-4">
        <div class="small-box bg-white rounded-0">
          <div class="inner">
            <h3>{{ $totalstudent }}</h3>
            <p class="font-weight-bold">STUDENTS</p>
          </div>

          <div class="icon" style="color: rgb(155, 219, 155)">
            <i class="fa fa-users"></i>
          </div>
          <a class="small-box-footer" style="background-color: #7AA2E3"> <i class="fa fa-users"></i></a>
        </div>
      </div>
      @endcan
      @can('dash_teacher', 77)
      <div class="col-lg-4">
        <div class="small-box bg-white rounded-0">
          <div class="inner">
            <h3>{{ $total_employee }}<sup style="font-size: 20px"></sup></h3>
            <p class="font-weight-bold">EMPLOYEES</p>
          </div>
          <div class="icon" style="color: rgb(158, 158, 220)">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <a class="small-box-footer" style="background-color: #7AA2E3"> <i class="fas fa-chalkboard-teacher"></i></a>
        </div>
      </div>
      @endcan
      @can('dash_feesCollection', 78)
      <div class="col-lg-4">
        <div class="small-box bg-white rounded-0">
          <div class="inner">
            <h3>{{ $total_misc_expense }}</h3>
            <p class="font-weight-bold">MISC. EXPENSE <span class="text-sm">(This month)</span></p>
          </div>
          <div class="icon" style="color: #9DB2BF">
            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
          </div>
          <a class="small-box-footer" style="background-color: #7AA2E3"> <i class="fa-solid fa-bangladeshi-taka-sign"></i></a>
        </div>
      </div>
      @endcan
      @can('dash_classWise', 79)
      <div class="col-md-6">
          <div class="card card-body">
                <canvas id="barChartClass" width="100%"></canvas>
          </div>
      </div>
      @endcan
      <div class="col-md-6">
          <div class="card card-body">
               <canvas id="studentPieChart"></canvas>
          </div>
       </div>
      @can('dash_estimated_fee', 91)
      <div class="col-md-6">
          <div class="card card-body">
              <span class="font-weight-bold"><i class="fa-solid fa-bangladeshi-taka-sign text-success"></i> Estimated Fee This Month</span>
                <canvas width="100%" height="50%" id="feesDonutChart"></canvas>
          </div>
      </div>
      @endcan
      @can('dash_attendance_percentage', 90)
      <div class="col-md-6">
          <div class="card card-body">
              <div class="form-group">
                  <label for="formControlRange">Today Present Students</label>
                  <span class="float-right text-success font-weight-bold">10%</span>
                  <input type="range" value="20" class="form-control-range" style="pointer-events: none;" readonly>
              </div>
              <div class="form-group">
                  <label for="formControlRange">Today Present Employees</label>
                  <span class="text-danger float-right font-weight-bold">10%</span>
                  <input type="range" value="20" class="form-control-range" style="pointer-events: none;" readonly>
              </div>
          </div>
      </div>
      @endcan
    </div>
    <script>
      $('#dashboard').addClass('active');
    </script>

    <script>
      @can('dash_classWise', 79)
      //bar
      var ctxB = document.getElementById("barChartClass").getContext('2d');
      var myBarChart = new Chart(ctxB, {
        type: 'bar',
        data: {
          labels: ["Play", "Nursery", "One", "Two", "Three", "Four","Five","Six"],
          datasets: [{
            label: 'Class wise students',
            data: [{{ $Play }}, {{ $Nursery }}, {{ $One }}, {{ $Two }}, {{ $Three }}, {{ $Four }},{{ $Five }},{{ $Six }}],

            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 99, 132, 0.2)',

            ],
            borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 99, 132, 0.2)',
            ],
            borderWidth: 2
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
      @endcan
      const ctx = document.getElementById('studentPieChart').getContext('2d');
        const data = {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Student Count',
                data: [{{ $total_male }}, {{ $total_female }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value} students`;
                            }
                        }
                    }
                }
            }
        };
        const studentPieChart = new Chart(ctx, config);
    </script>
      @can('dash_estimated_fee', 91)
      <script>
          var ctxC = document.getElementById('feesDonutChart').getContext('2d');
          var feesDonutChart = new Chart(ctxC, {
              type: 'doughnut',
              data: {
                  labels: ['Expected Fees', 'Total Collected', 'Due'],
                  datasets: [{
                      label: 'Fees Collection',
                      data: [{{ $expected_fees }}, {{ $collected_fees }}, {{ $total_due }}], // Replace these values with your actual data
                      backgroundColor: ['#FF9F40', '#36A2EB', '#FFCD56'],
                      hoverOffset: 4
                  }]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'top',
                      },
                      tooltip: {
                          callbacks: {
                              label: function(tooltipItem) {
                                  return tooltipItem.raw + ' INR';
                              }
                          }
                      }
                  }
              }
          });
      </script>
      @endcan
      <script>
          $(document).ready(function() {
              setInterval(function() {
                  $('.blinking').fadeOut(1200).fadeIn(1000);
              }, 1000);
          });
      </script>
    @endsection
