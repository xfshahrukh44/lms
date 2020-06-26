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
        <div class="col-lg-6 col-6" style = "text-align: center;">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3> Your </h3>

                <p> <strong>Assignments</strong></p>
                </div>
                <div class="icon">
                <i class="material-icons">assignment</i>
                </div>
                <a href="{{route('assignment.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-6" style = "text-align: center;">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3> {{$unmarked_submissions_count}} </h3>

                <p><strong>Unmarked submission/s</strong></p>
                </div>
                <div class="icon">
                <i class="material-icons">receipt_long</i>
                </div>
                <a href="{{route('teachersubmissions')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-6" style = "text-align: center;">
            <!-- small box -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$live_class_count}}</h3>

                <p><strong>Live Classes</strong></p>
            </div>
            <div class="icon">
                <i class="material-icons">laptop_chromebook</i>
            </div>
            <a href="{{route('session.index')}}" class="small-box-footer">Manage your sessions <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-6" style = "text-align: center;">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3 id = "time"><sup style="font-size: 20px"></sup></h3>

                <p><strong>Time spent this month</strong></p>
                </div>
                <div class="icon">
                <i class="material-icons">watch_later</i>
                </div>
                <a href="{{route('attendance.index')}}" class="small-box-footer">Attendance log <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    

@endsection('content_body')

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>

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