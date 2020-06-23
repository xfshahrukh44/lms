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
                  View Submission
                </h3>

                <a class="btn btn-xs" style="float: right;" href="{{route('submission.create')}}">
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
                          <th>Assignment</th>
                          <th>Student</th>
                          <th>Marks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;?>
                          @foreach($submission as $key => $value)
                          <tr style = "text-align: center">
                            <td >{{$no++}}</td>
                            <td >{{$value->assignment->title}}</td>
                            <td >{{$value->student->name}}</td>
                            <td >{{$value->marks}}</td>
                            <td>
                              <div style="display: inline-block;">

                                <a class="btn btn-info btn-xs" href="{{route('submission.show',$value->id)}}">
                                <span class="material-icons">remove_red_eye</span>
                                </a>
                                @role('teacher|admin')
                                <a class="btn btn-warning btn-xs" href="{{route('submission.edit',$value->id)}}">
                                <span class="material-icons">create</span>
                                </a>
                                @endrole
                                @role('admin')
                                <div class = "ml-1" style="float: right;">
                                  {{ Form::open(['route' => ['submission.destroy', $value->id], 'method' => 'delete']) }}
                                  <button type="submit" class="btn btn-danger btn-xs">
                                  <span class="material-icons">delete
                                  </span>
                                  </button>
                                  {{ Form::close() }}
                                </div>
                                @endrole

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