<?php
require_once "../classes/init.php";
if ($input->post("emailaddress") &&  $input->post("password")) {
    $emailaddress = $input->post("emailaddress");
    $password = $general->encrypt($input->post("password"));
    $query = $db->select("SELECT EntryID,Status FROM AcademicLecturer WHERE EmailAddress LIKE '{$emailaddress}' AND AccountPassword LIKE '{$password}'  LIMIT 0,1");
    if(!empty($query)){
        if($query[0]["Status"] === "" || $query[0]["Status"] === "0"){
            echo $general->pop_json(["type"=>"error","msg"=>"Sorry your account is not activated"]);
            exit;
        }
        $input->set_session("UserLoggedIn",$general->encrypt($query[0]['EntryID']));
        echo $general->pop_json(["type"=>"success","msg"=>"Your login is successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Sorry invalid username or password entered"]);
        exit;
    }
}else{
    echo $general->pop_json(["type"=>"error","msg"=>"Sorry you need to enter valid username and password"]);
    exit;
}