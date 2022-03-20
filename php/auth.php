<?php
require_once "../classes/init.php";

if($input->post("course") && $input->post("token")){
    $token = str_ireplace("-","",$input->post("token"));
    $course = $general->decrypt($input->post("course"));
    //update account
    $check = $db->select("SELECT TokenStatus FROM Tokens WHERE Token LIKE '{$token}' AND CourseID LIKE '{$course}'");
    if(empty($check)){
        echo $general->pop_json(["type"=>"error","msg"=>"Sorry this token could not be found"]);
        exit;
    }
    if($check[0]['TokenStatus'] === "0"){
        echo $general->pop_json(["type"=>"success","msg"=>"Token has not been use, you can use this token"]);
        exit;
    }else{
        $check2 = $db->select("SELECT FullName,s.StudentID,EmailAddress FROM AttendedView v JOIN Students s ON v.StudentID=s.EntryID WHERE Token LIKE '{$token}' AND ClassID LIKE '{$course}'");
        echo $general->pop_json(["type"=>"info","msg"=>"Your token {$input->post("token")} was used by {$check2[0]['StudentID']} | {$check2[0]['FullName']} | {$check2[0]['EmailAddress']}"]);
        exit;
    }
}else{
    echo $general->pop_json(["type"=>"error","msg"=>"Please fill the form properly"]);
    exit;
}