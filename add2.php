<?php
require_once('variable.php');

include 'head.php';

$title = $_POST[title];
$shortdescription = $_POST[shortdescription];
$longdescription = $_POST[longdescription];
$price = $_POST[price];
$shipping = $price * .199;
$tax = $price * 0.065;
$picture = $_POST[picture];
$ext =  pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
$filename = $title . '.' . $ext;
$filepath = 'img/';
$picturename = $filepath . $filename;
$validImage = true;

echo  '<br /><br /><div class="row"><div class="col-xs-1"></div><div class="col-xs-10"><article class="clearfix panel panel-default">';

if ($_FILES['picture']['size'] == 0){
      echo  '<h1 class="text-center">No files submitted</h1> ';
      $validImage = false;
};

if($_FILES['picture']['size'] > 1000000){
  echo '<h1 class="text-center">File too big. Must be less than 1MB</h1> ';
  $validImage = false;
};

if ($_FILES['picture']['type'] == 'image/gif' || $_FILES['picture']['type'] == 'image/jpeg' || $_FILES['picture']['type'] == 'image/pjpeg' || $_FILES['picture']['type'] == 'image/png'){
}else{
  echo '<h2 class="text-center">Wrong fileformat. Must be gif, jpeg or png.</h2>';
  $validImage = false;
};

if ($validImage == true){
    $tmp_name = $_FILES['picture']['tmp_name'];
    move_uploaded_file($tmp_name, $picturename);
    @unlink($_FILES['picture']['tmp_name']);

    $dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

    $query = "INSERT INTO products (title, shortdescription, longdescription, price, picture, shipping, tax)" .
    "VALUES ('$title', '$shortdescription', '$longdescription', '$price', '$picturename', '$shipping', '$tax')";

    $result = mysqli_query($dbconnect, $query) or die('run query failed');

    mysqli_close($dbconnect);

    echo '<h1 class="text-center">'. $title .' has been added</h1>';

}else{
    echo '<br /><div class="text-center"><a href="add.php"> Please upload Image again</a></div><br />';
};

echo  '</article></div></div>';

include 'footer.php'; 

?>
