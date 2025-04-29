    
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

<div class="variables">
    <?php
    use Carbon\Carbon;
    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rfstockdate');
    $disaplaydate  = "Date not defined";

    if($date){

    $disaplaydate = Carbon::createFromFormat('Y-m-d',$date)->format('d F Y');

    }
    
   
     
    $branchId = DB::table('selection')->where('user',Auth::user()->id)->value('rfstockbranch')??"Branch not defined";
    $branchName = '';
    $categoryName = '';
  
    $categoryId = DB::table('branches')->where('id',$branchId)->value('category');
    $sectorName = DB::table('branches')->where('id',$branchId)->value('sector');


    $supplierArray = DB::table('suppliers')->where('sector','Retail')->where('category',$categoryId)->pluck('id');

    if(is_numeric($branchId)){
       
      $branchName = DB::table('branches')->where('id',$branchId)->value('branch');
      $categoryName = DB::table('businesscategories')->where('id',$categoryId)->value('category');
      
      }
      else{
  
        $branchName = 'Branch not defined';
            
      }

      $title = $branchName." Full stocktaking ".$disaplaydate;
     
     

      $checkmissingproducts = DB::table('retailfullstocktakingmissingproducts')
      ->where('date',$date)->where('branch',$branchId)->count();
      $countedProducts = "";
      $missingproducts = "";
      $missingvalue  = 0;
      if($checkmissingproducts==0){
        $countedProducts = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->pluck('productid');
        $missingproducts = DB::table('retailbranchproducts')->where('branch', $branchId)->whereNotIn('product', $countedProducts)->get();
        $missingvalue  = 0;
        foreach( $missingproducts as $list){
          $price1 = DB::table('retailbaseproducts')->where('id',$list->product)->value('sellingprice');
          $price2 = round($price1*$list->rate, -2);
          $missingvalue  = ($list->quantity*$price2) +  $missingvalue ;
        } 

      }
      else{

      $missingproducts  = DB::table('retailfullstocktakingmissingproducts')
      ->where('date',$date)->where('branch',$branchId)->get();
 
     $missingvalue = DB::table('retailfullstocktakingmissingproducts')
      ->where('date',$date)->where('branch',$branchId)->sum(db::raw('quantity*price'));

      }
  
   ?> 
</div>

<section>
<div class="card">
<div class="card-header"> 

<div class="row">

<div class="col-12 col-md-12">
<a href="admin-retail-full-stocktaking-merged" class="btn border-seconadary"  style="margin-top:5px">
  <i class="bx bx-cog"></i> 
  Full stocktaking merged data
</a>
<a href="retail-full-stocktaking-missing-products" class="btn btn-primary"  style="margin-top:5px">
  <i class="fa fa-edit"></i>
  Missing products
</a>

<a href="retail-full-stocktaking-actions-and-info" class="btn border-secondary" style="margin-top:5px">
  <i class="bx bx-file"></i>
  Actions and Info
</a>

<a href="retail-full-stocktaking-missing-products" class="btn border-secondary" style="margin-top:5px;float:right">
<i class="bx bx-refresh"></i>
  Refresh
</a>

</div>


</div>

</div>
<div class="card-body">

<div class="row">
    <div class="col-md-12" style="margin-top:-12px">
        <select class="btn "  onchange="submitBranchId(this.value)" style="margin-left:-12px">
        <option value="" hidden>{{$branchName}} (FST)</option>
        <?php
        $branches = DB::table('branches')->where('sector','Retail')->get();
        ?>
        @foreach($branches as $branch)
        <option value="{{$branch->id}}">{{$branch->branch}}</option>
        @endforeach
        </select>

        <a href="#" id="dateBtn" class="btn" style=""> 
        {{$disaplaydate}} 
         </a>

         <a href="#" class="btn" style="float:right"> 
         Missing value : <span style="color:gray;font-weight:bold">MWK</span>
         <span style="color:gray;font-weight:bold">@convert($missingvalue)</span>
         </a>

      


    </div>

        <section>
        <script> 
            function submitBranchId(value) {
                document.getElementById('branchId').value = value;
                document.getElementById('branchForm').submit();
            }
        </script>
        <form action="make-selection" method="post" id="branchForm">
        @csrf
        <input type="hidden" name="rfstockbranch" id="branchId">
        </form>
        </section>
</div>


<div class="table-wrapper" style="margin-top:10px">
<table id="mergeddata-table" class="table  table-striped-column  table-sm table-striped table-fixed-first-column table-fixed-header" >
<thead class="table-dark">
<tr>
<th class="table-dark">Product</th>
<th style="text-align:center">Unit</th>
<th style="text-align:center">Price</th>
<th style="text-align:center">Quantity</th>
<th style="text-align:center">Action</th>
</tr>
</thead>
<tbody id="tbody">
@foreach($missingproducts as $d)
<?php
 $editrow = "editrow".$d->id;
 ?>
<tr id="{{$editrow}}">
   <td >

   <?php
   if($checkmissingproducts==0){
    $productName = DB::table('retailbaseproducts')->where('id',$d->product)->value('product');
    $unit = DB::table('retailbaseproducts')->where('id',$d->product)->value('unit');
    $price = DB::table('retailbaseproducts')->where('id',$d->product)->value('sellingprice');
   }
    else{
      $productName = $d->product;
      $unit = $d->unit;
      $price = $d->price;
    }
   ?>
    {{$productName}}

   </td>
   <td style="text-align:center">{{$unit}}</td>
   <td style="text-align:center">@convert($price)</td>
   <td style="text-align:center">{{$d->quantity}}</td>
	 <td style="text-align:center">
   @if($checkmissingproducts==0)
	 <a href="#" class="editDataBtnClass" 
        editId ="{{$d->id}}"
        editRow="{{$editrow}}"
        editproduct="{{$productName}}" 
        editunit="{{$unit}}" 
        editprice="{{$price}}"
        editquantity="{{$d->quantity}}" 
        editbatchnumber="{{$d->batchnumber}}" 
        editexpirydate="{{$d->expirydate}}"
        editstatus="{{$d->status}}"
        editshelfnumber="{{$d->snumber}}"
    > 
    <i class="fa fa-edit text-primary fa-2x" ></i>
    </a>
		<a href="#" class="deleteDataBtnClass" deleteLabel="{{$productName}}"  deleteId="{{$d->id}}" deleteRow="{{$editrow}}">
      <i class="fa fa-trash text-danger fa-2x"></i>
    </a>
    @else
    <a href="#"><i class="fa fa-ban text-danger fa-2x"></i></a>
   @endif
	</td>

</tr>
@endforeach
</tbody>
</table>
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
              <input type="date" name="rfstockdate"  class="form-control" value="{{$date}}">
            
              <button class="btn btn-primary" style="margin-top:15px;float:right">Submit</button>
           
            
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</section>



<section>
<!-- Modal -->
<div class="sweet-modal-container ">
  <div class="modal fade sweet-modal " id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="sweet-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body text-center" >
          <i class="feather icon-alert-circle text-warning" style="font-size:50px"></i>
		<h4 style="paddin-top:10px;padding-bottom:10px">Are you sure you want to delete <span id="displayDeleteItem"></span> ?</h4>
		   <h5>You won't be able to revert this!</h5>
		   <form action="delete-wholesale-branch-product" method="post" id="deleteForm">
			@csrf
			<input type="hidden" id="deleteInputId" name="id">
			<input type="hidden" id="deleteInputRow">
		   </form>
		<a href="#" class="btn btn-primary deleteDataBtn" style="margin-top:25px;margin-bottom:10px">Yes, Delete it</a>
		<a href="#" class="btn btn-warning keepDataBtn" style="margin-top:25px;margin-bottom:10px" >No, Keep it</a>
        </div>
      </div>
    </div>
  </div>
</div>
</section>





<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="editDataModal" data-bs-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title">Edit product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form action="#" method="post"   id="editDataForm">
			@csrf
      <input type="hidden" id="editId" name="id">
      <input type="hidden" id="editRow">

      
		<div class="row">

			<div class="form-group col-md-6">
				<label for="#">Product Name</label>
				<input type="text"name="product" class="form-control" id="editproduct" readonly>
			</div>





			<div class="form-group col-md-6">
				<label for="#">Unit</label>
				<input type="text" name="unit" class="form-control" id="editunit" readonly>
			</div>



			<div class="form-group col-md-6">
				<label for="#">Price</label>
				<input type="number" name="orderprice" class="form-control" id="editprice" readonly>
			</div>

      

      
      
			<div class="form-group col-md-6">
				<label for="#"><strong>Quantity</strong> </label>
				<input type="number" name="quantity" class="form-control" id="editquantity">
			</div>


 
      
			<div class="form-group col-md-6">
				<input type="hidden" name="batchnumber" class="form-control" id="editbatchnumber">
			</div>

      
			<div class="form-group col-md-6">
				<input type="hidden" name="expirydate" class="form-control" id="editexpirydate">
			</div>


      
      
			<div class="form-group col-md-6" style="display:none">
			
			  <select name="status" class="form-control" id="edtitstatus">
          <option value="Active">Active (Able to sale)</option>
          <option value="Locked">Locked (Not able to sale)</option>
        </select>
			</div>



      
			<div class="form-group col-md-6">
				<input type="hidden" name="shelfnumber" class="form-control" id="editshelfnumber">
			</div>

      <div class=" foem-group col-md-12" style="display:none">
        <textarea class="form-control" name="description" id="#">NA</textarea>
      </div>




		</form>

      </div>
    </div>


    <div class="modal-footer">
    <button class="btn btn-primary" style="float:right" id="submitEditDataBtn">Submit</button>
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


  $('#tbody').on('click', '.deleteDataBtnClass', function() {
      $('#deleteInputId').val($(this).attr('deleteId'));  
      $('#displayDeleteItem').html($(this).attr('deleteLabel'));
      $('#deleteInputRow').val($(this).attr('deleteRow'));
      $('#deleteDataModal').modal('show');
      })

      
		$('.keepDataBtn').click(function() {
			$('#deleteDataModal').modal('hide');
			toastr.info('Your data is safe', 'Great!',
			{
				timeOut: 5000,
				progressBar: true,
				
			});
		});
	
      
  $(document).on("click", ".deleteDataBtn", function(e) {
  var self = $(this);
  $(this).prop("disabled", true);
  $('#deleteDataModa').modal('hide');
  var form = document.getElementById("deleteForm");
  var row = document.getElementById('deleteInputRow').value;
  e.preventDefault(); 
  $.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
  });
  $.ajax({
      type:"post",
      url: '/delete-retail-branch-product',     
	  data: $(form).serialize(),
	  beforeSend: function() {
        $('#loading-status').css('display', 'block');
       },
     complete: function() {
		$('#loading-status').css('display', 'none');
		$("#"+row).load(" "+"#"+row+ ">"+ "*",function(){});
		self.prop("disabled", false);
		form.reset();
       },
  success:function(data) {
	  if(data.status===201){
		toastr.success(data.success,'Success',{ timeOut : 5000 ,	progressBar: true});
    $('#deleteDataModal').modal('hide'); 
		}else if(data.status===422){
		toastr.error(data.error,'Error',{ timeOut : 5000 , 	progressBar: true});
    $('#deleteDataModal').modal('hide'); 
		}else{
		toastr.info('Success!','Success',{ timeOut : 5000 , 	progressBar: true});
    $('#deleteDataModal').modal('hide');  
		}
      },
      error:function(jqXHR, textStatus, errorThrown) {
        if(textStatus === 'timeout')
          {   
            toastr.error('It is taking longer to delete the data check your internet connection and try again','Timeout Error',{ timeOut : 5000 , 	progressBar: true})  
            form.reset();
          }
          else{
        
            toastr.error('Server error occured try again later','Server Error',{ timeOut : 5000 , 	progressBar: true})  
            form.reset();
          }
      },
      timeout: 60000
     });
  })


  

  

$('#tbody').on('click', '.editDataBtnClass', function() {

$('#editId').val($(this).attr('editId'));

$('#editRow').val($(this).attr('editRow'));

$('#editproduct').val($(this).attr('editproduct'));

$('#editunit').val($(this).attr('editunit'));

$('#editprice').val($(this).attr('editprice'));

$('#editquantity').val($(this).attr('editquantity'));


$('#editbatchnumber').val($(this).attr('editbatchnumber'));

$('#editexpirydate').val($(this).attr('editexpirydate'));


$('#editstatus').val($(this).attr('editstatus'));

$('#editshelfnumber').val($(this).attr('editshelfnumber'));

$('#editDataModal').modal('show');
});






$(document).on("click", "#submitEditDataBtn", function(e) {
  var self = $(this);
  $(this).prop("disabled", true);
  $('#editDataModal').modal('hide');
  var form = document.getElementById("editDataForm");
  var row = document.getElementById('editRow').value;
  e.preventDefault(); 
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/update-retail-branch-product',
         data: $(form).serialize(),
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
            $("#"+row).load(" "+"#"+row+ ">"+ "*",function(){});
		         self.prop("disabled", false);
		         form.reset();
           },
          success: function(data) {
            if(data.status===201){
              toastr.success(data.success,'Success',{ timeOut : 5000 ,	progressBar: true});
            }else if(data.status===422){
              toastr.error(data.error,'Error',{ timeOut : 5000 , 	progressBar: true})  
            }else{
              toastr.info('Success!','Success',{ timeOut : 5000 , 	progressBar: true}); 
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
      })


    $('#mergeddata-table').DataTable({ 
     dom: 'Bfrtip', 
     autoWidth:false,
     paging: true,
     pageLength: -1,
     lengthChange: false,
     buttons: [

      {
      extend: 'copy',
      title: @json($title),
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },

     {
      extend: 'excel',
      title: @json($title),
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },
    
    {
      extend: 'pdf',
      title: @json($title),
      exportOptions: {
      columns: ':visible:not(:last-child)'
      },
      customize: function (doc) {
        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
        doc.content[1].table.body.forEach(function(row, i) {
          row[0].alignment = 'left'; 
          for (var j = 1; j < row.length; j++) {
            row[j].alignment = 'center'; 
          }
       
        });
      },
     

    },{
      extend: 'print',
      title: @json($title),
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },
  
  ]
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

