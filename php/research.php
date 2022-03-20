<?php
require_once "../classes/init.php";

if($input->post("orcidurl") &&  $input->post("academiaurl")){
    $academia = $input->post("academiaurl") !== "No" ? "on" :"";
    $orcid = $input->post("orcidurl") !== "No" ? "on" :"";
    $googlescholar = $input->post("googlescholarurl") !== "No" ? "on" :"";
    $researchgate = $input->post("researchgateurl") !== "No" ? "on" :"";
    $others = $input->post("othertools") !== "" ? "on" :"";

    $academiaurl = $input->post("academiaurl");
    $orcidurl = $input->post("orcidurl");
    $googlescholarurl = $input->post("googlescholarurl");
    $researchgateurl = $input->post("researchgateurl");
    $othertools = $input->post("othertools");

    $id = $general->decrypt($input->session("UserLoggedIn"));
    //update account
    $create = $db->query("UPDATE ApplicantPortal SET ORCIDID='{$orcidurl}',ResearchGate='{$researchgate}',Academia='{$academia}',GoogleScholar='{$googlescholar}',Orcid='{$orcid}',Others='{$others}',ScholarAddress='{$googlescholarurl}',ResearchGateAddress='{$researchgateurl}',AcademiaAddress='{$academiaurl}',OthersInput='{$othertools}' WHERE EntryID LIKE '{$id}'");
    if($create){
        echo $general->pop_json(["type"=>"success","msg"=>"Account updated successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Account was not updated"]);
        exit;
    }
}