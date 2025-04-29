    
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

#mobile-table {
    position: absolute;
    top: 35px;
    width: calc(100% - 24px); /* adjust this value to match the padding of .col-md-5 */
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ddd;
    z-index: 1000;
}

#mobile-search:focus {
    outline: none;
    box-shadow: none;
}

	</style>
</head>
<body>


<!--start page wrapper -->
<div class="page-wrapper">
<div class="page-content">

<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>



<?php
use Carbon\Carbon; 
$date = DB::table('selection')->where('user',Auth::user()->id)->value('rdate')??Carbon::today()->toDateString();
$disaplaydatey = Carbon::createFromFormat('Y-m-d', $date)->format('d F Y');
$value = 0;
$getproducts=DB::table('retaildeliverynotes')->where('date',$date)->get();

foreach($getproducts as $getproduct){

  $value = ($getproduct->quantity *  $getproduct->price) +  $value;


}

  

   ?>

<section>
<div class="card">
<div class="card-header"> 

<div class="row">

<div class="col-md-12">

<a href="admin-retail-action-center" class="btn border-secondary "  style="margin-top:5px">
  <i class="bx bx-cog"></i> 
  Actioncenter
</a>
<a href="#" class="btn border-secondary" id="dateBtn" style="margin-top:5px">
  <i class="fa fa-edit"></i>
  {{$disaplaydatey }}
</a>


<a href="admin-retail-price-changes" class="btn border-secondary" style="margin-top:5px">
<i class="bx bx-repeat"></i>
  Pricechanges 
</a>



<a href="admin-retail-deliverynotes" class="btn btn-primary" style="margin-top:5px;float:right">
  <i class="bx bx-file"></i>
  Deliverynotes
</a>
</div>



</div>


<script>
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
    navLinks.forEach(otherLink => {
        otherLink.classList.remove('bg-primary');
    });
    link.classList.add('bg-primary');
    });
});
</script>


</div>
<div class="card-body">

<div class="row">

<div class="col-md-12">
<a href="#"  class="btn text-primary" title="Value added" style="margin-left:-10px"> <span style="color:black">Deliverynotes [{{$disaplaydatey}}]</span>  <span style="color:gray;font-weight:bold"> MWK</span><span style="color:gray;font-weight:bold">@convert($value)</span></a>
<a href="#" id="submitAllDataToBranchesBtn" style="float:right" class="btn text-primary" title="This will add to respective branches all products distributed on {{$date}}"><i class="fa fa-check"></i> SUBMIT (ALL)</a>
</div>
<div class="col-md-12">
<?php
$branches = DB::table('retaildeliverynotes')->distinct()->pluck('branchid');
?>
<table class="table table-small table-striped" style="margin-top:10px">
<thead class="table-dark">
<tr>
  <th>Branch</th>
  <th style="text-align:center">Value</th>
  <th style="text-align:center">Errors</th>
  <th style="text-align:center">Submit</th>
  <th style="text-align:center">Action</th>
</tr>
</thead>
<tbody>
@foreach($branches as $branch)
<?php
$row= "row".$branch;
?>
<tr id="{{$row}}">
<?php
$branchName = DB::table('branches')->where('id',$branch)->value('branch');
$branchvalue=0;
  $getproducts2=DB::table('retaildeliverynotes')->where('date',$date)->where('branchid',$branch)->get();
    foreach($getproducts2 as $getproduct){
  
        $branchvalue = ($getproduct->quantity *  $getproduct->price) +  $branchvalue;
    }
$errors=0;
$errorReporting=0;
//$errors = DB::table('dnoteerrors')->where('date',Auth::user()->sdate1)->where('branch',$branch)->count();
//$errorReporting = DB::table('deliverynote')->where('date',Auth::user()->sdate1)->where('branch',$branch)->where('errors','true')->count();
$totalProducts = DB::table('retaildeliverynotes')->where('date',$date)->where('branchid',$branch)->count();
$toSubmit = DB::table('retaildeliverynotes')->where('date',$date)->where('branchid',$branch)->where('added_to_branch','No')->count();
?>
<td><a href="retail-deliverynote-pdf?id={{$branch}}" style="color:black">{{$branchName}}</a></td>
<td style="text-align:center"> @convert($branchvalue)</td>
<td style="text-align:center">0</td>
<td style="text-align:center">
<a href="#" class="addProductsToBranchBtn" branch="{{$branch}}" date="{{$date}}" row="{{$row}}">
<span class="badge bg-primary rounded-pill">
{{$toSubmit}} / {{$totalProducts}}</span>
</a> 
</td>
<td style="text-align:center">
<a href="admin-retail-deliverynote-details?branch={{$branch}}&&date={{$date}}"><span class="badge bg-danger rounded-pill"><i class="feather icon-arrow-right"></i></span></a> 
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>





</div>
</div>
</div>
</section>




<section description="Modal for changing interval">
  <div class="modal fade-scale" tabindex="-1" role="dialog" id="dateModal" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="make-selection" method="post" id="date-form">
            @csrf
            <div class="form-group">
              <label for="">Change date</label>
              <input type="date" name="rdate"  class="form-control" value="{{$date}}">
            
              <button class="btn btn-primary" style="margin-top:15px;float:right">Submit</button>
           
            
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</section>



<section description="Edit retail base products">
  <div class="modal fade-scale" tabindex="-1" role="dialog" id="editProductModal" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="edit-retail-base-prodcut-actioncenter" method="post" id="editDataForm">
            @csrf
            <input type="hidden" name="id" id="editid">
            <input type="hidden" name="oldprice" id="editoldprice">
            <div class="form-group">
              <label for="">Product</label>
              <input type="text" name="product" class="form-control" id="editproduct">
            </div>

            <div class="form-group">
              <label for="">Unit</label>
              <input type="text" name="unit" class="form-control" id="editunit">
            </div>


            <div class="form-group">
              <label for="">Price</label>
              <input type="text" name="price" class="form-control" id="editprice">
            </div>
            
            
            
          <button class="btn btn-primary" id="submitEditDataBtn" style="float:right;margin-top:15px">Submit</button>
           
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


  $('#dateBtn').click(function() {
    $('#dateModal').modal('show');
  });

  

$(document).on("click", ".addProductsToBranchBtn", function(e) {

    var self = $(this);

    var row = $(this).attr("row");

    $(this).prop("disabled", true);

    var date = $(this).attr("date");

    var branch = $(this).attr("branch");

    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: '/retail-add-products-to-specific-branch',
        data: {
        branch: branch,
        date: date
          },
        timeout: 60000,
        beforeSend: function() {
            $('#loading-status').css('display', 'block');
        },
        complete: function() {
            $('#loading-status').css('display', 'none');
            $("#"+row).load(" "+"#"+row+ ">"+ "*",function(){});
            self.prop("disabled", false);
        },
        success: function(data) {
            if (data.success) {
                toastr.success(data.success, 'Success', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (data.error) {
                toastr.error(data.error, 'Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 0 && xhr.readyState === 0) {
                toastr.error('Timeout check your internet connect and try again', 'Timeout Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (xhr.status === 422) {
                var errorPassage = '';
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    errorPassage += value + '\n'
                });
                toastr.error(errorPassage, 'Validation Errors', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (xhr.status === 404) {
                toastr.error(xhr.responseJSON.error, 'Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (xhr.status === 400) {
                toastr.error(xhr.responseJSON.error, 'Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (xhr.status === 500) {
                toastr.error('Internal server error occured try again later', 'Server Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else {
                toastr.error('Unspecified error occured try again later', 'Unspecified Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            }
        }
    });
});





$(document).on("click", "#submitAllDataToBranchesBtn", function(e) {
    var self = $(this);
    $(this).prop("disabled", true);
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: '/retail-add-allproducts-to-branches',
        timeout: 60000,
        beforeSend: function() {
            $('#loading-status').css('display', 'block');
        },
        complete: function() {
            $('#loading-status').css('display', 'none');
            $("#tbody").load(" #tbody > *", function() {});
            self.prop("disabled", false);
        },
        success: function(data) {
            if (data.success) {
                if (data.success === 'Delivery notes processed successfully') {
                    toastr.success(data.success, 'Success', {
                        timeOut: 5000,
                        progressBar: true
                    });
                } else if (data.success === 'No delivery notes to process') {
                    toastr.info(data.success, 'Info', {
                        timeOut: 5000,
                        progressBar: true
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 0 && xhr.readyState === 0) {
                toastr.error('Timeout check your internet connect and try again', 'Timeout Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (xhr.status === 500) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error(xhr.responseJSON.error, 'Server Error', {
                        timeOut: 5000,
                        progressBar: true
                    });
                } else {
                    toastr.error('Internal Server Error', 'Server Error', {
                        timeOut: 5000,
                        progressBar: true
                    });
                }
            } else {
                toastr.error('Unspecified error occured try again later', 'Unspecified Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            }
        }
    });
});





});
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

