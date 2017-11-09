<?php
$id = $_GET['id'];
require_once('auth.php');
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "DELETE FROM send_information WHERE order_id=$id";

$result = mysqli_query($dbconnect, $query) or die('delete query failed');

header('Location: purchaseHistory.php');

 ?>
