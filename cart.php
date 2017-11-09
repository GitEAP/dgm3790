<?php
$mem_id = $_COOKIE['id'];

require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query1 = "SELECT * FROM cart";
$result1 = mysqli_query($dbconnect, $query1) or die('cart query failed');

$query2 = "SELECT * FROM products";
$result2 = mysqli_query($dbconnect, $query2) or die('product query failed');

include 'head.php';
 ?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
  	<h1>Your Cart</h1>
     <a href="products.php" class="padding-sm"><button class="primary_button">Shop Some More</button></a>
	</article>
  </div>
</div>
<form action="checkout.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
  
  <?php

while($row1 = mysqli_fetch_array($result1)){
  if($row1['mem_id'] == $mem_id){
    $result2 = mysqli_query($dbconnect, $query2) or die('product query failed');
    while($row2 = mysqli_fetch_array($result2)){
      if($row2['id'] == $row1['product_id']){
          echo '<article class="clearfix panel panel-default">';
          echo '<div class="col-xs-4"><img src="'. $row2['picture'] .'" alt="Products" /> </div>';
          echo  '<div class="col-xs-8"><h3>' . $row2['title'] . '</h3>';
          echo '<p>Price: $' . $row2['price'] . '</p>';
          echo  '<p>'. $row2['shortdescription'] . '</p>';
          echo '<div class="form-group"><span>Quantity<input type="number" name="amount'.$row2['id'].'" value="1" class="form-control" required></span></div><br /><br />';
          echo '<a class="delete_button" href=deleteCartItem.php?id='.$row1['id'].'>Remove</a>';
          echo '<input type="hidden" name="title'.$row2['id'].'" value="'.$row2['title'].'">';
          echo '<input type="hidden" name="price'.$row2['id'].'" value="'.$row2['price'].'">';
          echo '<input type="hidden" name="shipping'.$row2['id'].'" value="'.$row2['shipping'].'">';
          echo '<input type="hidden" name="tax'.$row2['id'].'" value="'.$row2['tax'].'">';
          echo '<input type="hidden" name="product'.$row2['id'].'" value="'.$row2['id'].'">';
          echo  '</article>';
      };
    };
  };
};
  ?>
  </div>
</div>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
    <br /><br />
<?php 

$query3 = "SELECT * FROM cart";
$result3 = mysqli_query($dbconnect, $query3) or die('cart query failed');
while($row3 = mysqli_fetch_array($result3)){
  if($row3['mem_id'] == $mem_id){
    echo '<input type="submit"  class="primary_button" name="submit" value="Proceed to Checkout" id="submit"/>';
    break;
  };
};
?>

      <br /><br /><br /><br />
  </div>
</div>
</form>

<?php include 'footer.php'; ?>
