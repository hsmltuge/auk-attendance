<?php
if(!$input->session('UserLoggedIn')){
    $input->set_session('UserLoggedIn', "");
    @session_start();

    @session_destroy();
    unset($_SESSION['UserLoggedIn']);
    header("location:../");
}