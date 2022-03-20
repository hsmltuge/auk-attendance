<?php
require_once "../classes/init.php";
if(!$input->get("i")){
    echo "Sorry you are not supposed to be here";
    exit;
}
$id = $general->decrypt($input->get("i"));
$info = $db->select("SELECT Token,GetCourseCode(CourseID) CourseCode FROM Tokens WHERE CreatedOn LIKE '{$id}'");
$date = new DateTime($id);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto ;
  padding: 10px;
}
.grid-item {
  border: 1px solid rgba(0, 0, 0, 0.1);
  padding: 10px;
  font-size: 10.5px;
}
</style>
</head>
<body>
    <div style="text-align:center">
        <img src="../assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
        <h4>AL-QALAM UNIVERSITY, KATSINA </h4>
        <h4><?=count($info)?> ATTENDANCE TOKEN FOR <?=$date->format("Y-m-d")?></h4>
    </div>
<div class="grid-container">
  <?php
  foreach ($info as $i) {
      $token = $i['CourseCode']." | ". rtrim(chunk_split($i['Token'], 4, '-'),'-');
      echo "<div class='grid-item'>{$token}</div>";
  }
  ?>
</div>
<script>print()</script>
</body>
</html>