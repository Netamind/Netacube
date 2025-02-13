
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
<tbody id="tbody">

</tbody>
</table>
</div>
</div>
</section>



<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="newDataModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add a product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <?php $data = DB::table('wholesalebaseproducts')->whereIn('supplier',$supplierArray)->get(); ?>
            <input type="search" id="search-input" placeholder="Search products..." class="form-control">
            <table id="search-results" style="display: none;">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="search-results-body">
                    
                </tbody>
            </table>




		
      </div>
    </div>
  </div>
</div>
</section>



<section>
<div class="modal fade-scale" tabindex="-1" role="dialog" id="editDataModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title">Edit product <strong><?php echo e($categoryName); ?></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="edit-wholesale-baseproduct" method="post"   id="editDataForm">
			<?php echo csrf_field(); ?>
      <input type="hidden" id="editId" name="id">
      <input type="hidden" id="editRow">

      

		<div class="row">
			<div class="form-group col-md-6">
				<label for="#">Product Name</label>
				<input type="text"name="product" class="form-control" id="editproduct">
			</div>





			<div class="form-group col-md-6">
				<label for="#">Unit</label>
				<input type="text" name="unit" class="form-control" id="editunit">
			</div>



			<div class="form-group col-md-6">
				<label for="#">Order Price</label>
				<input type="number" name="orderprice" class="form-control" id="editorderprice">
			</div>

      

      
      
			<div class="form-group col-md-6">
				<label for="#">Selling Price</label>
				<input type="number" name="sellingprice" class="form-control" id="editsellingprice">
			</div>


      
      
			<div class="form-group col-md-6">
				<label for="#">Batch Number</label>
				<input type="text" name="batchnumber" class="form-control" id="editbatchnumber">
			</div>

      
			<div class="form-group col-md-6">
				<label for="#">Expiry Date</label>
				<input type="date" name="expirydate" class="form-control" id="editexpirydate">
			</div>




      <div class="form-group col-md-6">
        <?php $vatstatus = DB::table('vat_configuration')->value('status')?>
        <label for="#">VAT</label>
				<select name="vat" class="form-control"   id="editvat" >
        <?php 
        $vats = DB::table('vat_statuses')->get();
        ?>
        <?php $__currentLoopData = $vats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($vat->code); ?>"><?php echo e($vat->code); ?> (<?php echo e($vat->status); ?>)</option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
			</div>

      <div class="col-md-12">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" style="float:right" id="submitEditDataBtn">Submit</button>


      </div>
    
  


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
		   <form action="delete-business-cartigory" method="post" id="deleteForm">
			<?php echo csrf_field(); ?>
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


    const data = <?php echo json_encode($data, 15, 512) ?>;
    console.log(data);

    const searchInput = document.getElementById('search-input');
    const searchResultsTable = document.getElementById('search-results');
    const searchResultsBody = document.getElementById('search-results-body');

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const searchResults = data.filter((product) => product.name.toLowerCase().includes(searchTerm));

        searchResultsBody.innerHTML = '';

        searchResults.forEach((product) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>
                    <form>
                        <input type="number" name="quantity" value="0">
                        <button type="submit">Submit</button>
                    </form>
                </td>
            `;
            searchResultsBody.appendChild(row);
        });

        if (searchResults.length > 0) {
            searchResultsTable.style.display = 'table';
        } else {
            searchResultsTable.style.display = 'none';
        }
    });


    


})

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


<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\PROJECTS\LARAVEL\Netacube\resources\views/wholesale/adminwholesalebranchproducts.blade.php ENDPATH**/ ?>