<?php
require_once('protect.php');
require_once('variable.php');

$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$creditcard = $_POST['creditcard'];
$id = $_POST['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM member WHERE id='$id'";

$result = mysqli_query($dbconnect, $query) or die('update query failed');

$found = mysqli_fetch_array($result);

include 'head.php';

echo  '<br /><br /><div class="row"><div class="col-xs-1"></div><div class="col-xs-10"><article class="clearfix panel panel-default">';

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "UPDATE member SET email='$email', name='$name', phone='$phone', address='$address',  creditcard='$creditcard' WHERE id=$id";

$result = mysqli_query($dbconnect, $query) or die('update db query failed');

mysqli_close($dbconnect);

echo '<h1 class="text-center">Your Account has been Updated</h1>';
header( "refresh:3;url=index.php" );
echo  '</article></div></div>';

include 'footer.php'; 

?>
