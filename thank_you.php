<?php 
require_once "includes/head.php"; 
require_once "includes/navigation.php";
require_once "functions.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    // select customer order from db via there session id token and print there reciept;
    $order_number = $_COOKIE[ORDER_COOKIE];

    $query = "SELECT * FROM orders WHERE id = $order_number " ;

    $result = mysqli_query($connection,$query);

    if(!$result){die("result failed".mysqli_error($connection));}
    
    $row = mysqli_fetch_assoc($result);
    
    $items_purchased_as_string = $row['ordered_items'];
    $address_as_string = $row['customer_details'];
    $total_price = $row['total_paid'];
    $order_date = $row['order_date'];
    $items_purchased_array = json_decode($items_purchased_as_string,true); 
?>
 
<div id="jumper_contain">
 
    <div class="container">
   
        <div> 
            <h3 class="text-success"> Thank you! </h3> 
                You will recieve a email shortly confirming you purchase. <br>
                Please check you spam or junk mail if it is not in your inbox. <br> Additionally you can print this page as a reciept.
    
        </div> <br>
   
        <div class="row">
            <div class="col-md-12">
                
                <div class="row">
                    
                    <div class="col-md-6"> 
                        <div>   <h6 class="text-center"> Order details   </h6> </div> <br>
                            <!-- make table to display order like in basket -->
                            <table class="table table-inverse table-hover table-responsive">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Size</th>
                                        <th>Pic</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                    
                                <tbody>
                                    <?php  
                                        $i = 1;
                                        $total_quantity_count = 0;
                                        $grand_total = 0;
                                        
                                        foreach($items_purchased_array as $item)
                                        {
                                            $product_size = $item['size'];
                                            $product_quantity = $item['quantity'];
                                            $product_id = $item['product_id'];     ?>
                                            
                                        <tr>
                                            <td> <b>  <?= $i ?>.</b> </td>
                                            <td> <?= $item['title']?> </td>
                                            <td> <?= $item_size ?></td>
                                            <td> <img width="60px" height="60px" src="<?= $item['image'] ?>"> </td>
                                            <td> <?= $item['quantity'] ?></td>
                                            <td> £<?= number_format($item['price'],2) ?></td>
                                            <td> <?php $total = $item['price']  * $item['quantity'];
                                                    echo "£".number_format($total,2);
                                                ?>
                                            </td> 
                                            
                                                <?php
                                                    $i++; 
                                                    $total_quantity_count = $total_quantity_count + $item['quantity'];
                                                    $grand_total = $grand_total + $total;
                                                    $tax = number_format($grand_total * TAXRATE,2);
                                                
                                                    // update stock query
                                                    if($product_size == "xl" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_xl = size_xl - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "lg" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_lg = size_lg - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "md" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_md = size_md - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "sm" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_sm = size_sm - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "adult" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_adult = size_adult - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "child" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_child = size_child - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    }
                                                    if($product_size == "onesize" )
                                                    { 
                                                        $quantity_query = " UPDATE products SET size_onesize = size_onesize - $product_quantity WHERE id = $product_id " ;
                                                        $quantity_result = mysqli_query($connection,$quantity_query);
                                                        if(!$quantity_result)
                                                        {
                                                            die('quantity result failed'.mysqli_error($connection));
                                                        } 
                                                    } 
                                                ?>
                                            
                                        </tr> <?php 
                                        }  
                                        ?>
                                        
                                </tbody>
                            </table>
       
                            <div id="order_summary"> 
                                <div id=""> <b> Date of Order: </b>  <?= date("Y-m-d",time() + $order_date) ?>  </div>  
                                <div id=""> <b> Total items purchased: </b>  <?= $total_quantity_count?>  </div>  
                                <div id=""> <b>  Basket total:</b> £<?=  number_format($grand_total,2) ?>  </div> 
                                <div id="">  <b> Tax and VAT: </b>  £<?= $tax ?>  </div> 
                                <div id=""> <b> Grand total: </b>  £<?php $real_grand_total = $grand_total + $tax; echo number_format($real_grand_total,2);   ?>  </div> <br>  
                                <div id=""> <b> Order number: </b>  <?= $order_number?>  </div>  
                            </div>
                    </div>
  
                    <div class="col-md-1"> </div> 
 
                    <div class="col-md-5"> 
                        <h6 class="text-center"> Delivery Address</h6> <br>    
                            <?php
                                $address_as_array = json_decode($address_as_string,true);
                                $full_name = $address_as_array['full_name'] ;
                                $house_name = $address_as_array['house_name'];
                                $street_name = $address_as_array['street_name'];
                                $city = $address_as_array['city']; 
                                $postcode = $address_as_array['postcode'];
                                $email_address = $address_as_array['email'];
                                $mobile = $address_as_array['mobile'];
                            ?>

                        <div id="order_summary"> 
                            <div> <span id="name_delivery">  <?= $full_name ?>  </span> </div>  
                            <div> 
                                <span id="address_delivery"> 
                                    <?= $house_name. " ". $street_name ?>  <br>
                                    <?= $city ?> <br> <?= $postcode ?>  
                                </span> <br> 
                            </div>  
                            <div> <span id="email_delivery"> <?= $email_address ?> </span>  </div>  
                            <div> <span  id="mobile_delivery">  <?= $mobile ?>  </span> </div>  
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


<?php
 
// CONFIGURE PHP MAILER... Confirmation Email
$mail = new PHPMailer();    // Passing `true` enables exceptions
try 
{
    //Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.mailtrap.io' ;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = getenv(mailer_username);                 // SMTP username
    $mail->Password = getenv(mailer_password);                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525 ;                                    // TCP port to connect to

    $mail->CharSet = 'UTF-8' ; 

    //Recipients
    $mail->setFrom('thatsme@clothing.com','Matthews Menswear');  // Name is optional
    $mail->addAddress($address_as_array['email']); // Add a recipient
   // $mail->addAddress('ellen@example.com');              
   // $mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
   
   //Images to embed
    $mail->addEmbeddedImage('/Applications/MAMP/htdocs/e-commerce/img/small_logos/wow.png','logo');   
    // $mail->addEmbeddedImage('//Applications/MAMP/htdocs/e-commerce/img/hats/front_panel/__bluelogo_.jpeg','tel1'); 
  
    $the_message =
    '<h1 style="color:green; text-decoration:underline; text-align:center;"> Order confirmation </h1>'. 
    
    '<h2 style="text-align:center;"> Items Purchased </h2>'. 
            '<table style="text-align:center">
                <thead class="thead-inverse">
                    <tr>
                        <th width="25px">#</th>
                        <th width="130px">Item</th>
                        <th width="50px">Size</th>
                        <th width=50px">Pic</th>
                        <th width="50px%">Quantity</th>
                        <th width="50px">Price</th>
                        <th width="50px">Total</th>
                    </tr>
                </thead>
                <tbody>'.
                    '<span style="display:none">'. $i = 1;' .</span>'.
                    
                    $total_quantity_count = 0;
                    $grand_total = 0;
                    
                    foreach($items_purchased_array as $item)
                    {
                        if (!$mail->addEmbeddedImage(getcwd().'/'.trim($item['image']),trim('product_pic'.$i)))
                        {
                            echo 'Failed to attach '.getcwd().'/'.$item['image'],('product_pic'.$i);
                    
                        }
                        
                        $the_message.=
                        '<tr>'.
                            '<td> <b>'. $i .'.</b> </td>'.
                            '<td>'.$item['title']. '</td>'.
                            '<td>'.$item['size'].  '</td>'.
                            '<td> <img src="cid:product_pic'.$i.'" style="width:60px; height:60px; "> </td>'.
                            '<td>'. $item['quantity'].'</td>'.
                            '<td> £'. number_format($item['price'],2).'</td>'.
                            '<td> £'.$total = number_format($item['price'],2) * $item['quantity'];'</td>'.
                    
                            $i++;
            
                            $total_quantity_count = $total_quantity_count + $item['quantity'];
                            $grand_total = $grand_total + $total;
                            $tax = number_format($grand_total * TAXRATE,2);
                            $the_message.=
                        '</tr>' ; 
                    }  
                    $the_message.=  
                    '
                
                </tbody>
            </table>
            
            <div> 
                <div> <b> Date of Order: </b> ' . date("Y-m-d",time() + $order_date) .'   </div> 
                <div> <b> Total items purchased: </b>'. $total_quantity_count. '</div>'.  
                '<div> <b>  Basket total:</b> £'. number_format($grand_total,2). '</div>'. 
                '<div> <b> Tax and VAT: </b>  £'. $tax.  '</div>'. 
                '<div> <b> Grand total: </b>  £'.$real_grand_total = $grand_total + $tax; number_format($real_grand_total,2).' </div> <br> 
            
            </div>'; 
            
            $the_message.=
                '<h3 style="text-decoration:underline; margin-bottom:-2px"> Delivery Details </h3>
                    <div> 
                        <div> <span>'. $full_name .'</span> </div>  
                        <div> <span>'. $house_name. " ". $street_name.'<br>'.
                            $city.'<br>'. $postcode .' </span><br>'. 
                        '</div>'.  
                        '<div>  <span>'.  $email_address.'</span>  </div>'.  
                        '<div> <span>'. $mobile.' </span> </div>'.  
                        '<div> <b> Order reference number: </b> '. $order_number.  '</div>'. 
                    '</div>';


            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Order confirmation';
            $mail->Body    = 
            '<h1 style="text-align:center;"> <img width="150px" height="150px" src="cid:logo"> </h1> '.
            $the_message;
        

            $mail->send();
    
} 
catch (Exception $e)
{
    $msg = 'Message could not be sent. Mailer Error:'.$mail->ErrorInfo;
    $msg_class = "text text-danger";
}

?>
 
 <?php include "includes/footer.php"; ?>