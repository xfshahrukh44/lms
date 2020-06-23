@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Student</h1>
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
            Student
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('student.edit',$student->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['student.destroy', $student->id], 'method' => 'delete']) }}
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
                            <strong>Name: </strong>
                            {{ $student->name}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>OF: </strong>
                            <a href ="{{route('section.show', $student->section->id)}}"> {{$of}} </a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Contact: </strong>
                            {{$student->contact}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Address: </strong>
                            {{$student->address}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Account: </strong>
                            <a href = "{{route('user.show', $student->user_id)}}">{{$student->user->email}}</a>
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