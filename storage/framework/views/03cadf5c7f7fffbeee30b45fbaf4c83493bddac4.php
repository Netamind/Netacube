
<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title>Document</title>
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
	</style>
</head>


<body>
  
<div class="loading-status" id="loading-status" style="display:none">
  <div class="waves"></div>
</div>


<div class="card" style="margin-top:-10px">

<div class="card-header">
<a href="#" style="font-size:20px;font-weight:bold"><i class="feather icon-grid"></i> Company data</a> 
<a href="#" class="" id="moreInfo" style="float:right"><i class="feather icon-info" style="font-size:20px;font-weight:bold"></i></a>
<span style="font-size:16px">Manage data displayed on your business documents and website.</span>
</div>

<div class="row card-block" >
<div class="col-md-12 col-lg-4" id="generaldiv">
<h6 class="sub-title">
<span style="color:gray;font-weight:bold">General</span>
<a href="#" style="float:right"  data-toggle="modal" data-target="#general-modal">
  <i class="feather icon-edit text-primary" style="font-size:20px;" ></i>
</a>    
<?php
$appName = DB::table('appdata')->value('appname');
$appLink = DB::table('appdata')->value('applink');
$appTitle = DB::table('appdata')->value('apptitle');
?>
</h6>
<ul class="basic-list">
<li class>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Company Name</strong></h6>
<p class="generaldiv"><?php echo e($appName); ?></p>
</li>
<li class>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Website (Domain)</strong></h6>
<p  class="generaldiv" ><?php echo e($appLink); ?></p>
</li>
<li class>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Website Title</strong></h6>
<p class="generaldiv"><?php echo e($appTitle); ?></p>
</li>
</ul>
</div>



<div class="col-md-12 col-lg-4" id="contactdiv">
<h6 class="sub-title"> 
<span style="color:gray;font-weight:bold">Contact</span>
<a href="#" style="float:right" data-toggle="modal" data-target="#contact-modal">
  <i class="feather icon-edit text-primary" style="font-size:20px;"></i>
</a>
</h6>
<?php
$appAddress = DB::table('appdata')->value('appaddress');
$appContact = DB::table('appdata')->value('appcontact');
$appEmail = DB::table('appdata')->value('appemail');
?>
<ul class="basic-list list-icons">
<li>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Address</strong></h6>
<p><?php echo e($appAddress); ?></p>
</li>
<li>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Contact</strong></h6>
<p><?php echo e($appContact); ?></p>
</li>
<li>
<h6 style="color:gray;font-weight:bold;font-size:17px"><strong>Email</strong></h6>
<p><?php echo e($appEmail); ?></p>
</li>
</ul>
</div>



<div class="col-md-12 col-lg-4">
<h6 class="sub-title">
<span style="color:gray;font-weight:bold">Documents</span> 
</h6>
<?php
$appLogo = DB::table('appdata')->value('applogo');
$appLetterhead = DB::table('appdata')->value('appletterhead');
$appTerms = DB::table('appdata')->value('appterms');
?>
<ul class="basic-list list-icons-img">

<li>
<h6>
<span style="color:gray;font-weight:bold;font-size:17px">Logo</span>
<a href="#" style="float:right" id="changelogobtn">
  <i class="feather icon-edit text-primary" style="font-size:20px"></i>
</a>
<input type="file" id="logoinput" accept="image/*" style="display: none;">
</h6>
<div id="logodiv">
<?php
  $logoFile = DB::table('appdata')->value('applogo')
?>
<a href="appdata/images/<?php echo e($logoFile); ?>" data-lightbox="1" data-title="Logo image">
<img src="appdata/images/<?php echo e($logoFile); ?>" class="img-fluid p-absolute d-block text-center" alt>
</a>
</div>
</li>


  
<li>
<h6>
<span style="color:gray;font-weight:bold;font-size:17px">Letter Head</span>
<a href="#" style="float:right" id="changeletterheadbtn">
  <i class="feather icon-edit text-primary" style="font-size:20px"></i>
</a>
<input type="file" id="letterheadinput" accept="image/*" style="display: none;">
</h6>
<div id="letterheaddiv">
<?php
  $letterheadFile = DB::table('appdata')->value('appletterhead')
?>
<a href="appdata/images/<?php echo e($letterheadFile); ?>" data-lightbox="1" data-title="Letter Head image">
<img src="appdata/images/<?php echo e($letterheadFile); ?>" class="img-fluid p-absolute d-block text-center" alt>
</a>
</div>
</li>

  
<li>
<h6>
<span style="color:gray;font-weight:bold;font-size:17px">Terms & Conditions</span>
<a href="#" style="float:right" id="changetermsbtn">
  <i class="feather icon-edit text-primary" style="font-size:20px"></i>
</a>   
</h6>
<div id="termsdiv">
<?php
  $termsFile = DB::table('appdata')->value('appterms')
?>
<a href="#" id="readTerms">
  <?php echo e($termsFile); ?>

</a>

</div>
</li>






</ul>
</div>
</div>
</div>

</div>
</div>
</div>





<div class="modal fade modal-flex" id="general-modal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title">General</h6>
<a href="#" style="float:right" class="close" data-dismiss="modal" aria-label="Close">&times;</a>
</div>
<div class="modal-body model-container" id="generalformdiv">
	
<form action="update-app-data-general" method="post" class="j-pro"  novalidate id="generalform">
<?php echo csrf_field(); ?>

<div class="j-content">

<div class="j-row">
<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Company Name</label>
<div class="j-input">
<label class="j-icon-left" >
<i class="feather icon-grid"></i>
</label>
<input type="text"  name="appname" placeholder="App Name" value="<?php echo e($appName); ?>" class="name-group">
</div>
</div>


<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Website</label>
<div class="j-input">
<label class="j-icon-left" for="last_name">
<i class="icofont icofont-globe"></i>
</label>
<input type="text" name="applink" placeholder="App Link"  value="<?php echo e($appLink); ?>" class="name-group">
</div>
</div>
</div>



<div class="j-row">
<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Title</label>
<div class="j-input">
<label class="j-icon-left" for="url">
<i class="icofont icofont-underline"></i>
</label>
<input type="text" name="apptitle" value="<?php echo e($appTitle); ?>" placeholder="App title">
</div>
</div>
</div>



</div>

<div class="j-footer">
<button class="btn btn-default border border-info"   data-dismiss="modal" aria-label="Close" style="float:left;">Cancel</button>
<button type="submit" class="btn btn-primary" id="generalUpdate">Update</button>
</div>



</form>
</div>
</div>
</div>
</div>







<div class="modal fade modal-flex" id="contact-modal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title">Contact</h6>
<a href="#" style="float:right" class="close" data-dismiss="modal" aria-label="Close">&times;</a>
</div>
<div class="modal-body model-container" id="contactformdiv">
	
<form action="update-app-data-contact" method="post" class="j-pro"  novalidate id="contactform">
<?php echo csrf_field(); ?>

<div class="j-content">

<div class="j-row">
<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Address</label>
<div class="j-input">
<label class="j-icon-left" >
<i class="feather icon-grid"></i>
</label>
<input type="text"  name="appaddress" placeholder="App Address" value="<?php echo e($appAddress); ?>" class="name-group">
</div>
</div>


<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Contact</label>
<div class="j-input">
<label class="j-icon-left" for="last_name">
<i class="icofont icofont-globe"></i>
</label>
<input type="text" name="appcontact" placeholder="App Contact"  value="<?php echo e($appContact); ?>" class="name-group">
</div>
</div>
</div>



<div class="j-row">
<div class="j-span12 j-unit">
<label for="" style="margin-bottom:5px">Email</label>
<div class="j-input">
<label class="j-icon-left" for="url">
<i class="icofont icofont-underline"></i>
</label>
<input type="text" name="appemail" value="<?php echo e($appEmail); ?>" placeholder="App email">
</div>
</div>
</div>



</div>

<div class="j-footer">
<button class="btn btn-default border border-info"   data-dismiss="modal" aria-label="Close" style="float:left;">Cancel</button>
<button type="submit" class="btn btn-primary" id="contactUpdate">Update</button>
</div>



</form>
</div>
</div>
</div>
</div>

<section decription="Modal for change app data logo">
<div class="modal modal-flex" tabindex="-1" role="dialog" id="changeLogoModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change logo</h5>
        <a href="#" style="float:right" class="closeLogoModal" style="font-size:200px" >X</a>
      </div>
      <div class="modal-body">  
          <div class="cropper-container">
          <img src=" " id ="logoImage" alt class="crop-img img-fluid img-responsive">
          </div>
      </div>
      <div class="modal-footer">
      <button class="btn btn-secondary closeLogoModal mr-auto" >Close</button>
      <button class="btn btn-primary" id="uploadLogoBtn" style="float:right">Submit</button>
      </div>
    </div>
  </div>
</div>
</section>




<section decription="Modal for change app data letterhead">
<div class="modal modal-flex" tabindex="-1" role="dialog" id="changeLetterheadModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Letterhead</h5>
        <a href="#" style="float:right" class="closeLetterheadModal" style="font-size:200px" >X</a>
      </div>
      <div class="modal-body">  
          <div class="cropper-container">
          <img src=" " id ="letterheadImage" alt class="crop-img img-fluid img-responsive">
          </div>
      </div>
      <div class="modal-footer">
      <button class="btn btn-secondary closeLetterheadModal mr-auto" >Close</button>
      <button class="btn btn-primary" id="uploadLetterheadBtn" style="float:right">Submit</button>
      </div>
    </div>
  </div>
</div>
</section>



<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="termsModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Employee Guide</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="update-app-data-terms" method="post"  enctype="multipart/form-data" id="termsform">
        <?php echo csrf_field(); ?>
          <div class="form-group">
           <label for="">Upload a pdf file</label>
           <input type="file" name="termspdf" class="form-control" accept = "application/pdf">
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="uploadTermsBtn">Submit</button>
       </form>
      </div>
    
    </div>
  </div>
</div>
</section>



<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="moreInfoModal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Company Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
        Easily update your app data to ensure consistency across all business documents 
        and your website. Simply click the edit icon next to the item you wish to modify
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</section>



<section decription="Modal for app data info">
<div class="modal fade-scale" tabindex="-1" role="dialog" id="readTermsModal" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Terms & Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <iframe src="appdata/files/<?php echo e($termsFile); ?>#toolbar=1&navpanes=1&scrollbar=1&page=0&view=FitH" frameborder="0" width="100%" height="500"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

  $(document).on("click", "#generalUpdate", function(e) {
  var self = $(this);
  $(this).prop("disabled", true);
  $(this).html('<div class="spinner"></div>');
  var form = document.getElementById("generalform");

  e.preventDefault(); 
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  $.ajax({
      type:"post",
      url: '/update-app-data-general',
      data: $(form).serialize(),
      success:function(data) {

        if(data == 2){
        toastr.success('Data updateed successifully','Success')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        $("#generaldiv").load(" #generaldiv  > *",function(){});
        $("#generalformdiv").load(" #generalformdiv  > *",function(){});
        }
        if(data == 4){
        toastr.success('Data inserted successifully','Success')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        $("#generaldiv").load(" #generaldiv  > *",function(){});
        $("#generalformdiv").load(" #generalformdiv  > *",function(){});
        }

        if(data == 1){
        toastr.error('An error occured probably no data change detected','Error')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        }
        
        if(data == 3){
        toastr.error('An known error occured during inserting data try again later','Error')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        }   
      },
      error:function(jqXHR, textStatus, errorThrown) {

        var errors = jqXHR.responseJSON.errors;
        var errorPassage = '';
        if(textStatus === 'timeout')
          {   
            toastr.error('It is taking longer to submit the data check your internet connection and try again','Timeout Error')  
            form.reset();
          }
          else{
          
            $.each(errors, function(key, value) {
                errorPassage += value + '\n';
            });
            toastr.error(errorPassage, 'Server Errors', {
                timeOut: 60000
            });
            self.text("Submit")
            self.prop("disabled", false)
            form.reset();
          
          
          
          }
      },
      timeout: 60000
  });

  })



  $(document).on("click", "#contactUpdate", function(e) {
  var self = $(this);
  $(this).prop("disabled", true);
  $(this).html('<div class="spinner"></div>');
  var form = document.getElementById("contactform");

  e.preventDefault(); 
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  $.ajax({
      type:"post",
      url: '/update-app-data-contact',
      data: $(form).serialize(),
      success:function(data) {

        if(data == 2){
        toastr.success('Data updateed successifully','Success')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        $("#contactdiv").load(" #contactdiv  > *",function(){});
        $("#contactformdiv").load(" #contactformdiv  > *",function(){});
        }
        if(data == 4){
        toastr.success('Data inserted successifully','Success')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        $("#contactdiv").load(" #contactdiv  > *",function(){});
        $("#contactformdiv").load(" #contactformdiv  > *",function(){});
        }

        if(data == 1){
        toastr.error('An error occured probably no data change detected','Error')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        }
        
        if(data == 3){
        toastr.error('An known error occured during inserting data try again later','Error')  
        self.text("Submit")
        self.prop("disabled", false)
        form.reset();
        }
        


  
        
      },
      error:function(jqXHR, textStatus, errorThrown) {

        var errors = jqXHR.responseJSON.errors;
        var errorPassage = '';
        if(textStatus === 'timeout')
          {   
            toastr.error('It is taking longer to submit the data check your internet connection and try again','Timeout Error')  
            form.reset();
          }
          else{
          
            $.each(errors, function(key, value) {
                errorPassage += value + '\n';
            });
            toastr.error(errorPassage, 'Server Errors', {
                timeOut: 60000
            });
            self.text("Submit")
            self.prop("disabled", false)
            form.reset();
          
          
          
          }
      },
      timeout: 60000
  });

  })

function countUnfilledInputs(inputIds) {
  return inputIds.filter(id => document.getElementById(id).value === '').length;
}


$(document).ready(function() {
  // Trigger file input click on button click
  $('#changelogobtn').click(function() {
    $('#logoinput').click();
  });

  // Handle file input change
  $('#logoinput').change(function(e) {
    var file = e.target.files[0];
    if (file.type.startsWith('image/')) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var imageData = event.target.result;
        $('#logoImage').attr('src', imageData);
         var image = $('#logoImage');
         image.cropper({
            viewMode: 1,
            dragMode: 'crop',
            autoCrop: true,
            zoomable: true,
            scalable: true,
            cropBoxMovable: true,
            cropBoxResizable: true,  
            dataUrl: function(original) {
                    var extension = original.src.split('.').pop();
                    return original.toDataURL('image/' + extension);
            }     
          });

        $('#changeLogoModal').modal('show');

      };

      reader.readAsDataURL(file);
    }
     $('#uploadLogoBtn').click(function() {
      var self = $(this);
      $(this).prop("disabled", true);
      $('#changeLogoModal').modal('hide');
     
      var image = $('#logoImage');
      var croppedCanvas = image.cropper('getCroppedCanvas');
      var imageData = croppedCanvas.toDataURL();
      var mimeType = imageData.split('/')[1].split(';')[0];
      var blob = dataURLtoBlob(imageData);
      var mimeType = blob.type;
      var formData = new FormData();
      formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
      formData.append('logoimage', blob);
      formData.append('mimeType', mimeType);

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'POST',
          url: '/update-app-data-logo',
          data: formData,
          processData: false,
          contentType: false,
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
            $("#logodiv").load(" #logodiv  > *",function(){});
            self.prop("disabled", false);
            $('#logoinput').val('')
                
               imageTargetCropper =  $('#logoImage');

                currentCropper = $('#logoImage').data('cropper');

                currentCropper.destroy();

                imageTargetCropper.data('cropper',null);
          
           },
          success: function(data) {
            if(data.status===201){
              toastr.success(data.success,'Success',{ timeOut : 5000})  
            }else if(data.status===422){
              toastr.error(data.error,'Error',{ timeOut : 5000})  
            }else{
              toastr.info('Success!','Success',{ timeOut : 5000})  
            }
          },
        error: function(xhr, status, error) {
        if (xhr.status === 0 && xhr.readyState === 0) {
            toastr.error('Timeout check your internet connect and try again','Timeout Error',{ timeOut : 5000})  
          } else if (xhr.status === 422) {
              var errorPassage = '';
              var errors = xhr.responseJSON.errors;
              $.each(errors, function(key, value) { errorPassage += value + '\n'});
              toastr.error(errorPassage, 'Validation Errors', {timeOut: 5000});
          } else if (xhr.status === 500) {
              var errorMessage = xhr.responseText;
              toastr.error('Internal server error occured try again later', 'Server Error', {timeOut: 5000});
          } else {
          toastr.error('Unspecified error occured try again later', 'Unspecified Error',{timeOut: 5000});
        }
          }  
        });
      });
   });
});
$(document).ready(function() {
  $('.closeLogoModal').on('click', function() {
        $('#logoinput').val('')
        imageTargetCropper =  $('#logoImage');
        currentCropper = $('#logoImage').data('cropper');
        currentCropper.destroy();
        imageTargetCropper.data('cropper',null);
    $('#changeLogoModal').modal('hide');
  });
});
function dataURLtoBlob(dataURL) {
    var byteString = atob(dataURL.split(',')[1]);
    var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    var arrayBuffer = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(arrayBuffer);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([arrayBuffer], { type: mimeString });
 } 


 $(document).ready(function() {
  $('#moreInfo').on('click', function() {
    $('#moreInfoModal').modal('show');
  });
});

//--------------------------------------------------------------------------------------------------------------------//

$(document).ready(function() {
  // Trigger file input click on button click
  $('#changeletterheadbtn').click(function() {
    $('#letterheadinput').click();
  });

  // Handle file input change
  $('#letterheadinput').change(function(e) {
    var file = e.target.files[0];
    if (file.type.startsWith('image/')) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var imageData = event.target.result;
        $('#letterheadImage').attr('src', imageData);
         var image = $('#letterheadImage');
         image.cropper({
            viewMode: 1,
            dragMode: 'crop',
            autoCrop: true,
            zoomable: true,
            scalable: true,
            cropBoxMovable: true,
            cropBoxResizable: true,  
            dataUrl: function(original) {
                    var extension = original.src.split('.').pop();
                    return original.toDataURL('image/' + extension);
            }     
          });

        $('#changeLetterheadModal').modal('show');

      };

      reader.readAsDataURL(file);
    }

     $('#uploadLetterheadBtn').click(function() {
      var self = $(this);
      $(this).prop("disabled", true);
      $('#changeLetterheadModal').modal('hide');
     
      var image = $('#letterheadImage');
      var croppedCanvas = image.cropper('getCroppedCanvas');
      var imageData = croppedCanvas.toDataURL();
      var mimeType = imageData.split('/')[1].split(';')[0];
      var blob = dataURLtoBlob(imageData);
      var mimeType = blob.type;
      var formData = new FormData();
      formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
      formData.append('letterheadimage', blob);
      formData.append('mimeType', mimeType);

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'POST',
          url: '/update-app-data-letterhead',
          data: formData,
          processData: false,
          contentType: false,
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
            $("#letterheaddiv").load(" #letterheaddiv  > *",function(){});
            self.prop("disabled", false);
            $('#letterheadinput').val('')
                
               imageTargetCropper =  $('#letterheadImage');

                currentCropper = $('#letterheadImage').data('cropper');

                currentCropper.destroy();

                imageTargetCropper.data('cropper',null);
          
           },
          success: function(data) {
            if(data.status===201){
              toastr.success(data.success,'Success',{ timeOut : 5000})  
            }else if(data.status===422){
              toastr.error(data.error,'Error',{ timeOut : 5000})  
            }else{
              toastr.info('Success!','Success',{ timeOut : 5000})  
            }
          },
        error: function(xhr, status, error) {
        if (xhr.status === 0 && xhr.readyState === 0) {
            toastr.error('Timeout check your internet connect and try again','Timeout Error',{ timeOut : 5000})  
          } else if (xhr.status === 422) {
              var errorPassage = '';
              var errors = xhr.responseJSON.errors;
              $.each(errors, function(key, value) { errorPassage += value + '\n'});
              toastr.error(errorPassage, 'Validation Errors', {timeOut: 5000});
          } else if (xhr.status === 500) {
              var errorMessage = xhr.responseText;
              toastr.error('Internal server error occured try again later', 'Server Error', {timeOut: 5000});
          } else {
          toastr.error('Unspecified error occured try again later', 'Unspecified Error',{timeOut: 5000});
        }
          }  
        });
      });
   });
});
$(document).ready(function() {
  $('.closeLetterheadModal').on('click', function() {
        $('#logoinput').val('')
        imageTargetCropper =  $('#letterheadImage');
        currentCropper = $('#letterheadImage').data('cropper');
        currentCropper.destroy();
        imageTargetCropper.data('cropper',null);
    $('#changeLetterheadModal').modal('hide');
  });
});
function dataURLtoBlob(dataURL) {
    var byteString = atob(dataURL.split(',')[1]);
    var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    var arrayBuffer = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(arrayBuffer);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([arrayBuffer], { type: mimeString });
 } 


 $(document).ready(function() {
  $('#moreInfo').on('click', function() {
    $('#moreInfoModal').modal('show');
  });
});

//--------------------------------------------------------------------------------------------------------------------//
$(document).ready(function() {
  $('#changetermsbtn').click(function() {
    $('#termsModal').modal('show');
  });
})


$('#uploadTermsBtn').click(function() {
      var self = $(this);
      $(this).prop("disabled", true);
      $('#termsModal').modal('hide');
      const formData = new FormData( $('#termsform')[0]  )
      //var form = document.getElementById("termsform");
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type:"post",
         url: '/update-app-data-terms',
         data: formData ,
         contentType: false,
         processData: false,
          timeout: 60000,
          beforeSend: function() {
            $('#loading-status').css('display', 'block');
          },
          complete: function() {
            $('#loading-status').css('display', 'none');
            $("#termsdiv").load(" #termsdiv  > *",function(){});
            self.prop("disabled", false);
            form.reset();
           },
          success: function(data) {
            if(data.status===201){
              toastr.success(data.success,'Success',{ timeOut : 5000})  
            }else if(data.status===422){
              toastr.error(data.error,'Error',{ timeOut : 5000})  
            }else{
              toastr.info('Success!','Success',{ timeOut : 5000})  
            }
          },
        error: function(xhr, status, error) {
        if (xhr.status === 0 && xhr.readyState === 0) {
            toastr.error('Timeout check your internet connect and try again','Timeout Error',{ timeOut : 5000})  
          } else if (xhr.status === 422) {
              var errorPassage = '';
              var errors = xhr.responseJSON.errors;
              $.each(errors, function(key, value) { errorPassage += value + '\n'});
              toastr.error(errorPassage, 'Validation Errors', {timeOut: 5000});
          } else if (xhr.status === 500) {
              var errorMessage = xhr.responseText;
              toastr.error('Internal server error occured try again later', 'Server Error', {timeOut: 5000});
          } else {
          toastr.error('Unspecified error occured try again later', 'Unspecified Error',{timeOut: 5000});
        }
          }  
        });
      });
   
     



  $(document).ready(function() {
  $('#readTerms').click(function() {
    $('#readTermsModal').modal('show');
  });
})


    lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
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


<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Netamind Technology\Desktop\Netacube\resources\views/admin/appdata.blade.php ENDPATH**/ ?>