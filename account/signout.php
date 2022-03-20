<?php
@session_start();
if(isset($_SESSION['UserLoggedIn'])){
    $_SESSION['UserLoggedIn'] = null;
    @session_destroy();
    unset($_SESSION['UserLoggedIn']);
}
header("location:../");
exit;