
    <table class="table table-bordered table-hover table-striped  " >
        <thead>
            <th> Id </th>
            <th> Product</th>
            <th> Category</th>
            <th> Price</th>
            <th> Picture </th>
            <th> stock Xl </th>
            <th> stock Lg </th>
            <th> stock Md </th>
            <th> stock Sm </th>
            <th> stock adt </th>
            <th> stock chds </th>
            <th> stock oneSIZE </th>
            <th> Total stock </th>
            <th> Total sold </th> 
            <th> Edit  </th>
            <th> Delete  </th>
           
        </thead>
           
        <tbody>
                <?php       
                $query = "SELECT * FROM products LEFT JOIN categories ON cat_id = category LIMIT $page1,10 "; 
                $result = mysqli_query($connection,$query);
                if(!$result)
                {
                    die("select products failed".mysqli_error($connection));
                }

                while($row = mysqli_fetch_assoc($result))
                { ?> 
                <tr>
                    <td> <?php echo $row['id']; ?> </td>
                    <td> <?php echo  $row['title']; ?>  </td>
                    <td> <?php echo  $row['cat_name']; ?> </td>
                    <td> <?php echo  $row['price']; ?>  </td>
                    <td> <img class="product_table_pic" width="80px" height="100px" src="../<?php echo  $row['image_1']; ?>"> </td>
                    <td> <?php echo  $row['size_xl']; ?> </td>
                    <td> <?php echo  $row['size_lg']; ?>  </td>
                    <td> <?php echo  $row['size_md']; ?> </td>
                    <td> <?php echo  $row['size_sm']; ?> </td>
                    <td> <?php echo  $row['size_adult']; ?>  </td>
                    <td> <?php echo  $row['size_child']; ?>  </td>
                    <td> <?php echo  $row['size_onesize']; ?>  </td>
                    <td> <?php echo  $row['total_stock']; ?> </td>
                    <td> 0 </td>
                    <td> 
                        <a href="products.php?product=edit&item=<?=$row['id'] ?>">  
                            <button class="btn btn-dark btn-sm" type="button">  Edit <i class="fas fa-pencil-alt"></i>  </button> 
                        </a> 
                    </td>
                    
                    <!-- delete product btn opens the modal so we pass it all the values via attributes  -->
                    <td> <a class="delete_btn_to_open_modal" rel="<?= $row['id']?>" id="<?= $row['title'] ?>" >
                            <input type="hidden"  class="send_title" rel="<?= $row['image_1'] ?>" value="<?= $row['cat_name'] ?>">    
                            <button class="btn btn-danger btn-sm"  type="button">  Delete <i class="fas fa-trash "></i>  </button> 
                        </a>  
                    </td>
                </tr>  <?php
                 
                }  ?>  
              
        </tbody>

    </table>
       
    <br>     
       

    <div id="pagination_div"> 

        <!-- Pager -->
        <?php
        // dont let page go below 0 as nothing wil be there causing error
        if($all_posts !== 0)
        {

                // back a page setting  
                $previous = $page -1 ;
                
                if($previous <= 0)
                {
                    $previous = 1;
                } ?>

            <ul class="pager nav" id="pagination_list">
                
                <li class="previous">
                    <a href="products.php?page=<?php echo $previous; ?>" class='previous'>&larr; Previous </a>
                </li> 

                <?php
                $query1 = "SELECT * FROM products ";
                $result1 = mysqli_query($connection,$query1);
                    
                if(!$result1)
                {
                    die('select all products for pagination failed'.mysqli_error($connection));
                }

                // get number of rows back and round up with ceil so we dont miss any
                $count = ceil(mysqli_num_rows($result1)/10);

                for($i = 1; $i <= $count; $i++ )
                {
                    if($page == $i)
                    {
                        echo " <li> <a class='page_number active' href='products.php?page=$i'> $i </a> </li> ";
                    }
                    else
                    {
                        echo " <li  > <a class='page_number'  href='products.php?page=$i'> $i </a> </li> ";
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
                } ?>

                <li class="next">
                    <a href="products.php?page=<?php echo $next ?>" class="next">Next &rarr;</a>
                </li>


            </ul>
            <?php 
        } ?>  


            
    </div>

</div> 



