<?php 
require_once "includes/head.php";
require_once "functions.php";

$browser_id = session_id(); 

?>
 
<div id="jumper_contain" class="container">

    <?php
    if(isset($_POST["product_id"]))
    {
            $id = filter_input(INPUT_POST,"product_id");
            $title = filter_input(INPUT_POST,"title");
            $size = filter_input(INPUT_POST,"size");
            $price = filter_input(INPUT_POST,"price");
            $available = filter_input(INPUT_POST,"available");
            $image = filter_input(INPUT_POST,"image");
            $quantity = filter_input(INPUT_POST,"quantity");

            $id = filter_var($id,FILTER_SANITIZE_STRING);
            $title = filter_var($title,FILTER_SANITIZE_STRING);
            $size = filter_var($size,FILTER_SANITIZE_STRING);
            $price = filter_var($price,FILTER_SANITIZE_STRING);
            $available = filter_var($available,FILTER_SANITIZE_STRING);
            $image = filter_var($image,FILTER_SANITIZE_STRING);
            $quantity = filter_var($quantity,FILTER_SANITIZE_STRING);

            // set a new array that for posted item that will sent into query below 
            $basket_items_array = array();
            
            $basket_items_array[] = array(
            
                "product_id" => $id ,
                "title" => $title ,
                "size" => $size ,
                "price" => $price,
                "available" => $available,
                "image" => $image,
                "quantity" => $quantity
            
            );
    
            // check to see if basket cookie exists if it does then user already has a cart run code below
            if($basket_id != " ")
            {
        
                // find the shopping cart in database
                $query = "SELECT * FROM basket WHERE id = '$basket_id' ";
            
                $result = mysqli_query($connection,$query);
                $old_basket_row = mysqli_fetch_assoc($result); 
            
                //  fetch the basket from database and turn it back into an array just a single array at this point
                $old_basket_items = json_decode($old_basket_row['items'],true);
            
                // create variable to see if items match and set it to false
                $item_match = 0;

                // create an empty basket array so we can put our fetched shopping cart array inside after adding a new item
                // or adding to the quantity that the user wants to purchase
                $new_basket_items = array();

                // start loop  so we can see if we need to add a new item to the basket or just add to quantity
                foreach($old_basket_items as $basket_item)
                {
                    // if product id and size for one item are a match and in the db then we will add to the quantity instead of adding a new item to basket
                    // COMPARE NEW TO OLD THE NEW IS ON THE LEFT AND IS STILL A DOUBLE ARRAY(with 1 item in) THE OLD IS ON THE RIGHT AND IS A SINGLE
                    // which we are checking each item in
                    if($basket_items_array[0]['product_id'] == $basket_item['product_id'] && $basket_items_array[0]['size'] == $basket_item['size'])
                    {
                        // add to quantity still a single array as it is not inside the new one yet which is why is easier to add to 
                        $basket_item['quantity'] = $basket_item['quantity'] + $basket_items_array[0]['quantity'];
            
                        // check that desired quantity is not more than we have in stock if it is set quantity to total stock for that size
                        if($basket_item['quantity'] > $available )
                        {
                            $basket_item['quantity'] = $available;
                        }
                
                        // set item match to true as id and size was matched for item already in basket
                        $item_match = 1;
                    }   
            
                    // now after we have added to the quantity we then add the array/ updated item inside our new empty array
                    $new_basket_items[] = $basket_item;
                }// BUT IF a match was not found add new item to list
                if($item_match != 1)
                {
                    // join the two arrays New with the old
                $new_basket_items = array_merge($basket_items_array,$old_basket_items); 
                }

                // convert the joined array to string so we can add to database
                $basket_update_item = json_encode($new_basket_items);
        
                // run update query
                $stmt3 = mysqli_stmt_init($connection);
                $add_to_basket_query =" UPDATE basket SET items = ?, expire_date = ? WHERE id = ? " ;

                $basket_expire = date("Y-m-d H:i:s",strtotime("+30 days")); 

                if(!mysqli_stmt_prepare($stmt3,$add_to_basket_query))
                {
                    die('add to basket prep failed '.mysqli_error($connection));
                }

                if(!mysqli_stmt_bind_param($stmt3,"sss",$basket_update_item,$basket_expire,$basket_id))
                {
                    die('add to basket bind failed '.mysqli_error($connection));
                }

                if(!mysqli_stmt_execute($stmt3))
                {
                    die('add to basket execute failed '.mysqli_error($connection));
                }

                mysqli_stmt_close($stmt3);

                setcookie(BASKET_COOKIE,' ',1);
                setcookie(BASKET_COOKIE,$basket_id,$a_month);

            $_SESSION['success_basket']= $title. " was added to you basket.";  
            }
            else // if the shopping basket doesn't exist create in the database and set cookie with id of first item 
            {
                // ADD FIRST ITEM TO DATABASE

                // make sure cutsomers can not order more than is in stock 
                if($quantity > $available)
                {
                    $quantity = $available;
                }

                $basket_first_item = json_encode($basket_items_array);
                $basket_expire = date("Y-m-d H:i:s",strtotime("+30 days")); 
                
                $stmt2 = mysqli_stmt_init($connection);
                
                $basket_query ="INSERT INTO basket (items,expire_date)  VALUES(?,?) " ;
                
                if(!mysqli_stmt_prepare($stmt2,$basket_query))
                {
                    die('insert into basket prep failed '.mysqli_error($connection));
                }  
                
                if(!mysqli_stmt_bind_param($stmt2,"ss",$basket_first_item,$basket_expire ))
                {
                    die('insert into basket bind failed '.mysqli_error($connection));
                } 
                
                if(!mysqli_stmt_execute($stmt2))
                {
                    die('insert into basket execute failed '.mysqli_error($connection));
                }

                mysqli_stmt_close($stmt2);
                
                $basket_id = mysqli_insert_id($connection);
                
                setcookie(BASKET_COOKIE,$basket_id,$a_month);
                
                $_SESSION['success_basket']= $title. " was added to you basket.";
            }
        
    } 
    ?>

</div>
    
<?php include "includes/footer.php" ?>
   
<?php echo ob_get_clean(); ?>