<?php
require_once "../classes/init.php";

if ($input->post("reg")) {
    $reg =$input->post("reg");
    //fetch student details
    $info = $db->select("SELECT * FROM Students WHERE StudentID LIKE '{$reg}' ORDER BY CreatedOn ASC");
    if(empty($info)){
        echo $general->errors("error","Sorry student information could not be found","STUDENT NOT FOUND");
        exit;
    }
    ?>
    <div style="text-align:left" class="text-uppercase">
        <h4>Name: <?=$info[0]["FullName"]?></h4>
        <h4>Reg. Number: <?=$info[0]["StudentID"]?></h4>
        <h4>Course(s): <?=count($info)?></h4>
    </div>
    <?php
    $x=1;
    foreach($info as $i){
        ?>
        <table class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <?php
                    //fetch the courses the student is registered for
                    $attendance = $db->select("SELECT DISTINCT ClassDate FROM Tokens WHERE CourseID LIKE '{$i['CourseID']}' ORDER BY ClassDate ASC");
                    if(!empty($attendance)){
                        foreach($attendance as $a){
                            echo "<th>{$a['ClassDate']}</th>";
                        }
                    }
                    ?>
                    <th>Attendance Percentage</th>
                </tr>
            </thead>
            <tbody >
                <?php
                    $course = $db->select("SELECT * FROM Class WHERE EntryID LIKE '{$i['CourseID']}'");
                    $c = $course[0];
                    ?>
                    <tr class="text-left">
                        <td><?=$x?></td>
                        <td><?=$c['CourseCode']?></td>
                        <td><?=$c['CourseTitle']?></td>
                        <?php
                        $attendedCount = 0;
                        if(!empty($attendance)){
                            foreach($attendance as $a){
                                $attended = $db->select("SELECT ClassID FROM AttendedView WHERE ClassID LIKE '{$i['CourseID']}' AND ClassDate LIKE '{$a['ClassDate']}' AND StudentID LIKE '{$i['EntryID']}'");
                                $att = 0;
                                if(!empty($attended)){
                                    $att = 1;
                                    $attendedCount++;
                                }
                                echo "<td class='text-center'>{$att}</td>";
                            }
                        }
                        ?>
                        <td  class='text-center'><?=!empty($attendance) && $attendedCount === 0 ? $attendedCount."%" : round(($attendedCount/count($attendance)) * 100)."%"?></td>
                    </tr>
                </tbody>
            </table>
            <?php
        $x++;
    }
    
}else{
    echo $general->pop_json(["type"=>"error","msg"=>"Please fill the form properly"]);
    exit;
}