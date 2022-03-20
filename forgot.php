<?php
require_once "inc/header.php";
require_once "inc/nav.php";
?>

<div class="container mt-5 text-center">
    <div class="loginContainer">
        <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="contact-form">
                <div class="card card-custom mt-15 mb-15">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title text-left">
                                <img src="assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
                                <div >
                                    <h1 class="text-uppercase text-primary">Al-qalam university, katsina</h1>
                                    <span class="text-uppercase text-primary">Attendance System | Forgot password form</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        <form class="card-body form" autocomplete="off" id="kt_login_signup_form" method="post" action="php/forgot.php" autocomplete="off">
                        
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="emailaddress"
                                   autocomplete="off" placeholder="Email Address"/>
                        </div>
                        <!--end::Form group-->
						
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_singin_button"
                                    class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> Recover Password
                            </button>
                            <a href="login.php">Sign In</a> ::
                            <a href="register.php">Create Account</a> ::
                            <a href="activate.php">Activate Account Link</a>
                        </div>
                        <!--end::Action-->
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end div row -->
    </div>
</div>
<?php require_once("inc/footer.php")?>
<script src="js/forgot.js"></script>