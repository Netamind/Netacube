    
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




	</style>
</head>
<body>



<!--start page wrapper -->
<div class="page-wrapper">
<div class="page-content">

<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>



<section>
<div class="card">
<div class="card-header">

<div class="card-header">
    <?php 
    use Carbon\Carbon; 
    $branchId = Cookie::get('rbranch') ?? "NA";
    $date = Cookie::get('rdate') ?? "Date not defined";
    $disaplaydatey = Carbon::createFromFormat('Y-m-d', $date)->format('d F Y');
    $branchName = '';
    $categoryName = '';

  
    $categoryId = DB::table('branches')->where('id',$branchId)->value('category');
    $sectorName = DB::table('branches')->where('id',$branchId)->value('sector');

    
    if(is_numeric($branchId)){
       
        $branchName = DB::table('branches')->where('id',$branchId)->value('branch');
        $categoryName = DB::table('businesscategories')->where('id',$categoryId)->value('category');
        
        }
        else{
    
          $branchName = 'Branch not defined';
              
        }
  
   
  
        $title= $branchName." | System sales ".$date;

    
    
    // Retrieve products for the current branch and date
    $products = DB::table('retailsales')->where('branch',  $branchId )->where('date',   $date )->orderBy('id', 'asc')->get(); 
    ?>
    
    <!-- Select all checkbox -->
    <input type="checkBox" id="selectAll">
    
    <!-- Branch selection dropdown -->
    <select style="background-color:white;border:none;color:blue;padding-left:-20px;font-size:17px" onchange="submitBranchId(this.value)">
        <option hidden>{{$branchName}}</option>
        <?php
        $branches = DB::table('branches')->where('sector','Retail')->get();
        ?>
        @foreach($branches as $branch)
        <option value="{{$branch->id}}">{{$branch->branch}}</option>
        @endforeach
    </select>
          


    
    <a href="#" class="" id="dateBtn" style="float:right;font-size:17px">
    <i class="fa fa-edit" ></i> {{$disaplaydatey}}
     </a>


      <script> 
          function submitBranchId(value) {
              document.getElementById('branchId').value = value;
              document.getElementById('branchForm').submit();
          }
      </script>
      <form action="select-rbranch" method="post" id="branchForm">
        @csrf
        <input type="hidden" name="branch" id="branchId">
      </form>



    
    
</div>

<div class="card-body">
    <div>
         
          <a href="#" class="btn" disabled style="margin-left:-10px;font-size:17px">
            With selected (<span id="checkcount">0</span>) :
          </a>

          <a href="#" class="btn text-warning" id="reversebtn">
            <i class="fa fa-undo"></i> Reverse
          </a>
          
          <a href="#" class="btn text-primary"  id="changedatebtn">
            <i class="fa fa-calendar"></i> Change date
          </a>

          <a href="#" class="btn text-primary" style="float:right" id="infobtn">
            <i class="fa fa-info-circle"></i>Details
          </a>

        </div>
<hr>
<div class="table-wrapper">
  <table id="roles-table" class="table-striped-column table table-sm table-striped table-fixed-first-column table-fixed-header">
    <thead class="table-dark">
      <tr>
        <th class="table-dark">Product</th>
        <th style="text-align:center">Unit</th>
        <th style="text-align:center">Qty</th>
        <th style="text-align:center">rQty</th>
        <th style="text-align:center">Price</th>
        <th style="text-align:center">Total</th>
        <th style="text-align:center">Transid[20]</th>
        <th style="text-align:center">Time</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach($products as $d)
        <?php $row = "r".$d->id; ?>
        <tr id="{{$row}}">
          <td>
            <input type="checkbox" class="selectItems" data-id="{{$d->id}}">
            <a href="#" class="editdatabtn" style="color:black" 
               id1 = "{{$d->id}}" 
               id2 = "{{$d->product}}" 
               id3 = "{{$d->unit}}" 
               id4 = "{{$d->price}}" 
               id5 = "{{$d->quantity}}" 
               id6 = "{{$d->date}}" 
               id7 = "{{$row}}" 
               id8 = "{{$d->quantity}}" 
               id9 = "{{$d->productid}}" 
               id10 = "{{$branchId}}" >
              {{$d->product}}
            </a>
          </td>
          <td style="text-align:center">{{$d->unit}}</td>
          <td style="text-align:center">@convert2($d->quantity)</td>
          <td style="text-align:center">@convert2($d->rquantity)</td>
          <td style="text-align:center">@convert($d->price)</td>
          <td style="text-align:center">@convert($d->quantity*$d->price)</td>
          <td style="text-align:center">{{$d->transid}}</td>
          <td style="text-align:center">{{$d->time}}</td>
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
          <form action="select-rdate" method="post" id="date-form">
            @csrf
            <div class="form-group">
              <label for="">Change date</label>
              <input type="date" name="date" id="selected-date" class="form-control" value="{{$date}}">
            
              <button class="btn btn-primary" style="margin-top:15px;float:right">Submit</button>
           
            
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>
</section>



      
<section>
<!--Edit Modal-->
  <div class="modal fade " id="editdata-modal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header ">
              Edit system sales
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <div class="modal-body">

            <form action="edit-system-sales-retail" method="post" id="updatedataform">
                @csrf

                <input type="hidden" name="id" id="i1">
                <div class="row">

                  <div class="col-md-12">
                    <label for="">Product </label>
                    <input type="text" name="product" class="form-control" id="i2" readonly>
                  </div>

                  <div class="col-md-12">
                    <label for="">Unit </label>
                    <input type="text" name="unit" class="form-control" id="i3" readonly>
                  </div>
                  
                  <div class="col-md-12">
                    <label for="">Price </label>
                    <input type="text" name="price" class="form-control" id="i4" autocomplete="off">
                  </div>

                
                  <div class="col-md-12">
                    <label for="">Quantity </label>
                    <input type="text" name="quantity" class="form-control" id="i5" autocomplete="off">
                  </div>

                  
                 
                  <div class="col-md-12">
                    <label for="">Date </label>
                    <input type="date" name="date" class="form-control" id="i6">
                  </div>

                  

                 
                  <input type="hidden"  class="form-control" id="i7">
                

                  
                 
      
                 
                    <input type="hidden" name="oldquantity"  class="form-control" id="i8">
                    
                 
                    <input type="hidden" name="productid"  class="form-control" id="i9">
                

                 
                    <input type="hidden" name="branch"  class="form-control" id="i10">
                

                
                



        
                
        
              
          
            </div>

        <br>
            <div class="card-footer">
         
                <button class="btn btn-primary" style="float:right" id="updatedatabtn">Submit</button>
               </div>
            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.Edit modal -->
      </section>


          


        
      
<section>
<!--Edit Modal-->
  <div class="modal fade card-primary" id="reverse-modal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
                Reverse selected items
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <div class="modal-body">

         

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Enter password to reverse selected items</label>
                      <div class="input-group has-validation">
                     <input type="password"   name="password" class="form-control nofocus" placeholder="Enter password"  required="" id="id_password"  autocomplete="off" readonly   onfocus="this.removeAttribute('readonly');">
                    <!-- <span class="input-group-text" id="inputGroupPrepend">
                     <i class="far fa-eye"   id="togglePassword"></i>
                    </span>-->
                   </div>
                    </div> 

              

                    <button class="btn btn-primary" style="margin-top:20px;float:right" onclick="reverseData()" id="reversedata">Submit</button>

                
              
                   
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.Edit modal -->
      </section>

            
<section>
<!--Edit Modal-->
  <div class="modal fade card-primary" id="changedate-modal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              Change date for selected items
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <div class="modal-body">

         
            
                    <div class="col-12">
                      <label for="id_date" class="form-label">Enter date</label>
                     <input type="date"   name="date" class="form-control "  required="" id="id_date"  value={{$date}} >
                    </div> 
                    <br>

                    <div class="col-12">
                      <label for="yourPassword2" class="form-label">Enter password </label>
                      <div class="input-group has-validation">
                     <input type="password"   name="password" class="form-control nofocus" placeholder="Enter password"  required="" id="id_password2"  autocomplete="off" readonly   onfocus="this.removeAttribute('readonly');">
                     <span class="input-group-text" id="inputGroupPrepend2" style="display:none">
                     <i class="far fa-eye"   id="togglePassword2"></i>
                    </span>
                   </div>
                    </div> 

               

                    <button class="btn btn-primary" style="margin-top:20px;float:right" onclick="changeDate()" id="changedata">Submit</button>

                
                
                   
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.Edit modal -->
      </section>


      
      
<section>
<!--Edit Modal-->
  <div class="modal fade card-primary" id="info-modal">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header ">
              {{$branchName}} |  {{$disaplaydatey}} 
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:12px"></button>
            </div>
            <?php
            $ssales = DB::table('retailsales')->where('branch',$branchId)->where('date',$date)->sum(DB::raw('quantity * price'));
            $msales = DB::table('retailmanualsales')->where('branch',$branchId)->where('date',$date)->value('sales'); 
            ?>
            <div class="modal-body">
            <table class="table table-sm">
                <thead>
                    <?php
                    $intervals = DB::table('intervalsales')->where('branch',$branchId)->where('date',$date)->orderBy('id','asc')->pluck('slot');
                    ?>
                    <tr>
                        <th>Interval</th>
                        <th style="text-align:center">User</th>
                        <th style="text-align:center">System</th>
                        <th style="text-align:center">Cash</th>
                        <th style="text-align:center">Diff</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($intervals as $interval)
                    <tr>
                        <td>{{$interval}}</td>
                        <?php
                        $users = DB::table('retailsales')->where('branch',$branchId)->where('date',$date)->where('slot',$interval)->distinct()->pluck('user');
      
                        $sys = DB::table('retailsales')->where('branch',$branchId)->where('date',$date)->where('slot',$interval)->sum(DB::raw('quantity * price'));
                        $mns = DB::table('intervalsales')->where('branch',$branchId)->where('date',$date)->where('slot',$interval)->value('sales');
                
                        $userid =   DB::table('intervalsales')->where('branch',$branchId)->where('date',$date)->where('slot',$interval)->value('user');
                        $username = DB::table('users')->where('id', $userid)->value('username')
                        ?>
                        <td style="text-align:center">
                            <span title="<?php foreach($users as $user){ $sysuser = DB::table('users')->where('id',$user)->value('username'); echo $sysuser; } ?>">{{$username}}</span>
                        </td>
                        <td style="text-align:center">@convert($sys)</td>
                        <td style="text-align:center">@convert($mns)</td>
                        <td style="text-align:center">@convert($mns-$sys)</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td style="text-align:center;font-weight:bold">Grand Total</td>
                       <td style="text-align:center;font-weight:bold">@convert($ssales ) </td>
                      <td style="text-align:center;font-weight:bold"> @convert($msales)</td>
                      <td style="text-align:center;font-weight:bold">@convert($msales-$ssales)</td>
                    </tr>
                </tbody>
            </table>
         
          

           
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


  $('#newDataBtn').click(function() {
    $('#newDataModal').modal('show');
  });

  $('#dateBtn').click(function() {
    $('#dateModal').modal('show');
  });

 
$('#roles-table').DataTable({ 
     dom: 'Bfrtip', 
     autoWidth:false,
     paging: true,
     pageLength: -1,
     lengthChange: false,
     order : [],
     buttons: [

      {
      extend: 'copy',
      title: 'Roles',
      
    },

     {
      extend: 'excel',
      title: 'Roles',
     
    },
    
    {
      extend: 'pdf',
      title: 'Roles',
     
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
      title: 'Roles',
    },
  
  ]
 }); 




})

</script>

<script>
  

  $('body').on('click', '#infobtn', function () {
    $('#info-modal').modal('show');
 });

 
 $('body').on('click', '#selectdatebtn', function () {
    $('#selectdate-modal').modal('show');
 });




$('body').on('click', '.editdatabtn', function () {
      $('#i1').val($(this).attr('id1'));
      $('#i2').val($(this).attr('id2'));
      $('#i3').val($(this).attr('id3'));
      $('#i4').val($(this).attr('id4'));
      $('#i5').val($(this).attr('id5'));
      $('#i6').val($(this).attr('id6'));
      $('#i7').val($(this).attr('id7'));
      $('#i8').val($(this).attr('id8'));
      $('#i9').val($(this).attr('id9'));
      $('#i10').val($(this).attr('id10'));
      $('#editdata-modal').modal('show');
   });


   
   
$(document).on("click", "#updatedatabtn", function(e) {
  var row = document.getElementById('i7').value;
e.preventDefault(); 
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
var form = document.getElementById('updatedataform');

$.ajax({
    type:"post",
    url: '/edit-system-sales-retail',
    data: $(form).serialize(),
    
    success:function(data) {
     
    
      if(data==-1){
    
        $("#"+row).load(" "+"#"+row+ ">"+ "*",function(){});
       
       toastr.success('Data updated successifully');

       $('#editdata-modal').modal('hide');
         
       }else{

        toastr.error('Maximum quantity for this product should be' +'' +data);

       }
        

       


       
       
       
     

    },
    error:function() {
 
     
  
       toastr.error('Server error occured make sure you are connected to the internet');
         
       
    
    }
});

});



   var checkcount =0;

   
   $('#selectAll').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".selectItems").prop('checked', true); 
            $(".selectItems:checked").each(function() {  
              
              checkcount++;
            });  

            
           
         } else {  
           
            $(".selectItems").prop('checked',false); 
            
          
              checkcount=0
           
         }
         document.getElementById("checkcount").innerHTML = checkcount;
    
        });


        $('.selectItems').on('click', function(e) {

          checkcount2 = 0;

           $(".selectItems:checked").each(function() {  
              
              checkcount2++;

            });   

         document.getElementById("checkcount").innerHTML = checkcount2;
    
        });

      
      
    

     
     $('#reversebtn').on('click', function(e) {

      var selected = document.getElementById("checkcount").innerHTML;

      if(selected==0){
      
        toastr.error('You should select atleast one item to reverse');
      }
      else if(selected<=50){

        $('#reverse-modal').modal('show');

      }
      else{
        toastr.error('You can not reverse more than 50 items at once');
      }

    });


$('#changedatebtn').on('click', function(e) {
var selected1 = document.getElementById("checkcount").innerHTML;

if(selected1==0){

  toastr.error('You should select atleast one item to change date');
}
else if(selected1<=50){

  $('#changedate-modal').modal('show');

}
else{
  toastr.error('You can not change date of more than 50 items at once');
}

});

async function reverseData(){
document.getElementById("reversedata").disabled = true;
document.getElementById("reversedata").style.color = "red";
document.getElementById("reversedata").innerHTML = "Loading....";
const url = '';
var dataArray = []; 
var epassword = document.getElementById("id_password").value;
  $(".selectItems:checked").each(function() {  
    dataArray.push($(this).attr('data-id'));
   });  
   dataArray.push(epassword);
   data = JSON.stringify(dataArray);
   await fetch(url,{mode:"no-cors"}).then(response => {
        $.ajax({
          headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            type:"POST",
            url: '/reserve-sold-items',
            data: {data:data},
            success:function(data) {
             if(data==2){
              document.getElementById("id_password").value="";
              document.getElementById("reversedata").disabled = false;
              document.getElementById("reversedata").style.color = "white";
              document.getElementById("reversedata").innerHTML = "Submit";
              document.getElementById("checkcount").innerHTML = 0;
              $('#reverse-modal').modal('hide');
              $(".selectItems:checked").each(function() {  
                var id = $(this).attr('data-id')
                var row = "r"+id;
                $("#"+row).load(" " + "#"+row + ">" + "* ",function(){});
              });  
              $("#selectAll").prop('checked',false); 
              toastr.success('Data reversed successifully');
             }
             if(data == 1){
              toastr.error('An error occured, password entered is not correct');
              document.getElementById("reversedata").disabled = false;
              document.getElementById("reversedata").style.color = "white";
              document.getElementById("reversedata").innerHTML = "Submit";
             }


            },
            error:function(data) {

              toastr.error('An error occured, make sure you are connected to internet');
            }
        });

  }).catch(err => {
    toastr.error('An error occured request was not sent to the server, make sure you are connected to the internet');
  });
};




async function changeDate(){
document.getElementById("changedata").disabled = true;
document.getElementById("changedata").style.color = "red";
document.getElementById("changedata").innerHTML = "Loading....";
const url = '';
var dataArray = []; 
var epassword = document.getElementById("id_password2").value;
var edate = document.getElementById("id_date").value;
 dataArray.push(edate);
  $(".selectItems:checked").each(function() {  
    dataArray.push($(this).attr('data-id'));
   });  
   dataArray.push(epassword);
   data = JSON.stringify(dataArray);
   await fetch(url,{mode:"no-cors"}).then(response => {
        $.ajax({
          headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            type:"POST",
            url: '/rselected-items-change-date',
            data: {data:data},
            success:function(data) {

             console.log(data);
            
              if(data==2){
              document.getElementById("id_password2").value="";
              document.getElementById("changedata").disabled = false;
              document.getElementById("changedata").style.color = "white";
              document.getElementById("changedata").innerHTML = "Submit";
              document.getElementById("checkcount").innerHTML = 0;
              $('#changedate-modal').modal('hide');
              $(".selectItems:checked").each(function() {  
                var id = $(this).attr('data-id')
                var row = "r"+id;
                $("#"+row).load(" " + "#"+row + ">" + "* ",function(){});
              });  
              $("#selectAll").prop('checked',false); 
              toastr.success('Date changed successifully');
             }


             if(data == 1){
              toastr.error('An error occured, password entered is not correct');
              document.getElementById("changedata").disabled = false;
              document.getElementById("changedata").style.color = "white";
              document.getElementById("changedata").innerHTML = "Submit";
             }


            },
            error:function(data) {
              consolole.log(data)
            

              //toastr.error('An error occured, make sure you are connected to internet');
            }
        });

  }).catch(err => {
    toastr.error('An error occured request was not sent to the server, make sure you are connected to the internet');
  });
};

  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');
  togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
    



const togglePassword2 = document.querySelector('#togglePassword2');
  const password2 = document.querySelector('#id_password2');
  togglePassword2.addEventListener('click', function (e) {
    const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
    password2.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
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

