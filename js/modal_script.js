// modal script had to be on here or in footer as ajax is already being sent
$(document).ready(function () {
    
    var basket_modal_error = " ";
    var size =  $('#size_onepic_modal').val();
    if(size == "** Please choose **" || size == " "){
        $("#quantity").attr('max',1);
    }      


    // get the available stock when we change size and set it to variable
    $('#size_onepic_modal').change(function(){
       // get size selected and find out the stock available for that size   
      var available = $('#size_onepic_modal option:selected').attr("rel");
     
      // set the available stock into value attribute of hidden input so we can post it to basket page
      $('#available').val(available);

      // set max amount that the user can buy to the amount of stock we have for the selected item
      $("#quantity").attr('max', available);
         
  });
    // on add to basket button click
    $('#add_to_basket_btn').click(function(){
  
      var size =  $('#size_onepic_modal').val();
      var quantity = $('#quantity').val();
      var available = $('#available').val();

      // output error message size has not been selected
      if(size === "** Please choose **"){
        basket_modal_error += '<p id="size_error" class="text-danger text-center">Please choose a size. </p>';
        $('#modal_errors').html(basket_modal_error);
          
           setInterval(function(){
             $('#size_error').fadeOut(1000);
             basket_modal_error = " ";
           },3000) 
        return;
    }

    else{
        if(quantity > available){
             quantity = available;
        }

        // wiil take the values of the form and serialize the into get url then we can use them with ajax
        var data = $('#add_product_form').serialize();

        $.ajax({
            type: "post",
            url: "/matthews_menswear/add_to_basket.php",
            data: data,
            success: function () {
                location.reload();
            },
            error: function(){
             alert('something went wrong');   
            }
        });


    } 


  }); 


});

