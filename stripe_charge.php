<?php
 require_once "includes/head.php"; 
 require_once "includes/navigation.php";

    // bring in shipping address details from check_out.php
    $full_name = $_SESSION['payment_full_name'];
    $email = $_SESSION['payment_email'];
    $housename_number = $_SESSION['payment_house_name']; 
    $street_name = $_SESSION['payment_street_name'];
    $city_town = $_SESSION['payment_city']; 
    $post_code = $_SESSION['payment_postcode'];
    $mobile_number = $_SESSION['payment_mobile']; 

    $bskt_query = "SELECT * FROM basket WHERE id = $basket_id " ;

    $result_bskt = mysqli_query($connection,$bskt_query);
    
    if(!$result_bskt)
    {
        die('fetch basket failed'.mysqli_error($connection));  
    }

    $bskt_row = mysqli_fetch_assoc($result_bskt);

    // fetch the basket from the database
    $items_purchased = $bskt_row['items'];

    $customer_details = array();

    $customer_details = array(
     'full_name' => $full_name,
     'email' => $email, 
     'house_name' => $housename_number,  
     'street_name' => $street_name,
     'city' =>  $city_town , 
     'postcode' => $post_code,
     'mobile' => $mobile_number, 
    );

    $customer_details_as_string = json_encode($customer_details); 


// Stripe API secret key
$secret_key = getenv(STRIPE_Secret_test);

$response = array();

// Check whether stripe token is not empty
if(!empty($_POST['stripeToken']))
{
    
    // Get token, card and item info
    $token  = $_POST['stripeToken'];
    $email  = $_POST['stripeEmail'];
    $itemPrice = $_POST['itemPrice'];
    $currency = $_POST['currency'];
    $itemName = $_POST['itemName'];
    
 
    // Set api key
    \Stripe\Stripe::setApiKey($secret_key);
    
    // Add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));
    
    // Charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
    ));
    
    // Retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    // Check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
    {
        
        // Order details 
        $amount = $chargeJson['amount'];
        $currency = $chargeJson['currency'];
        $txnID = $chargeJson['balance_transaction'];
        $status = $chargeJson['status'];
        $orderID = $chargeJson['id'];
        $payerName = $chargeJson['source']['name'];

        // Insert transaction data into database for paid orders (orders)
        $stmt = mysqli_stmt_init($connection);
        $order_date =  date("Y-m-d H:i:s"); 
        
        $query = "INSERT INTO orders(customer_details,ordered_items,total_paid,order_date) VALUES(?,?,?,?)";
        
        $basket_total = number_format($totalcost_counter,2);
        
        if(!mysqli_stmt_prepare($stmt,$query))
        {
            die("insert to orders prep failed".mysqli_error($connection));
        }

        if(!mysqli_stmt_bind_param($stmt,"ssss",$customer_details_as_string,$items_purchased,$basket_total,$order_date))
        {
            die("insert to orders bind failed".mysqli_error($connection));
        }
        
        if(!mysqli_stmt_execute($stmt))
        {
            die("insert to orders execute failed".mysqli_error($connection));
        }
        
        // get id from db so we can use it on thank_you.php to print reciept
        $order_id = mysqli_insert_id($connection);
        
        // set cookie for this id on the users computer so we can print the reciept 
        setcookie(ORDER_COOKIE,$order_id,time() + (60 * 60 * 24));

        mysqli_stmt_close($stmt);
        
        // delete basket from database 
        $stmt1 = mysqli_stmt_init($connection);
        
        $query = " DELETE FROM basket WHERE id = ? ";
        
        if(!mysqli_stmt_prepare($stmt1,$query))
        {
            die("delete basket prep failed".mysqli_error($connection));
        }
        
        if(!mysqli_stmt_bind_param($stmt1,"i",$basket_id))
        {
            die("delete basket bind failed".mysqli_error($connection));
        }
        
        if(!mysqli_stmt_execute($stmt1))
        {
            die("delete basket execute failed".mysqli_error($connection));
        }
        
        mysqli_stmt_close($stmt1);

        // empty sessions and unset cookies
        unset($_SESSION['payment_full_name']);
        unset($_SESSION['payment_email']);
        unset($_SESSION['payment_house_name']);
        unset($_SESSION['payment_street_name']);
        unset($_SESSION['payment_city']);
        unset($_SESSION['payment_postcode']);
        unset($_SESSION['payment_mobile']);

        // unset basket cookie (set for 1 second)
        setcookie(BASKET_COOKIE,' ',1);

        $status = "succeeded";

            //order inserted successfully ?
            if($status == 'succeeded')
            {
                $response = array(
                    'status' => 1,
                    'msg' => 'Your payment was successful.',
                    'txnData' => $chargeJson
                );
            }
            else
            {
                $response = array(
                    'status' => 0,
                    'msg' => 'Transaction has been failed.'
                );
            }

    }else
    {
        $response = array(
            'status' => 0,
            'msg' => 'Transaction has been failed 2.'
        );
    }
}
else
{
    $response = array(
        'status' => 0,
        'msg' => 'Form submission error...'
    );
}


// Return response
echo json_encode($response);


