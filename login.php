<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";
require_once "functions.php";

// declare error vars and set them empty; 
$msg = ['email' => '', 'password' => ''];

$msg_alert = ['email' => '', 'password' => ''];

// login query (at the top of page so we can optput errors inline) 
if(isset($_POST['submit']))
{
    // sanitize email and password
    $password = trim($_POST['password']);
    $password = filter_var($password,FILTER_SANITIZE_STRING);

    $email = trim($_POST['email']);
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);

    // check email is not empty
    if(empty($email))
    {
        $msg['email'] = "You must provide an email ";
        $msg_alert['email'] = "alert-danger";
    }

    // check password is not empty
    if(empty($password))
    {
        $msg['password'] = "You must provide a password";
        $msg_alert['password'] = "alert-danger";
    }
        
    // if they are both not empty then check if email exists in our database
    if(!empty($email) && !empty($password) )
    {

        // check if email exists 
        $query = "SELECT * FROM users WHERE email = '$email' "; 
        $result = mysqli_query($connection,$query);
        
        if(!$result)
        {
          die("does email already exist query failed".mysqli_error($connection));
        }
        
        while($row = mysqli_fetch_assoc($result))
        {
            $db_id = $row['user_id'];
            $db_first_name = $row['first_name'];
            $db_last_name = $row['last_name'];
            $db_user_name = $row['user_name'];
            $db_password = $row['password'];
            $db_permissions = $row['permissions'];
            $db_email = $row['email'];
            $db_join_date = $row['join_date'];
            $db_last_login = $row['last_login'];
            $db_picture = $row['user_pic'];
        } 
          
        $email_exist = mysqli_num_rows($result);
        
        // output error if email is not in db
        if($email_exist == 0)
        {
            $msg['email'] =  "email not found in our system";
            $msg_alert['email'] = "alert-danger";
        }

        // check password is more than 6 chars
        if(strlen($password) < 6 )
        {
            $msg['password'] = "Password must be at least 6 characters long.";
            $msg_alert['password'] = "alert-danger";
        }
      
        // check that password is correct 
        if(!password_verify($password,$db_password))
        {
            $msg['password'] = "Incorrect password please try again or click link below to reset"; 
            $msg_alert['password'] = "alert-danger";
        }

        else if(password_verify($password,$db_password))  // log user in
        { 
        
            // update last login
            $date = date("Y-m-d H:i:s");
          
            $stmt = mysqli_stmt_init($connection);

            $update_last_login_query = "UPDATE users SET last_login = ? WHERE user_id = ? " ;
          
            if(!mysqli_stmt_prepare($stmt,$update_last_login_query))
            {
                die('login function prepare stmt failed'.mysqli_error($connection));
            }

            if(!mysqli_stmt_bind_param($stmt,"ss",$date,$db_id))
            {
              die("login function bind stmt failed".mysqli_error($connection));
            }

            if(!mysqli_stmt_execute($stmt))
            {
                die("login function execute stmt failed".mysqli_error($connection));
            }
            
            mysqli_stmt_close($stmt);

            // set sessions
            $_SESSION['id'] = $db_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['picture'] = $db_picture;
            $_SESSION['username'] = $db_user_name;
            $_SESSION['password'] = $db_password;
            $_SESSION['permissions'] = $db_permissions;
            $_SESSION['email'] = $db_email;
            $_SESSION['success_flash'] = "you are now logged in ";
              
            header("Location: admin/index.php");
        }
      
    }
    
} ?>

<div id="login_container" class="container-fluid">
  <div id="login-form">
    <div class="row">
      
      <div class="col-md-3 col-sm-1 "> </div>
      
      <div id="login_div" class="col-md-6 col-sm-10 "> 
        
        <h2  id="login_head" class="text-center">Login  </h2>
        
        <form method="post" action="">
          <div id="email_group" class="form-group">
            <label for="email">Email:</label>
            <!-- output error message for email if we need to  -->
            <?php 
            if(!empty($msg['email']))
            { ?> 
                <div class="<?= $msg_alert['email'] ?> ">  <?= $msg['email'] ?></div> <?php 
            } ?>    
              
              <input class="form-control" type="email" name="email" id="email" value="<?= isset($email)? $email : '' ?> ">
          </div> 

          <div class="form-group">
            <label for="email">Password:</label>
            <!-- output error message for password if we need to  -->
            <?php 
            if(!empty($msg['password']))
            { ?>
                <div class="<?= $msg_alert['password'] ?> ">  <?= $msg['password'] ?></div> <?php 
            } ?>
             
              <input class="form-control" type="password" name="password" id="password">
                
              <a id="forgot_password_link" href="forgot.php"> Click here if you have forgot </a>
          </div> 
          
          <br>

            <div class="form-group">
                <input type="submit" value="Login" id="login_btn" name="submit" class="btn btn-dark"> 
                <a href="register.php" id="login_btn" class="btn btn-success"> Sign up for an account</a> 
            </div>

        </form>
      </div>

      <div class="col-md-3 col-sm-1"> </div>
    </div>
  </div>
</div> 

<?php include "includes/footer.php"; ?>

