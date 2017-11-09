<?php
 $queryAddition= '';
require_once('auth.php');
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM send_information";
$result = mysqli_query($dbconnect, $query) or die('display query failed');

include 'head.php';
 ?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
  	<h1>Purchase History</h1>
      <br /><br />
	</article>
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
  <?php

  while($row = mysqli_fetch_array($result)){
    echo '<div class="col-xs-4"><article style="height: 600px;"class="clearfix panel panel-default">';
    echo '<div class="col-xs-12"><h3>Order #' . $row['order_id'] . '</h3>';
    echo '<p>Name: ' . $row['name'] . '<p>';
    echo '<p>Email: ' . $row['email'] . '<p>';
    echo '<p>Phone: ' . $row['phone'] . '<p>';
    echo '<p>Address: ' . $row['address'] . '<p>';
    echo '<p>Stripe Payment ID: ' . $row['creditcard'] . '<p>';
    echo '<p>Products Ordered: ' . $row['products'] . '<p>';
    echo '<p>Subtotal: $' . $row['subtotal'] . '<p>';
    echo '<p>Date Ordered: ' . $row['date'] . '<p>';
    echo '<a href="updateOrders.php?id='.$row['order_id'].'"> Update </a> | <a href=deleteOrders.php?id='.$row['order_id'].'> Delete</a> | <a href=emailClient.php?id='.$row['email'].'> Email</a>';
    echo  '</div></article></div>';

  };
  ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 text-center">
      <br /><br />
      <a href="manage.php" class="padding-sm"><button class="btn btn-success btn-lg">Manage Store</button></a>
      <br /><br /><br /><br />
    </div>
</div>

<?php include 'footer.php'; ?>
