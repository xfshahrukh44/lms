<div class="row">                        
                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('user_id', 'Related user') }}
                                {{ Form::select('user_id', $user_name, '', ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('section_id', 'Section') }}
                                {{ Form::select('section_id', $section_name, '', ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('contact', 'Contact') }}
                                {{ Form::text('contact', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                {{ Form::label('address', 'Address') }}
                                {{ Form::text('address', null, ['class'=>'form-control']) }}
                              </div>
                          </div>

                          <div class="col-md-12">
                              {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary','type' => 'submit'])}}
                          </div>   
                      </div>