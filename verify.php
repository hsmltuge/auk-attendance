<?php
require_once "../classes/init.php";

if($input->get("i")){
    $email = $general->decrypt($input->get("i"));
    $fetch = $db->select("SELECT  EntryID FROM AcademicLecturer WHERE EmailAddress LIKE '{$email}' LIMIT 0,1");
    if(!empty($fetch)){
        $id = $fetch[0]['EntryID'];
        $update = $db->query("UPDATE AcademicLecturer SET Status=1 WHERE EntryID LIKE '{$id}'");
        if($update){
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
                                    Your portal account has been verified successfully.
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
            $general->Email($email,"info@thriventservices.com","PORTAL ACCOUNT VERIFIED",$general->email_head().$body.$general->email_foot(),false);
            echo "Your account has been verifies please click the link to login <a href='index.php'>Go to login page</a>";
            exit;
        }else{
            echo "Sorry, something went wrong, system could verify your request...contact an administrator via email <a href='mailto:info@thriventservices.com'>info@thriventservices.com</a>";
            exit;
        }
    }else{
        echo "Sorry, system could not verify your parameter...contact an administrator via email <a href='mailto:info@thriventservices.com'>info@thriventservices.com</a>";
        exit;
    }
}
echo "Sorry, system could not find expected verification parameter...contact an administrator via email <a href='mailto:info@thriventservices.com'>info@thriventservices.com</a>";
exit;