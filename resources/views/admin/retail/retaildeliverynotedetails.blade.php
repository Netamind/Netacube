    
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
<?php
use Carbon\Carbon;
$branchId = request('branch');
$date = request('date')??Carbon::today()->toDateString();
$disaplaydatey = Carbon::createFromFormat('Y-m-d', $date)->format('d F Y');
$branchName = DB::table('branches')->where('id',$branchId)->value('branch')??"Branch not defined";

$data = DB::table('retaildeliverynotes')->where('branchid',$branchId)->where('date',$date)->get();
$dnotevalue = 0;
foreach ($data as $row) {
$dnotevalue += $row->quantity * $row->price;
}

$title = $branchName." Deliverynote ".$date." (MWK".$dnotevalue.")";

?>

<a href="admin-retail-deliverynotes" class="btn btn-primary"  ><i class="fa fa-arrow-left"></i></a>

<a href="#" class="btn" style="font-size:20px"  >{{$branchName}}</a>

<a href="#" class="btn"  style="font-size:20px">{{$disaplaydatey}}</a>







<a href="#" class="btn btn-primary"  style="float:right;margin-right:10px"><i class="fa fa-cloud-download"></i> Download</a>
<div>
    <a href="#" class="btn" style="margin-left:-10px;font-size:16px" disabled>
        Value : <span  style="color:gray;font-weight:bold">MWK</span><span style="color:gray;font-weight:bold">@convert($dnotevalue)</span> 
    </a>
    <a href="#" class="btn" disabled>
        <i>With selected:</i>
    </a>
    <a href="#" class="btn text-warning">
        <i class="fa fa-undo"></i> Unsubmit
    </a>
    <a href="#" class="btn text-primary">
        <i class="fa fa-calendar"></i> Change date
    </a>
    <a href="#" class="btn text-secondary">
        <i class="fa fa-building"></i> Change branch
    </a>
    <a href="#" class="btn text-success">
    <i class="fa fa-check"></i> Submit
    </a>
    <a href="#" class="btn text-danger">
        <i class="fa fa-trash"></i> Delete
    </a>
 </div>
</div>
<div class="card-body">

<div class="table-wrapper" >
<table id="deliverynote-table" class="table-striped-column table table-sm table-striped table-fixed-first-column table-fixed-header" >
<thead class="table-dark">
<tr>
<th class="table-dark">
<input type="checkbox" class="selectall"> Product</th>
<th style="text-align:center">Unit</th>
<th style="text-align:center">Quantity</th>
<th style="text-align:center">Price</th>
<th style="text-align:center">Total</th>
<th style="text-align:center">Submitted</th>
<th style="text-align:center">Action</th>
</tr>
</thead>
<tbody id="tbody">

    @foreach($data as $d)
    <?php
    $editrow = "editrow".$d->id;
    ?>
    <tr id="{{$editrow}}">
    <td ><input type="checkbox" name="select" class="select"> {{$d->productname}}</td>
    <td style="text-align:center">{{$d->unit}}</td>
    <td style="text-align:center">{{$d->quantity}}</td>
    <td style="text-align:center">@convert($d->price)</td>
    <td style="text-align:center;">@convert($d->quantity*$d->price)</td>
    <td style="text-align:center">{{$d->added_to_branch}}</td>

    <td style="text-align:center">
    <a href="#" class="editDataBtnClass" 
        editId ="{{$d->id}}"
        editRow="{{$editrow}}"
        editproduct="{{$d->productname}}" 
        editunit="{{$d->unit}}"
        editquantity="{{$d->quantity}}"  
        editprice="{{$d->price}}"
        > 
        <i class="fa fa-edit text-primary fa-2x" ></i>
        </a>
        <a href="#" class="deleteDataBtnClass" deleteLabel="{{$d->productname}}"  deleteId="{{$d->id}}" deleteRow="{{$editrow}}">
        <i class="fa fa-trash text-danger fa-2x"></i>
        </a>
    </td>
    </tr>
    @endforeach

</tbody>
</table>
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

$('#deliverynote-table').DataTable({ 
     dom: 'Bfrtip', 
     autoWidth:false,
     paging: true,
     pageLength: -1,
     lengthChange: false,
     buttons: [

      {
      extend: 'copy',
      title: @json($title),
      
    },

     {
      extend: 'excel',
      title: @json($title),
     
    },
    
    {
      extend: 'pdf',
      title: @json($title),
     
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
    },
  
  ]
 }); 


 

$(document).on("click", "#addProductsToBranchBtn", function(e) {
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

