<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class general 
{

    function return_to($url)
    {
        header("location:" . $url);
        exit;
    }

    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
        $num = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        if($num == 'NAN'){
            $num = 0;
        }
        return $num;
    }

    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function errors($type, $error, $title = false)
    {
        $title = $title == false ? "System Message!" : $title;
        $error = $title != 'success' ? $error : $error;
        return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4 class="text-center">' . strtoupper($title) . '</h4><hr>
    <p class="text-center">' . $error . '  </p>
    </div>';
    }

    public function Email($to, $from, $title, $body, $cc = false)
    {


        $headers = "From: $from \r\n";
        $headers .= "Reply-To: $from \r\n";
        $headers .= "CC: $cc \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (@mail($to, $title, $body, $headers)) {
            return 1;
        }
        return 0;
    }


    function send_sms($phone, $msg, $from)
    {
        $owneremail = "rislan.kanya@bazeuniversity.edu.ng";
        $subacct = "BAZEUNIV";
        $subacctpwd = "bazeuniv";
        $url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg" . "&owneremail=" . UrlEncode($owneremail) . "&subacct=" . UrlEncode($subacct) . "&subacctpwd=" . UrlEncode($subacctpwd) . "&message=" . UrlEncode($msg) . "&sender=" . UrlEncode($from) . "&sendto=" . UrlEncode($phone) . "&msgtype=" . UrlEncode(0);
        /* call the URL */
        if ($f = @fopen($url, "r")) {
            return 1;
        } else {
            return 2;
        }
    }

    function time_since($timestamp)
    {
        $datetime1 = new DateTime("now");
        $datetime2 = date_create($timestamp);
        $diff = date_diff($datetime1, $datetime2);
        $timemsg = '';
        if ($diff->y > 0) {
            $timemsg = $diff->y . ' year' . ($diff->y > 1 ? "'s" : '');
        } else if ($diff->m > 0) {
            $timemsg = $diff->m . ' month' . ($diff->m > 1 ? "'s" : '');
        } else if ($diff->d > 0) {
            $timemsg = $diff->d . ' day' . ($diff->d > 1 ? "'s" : '');
        } else if ($diff->h > 0) {
            $timemsg = $diff->h . ' hour' . ($diff->h > 1 ? "'s" : '');
        } else if ($diff->i > 0) {
            $timemsg = $diff->i . ' minute' . ($diff->i > 1 ? "'s" : '');
        } else if ($diff->s > 0) {
            $timemsg = $diff->s . ' second' . ($diff->s > 1 ? "'s" : '');
        }

        $timemsg = $timemsg . ' ago';
        return $timemsg;
    }

    function remote_file_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode == 200) {
            return true;
        }
        return false;
    }

    function file_upload($fileArray, $name, $target_path)
    {
        ini_set('post_max_size', '64M');
        ini_set('upload_max_filesize', '64M');
        $old_filename = basename($fileArray[$name]['name']);
        $exp = explode('.', basename($fileArray[$name]['name']));
        $target = $target_path . basename($fileArray[$name]['name']);
        if (is_dir($target_path)) {
            if (move_uploaded_file($fileArray[$name]['tmp_name'], $target)) {
                $new_name = $target_path . date('YmdHis', time()) . mt_rand() . '.' . end($exp);
                if (is_dir($target_path) AND file_exists($target)) {
                    rename($target, $new_name);
                }
                return $new_name;
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    function encrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SayyoFilms';
        $secret_iv = 'FilmsInternational';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    function decrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SayyoFilms';
        $secret_iv = 'FilmsInternational';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    function root_url()
    {
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }


    public function pop_json($array)
    {
        header('content-type:application/json');
        echo json_encode($array);
        exit;
    }

    function money_format($value)
    {
        return '₦'. number_format($value, '2', '.', ',');
    }
    function email_head(){
        return '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>THRIVENT SERVICES NIGERIA</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            </head>
            <body style="margin: 0; padding: 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                    <tr>
                        <td style="padding: 10px 0 30px 0;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                                <tr>
                                    <td align="center" bgcolor="FFFFFF" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; border-bottom:1px solid #cccccc">
                                        <img src="portal.thriventservices.com/assets/media/logos/logo.png"  alt="THRIVENT SERVICES" width="100" height="100" style="display: block;" />
                                        <p style="font-size: 18px;text-transform:uppercase">THRIVENT SERVICES</h1>
                                        <p style="font-size: 12px;">NIGERIA LIMITED</p>  
                                    </td>
                                </tr>
        ';
    }
    function email_foot(){
        return '
        <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                        POWERED BY SMARTSOURCING NIGERIA LIMITED, '.date("Y").'<sup> &reg;</sup>
                        </td>
                        <td align="right" width="25%">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                        <a href="#" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                        </a>
                                    </td>
                                    <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                        <a href="#" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
        ';
    }
}
