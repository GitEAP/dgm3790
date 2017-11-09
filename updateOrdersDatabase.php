<?php
require_once('protect.php');
require_once('variable.php');

$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$creditcard = $_POST['creditcard'];
$products = $_POST['products'];
$subtotal = $_POST['subtotal'];
$date = $_POST['date'];
$id = $_POST['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM send_information WHERE order_id='$id'";

$result = mysqli_query($dbconnect, $query) or die('update query failed');

$found = mysqli_fetch_array($result);

include 'head.php';

echo  '<br /><br /><div class="row"><div class="col-xs-1"></div><div class="col-xs-10"><article class="clearfix panel panel-default">';

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "UPDATE send_information SET email='$email', name='$name', subtotal='$subtotal', products='$products', date='$date', phone='$phone', address='$address',  creditcard='$creditcard' WHERE order_id=$id";

$result = mysqli_query($dbconnect, $query) or die('update db query failed');

mysqli_close($dbconnect);

echo '<h1 class="text-center">The order has been Updated</h1>';
header( "refresh:3;url=purchaseHistory.php" );
echo  '</article></div></div>';

include 'footer.php'; 

?>
