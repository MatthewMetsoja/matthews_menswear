<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";

$msg = " ";
$msg_class = " ";

if(!isset($_GET['reset_token']))
{
    header("Location: login.php");
}

if(isset($_GET['reset_token']))
{
    $token = filter_var($_GET['reset_token'],FILTER_SANITIZE_STRING);
}

    // select user that wants password update via the  unique reset token 
    $query = "SELECT user_name, email, reset_token FROM users WHERE reset_token = ? ";

    $stmt = mysqli_stmt_init($connection);
    if(!$stmt)
    {
        die('stmt init failed'.mysqli_error($connection));
    }

    if(!mysqli_stmt_prepare($stmt,$query))
    {
        die('stmt prepare failed'.mysqli_error($connection));
    }

    if(!mysqli_stmt_bind_param($stmt,"s",$token))
    {
        die('stmt bind failed'.mysqli_error($connection));
    }

    if(!mysqli_stmt_execute($stmt))
    {
        die('stmt execute failed'.mysqli_error($connection));
    }

    $result = mysqli_stmt_get_result($stmt);
           
    if(!$result)
    {
        die('stmt get result failed'.mysqli_error($connection));
    }
            
    $row = mysqli_fetch_assoc($result);

    $db_username = $row['user_name'];
    $db_email = $row['email'];
        
    mysqli_stmt_close($stmt); 


if(isset($_POST['submit_pw']))
{
 
    $password = $_POST['password'];
    $password_confirm = $_POST['password_check'];

    if(empty($password) || empty($password_confirm))
    {
        $msg = 'Please fill out the both password fields';
        $msg_class = 'text text-danger';
    }

    if($password !== $password_confirm)
    {
        $msg = 'Passwords don\'t match ';
        $msg_class = 'text text-danger';
    }

    if(strlen($password) < 5)
    {
        $msg = 'Password must be 5 characters in length or more';
        $msg_class = 'text text-danger';
    }

    else
    {

        htmlspecialchars($password);

        $hashed_password = password_hash($password,PASSWORD_DEFAULT); 

        $token = '';

        $pw_query = "UPDATE users SET password = ?, reset_token = ? WHERE email = ? ";

        $stmt1 = mysqli_stmt_init($connection);
            
        if(!$stmt1)
        {
            die('stmt1 init failed'.mysqli_error($connection));
        }

        if(!mysqli_stmt_prepare($stmt1,$pw_query))
        {
            die('stmt1 prepare failed'.mysqli_error($connection));
        }

        if(!mysqli_stmt_bind_param($stmt1,"sss",$hashed_password,$token,$db_email))
        {
            die('stmt1 bind failed'.mysqli_error($connection));}

                if(!mysqli_stmt_execute($stmt1)){
                    die('stmt1 execute failed'.mysqli_error($connection));}

                    else{ 
                        $msg = 'password updated successfully please click <a href="login.php"> here </a> to log in ';
                        $msg_class = 'text text-success';
                        mysqli_stmt_close($stmt1);
                        }
    }

}

  
?>
<!-- Page Content -->
<div class="container" id="jumper_contain">

    <div class="container">
        <div class="row">
        <div class="col-md-3 hidden-sm"> </div>
            <div id="main_div" class="col-xs-12 col-md-6">
            
                <div class="panel-body">
                    <div class="text-center">

                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        
                        <h2 id="login_head" class="text-center">Reset Password</h2>
                        
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                <div class="form-group">
                                    <label for="username" class="reset_label"> Choose A New Password:</label> <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="password" name="password" placeholder="enter new password" class="form-control"  type="password">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="username" class="reset_label"> Confirm Password:</label> <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"> <span class="glyphicon glyphicon-check"></span> </span>
                                        <input id="password" name="password_check" placeholder="confirm new password" class="form-control"  type="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input name="submit_pw" class="btn btn-lg btn-success btn-block" value="Confirm" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                            
                            <?php 
                            if($msg !== "")
                            { ?> 
                                <div class="<?php echo $msg_class ?> "> <?php echo $msg ?>  </div> <?php 
                            } ?>
                        </div><!-- Body-->
                    </div>
                </div>
            </div>  <!-- main div -->
         
            <div class="col-md-3 hidden-sm"> </div>
        </div>
    </div>
    
    <hr>

</div> <!-- /.container -->

<?php include "includes/footer.php";?>