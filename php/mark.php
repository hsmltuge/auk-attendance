<?php
require_once "../classes/init.php";

if($input->post("student") &&  $input->post("course") && $input->post("token")){
    $student = $general->decrypt($input->post("student"));
    $token = str_ireplace("-","",$input->post("token"));
    $course = $general->decrypt($input->post("course"));
    //update account
    $check = $db->select("SELECT EntryID FROM Tokens WHERE Token LIKE '{$token}' AND CourseID LIKE '{$course}' AND TokenStatus LIKE 0");
    if(empty($check)){
        echo $general->pop_json(["type"=>"error","msg"=>"Sorry this token could not be found, please use the verify attendance token option"]);
        exit;
    }
    $to = $check[0]['EntryID'];
    $create = $db->query("INSERT INTO Attendance (StudentID,TokenID,CourseID) VALUES ('{$student}','{$to}','{$course}')");
    if($create){
        $db->query("UPDATE Tokens SET TokenStatus = 1 WHERE EntryID LIKE '{$to}'");
        echo $general->pop_json(["type"=>"success","msg"=>"Attendance submitted successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Attendance was not submitted, something wrong happened"]);
        exit;
    }
}else{
    echo $general->pop_json(["type"=>"error","msg"=>"Please fill the form properly"]);
    exit;
}