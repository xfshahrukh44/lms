<!-- form start -->
                        <div class="">
                          <div class="col-md-12">
                            <div class="form-group">
                              {{Form::label('name','Role Name')}}
                              {{Form::text('name', null,['class' => 'form-control','id' => 'id'])}}
                              
                          </div>
                          </div>
                        </div>
                          
                        <div class="card-footer">
                        <div class="col-md-12">
                        {{Form::button(isset($model)? 'Update' : 'Save', ['class' => 'btn btn-primary','type' => 'submit'])}}
                          </div> 
                        </div>