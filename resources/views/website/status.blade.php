@extends('admin.dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
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


.dataTables_wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
   
}

.dataTables_filter, .dt-buttons {
    margin-bottom: 10px;
    overflow-x: hidden;
    position: sticky;
    left:0;
    right: 0;
    
}

@media (max-width: 767px) {
    .dataTables_wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }
}


   

    
	</style>

	
</head>
<body>

<!-- start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

    

<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>




        <div class="card">
            <div class="card-header">
                <h4>
                  <i class="bx bx-globe"></i> Website status
                    <a href="#" class="btn btn-primary" id="newDataBtn" style="float:right">
                        <i class="bx bx-info-circle" style="color:white"></i>Info
                    </a>
                </h4>
            </div>
            <div class="card-body">

            <?php
            $status = DB::table('websitestatus')->first();
            ?>

            @if(optional($status)->status==0)

             <div>{{optional($status)->is_zero_description}}</div>
              <a href="#" class="btn btn-info" style="margin-top:10px" id="statusBtn">Click here to enable website</a>

            @else

              <div>{{optional($status)->is_one_description}}</div>
              <a href="#" class="btn btn-info" style="margin-top:10px" id="statusBtn">Click here to disable website</a>
           @endif

            </div>
        </div>
    </div>
</div>
<!-- end page wrapper -->





<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="newDataModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Important Notice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
The landing page will display a website with dynamic data when the website status is enabled. 
Otherwise, it will redirect to the login page.
 The website content is determined by the data entered in the admin dashboard under website section.
      <br> <br>
      </div>
    </div>
  </div>
</div>
</section>





<section description="Modal for changing interval">
  <div class="modal fade-scale" tabindex="-1" role="dialog" id="statusModal" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comfirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="status-form">
            @csrf
            <div class="form-group">
              <label for="">Enter password to comfirm changing  website status</label>
            
              <input type="password" class="form-control" name="password" id="comfirmpassword" placeholder="Enter password" autocomplete="off">
              
              
              <button class="btn btn-primary" id="changeStatusBtn" style="margin-top:15px;float:right">Submit</button>
           
            
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</section>



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

  
  $('#newDataBtn').click(function() {
    $('#newDataModal').modal('show');
  });

    
    
$('#statusBtn').click(function() {
    $('#statusModal').modal('show');
  });


  
$(document).on("click", "#changeStatusBtn", function() {
    var self = $(this);
    var form = document.getElementById('status-form')
    $(this).prop("disabled", true);
    $.ajax({
        beforeSend: function() {
            $('#loading-status').css('display', 'block');
        },
        complete: function() {
            $('#loading-status').css('display', 'none');
            self.prop("disabled", false);
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/change-website-status',
        data: $(form).serialize(),
        success: function(data) {
            if (data.code == 200) {
                toastr.success(data.success);
                 setTimeout(function() {location.reload();}, 2000);
            } else if (data.code == 401) {
                toastr.error(data.error);
            } else if (data.code == 400) {
                toastr.error(data.error);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred, make sure you are connected to the internet');
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