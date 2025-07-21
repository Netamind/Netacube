    
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

    $supplierArray = DB::table('suppliers')->where('sector','Retail')->pluck('id');

    $productId  = DB::table('selection')->where('user',Auth::user()->id)->value('rproduct')??"0";
    
    $data = DB::table('retailbaseproducts')->whereIn('supplier',$supplierArray)->get();


    $product = (object) (DB::table('retailbaseproducts')->where('id', $productId)->first() ?? [
      'id' => '',
      'product' => 'Product not defined',
      'sellingprice' => '0',
      'unit' => 'na',
  ]);
  


    

   ?>


<section>
<div class="card">
<div class="card-header"> 

<div class="row">

<div class="col-12 col-md-7">
<a href="admin-retail-action-center" class="btn btn-primary"  style="margin-top:5px">
  <i class="bx bx-cog"></i> 
  Actioncenter
</a>
<a href="#" class="btn border-secondary" id="dateBtn" style="margin-top:5px">
  <i class="fa fa-edit"></i>
  {{$disaplaydatey }}
</a>

<a href="admin-retail-deliverynotes" class="btn border-secondary" style="margin-top:5px">
  <i class="bx bx-file"></i>
  Deliverynotes
</a>

<a href="admin-retail-price-changes" class="btn border-secondary" style="margin-top:5px">
<i class="bx bx-repeat"></i>
  Pricechanges 
</a>

</div>

<div class="col-12 col-md-5" style="position: relative;">

<input type="text" class="form-control border-primary" placeholder="search products here" style="margin-top:5px"   id="mobile-search">
  

<table class="table-sm table mobile-table table-borderless table-striped" style="display:none;font-size:14px" id="mobile-table">
        <thead>
        <tr style="border-top:none">
        <th></th>
        </tr>
        </thead>
        <tbody  class="border-primary">
        @foreach($data as  $d)
        <tr>
        <td style="padding:3px">
           
        <form action="make-selection" method="post" >
          @csrf
          <input type="hidden" name="rproduct" value="{{$d->id}}">
          <button style="width:100%;border:none;background:none;font-size:15px">
            {{$d->product}} &nbsp; @convert($d->sellingprice) / {{$d->unit}}
         </button>
         </form> 
        </td>
        </tr>
        @endforeach
        </tbody>
    </table>
      
        
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

<a href="#" class="btn" id="editDataBtnId" 
editid = "{{$product->id}}"
editproduct = "{{$product->product}}"
editunit ="{{$product->unit}}"
editprice="{{$product->sellingprice}}"
> 
<span id="refreshData"><i class="bx bx-edit"></i> {{$product->product}} [ @convert($product->sellingprice) / {{$product->unit}} ]</span>
</a>
<a href="#" style="float:right" class="btn text-danger"><i class="fa fa-warning"></i> Delete</a>
<a href="#" id="submitDataToBranchesBtn" style="float:right" class="btn text-success" title="This will add distributed quantitites to respective branches"><i class="fa fa-check"></i> Submit</a>
<a href="#" id="cancelDistributedProductBtn" style="float:right" class="btn text-warning" title="This will delete the distribution"><i class="fa fa-times"></i>Cancel</a>
<a href="#" id="submitAllDataToBranchesBtn" style="float:right" class="btn text-primary" title="This will add to respective branches all products distributed on {{$date}}"><i class="fa fa-check"></i> Submit (ALL)</a>

</div>



<?php
$branches = DB::table('branches')->where('sector','Retail')->get();
?>
@foreach($branches as $branch)
<div class="col-6 col-md-3 text-center" style="margin-top:10px" >
  <?php

  $stock = DB::table('retailbranchproducts')->where('branch',$branch->id)->where('product',$product->id)->value('quantity');
  
  $formid= "F".$product->id.$branch->id.$product->id.$branch->id.$branch->id;

  $input ="I".$branch->id.$branch->id.$product->id.$branch->id.$branch->id.$product->id; 
  $dquantity = DB::table('retaildeliverynotes')->where('date',$date)
  ->where('branchid',$branch->id)->where('productid',$product->id)
  ->where('added_to_branch','No')->value('quantity');

  $sdnote = DB::table('retaildeliverynotes')->where('date',$date)
  ->where('branchid',$branch->id)->where('productid',$product->id)
  ->where('added_to_branch','Yes')->value('quantity');

  ?>
<label for="#" >
   <span style="font-size:15px;font-weight:bold">{{$branch->branch}} </span> <br>
  <span style="color:gray;font-size:12px">stock  : {{$stock}} | order : 0 | sdnote : {{$sdnote}} </span>
  <span>  </span> </span>
</label>

<form action="submit-retail-dnote" id="{{$formid}}" method="post">
 @csrf
 <input type="text" autocomplete="off" name="quantity" class="form-control dnote-input" style="text-align:center;" id1="{{$formid}}"  id2 = "{{$input}}" value="{{$dquantity}}" >                  

    <input type="hidden" name="date" value="{{$date}}">
    <input type="hidden" name="branchid" value="{{$branch->id}}">
    <input type="hidden" name="productid" value="{{$product->id}}">
    <input type="hidden" name="productname" value="{{$product->product}}">
    <input type="hidden" name="unit" value="{{$product->unit}}">
    <!--<input type="hidden" name="price" value="{{$product->sellingprice}}">-->


 </form>

</div>


@endforeach
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



 $('#editDataBtnId').click(function() {

$('#editid').val($(this).attr('editid'));

$('#editRow').val($(this).attr('editRow'));

$('#editproduct').val($(this).attr('editproduct'));

$('#editunit').val($(this).attr('editunit'));

$('#editprice').val($(this).attr('editprice'));

$('#editoldprice').val($(this).attr('editprice'));

$('#editProductModal').modal('show');

});

});
 
$('#submitEditDataBtn').click(function(e) {
    var self = $(this);
    $(this).prop("disabled", true);
    $('#editProductModal').modal('hide');
    var form = document.getElementById("editDataForm");
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: '/retail-price-change',
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
            if (data.success) {
                toastr.success(data.success, 'Success', {
                    timeOut: 5000,
                    progressBar: true
                });
             $("#refreshData").html('<i class="bx bx-edit"></i> ' + data.product + ' [ ' + data.price + ' / ' + data.unit + ' ]');
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



  $(document).on("change", ".dnote-input", function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var id = $(this).attr("id1");
    var form = document.getElementById(id);

    $.ajax({
        type: "post",
        url: '/insert-retail-deliverynote',
        data: $(form).serialize(),
        success: function(response) {
            if (response.status === 200 || response.status === 201 || response.status === 202) {
                document.getElementById(id).style.borderBottom = "2px solid blue";
               // toastr.success(response.success);
            } else {
              document.getElementById(id).reset();
              toastr.error('Failed to update delivery note. Please refresh the page and try again.');

            }
        },
        error: function(xhr, status, error) {
            document.getElementById(id).reset();
            toastr.error('An error occured');
        }
    });
});


$(document).on("click", "#submitDataToBranchesBtn", function(e) {
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
        url: '/retail-add-product-to-branches',
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






$(document).on("click", "#cancelDistributedProductBtn", function(e) {
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
        url: '/retail-cancel-distributed-product',
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
                toastr.success(data.success, 'Success', {
                    timeOut: 5000,
                    progressBar: true
                });
            } else if (data.info) {
                toastr.info(data.info, 'Info', {
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
            } else if (xhr.status === 500) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error(xhr.responseJSON.error, 'Error', {
                        timeOut: 5000,
                        progressBar: true
                    });
                } else {
                    toastr.error('Internal Server Error', 'Error', {
                        timeOut: 5000,
                        progressBar: true
                    });
                }
            } else {
                toastr.error('Unspecified error occured try again later', 'Error', {
                    timeOut: 5000,
                    progressBar: true
                });
            }
        }
    });
});


</script>

<script>
$(document).ready( function () {
 var table = $("#mobile-table").DataTable({
          "paging": false,
        "bInfo" : false,
        "ordering":false,
  dom: 'lrtip'
  })
  $('#mobile-table').hide();
  $('#mobile-search').keyup( function() {
    var value = document.getElementById('mobile-search').value;
    if (value.length<2) {
      $('#mobile-table').hide();
    }else{
      $('#mobile-table').show();
     table.search($(this).val()).draw();
    }
  } );
} );
$('body').on('click', '#mobile-search', function () {
  $('#mobile-search').val('');
  $('#mobile-table').hide();
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

