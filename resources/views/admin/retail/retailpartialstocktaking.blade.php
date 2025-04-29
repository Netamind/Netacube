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


   
#mobile-search:focus {
  outline: none;
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
    <div class="variables">
    <?php
    use Carbon\Carbon;
    $date = DB::table('selection')->where('user',Auth::user()->id)->value('rpstockdate');
    $disaplaydate  = "Date not defined";

    if($date){

    $disaplaydate = Carbon::createFromFormat('Y-m-d',$date)->format('d F Y');

    }

    $branchId = DB::table('selection')->where('user',Auth::user()->id)->value('rpstockbranch')??"Branch not defined";
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

      $title = $branchName." Partial stocktaking ".$disaplaydate;
   ?> 
</div>

<div class="card">
<div class="card-header">

<div class="links">
      
  <select class="btn " style="margin-top:5px;margin-right:5px;border: 1px solid #999999" onchange="submitBranchId(this.value)">
  <option value="" hidden>{{$branchName}}</option>
  <?php
  $branches = DB::table('branches')->where('sector','Retail')->get();
  ?>
  @foreach($branches as $branch)
  <option value="{{$branch->id}}">{{$branch->branch}}</option>
  @endforeach
  </select>

  <a href="#" id="dateBtn" class="btn" style="margin-top:5px;border: 1px solid #999999"> 
      <i class="feather icon-edit"></i> {{$disaplaydate}} 
  </a>
  
  
  
  <a href="#" class="btn" style="float:right;margin-top:5px;border: 1px solid  #999999">
  <i class="bx bx-calendar"></i>History
  </a>

  
        <section>
        <script> 
            function submitBranchId(value) {
                document.getElementById('branchId').value = value;
                document.getElementById('branchForm').submit();
            }
        </script>
        <form action="make-selection" method="post" id="branchForm">
            @csrf
            <input type="hidden" name="rpstockbranch" id="branchId">
        </form>
        </section>
        </div>
  
    </div>
   <div class="card-body">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-stocktaking" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-check-square font-18 me-1'></i> </div>
                                <div class="tab-title">Partial stocktaking</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-data" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-cog font-18 me-1'></i> </div>
                                <div class="tab-title">Data</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-actions" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-cog font-18 me-1'></i> </div>
                                <div class="tab-title">Actions & info</div>
                            </div>
                        </a>
                    </li>
                </ul>
            
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="primary-pills-stocktaking" role="tabpanel">
                      <!--partial stocktaking--->
<div class="row">
<div class="col-md-5" style="padding:0px">

<?php
   $checkdate =DB::table('retailpartialstocktakinghistory')->where('branch',$branchId)->where('date',$date)->count();  
  ?>  
  @if($checkdate==0)
<input type="text"  id="mobile-search" style="background-color:silver;height:30px;width:100%; text-transform: uppercase;font-weight:bold;border:1px solid silver" placeholder="Search products here " autocomplete="off">                
 @else
 <input type="text"  style="background-color:silver;height:30px;width:100%; text-transform: uppercase;font-weight:bold;border:1px solid silver" placeholder="Date closed for stocktaking " autocomplete="off" disabled>                
 @endif
          
<div class=" border border-primary"   style="background-color:silver">     
<table class="table-sm table mobile-table border-primary table-striped" style="display:none;font-size:15px;" id="mobile-table">

<thead style="border:0;">
<tr style="border:0">
<th style="border:0"></th>
<th style="text-align:center;border:0"></th>
</tr>
</thead>


<tbody  style="background-color:silverk">
<?php
$products = DB::table('retailbaseproducts')->whereIn('supplier',$supplierArray)->get()
?>
@foreach($products as  $product)
<tr class="trow">
<td class="tcell" style="border:none">  
  <span style="text-transform: uppercase;font-family:takoma;font-weight:bold;">
  {{$product->product}}
  </span>

  <?php
   $cqty  = 0;
   $checkitem = DB::table('retailbranchproducts')->where('branch',$branchId)->where('product',$product->id)->count();
   if($checkitem>0){
    $cqty = DB::table('retailbranchproducts')->where('branch',$branchId)->where('product',$product->id)->value('quantity');
   }

  ?>
  
  <span>&nbsp;&nbsp;&nbsp; <span style="font-weight:bold;color:#1a1a1a">@convert($product->sellingprice)</span>  / <span style="color:gray;font-weight:bold"> {{$product->unit}}</span>   &nbsp;&nbsp;&nbsp; <span style="font-weight:bold;color: #4d4d4d">[ {{$cqty}} ]</span> </span>
 
</td>
<td style="margin-align:center;border:none">

<form  action="insert-retail-partial-stocktaking"  id="{{$product->id}}"   method="post">
   @csrf
   <input type="hidden" name="date" value="{{$date}}">
   <input type="hidden" name="branch" value="{{$branchId}}">
   <input type="hidden" name="product" value="{{$product->product}}">
   <input type="hidden" name="productid" value="{{$product->id}}">
   <input type="hidden" name="unit" value="{{$product->unit}}">
   <input type="hidden" name="price" value="{{$product->sellingprice}}">
   <input type="hidden" name="expected" value="{{$cqty}}">

  <div class="input-group" style="font-size:10px">

    <input type="inputbox" name="found"  id1="{{$product->id}}" class="form-control submit-data-input" style="width:50%;text-align:center;background-color:#c0c0c0;border:1px solid gray"   autocomplete="off" min="0" >
    
   </div>


</form>
</td>
</tr>
@endforeach
</tbody>

</table>
</div>
<!--/products table-->


                  </div>


                  <div class="col-md-7" style="min-height:100vh;border:1px solid silver;padding:0px;">
                  <?php
                      $items = DB::table('retailpartialstocktaking')->where('branch', $branchId)->where('date',$date)->orderBy('counter','desc')->get();
                      ?>
                  <table class="table table-sm">
                    <thead style="background-color:silverk;" >
                      <tr>
                        <th style="border:none;border-bottom:1px solid silver;color:#8c8c8c">Product</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Unit</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Price</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Expected</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Found</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Diff</th>
                      </tr>
                    </thead>
                    <tbody id="tableBody" >
                   @foreach($items as $item)
                      <tr>
                        <td>{{$item->product}}</td>
                        <td style="text-align:center">{{$item->unit}}</td>
                        <td style="text-align:center">@convert($item->price)</td>
                        <td style="text-align:center">{{$item->expected}}</td>
                        <td style="text-align:center;font-weight:bold">{{$item->found}}</td>
                        <td style="text-align:center">{{$item->found-$item->expected}}</td>
                      </tr>
                    @endforeach


                    </tbody>
                  </table>
                  </div>






                  </div>
                      <!-- / partialstocktaking-->
                    </div>


                    <div class="tab-pane fade" id="primary-pills-data" role="tabpanel">

                    <div class="table-wrapper2">
                    <table class="table table-sm" id="stockdata">
                    <thead  >
                      <tr>
                        <th style="border:none;border-bottom:1px solid silver;color:#8c8c8c">Product</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Unit</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Price</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Expected</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Found</th>
                        <th style="border:none;text-align:center;border-bottom:1px solid silver;color:#8c8c8c">Diff</th>
                      </tr>
                    </thead>
                    <tbody>
                   @foreach($items as $item)
                      <?php
                        $row = "row".$item->id;
                        $form = "form".$item->id;
                        $form2 = "forms".$item->id;
                        ?>
                      <tr id="{{$row}}">
                        <td>{{$item->product}}</td>
                        <td style="text-align:center">{{$item->unit}}</td>
                        <td style="text-align:center">@convert($item->price)</td>

                        <td style="text-align:center">
                        <span  style="display:none">{{$item->expected}}</span>
                        <form action="edit-stocktakes-retail" method="post" id="{{$form}}">
                        @csrf      
                        <input type="hidden" name="id"    value= "{{$item->id}}">
                        <input type="text" name="expected" class="edit-inputs"  style="text-align:center;border:none;width:80px;background-color:#f2f2f2"  value="{{$item->expected}}" id1={{$row}} id2="{{$form}}">
                        <input type="hidden" name="found"  class="form-control"  value= "{{$item->found}}" >
                        </form>
                        </td>

                        <td style="text-align:center;">
                        <span style="display:none">{{$item->found}}</span>
                        <form action="edit-stocktakes-retail" method="post" id="{{$form2}}">
                        @csrf      
                        <input type="hidden" name="id"    value= "{{$item->id}}">
                        <input type="text" name="found" class="edit-inputs"  style="text-align:center;border:none;width:80px;background-color:#f2f2f2" value= "{{$item->found}}"   id1={{$row}} id2="{{$form2}}">
                        <input type="hidden" name="expected"   value="{{$item->expected}}">
                        </form>
                        </td>
                        <td style="text-align:center">{{$item->found-$item->expected}}</td>
                      </tr>
                    @endforeach


                    </tbody>
                  </table>
                  </div>

                    </div>
                    <div class="tab-pane fade" id="primary-pills-actions" role="tabpanel">
                                                                
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
                        $productsCounted = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->count();
                        $withneg = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','<','expected')->count();
                        $withpos = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','>','expected')->count();

                        $withzero = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->whereColumn('found','expected')->count();
                        
                        $posvalue = DB::table('retailpartialstocktaking')
                            ->where('branch', $branchId)
                            ->where('date', $date)
                            ->whereColumn('found', '>', 'expected')
                            ->sum(DB::raw('(found - expected) * price'));

                        $negvalue = DB::table('retailpartialstocktaking')
                            ->where('branch', $branchId)
                            ->where('date', $date)
                            ->whereColumn('found', '<', 'expected')
                            ->sum(DB::raw('(found - expected) * price'));
                        
                        ?>

                        <tr>
                        <td>Products counted</td>
                        <td style="text-align:center">{{$productsCounted}}</td>

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
                        $exvalue = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->sum(DB::raw('expected * price'));
                        $fvalue = DB::table('retailpartialstocktaking')->where('branch',$branchId)->where('date',$date)->sum(DB::raw('found * price'));
                        
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




                        </tbody>
                        </table>
                        </div>

                        <div class="col-md-6 ">

                        <a href="#" class="btn border border-primary" style="margin-bottom:20px"><i class="bx bx-download"></i>Download report</a>
                        <a href="retail-partial-stocktaking" class="btn border border-primary" style="margin-bottom:20px;float:right"><i class="bx bx-refresh"></i>Refresh</a>
                        <div class="border border-danger p-2">
                        <h4><i class="fa fa-warning text-danger"></i> Partial stocktaking rectification</h4>
                        <p>This action is irreversible and will replace quantities of the counted products for <strong><span style="color:red">{{$branchName}}</span> </strong> with newly found data</p>
                        @if($checkdate>0)
                        <a href="#" class="btn" style="color:gray"> <i class="fa fa-ban"></i> No action available for the selected date</a>
                        @else
                        <a href="#" class="btn border border-danger" id="partialrectifyBtn">Click here  for  partial rectification <i class="feather icon-arrow-right"></i></a>
                        @endif
                        </div>

                     
                        </div>


                        </div>
                        </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page wrapper -->




      
<section>
<!--Edit Modal-->
  <div class="modal fade card-primary" id="passwordModal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              Partial stocktaking rectification
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <div class="modal-body">

            <form action="submit-retail-stock-partialrectification" method="post" id="partialrectificationForm">
                @csrf
               <p style="color:gray">Enter your password to complete this action</p>

               <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
             
                <input type="hidden" name="branch" value="{{$branchId}}">
                <input type="hidden" name="date" value="{{$date}}">

                <input type="hidden" name="expectedvalue" value="{{$exvalue}}">
                <input type="hidden" name="foundvalue" value="{{$fvalue}}">
        
            </form>
           <button class="btn btn-primary" style="margin-top:20px;float:right"  id="submitPartialrectificationBtn">Submit</button>   
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.Edit modal -->
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
              <input type="date" name="rpstockdate"  class="form-control" value="{{$date}}">
            
              <button class="btn btn-primary" style="margin-top:15px;float:right">Submit</button>
           
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
  


    $('#dateBtn').click(function() {
    $('#dateModal').modal('show');
  });


  $('#newDataBtn').click(function() {
    $('#newDataModal').modal('show');
  });

  $(document).ready(function() {
  $('#stockdata').DataTable({
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


$(document).ready(function () {
    $('#mobile-search').click(function (){
      $('#mobile-search').val('');
      $('#mobile-table').hide();
    });
})




$(document).on("change", ".submit-data-input", function(e) {
e.preventDefault();
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
var id = $(this).attr("id1");
$(this).css("fontWeight","bold");
var form = document.getElementById(id);
$.ajax({
    type:"post",
    url: '/insert-retail-partial-stocktaking',
    data: $(form).serialize(),
    success:function(data) {
        $("#tableBody").load(" #tableBody > *");
        form.reset();
    },
    error:function(jqXHR, textStatus, errorThrown) {
      if(textStatus === 'timeout')
        {   
            toastr.error('It is taking longer to submit the data check your internet connection and try again')  
            form.reset();
           
        }
        else{
          toastr.error('Server error occured, refresh the page and try again')  
          form.reset();
        }
    },
    timeout: 3000
  });

});




   
    
$('body').on('click', '#partialrectifybtn', function () {
     
     $('#partialrectify-modal').modal('show');

  });





  
$(document).on("change", ".edit-inputs", function(e) {
 var r = $(this).attr('id1')
 var f = $(this).attr('id2')
 var row = document.getElementById(r)
 var form = document.getElementById(f)
e.preventDefault()
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
$.ajax({
    type:"post",
    url: '/edit-retail-partial-stocktaking',
    data: $(form).serialize(),
    success:function(data) {
      if(data==2){

        document.getElementById(f).style.border="1px solid  blue";
        $("#"+r).load(" "+"#"+r+ ">"+ "*",function(){});
      
       }
      if(data==1){
       toastr.error('No data change detected');
       $("#"+r).load(" "+"#"+r+ ">"+ "*",function(){});

       }
    },
    error:function(jqXHR, textStatus, errorThrown) {
      if(textStatus === 'timeout')
        {   
            toastr.error('It is taking longer to submit the data check your internet connection and try again')  
            $("#"+r).load(" "+"#"+r+ ">"+ "*",function(){});
           
        }
        else{
          toastr.error('Server error occured, refresh the page and try again')  
          $("#"+r).load(" "+"#"+r+ ">"+ "*",function(){});
        }
    },
    timeout: 3000
   
});

});






$('#partialrectifyBtn').click(function() {
    $('#passwordModal').modal('show');
  });


  
$('#submitPartialrectificationBtn').click(function(e) {
      var self = $(this);
      $(this).prop("disabled", true);
      var form = document.getElementById("partialrectificationForm");
      e.preventDefault(); 
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/submit-retail-stock-partialrectification',
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
            }
            else if(data.status===422){
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