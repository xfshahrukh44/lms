@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Assignment</h1>
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

                    <div class="">
                      <div class="container">
                        <div class="form-group">
                            <strong>Title: </strong>
                            {{ $assignment->title}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Session: </strong>
                            <a href ="{{route('session.show', $assignment->session->id)}}"> {{$assignment->session->course->title." - ".$assignment->session->course->classroom->title." - ".$assignment->session->section->title}} </a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Description: </strong>
                            {{$assignment->description}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Marks: </strong>
                            {{$assignment->marks}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group row pl-2">
                            <strong class="pr-2">Download file: </strong>
                            <a href="{{route('asgn', ['assignment_id' => $assignment->id])}}"><span class="material-icons">get_app</span></a>
                        </div>
                    </div>
                    @role('admin|teacher')
                    <div class="container">
                        <div class="form-group row pl-2">
                            <strong class="pr-2">View Submissions: </strong>
                            <a href="{{route('submission.index', ['assignment_id' => $assignment->id])}}"><span class="material-icons">open_in_new</span></a>
                        </div>
                    </div>
                    @endrole
                    @role('admin|student')
                    <div class="container">
                        <div class="form-group row pl-2">
                            <strong class="pr-2">Submit your assignment: </strong>
                            <a href="{{route('submission.create', ['assignment_id' => $assignment->id])}}"><span class="material-icons">open_in_new</span></a>
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