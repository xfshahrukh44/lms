
  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text pl-3">L M S</span>
    </a>
    <?php
    use App\Models\Attendance;
    use Carbon\Carbon;
    $user_detail = Auth::user()->id;
    // $attendance_record = Attendance::where('user_id', $user_detail)->whereDate('created_at', Carbon::today())->get();
    // if(count($attendance_record) > 0)
    // {
    //   $attendance_check = false;
    // }
    // else
    // {
    //   $attendance_check =true; 
    // }
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <a href="{{route('user.show', $user_detail)}}" class="d-block">
          <i class="fa fa-user pr-1 pl-1" style="color:white;"></i>
          {{Auth::user()->name}}
          </a>


            <a id = "att" href ="#" class="d-block">Mark today's attendance </a>

          
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @role('admin')
          <li class="nav-item">
            <a href="{{ asset('program') }}" class="nav-link">
              <p>
              Program
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('school') }}" class="nav-link">
              <p>
              School
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('classroom') }}" class="nav-link">
              <p>
                Classroom
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('section') }}" class="nav-link">
              <p>
                Section
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ asset('course') }}" class="nav-link">
              <p>
                Course
              </p>
            </a>
          </li>
          @endrole

          @hasrole('admin|student')
          <li class="nav-item">
            <a href="{{ asset('student') }}" class="nav-link">
              <p>
                Student
              </p>
            </a>
          </li>
          @endrole

          @hasrole('admin|teacher')
          <li class="nav-item">
            <a href="{{ asset('teacher') }}" class="nav-link">
              <p>
                Teacher
              </p>
            </a>
          </li>
          @endrole

          <li class="nav-item">
            <a href="{{ asset('session') }}" class="nav-link">
              <p>
                Session
              </p>
            </a>
          </li>

          @role('admin')
          <li class="nav-item">
            <a href="{{ asset('role') }}" class="nav-link">
              <p>
                Roles
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('user') }}" class="nav-link">
              <p>
                Users
              </p>
            </a>
          </li>
          @endrole
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="modal fade" id="AddAttendance" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Attendance</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- /Add Form Content -->
                  <div class="row" style="margin: auto; width: 40%;">
                      <button id="check-in">
                        <i class="fas fa-sign-in-alt fa-9x"></i>
                        Check-In
                      </button>
                      <button id="check-out" class="btn-warning">
                        <i class="fas fa-sign-out-alt fa-9x"></i>
                        Check-Out
                      </button>
                      <h5 class = "" id="attendance_recorded">You have checked-out</h5>
                      <span id="check_in_time" style="font-size: 22px;"></span>
                  </div>

                  <!-- /.Add Form Content -->
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
            </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>

  <script type="text/javascript">

      var user_id = <?php echo auth()->user()->id; ?>;

      $('#att').on('click',function () {
        $.ajax({
            type : 'get',
            url : '{{URL::to("statusURL")}}',
            data:{"user_id":user_id},
            dataType: "JSON",
              success:function(data)
              {
                $('#AddAttendance').modal('show');
                if(data.length > 0)
                {
                  if(data[0].check_out)
                  {
                    $('#attendance_recorded').show();
                    $('#check-in').hide();
                    $('#check-out').hide();
                  }
                  else
                  {
                    $('#attendance_recorded').hide();
                    $('#check-in').hide();
                    $('#check-out').show();
                  }
                }
                else
                {
                  $('#attendance_recorded').hide();
                  $('#check-out').hide();
                  $('#check-in').show(); 
                }
              }
          });               
      });

      $('#check-in').on('click',function () {
        $('#check-in').hide();
        $.ajax({
            type : 'get',
            url : '{{URL::to("checkInURL")}}',
            data:{"user_id":user_id},
              success:function(data){
                $('#check_in_time').text('Check-In Time:'+data);
                $('#check_in_time').fadeOut(4000,function(){
                $('#check-out').show();
                 
                });
                location.reload();
              }
          });                          
      });

      $('#check-out').on('click',function () {
        $('#check-out').hide();
        $.ajax({
            type : 'get',
            url : '{{URL::to("checkOutURL")}}',
            data:{"user_id":user_id},
            dataType: "JSON",
              success:function(data){}
          });
        $('#attendance_recorded').show();                           
      });            

    </script>