<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";
    // check user is allowed to view admin page if not redirect
    if(!isset($_SESSION['id']) || $_SESSION['id'] == " ")
    {
        $_SESSION['error_flash'] = "You must be logged in to view that page";
        header("Location: login.php");
    }

    if(isset($_GET['order_id']))
    {
      $order_id = mysqli_real_escape_string($connection,$_GET['order_id']); 
    }
    
    $query = " SELECT * FROM orders WHERE id = $order_id " ;
    $result = mysqli_query($connection,$query);
    if(!$result)
    {
        die("orders result failed".mysqli_error($connection));
    }
    
    $row = mysqli_fetch_assoc($result);
    
    $id = $row['id'];
    $customer_details = json_decode($row['customer_details'],true);
    $ordered_items = json_decode($row['ordered_items'],true);
    $total_paid = $row['total_paid'];
    $order_date = $row['order_date'];
    
   // convert date to string so we can get the month and year below
    $date_as_string = strtotime($order_date);

    // get date and year value  so it can be used in $_GET direct us back to the right page once dispatch status has been changed
    $month_of_order = date("m",$date_as_string);
    $year_of_order = date("Y",$date_as_string);

    $order_dispatched = $row['order_dispatched'];
    $dispatch_date = $row['dispatch_date']; 

?> 

<div class="container" id="jumper_contain">

    <h3 class="text-center order_title test">Order reference number <?= $order_id ?>  </h3>

    <div class="row">
     
        <div class="col md-4">
        
            <h4 class="test"> Order details </h4> 
          
            <?php // get the order
                $i = 1;
                foreach($ordered_items as $items)
                {
                    echo "#".$i; echo "<br>";
                    echo "id = "; echo $items['product_id']; echo "<br>";
                    echo "name = "; echo $items['title']; echo "<br>";
                    echo "size = "; echo $items['size']; echo "<br>"; ?>
                    <img src="<?= $items['image'] ?> " width="100px" height="150px" > <?php echo "<br>";
                    echo "quantity = "; echo $items['quantity']; echo "<br> <br>";
                    $i++;
                
                } ?>

        </div>

        <div class="col md-4">
            <h4 class="test"> Delivery Address</h4>
            <?php
                foreach($customer_details as $details)
                {
                    echo  $details; echo "<br>";
                } ?>  
        </div>

        <div class="col md-4">
            <h4 class="test">Order summary</h4> <?php

                // order summary
                echo "Total Paid: £". $total_paid. "<br>"; 
               
                echo "Order Date: ". $order_date. "<br> <br>  "; ?>

                <h6 class="text-center"> Delivery Status</h6> <?php
                
                // sent status
                if($order_dispatched == 0)
                { ?>
                       <b> Status:   </b>  <span class="text-danger"> Not sent </span> 
                        <br> <?php 
                }
                else
                { ?>
                    Status:  <span class="text-success">  Dispatched </span> 
                    <br>  <?php 
                } ?>
                       
                <br> <br>
                       
                <b> Date order was sent: </b>  <?php 
                    if($dispatch_date == "Not sent")
                    { ?> 
                     <span class='text-danger'>  <?= $dispatch_date; ?>   </span>    <?php 
                    }
                    else
                    { ?>
                        <span class='text-success'>  <?= $dispatch_date; ?>   </span>    <?php 
                    } ?>
                      
                    <br> <br>
                   
        </div>
     

    </div>
   
    <a class="btn btn-lg btn-dark" href="user_home.php"> Go back </a>

</div>
               
    
<?php include "includes/footer.php"; ?>