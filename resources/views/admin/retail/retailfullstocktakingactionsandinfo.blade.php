    
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

      $checkdate =DB::table('retailfullstocktakinghistory')->where('branch',$branchId)->where('date',$date)->count();
   
    
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
<a href="retail-full-stocktaking-missing-products" class="btn border-secondary"  style="margin-top:5px">
  <i class="fa fa-edit"></i>
  Missing products
</a>

<a href="retail-full-stocktaking-actions-and-info" class="btn btn-primary" style="margin-top:5px">
  <i class="bx bx-file"></i>
  Actions and Info
</a>

<a href="retail-full-stocktaking-actions-and-info" class="btn border-secondary" style="margin-top:5px;float:right">
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

        <a href="#" class="btn" style="float:right"> <i class="bx bx-download"></i> Download report</a>

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
</div>

<div class="row" style="margin-top:10px">
<div class="col-md-6">
 <table class="table table-sm  border">
 <thead>
 <tr>
 <th style="color:gray"> <i class="fa fa-info-circle"></i> Description</th>
 <th style="text-align:center;color:gray">Value</th>

 </tr>
 </thead>
 <tbody>
   <?php
   $checkstocktakes = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->count();
   $withneg = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','<','expected')->count();
   $withpos = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','>','expected')->count();
   $withzero = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','expected')->count();
 
   $posvalue = DB::table('retailfullstocktaking')
    ->where('branch', $branchId)
    ->where('date', $date)
    ->whereColumn('found', '>', 'expected')
    ->sum(DB::raw('(found - expected) * price'));

$negvalue = DB::table('retailfullstocktaking')
    ->where('branch', $branchId)
    ->where('date', $date)
    ->whereColumn('found', '<', 'expected')
    ->sum(DB::raw('(found - expected) * price'));
   
 ?>

 <tr>
 <td>Products counted</td>
 <td style="text-align:center">{{$checkstocktakes}}</td>

 </tr>

 
 <tr>
 <td>Products with no anormalities</td>
 <td style="text-align:center">{{$withzero}}</td>
 </tr>

 
 <tr>
 <td>Products with overages</td>
 <td style="text-align:center">{{$withpos}}</td>
 </tr>

   
 <tr>
 <td>Overage value</td>
 <td style="text-align:center">@convert($posvalue)</td>
 </tr>


   
 <tr>
 <td>Products with shortages</td>
 <td style="text-align:center">{{$withneg}}</td>
 </tr>

 
 <tr>
 <td>Shortage value</td>
 <td style="text-align:center">@convert($negvalue)</td>
 </tr>


 <?php
   $exvalue = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->sum(DB::raw('expected * price'));
   $fvalue = DB::table('retailfullstocktaking')->where('branch',$branchId)->where('date',$date)->sum(DB::raw('found * price'));
   
 ?>

 
 <tr>
 <td>Expected value(EV)</td>
 <td style="text-align:center">@convert($exvalue)</td>

 </tr>

 
 <tr>
 <td>Found value(FV)</td>
 <td style="text-align:center">@convert($fvalue)</td>
 </tr>



 
 <tr>
 <td>Difference(FV-EV)</td>
 <td style="text-align:center">@convert($fvalue-$exvalue)</td>
 </tr>




 
 <tr>
 <td>Missing  value</td>
 <td style="text-align:center">@convert($missingvalue)</td>
 </tr>


 
 <tr>
 <td>Full difference (FV - (EV + MV) )
  <?php $totalExpection  = $exvalue + $missingvalue ?>
 </td>
 <td style="text-align:center">@convert($fvalue-$totalExpection)</td>
 </tr>




 </tbody>
 </table>
 </div>

 <div class="col-md-6 ">
 <div class="border border-danger p-2">
 <h4><i class="fa fa-warning text-danger"></i> Full stocktaking rectification</h4>
 <p>This action ias irreversible and will clear all products for <strong><span style="color:red">{{$branchName}}</span> </strong> and replace them with newly found data</p>
 @if($checkdate>0)
 <a href="#" class="btn" style="color:gray"> <i class="fa fa-ban"></i> No action available for the selected date</a>
 @else
 <a href="#" class="btn border border-danger" id="fullrectifyBtn">Click here  for  full rectification <i class="feather icon-arrow-right"></i></a>
 @endif
 </div>
 </div>


</div>
 </div>
</div>


</div>
</div>
</section>







      
<section>
<!--Edit Modal-->
  <div class="modal fade card-primary" id="passwordModal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              Full stocktaking rectification
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <div class="modal-body">

            <form action="submit-retail-stock-fullrectification" method="post" id="fullrectificationForm">
                @csrf
               <p style="color:gray">Enter your password to complete this action</p>

               <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
             
                <input type="hidden" name="branch" value="{{$branchId}}">
                <input type="hidden" name="date" value="{{$date}}">

                <input type="hidden" name="expectedvalue" value="{{$exvalue}}">
                <input type="hidden" name="foundvalue" value="{{$fvalue}}">
                <input type="hidden" name="missingvalue" value="{{$missingvalue}}">
            
            </form>
           <button class="btn btn-primary" style="margin-top:20px;float:right"  id="submitFullrectificationBtn">Submit</button>   
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.Edit modal -->
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


  $('#fullrectifyBtn').click(function() {
    $('#passwordModal').modal('show');
  });


  
$('#submitFullrectificationBtn').click(function(e) {
      var self = $(this);
      $(this).prop("disabled", true);
      var form = document.getElementById("fullrectificationForm");
      e.preventDefault(); 
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/submit-retail-stock-fullrectification',
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
                toastr.success(data.success,'Success',{ timeOut : 5000 , progressBar: true});
                setTimeout(function(){
                    window.location.reload();
                }, 5000); // reload page after 5 seconds
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

