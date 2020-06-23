<div class="row">                        
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('title', 'Title') }}
                                {{ Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter title']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('classroom_id', 'Classroom') }}
                                {{ Form::select('classroom_id', $classroom_name, '', ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-12">
                              {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary','type' => 'submit'])}}
                          </div>   
                      </div>