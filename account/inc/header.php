<?php
require_once "../classes/init.php";
require_once "security.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">        
	<title>AUK ATTENDANCE MANAGEMENT SYSTEM</title>
	<meta name="keywords" content="Al-Qalam University, Katsina, eforms, portal">
	<meta name="description" content="The official online admission application forms portal of Al-Qalam University, Katsina - Nigeria.">
    <meta name="robots" content="index,follow,archive">
	<meta name='coverage' content='Worldwide'>
	<meta name="author" content="Suleiman Hayat Tuge -- hsmltuge[at]gmail[dot]com" />
	<meta name='copyright' content='Suleiman Hayat Tuge III'>
	<meta name='date' content='March 18, 2022'>
	<base href=".">
	<meta name='target' content='all'>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
	<!-- Custom Theme files -->
	<link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/x-icon" href="../assets/media/logos/logo.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		@media (min-width: 992px){
			.content {
    			 padding: 0; 
			}
		}
		body,html{
			background-color: rgba(225,225,225,0.9);
		}
	.like_{
		margin-top:30vh !important;
		background-color: rgba(225,225,225,0.5);
	}
	@media screen and (max-width: 580px)  {
		.like_{
			margin-top:10vh !important;
			background-color: rgba(225,225,225,0.5);
		}
		.menu_determinant {
			margin-top:-15px;
		}
	}
    .text-primary {
		color: #4e4e4c !important;
	}
	.btn.btn-primary {
		color: #FFFFFF;
		background-color: #4e4e4c;
		border-color: #4e4e4c;
	}
	.btn.btn-primary:hover:not(.btn-text):not(:disabled):not(.disabled), .btn.btn-primary:focus:not(.btn-text), .btn.btn-primary.focus:not(.btn-text) {
		color: #FFFFFF;
		background-color: #4e4e4cde;
		border-color: #4e4e4cde;
	}
    .loginContainer{
    display: flex;
    align-items: center;
    justify-content: center;
    }
    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + 1.3rem + 2px);
        padding: 0.65rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #3F4254;
        background-color: #ffffff;
        background-clip: padding-box;
        border: 1px solid #00407e3d;
        border-radius: 0.85rem;
        -webkit-box-shadow: none;
        box-shadow: none;
        -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    }
    
	</style>
</head>
<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
