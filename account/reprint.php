<?php
require_once "inc/header.php";
if($input->get("retire")){
    $id = $general->decrypt($input->get("retire"));
    $db->query("UPDATE Class SET Status = '0' WHERE EntryID LIKE '{$id}'");
}
require_once "inc/nav.php";
$id = $general->decrypt($input->session("UserLoggedIn"));
$info = $db->select("SELECT * FROM Class WHERE CreatedBy LIKE '{$id}' ORDER BY Status DESC");

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
                                    <span class="text-uppercase text-primary">Attendance System | Re-Print Attendance Token</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                <form class="form" id="kt_register_form" method="post" action="../php/token.php" autocomplete="off">
                                     <!--begin::Form group-->
                                     <div class="form-group">
                                        <select name="programmes" data-live-search="true" id="class" class="form-control  h-auto py-7 px-6 rounded-lg border-1">
                                        <option value=''>Select course </option>
                                        <?php
                                        if (!empty($info)) {
                                            foreach ($info as $u) {
                                                if($u["Status"] !== "1"){
                                                    continue;
                                                }
                                                echo "<option value='{$general->encrypt($u['EntryID'])}'>{$u['CourseYear']} | {$u['CourseTitle']}</option>";
                                            }
                                        }?>
                                        </select>
                                    </div>
                                    <div class="responseDiv"></div>
                                    <!--begin::Form group-->
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
<script >
    $("select[name='programmes']").change(e => {
        const course = $(e.target).val();
        if(course !== ""){
            $(".responseDiv").html("Please wait system is loading")
            $.get("template_reprint.php?i="+course,(r) => {
                $(".responseDiv").html(r)
            })
        }else{
            $(".responseDiv").html("")
        }
    })
</script>