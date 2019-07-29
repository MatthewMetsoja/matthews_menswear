<?php 
require_once "includes/head.php";
require_once "includes/navigation.php"; 

// set  modal error message vars
$modal_msg = " " ; 
$modal_msg_alert = " ";


#<!-- DELETE QUERY  -->
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
        //password failed send error
        $modal_msg = "Wrong password entered... deleted failed  ";
        $modal_msg_alert = "alert-danger";
    }
    elseif($modal_msg == " " && $modal_msg_alert == " " ) // passed password verification run delete query
    {
        $stmt_del = mysqli_stmt_init($connection);
        $query_del = "DELETE FROM users WHERE user_id = ? ";
 
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
   
        header("Location: staff.php");

    }  

}
 
#     <!-- Setting For Pagination  -->  
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


# <!-- Setting For user page  -->      
  if(isset($_GET['user']))
    {
        $user_page = mysqli_real_escape_string($connection,$_GET['user']);
    }
    else
    { 
        $user_page = " " ;
    }
 
?>
  
  
  
  <div class="<?= $modal_msg_alert ?>"> <?= $modal_msg; ?> </div>  

  <h2 class="text-center order_title"> <a id="products_title" href="staff.php"> Staff Members </a> </h2>

  <div class="container">
    <div class="row">
      <?php 
      if($user_page == 'edit' || $user_page == 'add')
      { ?>
          <div class="col-sm-1"> </div>   
          <div class="col-sm-10"> <?php   
      } ?>
 
          <div class="text-center"> 
      
            <?php       // set active classes for sub menu 
            if($user_page != "add" && $user_page != 'edit')
            { ?>
                <!-- only show add product btn if we are not on that page already -->
                <div id="add_new_user_btn">
                    <a class="btn btn-success" href="staff.php?user=add" >Add new team member</a> 
                </div> <br>   <?php 
            } ?>
     
            <div class="<?= $modal_msg_alert; ?>"> <?= $modal_msg; ?> </div>  
  
            <div class="text-center">  
              
                <?php  //  show default table or form to include in the page     
              
                if($user_page == "add")
                {
                    include "includes/staff_add.php";
                }
                elseif($user_page == "edit")
                {
                    include "includes/staff_edit.php";
                }
                else
                {
                    include "includes/staff_view_all.php";
                } ?>

    
      <?php include "includes/delete_modal.php"; ?>

    <div class="<?= $modal_msg_alert; ?>"> <?= $modal_msg; ?> </div> 
    
  <?php include "includes/footer.php" ?>