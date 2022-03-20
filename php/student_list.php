<?php
require_once "../classes/init.php";

if(!$input->get("i")){
    echo "Sorry system is experiencing some technical issues";
    exit;
}
$id = base64_decode($input->get("i"));
$info = $db->select("SELECT * FROM Students WHERE CourseID LIKE '{$id}' ORDER BY FullName");
?>
 <form class="form" id="kt_register_form" method="post"  autocomplete="off">
        <!--begin::Form group-->
        <div class="form-group">
            <select name="student" data-live-search="true" id="class" class="form-control  h-auto py-7 px-6 rounded-lg border-1">
            <option value=''>Select Your name </option>
            <?php
            if (!empty($info)) {
                foreach ($info as $u) {
                    $name = strtoupper($u['FullName']);
                    echo "<option value='{$general->encrypt($u['EntryID'])}'>{$u['StudentID']} | {$name} </option>";
                }
            }?>
            </select>
            <!--begin::Form group-->
        </div>
        <div class="form-group">
            <input type="hidden" name="course" value="<?=$general->encrypt($id)?>">
            <p>Please Note: The system will automatically add the dashes for you, just continue wriing the token after you have selected your name</p>
            <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="token"
                    autocomplete="off" placeholder="Enter your attendance token"/>
        </div>
        <!--end::Form group-->
						
        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button type="submit" id="kt_register_form_submit_button"
                    class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> Submit Attendance
            </button>
        </div>
        <!--end::Action-->
    </div>
    <!--begin::Form group-->
</form>