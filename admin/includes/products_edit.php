<!-- EDIT PRODUCT QUERY -->
<?php

// error message vars
$msg_alert = 
[
  'name' => '', 'category' => '','pic1' => '', 'pic2' => '', 'pic3' => '',  
  'list_price'=> '', 'our_price'=> '',  'stock' => ''
];

$msg = 
[
  'name' => '','category' => '','pic1' => '', 'pic2' => '', 'pic3' => '', 
  'list_price'=> '', 'our_price'=> '', 'stock' => ''
];

if(isset($_POST['submit_update']))
{

    $item_id = filter_var($_GET['item'],FILTER_SANITIZE_STRING);
    // start filters/sanitization declare vars
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    $category = $_POST['category'];
    $stock_onesize = filter_var($_POST['stock_onesize'],FILTER_SANITIZE_NUMBER_INT);
    $price_list = filter_var($_POST['list_price'], FILTER_SANITIZE_STRING);
    $price_our = filter_var($_POST['our_price'], FILTER_SANITIZE_STRING);
    $stock_xl = filter_var($_POST['stock_xl'], FILTER_SANITIZE_NUMBER_INT);
    $stock_lg = filter_var($_POST['stock_lg'], FILTER_SANITIZE_NUMBER_INT);
    $stock_md = filter_var($_POST['stock_md'], FILTER_SANITIZE_NUMBER_INT);
    $stock_sm = filter_var($_POST['stock_sm'], FILTER_SANITIZE_NUMBER_INT);
    $stock_adult = filter_var( $_POST['stock_adult'], FILTER_SANITIZE_NUMBER_INT);
    $stock_child = filter_var($_POST['stock_child'], FILTER_SANITIZE_NUMBER_INT);
    $pic1 = $_FILES['image']['name'];
    $tmp_pic1 = $_FILES['image']['tmp_name'];
    $pic2 = $_FILES['pic2']['name'];
    $tmp_pic2 = $_FILES['pic2']['tmp_name'];
    $pic3 = $_FILES['pic3']['name']; 
    $tmp_pic3 = $_FILES['pic3']['tmp_name'];  
    $total_stock = $stock_xl + $stock_lg +  $stock_md + $stock_sm +  $stock_adult +  $stock_child + $stock_onesize;
   
 
    // FORM VALIDATION stage 1
    if(empty($name))
    {
      $msg['name'] = "Please add a product name ";
      $msg_alert['name'] = "alert-danger" ;
    }

    if($category == " ")
    {
        $msg['category'] = "Please choose a category for the item ";
        $msg_alert['category'] = "alert-danger" ;
    }
    
    if(empty($price_list) || $price_list == 0 || $price_list == "0" )
    {
        $msg['list_price'] = "you forgot to add the list price ";
        $msg_alert['list_price'] = "alert-danger" ;
    }
  
    if(empty($price_our) || $price_our == 0 || $price_our == "0" )
    {
        $msg['our_price'] = "you forgot to add our sale price ";
        $msg_alert['our_price'] = "alert-danger" ;
    }
  
    if($stock_onesize == 0 && $stock_adult == 0 && $stock_child == 0 & $stock_xl == 0 && $stock_lg == 0 && $stock_md == 0 && $stock_sm == 0)
    {
        $msg['stock'] = "You forgot to put in the stock";
        $msg_alert['stock'] = "alert-danger";
    }
    // stage 2  if no errors run query
    else if(empty($msg['name']) && empty($msg['category']) && empty($msg['list_price']) && empty($msg['our_price']) && empty($msg['stock']) ) 
    {

          if($category == 1 )
          {
              if(!empty($pic1))
              {
                  move_uploaded_file($tmp_pic1, "../img/tshirts/front_panel/$pic1");
                  $pic1 = "img/tshirts/front_panel/$pic1";
              }  
              
              if(!empty($pic2))
              {
                  move_uploaded_file($tmp_pic2, "../img/tshirts/modal/$pic2");
                  $pic2 = "img/tshirts/modal/$pic2";
              }
                  
              if(!empty($pic3))
              {
                  move_uploaded_file($tmp_pic3, "../img/tshirts/modal/$pic3");
                  $pic3 = "img/tshirts/modal/$pic3";
              }
          }
                
          if($category == 2 )
          {
              if(!empty($pic1))
              {    
                  move_uploaded_file($tmp_pic1, "../img/jumpers/main/$pic1");
                  $pic1 = "img/jumpers/main/$pic1";
              }
                
              if(!empty($pic2))
              {
                  move_uploaded_file($tmp_pic2, "../img/jumpers/modal/$pic2");
                  $pic2 = "img/jumpers/modal/$pic2";
              }
                
              if(!empty($pic3))
              {
                  move_uploaded_file($tmp_pic3, "../img/jumpers/modal/$pic3");
                  $pic3 = "img/jumpers/modal/$pic3";
              }
    
          }
          
          if($category == 3 )
          {
              if(empty($pic2) || empty($pic3))
              {
                  $pic2 = $pic1;
                  $pic3 = $pic1;
              }
                  
              if(!empty($pic1))
              {  
                  move_uploaded_file($tmp_pic1, "../img/hats/front_panel/$pic1");
                  $pic1 = "img/hats/front_panel/$pic1";
                  $pic2 = "img/jumpers/modal/$pic2";
                  $pic3 = "img/jumpers/modal/$pic3";
              }
          
          }
                
          if($category == 4 || $category == 5 )
          {
              if(empty($pic2) || empty($pic3))
              {
                  $pic2 = $pic1;
                  $pic3 = $pic1;
              }
                
              if(!empty($pic1))
              {
                  move_uploaded_file($tmp_pic1, "../img/accessories/front/$pic1");
                  $pic1 = "img/accessories/front/$pic1"; 
                  $pic2 = "img/jumpers/modal/$pic2";
                  $pic3 = "img/jumpers/modal/$pic3";
              }
          
          }

         
          // get old main pic if its empty
          if(empty($pic1))
          { 
              $image_query = "SELECT * FROM products WHERE id = ? ";
    
              $stmt_2 = mysqli_stmt_init($connection);
              
              if(!mysqli_stmt_prepare($stmt_2,$image_query))
              {
                  die('prepare stmt 2 failed'.mysqli_error($connection));
              } 
              
              if(!mysqli_stmt_bind_param($stmt_2,"i",$item_id))
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
              $pic1 = $row_old_pic['image_1'];
              mysqli_stmt_close($stmt_2);
          }

          
          // get old pic2 if its empty
          if(empty($pic2))
          { 
              $image2_query = "SELECT * FROM products WHERE id = ? ";
    
              $stmt_3 = mysqli_stmt_init($connection);
          
              if(!mysqli_stmt_prepare($stmt_3,$image2_query))
              {
                  die('prepare stmt 3 failed'.mysqli_error($connection));
              } 
          
              if(!mysqli_stmt_bind_param($stmt_3,"i",$item_id))
              {
                  die('stmt 3 bind failed'.mysqli_error($connection));
              }
          
              if(!mysqli_stmt_execute($stmt_3))
              {
                  die('stmt 3 execute failed'.mysqli_error($connection));
              }

              $pic2_result = mysqli_stmt_get_result($stmt_3);
              
              if(!$pic2_result)
              {
                  die('get former image2 result query failed'.mysqli_error($connection));
              }
            
              $row_old_pic2 = mysqli_fetch_assoc($pic2_result);
              $pic2 = $row_old_pic2['image_2'];
              mysqli_stmt_close($stmt_3);
          }
              
          // get old pic3 if its empty
          if(empty($pic3))
          { 
              $image3_query = "SELECT * FROM products WHERE id = ? ";
              $stmt_4 = mysqli_stmt_init($connection);
            
              if(!mysqli_stmt_prepare($stmt_4,$image3_query))
              {
                  die('prepare stmt 4 failed'.mysqli_error($connection));
              } 
            
              if(!mysqli_stmt_bind_param($stmt_4,"i",$item_id))
              {
                  die('stmt 4 bind failed'.mysqli_error($connection));
              }
            
              if(!mysqli_stmt_execute($stmt_4))
              {
                  die('stmt 4 execute failed'.mysqli_error($connection));
              }

              $pic3_result = mysqli_stmt_get_result($stmt_4);
              if(!$pic3_result)
              {
                  die('get former image3 result query failed'.mysqli_error($connection));
              }
            
              $row_old_pic3 = mysqli_fetch_assoc($pic3_result);
              $pic3 = $row_old_pic3['image_3'];
              mysqli_stmt_close($stmt_4);
          }
          

          // update product prepared statement     
          $update_query = " UPDATE products SET  title = ? , price = ?,
          list_price = ?, category = ?, image_1 = ?, image_2 = ?, image_3 = ?,
          size_xl = ?, size_lg = ?, size_md = ?, size_sm = ?, size_adult = ?, size_child = ?, size_onesize = ?,
          total_stock = ? WHERE id = ? ";
  
          $stmt_up = mysqli_stmt_init($connection);
          if(!$stmt_up)
          {
              die('initialize stmt_up failed'.mysqli_error($connection));
          }    
  
          if(!mysqli_stmt_prepare($stmt_up,$update_query))
          {
              die('prepare stmt_up failed'.mysqli_error($connection));   
          }
  
          if(!mysqli_stmt_bind_param($stmt_up,"sssisssiiiiiiiii",$name,$price_our,$price_list,$category,$pic1,$pic2,
          $pic3,$stock_xl,$stock_lg,$stock_md,$stock_sm,$stock_adult,$stock_child,$stock_onesize,$total_stock,$item_id))
          {
              die('bind stmt_up failed'.mysqli_error($connection));   
          }
  
          if(!mysqli_stmt_execute($stmt_up))
          {
              die('execute stmt_up update db failed'.mysqli_error($connection));   
          }
  
          else
          {
              mysqli_stmt_close($stmt_up);
              header("Location: products.php?product=".$category); 
          }    
 
    }    
} 


// show form  
if(isset($_GET['item']))
{
    $item_id = filter_var($_GET['item'],FILTER_SANITIZE_STRING);

    $stmt_edit = mysqli_stmt_init($connection);
    $edit_query = "SELECT * FROM products LEFT JOIN categories ON category = cat_id WHERE id = ? ";

    if(!mysqli_stmt_prepare($stmt_edit,$edit_query))
    {
        die("prep failed stmt edit query".mysqli_error($connection));   
    }
  
    if(!mysqli_stmt_bind_param($stmt_edit,"i",$item_id))
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
        $old_category = $row_edit['cat_id']; 
        $old_pic1 = $row_edit['image_1']; 
        $old_pic2 = $row_edit['image_2']; 
        $old_pic3 = $row_edit['image_3'];
        $old_price = $row_edit['price'];
        $old_list_price = $row_edit['list_price'];   ?>

          <!-- FORM STARTS HERE -->

          <div class="text-center">
            <h6> <b> Edit product </b> </h6>

              <div class="row"> 
                  <div class="col-1"> </div>
                
                  <div id="add_product_form_container" class="col-10"> 
                          
                      <form action="" method="post" enctype="multipart/form-data"  >

                          <div id="form_start" class="form-group ">
                              <label class="form_label" for="product_name"> Product Name: </label> <br>
                              <div class=" <?= $msg_alert['name']; ?>" > <?= $msg['name']; ?> </div>
                              <input type="text" name="name" class="form-control" value="<?php echo isset($name) ? trim($name) : $row_edit['title'] ?> ">
                          </div>

                          
                          <div class="form-group " id="category_div">
                              <label class="form_label" for="product_category"> Category: </label> <br>
                              <div class=" <?= $msg_alert['category']; ?>" > <?= $msg['category']; ?> </div>
                              
                              <select class="form-control" name="category" id="choose_category" > 

                                  <option value="<?= $row_edit['cat_id'] ?>"> <?= $row_edit['cat_name'] ?> </option>
                            
                                  <?php // get  the other categories just incase the user choose the wrong one
                                  $selectCat1_query = "SELECT * FROM categories WHERE cat_id != $old_category " ;
                                  $selectCat1_result = mysqli_query($connection,$selectCat1_query);
                                  if(!$selectCat1_result)
                                  {
                                    die("select cats failed".mysqli_error($connection));
                                  }
                                  
                                  while($row11 = mysqli_fetch_assoc($selectCat1_result))
                                  {  ?>
                                  
                                  <option value="<?= $row11['cat_id'] ?>"> <?= $row11['cat_name'] ?> </option> <?php 
                                      
                                  } ?>
                              
                              </select>   
                          </div>

                          <div class="form-group ">
                              <label  class="form_label" for="product_name"> Picture 1 (main): </label> <br> <br> 
                              <img id="edit_pic_label1" class="form_label" src="../<?= $row_edit['image_1'] ?>"  height="100px" width="80px">
                              <br>
                
                              <input type="file" class="form-control form_pic_input" name="image" >                
                          </div>

                          <div id="add_product_pic2" class="form-group ">
                              <label  class="form_label" for="product_name"> Picture 2: </label> <br> <br> 
                              <img id="edit_pic_label2" class="form_label" src="../<?= $row_edit['image_2'] ?>"  height="100px" width="80px"> <br>
                              <div class=" <?= $msg_alert['pic2'] ?>" > <?= $msg['pic2'] ?> </div>

                              <input type="file" name="pic2"  class="form-control form_pic_input">
                          </div>

                          <div class="form-group" id="add_product_pic3">
                              <label  class="form_label" for="product_name"> Picture 3: </label> <br>  <br> 
                              <img id="edit_pic_label3" class="form_label" src="../<?= $row_edit['image_3'] ?>"  height="100px" width="80px"><br>
                              <div class=" <?= $msg_alert['pic3'] ?>" > <?= $msg['pic3'] ?> </div>

                              <input type="file" name="pic3" class="form-control form_pic_input" >
                          </div>
                     
                          <div class="form-group " id="price_div">
                              <div class="<?= $msg_alert['list_price']; ?>"> <?= $msg['list_price']; ?> </div>   
                              <label id="price_label" class="form_label" for="product_name"> Original Price:   <br> (please enter pounds and pennys) </label> <br> 
                        
                              <span id="pound_sign" class="pound_sign"> £ </span> 
                              <input id="list_price_input" class="form-control" type="number" placeholder="0" min=0 step="0.01" value="<?= isset($price_list) ? $price_list : $old_list_price ?>" name="list_price">
                          </div>
                          

                          <div class="form-group " id="price_div1">
                              <div class="<?= $msg_alert['our_price']; ?>"> <?= $msg['our_price']; ?> </div>
                              <label class="form_label"  for="product_name">Our Price:  <br> (please enter pounds and pennys)  </label> <br> 
                            
                              <span id="pound_sign1" class="pound_sign1"> £ </span>  
                              <input id="our_price_input" class="form-control" type="number" placeholder="0" min=0 step="0.01" value="<?= isset($price_our) ? $price_our : $old_price ?>" name="our_price" >     
                          </div>
                         
                          <br>

                          <div class="form-group " id="stock_group">
                              <label class="form_label" for="product_name"> Stock: </label>  <br>
                                
                              <div id="stock_box_div"> 
                                  <div class=" <?= $msg_alert['stock'] ?>" id="stock_alert_div" > <?= $msg['stock'] ?> </div>
                                     
                                  <span> 
                                    OneSizeF/A: <input  type="number" min=0 value="<?= isset($stock_onesize) ? $stock_onesize : $row_edit['size_onesize'] ;?>" name="stock_onesize">
                                  </span>
                                  <span id="foursize_stock">
                                      XL: <input  type="number"  min=0 value="<?= isset($stock_xl) ? $stock_xl : $row_edit['size_xl'] ;?>" name="stock_xl"> 
                                      Large: <input type="number" min=0 value="<?= isset($stock_lg) ? $stock_lg : $row_edit['size_lg'] ;?>"  name="stock_lg" > 
                                      <span id="foursize_stock_split">  Medium: <input type="number" min=0 value="<?= isset($stock_md) ? $stock_md : $row_edit['size_md'] ;?>"  name="stock_md">   
                                        Small: <input type="number" min=0  value="<?= isset($stock_sm) ? $stock_sm : $row_edit['size_sm'] ;?>" name="stock_sm">  
                                      </span>  <br> 
                                  </span>  
                                  <span  class="form_label" id="twosize_stock">
                                      Adult: <input type="number" min=0 value="<?= isset($stock_adult) ? $stock_adult : $row_edit['size_adult'] ;?>"  name="stock_adult">   
                                      Child: <input type="number" min=0 value="<?= isset($stock_child) ? $stock_child : $row_edit['size_child'] ;?>" name="stock_child"> <br> 
                                  </span>  
                                        
                              </div>

                          </div>
                          
                          <div class="submit_btn_div">
                              <button class="btn btn-success" id="edit_product_btn" name="submit_update" type="submit">Update product</button>
                          </div>

                      </form>

                  </div>

                  <div class="col-1"> </div>
              </div>
              
          </div>
          
          <br>  <?php  
    } 
            
}
 

 ?>


 