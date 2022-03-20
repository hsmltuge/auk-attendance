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
                                Please find below your password.
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                <h1>'.$general->decrypt($form[0]['Password']).'</h1>
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
        Email($emailaddress,"THRIVENT PASSWORD RECOVERY",$general->email_head().$body.$general->email_foot());
        echo $general->pop_json(["type"=>"success","msg"=>"Your application is submitted successfully"]);
        exit;
    }else{
        echo $general->pop_json(["type"=>"errory","msg"=>"Sorry system could not process your request."]);
        exit;
    }
    
    
}