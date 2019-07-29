<?php 
session_start(); 
ob_start(); 

// give basket cookie a name that is a token, 
define('BASKET_COOKIE','dfdG538Dvcs87MNmg');
define('ORDER_COOKIE','TdGF356DO0c3s3rd24');

require_once "includes/init.php"; 

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, ">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/fontawesome.js"></script>
    <script src="js/script.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <title>Matthew's Shop  </title>
</head>
<body>

<?php
  // TAX RATE
    define('TAXRATE',0.2);

  // error message for users trying to view bacKend will want updating once we change access the system
    if(isset($_SESSION['error_flash']))
    {
        echo "<div id='invis_banner' class='login_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_flash']." </p> </div> "; 
        unset($_SESSION['error_flash']);  
    }

    // configure a month for when we want to expire the cookie
    $a_month = time() + (86400 * 30);

    // cookie value which will be basket_id to empty if we have not set the cookie
    $basket_id =  " " ;
    $order_id =  " " ;
  
    // but if we do set it then escape the string to prevent attacks
    if(isset($_COOKIE[BASKET_COOKIE]))
    {
        $basket_id = mysqli_real_escape_string($connection,$_COOKIE[BASKET_COOKIE]);
    }

    if(isset($_COOKIE[ORDER_COOKIE]))
    {
        $order_id = mysqli_real_escape_string($connection,$_COOKIE[ORDER_COOKIE]);
    }


    $session_id = session_id(); 
 
 ?>