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
            Classroom
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('classroom.edit',$classroom->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['classroom.destroy', $classroom->id], 'method' => 'delete']) }}
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
                          <span class="info-box-number">{{ $classroom->title}}</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">School</span>
                          <span class="info-box-number"><a href ="{{route('school.show', $classroom->school->id)}}"> {{$classroom->school->title}} </a></span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Courses</span>
                          <span class="info-box-number">
                          @foreach($classroom->courses as $key => $value)
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
                          <span class="info-box-text">Sections</span>
                          <span class="info-box-number">
                          @foreach($classroom->sections as $key => $value)
                            <a href ="{{route('section.show', $value->id)}}"> {{$value->title}} </a>
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