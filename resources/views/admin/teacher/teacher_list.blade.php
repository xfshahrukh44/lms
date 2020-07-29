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
                  View Teacher
                </h3>

                <a class="btn btn-xs" style="float: right;" href="{{route('teacher.create')}}">
                  <span class="material-icons">add_box</span>
                </a>
                
              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="tab-content p-0">
                  
                  <!-- Main card content.. -->

                    <div class="container col-md-12">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr style = "text-align: center">
                          <th>#</th>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>Address</th>
                          <th>Account</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;?>
                          @foreach($teacher as $key => $value)
                          <tr style = "text-align: center">
                            <td >{{$no++}}</td>
                            <td >{{$value->name}}</td>
                            <td >{{$value->contact}}</td>
                            <td >{{$value->address}}</td>
                            <td >{{$value->user->name}}</td>
                            <td>
                              <div style="display: inline-block;">

                                <a class="btn btn-info btn-xs" href="{{route('teacher.show',$value->id)}}">
                                <span class="material-icons">remove_red_eye</span>
                                </a>

                                <a class="btn btn-warning btn-xs" href="{{route('teacher.edit',$value->id)}}">
                                <span class="material-icons">create</span>
                                </a>
                                <div class = "ml-1" style="float: right;">
                                  {{ Form::open(['route' => ['teacher.destroy', $value->id], 'method' => 'delete']) }}
                                  <button type="submit" class="btn btn-danger btn-xs">
                                  <span class="material-icons">delete
                                  </span>
                                  </button>
                                  {{ Form::close() }}
                                </div>

                              </div>
                            </td>
                          </tr>
                          @endforeach 
                      </tbody>
                    </table>
                  </div>

                  <!-- /.Main card-content.. -->
       
                </div>
              </div><!-- /.card-body -->

        </div>
        <!-- /.card -->
      </section>
    </div>
    @foreach($teacher as $key => $value)
    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
      <div class="card bg-light">
        <div class="card-header text-muted border-bottom-0">
          Digital Strategist
        </div>
        <div class="card-body pt-0">
          <div class="row">
            <div class="col-7">
              <h2 class="lead"><b>{{$value->name}}</b></h2>
              <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
              <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
              </ul>
            </div>
            <div class="col-5 text-center">
              <img src="{{asset('storage/'.$value->image)}}" alt="" class="img-circle img-fluid">
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="text-right">
            <a href="#" class="btn btn-sm bg-teal">
              <i class="fas fa-comments"></i>
            </a>
            <a href="#" class="btn btn-sm btn-primary">
              <i class="fas fa-user"></i> View Profile
            </a>
          </div>
        </div>
      </div>
    </div>
    @endforeach

  
    

@endsection('content_body')