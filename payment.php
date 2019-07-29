<?php include "includes/head.php" ?>
<?php include "includes/navigation.php" ?>

<div class="container-fluid" id="jumper_contain">
    <div class="row"> 
      <div class="col-3"></div>
       
        <div class="col-6" id="step2">
          
            <?php
            // Stripe API publishable key
            $publishable_key = getenv(STRIPE_Publishable_test) ;

            // Product details
            $productName = 'matthews menswear';
            $basket_total = strval(round($totalcost_counter * 100));

            $productPrice = $basket_total;

            $currency = 'gbp';

            $productPriceFormat = number_format(($productPrice/100), 2, '.', ' ');
            ?>

            <div class="container">
                <div id="payment_form" class="item"> <br>
                    <!-- Product details -->
                    <h4 id="payment_head" class="text-center"> Payment <i class="fas fa-shopping-basket    "></i>   <br>  <span class="text-center"> <img src="/e-commerce/img/small_logos/wow.png" width="100px" height="100px"> </span>  </h4>
                
                    <p class="text-center">Please click below to continue to payment</p>
                        <p class="text-center">
                            <?= $basket_counter; 
                        
                            if($basket_counter == 1)
                            { ?> 
                                Item <?php 
                            }
                            else
                            { ?> 
                                Items <?php 
                            } ?>  
                        </p>
                        
                        <p class="text-center">Basket total: £<?php echo $productPriceFormat.' '.strtoupper($currency); ?></p>
                    
                    <div id="back_btn_payment">
                        <a   class="btn btn-secondary" href="check_out.php" >Go Back </a>  
                    </div>
                    
                    <!-- Buy button -->
                    <div class="text-center" id="buynow">
                        <button class="btn-lg btn-success" id="payButton">Pay now</button>
                        <input type="hidden" id="payProcess" value="0"/>
                    </div>
                </div>
            
            </div> 
        </div>

        <div class="col-3"></div>
        
    </div>
</div>
  
<script>
var handler = StripeCheckout.configure({
    key: '<?php echo $publishable_key; ?>',
    image: '/e-commerce/img/small_logos/wow.png',
    locale: 'auto',
    token: function(token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        
        $('#paymentDetails').hide();
        $('#payProcess').val(1);
        $.ajax({
            url: '/e-commerce/stripe_charge.php',
            type: 'POST',
            data: {
                   stripeToken: token.id,
                   stripeEmail: token.email,
                   itemName: '<?php echo $productName; ?>',
                   itemPrice: '<?php echo $productPrice; ?>',
                   currency: '<?php echo $currency; ?>'
                   },
            // dataType: "json",
            beforeSend: function(){
                $('#payButton').prop('disabled', true);
                $('#payButton').html('Please wait...');
            },
            success: function(data){
                $('#payProcess').val(0);
                  location.replace("/e-commerce/thank_you.php")
            },
            error: function(data) {
                $('#payProcess').val(0);
                $('#payButton').prop('disabled', false);
                $('#payButton').html('Buy Now');
                alert('Some problem occurred, please try again.');
            }
        });
    }
});

var stripe_closed = function(){
    var processing = $('#payProcess').val();
    if (processing == 0){
        $('#payButton').prop('disabled', false);
        $('#payButton').html('Buy Now');
    }
};

var eventTggr = document.getElementById('payButton');
if(eventTggr){
    eventTggr.addEventListener('click', function(e) {
        $('#payButton').prop('disabled', true);
        $('#payButton').html('Please wait...');
        
        // Open Checkout with further options:
        handler.open({
            name: 'Matthews Menswear',
            description: '<?php echo $productName; ?>',
            amount: '<?php echo $totalcost_counter * 100; ?>',
            currency: '<?php echo $currency; ?>',
            closed:	stripe_closed
        });
        e.preventDefault();
    });
}

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
</script>

   <?php include "includes/footer.php"; ?>