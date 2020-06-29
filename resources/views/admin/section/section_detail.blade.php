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

                    <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Title</span>
                          <span class="info-box-number">{{ $section->title}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Class</span>
                          <span class="info-box-number"><a href ="{{route('classroom.show', $section->classroom->id)}}"> {{$section->classroom->title}} </a></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Courses</span>
                          <span class="info-box-number">
                            @foreach($courses as $key => $value)
                              <a href ="{{route('course.show', $value->id)}}"> {{$value->title}} </a>
                              <br>
                            @endforeach
                        </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Students</span>
                          <span class="info-box-number">
                            @foreach($section->students as $key => $value)
                              <a href ="{{route('student.show', $value->id)}}"> {{$value->name}} </a>
                              <br>
                            @endforeach
                          </span>
                        </div>
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