
<h6> <b> Edit user </b> </h6>

<!-- FORM STARTS HERE -->

<?php
if(isset($_GET['who']))
{
    $users_id =  mysqli_real_escape_string($connection,$_GET['who']); 
  
    $stmt_edit = mysqli_stmt_init($connection);
  
    $edit_query = "SELECT * FROM users WHERE user_id = ? ";

    if(!mysqli_stmt_prepare($stmt_edit,$edit_query))
    {
      die("prep failed stmt edit query".mysqli_error($connection));   
    }

    if(!mysqli_stmt_bind_param($stmt_edit,"i",$users_id))
    {
      die("bind failed stmt_edit".mysqli_error($connection));  
    }

    if(!mysqli_stmt_execute($stmt_edit))
    {
      die("execute failed stmt_edit".mysqli_error($connection));
    }

    $result_edit = mysqli_stmt_get_result($stmt_edit);

    while($row_edit = mysqli_fetch_assoc($result_edit))
    {
        $db_password = $row_edit['password'];   ?>

        <div class="row"> 
            
          <div class="col-1"> </div>
            
          <div id="add_product_form_container" class="col-10"> 
                
              <form action="" method="post" enctype="multipart/form-data"  >

                  <div class="form-group ">
                      <label class="form_label" for="full_name"> First Name: </label> <br>
                      
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['first_name_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['first_name_msg'] ;?> </div> <?php 
                          unset($_SESSION['first_name_msg']);  
                      } ?>
                      
                      <input type="text" name="first_name" class="form-control" value="<?php echo isset($first_name) ? trim($first_name) : $row_edit['first_name'] ?> ">
                  </div>

                  <div class="form-group ">
                      <label class="form_label" for="full_name"> Last Name: </label> <br>
                      
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['last_name_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['last_name_msg'] ;?> </div> <?php 
                          unset($_SESSION['last_name_msg']);  
                      } ?>
                    
                      <input type="text" name="last_name" class="form-control" value="<?php echo isset($last_name) ? trim($last_name) : $row_edit['last_name'] ?> ">
                  </div>

                  <div class="form-group ">
                      <label class="form_label" for="user_name"> Username: </label> <br>
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['user_name_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['user_name_msg'] ;?> </div> <?php 
                          unset($_SESSION['user_name_msg']);  
                      } ?>
                    
                      <input type="text" name="user_name" class="form-control" value="<?php echo isset($user_name) ? trim($user_name) : $row_edit['user_name'] ?> ">
                  </div>

                  <div class="form-group">
                      <label class="form_label" for="email"> Email: </label> <br>
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['email_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['email_msg'] ;?> </div> <?php 
                          unset($_SESSION['email_msg']);  
                      } ?>
                    
                      <input type="email" name="email" class="form-control" value="<?php echo isset($email) ? trim($email) : $row_edit['email'] ?> ">
                  </div>

                  <div class="form-group ">
                      <label class="form_label" for="password"> Password: </label> <br>
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['password_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['password_msg'] ;?> </div> <?php 
                          unset($_SESSION['password_msg']);  
                      } ?>
                      
                      <input type="password" name="password" class="form-control" value="<?= $row_edit['password'] ?> ">
                  </div>

                  <div class="form-group ">
                      <label class="form_label" for="password_confirm"> Password Confirm: </label> <br>
                      <!-- output error msg if we need to -->
                      <?php   
                      if(isset($_SESSION['password_msg']))
                      { ?>
                          <div class='alert-danger'> <?= $_SESSION['password_msg'] ;?> </div> <?php 
                          unset($_SESSION['password_msg']);  
                      } ?>
                    
                      <input type="password" name="password_confirm" class="form-control" value="<?= $row_edit['password'] ?> "> 
                  </div>

                  <div class="form-group " id="category_div">
                        <label class="form_label" for="permission"> Permissions: </label> <br>
                      
                        <select class="form-control" name="permissions" id="permissions_select"> 
                          
                            <!-- if the form has NOT been submitted get choosen option and set as default selected  -->
                            <?php 
                            if(!isset($permissions) || isset($permissions) && $permissions == " ")
                            { ?>
                                  <option selected value="<?= $row_edit['permissions']; ?>"> <?= $row_edit['permissions']; ?> </option> <?php 
                                
                                // also get the other options just incase the user choose the wrong one
                                if( $row_edit['permissions'] === 'admin')
                                { ?>
                                  <option value="user"> user </option>
                                  <option value="staff"> staff </option> <?php 
                                }
                                elseif($row_edit['permissions'] === 'user')
                                { ?>
                                  <option value="admin"> admin </option>
                                  <option value="staff"> staff </option> <?php 
                                } 
                                elseif($row_edit['permissions'] === 'staff')
                                { ?>
                                  <option value="user"> user </option>
                                  <option value="staff"> staff </option>  <?php 
                                }

                            } // the form has been submitted with errors get choosen option
                            else if(isset($permissions) && $permissions != " ") 
                            { ?>
                                  <option selected value="<?= $permissions; ?>"> <?= $permissions; ?> </option> <?php 
                                  
                                // get  the other options just incase the user choose the wrong option
                                if($permissions == 'admin')
                                { ?>
                                  <option value="user"> user </option>
                                  <option value="staff"> staff </option>  <?php 
                                }
                                elseif($permissions == 'user')
                                { ?>
                                  <option value="admin"> admin </option>
                                  <option value="staff"> staff </option>  <?php 
                                } 
                                elseif($permissions == 'staff')
                                { ?>
                                  <option value="user"> user </option>
                                  <option value="staff"> staff </option>  <?php 
                                } 
                            } ?>
                      
                        </select>
                  </div>
            
                  <div class="form-group ">
                        <label class="form_label" for="picture"> Picture: </label> <br> <br>
                        <img id="edit_pic_label1" class="form_label" src="../<?= $row_edit['user_pic'] ?>"  height="100px" width="80px">
                        <input type="file" class="form-control form_pic_input" name="picture" >      
                  </div>
              
                  <div>
                      <button class="btn btn-success"  name="submit" type="submit">Update User</button>   
                  </div>
              </form>
            
          </div>
           
          <div class="col-1"> </div>
        </div>
       
       <br>  <?php 
    } 
} ?>



 <!-- EDIT USER QUERY -->
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
    $join_date  = date("Y-m-d H:i:s");
    $last_login = date("Y-m-d H:i:s");
   
 
    // FORM VALIDATION  //stage 1

      //check for empty fields
      if(empty($first_name))
      {
        $_SESSION['first_name_msg'] = "Please add your first name"; 
      }

      if(empty($last_name))
      {
        $_SESSION['last_name_msg'] = "Please add your last name";
      }

      if(empty($user_name))
      {
        $_SESSION['user_name_msg'] = "Please add a username ";
      }

      if(empty($email))
      {
        $_SESSION['email_msg'] = "Please add email address ";
      }

      if(!filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        $_SESSION['email_msg'] = "Please choose a valid email ";
      }

      if(empty($password))
      {
        $_SESSION['password_msg'] = "Please enter password ";
      }

      if(empty($password_confirm))
      {
        $_SESSION['password_msg'] = "Please enter password ";
      }

      if($password !== $password_confirm)
      {
        $_SESSION['password_msg'] = "Passwords do not match ";
      }

      if(strlen($password) < 6 )
      {
        $_SESSION['password_msg'] = "Password must be at least 6 characters ";
      }

            // stage 2 
            // if no errors run query
      if(empty($_SESSION['first_name_msg']) && empty($_SESSION['last_name_msg']) && empty($_SESSION['user_name_msg']) &&
              empty($_SESSION['email_msg']) && empty($_SESSION['password_msg']) )
      {

            // move images to correct folders but only if we change the image
            if($permissions === "user" && !empty($picture) )
            {
                move_uploaded_file($tmp_picture, "../img/users/customers/$picture");
          
                // then give the image that value so we are able to keep images in seperate folders  
                $picture = "img/users/customers/$picture";        
            }


            if($permissions === "staff" || $permissions === "admin" && !empty($picture) )
            {
                move_uploaded_file($tmp_picture, "../img/users/staff/$picture");
                $picture = "img/users/staff/$picture"; 
            }

            
            if(empty($picture))
            {
                  // get old main pic if its empty
                  $image_query = "SELECT * FROM users WHERE user_id = ? ";
        
                  $stmt_2 = mysqli_stmt_init($connection);
                  
                  if(!mysqli_stmt_prepare($stmt_2,$image_query))
                  {
                    die('prepare stmt 2 failed'.mysqli_error($connection));
                  } 
              
                  if(!mysqli_stmt_bind_param($stmt_2,"i",$users_id))
                  {
                    die('stmt 2 bind failed'.mysqli_error($connection));
                  }
              
                  if(!mysqli_stmt_execute($stmt_2))
                  {
                    die('stmt 2 execute failed'.mysqli_error($connection));
                  }
    
                  $image_result = mysqli_stmt_get_result($stmt_2);
                  
                  if(!$image_result)
                  {
                  die('get former image result query failed'.mysqli_error($connection));
                  }
                
                  $row_old_pic = mysqli_fetch_assoc($image_result);
          
                  $picture = $row_old_pic['user_pic'];
                
                  mysqli_stmt_close($stmt_2);
            
            }
              

            //only hash password if it is being changed
            if($password !== $db_password)
            {
                $password = password_hash($password,PASSWORD_DEFAULT);
            }

            $update_stmt = mysqli_stmt_init($connection);
          
            $update_query = " UPDATE users SET first_name = ?, last_name = ?, user_name = ?, password = ?, 
                              permissions = ?, email = ?, join_date = ?, last_login = ?, user_pic = ? WHERE user_id = ? ";  

            if(!mysqli_stmt_prepare($update_stmt,$update_query))
            {
              die('insert_prep failed'.mysqli_error($connection));
            }

            if(!mysqli_stmt_bind_param($update_stmt,"ssssssssss",$first_name,$last_name,$user_name,$password,$permissions,$email,
                $join_date,$last_login,$picture,$users_id))
            {
              die("insert bind failed".mysqli_error($connection));
            }

            if(!mysqli_stmt_execute($update_stmt))
            {
              die("insert ex failed".mysqli_error($connection));
            }
            
            if(!mysqli_stmt_close($update_stmt))
            {
              die("insert stmt didnt close".mysqli_error($connection));
            } 

            header('location: staff.php');

      }    
   
}

?>