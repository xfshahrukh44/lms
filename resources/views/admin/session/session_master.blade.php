                      <div class="row">  
                      @role('admin')            
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('section_id', 'Section') }}
                                {{ Form::select('section_id', $section_name, null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('course_id', 'Course') }}
                                {{ Form::select('course_id', $course_name, null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('teacher_id', 'Teacher') }}
                                {{ Form::select('teacher_id', $teacher_name, null, ['class'=>'form-control']) }}
                              </div>
                          </div>
                          @endrole

                          @role('admin|teacher')
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('meeting_url', 'Meeting url') }}
                                {{ Form::text('meeting_url', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('state', 'state') }}
                                {{ Form::select('state', ['enable' => 'enable', 'disable' => 'disable'], null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-12">
                              {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary','type' => 'submit'])}}
                          </div>   
                          @endrole
                      </div>