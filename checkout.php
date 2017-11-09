<?php
require_once('variable.php');
require_once('config.php');

$mem_id = $_COOKIE['id'];
$productArray = array();
$titleArray = array();
$priceArray = array();
$shippingArray = array();
$taxArray = array();
$amountArray = array();
$timesPrice = array();

foreach($_POST as $k => $v) {
  if(strpos($k, 'title') === 0) {
      array_push($titleArray, $v);
  }
}
foreach($_POST as $k => $v) {
  if(strpos($k, 'price') === 0) {
      array_push($priceArray, $v);
  }
}
foreach($_POST as $k => $v) {
  if(strpos($k, 'shipping') === 0) {
      array_push($shippingArray, $v);
  }
}
foreach($_POST as $k => $v) {
  if(strpos($k, 'tax') === 0) {
      array_push($taxArray, $v);
  }
}
foreach($_POST as $k => $v) {
  if(strpos($k, 'amount') === 0) {
      array_push($amountArray, $v);
  }
}

for($i = 0; $i < count($titleArray); ++$i) {
  $inputtitle = $titleArray[$i];
  $inputamount = $amountArray[$i];
  array_push($productArray, $inputamount);
  array_push($productArray, $inputtitle);
}

for($i = 0; $i < count($priceArray); ++$i) {
  $inputprice = $priceArray[$i];
  $inputamount = $amountArray[$i];
  $newPrice = $inputamount * $inputprice;
  array_push($timesPrice, $newPrice);

}

$stringProducts = implode(",", $productArray);

$priceTotal = array_sum($timesPrice);
$shippingTotal = array_sum($shippingArray);
$taxTotal = array_sum($taxArray);

$subTotal =  $priceTotal + $shippingTotal + $taxTotal;
$stripeSubTotal = $subTotal * 100;

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM member WHERE id=$mem_id";
$resultMember = mysqli_query($dbconnect, $query) or die('Member query failed');
$foundMember = mysqli_fetch_array($resultMember);

$query2 = "SELECT * FROM cart";
$resultCart = mysqli_query($dbconnect, $query2) or die('Cart query failed');
$foundCart = mysqli_fetch_array($resultCart);

$query3 = "SELECT * FROM products";
$resultProduct = mysqli_query($dbconnect, $query3) or die('Product query failed');
$foundProduct = mysqli_fetch_array($resultProduct);


include 'head.php';
 ?>

<form action="saveToDB.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">
<br /><br />
<div class="row">
<div class="col-xs-1"></div>
<div class="col-xs-6">
  <article class="clearfix panel panel-default">
    
    <?php
      if($mem_id == 0){
        echo '<h1 class="text-center">Your Information</h1><div class="form-group">
        <span>Name <input type="text" name="name" value="" required class="form-control"></span>
        </div>
        <div class="form-group">
        <span>Email <input type="text" name="email" value="" required class="form-control"></span>
        </div>

        <div class="form-group">
        <span>Phone <input type="tel" name="phone" value="" required class="form-control"></span>
        </div>

        <div class="form-group">
        <span>Address <input type="text" name="address" value="" required class="form-control"></span>
        </div>';
      }else{
        echo '<h1 class="text-center">Your Information</h1><div class="form-group">
        <span>Name <input type="text" name="name" value="'.$foundMember['name'] .'" required class="form-control"></span>
        </div>
        <div class="form-group">
        <span>Email <input type="text" name="email" value="'.$foundMember['email'] .'" required class="form-control"></span>
        </div>

        <div class="form-group">
        <span>Phone <input type="tel" name="phone" value="'.$foundMember['phone'] .'" required class="form-control"></span>
        </div>

        <div class="form-group">
        <span>Address <input type="text" name="address" value="'.$foundMember['address'] .'" required class="form-control"></span>
        </div>';
      }
      
      
    ?>

    

    <?php
      echo '<input type="hidden" name="subTotal" value="'.$subTotal .'">
      <input type="hidden" name="productArray" value="'.$stringProducts .'">';

      echo'<h1 class="text-center">Subtotal: $' . $subTotal . '</h1>';

      ?>
      <br />

      <div class="text-center">
        <script
          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-email= "<?php echo $foundMember['email']; ?>"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-amount="<?php echo $stripeSubTotal ?>"
          data-name="Team Hats"
          data-description="Selling hats the cool way."
          data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
          data-locale="auto"
          data-allow-remember-me="false">
        </script>
      </div>
  
      <br /><br />
  
  </article>
  </div>
  <div class="col-xs-4">
    <article class="clearfix panel panel-default">
      <h1 class="text-center">Billing Break Down</h1>
      <div class="row">
      
      <div class="col-xs-7">
      <?php 
      for($i = 0; $i < count($titleArray); ++$i) {
        echo $titleArray[$i]. ': ';
        echo '$'.$priceArray[$i];
        echo ' x'.$amountArray[$i]. '<br />';
      }

      ?>
      </div>
      </div>
      <br /><br />
      <?php
      echo "Total Item Price: $" . $priceTotal . "<br />";
      echo "Total Shipping Price: $" . $shippingTotal . "<br />";
      echo "Total Tax Price: $" . $taxTotal . "<br /><br />";
      echo "Subtotal: $" . $subTotal  . "<br />";
      
      ?>
    </article>
  </div>
  <div class="col-xs-1"></div>
  </div>
</div>
</form>
  
  <?php include 'footer.php'; ?>
