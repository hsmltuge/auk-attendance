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
                                    <span class="text-uppercase text-primary">Attendance System | Token Management</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
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
                                                echo "<option value='{$u['EntryID']}'>{$u['CourseYear']} | {$u['CourseTitle']}</option>";
                                            }
                                        }?>
                                        </select>
                                    </div>
                                    <!--begin::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <input class="form-control h-auto py-7 px-6 rounded-lg border-1" name="date" type="date"
                                            autocomplete="off" placeholder="Lecture Date"/>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Action-->
                                    <div class="pb-lg-0 pb-5">
                                        <button type="submit" id="kt_register_form_submit_button"
                                                class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> Generate Token
                                        </button>
                                    </div>
                                    <!--end::Action-->
                                    </form>
                                </div>
                                <div class="col-md-8">
                                <?php
                            if(!empty($info)){
                                ?>
                                <table class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Year</th>
                                            <th>Students</th>
                                            <th>Tokens</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php
                                        $x=1;
                                        foreach($info as $i){
                                            $students = $db->select("SELECT EntryID FROM Students WHERE CourseID LIKE '{$i['EntryID']}'");
                                            $token = $db->select("SELECT EntryID FROM Tokens WHERE CourseID LIKE '{$i['EntryID']}'");
                                            ?>
                                                <tr title="Retired records will not be visible to the students">
                                                    <td><?=$x?></td>
                                                    <td><?=$i['CourseCode']?></td>
                                                    <td><?=$i['CourseTitle']?></td>
                                                    <td><?=$i['CourseYear']?></td>
                                                    <td><?=count($students)?></td>
                                                    <td><?=count($token)?></td>
                                                    <td><?=$i['Status'] === "1" ? "Active": "Retired"?></td>
                                                    <td><?=$i['CreatedOn']?></td>
                                                </tr>
                                            <?php
                                            $x++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }else{
                               echo $general->errors("warning","Sorry, there are no training available at the moment","NO TRAINING FOUND");
                            }
                            ?>
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
<script src="../js/token.js"></script>