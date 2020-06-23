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
    

@endsection('content_body')