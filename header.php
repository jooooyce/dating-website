<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!--
        Name: 			Ellen Coombs
        File: 			<?php echo $title ."\n"; ?>
        Date: 			<?php echo $date ."\n"; ?>
        Description: 	<?php echo $description ."\n"; ?>
    -->
    <title><?php echo $title; ?></title>

    <!--Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico?v=4.0" type="image/x-icon"/>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css?v=3.0" type="text/css"/>

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css"/>

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/creative.css?v=1.23" type="text/css"/>
    <link rel="stylesheet" href="css/datingsite.css?v=1.98" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js" type="text/javascript"/>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js" type="text/javascript"/>
    <![endif]-->
</head>
<body id="page-top">
<?php
ob_start();
require "includes/constants.php";
require "includes/functions.php";
require "includes/db.php";
session_start();
$message = "";

//if(!empty($_SESSION['message'])){
	//$message = '<p style="color: #262626" align="center">' . $_SESSION['message'] . '</p>';
	//unset ($_SESSION['message']);
//}

?>
