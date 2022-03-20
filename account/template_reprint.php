<?php
require_once "../classes/init.php";
if(!$input->get("i")){
    echo "Sorry you are not supposed to be here";
}
$id = $general->decrypt($input->get("i"));
$info = $db->select("SELECT CreatedOn,COUNT(CreatedOn) ListCount FROM Tokens WHERE CourseID LIKE '{$id}' GROUP BY CreatedOn");
$course = $db->select("SELECT CourseCode,CourseTitle FROM Class WHERE EntryID LIKE '{$id}' LIMIT 0,1");
if(!empty($info)){
    ?>
    <table class="table table-hover table-bordered ">
        <thead>
            <tr>
                <th>SN</th>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Created At</th>
                <th>Tokens Generated</th>
                <th>Print</th>
            </tr>
        </thead>
        <tbody >
            <?php
            $x=1;
            foreach($info as $i){
                
                ?>
                    <tr title="Retired records will not be visible to the students">
                        <td><?=$x?></td>
                        <td><?=$course[0]['CourseCode']?></td>
                        <td><?=$course[0]['CourseTitle']?></td>
                        <td><?=$i['CreatedOn']?></td>
                        <td><?=$i['ListCount']?></td>
                        <td>
                            <a  href="print.php?i=<?=$general->encrypt($i["CreatedOn"])?>" target="_blank" id="kt_login_submit_button" class="btn btn-primary btn-block font-weight-bolder ">Print</a>
                        </td>
                    </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>
    <?php
}else{
    echo $general->errors("danger","Sorry system could not find attendance for the selected course","NO RECORD FOUND");
}
?>