@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">School</h1>
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
            School
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('school.edit',$school->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['school.destroy', $school->id], 'method' => 'delete']) }}
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
                            {{ $school->title}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Location: </strong>
                            {{ $school->location}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Program: </strong>
                            <a href = "{{route('program.show', $school->program->id)}}">{{ $school->program->title}}</a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Classes: </strong>
                            @foreach($school->classrooms as $key => $value)
                              <br>
                              <a href ="{{route('classroom.show', $value->id)}}"> {{$value->title}} </a>
                            @endforeach
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