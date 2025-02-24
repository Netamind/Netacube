
<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/feather/css/feather.css">


	<style>
.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-top: 4px solid #f35800; /* orange color */
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 2s linear infinite;
}

@keyframes  spin {
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

@keyframes  move {
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

@keyframes  bounce {
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
 
	</style>
</head>
<body>


<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>
<section>
<div class="card">
<div class="card-header">


<?php
   
    $branchId = Cookie::get('branch') ?? "NA";
    $branchName = '';
    $categoryName = '';
    $categoryId = DB::table('branches')->where('id',$branchId)->value('category');

    $supplierArray = DB::table('suppliers')->where('sector','Wholesale')->where('category',$categoryId)->pluck('id');

    if(is_numeric($branchId)){
       
      $branchName = DB::table('branches')->where('id',$branchId)->value('branch');
      $categoryName = DB::table('businesscategories')->where('id',$categoryId)->value('category');
      
      }
      else{
  
        $branchName = 'Branch not defined';
            
      }

  ?>

<h4>
<select name="category" id="" style=";border:none;margin-left:-4px" onchange="submitBranchId(this.value)">
<option value="" hidden><?php echo e($branchName); ?></option>
<?php
$branches = DB::table('branches')->where('sector','Wholesale')->get();
?>
<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($branch->id); ?>"><?php echo e($branch->branch); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
   




<a href="#" class="btn btn-primary" id="uploadCsvBtn"style="float:right" title="Add new product"> 
    <i class="feather icon-plus-circle" style="color:white"></i>  
</a>


<a href="#" class="btn btn-primary"  id="newDataBtn"   style="float:right;margin-right:10px" title="Find more info">
    <i class="feather icon-info"></i>
</a> 


<a href="#" class="btn btn-primary"  id="newDataBtn"   style="float:right;margin-right:10px" title="Download deliverynotes">
    <i class="feather icon-file"></i>
</a> 




<a href="#" class="btn btn-primary"  id="newDataBtn"   style="float:right;margin-right:10px" title="Choose action for selected products">
    <i class="fa fa-check"></i> <counter>0</counter>
</a> 

 

<script> 
    function submitBranchId(value) {
        document.getElementById('branchId').value = value;
        document.getElementById('branchForm').submit();
    }
</script>
<form action="select-branch" method="post" id="branchForm">
  <?php echo csrf_field(); ?>
  <input type="hidden" name="branch" id="branchId">
 </form>


</h4>
<span style="font-size:14px;">
Manage wholesale branch products <strong><?php echo e($categoryName); ?></strong> 
</span>

<hr>

</div>

<div class="card-block" style="margin-top:-15px">

<div class="table-wrapper">
<table id="business-table" class="table-striped-column  table-sm table-striped table-fixed-first-column table-fixed-header" >
<thead class="table-dark">
<tr>
<th class="table-dark">
<input type="checkbox" class="selectall"> Product</th>
<th style="text-align:center">Unit</th>
<th style="text-align:center">Quantity</th>
<th style="text-align:center">Price</th>
<th style="text-align:center">Rate</th>
<th style="text-align:center">Batch</th>
<th style="text-align:center">Expiry</th>
<th style="text-align:center">VAT</th>
<th style="text-align:center">Action</th>
</tr>
</thead>
<?php
$data = DB::table('wholesalebranchproducts')->where('branch',$branchId)->get();
?>
<tbody id="tbody">
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
 $editrow = "editrow".$d->id;
 $productName = DB::table('wholesalebaseproducts')->where('id', $d->product)->value('product');
 $productUnit = DB::table('wholesalebaseproducts')->where('id', $d->product)->value('unit');
 $productPrice = DB::table('wholesalebaseproducts')->where('id', $d->product)->value('sellingprice');
 ?>
<tr id="<?php echo e($editrow); ?>">
   <td ><?php echo e($productName); ?></td>
   <td style="text-align:center"><?php echo e($productUnit); ?></td>
   <td style="text-align:center"><?php echo e($d->quantity); ?></td>
   <td style="text-align:center"><?php 
                $value = is_numeric($productPrice) ? $productPrice : 0; 
                echo number_format($value, 0); 
            ?></td>
   <td style="text-align:center"><?php echo e($d->product); ?></td>

   <td style="text-align:center"><?php echo e($d->product); ?></td>
   <td style="text-align:center"><?php echo e($d->product); ?></td>
   <td style="text-align:center"><?php echo e($d->product); ?></td>
	 <td style="text-align:center">
	 <a href="#" class="editDataBtnClass" 
    editId ="<?php echo e($d->id); ?>"
    editRow=<?php echo e($editrow); ?> 
    editbranch="<?php echo e($d->product); ?>" 
    editsector="<?php echo e($d->product); ?>" 
    editcategory="<?php echo e($d->product); ?>" 
    editaddress="<?php echo e($d->product); ?>" 
    editcontact="<?php echo e($d->product); ?>" 
    editemail="<?php echo e($d->product); ?>" 
    > 
    <i class="fa fa-edit text-primary fa-2x" ></i>
    </a>
		<a href="#" class="deleteDataBtnClass" deleteLabel="<?php echo e($productName); ?>"  deleteId="<?php echo e($d->id); ?>" deleteRow="<?php echo e($editrow); ?>">
      <i class="fa fa-trash text-danger fa-2x"></i>
    </a>
	</td>

</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
</div>
</section>


<section>
  <div class="modal fade card-info"  id="newDataModal" data-backdrop="static">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <h4 class="modal-title">Add product for <?php echo e($branchName); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

          <?php
             $data = DB::table('wholesalebaseproducts')->whereIn('supplier',$supplierArray)->get();
             ?>

                <div class="row">
                <div class="col-sm-12">
                <label>Search a product you want to add</label>
                <div class="input-group input-group-button">

                <input type="text" autocomplete="off" style="width:80%;border:1px solid #8c8c8c;text-align:left;"  id="mobile-search" ><button style="border:1px solid #8c8c8c"  id="cancelsearch" >Cancel</button>
               
              </div>
                </div>
                </div>

          <div class="row">
          <div class="col-md-12">
     
          </div>
          </div>

        <table class="table-sm table mobile-table " style="display:none;font-size:14px" id="mobile-table">
        <thead>
        <tr style="border-top:none">
        <th style="border-top:none;border-bottom:none;font-weight:bold">Item Description</th>
        <th style="text-align:center;border-top:none;border-bottom:none;font-weight:bold">Action</th>
        </tr>
        </thead>
        <tbody >
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td><?php echo e($d->product); ?> &nbsp;
        <strong><?php 
                $value = is_numeric($d->sellingprice) ? $d->sellingprice : 0; 
                echo number_format($value, 0); 
            ?></strong> / <?php echo e($d->unit); ?>

        </td>
        <?php
        $btnrow = "row".$d->id;
        $formid = "form".$d->id;
        ?>
        <td style="margin-align:center">
        <form  action="insert-wholesale-branch-product"  id="<?php echo e($formid); ?>"  class="cart-forms"  method="post">
        <?php echo csrf_field(); ?>

            <input type="hidden" name="productid"  value="<?php echo e($d->id); ?>"> 
            <input type="hidden" name="branch"  value="<?php echo e($branchId); ?>"> 
              <div class="input-group-append" style="font-size:10px">
            <input type="text" name = "quantity" style="width:70%;border:1px solid #8c8c8c;text-align:center;"><button class="insertDataBtn" style="border:1px solid #8c8c8c" form="<?php echo e($formid); ?>"  row="<?php echo e($btnrow); ?>" id="<?php echo e($btnrow); ?>">Add</button>
  

        </form>
        </td>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

          </table>

        
          </div>
            
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.excel modal -->
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

  $('#uploadCsvBtn').click(function() {
    $('#newDataModal').modal('show');
  });

      
 
$('#business-table').DataTable({ 
     dom: 'Bfrtip', 
     autoWidth:false,
     paging: true,
     buttons: [
     {
      extend: 'excel',
      title: 'Wholesale baseproducts',
      exportOptions: {
        columns: ':visible:not(:last-child)'
      }
    },
    
    {
      extend: 'pdf',
      title: 'Wholesale baseproducts',
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
     

    }
  
  ]
 }); 
 $('#newDataBtn').click(function() {
    $('#csvDataModal').modal('show');
  });


  $('body').on('click', '.insertDataBtn', function(e) {
      var self = $(this);
      var formid = $(this).attr('form');
      var row =  $(this).attr('row');
      $(this).prop("disabled", true);
      var form = document.getElementById(formid);

      e.preventDefault(); 
      
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/insert-wholesale-branch-product',
         data: $(form).serialize(),
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
            $("#tbody").load(" #tbody  > *",function(){});
            self.prop("disabled", false);
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
         form.reset();
          }  
        });
      });

	  

  


})
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
$('body').on('click', '#cancelsearch', function () {
  $('#mobile-search').val('');
  $('#mobile-table').hide();
});
</script>

<!--js toastr notification-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
  <?php if(Session::has('message')): ?>
    var type = "<?php echo e(Session::get('alert-type', 'info')); ?>";
    switch(type){
        case 'info':
            toastr.info("<?php echo e(Session::get('message')); ?>");
            break;

        case 'warning':
            toastr.warning("<?php echo e(Session::get('message')); ?>");
            break;

        case 'success':
            toastr.success("<?php echo e(Session::get('message')); ?>");
            break;

        case 'error':
            toastr.error("<?php echo e(Session::get('message')); ?>");
            break;
    }
  <?php endif; ?>
</script>
<!--js toastr notification--> 

</body>
</html>
 <?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Netamind Technology\Desktop\Netacube\resources\views/wholesale/adminwholesalebranchproducts.blade.php ENDPATH**/ ?>