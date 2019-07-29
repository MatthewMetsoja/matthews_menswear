<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php"; 
require_once "functions.php"; 

if(!isset($_SESSION['id']) || $_SESSION['id'] == " ")
{
    $_SESSION['error_flash'] = "You must be logged in to view that page";
    header("Location: login.php");
}

?>

<div class="container-fluid" id="jumper_contain">
  <div class="row"> 
  
    <div class="col-sm-1"> </div>    

    <div id="users_order_table" class="col-sm-10" >
      <?php            
        $query = "SELECT * FROM orders " ;
        $result = mysqli_query($connection,$query);
        if(!$result)
        {
          die("orders result failed".mysqli_error($connection));
        }
        
        $number_of_orders = mysqli_num_rows($result); 
      ?>
        
      <!-- DISPLAY RESULTS IN TABLE -->
      <h5 class="text-center order_title"> Orders for  <?= $_SESSION['username'];  ?>  </h5>
          
      <table class="table-bordered table-hover table-responsive">
        <thead>
            <th width="5%">Order Id</th> 
            <th width="20%">Customer Name</th>
            <th width="10%">Details </th>  
            <th width="15%">Total Paid</th> 
            <th width="15%">Order date</th> 
            <th width="5%">Order dispatched</th>
            <th width="10%">Dispatch date</th> 
            <th width="2%">View order</th>        
        </thead>
                            
        <tbody> 
          <?php
            while($row = mysqli_fetch_assoc($result))
            {
              $id = $row['id'];
              $customer_details = json_decode($row['customer_details'],true);
              $ordered_items = json_decode($row['ordered_items'],true);
              $count_items = count($ordered_items);        
              $total_paid = $row['total_paid'];
              $total_sales += $total_paid;
              $order_date = $row['order_date'];
              $order_dispatched = $row['order_dispatched'];
              $dispatch_date = $row['dispatch_date']; 
          
              $_SESSION['first_name'] = $first_name;
              $_SESSION['last_name'] = $last_name;
              $full_name = $first_name." ".$last_name;
          
              if($customer_details['email'] == $_SESSION['email'] || $customer_details['full_name'] == $full_name  )
              { ?>
                <tr> 
                    <td> <?= $id ?></td>
                    <td> <?= $customer_details['full_name']; ?> </td>
                    <td> <?= $count_items. " items ordered" ?> </td>
                    <td> £<?= $total_paid ?> </td>
                    <td> <?= date('F j, Y g:iA',strtotime($order_date))?> </td>
                    <td> 
                      <?php 
                        if($order_dispatched == 0)
                        { ?>
                            <span class="text-danger"> Not sent </span>  <br> <?php 
                        }
                        else
                        { ?>  
                            <span class="text-success"> Dispatched </span>   <?php 
                        } ?>
                    </td>
                    <td> 
                      <?php 
                        if($dispatch_date !== "Not sent")
                        {
                          echo date('F j, Y g:iA' , strtotime($dispatch_date)); 
                        }
                        else
                        {
                          echo "<span class=text-danger>". $dispatch_date. "</span>";  
                        } ?> 
                    </td> 

                    <td> <a id="view_order"href="users_orders.php?order_id=<?=$id?>">View</a></td> 
                </tr> <?php

              }


            } ?>

        </tbody>
      </table>
              
    </div>
      
    <div class="col-sm-1"> </div>          
    <br>
  </div>
</div>

<?php include "includes/footer.php"; ?>
