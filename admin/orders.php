<?php 
require_once "includes/head.php";
require_once "includes/navigation.php";
 
    $this_year = date("Y");
    $last_year = $this_year - 1;
    $this_month = date("m");
    $next_month = $this_month + 1;
    $last_month = $this_month - 1;

?>
    <div class="container" id="jumper_contain">
       
        <h1 class="text-center order_title">Orders</h1>
    
            <div class="row">
               
                <div class="col-md-12"> 
                
                    <?php
                    if(isset($_GET['source']))
                    {
                        $source = mysqli_real_escape_string($connection,$_GET['source']);
                    }
                    else
                    {
                        $source = '';  
                    }

                    switch($source)
                    {
                        case "view_order":
                        include "includes/orders_view_order.php";
                        break;

                        case "view_monthly": 
                        include "includes/orders_view_all.php";
                        break;

                        default:
                        include "includes/orders_choose.php";
                    }  
                    ?>


                </div>
       
            </div>
    </div> 

    <?php include "includes/footer.php"; ?>





<?php 

// update order dispatched

$date_sent = date("Y-m-d H:i:s");  
$reset_date_sent = "Not sent";  
$sent = 1;
$not_sent = 0;


if(isset($_GET['dispatched']))
{
    $dispatched = filter_var($_GET['dispatched'],FILTER_SANITIZE_STRING);

    $id_to_update = filter_var($_GET['dispatch_id'],FILTER_SANITIZE_STRING);

    if($dispatched == "yes")
    {
        $stmt = mysqli_stmt_init($connection);   
        $query = "UPDATE orders SET order_dispatched = ?, dispatch_date = ? WHERE id = ? " ;
        
        if(!mysqli_stmt_prepare($stmt,$query))
        {
            die("dispatch prep failed".mysqli_error($connection));   
        }

        if(!mysqli_stmt_bind_param($stmt,"isi",$sent,$date_sent,$id_to_update))
        {
            die("dispatch bind failed".mysqli_error($connection));   
        }

        if(!mysqli_stmt_execute($stmt))
        {
            die("dispatch execute failed".mysqli_error($connection));   
        }

        mysqli_stmt_close($stmt);
        
        header("Location: orders.php?source=view_monthly&month=$selected_month&year=$selected_year");
    }  


    if($dispatched == "no")
    {
        
        $stmt = mysqli_stmt_init($connection);   
        $query = "UPDATE orders SET order_dispatched = ?, dispatch_date = ? WHERE id = ? " ;
        
        if(!mysqli_stmt_prepare($stmt,$query))
        {
            die("dispatch prep failed".mysqli_error($connection));   
        }

        if(!mysqli_stmt_bind_param($stmt,"isi",$not_sent,$reset_date_sent,$id_to_update))
        {
            die("dispatch bind failed".mysqli_error($connection));   
        }

        if(!mysqli_stmt_execute($stmt))
        {
            die("dispatch execute failed".mysqli_error($connection));   
        }

        mysqli_stmt_close($stmt);
        
        header("Location: orders.php?source=view_monthly&month=$selected_month&year=$selected_year");
    } 

    

}

?>