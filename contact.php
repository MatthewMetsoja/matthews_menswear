<?php 
require_once "includes/head.php";
require_once "includes/navigation.php";
require_once "functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// set error vars
$msg = array(
    'subject' => " ",
    'f_name' => " ",
    'l_name' => " ",
    'sender_email' => " ",
    'the_message' => " ",
    "error" => " "
);

$msg_alert = array(
    'subject' => " ",
    'f_name' => " ",
    'l_name' => " ",
    'sender_email' => " ",
    'the_message' => " ",
    "error" => " "
);

    
if(isset($_POST['send']))
{
    // validate message sanitize and check for errors
    $subject = mysqli_real_escape_string($connection,trim($_POST['subject']));
   
    if(empty($subject || $subject == " "))
    {
        $msg['subject'] = "please enter a subject";
        $msg_alert['subject'] = "text-danger";
    }
   
    $sender_f_name = filter_var(trim($_POST['first_name']),FILTER_SANITIZE_STRING);
    
    if(empty($sender_f_name) || $sender_f_name = " ")
    {
        $msg['f_name'] = "please enter your first name";
        $msg_alert['f_name'] = "text-danger";
    }

    $sender_l_name = filter_var(trim($_POST['last_name']),FILTER_SANITIZE_STRING);
    
    if(empty($sender_l_name) || $sender_l_name = " ")
    {
        $msg['l_name'] = "please enter your last name";
        $msg_alert['l_name'] = "text-danger";
    }
    
    $sender = trim($_POST['email']);
 
    if(!filter_var($sender,FILTER_VALIDATE_EMAIL))
    {
        $msg['sender_email'] = "please enter a valid email address";
        $msg_alert['sender_email'] = "text-danger";
    }

    filter_var($sender,FILTER_SANITIZE_EMAIL);

    if(empty($sender) || $sender == " " )
    {
        $msg['sender_email'] = "please enter your email address";
        $msg_alert['sender_email'] = "text-danger";
    }

    
    $the_message = mysqli_real_escape_string($connection,trim($_POST['the_message']));
    
    if(empty($the_message) || $the_message == " ")
    {
        $msg['the_message'] = "Please tell us what you want to say in the message box";
        $msg_alert['the_message'] = "text-danger";
    }
    else if(empty($msg['subject']) && empty($msg['f_name']) && empty($msg['l_name']) && empty($msg['sender_email']) && empty($msg['the_message']) )  
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer();

        try 
        {
            //Server settings
           
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = getenv(mailer_username);                     // SMTP username
            $mail->Password   = getenv(mailer_password);                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 2525;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8' ; 

            //SENDER AND Recipients
            $mail->setFrom($sender, $sender_f_name.' '.$sender_l_name);
            $mail->addAddress('thatsmeclothing@icloud.com', 'Matthews Menswear');     // recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
         

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject ;
            $mail->Body    = wordwrap($the_message,70,"\n", false);
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            $_SESSION['success_basket'] = "Thanks for your message we aim to reply within 48 hours ";
            header("Location: index.php");
          
        } catch (Exception $e) {
            $msg['error'] = 'Message could not be sent. Mailer Error:'.$mail->ErrorInfo;
            $msg_class['error'] = "text text-danger";
        }

    }
}?>

 
    <!-- Page Content -->
<div class="container" id="jumper_contain">
    
    <section id="login">
        <div class="container" >
            <div class="row">
                <div class="col-md-3 hidden-sm"> </div>
                <div id="main_div" class="col-xs-12 col-md-6">
                    <div class="form-wrap">
                        <h1 class="text-center test">Contact Us</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                    
                            <div class="form-group">
                                <label for="subject" id="login_head">Subject:</label>
                                <div class="<?= $msg_alert['subject'] ?> "> <?= $msg['subject'] ?> </div>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Please tell us what your message is about here"
                                value="<?php echo isset($subject) ? $subject : '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="username" id="login_head">First Name:</label>
                                <div class="<?= $msg_alert['f_name'] ?> "> <?= $msg['f_name'] ?> </div>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Please write your first name here"
                                value="<?php echo isset($first_name) ? $first_name : '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="username" id="login_head">Last Name:</label>
                                <div class="<?= $msg_alert['l_name'] ?> "> <?= $msg['l_name'] ?> </div>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Please write your last name here"
                                value="<?php echo isset($last_name) ? $last_name : '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="email" id="login_head">Email:</label>
                                <div class="<?= $msg_alert['sender_email'] ?> "> <?= $msg['sender_email'] ?> </div>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" >
                            </div>
                           
                            <div class="form-group">
                                <label for="message" id="login_head"> Message: </label>
                                <div class="<?= $msg_alert['the_message'] ?> "> <?= $msg['the_message'] ?> </div>
                                <textarea name="the_message" rows="10"  class="form-control" placeholder="Please write your message to us here"></textarea>
                            </div>
                    
                            <input type="submit" name="send" id="btn-login" class="btn btn-success btn-lg btn-block contact_button" value="Send">
                            
                        </form>
                    
                    </div>
                </div> <!-- /.col-xs-12 -->
                <div class="col-md-3 hidden-sm"> </div>
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

</div>
        <hr>

<?php include "includes/footer.php";?>