<?php
require_once "../classes/init.php";
require_once "index.php";

if($input->post("emailaddress") ){
    //training
    $emailaddress = $input->post("emailaddress");
    //check if the form is properly filled
    $form = $db->select("SELECT * FROM AcademicLecturer WHERE EmailAddress  LIKE '{$emailaddress}' LIMIT 0,1");
    if(!empty($form)){
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
                            <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 40px; line-height: 20px;">
                            <a href="portal.thriventservices.com/verify.php?i='.$general->encrypt($emailaddress).'">Click here to verify your account</a>
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
        Email($email,"THRIVENT PORTAL ACCOUNT REACTIVATION",$general->email_head().$body.$general->email_foot());
        echo $general->pop_json(["type"=>"success","msg"=>"Your application is submitted successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"errory","msg"=>"Sorry system could not process your request."]);
        exit;
    }
    
    
}