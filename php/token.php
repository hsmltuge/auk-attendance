<?php
require_once "../classes/init.php";

if($input->post("programmes") && $input->post("date")){
    $date = $input->post("date");
    $programmes = $input->post("programmes");
    $insert = date("Y-m-d H:m:s");
    $id = $general->decrypt($input->session("UserLoggedIn"));
    //select students 
    $list  = $db->select("SELECT EntryID FROM Students WHERE CourseID LIKE '{$programmes}'");
    if(!empty($list)){
        try{
            foreach($list as $l){
                //generate token
                while(true){
                    $rand = $general->generateRandomString(2);
                    $rand2 = $general->generateRandomString(2);
                    $token = $rand.rand(100000000000,time()).$rand2;
                    //check if token exists
                    $check = $db->select("SELECT EntryID FROM Tokens LIKE '{$token}' AND CourseID LIKE '{$programmes}' LIMIT 0,1");
                    if(!empty($check)){
                        continue;
                    }
                    $db->query("INSERT INTO Tokens (ClassDate,Token,CourseID,CreatedBy,CreatedOn) VALUES ('{$date}','{$token}','{$programmes}','{$id}','{$insert}')");
                    break;
                }
            }
            echo $general->pop_json(["type"=>"success","msg"=>"Account updated successfully","date" => $general->encrypt($insert)]);
            exit;
        }catch(Exception $e){
            //delete
            $db->query("DELETE FROM Tokens WHERE CourseID LIKE '{$programmes}' AND CreatedOn LIKE '{$insert}'");
            echo $general->pop_json(["type"=>"error","msg"=>"Account was not updated"]);
            exit;
        }
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Sorry no student could be found in the course"]);
        exit;
    }
}