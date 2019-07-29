 <?php      
     //active page set up               
    $homePageClass = '';
    $contactPageClass = '';
    $tshirtsPageClass = '';
    $jumpersPageClass = '';
    $hatsPageClass  = '';
    $salePageClass  = '';
    $accessoriesPageClass = '';
    $basketPageClass = '' ;
    $loginPageClass = '' ;
    $user_homePageClass = '' ;
    $user_profilePageClass = '';

    // get the name of the page for the ones who are not in the loop
    $pageName = basename($_SERVER['PHP_SELF']);

    $home_page = 'index.php';
    $contact_page = 'contact.php';
    $tshirts_page = 'tshirts.php';
    $jumpers_page = 'jumpers.php';
    $hats_page = 'hats.php';
    $sale_page = 'sale.php';
    $accessories_page = 'accessories.php';
    $basket_page = 'basket.php';
    $checkout_page = 'check_out.php';
    $payment_page = 'payment.php';
    $login_page = 'login.php';
    $user_home_page =  'user_home.php';
    $user_profile_page = 'user_profile.php';


    if($pageName === $home_page)
    {
        $homePageClass = 'active';    
    }

    if($pageName === $contact_page)
    {
        $contactPageClass = 'active';    
    }

    if($pageName === $jumpers_page)
    {
        $jumpersPageClass = 'active';    
    }
        
    if($pageName ===  $tshirts_page)
    {
        $tshirtsPageClass = 'active';    
    }

    if($pageName ===  $hats_page)
    {
        $hatsPageClass = 'active';    
    }   
        
    if($pageName ===  $sale_page)
    {
        $salePageClass = 'active';    
    }  

    if($pageName ===  $accessories_page)
    {
        $accessoriesPageClass = 'active';    
    } 
            
    if($pageName ===  $login_page)
    {
        $loginPageClass = 'active';    
    }  
        
    if($pageName ===  $user_home_page || $pageName === "users_orders.php")
    {
        $user_homePageClass = 'active';    
    }

    if($pageName ===  $user_profile_page)
    {
        $user_profilePageClass = 'active';    
    }

    if($pageName === $basket_page || $pageName === $payment_page || $pageName === $checkout_page)
    {
        $basketPageClass = 'active';    
    }    

?>


    <nav class="navbar navbar-expand-md navbar fixed-top">
       
        <a class="navbar-brand" href="index.php"> <img id="home_link" src="img/small_logos/smallmatty.png" > </a>
        
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            Menu
        </button>

        <div id="my-nav" class="collapse navbar-collapse">
           
            <ul class="navbar-nav mr-auto">
                <?php 
                        // only show admin link to logged in admin who are allowed access to the page
                    if(isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'admin')
                    { ?> 
                            <li class="nav-item ">
                                <a class="nav-link"  href="admin/index.php" tabindex="-1" aria-disabled="true"> Admin</a>
                            </li> <?php 
                    } 

                        // show drop down with log out link if user is logged in
                    if(isset($_SESSION['id']) && $_SESSION['id'] !== " ")
                    { ?> 
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?= $passwordPageClass ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> 
                                        <img id="profile_pic" src="<?= $_SESSION['picture'] ?>" height="40px" width="40px" >
                                </a>
           
                                <div class="dropdown-menu">
                                            <a class="dropdown-item <?php echo $user_homePageClass?>"  href="user_home.php"> My Orders  <i class="fas fa-history"></i> </a>
            
                                            <a class="dropdown-item <?php echo $user_profilePageClass ?>" href="user_profile.php"> My Profile  <i class="fas fa-user"></i> </a>
                                       
                                    <?php
                                    // show log out link instead
                                    if(isset($_SESSION['id']) && $_SESSION['id'] !== " ")
                                    { ?> 
             
                                            <a class="dropdown-item" href="logout.php" tabindex="-1" aria-disabled="true"> Log out <i class="fas fa-power-off"></i></a>
                                       <?php 
                                    } ?>

                                </div>
                            </li>
                        <?php 
                    } ?>

               
                    <li class="nav-item">
                            <a class="nav-link <?php echo $jumpersPageClass ?> " href="jumpers.php" tabindex="-1" aria-disabled="true">Jumpers  </a>
                    </li>

                    <li class="nav-item ">
                            <a class="nav-link <?php echo $tshirtsPageClass ?>" href="tshirts.php" tabindex="-1" aria-disabled="true"> T-shirts</a>
                    </li>

                    <li class="nav-item ">
                            <a class="nav-link <?php echo $hatsPageClass ?>" href="hats.php" tabindex="-1" aria-disabled="true">Hats </a>
                    </li>

                    <li class="nav-item">
                            <a class="nav-link <?php echo $accessoriesPageClass ?>" href="accessories.php" tabindex="-1" aria-disabled="true">  Accessories</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo $salePageClass ?>" href="sale.php" tabindex="-1" aria-disabled="true">Sale</a>
                    </li>
               
                <?php  // hide login link when user has logged in
                if(!isset($_SESSION['id']) || $_SESSION['id'] == " ")
                { ?> 
                    <li class="nav-item">
                        <a class="nav-link <?php echo $loginPageClass ?>" href="login.php" tabindex="-1" aria-disabled="true"> Login/sign-up  </a>
                    </li>    <?php 
                } ?>
           

                    <li class="nav-item">
                        <a class="nav-link <?php echo $contactPageClass ?>" href="contact.php" tabindex="-1" aria-disabled="true">  Contact </a>
                    </li>

                    <li class="nav-item">
                       
                        <a class="nav-link <?php echo $basketPageClass ?>" href="basket.php" tabindex="-1" aria-disabled="true"> Basket  <i class="fas fa-shopping-basket    "></i>  
                            <?php  
                            if($basket_id != " ")
                            {
                                $basket_counter = 0;
                                $totalcost_counter = 0;
                                $count_query = "SELECT * FROM basket WHERE id = '$basket_id' ";
                            
                                $count_result = mysqli_query($connection,$count_query);
                            
                                $count_row = mysqli_fetch_assoc($count_result); 
                                $count_items = json_decode($count_row['items'],true);
                            
                                foreach($count_items as $item_quantity)
                                {
                                    $basket_counter = $basket_counter + $item_quantity['quantity']; 
                                
                                    $price = $item_quantity['price'] * $item_quantity['quantity'];
                                    $totalcost_counter = $totalcost_counter + $price + ($price * TAXRATE);      
                                }
                            } 
                            ?>
                        
                            <span id="basket_counter"> <?php if($basket_counter != 0){echo $basket_counter; } ?>  </span>   
                        </a>

                    </li>
           
            </ul>

        </div>

    </nav>
    
    <?php
    // error message for shopping basket
    if(isset($_SESSION['error_basket']))
    {
        echo  
            "<nav id='nav2' class='nav fixed-top'>
                    <div id='basket_banner' class='basket_banner bg-danger'> <p class='text-light text-center'>".$_SESSION['error_basket']." </p> </div> 
             </nav> ";   
        
        unset($_SESSION['error_basket']);
    }
    
   


    if(isset($_SESSION['success_basket']))
    {
        echo  
            "<nav id='nav2' class='nav fixed-top'>
                    <div id='basket_banner' class='basket_banner bg-success'> <p class='text-light text-center'>".$_SESSION['success_basket']." </p> </div> 
            </nav> "; 
            
        unset($_SESSION['success_basket']);
    }

?>  
  
    
