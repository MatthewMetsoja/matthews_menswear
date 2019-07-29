$(document).ready(function () {
   
    /// show side menu for small screens button toggle 
    $('#nice_box_btn').click(function(){
       
        $('#nice_box').toggle();

    });
 

    // brand logo on hover change background;
    $('#home_link').hover(function () {
      
      // over
      $(this).attr('src','img/small_logos/smallmatty_hover.png'); 
    }, function () {
      
      // out
      $(this).attr('src','img/small_logos/smallmatty.png'); 
    }
    );


    // panel pictures on hover change background;
    $('#my_panel_jumpers').hover(function () {
        // over
        $(this).attr('src','img/small_logos/jumper_hover1.png'); 
    }, function () {
        // out
        $(this).attr('src','img/small_logos/jumpers_panel.png'); 
    });

    $('#my_panel_tshirts').hover(function(){
  
      $(this).attr('src','img/small_logos/thsirts_hover1.png');
    },function(){
        $(this).attr('src','img/small_logos/tshirt_panel.png');
    }
    );

    $('#my_panel_hats').hover(function () {
      // over
      $(this).attr('src','img/small_logos/hats1_hover.png'); 
    }, function () {
      // out
      $(this).attr('src','img/small_logos/hats_panel.png'); 
    }
    );

    $('#my_panel_sale').hover(function () {
      // over
        $(this).attr('src','img/small_logos/sale1_hover.png'); 
    }, function () {
        // out
        $(this).attr('src','img/small_logos/sale_panel.png'); 
    }
    );

    $('#my_panel_accessories').hover(function () {
        // over
        $(this).attr('src','img/small_logos/acessory_hover1.png'); 
    }, function () {
        // out
        $(this).attr('src','img/small_logos/accessories_panel.png'); 
    }
    );

    //modal t shirt, jumper 3pic items pages AJAX way      
    $(".modal_1_pics").on('click', function(){

         var id = $(this).attr('id');
     
         var data = {"id" : id};

        $.ajax({
            url: "/matthews_menswear/3pic_modal.php"  ,
            method : "post",
            data: data,
          
            // add modal with new info to after body
            success: function(data){
              $('body').prepend(data);
              $('#threepic_modal').modal('show');
            },
            error: function(){
                alert('something went wrong!');
            }
        });

        $('#threepic_modal').on('hidden.bs.modal', function () {
        
          setTimeout(function(){
                jQuery('#threepic_modal').remove();
          },50);
        
      });
        
   

    });
 
      
      //modal hats page and rest of 1 pic items
      $('.onepic_modal_link').click(function(){
            
          var id = $(this).attr('id');
  
          var data = {"id" : id};

          $.ajax({
             
            url: "/matthews_menswear/1pic_modal.php"  ,
            method : "post",
            data: data,
          
            // add modal with new info to after body
            success: function(data){
                $('body').prepend(data);
                $('#onepic_modal').modal('show');
            },
            error: function(){
                alert('something went wrong!');
            }
          });

          $('#onepic_modal').on('hidden.bs.modal', function () {

            setTimeout(function(){
                jQuery('#onepic_modal').remove();
            },50);

          });
     

      });
 

    //modal accessories page // onesize modal /////// 
    $('.accessories_modal_link').click(function(){
            
        //get values from item clicked on 
        var title = $(this).attr('rel');
        var stock = $(this).find('.stock').attr('rel');
        var main_pic = $(this).find('#main_img').attr('src');
        var price = $(this).find('.price').attr('rel');

        // hide add to basket btn if stock is empty 
        if(stock == 0){
          $('#add_to_basket_btn').hide();  
        }

       
        // set modal values to the values of the item we click
        $('#modal_title').text(title);
        $('#modal_pic').attr('src', main_pic);
        $('#modal_price').text('£' + price);
        $('#modal_stock').text(stock);
        
        $("#onesize_modal").modal('show');


        $('#onesize_modal').on('hidden.bs.modal',function(){
        
            setTimeout(function(){
                $('#onesize_modal').remove();
            },50);

        });

    });

    // remove login banner after 10seconds
    setTimeout(function(){
        $('.login_banner').fadeOut('slow');
    },2000);

    // update shopping basket (take one from quantity)   
    $('.minus_one_btn').click(function(){

        var edit_id = $(this).attr('rel');
        var edit_size = $(this).val();

        var data = {
            "mode": "minus1",
            "edit_id" : edit_id,
            "edit_size" : edit_size
        };

        $.ajax({
          
            method: "post",
            url: "/matthews_menswear/update_basket.php",
            data: data,
          
            success: function() {
              location.reload(); 
            },
            error: function(){
              alert("something went wront");
            } 
        });

    });


    // update shopping basket  (add one to quantity)   
    $('.plus_one_btn').click(function(){

      var edit_id = $(this).attr('rel');
      var edit_size = $(this).val();

      var data = {
        "mode" : "plus1",
        "edit_id" : edit_id,
        "edit_size" : edit_size
      };

      $.ajax({
          method: "post",
          url: "/matthews_menswear/update_basket.php",
          data: data,
        
          success: function() {
            location.reload(); 
          },
          error: function(){
              alert("something went wront");
          } 
      });

    });

    // update shopping basket (delete item)  
    $('.remove_from_basket_btn').click(function(){
    
      var edit_id = $(this).attr('rel');
      var edit_size = $(this).val();

      var data = {
        "mode" : "delete_item",
        "edit_id" : edit_id,
        "edit_size" : edit_size
      };

      $.ajax({
          method: "post",
          url: "/matthews_menswear/update_basket.php",
          data: data,
          
          success: function() {
            location.reload(); 
          },
          error: function(){
            alert("something went wront");
          } 
      });

    });


    // remove product added to basket alert after 2seconds
    setTimeout(function(){
        $('#nav2').fadeOut('slow');
    },2000);


});

