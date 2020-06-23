@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Submission</h1>
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
            Submission
          </h3>

          <div class = "row" style = "float:right;">

            @role('admin|teacher')
            <a class="btn btn-warning btn-xs" href="{{route('submission.edit',$submission->id)}}">
            <span class="material-icons">create</span>
            </a>
            @endrole
            @role('admin')
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['submission.destroy', $submission->id], 'method' => 'delete']) }}
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
                            <strong>Assignment Title: </strong>
                            {{ $submission->assignment->title}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Student: </strong>
                            {{ $submission->student->name}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Title: </strong>
                            {{ $submission->title}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Marks: </strong>
                            {{ $submission->marks}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group row pl-2">
                            <strong class="pr-2">Download file: </strong>
                            <a href="{{route('submit', ['submission_id' => $submission->id])}}"><span class="material-icons">get_app</span></a>
                        </div>
                    </div>

                    </div>
                
                  

                  <!-- /.Main card-content.. -->
       
                </div>
              </div><!-- /.card-body -->

        </div>
        <!-- /.card -->
      </section>
    </div>
    

@endsection('content_body')