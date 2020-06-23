<div class="row">           
                          @role('admin|student')             
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('assignment_id', 'Assignment') }}
                                {{ Form::select('assignment_id', $assignment_name, null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('student_id', 'Student') }}
                                {{ Form::select('student_id', $student_name, null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('title', 'Title') }}
                                {{ Form::text('title', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('file', 'File') }}
                                {{ Form::file('file', null, ['class'=>'form-control']) }}
                                <!-- <input type="file" name="file"> -->
                              </div>
                          </div>
                          @endrole
                          @role('admin|teacher')
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('marks', 'Marks') }}
                                {{ Form::text('marks', null, ['class'=>'form-control']) }}
                              </div>
                          </div>
                          @endrole

                          <div class="col-md-12">
                              {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary swalDefaultSuccess','type' => 'submit'])}}
                          </div>   
                      </div>