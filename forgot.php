<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";
require_once "functions.php"; 
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = " ";
$msg_class = " ";

if(isset($_POST['forgot_submit']))
{

    $email = $_POST['email'];

    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $msg = 'Please enter a valid email';
        $msg_class = 'text text-danger';
    }  

    filter_var($email,FILTER_SANITIZE_EMAIL);
     
    $length = 50;
  
       // create random token for password reset
    $token = bin2hex(openssl_random_pseudo_bytes($length));

    if(empty($email))
    {
        $msg = 'You forgot to enter your email!';
        $msg_class = 'text text-danger';
    } 
    else
    { 
        $email_exists_query = " SELECT email FROM users WHERE email = '$email' "; 
        $email_exists_result = mysqli_query($connection,$email_exists_query);
        
        if(!$email_exists_result)
        {
            die("does username already exist query failed".mysqli_error($connection));
        }
     
        $rows = mysqli_num_rows($email_exists_result);
        
        if($rows !== 0)
        {
        
            $query = "UPDATE users SET reset_token = ? WHERE email = ? ";

            $stmt = mysqli_stmt_init($connection);

            if(!mysqli_stmt_prepare($stmt,$query))
            {
                die('prepare stmt failed'.mysqli_error($connection));    
            }
            
            if(!mysqli_stmt_bind_param($stmt,"ss",$token,$email))
            {
                die('bind stmt failed'.mysqli_error($connection));    
            }

            if(!mysqli_stmt_execute($stmt))
            {
                die('execute stmt failed'.mysqli_error($connection));    
            }
            
            mysqli_stmt_close($stmt);

            // after token has been set for user in the database we send them a message with reset link  

            // CONFIGURE PHP MAILER
            $mail = new PHPMailer();    // Passing `true` enables exceptions
            
            try 
            {
                //Server settings
            
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.mailtrap.io' ;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = getenv(mailer_username);                 // SMTP username
                $mail->Password = getenv(mailer_password);                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 2525 ;                                    // TCP port to connect to

                $mail->CharSet = 'UTF-8' ; 

                //Recipients
                $mail->setFrom('thatsmeclothing@icloud.com','Matthews Menswear');  // Sender
                $mail->addAddress($email); // recipient
            
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password reset';
                $mail->Body    = '  <p> 
                                        Please click the link to reset your password 
                                        <a href="http://localhost:8888/e-commerce/reset.php?email='.$email.'&reset_token='.$token. ' " > 
                                            CLICK HERE TO RESET PASSWORD 
                                        </a>
                                    </p> ';
            
                $mail->send();
            
                $msg = ' Thank you please check your email for password reset link ';
                $msg_class = "text text-success ";
            } 
            catch (Exception $e) 
            {
                $msg = 'Message could not be sent. Mailer Error:'.$mail->ErrorInfo;
                $msg_class = "text text-danger";
            }


        }
        else
        {
            $msg = "email not in system ";
            $msg_class = "text text-danger ";
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
             
               
                <div class="text-center">

                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                                
                    <h2 id="login_head" class="text-center">Forgotton Password?</h2>
                                
                    <p> <b>  You can reset your password here.  </b> </p>
                                
                    <div class="panel-body">

                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                            <div class="form-group">
                                <label for="">Please Enter Your Email  <i class="fas fa-envelope"></i> </label> <br>                        
                                <div class="input-group">
                                    <input  id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                </div> 
                            </div>
                                        
                            <div class="form-group">
                                <input name="forgot_submit" class="btn btn-lg btn-success btn-block" value="Reset Password" type="submit">
                            </div>

                            <input type="hidden" class="hide" name="token" id="token" value="">
                                    
                        </form>

                        <?php 
                        if(!empty($msg))
                        { ?>
                            <div class="<?php echo $msg_class; ?>" > <?php echo $msg; ?> </div> <?php 
                        } ?> 

                    </div>

                </div>
                  
              
            </div>    <!--main div -->
           
            <div class="col-md-3 hidden-sm"> </div>
        </div>
    </div>

    <hr>

</div> 

<?php include "includes/footer.php";?>