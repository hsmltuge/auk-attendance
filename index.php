<?php
require_once "inc/header.php";
require_once "inc/nav.php";
$info = $db->select("SELECT * FROM Class WHERE Status LIKE 1 ORDER BY CourseTitle ASC");
?>
<div class="container mt-5 text-center">
    <div class="loginContainer">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="contact-form">
                <div class="card card-custom mt-15 mb-15">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title text-left">
                            <img src="assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
                                <div >
                                    <h1 class="text-uppercase text-primary">Al-qalam university, katsina</h1>
                                    <span class="text-uppercase text-primary">Attendance System | View Student Attendance</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="regNo"
                                            autocomplete="off" placeholder="Registration Number"/>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <div class="col-md-4">
                                    <!--begin::Action-->
                                    <div class="pb-lg-0 pb-5">
                                        <button type="submit" id="kt_register_form_submit_button"
                                                class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> View Attendance
                                        </button>
                                    </div>
                                    <!--end::Action-->
                                </div>
                            </div>
                            <div class="displayAttendance"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end div row -->
    </div>
</div>


<?php
require_once "inc/footer.php"
?>
<script>
    $(document).on("click",'#kt_register_form_submit_button', () => {
        const reg = $('input[name="regNo"]').val()
        if(reg === ""){
            $(".displayAttendance").html("Sorry, Reg number cannot be empty")
            return false
        }
        if((reg.match(new RegExp("/","g")) || []).length < 3 ){
            $(".displayAttendance").html("Sorry, Reg number pattern did not match")
            return false
        }
        $(".displayAttendance").html("Please wait system loading")
        $.post("php/myattendance.php",{reg},r => {
            $(".displayAttendance").html(r)
        })
    })
</script>