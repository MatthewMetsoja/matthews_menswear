<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";

    // un-set sessions
    unset($_SESSION['id']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['permissions']);
    unset($_SESSION['email']);
    unset($_SESSION['picture']);
    unset($_SESSION['success_flash']);
    unset($_SESSION['error_flash']);
                 
    header("Location: index.php"); 
    

          
include "includes/footer.php"; 

?>