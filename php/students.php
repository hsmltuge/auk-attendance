<?php
require_once "../classes/init.php";
require_once "index.php";
if($input->post("jsonRecords")  && $input->post("programmes")){
    $json = json_decode(stripslashes($input->post("jsonRecords")),true);
    if(!empty($json)){
        foreach($json as $j){
            //training
            if(!isset($j["EmailAddress"]) || !isset($j["RegNo"])  || !isset($j["FullNames"])){
                continue;
            }
            $emailaddress = $j["EmailAddress"];
            $regNo = $j["RegNo"];
            $fullNames =  $j["FullNames"];
            
            $programmes = $input->post("programmes");
            $id = $general->decrypt($input->session("UserLoggedIn"));
            //check if the person has applied before
            $check = $db->select("SELECT EntryID FROM Students WHERE EmailAddress LIKE '{$emailaddress}' AND FullName LIKE '{$fullNames}' AND StudentID LIKE '{$regNo}' AND CourseID LIKE '{$programmes}' AND CreatedBy LIKE '{$id}'");
            if(!empty($check)){
               continue;
            }   
            //update account
            $db->query("INSERT INTO Students (EmailAddress,FullName,StudentID,CourseID,CreatedBy) VALUES ('{$emailaddress}','{$fullNames}','{$regNo}','{$programmes}','{$id}')");
        }
        echo $general->pop_json(["type"=>"success","msg"=>"Your students were added"]);
        exit;
    }
    echo $general->pop_json(["type"=>"error","msg"=>"Your students were not added"]);
    exit;
}