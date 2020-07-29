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

                    <div class="row">

                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Name</span>
                          <img src="{{asset('storage/'.$teacher->image)}}"/>
                          {{asset('storage/'.$teacher->image)}}
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Name</span>
                          <span class="info-box-number">{{ $teacher->name}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Contact</span>
                          <span class="info-box-number">{{$teacher->contact}}</span>
                        </div>
                      </div>
                    </div> 
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Address</span>
                          <span class="info-box-number">{{$teacher->address}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Account</span>
                          <span class="info-box-number"><a href = "{{route('user.show', $teacher->user_id)}}">{{$teacher->user->email}}</a></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box" style = "text-align: center;">
                        <div class="info-box-content">
                          <span class="info-box-text">Sessions</span>
                          <span class="info-box-number">
                            @foreach($sessions as $session)
                              <a href = "{{route('session.show', $teacher->sessions[0]->id)}}">{{$session}}</a>
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