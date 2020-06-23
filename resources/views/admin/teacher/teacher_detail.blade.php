@extends('admin.layouts.app')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
          <h1 class="m-0 text-dark">Teacher</h1>
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
            Teacher
          </h3>

          <div class = "row" style = "float:right;">

            <a class="btn btn-warning btn-xs" href="{{route('teacher.edit',$teacher->id)}}">
            <span class="material-icons">create</span>
            </a>
            
            <div class = "ml-1" style="float: right;">
              {{ Form::open(['route' => ['teacher.destroy', $teacher->id], 'method' => 'delete']) }}
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
                            {{ $teacher->name}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Contact: </strong>
                            {{$teacher->contact}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Address: </strong>
                            {{$teacher->address}}
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Account: </strong>
                            <a href = "{{route('user.show', $teacher->user_id)}}">{{$teacher->user->email}}</a>
                        </div>
                    </div>
                    <div class="container">
                        <div class="form-group">
                            <strong>Sessions: </strong>
                            @foreach($sessions as $session)
                              <br>
                              <a href = "{{route('session.show', $teacher->sessions[0]->id)}}">{{$session}}</a>
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