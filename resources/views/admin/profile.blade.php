    
@extends('admin.dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/feather/css/feather.css">


	<style>
.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-top: 4px solid #f35800; /* orange color */
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.loading-status {
  top: 0;
  left: 0;
  width: 110%;
  height: 8px;
  background-color: #f7f7f7;
  z-index: 1000;
  overflow: hidden;
}
.waves {
  position: absolute;
  top: 0;
  left: -10%;
  width: 110%;
  height: 7px;
  background-image: repeating-linear-gradient(120deg, #007bff, #007bff 10px, #000 10px, #000 20px);
  border-radius: 0;
  animation: move 2.5s linear infinite;
}

@keyframes move {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 40px 0;
  }
}


.sweet-modal-container {
  /* styles for the modal container */
}

.sweet-modal-container .sweet-modal .modal-content {
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transform: scale(0.5);
  opacity: 0;
  transition: transform 0.3s, opacity 0.3s;
}

.sweet-modal-container .sweet-modal .modal-header {
  border-bottom: none;
  padding: 1.5rem;
}

.sweet-modal-container .sweet-modal .modal-title {
  font-weight: 600;
  font-size: 1.25rem;
}

.sweet-modal-container .sweet-modal .modal-body {
  padding: 1.5rem;
}

.sweet-modal-container .sweet-modal .modal-footer {
  border-top: none;
  padding: 1.5rem;
  justify-content: flex-end;
}

.sweet-modal-container .sweet-modal .modal-footer .btn {
  padding: 0.5rem 1rem;
  font-size: 1rem;
  border-radius: 5px;
}

.sweet-modal-container .sweet-modal .modal-footer .btn-secondary {
  background-color: #f7f7f7;
  color: #666;
  border: 1px solid #ddd;
}

.sweet-modal-container .sweet-modal .modal-footer .btn-primary {
  background-color: #4CAF50;
  color: #fff;
  border: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.sweet-modal-container .sweet-modal.show {
  opacity: 1;
}

.sweet-modal-container .sweet-modal.show .modal-content {
  transform: scale(1);
  opacity: 1;
}

.sweet-modal-container .sweet-modal.show .modal-content {
  animation: bounce 0.5s;
}

@keyframes bounce {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}

.table-wrapper {
  overflow-x: auto;
}


.table-fixed-first-column {
  border-collapse: collapse;
  width: 100%;
  
}

.table-fixed-first-column th:first-child {
  position: sticky !important;
  top: 0 !important;
  left: 0 !important;
  z-index: 2 !important;

  box-shadow: 2px 0px 2px rgba(0, 0, 0, 0.1); 
}


.table-fixed-first-column td:first-child {
  position: sticky !important;
  left: 0 !important;
  z-index: 1 !important;
  background-color:white;
  box-shadow: 2px 0px 2px rgba(0, 0, 0, 0.1); 
}




.table-striped-column td:nth-child(1) { /* Change 2 to the column number you want to stripe */
  background-color:#F7F7F7;
}

.table-striped-column tr:nth-child(odd) td:nth-child(1) {
  background-color: #e6e6e6;
}
	</style>
</head>
<body>


<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>




<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Profile</h4>
<span>Ensure all your details are up to date</span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item" style="float: left;"><a href="#!">Home</a>
</li>
<li class="breadcrumb-item" style="float: left;"><a href="#!" style="margin-right:10px">Profile</a>
</li>
</ul>
</div>
</div>
</div>
</div>

<div class="page-body">

<div class="row">
<div class="col-lg-12">


<div class="tab-header card">
<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal details</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#leaves" role="tab">Leaves</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#finances" role="tab">Finances</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#password" role="tab">Change password</a>
<div class="slide"></div>
</li>
</ul>
</div>



<div class="tab-content">

<div class="tab-pane active" id="personal" role="tabpanel">
<div class="card">
<div class="card-body">

<h4 class="text-dark">Personal details</h4>

<?php


  $employeeId = Auth::user()->employeeid;

  ?>

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
<p style="font-size:16px">Contact system administrator if some information is not correct</p>
<div class="row">

<div class="col-md-6">
<div class="table-responsive">
<table class="table">
<tbody>
<tr>
<th scope="row">
Name</th>
<td>{{$name}}
</td>
</tr>
<tr>
<th scope="row">
Phone Number</th>
<td>{{$phone}}</td>
</tr>
<tr>
<th scope="row">
Email</th>
<td>{{$email}}</td>
</tr>
<tr>

<th scope="row">
Date of birth</th>
<td>{{$dob}}</td>
</tr>


<th scope="row">
ID Type</th>
<td>{{$idtype}}</td>
</tr>


<th scope="row">
ID Number</th>
<td>{{$idnumber}}</td>
</tr>


</tbody>
</table>
</div>
</div>



<div class="col-md-6">
<div class="table-responsive">
<table class="table">
<tbody>

<tr>
<th scope="row">
Date started working</th>
<td>{{$startedon}}
</td>
</tr>


<tr>
<th scope="row">
Position</th>
<td>NA
</td>
</tr>



<tr>
<th scope="row">
Status </th>
<td>
  @if($status==1)
  Active
  @else
  Inactve
  @endif
</td>
</tr>


<tr>
<th scope="row">
Branch</th>
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
<th scope="row">
Role</th>
<td>
  <?php 
  $role = Auth::user()->role;
  ?>
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
<p style="font-size:16px">To view more details you have to be added as employee</p>
<div class="col-md-12">
<div class="table-responsive">
<table class="table">

<tbody>

<tr>
<th scope="row">
Name</th>
<td><a href="#!">{{Auth::user()->username}}</a>
</td>
</tr>
<tr>
<th scope="row">
Email</th>
<td>{{Auth::user()->email}}</td>
</tr>
<tr>
<th scope="row">
Role</th>
<td>{{Auth::user()->role}}</td>
</tr>
<tr>
<th scope="row">
Branch</th>
<td>NA</td>
</tr>
</tbody>
</table>
</div>
</div>
@endif
</div>
</div>
</div>




<div class="tab-pane" id="leaves" role="tabpanel">
<div class="card">
<div class="card-body">
<h4 class="text-dark">Leaves</h4>
<p style="font-size:16px">No data found</p>



</div>
</div>
</div>



<div class="tab-pane" id="finances" role="tabpanel">
<div class="card">
<div class="card-body">
<h4 class="text-dark">Finances</h4>
<p style="font-size:16px">No data found</p>


</div>
</div>
</div>




<div class="tab-pane" id="password" role="tabpanel">
<div class="card">
<div class="card-body">
<h4 class="text-dark">Change password</h4>


<form action="change-password" method="post" id="changePasswordForm">
<div class="row">
<div class="col-md-4">
      <div class="form-group ">
        <label for="">Current password</label>
        <input type="password" name="currentpassword" class="form-control" placeholder="Enter current password">
      </div>
  </div>


  <div class="col-md-4">
      <div class="form-group ">
        <label for="">New password</label>
        <input type="password" name="newpassword" class="form-control" placeholder="Enter new password" >
      </div>
  </div>

  
<div class="col-md-4">
      <div class="form-group ">
        <label for="">Comfirm password</label>
        <input type="password" name="comfirmpassword" class="form-control" placeholder="Comfirm password">
      </div>
<button class="btn btn-primary" style="float:right" id="submitDataBtn">Submit</button>
  </div>

  </div>
  </form>



 </div>
</div>
</div>
</div>





</div>





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
         url: '/change-password',
         data: $(form).serialize(),
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
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

</body>
</html>
 @endsection

