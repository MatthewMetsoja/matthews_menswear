
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <th> Id </th>
            <th> Name</th>
            <th> Username</th>
            <th> Picture</th>
            <th> Permission </th>
            <th> Email </th>
            <th> Join date </th>
            <th> Last Login </th>
            <th> Edit  </th>
            <th> Delete  </th> 
        </thead>

        <tbody>
            <?php 
            $query = "SELECT * FROM users WHERE permissions != 'user' LIMIT $page1,10 "; 
            $result = mysqli_query($connection,$query);
            
            if(!$result)
            {
                die("select products failed".mysqli_error($connection));
            }

            while($row = mysqli_fetch_assoc($result))
            { ?> 
                <tr>
                    <td> <?php echo $row['user_id']; ?> </td>
                    <td> <?php echo  $row['first_name']." ".$row['last_name'];  ?>  </td>
                    <td>  <?php echo  $row['user_name']; ?> </td>
                    <td> <img class="product_table_pic " width="80px" height="100px" src="../<?php echo  $row['user_pic']; ?> "> </td>
                    <td> <?php echo  $row['permissions']; ?>  </td>
                    <td>  <?php echo  $row['email']; ?> </td>
                    <td> <?php echo  date("M d Y h:i A", strtotime($row['join_date']));  ?> </td>
                    <td> <?php echo $row['last_login'] == $row['join_date'] ? "Never" : date("M d Y h:i A", strtotime($row['last_login']))  ?> </td>
                    <td> <a href="staff.php?user=edit&who=<?=$row['user_id']; ?>">  <button class="btn btn-dark btn-sm" type="button">  Edit <i class="fas fa-pencil-alt    "></i>  </button> </a> </td>
                    
                    <!-- delete product btn opens the modal so we pass it all the values via attributes  -->
                    <td> 
                        <a class="delete_btn_to_open_modal" rel="<?= $row['user_id'];?>" id="<?= $row['user_name']?>" >
                            <input type="hidden"  class="send_title" rel="<?= $row['user_pic']; ?>" value=" the system ?">      
                            <button class="btn btn-danger btn-sm"  type="button">  Delete <i class="fas fa-trash "></i>  </button> 
                        </a>  
                    </td>
                </tr> <?php 
            }   ?>  
              
        </tbody>
        
    </table>
       
    <br>     
       
    <!-- Pager -->
    <div id="pagination_div"> 
    
        <?php
        // dont let page go below 0 as nothing wil be there causing error
        if($all_posts !== 0)
        {
                // back a page setting  
                $previous = $page -1 ;
                if($previous <= 0)
                {
                    $previous = 1;
                }  ?>

            <ul class="pager nav" id="pagination_list">
                
                <li class="previous">
                    <a href="staff.php?page=<?php echo $previous ?>" class='previous'>&larr; Previous </a>
                </li> 

                <?php
                $query1 = "SELECT * FROM users WHERE permissions != 'user' ";
                $result1 = mysqli_query($connection,$query1);
                    
                if(!$result1)
                {
                    die('select all products for pagination failed'.mysqli_error($connection));
                }

                // get number of rows back and round up with ceil so we dont miss any
                $count = ceil(mysqli_num_rows($result1)/10);

                for($i = 1; $i <= $count; $i++ )
                {
                    if($page == $i) // active page
                    {
                        echo " <li> <a class='page_number active' href='staff.php?page=$i'> $i </a> </li> ";
                    }
                    else
                    {
                        echo " <li  > <a class='page_number'  href='staff.php?page=$i'> $i </a> </li> ";
                    }
                }

                    // forward a page setting  
                    if($page > 1)
                    {
                        $next = $page +1;
                    }
                    elseif($page == 0 || $page = " ")
                    {
                        $next = $page +2;
                    }
                    
                    // dont let pages go above how many there are
                    if($next >= $count)
                    {
                        $next = $count;
                    }  ?>
           
                <li class="next">
                    <a href="staff.php?page=<?php echo $next ?>" class="next">Next &rarr;</a>
                </li>

            </ul>   <?php

        } ?>  


    </div>

</div> 



