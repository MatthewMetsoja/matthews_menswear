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


//  <!-- ADD PRODUCT QUERY -->
if(isset($_POST['submit']))
{
 

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
    
  
    // FORM VALIDATION
    //stage 1  
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
    
    if(empty($pic1))
    {
        $msg['pic1'] = "Please choose a main pic for the item ";
        $msg_alert['pic1'] = "alert-danger" ;
    }
  
    if($category == 1 && $pic2 == '')
    {
        $msg['pic2'] = "Please choose a second pic for the item ";
        $msg_alert['pic2'] = "alert-danger" ;
    }

    if($category == 1 && $pic3 == '')
    {
        $msg['pic3'] = "Please choose a third pic for the item ";
        $msg_alert['pic3'] = "alert-danger" ;
    }

    if($category == 2 && $pic2 == '')
    {
        $msg['pic2'] = "Please choose a second pic for the item ";
        $msg_alert['pic2'] = "alert-danger" ;
    }

    if($category == 2 && $pic3 == '')
    {
        $msg['pic3'] = "Please choose a third pic for the item ";
        $msg_alert['pic3'] = "alert-danger" ;
    }

    if(empty($price_list))
    {
        $msg['list_price'] = "you forgot to add the list price ";
        $msg_alert['list_price'] = "alert-danger" ;
    }
  
    if(empty($price_our))
    {
        $msg['our_price'] = "you forgot to add our sale price ";
        $msg_alert['our_price'] = "alert-danger" ;
    }
  
    if($stock_onesize == 0 && $stock_adult == 0 && $stock_child == 0 & $stock_xl == 0 && $stock_lg == 0 && $stock_md == 0 && $stock_sm == 0)
    {
        $msg['stock'] = "You forgot to put in the stock";
        $msg_alert['stock'] = "alert-danger";
    }

    // check that product does not exist already
    $stmt = mysqli_stmt_init($connection);   
    $product_exists_query = "SELECT * FROM products WHERE category = ? and title = ? ";
    if(!mysqli_stmt_prepare($stmt,$product_exists_query))
    {
        die('prep product exists failed'.mysqli_error($connection));
    } 
    if(!mysqli_stmt_bind_param($stmt,'is',$category,$name))
    {
        die("bind product exists failed".mysqli_error($connection));
    }

    if(!mysqli_stmt_execute($stmt))
    {
        die("execute prod exists failed".mysqli_error($connection));
    }

    $product_exists_result = mysqli_stmt_get_result($stmt);
      
    if(mysqli_num_rows($product_exists_result) != 0 )
    {
        $msg['name'] = 'There is already a product with the same name in that category ';
        $msg_alert['name'] = 'alert-warning'; 
    }

    if(!mysqli_stmt_close($stmt))
    {
        die("does item exist stmt didnt close".mysqli_error($connection));
    } 

    // stage 2 
    // if no errors run query
      if(empty($msg['name']) && empty($msg['category']) && empty($msg['list_price']) && empty($msg['our_price']) && empty($msg['pic1']) && 
        empty($msg['pic2']) && empty($msg['pic3']) && empty($msg['stock'])  )
      {

            // move images to correct folders
            if($category == 1 )
            {
                move_uploaded_file($tmp_pic1, "../img/tshirts/front_panel/$pic1");
                move_uploaded_file($tmp_pic2, "../img/tshirts/modal/$pic2");
                move_uploaded_file($tmp_pic3, "../img/tshirts/modal/$pic3");
            
                // then give the image that value so we are able to keep images in seperate folders  
                $pic1 = "img/tshirts/front_panel/$pic1";
                $pic2 = "img/tshirts/modal/$pic2";
                $pic3 = "img/tshirts/modal/$pic3";
            }

            if($category == 2 )
            {
                move_uploaded_file($tmp_pic1, "../img/jumpers/main/$pic1");
                move_uploaded_file($tmp_pic2, "../img/jumpers/modal/$pic2");
                move_uploaded_file($tmp_pic3, "../img/jumpers/modal/$pic3");

                $pic1 = "img/jumpers/main/$pic1";
                $pic2 = "img/jumpers/modal/$pic2";
                $pic3 = "img/jumpers/modal/$pic3";    
            }

            if($category == 3 )
            {
                move_uploaded_file($tmp_pic1, "../img/hats/front_panel/$pic1");
                $pic1 = "img/hats/front_panel/$pic1";
            }

            if($category == 4 || $category == 5 ){
            move_uploaded_file($tmp_pic1, "../img/accessories/front/$pic1");
            $pic1 = "img/accessories/front/$pic1"; 
            }

            // upload the same pic 3 times for items that only need 1 pic so we dont mess up the query
            if(empty($pic2) || empty($pic3))
            {
                $pic2 = $pic1;
                $pic3 = $pic1;
            }

                $insert_stmt = mysqli_stmt_init($connection);
            
                $insert_query = "INSERT INTO products(title,price,list_price,category,image_1,image_2,
                image_3,size_xl,size_lg,size_md,size_sm,size_adult,size_child,size_onesize,total_stock)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";  

                if(!mysqli_stmt_prepare($insert_stmt,$insert_query))
                {
                  die('insert_prep failed'.mysqli_error($connection));
                }

                if(!mysqli_stmt_bind_param($insert_stmt,"sssisssiiiiiiii",$name,$price_our,$price_list,$category,$pic1,$pic2,$pic3,$stock_xl,
                $stock_lg,$stock_md,$stock_sm,$stock_adult,$stock_child,$stock_onesize,$total_stock))
                {
                    die("insert bind failed".mysqli_error($connection));
                }

                if(!mysqli_stmt_execute($insert_stmt))
                {
                    die("insert ex failed".mysqli_error($connection));
                }
                  
                if(!mysqli_stmt_close($insert_stmt))
                {
                  die("insert stmt didnt close".mysqli_error($connection));
                } 

                header('location: products.php?product='.$category);

      }    
   
} ?>

<!-- FORM STARTS HERE -->
<h6> <b> Add new product </b> </h6>

<div class="row"> 
  
    <div class="col-1"> </div>

    <div id="add_product_form_container" class="col-10"> 
        
      <form action="" method="post" enctype="multipart/form-data" >

          <div id="form_start" class="form-group ">
              <label class="form_label" for="product_name"> Product Name: </label> <br>
                  <!-- output error msg if we need to -->
              <div class=" <?= $msg_alert['name']; ?>" > <?= $msg['name']; ?> </div>
              <input type="text" name="name" class="form-control" value="<?php echo isset($name) ? trim($name) : '' ?> ">
          </div>

        
          <div class="form-group " id="category_div">
              <label class="form_label" for="product_category"> Category: </label> <br>
                  <!-- output error msg if we need to -->
              <div class="<?= $msg_alert['category'] ?>" > <?= $msg['category'] ?> </div>
            
              <select class="form-control" name="category" id="choose_category" > 
                    <?php  //  only show please choose as an option if user has not already submitted form  
                    if(!isset($category) || isset($category) && $category == " ")
                    {  ?>
                            <option selected value=" "> ** Please Choose **</option> 
                      <?php 
                            // relate category table to the product table for category select so we can show category names in select option
                            $selectCat_query = "SELECT * FROM categories ";
                            $selectCat_result = mysqli_query($connection,$selectCat_query);
                        
                          if(!$selectCat_result)
                          {
                            die("select cats failed".mysqli_error($connection));
                          }
                        
                          while($row = mysqli_fetch_assoc($selectCat_result))
                          { ?>
                              <option value="<?= $row['cat_id'] ?>"> <?= $row['cat_name'] ?> </option> 
                            <?php 
                          }
                    } 

                    if(isset($category) && $category != " ")
                    {
                        // get category user selected if they did and submitted the form with errors
                        $selected_query = "SELECT * FROM categories WHERE $category = cat_id" ;
                        $selected_result = mysqli_query($connection,$selected_query);
                        
                        if(!$selected_result)
                        {
                          die("get selected failed".mysqli_error($connection));
                        }
                      
                        $selected_row = mysqli_fetch_assoc($selected_result) ?>
                        
                            <option selected value="<?= $selected_row['cat_id'] ?>"> <?= $selected_row['cat_name'] ?> </option>
                    
                      <?php 
                    
                      // get  the other categories just incase the user choose the wrong one
                        $selectCat1_query = "SELECT * FROM categories WHERE cat_id != $category " ;
                        $selectCat1_result = mysqli_query($connection,$selectCat1_query);
                        
                        if(!$selectCat1_result)
                        {
                          die("select cats failed".mysqli_error($connection));
                        }
                        while($row11 = mysqli_fetch_assoc($selectCat1_result))
                        { ?>
                            <option value="<?= $row11['cat_id'] ?>"> <?= $row11['cat_name'] ?> </option> 
                            
                          <?php 
                      
                        } 

                    } ?>
             </select>
             
          </div>

       
          <div class="form-group ">
                <label class="form_label" for="product_name"> Picture 1 (main): </label> <br> <br>
                <div class=" <?= $msg_alert['pic1'] ?>" > <?= $msg['pic1'] ?> </div>
                <input type="file" class="form-control form_pic_input" name="image" >
            
          </div>

          <div id="add_product_pic2" class="form-group ">
                <label class="form_label" for="product_name"> Picture 2: </label> <br> <br>
                <div class=" <?= $msg_alert['pic2'] ?>" > <?= $msg['pic2'] ?> </div>
                <input type="file" name="pic2"  class="form-control form_pic_input">
          </div>

          <div class="form-group" id="add_product_pic3">
              <label class="form_label" for="product_name"> Picture 3: </label> <br> <br>
              <div class=" <?= $msg_alert['pic3'] ?>" > <?= $msg['pic3'] ?> </div>
              <input type="file" name="pic3" class="form-control form_pic_input" >
          </div>

      
          <div class="form-group " id="price_div">
              <label id="price_label" class="form_label <?= $msg_alert['list_price'] ?>" for="product_name"> Original Price: <?= $msg['list_price'] ?>  <br> (please enter pounds and pennys) </label> <br> 
              <span class="pound_sign" id="pound_sign"> £ </span> <input class="form-control" id="list_price_input" type="number" step="0.01" placeholder="0" value="<?= isset($price_list) ? $price_list : " " ;?>" min=0 name="list_price" >  
          </div>
          

          <div class="form-group " id="price_div1">
              <label class="form_label  <?= $msg_alert['list_price'] ?> " id="our_price_label" for="product_name"> Our Price: <?= $msg['our_price'] ?>  <br> (please enter pounds and pennys)  </label> <br> 
              <label for=""> </label> <span id="pound_sign1" class="pound_sign1"> £ </span>  <input id="our_price_input" class="form-control" type="number" placeholder="0" min=0 step="0.01" value="<?= isset($price_our) ? $price_our : " " ;?>" name="our_price" >  
          </div>
         
          <br>

          <div class="form-group " id="stock_group">
            
              <label class="form_label" for="product_name"> Stock: </label>  <br>
              <div id="stock_box_div"> 
                    <div class=" <?= $msg_alert['stock'] ?>" id="stock_alert_div" > <?= $msg['stock'] ?> </div>
                    <span class="form_label"id="onesize_stock">
                            OneSizeF/A: <input  type="number" min=0 value="<?= isset($stock_onesize) ? $stock_onesize : 0 ;?>" name="stock_onesize">
                    </span>

                    <span id="foursize_stock">
                            XL: <input  type="number"  min=0 value="<?= isset($stock_xl) ? $stock_xl : 0 ;?>" name="stock_xl"> 
                            Large: <input type="number" min=0 value="<?= isset($stock_lg) ? $stock_lg : 0 ;?>"  name="stock_lg" > 
                          <span id="foursize_stock_split">  Medium: <input type="number" min=0 value="<?= isset($stock_md) ? $stock_md : 0 ;?>"  name="stock_md">   
                                Small: <input type="number" min=0  value="<?= isset($stock_sm) ? $stock_sm : 0 ;?>" name="stock_sm">  
                          </span>  <br> 
                    </span>  
                        
                    <span  class="form_label" id="twosize_stock">
                            Adult: <input type="number" min=0 value="<?= isset($stock_adult) ? $stock_adult : 0 ;?>"  name="stock_adult">   
                            Child: <input type="number" min=0 value="<?= isset($stock_child) ? $stock_child : 0 ;?>" name="stock_child"> <br>       
                    </span>  
                        
              </div>
            
          </div>
      
          <div class="submit_btn_div"> 
              <button class="btn btn-success" id="add_product_btn" name="submit" type="submit">Add product</button>
          </div>

      </form>
       
    </div>
    
    <div class="col-1"> </div>
    
</div> <br>
