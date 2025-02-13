<!DOCTYPE html>
<html lang="en">
<head>
<title>Netacube - Business management system</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">

<meta name="author" content="#">

<link rel="icon" href="system/images/icon.png" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/bootstrap/dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/icofont/css/icofont.css">

<link rel="stylesheet" type="text/css" href="dashboard/files/assets/css/style.css">


<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/feather/css/feather.css">

<style>

:root {
    --input-padding-x: 1rem;
    --input-padding-y: .5rem;
    --placeholder-color: #6c757d;
    --top-position: 14px;
    --label-z-index: 5;
    --input-background-color: #ffffff;
    --top-position-in-border: 5px;
    --outline-border-color: #80bdff;
    --top-position-outline: -8px;
    --normal-border-color: #ced4da;
    --outline-border-size: .125rem;
    --outline-animation-duration: .3s;
    --outline-transition-type: linear;
}
.form-label-group {
    position: relative;
    margin-bottom: 1rem;
}
.form-label-group label {
    margin: 0;
    pointer-events: none;
}

.form-label-group input,
.form-label-group textarea,
.form-label-group label,
.form-label-group:not(.in-border).form-label-group:not(.outline) select {
    padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group label {
    position: absolute;
    top: 50%;
    left: 0;
    display: block;
    width: 100%;
    margin-bottom: 0; /* Override default `<label>` margin */
    color: var(--placeholder-color);
    border-radius: .25rem;
    transition: all .2s ease-in-out;
    transform-origin: 0 0;
    transform: translateY(-50%);
    text-align: left;/* 
    visibility: hidden; */
    z-index: var(--label-z-index);
}
.form-label-group.form-control {
    padding:0;
}
.form-label-group.form-control input {
    border: none;
    height: 99%;
}
.form-label-group textarea ~ label {
    top: 0px;
    transform: translateY(0);
}

.form-label-group.transparent input::-webkit-input-placeholder {
    color: transparent;
}

.form-label-group.transparent input:-ms-input-placeholder {
    color: transparent;
}

.form-label-group.transparent input::-ms-input-placeholder {
    color: transparent;
}

.form-label-group.transparent input::-moz-placeholder {
    color: transparent;
}

.form-label-group.transparent input::placeholder, .form-label-group.transparent textarea::placeholder {
    color: transparent;
}

.form-label-group input:not(:placeholder-shown), .form-label-group input:focus, .form-label-group textarea:not(:placeholder-shown), .form-label-group textarea:focus {
    padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
    padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group:not(.in-border).form-label-group:not(.outline) select {
    padding-bottom: 0;
}

.form-label-group input:not(:placeholder-shown) ~ label, .form-label-group input:focus ~ label, .form-label-group textarea:not(:placeholder-shown) ~ label, .form-label-group textarea:focus ~ label, .form-label-group select ~ label {
    font-size: 1em;
    top: var(--top-position);
    transform: translateY(-50%) scale(.7);
    visibility: visible;
}
.form-label-group input.form-control-lg:not(:placeholder-shown) ~ label, .form-label-group input.form-control-lg:focus ~ label{
    top: calc(2px + var(--top-position));
}
.form-label-group input.form-control-sm:not(:placeholder-shown) ~ label, .form-label-group input.form-control-sm:focus ~ label{
    top: calc(2px - var(--top-position));
}
.form-label-group input:focus::placeholder, .form-label-group textarea:focus::placeholder {
    visibility: hidden;
    color: rgba(255, 255, 255, 0);
    transition-delay: 0s;
    opacity: 0;
    text-shadow: none;
}



.form-label-group input::placeholder, .form-label-group textarea::placeholder {
    transition-delay: .2s;
    color: rgba(255, 255, 255, 0);
    opacity: 0;
}

.form-label-group .intl-tel-input label, .form-label-group .iti label {
    margin-left: 42px;
}

.form-label-group .intl-tel-input input:focus::placeholder, .form-label-group .iti input:focus::placeholder{
    visibility: visible;
    color: var(--placeholder-color);
    opacity: 1;
}


/* In Border */

.form-label-group.in-border label {
    width: auto;
    /* left: .6rem; */
}

.form-label-group.in-border input:focus, .form-label-group.in-border textarea:focus, .form-label-group.in-border select:focus {

    box-shadow: none;
}

.form-label-group.in-border input:not(:placeholder-shown) ~ label, .form-label-group.in-border input:focus ~ label, .form-label-group.in-border textarea:not(:placeholder-shown) ~ label, .form-label-group.in-border textarea:focus ~ label, .form-label-group.in-border select ~ label {
    left: calc(var(--input-padding-x)/10);
    top: var(--top-position-in-border);
    height: auto;
}

.form-label-group.in-border input:not(:placeholder-shown) ~ label::after, .form-label-group.in-border input:focus ~ label::after, .form-label-group.in-border textarea:not(:placeholder-shown) ~ label::after, .form-label-group.in-border textarea:focus ~ label::after, .form-label-group.in-border select ~ label::after {
    visibility: visible;
    transition: all .2s ease;
}

.form-label-group.in-border label::after{
    content: " ";
    display: block;
    position: absolute;
    background: var(--input-background-color);
    height: 4px;
    top: 50%;
    left: .7em;
    right: .7em;
    z-index: -1;
    visibility: hidden;
}

.form-label-group.in-border input,
.form-label-group.in-border label {
    
    padding: var(--input-padding-y) var(--input-padding-x);
    
}


.form-label-group.in-border textarea,
.form-label-group.in-border textarea ~ label {
    padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group.in-border input,
.form-label-group.in-border textarea, 
.form-label-group.in-border label,
.form-label-group.in-border select {
    transition: all .2s linear, border-color .5s ease-in-out,box-shadow .5s ease-in-out;
}


.form-label-group.in-border .intl-tel-input input:not(:placeholder-shown) ~ label, .form-label-group.in-border .intl-tel-input input:focus ~ label, .form-label-group.in-border .iti input:not(:placeholder-shown) ~ label, .form-label-group.in-border .iti input:focus ~ label {
    margin-left: 0px;
}

.form-label-group.iti-right .iti__flag-container {
    right: 0;
    left: auto;
}

.form-label-group.iti-right .iti--allow-dropdown input, .form-label-group.in-border.iti-right .iti--allow-dropdown input[type="tel"], .iti--allow-dropdown input[type="text"], .form-label-group.iti-right .iti--separate-dial-code input, .form-label-group.iti-right .iti--separate-dial-code input[type="tel"], .form-label-group.iti-right .iti--separate-dial-code input[type="text"] {
    padding-left: var(--input-padding-x);
}

.form-label-group.iti-right .intl-tel-input label, .form-label-group.iti-right .iti label {
    margin-left: 0;
}

.form-label-group.iti-right .iti__country-list {
    right: 0px;
}

.form-label-group .iti__country-list {
    z-index: calc(var(--label-z-index) + 2) !important;
}



/* Outline */

.form-label-group.outline span {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    width: 100%;
    margin-bottom: 0; /* Override default `<label>` margin */
    color: var(--placeholder-color);
    border-radius: .25rem;
    transition: all .2s var(--outline-transition-type);
    transform-origin: 0 0;
    /* transform: translateY(-50%); */
    text-align: left;/* 
    visibility: hidden; */
    z-index: var(--label-z-index);
    height: 100%;
    flex-wrap: wrap;
    pointer-events: none;
}

.form-label-group.outline input.border-danger ~ span{
    --normal-border-color: var(--danger, #dc3545);
}
.form-label-group.outline input.border-primary ~ span {
    --normal-border-color: var(--primary, #007bff);
}
.form-label-group.outline input.border-secondary ~ span {
    --normal-border-color: var(--secondary, #6c757d);
}
.form-label-group.outline input.border-success ~ span {
    --normal-border-color: var(--success, #28a745);
}
.form-label-group.outline input.border-info ~ span {
    --normal-border-color: var(--info, #17a2b8);
}
.form-label-group.outline input.border-warning ~ span {
    --normal-border-color: var(--warning, #ffc107);
}
.form-label-group.outline input.border-light ~ span {
    --normal-border-color: var(--light, #f8f9fa);
}
.form-label-group.outline input.border-dark ~ span {
    --normal-border-color: var(--dark, #343a40);
}
.form-label-group.outline input.border-white ~ span{
    --normal-border-color: var(--white, ##fff);
}


.form-label-group.outline input:focus, .form-label-group.outline textarea:focus, .form-label-group.outline select:focus {
    box-shadow: none;
}

.form-label-group.outline input:not(:placeholder-shown) ~ span, .form-label-group.outline input:focus ~ span, .form-label-group.outline textarea:not(:placeholder-shown) ~ span, .form-label-group.outline textarea:focus ~ span, .form-label-group.outline select ~ span {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    width: 100%;
    margin-bottom: 0; /* Override default `<label>` margin */
    color: var(--placeholder-color);
    border-radius: .25rem;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
    transform-origin: 0 0;
    /* transform: translateY(-50%); */
    text-align: left;/* 
    visibility: hidden; */
    z-index: var(--label-z-index);
    height: 100%;
    flex-wrap: wrap;
}

.form-label-group.outline input ~ span::after, .form-label-group.outline input ~ span::after, .form-label-group.outline textarea ~ span::after, .form-label-group.outline textarea ~ span::after, .form-label-group.outline select ~ span::after {
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
    content: " ";
    /* width: 1px;*/
    width: 1px; 
    flex: 1 0 auto;
    border: var(--outline-border-size) solid var(--normal-border-color);
    border-left: none;
    position: relative;
    right: 0px;
    height: 100%;
    visibility: hidden;
    border-radius: 0 .25rem .25rem 0;
    flex-grow: 1;
    flex-basis: 0;
    max-width: 1px;
}

.form-label-group.outline input:not(:placeholder-shown) ~ span::after, .form-label-group.outline input:focus ~ span::after, .form-label-group.outline textarea:not(:placeholder-shown) ~ span::after, .form-label-group.outline textarea:focus ~ span::after, .form-label-group.outline select ~ span::after {
    height: 100%;
    border: 1px solid var(--normal-border-color);
    border-left: none;
    content: " ";
    display: block;
    position: relative;
    background: transparent;
    /* top: 0px;
    right: 0px; */
    z-index: -1;
    border-radius: 0 .25rem .25rem 0;
    width: 100%;
    max-width: 100%;
    flex-grow: 1;
    flex-basis: 0;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
    visibility: visible;
}
.form-label-group.outline input:not(:placeholder-shown) ~ span::before, .form-label-group.outline input:focus ~ span::before, .form-label-group.outline textarea:not(:placeholder-shown) ~ span::before, .form-label-group.outline textarea:focus ~ span::before, .form-label-group.outline select ~ span::before {
    height: 100%;
    border: 1px solid var(--normal-border-color);
    border-right: none;
    content: " ";
    display: block;
    position: relative;
    background: transparent;
    top: 0px;
    left: 0px;
    z-index: -1;
    border-radius: .25rem 0 0 .25rem;
    width: 100%;
    flex: 0 0 9px;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
}

.form-label-group.outline label {
    position: relative;
    top: 50%;
    left: 0;
    display: block;
    width: auto;
    margin-bottom: 0;
    color: var(--placeholder-color);
    border-radius: .25rem;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
    /* transform: translateY(-50%); */
    text-align: left;
    /* visibility: hidden; */
    z-index: var(--label-z-index);
    flex-grow: 1;
    flex-basis: 0;
    max-width: 100%;
    flex: 0 0 auto;
    margin-right: auto;
}

.form-label-group.outline input:not(:placeholder-shown) ~ span label, .form-label-group.outline input:focus ~ span label, .form-label-group.outline textarea:not(:placeholder-shown) ~ span label, .form-label-group.outline textarea:focus ~ span label, .form-label-group.outline select ~ span label {
    transform: none;
    top: var(--top-position-outline);
    font-size: .6rem;
    padding: var(--input-padding-y) calc(var(--input-padding-x)/3);
    padding-top: 0;
    color: var(--placeholder-color);
    margin: 0;
    margin-right: auto;
    /* padding-bottom: 0; */
    /* height: fit-content; */
    
}

.form-label-group.outline input:not(:placeholder-shown ), .form-label-group.outline input:focus , .form-label-group.outline textarea:not(:placeholder-shown) , .form-label-group.outline textarea:focus , .form-label-group.outline select {
    border-top-color: transparent !important;
    border-bottom-color: var(--normal-border-color);
    border-bottom-width: 1px;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
}

.form-label-group.outline input,
.form-label-group.outline textarea, 
.form-label-group.outline label,
.form-label-group.outline select {
    background-color: transparent;
    transition: all var(--outline-animation-duration) var(--outline-transition-type);
}

.form-label-group.outline select ~ span::after, .form-label-group.outline select ~ span::before{
    border-color: var(--normal-border-color);
}

.form-label-group.outline input, .form-label-group.outline label {
    padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group.outline select {
    border-bottom-color: var(--normal-border-color);
}

.form-label-group.outline select ~ span label {
    color: var(--placeholder-color);
}

.form-label-group.outline.border-danger {
    --outline-border-color: var(--danger, #dc3545);
}
.form-label-group.outline.border-primary {
    --outline-border-color: var(--primary, #007bff);
}
.form-label-group.outline.border-secondary {
    --outline-border-color: var(--secondary, #6c757d);
}
.form-label-group.outline.border-success {
    --outline-border-color: var(--success, #28a745);
}
.form-label-group.outline.border-info {
    --outline-border-color: var(--info, #17a2b8);
}
.form-label-group.outline.border-warning {
    --outline-border-color: var(--warning, #ffc107);
}
.form-label-group.outline.border-light {
    --outline-border-color: var(--light, #f8f9fa);
}
.form-label-group.outline.border-dark {
    --outline-border-color: var(--dark, #343a40);
}
.form-label-group.outline.border-white {
    --outline-border-color: var(--white, #fff);
}

.form-label-group.outline input:focus ~ span::before,  .form-label-group.outline textarea:focus ~ span::before, .form-label-group.outline input:focus ~ span::after,  .form-label-group.outline textarea:focus ~ span::after, .form-label-group.outline select:focus ~ span::after, .form-label-group.outline select:focus ~ span::before, .form-label-group.outline select:focus ~ span label{
    border-color: var(--outline-border-color);
    color: var(--outline-border-color) !important;
    border-width: var(--outline-border-size);

    transition: all var(--outline-animation-duration) var(--outline-transition-type);
}
.form-label-group.outline select:focus, .form-label-group.outline input:focus, .form-label-group.outline textarea:focus {
    border-bottom-color: var(--outline-border-color) !important;
    border-bottom-width: var(--outline-border-size);
    transition: all .2s var(--outline-transition-type);
}

 .form-label-group.outline input:focus ~ span label, .form-label-group.outline textarea:focus ~ span label, .form-label-group.outline select:focus ~ span label {
    color: var(--outline-border-color) !important;
}


</style>



</head>
<body class="fix-menu">

<div class="theme-loader">
<div class="ball-scale">
<div class="contain">
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
</div>
</div>
</div>

<section class="login-block">

<div class="container">
<div class="row">
<div class="col-sm-12">


<div class="text-center">
<img src="system/images/netacube.png" alt="" style="height:70px">
</div>
<div class="auth-box card">
<div class="card-block">
<div class="row m-b-20">
<div class="col-md-12">
    <?php
    $companyNeme = DB::table('appdata')->value('appname');
    ?>
<h4 class="text-center text-secondary" style="padding-top:10px">
   <span style="text-transform:uppercase"><?php echo e($companyNeme); ?></span>
</h4>
</div>
</div>


<form action="user-authentication" method="post" id="loginForm">
 <?php echo csrf_field(); ?>

<div class="form-label-group">
    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" style="height:50px"/>
    <label for="email" style="font-size:17px">Email address</label>
</div>

<div class="form-label-group">
    <input type="text" id="password" autocomplete="off"  class="form-control" placeholder="Password2" style="height:50px"/>
    <label for="password" style="font-size:17px">Password</label>
</div>

<input type="hidden" id="password-actual" name="password">



<div class="row m-t-30">
<div class="col-md-12">
<button  class="btn btn-primary btn-md btn-block  text-center m-b-20" ><i class="feather icon-lock"></i>Login</button>
</div>
</div>



<div class="row m-t-8 text-left">
<div class="col-12">



<div class="forgot-phone text-left f-left">
<a href="#" class="text-right f-w-600" id="cancel-btn" style="font-weight: normal">Cancel</a>
</div>


<div class="forgot-phone text-right f-right">
<a href="#" class="text-right f-w-600" style="font-weight: normal">Forgot password?</a>
</div>



</div>
</div>




</form>

<hr/>
<div class="row">
<div class="col-md-12">
    <p class="text-inverse text-center" style="padding-top:10px">
        <a href="#"> Contact support <i class="feather icon-message"></i> <i class="fa fa-paper-plane text-primary"></i> </a>
       
    </p>
</div>
</div>



</div>
</div>

</div>

</div>

<div class="row">
<!--<div class="col-md-12">
    <p class="text-inverse text-center text-info" style="padding-top:20px">
    Developed by   <a href="https://netamind.com/" class="text-primary"><i>Netamind Technology</i></a>
    </p>
</div>-->
</div>

</div>



</section>


<script type="text/javascript" src="dashboard/files/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/modernizr/modernizr.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/i18next/i18next.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
<script type="text/javascript" src="dashboard/files/assets/js/common-pages.js"></script>

<script>
const passwordInput = document.getElementById('password');
const passwordActualInput = document.getElementById('password-actual');
let actualPasswordValue = '';

passwordInput.addEventListener('input', (e) => {
  actualPasswordValue += e.data;
  const maskedValue = '*'.repeat(actualPasswordValue.length);
  e.target.value = maskedValue;
  passwordActualInput.value = actualPasswordValue;
});

passwordInput.addEventListener('keydown', (e) => {
  if (e.key === 'Backspace') {
    actualPasswordValue = actualPasswordValue.slice(0, -1);
    const maskedValue = '*'.repeat(actualPasswordValue.length);
    e.target.value = maskedValue;
    passwordActualInput.value = actualPasswordValue;
  }
});
</script>



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
            toastr.error( "<?php echo e(Session::get('message')); ?>");
            break;
    }
  <?php endif; ?>
</script>
<!--js toastr notification--> 




</body>
</html><?php /**PATH C:\Users\dell\Desktop\Netacube\resources\views/web/login.blade.php ENDPATH**/ ?>