<div class="row">                        
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('session_id', 'Session') }}
                                {{ Form::select('session_id', $session_name, null, ['class'=>'form-control']) }}
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
                                {{ Form::label('description', 'Description') }}
                                {{ Form::text('description', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('marks', 'Marks') }}
                                {{ Form::text('marks', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('file', 'File') }}
                                {{ Form::file('file', null, ['class'=>'form-control']) }}
                                <!-- <input type="file" name="file"> -->
                              </div>
                          </div>

                          <div class="col-md-12">
                              {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary','type' => 'submit'])}}
                          </div>   
                      </div>