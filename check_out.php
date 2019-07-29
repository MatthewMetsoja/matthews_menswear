<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php"; 
 
// set emptys errors array
$msg_alert =array(

  "full_name" => "",
  "email" => "",
  "house_name" => "",
  "city" => "",
  "postcode" => "",
  "mobile" => ""

);

$msg = array(
  "full_name" => "",
  "email" => "",
  "house_name" => "",
  "city" => "",
  "postcode" => "",
  "mobile" => ""

);


if(isset($_POST['submit_address']))
{

    // get fields from address section of form
    $full_name = filter_input(INPUT_POST,"full_name");
    $email = filter_input(INPUT_POST,"email");
    $housename_number = filter_input(INPUT_POST,"housename_number");
    $street_name = filter_input(INPUT_POST,"street_name");
    $city_town = filter_input(INPUT_POST,"city_town");
    $post_code = filter_input(INPUT_POST,"post_code");
    $mobile_number = filter_input(INPUT_POST,"mobile_number");

    $full_name = filter_var(trim($full_name),FILTER_SANITIZE_STRING);
    $email = filter_var(trim($email),FILTER_SANITIZE_STRING);
    $housename_number = filter_var(trim($housename_number),FILTER_SANITIZE_STRING);
    $street_name = filter_var(trim($street_name),FILTER_SANITIZE_STRING);
    $city_town = filter_var(trim($city_town),FILTER_SANITIZE_STRING);
    $post_code = filter_var(trim($post_code),FILTER_SANITIZE_STRING);
    $mobile_number = filter_var(trim($mobile_number),FILTER_SANITIZE_STRING);
  
    if(empty($full_name) || $full_name == " " )
    {
      $msg['full_name'] = "<span class='text-danger'> Please enter your full name </span> "; 
      $msg_alert['full_name'] = "alert-danger";
    }

    if(empty($email) || $email == " "  )
    {
      $msg['email'] = "<span class='text-danger'> Please enter your full name </span> "; 
      $msg_alert['email'] = "alert-danger";
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
      $msg['email'] = "<span class='text-danger'> Please enter a vaild email </span> "; 
      $msg_alert['email'] = "alert-danger";
    }

    if(empty($housename_number) || $housename_number == " " )
    {
      $msg['house_name'] = "<span class='text-danger'> Please enter your house name or number </span> "; 
      $msg_alert['house_name'] = "alert-danger";
    }

    if(empty($city_town) || $city_town == " "  )
    {
      $msg['city'] = "<span class='text-danger'> Please enter City or town </span> "; 
      $msg_alert['city'] = "alert-danger";
    }

    if(empty($post_code) || $post_code == " " )
    {
      $msg['postcode'] = "<span class='text-danger'> Please enter your Post-code </span> "; 
      $msg_alert['postcode'] = "alert-danger";
    }

    if(empty($mobile_number) || $mobile_number ==  " " )
    {
      $msg['mobile'] = "<span class='text-danger'> Please enter your mobile number  </span> "; 
      $msg_alert['mobile'] = "alert-danger";
    }

    else if(empty($msg['full_name']) && empty($msg['email']) && empty($msg['house_name']) && empty($msg['city']) && 
    empty($msg['postcode']) && empty($msg['mobile']) )
    {
        // redirect to next stage if the form is all filled out with no errors
       $_SESSION['payment_full_name'] =  $full_name;
       $_SESSION['payment_email'] = $email;
       $_SESSION['payment_mobile'] =  $mobile_number;
       $_SESSION['payment_house_name'] = $housename_number;
       $_SESSION['payment_street_name'] = $street_name;
       $_SESSION['payment_postcode'] = $post_code; 
       $_SESSION['payment_city'] = $city_town; 

        header("Location: payment.php");
      
    }


}


      // <!-- CHECK OUT FORM STARTS HERE --> 
      if(!isset($_GET['payment']))
      { ?>
          <div class="container-fluid" id="jumper_contain">
            
            <h2 class="text-center">Checkout <i class="fas fa-shopping-bag    "></i>  </h2>
            
            <form action="" method="post">
          
              <div class="row" id="both_forms">
          
                <div class="col-sm-2 col-1"></div>
              
                <div class="col-sm-9 col-10"> <br>
                
                <div class="col-md-10" id="step1"> 
              
                  <h5 class="text-center mt-4"> <u> Shipping address </u> </h5>
                    <div class="form-group col-12">
                      <label for="first_name">Full Name:</label>
                      <div class="<?= $msg_alert['full_name'] ?>"> <?= $msg['full_name'] ?></div>
                      <span id="name_message"></span>
                      <input type="text" name="full_name" class="form-control"  id="full_name" value="<?= isset($full_name) ? trim($full_name) : '' ?> ">
                    </div>
                
                    <div class="form-group col-12">
                        <label for="email">Email:</label>
                        <div class="<?= $msg_alert['email'] ?>"> <?= $msg['email'] ?></div>
                        <span id="email_message"></span>
                        <input type="email" class="form-control"  name="email" id="email" value="<?= isset($email) ? trim($email) : '' ?> ">
                    </div>

                    <div class="form-group col-12">
                        <label for="house_name">House name/ number:</label>
                        <div class="<?= $msg_alert['house_name'] ?>"> <?= $msg['house_name'] ?></div>
                        <span id="house_message"></span>
                        <input type="text" class="form-control"  name="housename_number" id="housename_number" value="<?= isset($housename_number) ? trim($housename_number) : '' ?> ">
                    </div>

                    <div class="form-group col-12">
                        <label for="street_name">Street name:</label>      
                        <input type="text" class="form-control"  name="street_name" id="street_name" value="<?= isset($street_name) ? trim($street_name) : '' ?> ">
                    </div>

                    <div class="form-group col-12">
                        <label for="city_town">City/Town:</label>
                        <div class="<?= $msg_alert['city'] ?>"> <?= $msg['city'] ?></div>
                        <span id="city_message"></span>
                        <input type="text" class="form-control" name="city_town" id="city_town" value="<?= isset($city_town ) ? trim($city_town) : '' ?> ">
                    </div>

                    <div class="form-group col-12">
                        <label for="post_code">Post code:</label>
                        <div class="<?= $msg_alert['postcode'] ?>">  <?= $msg['postcode'] ?></div>
                        <span id="postcode_message"></span>
                        <input type="text" class="form-control" name="post_code" id="post_code" value="<?= isset($post_code ) ? trim($post_code) : '' ?> ">
                    </div>

                    <div class="form-group col-12">
                        <label for="full_name">Mobile number:</label>
                        <div class="<?= $msg_alert['mobile'] ?>"> <?= $msg['mobile'] ?></div>
                        <span id="name_message"></span>
                        <input type="number" class="form-control" name="mobile_number" value="<?= isset($mobile_number ) ? trim($mobile_number) : '' ?>">
                  </div>

                  <div id="next_stage_div">
                        <a id="cancel_btn" href="basket.php" class="btn btn-secondary block-2"> Cancel</a>
                        <button type="submit" name="submit_address" id="next_stage_btn" class="btn btn-success  block-1">confirm <i class="fas fa-forward"></i> </button>
                  </div>
            </form>
          
          </div>
                
        <?php 
      }?>  
    </div> 
        
  </div>
</div>

 <?php include "includes/footer.php"; ?>