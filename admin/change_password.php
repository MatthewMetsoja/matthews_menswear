<?php 
require_once "includes/head.php";
require_once "includes/navigation.php";
 
// get old password and user id
$db_password = $_SESSION['password']; 
$db_id = $_SESSION['id']; 


// declare error vars and set them empty; 
$msg = ['password_old' => '', 'password_new' => '', 'password_confirm' => '' ];

$msg_alert = ['password_old' => '', 'password_new' => '', 'password_confirm' => '' ];

  // login query (at the top of page so we can optput errors inline) 
  if(isset($_POST['change_password']))
  {
      //  STAGE1 check passwords are not empty
      if(empty($_POST['password_old']) )
      {
          $msg['password_old'] = "Old Password must not be left blank!";
          $msg_alert['password_old'] = "alert-danger";
      }
           
      if(empty($_POST['password_new']) )
      {
          $msg['password_new'] = "New Password must not be left blank!";
          $msg_alert['password_new'] = "alert-danger";
      }
           
      if(empty($_POST['password_confirm']) )
      {
          $msg['password_confirm'] = "You must confirm your new password!";
          $msg_alert['password_confirm'] = "alert-danger";
      }
           
      // STAGE2 if they are all empty then sets vars and check passwords meet criteria
      else if(!empty($_POST['password_old']) && !empty($_POST['password_new']) && !empty($_POST['password_confirm']) )
      {

          $password_old =  filter_var(trim($_POST['password_old']),FILTER_SANITIZE_STRING);
          $password_new = filter_var(trim($_POST['password_new']),FILTER_SANITIZE_STRING);
          $password_confirm = filter_var(trim($_POST['password_confirm']),FILTER_SANITIZE_STRING);

          if(!password_verify($password_old,$db_password))
          {
              $msg['password_old'] = "Your old password does not match our records.";
              $msg_alert['password_old'] = "alert-danger";
          }

          // check password is more than 6 chars
          if(strlen($password_new) < 6 )
          {
              $msg['password_new'] = "Password must be at least 6 characters long.";
              $msg_alert['password_new'] = "alert-danger";
              $msg['password_confirm'] = "Password must be at least 6 characters long.";
              $msg_alert['password_confirm'] = "alert-danger";
          }
          
           // check that passwords match  
           if($password_new !== $password_confirm)
           {
              $msg['password_new'] = "Passwords do not match!"; 
              $msg_alert['password_new'] = "alert-danger";
              $msg['password_confirm'] = "Passwords do not match!"; 
              $msg_alert['password_confirm'] = "alert-danger";
           }

           if(empty($msg['password_old']) && empty($msg['password_new']) && empty($msg['password_confirm']))
           {
              //STAGE3 Hash the new password and run query to update it in the db
              $hash_password_new = password_hash($password_new,PASSWORD_DEFAULT);

              $query = "UPDATE users SET password = ? WHERE user_id = ? " ;
              $stmt = mysqli_stmt_init($connection);
            
              if(!mysqli_stmt_prepare($stmt,$query))
              {
                die('prep failed'.mysqli_error($connection));
              }
            
              if(!mysqli_stmt_bind_param($stmt,"si",$hash_password_new,$db_id))
              {
                die('bind failed'.mysqli_error($connection));
              }

              if(!mysqli_stmt_execute($stmt))
              {
                die('execute failed'.mysqli_error($connection));
              }  

              mysqli_stmt_close($stmt);

              $_SESSION['password'] = $hash_password_new;
              $_SESSION['success_flash'] = "Your password has been updated! ";
            
              header("Location: index.php");
           }
           
          
      }   
    
  } ?>

<div id="login_container" class="container-fluid">

  <div id="login-form">
  
    <div class="row">
        
        <div class="col-md-3 col-sm-1 "> </div>

        <div id="login_div" class="col-md-6 col-sm-10 "> 
       
          <h2  id="login_head" class="text-center">Change password <i class="fas fa-lock    "></i> </h2>
            
          <form method="post" action="">
           
              <div id="email_group" class="form-group">
                  <label for="email">Old Password:</label>
                  <!-- output error message for email if we need to  -->
                  <?php 
                  if(!empty($msg['password_old']))
                  { ?> 
                      <div class="<?= $msg_alert['password_old']; ?> ">  <?= $msg['password_old']; ?></div> <?php 
                  } ?>
                  
                  <input class="form-control" type="password" name="password_old" id="password_old">
              </div>

              <div class="form-group">
                  <label for="email">New Password:</label>
                  <!-- output error message for password if we need to  -->
                  <?php
                  if(!empty($msg['password_new']))
                  { ?> 
                      <div class="<?= $msg_alert['password_new']; ?> ">  <?= $msg['password_new']; ?></div> <?php 
                  } ?>
                
                  <input class="form-control" type="password" name="password_new" id="password_new">
              </div> 

              <div class="form-group">
                  <label for="email">Confirm New Password:</label>
                  <!-- output error message for password if we need to  -->
                  <?php 
                  if(!empty($msg['password_confirm']))
                  { ?> 
                      <div class="<?= $msg_alert['password_confirm']; ?> ">  <?= $msg['password_confirm']; ?></div> <?php 
                  } ?>
                 
                 <input class="form-control" type="password" name="password_confirm" id="password_confirm">
              </div> 
            
              <br>

              <div class="form-group">
                  <a href="index.php" class="btn btn-dark">Cancel </a>
                  <input type="submit" value="Change Password" id="login_btn" name="change_password" class="btn btn-success"> 
              </div>

          </form>

        </div>

        <div class="col-md-3 col-sm-1"> </div>

    </div>

  </div>
  
</div> 


<?php include "includes/footer.php" ?>

