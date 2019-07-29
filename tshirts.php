<?php 
require_once "includes/head.php";
require_once "includes/navigation.php"; 
?>

<div id="jumper_headerWrapper">
    <div id="lil_border_nav" >  </div>
    <div id="logo_text"> <img id="thatsme_logo" src="img/small_logos/wow.png" > </div>
</div>

<div id="jumper_contain" class="container-fluid">
  <div class="row"> 
 
    <div class="col-md-1"> </div>

    <div class="col-md-10">
    
      <div class="row">     
        <?php 
          $query = "SELECT * FROM products WHERE category = 1 AND total_stock != 0 " ;
          $result = mysqli_query($connection,$query);
          
          if(!$result)
          {
            die('select query failed'.mysqli_error($connection));
          }
      
          while($row = mysqli_fetch_assoc($result))
          { ?>
        
            <div class="col-lg-3 col-md-6 products">
           
                <a class="modal_1_pics" id="<?php echo $row['id'] ?>" > 
                  <img class="img-fluid main_img" src="<?php echo $row['image_1'] ?> "  >   
                </a> 
            
                <h5 class="item_title"><?php echo $row['title'] ?> </h5>
            
                <p class="price_para"> £<?php echo $row['price'] ?> </p>
           
            </div>  <?php

          }  ?>
         
             
      </div> 

    </div>

    <div class="col-md-1">  </div>
 
  </div>
</div>

<?php include "includes/footer.php"; ?>

