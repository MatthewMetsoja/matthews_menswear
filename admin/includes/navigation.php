<?php
// active link settings
$pageName = basename($_SERVER['PHP_SELF']);

$adminHome_page = 'index.php';
$orders_page = 'orders.php';
$products_page = 'products.php';
$staff_page = 'staff.php';
$users_page = 'users.php';
$password_page = 'change_password.php';

    $adminHomePageClass = '';
    $ordersPageClass = '';
    $productsPageClass = '';
    $staffPageClass = '';
    $usersPageClass = '';
    $passwordPageClass = '';

    if($pageName === $adminHome_page)
    {
        $adminHomePageClass = 'active';    
    }


    if($pageName === $orders_page)
    {
        $ordersPageClass = 'active';    
    }

    else if($pageName === $products_page)
    {
        $productsPageClass = 'active';    
    }

    else if($pageName === $staff_page)
    {
        $staffPageClass = 'active';    
    }

    else if($pageName === $users_page)
    {
        $usersPageClass = 'active';    
    }

    else if($pageName === $password_page)
    {
        $passwordPageClass = 'active';    
    }

?>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    
    <a class="navbar-brand" href="../index.php">
        <img id="home_link" src="../img/small_logos/smallmatty.png" > 
    </a>

    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class=""> menu</span>
    </button>
   
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= $passwordPageClass ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> 
                        <img id="profile_pic" src="../<?= $_SESSION['picture'] ?>" height="40px" width="40px" >
                </a>
               
                <div class="dropdown-menu">
                    <a class="dropdown-item <?= $passwordPageClass ?>" href="change_password.php">Change Password <i class="fas fa-lock    "></i> </a>
                    <div class="dropdown-divider"></div>
                    <?php  // show log out link 
                    if(isset($_SESSION['id']) && $_SESSION['id'] !== " ")
                    { ?> 
                
                        <a class="dropdown-item" href="../logout.php" tabindex="-1" aria-disabled="true"> Log out <i class="fas fa-power-off    "></i>  </a>

                       <?php 
                    } ?>

                </div>
            </li>

            <li class="nav-item " id="first_nav_link">
                <a class="nav-link <?= $adminHomePageClass ?> " href="index.php"> Admin Home </a>
            </li>

            <li class="nav-item">
              
                <a class="nav-link <?=  $ordersPageClass ?>" href="orders.php">Check Orders</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link <?= $productsPageClass  ?>" href="products.php">Products</a>
            </li>
        
            <li class="nav-item">
                <a class="nav-link <?=  $staffPageClass ?>" href="staff.php">Staff </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link <?=  $usersPageClass ?>" href="users.php">Users </a>
            </li> 
            
        </ul>
        
    </div>

</nav>

<?php 
if(isset($_SESSION['success_flash']))
{
    echo "<div class='login_banner bg-success'> <p class='text-light text-center'>".$_SESSION['success_flash']." </p> </div> "; 
    unset($_SESSION['success_flash']);  
}

