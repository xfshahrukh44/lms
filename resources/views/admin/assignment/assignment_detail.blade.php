@extends('admin.layouts.app')

@section('content_header')
@endsection('content_header')

@section('content_body')

    <div class="row">
      <section class="col-md-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card card-primary">
        <div class="card-header">

          <h3 class="card-title">
            <i class="fas mr-1"></i>
            Assignment
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('assignment.edit',$assignment->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['assignment.destroy', $assignment->id], 'method' => 'delete']) }}
              <button type="submit" class="btn btn-danger btn-xs">
              <span class="material-icons">delete
              </span>
              </button>
              {{ Form::close() }}
            </div>
            
          </div>

          </div><!-- /.card-header -->

              <div class="card-body">
                <div class="tab-content p-0">
                  
                  <!-- Main card content.. -->

                    <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Title</span>
                          <span class="info-box-number">{{ $assignment->title}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Session</span>
                          <span class="info-box-number"><a href ="{{route('session.show', $assignment->session->id)}}"> {{$assignment->session->course->title." - ".$assignment->session->course->classroom->title." - ".$assignment->session->section->title}} </a></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Description</span>
                          <span class="info-box-number">{{$assignment->description}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Marks</span>
                          <span class="info-box-number">{{$assignment->marks}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Download file</span>
                          <span class="info-box-number"><a href="{{route('asgn', ['assignment_id' => $assignment->id])}}"><span class="material-icons">get_app</span></a></span>
                        </div>
                      </div>
                    </div>
                    @role('admin|teacher')
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">View Submissions</span>
                          <span class="info-box-number"><a href="{{route('submission.index', ['assignment_id' => $assignment->id])}}"><span class="material-icons">open_in_new</span></a></span>
                        </div>
                      </div>
                    </div>
                    @endrole
                    @role('admin|student')
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Submit your assignment</span>
                          <span class="info-box-number"><a href="{{route('submission.create', ['assignment_id' => $assignment->id])}}"><span class="material-icons">open_in_new</span></a></span>
                        </div>
                      </div>
                    </div>
                    @endrole

                    </div>
                
                  

                  <!-- /.Main card-content.. -->
       
                </div>
              </div><!-- /.card-body -->

        </div>
        <!-- /.card -->
      </section>
    </div>
    

@endsection('content_body')