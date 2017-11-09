<?php
$mem_id = $_COOKIE['id'];
require_once('config.php');

$token  = $_POST['stripeToken'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$subTotal = $_POST['subTotal'];
$stripeTotal = $subTotal * 100;
$products = $_POST['productArray'];

$customer = \Stripe\Customer::create(array(
    'email' => $email,
    'source'  => $token
));

$charge = \Stripe\Charge::create(array(
    'customer' => $customer->id,
    'amount'   => $stripeTotal,
    'currency' => 'usd'
));

$creditcard = $charge->id;

require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
$query = "INSERT INTO send_information (subtotal, name, email, phone, address, creditcard, products, date) VALUES ('$subTotal', '$name', '$email', '$phone', '$address', '$creditcard', '$products', NOW() )";
$result = mysqli_query($dbconnect, $query) or die('add to db query failed');

$subject = "Your Order has been sent.";
$message = "Thank You for your business ". $name . ", Here are the details of your order: You ordered " . $products . "(s). The subtotal of your order: $". $subTotal . ". Your items will be sent to: ". $address . ". Thank you for your business and hope you have a fantHATic day.";
$from = "kylejohnson2612@gmail.com";
$to = $email;

mail($to, $subject, $message, 'From:' . $from);

$query2 = "DELETE FROM cart WHERE mem_id=$mem_id";

$result2 = mysqli_query($dbconnect, $query2) or die('delete query failed');

mysqli_close($dbconnect);



include 'head.php';  

?>
<br /><br />
<div class="row">
<div class="col-xs-1"></div>
  <div class="col-xs-10 text-center">
    <article class="clearfix panel panel-default">
      <?php
      echo '<h1>Thank You</h1><p>Your order will arrive within 3-5 business days. </p>';
      ?>
      <br /><br />
    </article>
  </div>
</div>
<br /><br />

<?php include 'footer.php'; ?>
