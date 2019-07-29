<?php
// set up for pagination
$dt = DateTime::createFromFormat('!m',$i); 

  if(isset($_GET['page']))
  {
      $page = mysqli_real_escape_string($connection,$_GET['page']);
  }
  else
  {
      $page = " ";
  }


  if($page == 1 || $page == " ")
  {
      $start_number = 0;
  }
  else
  {
      $start_number = ($page * 20) - 20;
  }


  // set up for select orders by month and year
  if(isset($_GET['month']))
  {
      $selected_month = mysqli_real_escape_string($connection,$_GET['month']);
  }
  else
  {
      $selected_month = " ";
  }

  if(isset($_GET['year']))
  {
      $selected_year = mysqli_real_escape_string($connection,$_GET['year']);
  }
  else
  {
      $selected_year = " ";
  }
      
            
  $query = "SELECT * FROM orders WHERE MONTH(order_date) = $selected_month AND YEAR(order_date) = $selected_year ORDER BY id DESC LIMIT $start_number,20  " ;
  
  $result = mysqli_query($connection,$query);
  
  if(!$result){die("orders result failed".mysqli_error($connection));}
  
  $number_of_orders = mysqli_num_rows($result);
    
  
  // display message if there are no orders for the month
  if($number_of_orders == 0)
  { ?>
      <h2 class="text-danger text-center"> There are no orders to show for this month</h2> 
      
      <p class="text-center">
          <b> Please check that you have not selected a month/date that is in the future. </b> 
      </p>
     
      <div class="text-center">
          <a class="btn btn-dark btn-lg" href="orders.php">Go back </a>  
      </div> <br>  <?php
  }
  else
  { // display orders if there are some to display ?>

        <!-- DISPLAY RESULTS IN TABLE -->
      <h5 class="text-center order_title"> 
          Orders for  <?php $format_month = DateTime::createFromFormat('!m',$selected_month); echo $format_month->format("F"). " ". $selected_year; ?>  
      </h5>

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
      
            <tbody> <?php
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
                $dispatch_date = $row['dispatch_date']; ?>
                            
                <tr> 
                    <td> <?= $id; ?> </td>
                    <td> <?= $customer_details['full_name']; ?> </td>
                    <td> <?= $count_items. " items ordered"; ?> </td>
                    <td> £<?= $total_paid; ?> </td>
                    <td> <?= date('F j, Y g:iA',strtotime($order_date))?> </td>
                    <td><?php 
                        if($order_dispatched == 0)
                        { ?>
                            <span class="text-danger"> Not sent </span>  <br> <?php 
                        }
                        else
                        { ?>  
                            <span class="text-success"> Dispatched </span>  <?php 
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
                    
                </tr> <?php
              } ?>
            </tbody>

        </table>

        <?php 
        // get total by selecting all from the month without a limit else we will have to different totals on each pagination page.
        $query_total = "SELECT * FROM orders WHERE MONTH(order_date) = $selected_month AND YEAR(order_date) = $selected_year " ;
        $result_total = mysqli_query($connection,$query_total);
        
        if(!$result_total)
        {
          die("orders result failed".mysqli_error($connection));
        }
        
        $total_sales = 0;
        
        while($row_total = mysqli_fetch_assoc($result_total))
        {
            $t_p = $row_total['total_paid'];
            
            $total_sales += $t_p ;
        } ?>            
                
          <div class="float-right"> <p> <b> Total sales:</b> £<?= number_format($total_sales,2) ?></p></div>
                
          <br>
            
        <?php  // select with no limit for pagination
          $pagination_query = "SELECT * FROM orders WHERE MONTH(order_date) = $selected_month AND YEAR(order_date) = $selected_year " ;
          $pagination_result = mysqli_query($connection,$pagination_query);
          
          if(!$pagination_result)
          {
            die("orders result failed".mysqli_error($connection));
          }

          $pagination_number_of_orders = mysqli_num_rows($pagination_result);

          $divide_for_pag = ceil($pagination_number_of_orders/20);        

          if($pagination_number_of_orders > 20)
          { ?>
            
              <div id="order_pagination_div"> 
                <ul class="pager nav" id="month_pagination">
                 
                  <?php
                    // back a page setting  
                    $previous = $page -1 ;
                  
                    if($previous <= 0)
                    {
                        $previous = 1;
                    } ?>
              
                      <li> 
                        <a id="previous_month_pag" href="orders.php?source=view_monthly&month=<?=$selected_month?>&year=<?=$selected_year?>&page=<?= $previous ?>"> 
                          <i class="fas fa-arrow-left"></i> Previous 
                        </a>
                      </li> <?php
              
                    // monthly pagination
                    for($p = 1; $p < $divide_for_pag; $p++)
                    {
                        if($page == $p)
                        {
                            $active = "active";
                        }
                        else
                        { 
                            $active = " ";
                        } ?>  
                      
                        <a class="order_pagination_number <?= $active ?>" href="orders.php?source=view_monthly&month=<?=$selected_month?>&year=<?=$selected_year?>&page=<?= $p ?> ">
                          <?= $p ?> 
                        </a>  <?php 
                    }  
                    
                    if($page = " ")
                    {
                        $next = 2;
                    }
                    else
                    {
                        $next = $page +1 ;
                    }
                    
                    if($next >= $divide_for_pag)
                    {
                        $next = $divide_for_pag;
                    } ?>

                      <li id="next_li"> 
                          <a id="next_month_pag"  href="orders.php?source=view_monthly&month=<?=$selected_month?>&year=<?=$selected_year?>&page=<?= $next ?>"> 
                              Next <i class="fas fa-arrow-right "></i> 
                          </a>
                      </li>
              </ul>
            <br> <?php 
          }
  } ?>
          </div> <br>

      <div class="text-center"> <a class="btn btn-dark btn-lg" href="orders.php">Go back to month select </a>  </div> 
      
      <br>