@extends('wholesale.dashboard')
@section('content')


    
           
    <div class="progress" id="progressBar" role="progressbar" aria-label="Animated striped" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 8px; transform: rotate(180deg);display:none">
    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
    </div>

      
 <div class="content-page">
                <div class="content">
                    
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">     
                                    <h4 class="page-title">Profile</h4>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Jidox</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">

                            <div class="col-xl-12 col-lg-7">

                                <div class="card">
                                    <div class="card-body">

                                    
                                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                            <li class="nav-item">
                                                <a href="#profile" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-start rounded-0 active">
                                                <i class="ri-account-circle-line fw-normal fs-18 align-middle me-1"></i>  
                                                Profile
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#leaves" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                    Leaves
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#finances" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-end rounded-0">
                                                    Finances
                                                </a>
                                            </li>
                                             <li class="nav-item">
                                                <a href="#password" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-end rounded-0">
                                                    Change password
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">

                                            <div class="tab-pane show active" id="profile">

                                              <?php $employeeId = Auth::user()->employeeid; $name = "" ?>
    @if( $employeeId > 0)
        <?php 
            $name = DB::table('employees')->where('id',$employeeId)->value('name'); 
            $phone = DB::table('employees')->where('id',$employeeId)->value('phone'); 
            $email = DB::table('employees')->where('id',$employeeId)->value('email'); 
            $dob = DB::table('employees')->where('id',$employeeId)->value('dob'); 
            $idtype = DB::table('employees')->where('id',$employeeId)->value('idtype'); 
            $idnumber = DB::table('employees')->where('id',$employeeId)->value('idnumber'); 
            $status = DB::table('employees')->where('id',$employeeId)->value('status'); 
            $startedon = DB::table('employees')->where('id',$employeeId)->value('started_on'); 
            $registeredon = DB::table('employees')->where('id',$employeeId)->value('registered_on'); 
        ?>
    

          <p class="text-muted fs-15">
           Contact system administrator if some information is not correct                         
         </p>
        
        <div class="row">
            <div class="col-md-6 border">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th scope="row"> Name</th>
                            <td>{{$name}} </td>
                        </tr>
                        <tr>
                            <th scope="row"> Phone Number</th>
                            <td>{{$phone}}</td>
                        </tr>
                        <tr>
                            <th scope="row"> Email</th>
                            <td>{{$email}}</td>
                        </tr>
                        <tr>
                            <th scope="row"> Date of birth</th>
                            <td>{{$dob}}</td>
                        </tr>
                        <th scope="row"> ID Type</th>
                        <td>{{$idtype}}</td>
                        </tr>
                        <th scope="row"> ID Number</th>
                        <td>{{$idnumber}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 border">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row"> Date started working</th>
                                <td>{{$startedon}} </td>
                            </tr>
                            <tr>
                                <th scope="row"> Position</th>
                                <td>NA </td>
                            </tr>
                            <tr>
                                <th scope="row"> Status </th>
                                <td> 
                                    @if($status==1) 
                                        Active 
                                    @else 
                                        Inactve 
                                    @endif 
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> Branch</th>
                                <td> 
                                    <?php 
                                        $branchid = DB::table('userbranch')->where('employeeid',$employeeId)->value('branchid'); 
                                        $branchName = DB::table('branches')->where('id',$branchid)->value('branch') 
                                    ?>
                                    @if($branchid) 
                                        {{$branchName}} 
                                    @else 
                                        Not set 
                                    @endif 
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"> Role</th>
                                <td> 
                                    <?php $role = Auth::user()->role; ?>
                                    @if($role) 
                                        {{$role}} 
                                    @else 
                                        Not set 
                                    @endif 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <p class="text-muted fs-15">
            To view more details you have to be added as employee                           
         </p>
    @endif




                                            </div> 
                                            <!-- end tab-pane profile section -->
                                        
    
                                            <div class="tab-pane" id="leaves">

                                              Leaves data not found
    
                                            </div>
                                            <!-- end tab-pane leaves section-->
    
                                            <div class="tab-pane" id="finances">

                                             Finances data not found
                                               
                                            </div>
                                            <!-- end tab-pane finances section-->



                        <div class="tab-pane" id="password">         

                                        <p class="text-muted fs-15">
                                         Fill this form to change your password (The password must be atleast 4 charecters long)
                                        </p>
                                        
                                        <form class="form-horizontal" action="change-password" method="post" id="changePasswordForm">
                                              @csrf
                                            <div class="row mb-3">
                                                <label for="#" class="col-3 col-form-label">Current password</label>
                                                <div class="col-9">
                                                    <input type="password" class="form-control" name="currentpassword" placeholder="Enter current password">
                                                </div>
                                            </div>
                                             <div class="row mb-3">
                                                <label for="#" class="col-3 col-form-label">New password</label>
                                                <div class="col-9">
                                                    <input type="password" class="form-control" name="newpassword" placeholder="Enter new password">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="#" class="col-3 col-form-label">Comfirm password</label>
                                                <div class="col-9">
                                                    <input type="password" class="form-control" name="comfirmpassword" placeholder="Retype new password">
                                                </div>
                                            </div>
                                           
                                            <div class="justify-content-end row">
                                                <div class="col-9 text-end">
                                                    <button type="submit" class="btn btn-info" id="submitDataBtn">Submit</button>
                                                </div>
                                            </div>
                                        </form>   
                                 </div>
                                <!-- end tab-pane password section-->


    
                                        </div> <!-- end tab-content -->
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

                

<!-- jQuery -->
<script src="Admin320/plugins/jquery/jquery.min.js"></script>
<script src="Admin320/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="Admin320/plugins/toastr/toastr.min.js"></script>
<script>
 var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 12000
    });
$(document).ready(function() {

  $('#submitDataBtn').click(function(e) {
      var self = $(this);
      $(this).prop("disabled", true);
      var form = document.getElementById("changePasswordForm");
      e.preventDefault(); 
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/rsales-change-password',
         data: $(form).serialize(),
          timeout: 60000,
          beforeSend: function() {
           $('#progressBar').show();
          },
          complete: function() {
           $('#progressBar').hide();
            self.prop("disabled", false);
           },
          success: function(data) {
            if(data.status===201){
              toastr.success(data.success,'Success',{ timeOut : 5000 ,	progressBar: true});
              form.reset();
            }else if(data.status===422){
              toastr.error(data.error,'Error',{ timeOut : 5000 , 	progressBar: true})  
            }else{
              toastr.info('Success!','Success',{ timeOut : 5000 , 	progressBar: true}); 
              form.reset();
            }
          },
        error: function(xhr, status, error) {
        if (xhr.status === 0 && xhr.readyState === 0) {
            toastr.error('Timeout check your internet connect and try again','Timeout Error',{ timeOut : 5000 , 	progressBar: true})  
          } else if (xhr.status === 422) {
              var errorPassage = '';
              var errors = xhr.responseJSON.errors;
              $.each(errors, function(key, value) { errorPassage += value + '\n'});
              toastr.error(errorPassage, 'Validation Errors', {timeOut: 5000, 	progressBar: true});
          } else if (xhr.status === 500) {
              var errorMessage = xhr.responseText;
              toastr.error('Internal server error occured try again later', 'Server Error', {timeOut: 5000 , 	progressBar: true});
          } else {
          toastr.error('Unspecified error occured try again later', 'Unspecified Error',{timeOut: 5000 ,	progressBar: true});
        }
          }  
        });
      });

})

</script>
<!--js toastr notification-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script>
<!--js toastr notification--> 



@endsection