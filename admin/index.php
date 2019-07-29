<?php 
require_once "includes/head.php";
require_once "includes/navigation.php";

$this_year = date("Y");
$last_year = $this_year - 1;
$this_month = date("m");
$next_month = $this_month + 1;
$last_month = $this_month - 1;

?>
    
  <h2 id="admin_head" class="text-center order_title">Admin   <small class="text-center">  <?= $_SESSION['first_name']. " ".$_SESSION['last_name']; ?> </small> </h2>
    
  <div class="container-fluid">
      
      <div class="row"> 
          
          <div class="col-6">
            
              <h4 class="text-center order_title">Order that need to be dispatched</h4>
            
              <table class="table-inverse table-hover table-responsive">
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
                    $query = "SELECT * FROM orders WHERE order_dispatched = 0 " ;  
                    $result = mysqli_query($connection,$query);
                            
                    if(!$result)
                    {
                      die("orders result failed".mysqli_error($connection));
                    }
                            
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $id = $row['id'];
                        $customer_details = json_decode($row['customer_details'],true);
                        $ordered_items = json_decode($row['ordered_items'],true);
                        $count_items = count($ordered_items);        
                        $total_paid = $row['total_paid'];
                        $order_date = $row['order_date'];
                        $order_dispatched = $row['order_dispatched'];
                        $dispatch_date = $row['dispatch_date']; ?>
                            
                      <tr> 
                          <td> <?= $id ?></td>
                          
                          <td> <?= $customer_details['full_name']; ?> </td>
                          
                          <td> <?= $count_items. " items ordered" ?> </td>
                          
                          <td> £<?= $total_paid ?> </td>
                          
                          <td> <?= date('F j, Y g:iA',strtotime($order_date))?> </td>
                          
                          <td> <?php 
                                if($order_dispatched == 0)
                                { ?>
                                    <span class="text-danger"> Not sent </span>  <br> <?php 
                                }
                                else
                                { ?>  
                                    <span class="text-success"> Dispatched </span>   <?php 
                                } ?>
                          </td>

                          <td> <?php 
                                if($dispatch_date !== "Not sent")
                                {
                                  echo date('F j, Y g:iA' , strtotime($dispatch_date)); 
                                }
                                else
                                {
                                  echo "<span class=text-danger>". $dispatch_date. "</span>";  
                                } ?> 
                          </td> 
                            
                          <td> <a id="view_order"href="orders.php?order_id=<?=$id?>&source=view_order">View</a></td> 
                            
                      </tr>    <?php

                    } ?> 

                  </tbody>
              </table>


          </div>
            
          <div class="col-6"> 
             
              <h4 class="text-center order_title">Monthly sales reports </h4>
    
              <table class=" table table-bordered"> 
                  
                  <thead>
                      <th> Months</th>
                      <th> <?= $last_year ?></th>
                      <th> <?= $this_year ?>  </th>
                  </thead>

                  <?php // show all months (loop and convert) 
                  for($i = 1; $i <= 12; $i++)
                  {   
                      $dt = DateTime::createFromFormat('!m',$i); ?>
                      
                      <tr>
                            <td> <?= $dt->format("F"); ?>  </td> <?php
                      
                            // last year sales
                            $query_last_year = "SELECT * FROM orders WHERE MONTH(order_date) = $i AND YEAR(order_date) = $last_year  ORDER BY id  ";
                            $result_last_year = mysqli_query($connection,$query_last_year);
                            
                            if(!$result_last_year)
                            {
                              die("result last year failed".mysqli_error($connection));
                            }
                      
                              $sale = 0;  
                      
                            while($row_last_year = mysqli_fetch_assoc($result_last_year))
                            {
                       
                              $sale +=  $row_last_year['total_paid'];
                        
                            } ?>

                              
                            <td> <?= "£".$sale ?>  </td> 
                    
                            <?php $last_year_total += $sale; 
                    
                            // this year sales
                            if($i <= $this_month)
                            {
                                $query_this_year = "SELECT * FROM orders WHERE MONTH(order_date) = $i AND YEAR(order_date) = $this_year ";
                                $result_this_year = mysqli_query($connection,$query_this_year);
                     
                                if(!$result_this_year)
                                {
                                  die("result this year failed".mysqli_error($connection));
                                }
                     
                                  $sale_1 = 0; 

                                while($row_this_year = mysqli_fetch_assoc($result_this_year))
                                {
                                  $sale_1 += $row_this_year['total_paid'];

                                } ?>

                            <td> <?= "£". $sale_1; ?>  </td> 
                                
                                <?php $this_year_total += $sale_1;  
                            } ?>
                      
                      <tr> <?php
                  
                 } ?>

              </table>           
                    
              <div>              
                  <p> 
                      <h5> <b class="order_title"> Total sales for the Year: </b>  </h5>  
                        
                      <b>  <?= $last_year.":" ?> </b> <?= "£". $last_year_total ?>  <br>
                        
                      <b> <?= $this_year.":" ?> </b> <?= " £". $this_year_total ?>  
                  </p>           
              </div>

          </div>
                   
          <div class="col-4"></div>

      </div>
  </div> 

<?php include "includes/footer.php"; ?>