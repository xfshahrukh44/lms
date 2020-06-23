@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Section</h1>
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
            Section
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('section.edit',$section->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['section.destroy', $section->id], 'method' => 'delete']) }}
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
                            {{ $section->title}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Class: </strong>
                            <a href ="{{route('classroom.show', $section->classroom->id)}}"> {{$section->classroom->title}} </a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Courses: </strong>
                            @foreach($courses as $key => $value)
                              <br>
                              <a href ="{{route('course.show', $value->id)}}"> {{$value->title}} </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Students: </strong>
                            @foreach($section->students as $key => $value)
                              <br>
                              <a href ="{{route('student.show', $value->id)}}"> {{$value->name}} </a>
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