<?php
include ('inc/includes.php');
//Session::init();
   
$_SESSION['name']			=	base64_encode($_REQUEST['name']);
$_SESSION['man']			=	base64_encode($_REQUEST['man']);
$_SESSION['model']			=	base64_encode($_REQUEST['model']);
$_SESSION['os']				=	base64_encode($_REQUEST['os']);
$_SESSION['version']		=	base64_encode($_REQUEST['version']);
$_SESSION['hddcapacity']	=	base64_encode($_REQUEST['hddcapacity']);
$_SESSION['speed']			=	base64_encode($_REQUEST['speed']);
$_SESSION['username']		=	base64_encode($_REQUEST['username']);
$_SESSION['dig']			=	base64_encode($_REQUEST['dig']);
$_SESSION['mcadd']			=	base64_encode($_REQUEST['mcadd']);
$_SESSION['ramid']			=	base64_encode($_REQUEST['ramid']);
$_SESSION['cdr']			=	base64_encode($_REQUEST['cdr']);
$_SESSION['cpumake']		=	base64_encode($_REQUEST['cpumake']);
$_SESSION['dns']			=	base64_encode($_REQUEST['dns']);
$_SESSION['ipadd']			=	base64_encode($_REQUEST['ipadd']);
$_SESSION['osbit']			=	base64_encode($_REQUEST['osbit']);
$_SESSION['serialno']		=	base64_encode($_REQUEST['serialno']);
$_SESSION['subnet']			=	base64_encode($_REQUEST['subnet']);
$_SESSION['AudioStatus']			=	base64_encode($_REQUEST['AudioStatus']);
?>


