<?php
require_once "../classes/init.php";
if(!$input->post("programmes")){
    echo "Sorry you are not supposed to be here";
    exit;
}
$courseid = $input->post("programmes");
$info = $db->select("SELECT * FROM Class WHERE EntryID LIKE '{$courseid}'");
$student = $db->select("SELECT * FROM Students WHERE CourseID LIKE '{$courseid}' ORDER BY StudentID ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        html,body{
            margin:10px;
            font-size:12px;
        }
        table, th, td {
            padding:3px;
            border: 1px solid;
        }
        table {
  border-collapse: collapse;
  width: 100%;
}
    </style>
</head>
<body>
    <div style="text-align:center">
        <img src="../assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
        <h4>AL-QALAM UNIVERSITY, KATSINA </h4>
        <h4><?=!empty($info) ? strtoupper($info[0]['CourseCode'].' - '. $info[0]['CourseTitle']) : ""?> SEMESTER ATTENDANCE REPORT </h4>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>REG. NUMBER</th>
                    <th>NAMES</th>
                    <?php
                    $schedules = $db->select("SELECT DISTINCT ClassDate FROM tokens WHERE CourseID LIKE '{$courseid}'");
                    if(!empty($schedules)){
                        foreach($schedules as $s){
                            echo "<th>{$s['ClassDate']}</th>";
                        }
                    }
                    ?>
                    <th>PERCENTAGE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($student)){
                        $sn =1;
                        foreach($student as $s){
                            ?>
                            <tr>
                                <th><?=$sn?></th>
                                <td><?=$s["StudentID"]?></td>
                                <td><?=$s["FullName"]?></td>
                                <?php
                                $perc = 0;
                                if(!empty($schedules)){
                                    foreach($schedules as $s0){
                                        //check if the student attended the class
                                        $attended = $db->select("SELECT ClassID FROM AttendedView WHERE ClassID LIKE '{$courseid}' AND StudentID LIKE '{$s['EntryID']}' AND ClassDate LIKE '{$s0['ClassDate']}'");
                                        $att = 0;
                                        if(!empty($attended)){
                                            $att=1;
                                            $perc++;
                                        }
                                        echo "<td>{$att}</td>";
                                    }
                                }
                                ?>
                                <th  class='text-center'><?=!empty($schedules) && $perc === 0 ? $perc."%" : round(($perc/count($schedules)) * 100)."%"?></th>
                            </tr>
                            <?php
                            $sn++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script>print()</script>
</body>
</html>