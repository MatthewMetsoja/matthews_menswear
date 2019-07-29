<?php 
session_start(); 
ob_start(); 
require_once "includes/init.php"; 

$master = password_hash(getenv(Master),PASSWORD_DEFAULT);

    // check user is allowed to view admin page if not redirect
    if(!isset($_SESSION['id']) || $_SESSION['id'] == " ")
    {
        $_SESSION['error_flash'] = "You must be logged in to view that page";
        header("Location: ../login.php");
    }

    if($_SESSION['permissions'] == "user")
    {
        header("Location: ../index.php");
    }

?>
 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, ">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../js/jquery.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/fontawesome.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <title> Staff admin </title>
</head>
<body>


