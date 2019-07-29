<?php 
require_once "includes/head.php";
require_once "includes/navigation.php"; 
require_once "functions.php";
?>

<div id="jumper_contain" class="container">

  <div class="row" id="the_basket">
      
    <div class="col-sm-12">
          
      <h2 class="text-center"> Basket <i class="fas fa-shopping-cart"></i> </h2> 
   
      <?php 
      if($basket_id == " ")
      { ?>
        <div> 
          <p class="text-center"> Your basket is empty </p> 
        </div> <?php
      }
      else //set counter for number of differerent items
      {  
          $i = 1;
      
          // set counter for total quantity
          $total_quantity_count = 0;
        
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
        
          ?>

          <h5 class="text-center">Order details</h5>
    
          <table class="table table-inverse">
          
            <thead class="thead-inverse">
                <th width=2%>#</th>
                <th width=15%>Item</th>
                <th width=10%></th>
                <th width=10%>size</th>
                <th width=10%>Quantity</th>
                <th width=10%>Price</th>
                <th width=10%>Total</th>
                <th width=10%>Action</th>       
            </thead>
         
            <tbody>
              <?php  // break down the array into single items and and output them in bakset table 
              foreach($full_basket_as_array as $basket_item)
              { ?>
                <tr>
                    <?php $total = $basket_item['price'] * $basket_item['quantity']; ?>
                    
                    <td> <?= $i ?>.</td>
                      
                    <td> <?= $basket_item['title'] ?>  </td>
                      
                    <td>  <img src="<?= $basket_item['image'] ?>" width="75px" height="75px"> </td>
                      
                    <td id="size_row"><?= $basket_item['size']?></td>
                      
                    <td>  
                          <!-- add one to quantity button  -->
                          <button class="minus_one_btn  btn-xs" rel="<?= $basket_item['product_id'] ?>"  value="<?= $basket_item['size'] ?>"  id=""> - </button>
                              
                          <?php 
                          
                          echo $basket_item['quantity']; 

                          if($basket_item['quantity'] < $basket_item['available'])
                          { ?> 
                            <!-- take one from quantity button  -->
                            <button class="plus_one_btn  btn-xs" rel="<?= $basket_item['product_id'] ?>" value="<?= $basket_item['size'] ?>"  id=" ">  + </button> <?php 
                          }
                          else 
                          { ?>
                            <br> <span class="text-danger stock_warning"> <br> only <?= $basket_item['available'] ?> left in stock! </span>  <?php 
                          } ?>

                    </td>
                  
                    <td> £<?= number_format((float)  $basket_item['price'],2);  ?> </td>
                      
                    <td> £<?= number_format((float)  $total,2); ?> </td>
                      
                    <td> 
                        <button class="remove_from_basket_btn  btn-sm btn-danger" rel="<?= $basket_item['product_id'] ?>" value="<?= $basket_item['size'] ?>">
                            Remove 
                        </button> 
                    </td>
                </tr>
                    
                    <?php // grand_total get worked out by looping round and adding to itself on each go  then gets echoed outside of the loop
                          
                    $grand_total = $grand_total + ($basket_item['quantity'] * $basket_item['price']) ; 
                          
                      // add quantity to total quantity count
                    $total_quantity_count += $basket_item['quantity'];
                          
                      // work out tax
                    $tax = TAXRATE * $grand_total;
                    $tax = number_format((float) $tax,2);


                    // increment item counter;
                    $i++;
              }
  
                mysqli_stmt_close($stmt); ?>
            </tbody>
          </table>  

          <div id="checkout_price_and_btn"> 
              <div id="basket_total"> <b> Total items </b>  <?= $total_quantity_count?>  </div> <br> 
              <div id="basket_total"> <b>Basket total </b>  £<?=  number_format($grand_total,2) ?>  </div> <br>
              <div id="basket_total"> <b> Tax and VAT</b>  £<?= $tax ?>  </div> <br> <br> 
              <div id="basket_total"> <b> Grand total </b>  £<?php $real_grand_total = $grand_total + $tax; echo number_format($real_grand_total,2);   ?>  </div> <br>  
              <div id="check_out_btns">      
                  <!-- Button trigger modal -->
                  <a class="btn btn-success" id="checkout_btn" href="check_out.php">   <i class="fas fa-shopping-cart"></i>  Checkout </a>
              </div> 
          </div>  <?php
            
      }    ?>
          
    </div>
  </div>
</div>
    
  <?php include "includes/footer.php"; ?>
    
  <?php echo ob_get_clean(); ?>