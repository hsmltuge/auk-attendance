<?php
require_once "../classes/init.php";
require_once "index.php";

if($input->post("emailaddress") && $input->post("firstname") && $input->post("password")){
    $firstname = $input->post("firstname");
    $middlename = $input->post("middlename");
    $lastname = $input->post("lastname");
    $emailaddress = $input->post("emailaddress");
    $password = $input->post("password");
    //check  if account already exists
    $check = $db->select("SELECT EntryID FROM AcademicLecturer WHERE EmailAddress LIKE '%{$emailaddress}%'");
    if(!empty($check)){
        echo $general->pop_json(["type"=>"error","msg"=>"Sorry an account already exist with the email address or password"]);
        exit;
    }
    //create account
    $pass = $general->encrypt($password);
    $create = $db->query("INSERT INTO AcademicLecturer (FirstName,MiddleName,LastName,EmailAddress,AccountPassword) VALUES  ('{$firstname}','{$middlename}','{$lastname}','{$emailaddress}','{$pass}')");
    if($create){
       $body = '<tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Greetings,</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    You have successfully, create your account, Please click the link/button to confirm your account:
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 18px; line-height: 20px;">
                                    <a href="https://attendance.auk.edu.ng/account/verify.php?i='.$general->encrypt($emailaddress).'">Click here to verify your account</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Thank you<br>Management
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>';
        Email($emailaddress,"PORTAL APPLICATION",$general->email_head().$body.$general->email_foot());
        echo $general->pop_json(["type"=>"success","msg"=>"Account created successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"error","msg"=>"Account was not created"]);
        exit;
    }
}