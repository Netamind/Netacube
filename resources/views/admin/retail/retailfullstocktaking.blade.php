@extends('admin.dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
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


input[type="updatecart"]:focus { 
    outline: 1px solid blue;
}



input[type="updatecart2"]:focus { 
    outline: 1px solid blue;
}


input[type="submitdnoteerrorinput"]:focus { 
    outline: none
}

input[type="inputbox"]
{
    background: transparent;

}


input[type="inputbox"]:focus
{
    outline:1px none;
    background: transparent;

}




input[type="carttime"]
{
    background: transparent;
    border: none;
}

#tablediv{

  background-color:#cccccc;

  /*background-color:#e6c300*/

}


#tablediv2{

background-color:#e6c300;



}

.submit-data-input2{
  background:none;
  border: 1px ridge  #b3b3b3;
}



.submit-data-input{
  background:none;
  border: 1px ridge  #b3b3b3;
}

.trow{
  color:black;

}

tr.trow td {
  
  /*border-width: 1px; border-color:  #a6a6a6*/
  border-bottom: 1px solid  #a6a6a6;
  border-top: 1px solid  #a6a6a6;
}

.tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height:70vh; /* gives an initial height of 200px to the table */
      }
      .tableFixHead thead th {
        position: sticky; /* make the table heads sticky */
        top: 0px; /* table head will be placed from the top of the table and sticks to it */
      }



.calculator {
  width: 100%;
  height: auto;
  /*margin: 70px auto 0;*/
  overflow: hidden;
  box-shadow: 4px 4px rgba(0, 0, 0, 0.2);
}

.calculator span {
  -moz-user-select: none;
  user-select: none;
}

.top {
  position: relative;
  height: 150px;
  background-color: blue;

}

.top .unit {
  text-transform: uppercase;
  position: absolute;
  top: 10px;
  left: 10px;
  font-weight: 700;
  color: #757575;
}

.top .screen {
  position: relative;
  width: 100%;
  top: 20%;
  height: 80%;
}

.screen > div  {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  width: 100%;
  padding: 5px;
  text-align: right;
}

.screen .input {
  color: #757575;
  height: 60%;
  font-size: 35px;
}

.screen .result {
  color: #9e9e9e;
  font-size: 20px;
  height: 40%;
}

.bottom {
  background-color: #2D2D2D;
  height: 300px;
  color: #fff;
  cursor: pointer;
}

.bottom section {
  position: relative;
  height: 100%;
  float: left;
  display: flex;
}

.keys {
  width: 80%;
}


.keys .column {
  display: flex;
  flex-grow: 1;
}

.keys .column, .operators {
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.keys .column span, .operators span {
  position: relative;
  overflow: hidden;
  flex-grow: 1;
  width: 100%;
  line-height: 1;
  padding: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background-color 0.5s;
}

.keys .column span {
  font-size: 25px;
}

.keys .column span:hover, .operators span:hover {
  background-color: rgba(0, 0, 0, 0.2);
}

.operators {
  width: 20%;
  font-size: 18px;
  background-color: #434343;
}

.delete {
  font-size: 16px;
  text-transform: uppercase;
}

.credit {
  display: block;
  text-align: center;
  width: 100%;
  position: absolute;
  bottom: 20px;
  margin: 0 auto;
}

.credit a, .error {
  color: #C2185B;
}


div::-webkit-scrollbar {
        background-color: silver;
        height: 8px; /* Reduce the height of the scrollbar */
    }
    div::-webkit-scrollbar-thumb {
        background-color: gray;
    }



	</style>
</head>
<body  onload="onLoadFunctions()">

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
   ?> 
</div>
<section>
  
<div class="row" style="margin-top:-12px">
<!--Links---->    
<div class="col-md-12" style="background-color:silver;padding-top:5px">

<select class="btn " style=";background-color:silver;margin-bottom:10px;margin-top:5px;margin-right:5px;border: 1px solid #999999" onchange="submitBranchId(this.value)">
<option value="" hidden>{{$branchName}} (FST)</option>
<?php
$branches = DB::table('branches')->where('sector','Retail')->get();
?>
@foreach($branches as $branch)
<option value="{{$branch->id}}">{{$branch->branch}}</option>
@endforeach
</select>





<a href="#" id="dateBtn" class="btn" style="margin-bottom:10px;margin-top:5px;border: 1px solid #999999"> 
    <i class="feather icon-edit"></i> {{$disaplaydate}} 
</a>



<a href="admin-retail-full-stocktaking-merged" class="btn" style="float:right;margin-bottom:10px;margin-top:5px;border: 1px solid  #999999">
Merged data <i class="feather icon-arrow-right"></i>
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
  <input type="hidden" name="rfstockbranch" id="branchId">
 </form>
</section>


</div>
<!--/Links col-md-12 -->


<!---Left Collumn-->
<div class="col-md-5">
<div class="row">
<!--search input-->
<div class="col-md-12 bg-primary p-2">
<div class="input-group " style="margin-top:10px;margin-bottom:13px">    
  <?php
   $checkdate =DB::table('retailfullstocktakinghistory')->where('branch',$branchId)->where('date',$date)->count();  
  ?>  
  @if($checkdate==0)
<input type="text" class="form-control" id="mobile-search" style="background-color:silver;text-transform: uppercase;font-weight:bold;border:1px solid silver" placeholder="Search products here " autocomplete="off">                
 @else
 <input type="text" class="form-control" id="mobile-search2" style="background-color:silver;text-transform: uppercase;font-weight:bold;border:1px solid silver" placeholder="Date closed for stocktaking " autocomplete="off" disabled>                
 @endif
</div>
</div>
<!--/search input-->

<!--producs table-->
<div class="col-md-12 border border-primary " id="tablediv" style="background-color:silver"> 
        
<table class=" table table-sm table mobile-table table-striped" style="display:none" id="mobile-table">
<thead>
<tr>

<th style="border:0"></th>
<th style="text-align:center;border:0"></th>

</tr>
</thead>


<tbody>

<?php
$products = DB::table('retailbaseproducts')->whereIn('supplier',$supplierArray)->get()
?>
@foreach($products as  $product)
<tr class="trow">
<td class="tcell">


 <?php
     $inputid = $product->id."input";
     $branchqty = 0;
     $branchrate = 1.00;
     $checkQty =  DB::table('retailbranchproducts')->where('branch',$branchId)->where('product',$product->id)->count();
    
     if($checkQty>0){

      $branchqty = DB::table('retailbranchproducts')->where('branch',$branchId)->where('product',$product->id)->value('quantity');
      $branchrate = DB::table('retailbranchproducts')->where('branch',$branchId)->where('product',$product->id)->value('rate');
   
     }
    
   ?>
  <span style="text-transform: uppercase;font-family:takoma;font-weight:bold;">
  {{$product->product}}
  </span>
  <span style="color:gray;font-family:monospace">@convert($product->sellingprice)/{{$product->unit}} &nbsp; [{{$branchqty}}] </span>
  
  
</td>
<td>

  <form  action="#"  id="{{$product->id}}"  class="cart-forms">
    <input type="inputbox" id="{{$inputid}}" class="form-control sale-data cart-input submit-data-input" style="text-align:center;border: 1px solid  #999999" name="quantity"  autocomplete="off" min="0"
      productid="{{$product->id}}" 
      product="{{$product->product}}"                    
      unit = "{{$product->unit}}"    
      price="{{$product->sellingprice}}"               
      branch = {{$branchId}}                  
      inputid = "{{$inputid}}"  
      date = "{{$date}}"
      rate = "{{$branchrate}}"     
    >
</form>


</td>

</tr>
@endforeach
</tbody>

</table>
</div>
<!--/products table-->
</div>
</div>
<!---/Left Collumn-->



<!---Right Collumn-->
<div class="col-md-7" >
<div class="row bg-primary " style="">

<!--Cart total-->
<div class="col-md-12 bg-primary" style="height:51px">
<div class="" style="margin-top:17px"> 


<a href="#" class="btn"   style="border: 2px solid silver;font-weight:bold;color:silver">
<i class="fa fa-shopping-cart"></i> | MWK<span  id="cartTotal1" style="color:#f2f2f2;font-weight:bold;font-size:17px"></span>
<input type="hidden"  id="cartTotal2"  >
</a>

<a href="retail-full-stocktaking"  style="margin-left:5px;border:2px solid silver;font-weight:bold;color:silver;width:80px" class="btn" title="click here to refresh this page">
 <i class="fa fa-refresh" style="color:#d9d9d9"></i>
</a>

<a href="#" id="mergeDataBtn"  style="float:right;border:2px solid silver;font-weight:bold;color:silver;width:80px" class="btn" title="Click here to merge data">
 <i class="fa fa-angle-right " style="color:#d9d9d9;font-weight:bold;font-size:15px"></i> 
</a>

</div>
</div>
<!--/Cart total -->


<div class="col-md-12" style="height:100%;background-color:silver;margin-top:27px">

<!--cart table-->
<div style="overflow-x:auto;">
    <table class="table table-sm" id="cartTable" style="font-size:12px">
        <thead style="color: #3d5c5c">
            <tr style="font-size:14px">
                <th style="border-bottom:2px solid #a6a6a6;border-top:0px solid #a6a6a6 ;font-weight:bold">Item</th>
                <th style="text-align:center;border-bottom:2px solid #a6a6a6;border-top:1px solid #a6a6a6; font-weight:bold">Unit</th>
                <th style="text-align:center;border-bottom:2px solid #a6a6a6;border-top:1px solid #a6a6a6; font-weight:bold">Price</th>
                <th style="text-align:center;border-bottom:2px solid #a6a6a6;border-top:1px solid #a6a6a6; font-weight:bold">Qty</th>
                <th style="text-align:center;border-bottom:2px solid #a6a6a6;border-top:1px solid #a6a6a6; font-weight:bold">Actn</th>
            </tr>
        </thead>
        <tbody id="cartbody">
        </tbody>
    </table>
</div>
<!--/cart table-->
</div>  
</div>
</div>
<!---/Right Collumn-->
</div>
</section>



</div>
</div>





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





<section description="Modal for changing interval">
  <div class="modal fade-scale" tabindex="-1" role="dialog" id="mergeDataModal" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Merge comfirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="date-form">
            @csrf
            <div class="form-group">
              <label for="">Enter password to comfirm merging data</label>
            
              <input type="password" class="form-control" name="password" id="comfirmpassword" placeholder="Enter password" autocomplete="off">
              
              
              <button class="btn btn-primary" id="submitMergeDataBtn" style="margin-top:15px;float:right">Submit</button>
           
            
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

  
$('#mergeDataBtn').click(function() {
    $('#mergeDataModal').modal('show');
  });


  $(document).on("click", "#submitMergeDataBtn", function() {  
    var self = $(this);
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
        url: '/merge-retail-full-stocktaking',
        data: { data: JSON.stringify([document.getElementById("comfirmpassword").value, localStorage.cartDataFstock]) },
        
        success: function(data) {
            if (data == 2) {
        
                toastr.success('Data merged successfully');
                localStorage.removeItem('cartDataFstock');
            }
            if (data == 1) {
                toastr.error('An error occurred, password entered is not correct');
            }
        },
        error: function(data) {
            toastr.error('An error occurred, make sure you are connected to the internet');
        }
    });
});


var  cartArray = [];
var receiptArray = [];
 
</script>


<script>

$('body').on('change', '.sale-data', function (){ 
    var productid = $(this).attr('productid'); 
    var product = $(this).attr('product'); 
    var unit = $(this).attr('unit'); 
    var price = $(this).attr('price'); 
    var branch = $(this).attr('branch'); 
    var date = $(this).attr('date'); 
    var rate = $(this).attr('rate'); 
    var inputid = $(this).attr('inputid'); 
    var quantity = document.getElementById(inputid).value; 
    var deleteid = generateUniqueId();

    var cartRow = { 
        Productid:productid, 
        Product:product, 
        Unit:unit, 
        Price:price, 
        Branch:branch, 
        Date:date, 
        Rate:rate,
        Quantity:quantity, 
        Deleteid : deleteid
    } 

    if(!isNaN(quantity) && quantity > 0){
        cartArray.push(cartRow); 
        localStorage.cartDataFstock=JSON.stringify(cartArray) 
        var btn = '<a href="#" style="color:red" onclick="removeCartItem('+deleteid+')">X</a>';
        var dprice = numberToCurrency (price); 
        prepareTableCell(product,unit,dprice,quantity,btn,deleteid) 
        document.getElementById(inputid).value =" " 
        cartTable =JSON.parse(localStorage.cartDataFstock);
        cartTotal=0; 
        for(var i=0;i<cartTable.length;i++){
            var price = cartTable[i].Price;
            var quantity = cartTable[i].Quantity;

            var cartTotal = price*quantity + cartTotal;

            var cartDisplayNum = numberToCurrency (cartTotal);

            document.getElementById("cartTotal1").innerHTML = cartDisplayNum;
            document.getElementById("cartTotal2").value = cartTotal;
            }  

    } else{ 
        toastr.error('An error occured, Quantity must be a number greater than 0' ); 
        document.getElementById(inputid).value =" " 
    } 
}) 

var numberToCurrency = function (input_val, fixed = false, blur = false) {
    if(!input_val) {
        return "";
    }
    
    if(blur) {
        if (input_val === "" || input_val == 0) { return 0; }
    }

    if(input_val.length == 1) {
        return parseInt(input_val);
    }

    input_val = ''+input_val;
    
    let negative = '';
    if(input_val.substr(0, 1) == '-'){
        negative = '-';
    }
    if (input_val.indexOf(".") >= 0) {
        var decimal_pos = input_val.indexOf(".");
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        left_side = left_side.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if(fixed && right_side.length > 3) {
            right_side = parseFloat(0+right_side).toFixed(2);
            right_side =  right_side.substr(1, right_side.length);
        }
        right_side = right_side.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(right_side.length > 2) {
            right_side = right_side.substring(0, 2);
        }
    
        if(blur && parseInt(right_side) == 0) {
            right_side = '';
        }

        if(blur && right_side.length < 1) {
            input_val = left_side;
        } else {
            input_val = left_side + "." + right_side;
        }
    } else {
        input_val = input_val.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    if(input_val.length > 1 && input_val.substr(0, 1) == '0' && input_val.substr(0, 2) != '0.' ) {
        input_val = input_val.substr(1, input_val.length);
    } else if(input_val.substr(0, 2) == '0,') {
        input_val = input_val.substr(2, input_val.length);
    }
    
    return negative+input_val;
};


function prepareTableCell(product,unit,price,quantity,btn,rownum){
var table = document.getElementById('cartTable').getElementsByTagName('tbody')[0];

var row  = table.insertRow(0);
cell1 = row.insertCell(0)
cell2 = row.insertCell(1)
cell3 = row.insertCell(2)
cell4 = row.insertCell(3)
cell5 = row.insertCell(4)

cell1.innerHTML = product;
cell2.innerHTML = unit;
cell3.innerHTML = price;
cell4.innerHTML = quantity;
cell5.innerHTML = btn;

row.id= "r"+rownum;
 
cell2.style.textAlign = "center";
cell3.style.textAlign = "center";
cell4.style.textAlign = "center";
cell5.style.textAlign = "center";

for (var i = 0; i < 5; i++) {
    var cell = row.cells[i];
    cell.style.borderBottom = "1px solid  #b3b3b3";
}


}


function displayCartData(){
if(localStorage.cartDataFstock){

  cartArray =JSON.parse(localStorage.cartDataFstock);

  for(var i=0;i<cartArray.length;i++){
    var productid = cartArray[i].Productid;
    var product = cartArray[i].Product;
    var unit = cartArray[i].Unit;
    var price = cartArray[i].Price;
    var quantity = cartArray[i].Quantity; 
    var deleteid = cartArray[i].Deleteid; 
    var btn = '<a href="#" style="color:red" onclick="removeCartItem('+deleteid+')">X</a>';
     prepareTableCell(product,unit,price,quantity,btn,deleteid)
  }

    cartTable =JSON.parse(localStorage.cartDataFstock);
    cartTotal=0; 
    for(var i=0;i<cartTable.length;i++){
        var price = cartTable[i].Price;
        var quantity = cartTable[i].Quantity;

        var cartTotal = price*quantity + cartTotal;

        var cartDisplayNum = numberToCurrency (cartTotal);

        document.getElementById("cartTotal1").innerHTML = cartDisplayNum;
        document.getElementById("cartTotal2").value = cartTotal;
    }  

}

}


</script>
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


$(document).ready(function () {
    $('#mobile-search').click(function (){
      $('#mobile-search').val('');
      $('#mobile-table').hide();
    });
})
</script>



<script>
    
function removeCartItem(id){
    var rowid = "r"+id;
    var row = document.getElementById(rowid);
    if(row){
        var rowindex = row.rowIndex;
        var table = document.getElementById("cartTable");
        table.deleteRow(rowindex);
    }
    var cartTotal = 0;
    var newData = [];
    var oldData = JSON.parse(localStorage.cartDataFstock)
    for (var i = 0; i <oldData.length; i++) {
        if(id != oldData[i].Deleteid){
            newData.push(oldData[i]);
        }
    }
    localStorage.cartDataFstock = JSON.stringify(newData);
    cartArray = newData; 
    cartTable =JSON.parse(localStorage.cartDataFstock);
    cartTotal=0;
    if(cartTable.length > 0){
        for(var i=0;i<cartTable.length;i++){
            var price = cartTable[i].Price;
            var quantity = cartTable[i].Quantity;
            var cartTotal = price*quantity + cartTotal;
            var cartDisplayNum = numberToCurrency (cartTotal);
            document.getElementById("cartTotal1").innerHTML = cartDisplayNum;
            document.getElementById("cartTotal2").value = cartTotal;
        }
    } else {
        document.getElementById("cartTotal1").innerHTML = "0";
        document.getElementById("cartTotal2").value = 0;
    }
}



function onLoadFunctions(){
  displayCartData();
  document.getElementById('mobile-search').focus();
}
</script>
<script>


 function generateUniqueId() {
    var timestamp = Math.floor(Date.now() / 1000);
    var randomNum = Math.floor(Math.random() * 1000000);
    var uniqueId = (timestamp * 1000000) + randomNum;
    return uniqueId.toString().padStart(10, '0');
}


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