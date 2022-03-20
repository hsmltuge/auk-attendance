<?php
require_once "../classes/init.php";
if($input->post("title") && $input->post("code") && $input->post("year")){
    //training
    $title = $input->post("title");
    $code = $input->post("code");
    $year = $input->post("year");
    $id = $general->decrypt($input->session("UserLoggedIn"));
    //check if the person has applied before
    $check = $db->select("SELECT EntryID FROM Class WHERE CourseCode LIKE '{$code}' AND CourseTitle LIKE '{$title}' AND CourseYear LIKE '{$year}' AND Status LIKE 1 AND CreatedBy LIKE '{$id}'");
    if(!empty($check)){
        echo $general->pop_json(["type"=>"error","msg"=>"You already added a record with similar details"]);
        exit;
    }   
    //update account
    $create = $db->query("INSERT INTO Class (CourseCode,CourseTitle,CourseYear,CreatedBy) VALUES ('{$code}','{$title}','{$year}','{$id}') ");
    if($create){
        echo $general->pop_json(["type"=>"success","msg"=>"Your course is submitted successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Your course is not submitted"]);
        exit;
    }
}