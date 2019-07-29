<?php
// error message vars

$msg_alert = 
[
'first_name' => '','last_name' => '', 'user_name' => '','email' => '', 'password' => '', 
'password_confirm' => '', 'permissions'=> '', 'picture'=> ''
];

$msg = 
[
  'first_name' => '','last_name' => '', 'user_name' => '','email' => '', 'password' => '', 
  'password_confirm' => '', 'permissions'=> '', 'picture'=> ''
];

?>



 <!-- ADD USER QUERY -->
<?php
  if(isset($_POST['submit']))
  {
 
    // start filters/sanitization declare vars
    $first_name = filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    $last_name = filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    $user_name = filter_var(trim($_POST['user_name']), FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $password_confirm = filter_var(trim($_POST['password_confirm']), FILTER_SANITIZE_STRING);
    $permissions = $_POST['permissions'];
    $picture = $_FILES['picture']['name'];
    $tmp_picture = $_FILES['picture']['tmp_name'];
    $join_date =  date("Y-m-d H:i:s");
    $last_login =   date("Y-m-d H:i:s");
    $reset_token = "";
   
 
      // FORM VALIDATION  //stage 1
      //check for empty fields
      if(empty($first_name))
      {
          $msg['first_name'] = "Please add your first name";
          $msg_alert['first_name'] = "alert-danger" ;
      }

      if(empty($last_name))
      {
          $msg['last_name'] = "Please add your last name";
          $msg_alert['last_name'] = "alert-danger" ;
      }

      if(empty($user_name))
      {
          $msg['user_name'] = "Please add a username ";
          $msg_alert['user_name'] = "alert-danger" ;
      }

      if(empty($email))
      {
          $msg['email'] = "Please add email address ";
          $msg_alert['email'] = "alert-danger" ;
      }

      if(empty($password))
      {
          $msg['password'] = "Please choose a password ";
          $msg_alert['password'] = "alert-danger" ;
      }

      if(empty($password_confirm))
      {
          $msg['password_confirm'] = "You forgot to confirm your password ";
          $msg_alert['password_confirm'] = "alert-danger" ;
      }

      if($password !== $password_confirm)
      {
          $msg['password_confirm'] = "Passwords do not match ";
          $msg_alert['password_confirm'] = "alert-danger" ;
          $msg['password'] = "Passwords do not match ";
          $msg_alert['password'] = "alert-danger" ;
      }

      if(strlen($password) < 6 )
      {
          $msg['password'] = "Password must be at least 6 characters ";
          $msg_alert['password'] = "alert-danger" ;
          $msg['password_confirm'] = "Password must be at least 6 characters ";
          $msg_alert['password_confirm'] = "alert-danger" ;
      }

      if($permissions == " ")
      {
          $msg['permissions'] = "Please choose user permissions ";
          $msg_alert['permissions'] = "alert-danger" ;
      }
      
      if(empty($picture))
      {
          $msg['picture'] = "Please choose a main pic for the item ";
          $msg_alert['picture'] = "alert-danger" ;
      }

      if(!filter_var($email,FILTER_VALIDATE_EMAIL))
      {
          $msg['email'] = "Please choose a valid email ";
          $msg_alert['email'] = "alert-danger" ;
      }


      // check that email does not exist already
      $stmt = mysqli_stmt_init($connection);   
      $email_exists_query = "SELECT * FROM users WHERE email = ? ";
      if(!mysqli_stmt_prepare($stmt,$email_exists_query))
      {
          die('prep email exists failed'.mysqli_error($connection));
      } 
      
      if(!mysqli_stmt_bind_param($stmt,'s',$email))
      {
          die("bind email exists failed".mysqli_error($connection));
      }

      if(!mysqli_stmt_execute($stmt))
      {
          die("execute email exists failed".mysqli_error($connection));
      }

      $email_exists_result = mysqli_stmt_get_result($stmt);
      
      if(mysqli_num_rows($email_exists_result) != 0 )
      {
          $msg['email'] = 'There is already a user with that email please choose another ';
          $msg_alert['name'] = 'alert-warning'; 
      }

      if(!mysqli_stmt_close(stmt))
      {
          "does email exist stmt didnt close";
      } 


        // stage 2 
        // if no errors run query
      else if(empty($msg['first_name']) &&  empty($msg['last_name']) && empty($msg['user_name']) && empty($msg['email']) && empty($msg['password']) && empty($msg['password_confirm']) && empty($msg['permissions']) && empty($msg['picture']) )
      {

          // move images to correct folders
          if($permissions === "user" )
          {
              move_uploaded_file($tmp_picture, "../img/users/customers/$picture");
          
              // then give the image that value so we are able to keep images in seperate folders  
              $picture = "img/users/customers/$picture";        
          }

          if($permissions === "staff" || $permissions === "admin" )
          {
              move_uploaded_file($tmp_picture, "../img/users/staff/$picture");
              $picture = "img/users/staff/$picture"; 
          }

          // hash password
          $password = password_hash($password,PASSWORD_DEFAULT);

          $insert_stmt = mysqli_stmt_init($connection);
         
          $insert_query = "INSERT INTO users(first_name,last_name,user_name,password,permissions,email,join_date,last_login,user_pic,reset_token)
          VALUES(?,?,?,?,?,?,?,?,?,?) ";  

          if(!mysqli_stmt_prepare($insert_stmt,$insert_query))
          {
              die('insert_prep failed'.mysqli_error($connection));
          }

          if(!mysqli_stmt_bind_param($insert_stmt,"ssssssssss",$first_name,$last_name,$user_name,$password,$permissions,$email,
          $join_date,$last_login,$picture,$reset_token))
          {
              die("insert bind failed".mysqli_error($connection));
          }

          if(!mysqli_stmt_execute($insert_stmt))
          {
              die("insert ex failed".mysqli_error($connection));
          }
          
          if(!mysqli_stmt_close($insert_stmt))
          {
            "insert stmt didnt close";
          } 

          header('location: staff.php');

      }    
   
  }
?>

<!-- FORM STARTS HERE -->
<h6> <b> Add new team member </b> </h6>
<div class="row"> 
   
    <div class="col-1"> </div>
    
    <div id="add_product_form_container" class="col-10"> 
        <form action="" method="post" enctype="multipart/form-data"  >

            <div id="form_start" class="form-group ">
                <label class="form_label" for="full_name"> First Name: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['first_name']; ?>" > <?= $msg['first_name']; ?> </div>
                <input type="text" name="first_name" class="form-control" value="<?php echo isset($first_name) ? trim($first_name) : '' ?> ">
            </div>

            <div id="form_start" class="form-group ">
                <label class="form_label" for="full_name"> Last Name: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['last_name']; ?>" > <?= $msg['last_name']; ?> </div>
                <input type="text" name="last_name" class="form-control" value="<?php echo isset($last_name) ? trim($last_name) : '' ?> ">
            </div>

            <div id="form_start" class="form-group ">
                <label class="form_label" for="user_name"> Username: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['user_name']; ?>" > <?= $msg['user_name']; ?> </div>
                <input type="text" name="user_name" class="form-control" value="<?php echo isset($user_name) ? trim($user_name) : '' ?> ">
            </div>

            <div id="form_start" class="form-group ">
                <label class="form_label" for="email"> Email: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['email']; ?>" > <?= $msg['email']; ?> </div>
                <input type="email" name="email" class="form-control" value="<?php echo isset($email) ? trim($email) : '' ?> ">
            </div>

            <div id="form_start" class="form-group ">
                <label class="form_label" for="password"> Password: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['password']; ?>" > <?= $msg['password']; ?> </div>
                <input type="password" name="password" class="form-control">
            </div>

            <div id="form_start" class="form-group ">
                <label class="form_label" for="password_confirm"> Password Confirm: </label> <br>
                  <!-- output error msg if we need to -->
                <div class=" <?= $msg_alert['password_confirm']; ?>" > <?= $msg['password_confirm']; ?> </div>
                <input type="password" name="password_confirm" class="form-control">
            </div>

        
            <div class="form-group " id="category_div">
                <label class="form_label" for="permission"> Permissions: </label> <br>
                <!-- output error msg if we need to -->
                <div class="<?= $msg_alert['permissions']; ?>" > <?= $msg['permissions']; ?> </div>
            
                <select class="form-control" name="permissions" id="permissions_select" > 
    
                      <!-- if the form has NOT been submitted show please choose as an option  -->
                      <?php  
                      if(!isset($permissions) || isset($permissions) && $permissions == " ")
                      { ?>
                          <option selected value=" "> ** Please Choose **</option>
                          <option value="admin"> admin </option>
                          <option value="user"> user </option>
                          <option value="staff"> staff </option> <?php 
                      } ?>

                        <!-- or if the form has been submitted get choosen option and set as default selected -->
                      <?php
                      if(isset($permissions) && $permissions != " ")
                      {  ?>
                          <option selected value="<?= $permissions ?>"> <?= $permissions ?> </option> <?php 
                      
                          // get  the other options just incase the user choose the wrong one
                        if($permissions == 'admin')
                        { ?>
                          <option value="user"> user </option>
                          <option value="staff"> staff </option> <?php 
                        }
                        elseif($permissions == 'user')
                        { ?>
                          <option value="admin"> admin </option>
                          <option value="staff"> staff </option> <?php 
                        } 
                        elseif($permissions == 'staff')
                        { ?>
                          <option value="user"> user </option>
                          <option value="staff"> staff </option> <?php 
                        } 
                      } ?>
                
                </select>
            </div>
        
            <div class="form-group ">
                  <label class="form_label" for="picture"> Picture: </label> <br> <br>
                  <div class=" <?= $msg_alert['picture']; ?>" > <?= $msg['picture']; ?> </div>
                  <input type="file" class="form-control form_pic_input" name="picture" >
            </div>
        
            <div>
                <button class="btn btn-success"  name="submit" type="submit">Add new team member</button>   
            </div>

        </form>
        
    </div>
    
    <div class="col-1"> </div>
</div>
 <br>
