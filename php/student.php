<?php
require_once "../classes/init.php";
require_once "index.php";
if($input->post("emailaddress") && $input->post("regNo") && $input->post("fullNames") && $input->post("programmes")){
    //training
    $emailaddress = $input->post("emailaddress");
    $regNo = $input->post("regNo");
    $fullNames = $input->post("fullNames");
    $programmes = $input->post("programmes");
    $id = $general->decrypt($input->session("UserLoggedIn"));
    //check if the person has applied before
    $check = $db->select("SELECT EntryID FROM Students WHERE EmailAddress LIKE '{$emailaddress}' AND FullName LIKE '{$fullNames}' AND StudentID LIKE '{$regNo}' AND CourseID LIKE '{$programmes}' AND CreatedBy LIKE '{$id}'");
    if(!empty($check)){
        echo $general->pop_json(["type"=>"error","msg"=>"You have already added this student"]);
        exit;
    }   
    //update account
    $create = $db->query("INSERT INTO Students (EmailAddress,FullName,StudentID,CourseID,CreatedBy) VALUES ('{$emailaddress}','{$fullNames}','{$regNo}','{$programmes}','{$id}')");
    if($create){
        echo $general->pop_json(["type"=>"success","msg"=>"Your student was added successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Your student was not added"]);
        exit;
    }
}