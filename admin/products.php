<?php 
require_once "includes/head.php";
require_once "includes/navigation.php"; 

// set  modal error message vars
  $modal_msg = " " ; 
  $modal_msg_alert = " ";

//  DELETE PRODUCT QUERY  //
if(isset($_POST['delete_submit']))
{
    // get values for query
    $id =  filter_var($_POST['id'],FILTER_SANITIZE_STRING); 
    $password = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
    $password_con = filter_var($_POST['pass_con'],FILTER_SANITIZE_STRING);

    // check password match
    if($password !== $password_con)
    {
        $modal_msg = "passwords do no match... deleted failed";
        $modal_msg_alert = "alert-danger";
    }

    // password verfication so that only auth staff can delete
    if(!password_verify($password,$master))
    {
        $modal_msg = "Wrong password entered... deleted failed  ";
        $modal_msg_alert = "alert-danger";
    }
    elseif($modal_msg == " " && $modal_msg_alert == " " )  // passed password verification run delete query
    {
        
        $stmt_del = mysqli_stmt_init($connection);
        $query_del = "DELETE FROM products WHERE id = ? ";
 
        if(!mysqli_stmt_prepare($stmt_del,$query_del))
        {
            die("prep del failed".mysqli_error($connection));
        }
 
        if(!mysqli_stmt_bind_param($stmt_del,'i',$id))
        {
            die("del bind failed".mysqli_error($connection));
        }
 
        if(!mysqli_stmt_execute($stmt_del))
        {
            die("del execute failed".mysqli_eror($connection));
        }

        mysqli_stmt_close($stmt_del);
 
  
    }  

}



//  <!-- Setting For Pagination  -->  
  if(isset($_GET['page']))
  {
      $page = mysqli_real_escape_string($connection,$_GET['page']);
  }
  else
  {
      $page = " ";
  }

  if($page === " " || $page === 0 )
  {
      $page1 = 0;
  }
  else
  {
      $page1 = ($page * 10) -10;
  }



# <!-- Setting For Stock page  -->  
  if(isset($_GET['product']))
  {
      $stock_page = mysqli_real_escape_string($connection,$_GET['product']);
  }
  else
  {
      $stock_page = " " ;
  }
 
?>



  <div class="<?= $modal_msg_alert ?>"> <?= $modal_msg; ?> </div>

  <h2 class="text-center order_title"> <a id="products_title" href="products.php"> Products </a> </h2>


<div class="container">
    <div class="row">
      <?php 
      if($stock_page == 'edit' || $stock_page == 'add')
      { ?>
          <div class="col-sm-1"> </div>   
        
          <div class="col-sm-10"> <?php   
      } ?>
  
          <div class="text-center"> 
        
            <?php
            // set active classes for sub menu 
            if($stock_page != "add" && $stock_page != 'edit')
            { 
        
                if($stock_page == 1)
                { ?>
                      <a class="admin_product_menu active" href="products.php?product=1">T shirts </a> <?php 
                }
                else
                { ?> 
                      <a class="admin_product_menu " href="products.php?product=1">T shirts </a> <?php 
                } 
              
                
                if($stock_page == 2)
                { ?>
                    <a class="admin_product_menu active" href="products.php?product=2"> Jumpers </a> <?php 
                }
                else
                { ?> 
                    <a class="admin_product_menu " href="products.php?product=2"> Jumpers </a> <?php 
                } 
            
        
                if($stock_page == 3)
                { ?>
                    <a class="admin_product_menu active" href="products.php?product=3"> Hats </a> <?php 
                } 
                else
                { ?> 
                    <a class="admin_product_menu" href="products.php?product=3"> Hats </a> <?php 
                } 
                
  
                if($stock_page == 4)
                { ?> 
                    <a class="admin_product_menu active" href="products.php?product=4"> Accessories</a> <?php 
                }
                else
                { ?> 
                    <a class="admin_product_menu" href="products.php?product=4"> Accessories</a> <?php 
                } 
                
                
                if($stock_page == 5)
                { ?> 
                    <a class="admin_product_menu active" href="products.php?product=5"> Sale</a> <?php 
                }
                else
                { ?> 
                    <a class="admin_product_menu " href="products.php?product=5"> Sale </a> <?php 
                } ?> 
            

                <br>  <br>  
            
                <div class=text-center>  <a class="btn-sm btn-success" href="products.php?product=add" >Add new product</a> </div> 
                
                <br> 
              
                <?php 
            } ?>
      
            
              <div class="<?= $modal_msg_alert ?>"> <?= $modal_msg ?> </div>  
    
              <div class="text-center">  
                 
                  <?php    //  show default table or form to include in the page    
                    if($stock_page == " ")
                    {
                        include "includes/products_view_all.php";
                    }
                    else if($stock_page == "add")
                    {
                        include "includes/products_add.php";
                    }
                    else if($stock_page == "edit")
                    {
                        include "includes/products_edit.php";
                    }
                    else
                    {
                        include "includes/products_view_category.php";
                    } 

      include "includes/delete_modal.php"; ?>

      <div class="<?= $modal_msg_alert; ?>"> <?= $modal_msg; ?> </div> 
 
    <?php include "includes/footer.php" ?>