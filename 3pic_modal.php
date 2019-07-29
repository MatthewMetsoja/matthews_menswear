<?php require_once "includes/init.php"; 

  if(isset($_POST['id']))
  {
       $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
  }
  else
  {
      $id = null;
  }
 
  $query = "SELECT * FROM products WHERE id = $id ";
  $result = mysqli_query($connection,$query);
  $row = mysqli_fetch_assoc($result);

?>


<!-- Modal -->
<?php ob_start(); ?>
<div class="modal fade bd-modal-lg " id="threepic_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="t_shirtModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="t_shirtModalLabel"> <?= $row['title'] ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                   
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
                
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <img id="first_slide" class="d-block w-100 " src="<?php echo $row['image_1'] ?>" alt="<?= $row['image_1'] ?>">
                  </div>
                 
                  <div class="carousel-item">
                      <img id="second_slide" class="d-block w-100" src="<?= $row['image_2'] ?> " alt="<?= $row['image_1'] ?>">
                  </div>
                 
                  <div class="carousel-item">
                      <img id="third_slide" class="d-block w-100" src="<?= $row['image_3'] ?> " alt="<?= $row['image_3'] ?>">
                  </div>
              </div>
               
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
              </a>
                
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
              </a>
        </div>

        <div id="size_sm" rel="<?= $row['size_sm'] ?> "> </div>
        <div id="size_md" rel="<?= $row['size_md'] ?> "> </div>
        <div id="size_lg" rel="<?= $row['size_lg'] ?> "> </div>
        <div id="size_xl" rel="<?= $row['size_xl'] ?> "> </div>

      </div>
    
      <div id="">   £<?= $row['price'] ?>  </div>
         
     
      <div class="modal-footer">
    
          <form action="" method="post" id="add_product_form"> 
              <span id="modal_errors" class="alert-danger"></span>

              <div class="form-group">
                  <label for="size">Size</label>
                  <select name="size" id="size_onepic_modal">
                          
                          <option default > ** Please choose ** </option>
                      
                      <?php      
                      if($row['size_xl'] != 0)
                      { ?> 
                          <option id="option1PicModal_xl" value="xl" rel="<?= $row['size_xl'] ?>" >XL</option> <?php
                      }
                          
                      if($row['size_lg'] != 0)
                      { ?> 
                          <option id="option1PicModal_lg" value="lg" rel="<?= $row['size_lg'] ?>" >L</option> <?php 
                      }

                      if($row['size_md'] != 0)
                      { ?> 
                          <option id="option1PicModal_md" value="md" rel="<?= $row['size_md'] ?>" >M</option> <?php 
                      }

                      if($row['size_sm'] != 0)
                      { ?> 
                          <option id="option1PicModal_sm" value="sm" rel="<?= $row['size_sm'] ?>" >S</option> <?php 
                      }

                      if($row['size_adult'] != 0)
                      { ?> 
                          <option id="option1PicModal_adult" value="adult" rel="<?= $row['size_adult'] ?>" >Adult</option> <?php 
                      }

                      if($row['size_child'] != 0)
                      { ?> 
                          <option id="option1PicModal_child" value="child" rel="<?= $row['size_child'] ?>" >Child</option> <?php 
                      }

                      if($row['size_onesize'] != 0)
                      { ?> 
                          <option id="option1PicModal_onesize" value="onesize" rel="<?= $row['size_onesize'] ?>" >One size fits all</option> <?php 
                      } ?>

                  </select>
              </div>  

              <input id="quantity" type="hidden" min="1" max="" value="1" name="quantity"> 
              <!-- hidden values to send to basket -->
              <input type="hidden" name="image" id="image" value="<?= $row['image_1'] ?> ">
              <input type="hidden" name="title" id="title" value="<?= $row['title'] ?> ">
              <input type="hidden" name="price" id="price" value="<?= $row['price'] ?> ">
              <input type="hidden" name="available" id="available" value=" ">
              <input type="hidden" name="product_id" id="product_id" value="<?= $id ?>">
            
              <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="add_to_basket_btn" type="button" name="add_to_basket" class="btn btn-primary"> Add to basket <i class="fa fa-shopping-basket" aria-hidden="true"></i> </button>
              </div>
                
                            
          </form>
      </div>
    </div>
  </div>
</div>

<script src="js/modal_script.js"></script>

<?php echo ob_get_clean(); ?>