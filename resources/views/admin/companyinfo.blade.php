@extends('admin.dashboard')
@section('content')    

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

        
<div class="progress" id="progressBar" role="progressbar" aria-label="Animated striped" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 8px; transform: rotate(180deg);display:none">
<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
</div>

<div class="content-page">
<div class="content">
<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column">
<h4 class="page-title">Dashboard</h4>
<form class="d-flex mb-xxl-0 mb-2">
<div class="input-group">
<input type="text" class="form-control shadow border-0" id="dash-daterange">
<span class="input-group-text bg-primary border-primary text-white">
<i class="ri-calendar-todo-fill fs-13"></i>
</span>
</div>
<a href="javascript: void(0);" class="btn btn-primary ms-2">
<i class="ri-refresh-line"></i>
</a>
</form>
</div>
</div>
</div>
<!-- end page title -->


<div class="card">
<div class="card-header" style="margin-bottom: 0px; padding-bottom: 0px;">
<h4 class="header-title mb-1">
Company Info
<a href="#" class="float-end text-primary fs-16" id="companyInfoBtn"><i class="ri-information-line text-primary fs-18 align-middle me-1"></i></a>
</h4>
<p class="text-muted fs-15">Manage data displayed on your business documents and website.</p>
</div>
<div class="card-body"  style="margin-top: 0px; padding-top: 0px;">
<ul class="nav nav-pills bg-nav-pills nav-justified mb-3 mt-0">
    <li class="nav-item">
        <a href="#general" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-start rounded-0 active">
        <i class="ri-file-list-3-line fw-normal fs-18 align-middle me-1"></i>  
        General
        </a>
    </li>
    <li class="nav-item">
        <a href="#contact" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
            <i class="ri-contacts-book-line fw-normal fs-18 align-middle me-1"></i>  
            Contact
        </a>
    </li>
    <li class="nav-item">
        <a href="#documents" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-end rounded-0">
            <i class="ri-file-pdf-2-line fw-normal fs-18 align-middle me-1"></i>  
            Documents
        </a>
    </li>
        <li class="nav-item">
        <a href="#images" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-end rounded-0">
            <i class="ri-file-image-line fw-normal fs-18 align-middle me-1"></i>  
            Images
        </a>
    </li>
</ul>

<div class="tab-content">

<div class="tab-pane show active" id="general">

<?php  
$generalData = DB::table('companygeneral_info')->where('id',1)->first();
?>

<form class="form-horizontal" action="update-company-general-info" method="post" id="generalForm">
        @csrf
    <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">Business/Comapny name</label>
        <div class="col-9">
            <input type="text" class="form-control" name="business_name" value="{{optional($generalData)->business_name}}">
        </div>
    </div>
        <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">License Number</label>
        <div class="col-9">
            <input type="text" class="form-control" name="business_license_number" value="{{optional($generalData)->business_license_number}}" >
        </div>
    </div>

    <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">TIN Number</label>
        <div class="col-9">
            <input type="text" class="form-control" name="tin_number" value="{{optional($generalData)->tin_number}}">
        </div>
    </div>

    
    <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">Company Description</label>
        <div class="col-9">
            <textarea name="business_description" class="form-control">{{optional($generalData)->business_description}}</textarea>
        </div>
    </div>

    
    <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">Company Mission</label>
        <div class="col-9">
            <textarea name="business_mission" class="form-control">{{optional($generalData)->business_mission}}</textarea>
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="#" class="col-3 col-form-label">Company Vision</label>
        <div class="col-9">
             <textarea name="business_vision" class="form-control">{{optional($generalData)->business_vision}}</textarea>
        </div>
    </div>


    
    <div class="justify-content-end row">
        <div class="col-9 text-end">
            <button type="submit" class="btn btn-info" id="submitGeneralDataBtn">Update</button>
        </div>
    </div>
</form>   
</div>


<div class="tab-pane show " id="contact">
contact
</div>


<div class="tab-pane show " id="documents">
documents
</div>


<div class="tab-pane show " id="images">
images
</div>




</div> <!-- end tab content -->
</div> <!-- end card-body -->
</div> <!-- end card-->
</div> <!-- container -->
</div> <!-- content -->
</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- Start modal sections -->
<!-- ============================================================== -->

<section>
<!-- Modal -->
<div class="modal fade" id="companyInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Company info </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <p class="m-0">
                Easily update your company info to ensure consistency across all business documents 
                and your website. 
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
</section>



<!-- ============================================================== -->
<!-- End modal sections -->
<!-- ============================================================== -->





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

$("#companyInfoBtn").click(function() {
    $("#companyInfoModal").modal('show');
  });

  
   $('#submitGeneralDataBtn').click(function(e) {
    var self = $(this);
    $(this).prop("disabled", true);
    var form = document.getElementById("generalForm");
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: '/update-company-general-info',
        data: $(form).serialize(),
        timeout: 20000,
        beforeSend: function() {
            $('#progressBar').show();
        },
        complete: function() {
            $('#progressBar').hide();
            self.prop("disabled", false);
        },
        success: function(data) {
            if (data.status === 201) {
                toastr.success(data.success, 'Success', {
                    timeOut: 10000,
                    progressBar: true
                });
                //form.reset();
            } else {
                toastr.info('Success!', 'Success', {
                    timeOut: 10000,
                    progressBar: true
                });
                //form.reset();
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 0 && xhr.readyState === 0) {
                toastr.error('Timeout check your internet connect and try again', 'Timeout Error', {
                    timeOut: 10000,
                    progressBar: true
                })
            } else if (xhr.status === 422) {
                var errorPassage = '';
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    errorPassage += value + '\n'
                });
                toastr.error(errorPassage, 'Validation Errors', {
                    timeOut: 10000,
                    progressBar: true
                });
            } else if (xhr.status === 500) {
                var errorMessage = 'Internal server error occured.' //+ xhr.responseText;
                toastr.error(errorMessage, 'Server Error', {
                    timeOut: 10000,
                    progressBar: true
                });
            } else {
                toastr.error('Unspecified error occured try again later', 'Unspecified Error', {
                    timeOut: 10000,
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








@endsection