<?php
@session_start();

spl_autoload_register(function($classes){
    require_once "class/".$classes.".class.php";
});
$db = new db();
$input = new input();
$general = new general();