@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Session</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
@endsection('content_header')

@section('content_body')

    <div class="row">
      <section class="col-md-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card card-primary">
        <div class="card-header">

          <h3 class="card-title">
            <i class="fas mr-1"></i>
            Session
          </h3>

          
          <div class = "row" style = "float:right;">
          @role('admin|teacher')
            <a class="btn btn-warning btn-xs" href="{{route('session.edit',$session->id)}}">
            <span class="material-icons">create</span>
            </a>
          @endrole
          @role('admin')
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['session.destroy', $session->id], 'method' => 'delete']) }}
              <button type="submit" class="btn btn-danger btn-xs">
              <span class="material-icons">delete
              </span>
              </button>
              {{ Form::close() }}
            </div>

          @endrole
            
          </div>

          </div><!-- /.card-header -->

              <div class="card-body">
                <div class="tab-content p-0">
                  
                  <!-- Main card content.. -->

                    <div class="">
                      <div class="container">
                        <div class="form-group">
                            <strong>Class: </strong>
                            <a href = "{{route('section.show', $session->section->id)}}">{{ $session->section->classroom->title." - ".$session->section->title}}</a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Course: </strong>
                            <a href = "{{route('course.show', $session->course->id)}}">{{$session->course->classroom->title." - ".$session->course->title}}</a>
                            
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Teacher: </strong>
                            <a href = "{{route('teacher.show', $session->teacher->id)}}">{{$session->teacher->name}}</a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <div class="row pl-2">
                            <strong class = "mr-2">Assignments </strong>
                            @role('teacher')
                            <a href = "{{route('assignment.create', ['session_id' => $session->id])}}"><span class="material-icons">add_box</span></a>
                            @endrole
                            </div>
                            @foreach($session->assignments as $key => $value)
                              <div class="row pl-2">
                                <a class = "mr-2" href ="{{route('assignment.show', $value->id)}}"> {{$value->title}} </a>
                                <a href="{{route('asgn', array('assignment_id' => $value->id))}}"><span class="material-icons">get_app</span></a>
                              </div>
                            @endforeach
                        </div>
                    </div>

                    @if($session->state === "enable")
                    <div class="row">
                    <div class="col-md-12" >
                        <a class="btn btn-warning " style="padding: 0.5% 47.4%;" href="{{$session->meeting_url}}" >Meeting</a>
                    </div>
                    </div>
                    @endif
                
                  

                  <!-- /.Main card-content.. -->
       
                </div>
              </div><!-- /.card-body -->

        </div>
        <!-- /.card -->
      </section>
    </div>
    

@endsection('content_body')