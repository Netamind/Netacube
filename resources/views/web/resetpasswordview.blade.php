<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Netacube - The ultimate business management system</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!--favicon-->
	    <link rel="icon" href="system/images/icon1.png" type="image/x-icon">

        <!-- Theme Config Js -->
        <script src="jidox/assets/js/config.js"></script>

        <!-- App css -->
        <link href="jidox/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Remixicons  -->
        <link href="jidox/assets/remixicons/remixicon.css" rel="stylesheet" type="text/css" />

        <style>
                    .loading-status {
        top: 0;
        left: 0;
        width: 100%;
        height: 8px;
        background-color: #f7f7f7;
        z-index: 1000;
        overflow: hidden;
        position: fixed;
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
            transform: translateX(0);
        }
        100% {
            transform: translateX(40px);
        }
        }

         
	</style>
    </head>
        


    <body class="authentication-bg">

       
        <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
            <svg xmlns="#" version="1.1" xmlns:xlink="#" xmlns:svgjs="#" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1920 1024">
                <g mask="url(&quot;#SvgjsMask1046&quot;)" fill="none">
                    <rect width="1920" height="1024" x="0" y="0" fill="url(#SvgjsLinearGradient1047)"></rect>
                    <path d="M1920 0L1864.16 0L1920 132.5z" fill="rgba(255, 255, 255, .1)"></path>
                    <path d="M1864.16 0L1920 132.5L1920 298.4L1038.6100000000001 0z" fill="rgba(255, 255, 255, .075)"></path>
                    <path d="M1038.6100000000001 0L1920 298.4L1920 379.53999999999996L857.7000000000002 0z" fill="rgba(255, 255, 255, .05)"></path>
                    <path d="M857.7 0L1920 379.53999999999996L1920 678.01L514.57 0z" fill="rgba(255, 255, 255, .025)"></path>
                    <path d="M0 1024L939.18 1024L0 780.91z" fill="rgba(0, 0, 0, .1)"></path>
                    <path d="M0 780.91L939.18 1024L1259.96 1024L0 585.71z" fill="rgba(0, 0, 0, .075)"></path>
                    <path d="M0 585.71L1259.96 1024L1426.79 1024L0 408.19000000000005z" fill="rgba(0, 0, 0, .05)"></path>
                    <path d="M0 408.19000000000005L1426.79 1024L1519.6599999999999 1024L0 404.09000000000003z" fill="rgba(0, 0, 0, .025)"></path>
                </g>
                <defs>
                    <mask id="SvgjsMask1046">
                        <rect width="1920" height="1024" fill="#ffffff"></rect>
                    </mask>
                    <linearGradient x1="11.67%" y1="-21.87%" x2="88.33%" y2="121.88%" gradientUnits="userSpaceOnUse" id="SvgjsLinearGradient1047">
                        <stop stop-color="#0e2a47" offset="0"></stop>
                        <stop stop-color="#00459e" offset="1"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </div>

         
           
    <div class="progress" id="progressBar" role="progressbar" aria-label="Animated striped" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 8px; transform: rotate(180deg);display:none">
    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
    </div>


        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-4 text-center">
                                <div class="auth-brand mb-0">
                                    <a href="#" class="logo-dark">
                                    <img src="system/images/netacube1.png" alt="" style="height:52px">
                                    </a>
                                </div>
                            </div>

                             <div class="text-center  ">
                                    <h4 class="text-dark-50 text-center mt-0">Reset password</h4>
                                    <p class="text-muted ">Fill this form to reset your password</p>
                                </div>
                            <div class="card-body">
                            	<form action="#" method="post" id="newDataForm">
                                   @csrf
                                    <input type="hidden" name="token" value="{{ request('token') }}">
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Enter  new password</label>
                                    	<input type="password"  name="password" class="form-control" placeholder="Enter new password" autocomplete="off" />
                                    </div>

                                      <div class="mb-3">
                                        <label for="comfirmpassword" class="form-label">Confirm new password</label>
                                     	<input type="password"  name="password_confirmation" class="form-control" autocomplete="off" placeholder="Re-enter the new password" />
                                    </div>
                        
                                    <button class="btn btn-primary form-control mt-2 mb-2" type="submit"  id="submitDataBtn">Reset Password</button>
                        
                                    <a href="/" class="btn btn-light form-control mt-3 mb-2"><i class="ri-arrow-left-line"></i> Back to login</a>
                                
                                    			
                                </form>
                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <span class="text-white-50"><script>document.write(new Date().getFullYear())</script> © Netamind Technology</span>
        </footer>
        <!-- Vendor js -->
        <script src="jidox/assets/js/vendor.min.js"></script>
        
        <!-- App js -->
        <script src="jidox/assets/js/app.min.js"></script>

	
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

        $('#submitDataBtn').click(function(e) {
            var self = $(this);
            $(this).prop("disabled", true);
            var form = document.getElementById("newDataForm");
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '/reset-password',
                data: $(form).serialize(),
                timeout: 60000,
                beforeSend: function() {
                     $('#progressBar').show();
                },
                complete: function() {
                     $('#progressBar').hide();
                    $("#tbody").load(" #tbody > *", function() {});
                    self.prop("disabled", false);
                },
                success: function(data) {
                    if (data.status === 201) {
                        toastr.success(data.success, 'Success', {
                            timeOut: 10000,
                            progressBar: true
                        });
                    } else if (data.status === 400) {
                        toastr.error(data.error, 'Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    } else {
                        toastr.error('Unspecified error occurred try again later', 'Unspecified Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 0 && xhr.readyState === 0) {
                        toastr.error('Timeout check your internet connection and try again', 'Timeout Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    } else if (xhr.status === 422) {
                        var errorPassage = '';
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $.each(value, function(index, message) {
                                errorPassage += message + '\n';
                            });
                        });
                        toastr.error(errorPassage, 'Validation Errors', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    } else if (xhr.status === 400) {
                        toastr.error(xhr.responseJSON.error, 'Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    } else if (xhr.status === 500) {
                        toastr.error('Internal server error occurred try again later', 'Server Error', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    } else {
                        toastr.error('Unspecified error occurred try again later', 'Unspecified Error', {
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
