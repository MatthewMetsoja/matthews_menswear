<?php 
require_once "includes/head.php";
require_once "includes/navigation.php"; 
?>
  
<!-- header -->
<div id="headerWrapper">
    <div id="lil_border_nav" >  </div>
    <div id="logo_text"> <img id="thatsme_logo" src="img/small_logos/wow.png" > </div>
</div>

<div id="main_contain" class="container-fluid">

    <div class="row">         
        <div class="col-md-1"> </div>
    
        <div class="col-md-10">
            <div class="row">
                
                <div class="col-sm-4 my_panel_div ">
                    <a href="jumpers.php"> <img src="img/small_logos/jumpers_panel.png" id="my_panel_jumpers" class="img-fluid my_panel_img "> </a> 
                </div>    
                
                <div class="col-sm-4 my_panel_div">
                    <a href="tshirts.php">  <img src="img/small_logos/tshirt_panel.png" id="my_panel_tshirts" class="img-fluid "> </a> 
                </div> 
            
                <div class="col-sm-4 my_panel_div">        
                    <a href="hats.php">  <img src="img/small_logos/hats_panel.png" id="my_panel_hats" class="img-fluid " > </a> 
                </div> 
        
            </div>

            <div class="row">  
                <div class="col-sm-1">  </div>
               
                <div class="col-sm-5 my_panel_div " >    
                    <a href="accessories.php">  <img src="img/small_logos/accessories_panel.png" id="my_panel_accessories" class="img-fluid "> </a> 
                </div>    
                
                <div class="col-sm-5 mypanel_div">     
                    <a href="sale.php">  <img src=img/small_logos/sale_panel.png id="my_panel_sale" class="img-fluid "> </a> 
                </div>

                <div class="col-sm-1">  </div>
            </div>   
        
        </div>

        <div class="col-md-1">  </div>
    </div>   

</div>

<div class="jumbotron jumbotron-fluid" id="jumbo">
    <div class="container">
        <h2 id="jumbo_title" class="display-4 text-center" >Go on and treat yourself.. You deserve it</h2>
        <p class="lead"> 
            Here at That's me clothing Matthew's Menswear we aim to please.... Our garments are hand made and sourced ethically.
            If you have any design requests or would like a product made please do not hesistate to contact us via the link in the menu at the top of the page and 
            we will be more than happy to assist you with a tailer made product to suit your needs. 
        </p>
    </div>
</div>

<?php include "includes/footer.php"; ?>