@extends('admin.layouts.app')
@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
@endsection('content_header')


@section('content_body')

    <div class = "row">
            <!-- start -->
        <div class="col-md-2 col-sm-6">
        <a href="{{route('classroom.index')}}">
                <div class="info-box ">
                <span class="info-box-icon"style="background-color: white;" ><i class="material-icons">cast_for_education</i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Classes</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </a>
        </div>

    <!-- end -->

    <!-- start -->
        <div class="col-md-2 col-sm-6">
        <a href="{{route('section.index')}}">
                <div class="info-box ">
                <span class="info-box-icon"style="background-color: white;" ><i class="material-icons">sort_by_alpha</i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sections</span>

                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </a>
        </div>

    <!-- end -->

    <!-- start -->
        <div class="col-md-2 col-sm-6">
        <a href="{{route('role.index')}}">
                <div class="info-box ">
                <span class="info-box-icon"style="background-color: white;" ><i class="material-icons">account_tree</i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Roles</span>

                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </a>
        </div>

    <!-- end -->

    <!-- start -->
        <div class="col-md-2 col-sm-6">
        <a href="{{route('course.index')}}">
                <div class="info-box ">
                <span class="info-box-icon"style="background-color: white;" ><i class="material-icons">menu_book</i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Courses</span>

                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </a>
        </div>

    <!-- end -->

    <!-- start -->
        <div class="col-md-2 col-sm-6 col-12">
        <a href="{{route('user.index')}}">
                <div class="info-box ">
                <span class="info-box-icon"style="background-color: white;" ><i class="material-icons">alternate_email</i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Accounts</span>

                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </a>
        </div>

    <!-- end -->

    <div class="col-lg-2 col-6" style = "text-align: center;">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3 id = "time"><sup style="font-size: 20px"></sup></h3>

                <p><strong>Time spent this month</strong></p>
                </div>
                <div class="icon">
                <i class="material-icons">watch_later</i>
                </div>
                <a href="{{route('attendance.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
    <!-- chartwork -->
    <div class="col-md-6 col-sm-6 col-12 chart" id="chart">
        <p> chart </p>
        <canvas id="myChart"></canvas>
    </div>


    <!-- <div class="card-header">
        <h3 class="card-title">Line Chart</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
        </div>
        <div class="card-body">
        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 657px;" width="525" height="200" class="chartjs-render-monitor"></canvas>
        </div>
    </div> -->
            
    <!-- end cahrtwork -->
    

@endsection('content_body')


<!-- chart scripts -->



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"></script>
<script>
    $(document).ready(function(){
        var work_hours = "'<?php echo $wh;?>'";
        var check = "<?php echo $check;?>";
        var days = parseInt("<?php echo $total_days;?>");
        var h = parseInt(work_hours.substring(1, 3));
        if(days > 0){
            for(var i = 0; i<days; i++){
                h+=24;
            }
        }
        if(check == 'out'){
            if(h < 10){
                document.getElementById("time").innerHTML = "0"+h+work_hours.substring(3,9);
            }
            else if(h >=10){
                document.getElementById("time").innerHTML = h+work_hours.substring(3,9);
            }
            
        }
    });
</script>

<script>
    var work_hours = "'<?php echo $wh;?>'";
    var check = "<?php echo $check;?>";
    var days = parseInt("<?php echo $total_days;?>");
    var h = parseInt(work_hours.substring(1, 3));
    var m = parseInt(work_hours.substring(4, 6));
    var s = parseInt(work_hours.substring(7, 9));
    if(days > 0){
        for(var i = 0; i<days; i++){
            h+=24;
        }
    }
    if(check == 'in'){
    var x = setInterval(function(){
        if(s < 9){
            s++;
            if(m < 10){
                if(h < 10){
                    var time = "0"+h+":0"+m+":0"+s;
                }
                else if(h >= 10 ){
                    var time = h+":0"+m+":0"+s;
                }
            }
            else if(m >= 10){
                if(h < 9){
                    var time = "0"+h+":"+m+":0"+s;
                }
                else if(h >= 9 ){
                    var time = h+":"+m+":0"+s;
                }
            }
        }
        else if(s >= 9 && s < 59){
            s++;
            if(m < 10){
                if(h < 10){
                    var time = "0"+h+":0"+m+":"+s;
                }
                else if(h >= 10 ){
                    var time = h+":0"+m+":"+s;
                }
            }
            else if(m >= 10){
                if(h < 10){
                    var time = "0"+h+":"+m+":"+s;
                }
                else if(h >= 10 ){
                    var time = h+":"+m+":"+s;
                }
            }
        }
        else if(s >= 59){
            s = 0;
            if(m < 9){
                m++;
                if(h < 10){
                    var time = "0"+h+":0"+m+":0"+s;
                }
                else if(h >= 10 ){
                    var time = h+":0"+m+":0"+s;
                }
            }
            else if(m >= 9 && m < 59){
                m++;
                if(h < 10){
                    var time = "0"+h+":"+m+":0"+s;
                }
                else if(h >= 10 ){
                    var time = h+":"+m+":0"+s;
                }
            }
            else if(m >= 59){
                m = 0;
                if(h < 9){
                    h++;
                    var time = "0"+h+":0"+m+":0"+s;
                }
                else if(h >= 9 ){
                    h++;
                    var time = h+":0"+m+":0"+s;
                }
            }
            
        }
        document.getElementById("time").innerHTML = time;

        },1000);
    }
    $(document).on('click','#check-out',function(){
        clearInterval(x);
    });
</script>

<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
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
</script>
