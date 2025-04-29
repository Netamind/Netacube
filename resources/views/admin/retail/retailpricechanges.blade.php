    
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
    $title = "Price changes [".$disaplaydatey."]"

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

<a href="admin-retail-deliverynotes" class="btn border-secondary" style="margin-top:5px">
  <i class="bx bx-file"></i>
  Deliverynotes
</a>

<a href="admin-retail-price-changes" class="btn btn-primary" style="margin-top:5px;float:right">
<i class="bx bx-repeat"></i>
  Pricechanges 
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

<?php
$data = DB::table('retailpricechanges')->where('date',$date)->get();

?>

<div class="table-wrapper">
          <table id="pricechanges-table" class="table table-striped-column  table-sm table-striped table-fixed-first-column table-fixed-header" >
          <thead class="table-dark">
          <tr>
          <th class="table-dark">Product</th>
          <th style="text-align:center">Unit</th>
          <th style="text-align:center">Oldprice</th>
          <th style="text-align:center">Newprice</th>
          </tr>
          </thead>
          <tbody id="tbody">
          @foreach($data as $d)
        
          <tr>
            <td >
            <?php
            $productname = DB::table('retailbaseproducts')->where('id',$d->productid)->value('product');
            ?>
            {{$productname}}
            </td>
            <td style="text-align:center">{{$d->unit}}</td>
            <td style="text-align:center">@convert($d->oldprice)</td>
            <td style="text-align:center">@convert($d->newprice)</td>
          </tr>
          @endforeach
          </tbody>
          </table>
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
              <input type="date" name="rdate" class="form-control" value="{{$date}}">
            
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
$(document).ready(function() {


  $('#dateBtn').click(function() {
    $('#dateModal').modal('show');
  });


  
 
$('#pricechanges-table').DataTable({ 
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

