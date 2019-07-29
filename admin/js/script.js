$(document).ready(function (){
   
    /// show side menu for small screens button toggle 
    $('#nice_box_btn').click(function(){
        $('#nice_box').toggle();
    }); 
  
    // brand logo on hover change background;
    $('#home_link').hover(function (){
        // over
        $(this).attr('src','../img/small_logos/smallmatty_hover.png'); 
    }, function (){
        // out
        $(this).attr('src','../img/small_logos/smallmatty.png'); 
    });





    var category = $('#choose_category').val();

    if(category == 1 || category == 2 || category == " "){
        
      $('#add_product_pic2, #add_product_pic3').show();
            
    }
    else
    {
      $('#add_product_pic2, #add_product_pic3').hide();   
    }

    $('#choose_category').change(function(){

        var category = $(this).val();

              if(category == 1 || category == 2 || category == " "){
                $('#add_product_pic2, #add_product_pic3').show();
              
            
              }

              else{
                $('#add_product_pic2, #add_product_pic3').hide();
              
              }
      
    });

    
      // £ SIGN ADJUSTMENT WHEN ALERT IS OPEN (ON PAGE LOAD)
      var size = $(window).width(); // New width
      var price_alert = $('#price_label').html();
    
      // SMALL SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
      if(size <= 752  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
        $('#pound_sign').addClass('move_the_pound_sign_SM');
        $('#pound_sign1').addClass('move_the_pound_sign1_SM');
        
      }
      else{
        $('#pound_sign').removeClass('move_the_pound_sign_SM');
        $('#pound_sign1').removeClass('move_the_pound_sign1_SM');
      }
      
      
      // MEDIUM SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
      if(size >= 754 && size <= 976  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
        $('#pound_sign').removeClass('move_the_pound_sign_LG');
        $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
        $('#pound_sign').removeClass('move_the_pound_sign_SM');
        $('#pound_sign1').removeClass('move_the_pound_sign1_SM');
       
        $('#pound_sign').addClass('move_the_pound_sign_MD');
        $('#pound_sign1').addClass('move_the_pound_sign1_MD');
        
      }
      else{
        $('#pound_sign').removeClass('move_the_pound_sign_MD');
        $('#pound_sign1').removeClass('move_the_pound_sign1_MD');
      }
       
       // LARGE SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
      if(size >= 977  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
          $('#pound_sign').removeClass('move_the_pound_sign_XL');
          $('#pound_sign1').removeClass('move_the_pound_sign1_XL');
          $('#pound_sign').removeClass('move_the_pound_sign_MD');
          $('#pound_sign1').removeClass('move_the_pound_sign1_MD');
       
        $('#pound_sign').addClass('move_the_pound_sign_LG');
        $('#pound_sign1').addClass('move_the_pound_sign1_LG');
        
      }
      else{
        $('#pound_sign').removeClass('move_the_pound_sign_LG');
        $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
      }

        // XL SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
      if(size >= 1185  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
          $('#pound_sign').removeClass('move_the_pound_sign_LG');
          $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
         
          $('#pound_sign').addClass('move_the_pound_sign_XL');
          $('#pound_sign1').addClass('move_the_pound_sign1_XL');
          
      }
      else{
          $('#pound_sign').removeClass('move_the_pound_sign_XL');
          $('#pound_sign1').removeClass('move_the_pound_sign1_XL');
      }
   
      // £ SIGN ADJUSTMENT WHEN ALERT IS OPEN (ON WINDOW RESIZE)
      $(window).resize(function(){
       
          var size = $(window).width(); // New width

          // SMALL SCREEN £ SIGN ADJUSTMENT 
          if(size <= 752  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
            $('#pound_sign').removeClass('move_the_pound_sign_MD');
            $('#pound_sign1').removeClass('move_the_pound_sign1_MD');
          
            $('#pound_sign').addClass('move_the_pound_sign_SM');
            $('#pound_sign1').addClass('move_the_pound_sign1_SM');
            
          }
          else{
            $('#pound_sign').removeClass('move_the_pound_sign_SM');
            $('#pound_sign1').removeClass('move_the_pound_sign1_SM');
          }
            
          // MEDIUM SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
          if(size >= 754 && size <= 976  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
            $('#pound_sign').removeClass('move_the_pound_sign_LG');
            $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
            $('#pound_sign').removeClass('move_the_pound_sign_SM');
            $('#pound_sign1').removeClass('move_the_pound_sign1_SM');
          
            $('#pound_sign').addClass('move_the_pound_sign_MD');
            $('#pound_sign1').addClass('move_the_pound_sign1_MD');
            
          }
          else{
            $('#pound_sign').removeClass('move_the_pound_sign_MD');
            $('#pound_sign1').removeClass('move_the_pound_sign1_MD');
          }
          
          // LARGE SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
          if(size >= 977  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
            $('#pound_sign').removeClass('move_the_pound_sign_XL');
              $('#pound_sign1').removeClass('move_the_pound_sign1_XL');
              $('#pound_sign').removeClass('move_the_pound_sign_MD');
              $('#pound_sign1').removeClass('move_the_pound_sign1_MD');
          
            $('#pound_sign').addClass('move_the_pound_sign_LG');
            $('#pound_sign1').addClass('move_the_pound_sign1_LG');
            
          }
          else{
            $('#pound_sign').removeClass('move_the_pound_sign_LG');
            $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
          }

          // XL SCREEN £ SIGN ADJUSTMENT WHEN ALERT IS OPEN
          if(size >= 1185  && price_alert != ' Original Price:   <br> (please enter pounds and pennys) '){
              $('#pound_sign').removeClass('move_the_pound_sign_LG');
              $('#pound_sign1').removeClass('move_the_pound_sign1_LG');
            
              $('#pound_sign').addClass('move_the_pound_sign_XL');
              $('#pound_sign1').addClass('move_the_pound_sign1_XL');
              
          }
          else{
              $('#pound_sign').removeClass('move_the_pound_sign_XL');
              $('#pound_sign1').removeClass('move_the_pound_sign1_XL');
          }

      });
      
   
      /// open delete product modal 
      $('.delete_btn_to_open_modal').click(function(){
        
        // get values from clicked on item and put into vars
        var id = $(this).attr('rel'); 
        var title = $(this).attr('id');
        var category = $(this).find('.send_title').val(); 
        var image = $(this).find('.send_title').attr('rel'); 

        $('#modal_span_id').html(title);
        $('#modal_span_title_cat').html(category);
        $('#modal_delete_product_pic').attr('src','../' + image);
        $('#id_to_send').val(id);
        $('#delete_product_modal').modal('show');

      });

      
    // remove login banner after 10seconds
    setTimeout(function(){
      $('.login_banner').fadeOut('slow');
    },2000);


});

