<?php
require_once "inc/header.php";
if($input->get("retire")){
    $id = $general->decrypt($input->get("retire"));
    $db->query("UPDATE Class SET Status = '0' WHERE EntryID LIKE '{$id}'");
}
require_once "inc/nav.php";
$id = $general->decrypt($input->session("UserLoggedIn"));
$info = $db->select("SELECT * FROM Class WHERE CreatedBy LIKE '{$id}' AND Status LIKE 1 ORDER BY Status DESC");

?>
<div class="container mt-5 text-center">
    <div class="loginContainer">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="contact-form">
                <div class="card card-custom mt-15 mb-15">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title text-left">
                                <img src="../assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
                                <div >
                                    <h1 class="text-uppercase text-primary">Al-qalam university, katsina</h1>
                                    <span class="text-uppercase text-primary">Attendance System | Who Used Attendance Token</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php require_once "inc/subreport.php"?>                           
                                <form class="form" id="kt_register_form" method="post" action="semester_report.php" autocomplete="off">
                                <p>Please Note: The system will automatically add the dashes for your token, just continue writing the token after you have selected your course</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <select name="course" requried data-live-search="true" id="class" class="form-control  h-auto py-7 px-6 rounded-lg border-1">
                                            <option value=''>Select course </option>
                                            <?php
                                            if (!empty($info)) {
                                                foreach ($info as $u) {
                                                    echo "<option value='{$general->encrypt($u['EntryID'])}'>{$u['CourseYear']} | {$u['CourseTitle']}</option>";
                                                }
                                            }?>
                                            </select>
                                        </div>
                                        <!--End::Form group-->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="token"
                                                    autocomplete="off" placeholder="Enter your attendance token"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!--begin::Action-->
                                        <div class="pb-lg-0 pb-5">
                                            <button type="submit" id="kt_register_form_submit_button"
                                                    class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> Save
                                            </button>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                </div>   
                                
                                    
                                    
                                </form>
                                </div>                            
                            </div>
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
    $(document).on("keyup","input[name='token']",(e) => {
        var foo = $(e.target).val().split("-").join(""); // remove hyphens
        if (foo.length > 0) {
            foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
        }
        $(e.target).val(foo.toUpperCase());
    });
    $(document).on("submit","#kt_register_form",e => {
        e.preventDefault()
        $.post("../php/auth.php", $(e.target).serializeArray() ,r => {
            Swal.fire({
                text: r.msg,
                icon: r.type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
        })
    })
</script>