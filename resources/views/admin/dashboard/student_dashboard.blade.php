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
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3> New </h3>

                <p>Assignments</p>
                </div>
                <div class="icon">
                <i class="material-icons">hourglass_top</i>
                </div>
                <a href="{{route('assignment.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3> Your </h3>

                <p>Submissions</p>
                </div>
                <div class="icon">
                <i class="material-icons">done_all</i>
                </div>
                <a href="{{route('submission.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$live_class_count}}</h3>

                <p>Live Classes</p>
            </div>
            <div class="icon">
                <i class="material-icons">live_tv</i>
            </div>
            <a href="{{route('session.index')}}" class="small-box-footer">Manage Sessions <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3>{{$work_hours}}<sup style="font-size: 20px"></sup></h3>

                <p>Time spent this month</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('attendance.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Student</h3>

                <p>Portal</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('portal')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    

@endsection('content_body')