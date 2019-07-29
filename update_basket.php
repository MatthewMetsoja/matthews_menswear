<?php 
require_once "includes/head.php";


  $mode = filter_var($_POST['mode'],FILTER_SANITIZE_STRING);
    
  $edit_size = filter_var($_POST['edit_size'],FILTER_SANITIZE_STRING);
    
  $edit_id = filter_var($_POST['edit_id'],FILTER_SANITIZE_STRING);


  // fetch the basket from the database so we can update update it
    $stmt = mysqli_stmt_init($connection);
    $query = "SELECT * FROM basket WHERE id = ? " ;
    if(!mysqli_stmt_prepare($stmt,$query))
    {
      die('prep basket stmt failed'.mysqli_error($connection));  
    }
    if(!mysqli_stmt_bind_param($stmt,"i",$basket_id))
    {
      die('bind basket stmt failed'.mysqli_error($connection));  
    }
    if(!mysqli_stmt_execute($stmt))
    {
      die('exexute basket stmt failed'.mysqli_error($connection));  
    }
    
    $result = mysqli_stmt_get_result($stmt);
    if(!$result)
    {
      die('result basket failed'.mysqli_error($connection));  
    }

    $row = mysqli_fetch_assoc($result);

    // fetch the basket from the database
    $full_basket_as_string = $row['items'];
    
    // convert it back to an assoc array (true) 
    $full_basket_as_array = json_decode($full_basket_as_string,true); 
    
    $updated_basket_array = array();

    // delete item from basket
    if($mode == "delete_item")
    {
        foreach($full_basket_as_array as $basket_item)
        {
            // if size and id match then we have found the item 
            if($basket_item['product_id'] == $edit_id && $basket_item['size'] == $edit_size)
            {
              $basket_item['quantity'] = 0 ; 
            }
            // loops through each and adds all items again with the new value in there but only will add in there if the value is not 0 
            // so the empty items get left out of our new basket so it is basicaaly a delete also 
            if($basket_item['quantity'] != 0)
            {
              $updated_basket_array[] = $basket_item;  
            }
        }  
    }

    
   // minus one from quantity
    if($mode == "minus1")
    {
        foreach($full_basket_as_array as $basket_item)
        {
            // if size and id match then we have found the item 
            if($basket_item['product_id'] == $edit_id && $basket_item['size'] == $edit_size)
            {
              $basket_item['quantity'] = $basket_item['quantity'] - 1; 
            }
          
            // loops through each and adds all items again with the new value in there but only will add in there if the value is not 0 
            // so the empty items get left out of our new basket so it is basicaaly a delete also 
            if($basket_item['quantity'] != 0)
            {
              $updated_basket_array[] = $basket_item;  
            }
        }     
    }

    // add one from quantity
    if($mode == "plus1")
    {
        foreach($full_basket_as_array as $basket_item)
        {
         
            // if size and id match then we have found the item 
            if($basket_item['product_id'] == $edit_id && $basket_item['size'] == $edit_size)
            {
              $basket_item['quantity'] = $basket_item['quantity'] + 1; 
            }
       
            // loops through each and adds all items again with the new value in there
            $updated_basket_array[] = $basket_item;  
         
        }  
    }

    if(!empty($updated_basket_array))
    {
        $updated_basket = json_encode($updated_basket_array);
       
        // UPDATE BASKET QUERY  
          $stmt3 = mysqli_stmt_init($connection);
          $update_basket_query =" UPDATE basket SET items = ? WHERE id = ? " ;
          
          if(!mysqli_stmt_prepare($stmt3,$update_basket_query))
          {
            die('update basket prep failed '.mysqli_error($connection));
          }

          if(!mysqli_stmt_bind_param($stmt3,"ss",$updated_basket,$basket_id))
          {
            die('update basket bind failed '.mysqli_error($connection));
          } 

          if(!mysqli_stmt_execute($stmt3))
          {
            die('update basket execute failed '.mysqli_error($connection));
          }

          mysqli_stmt_close($stmt3);

          $_SESSION['success_basket'] = "Basket updated";
         
    }

    if(empty($updated_basket_array))
    {
        // delete the basket from the db if its empty and delete cookie   
        // DELETE BASKET QUERY

        $stmtDelete = mysqli_stmt_init($connection);
        $update_basket_query =" DELETE FROM basket WHERE id = ? ";
        
        if(!mysqli_stmt_prepare($stmtDelete,$update_basket_query))
        {
          die('update basket prep failed '.mysqli_error($connection));
        }  
        if(!mysqli_stmt_bind_param($stmtDelete,"s",$edit_id))
        {
          die('update basket bind failed '.mysqli_error($connection));
        }

        if(!mysqli_stmt_execute($stmtDelete))
        {
          die('update basket execute failed '.mysqli_error($connection));
        }

        mysqli_stmt_close($stmtDelete);

        // destroy the cookie 
        setcookie(BASKET_COOKIE,'',1);
        
        $_SESSION['success_basket'] = "Basket updated";
          
    }
    
?>

<?php echo ob_get_clean(); ?>