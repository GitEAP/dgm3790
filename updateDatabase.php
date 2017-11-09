<?php
require_once('auth.php');
require_once('variable.php');

$title = $_POST[title];
$shortdescription = $_POST[shortdescription];
$longdescription = $_POST[longdescription];
$price = $_POST[price];
$shipping = $price * .199;
$tax = $price * 0.065;
$picture = $_POST['picture'];
$id = $_POST['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM products WHERE id='$id'";

$result = mysqli_query($dbconnect, $query) or die('update query failed');

$found = mysqli_fetch_array($result);

include 'head.php';

$ext =  pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
$filename = $title . '.' . $ext;
$filepath = 'img/';
$picturename = $filepath . $filename;
$validImage = true;

echo  '<br /><br /><div class="row"><div class="col-xs-1"></div><div class="col-xs-10"><article class="clearfix panel panel-default">';

if ($_FILES['picture']['size'] == 0){
      $_FILES['picture'] == $found['picture'];
      $picturename = $found['picture'];
      $validImage = true;
      
};

if ($validImage == true){

    $tmp_name = $_FILES['picture']['tmp_name'];
    move_uploaded_file($tmp_name, $picturename);
    @unlink($_FILES['picture']['tmp_name']);

    $dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

    $query = "UPDATE products SET title='$title', shortdescription='$shortdescription', longdescription='$longdescription', price='$price',  picture='$picturename', shipping='$shipping', tax='$tax' WHERE id=$id";

    $result = mysqli_query($dbconnect, $query) or die('update db query failed');

    mysqli_close($dbconnect);

    ?>

    <script type="text/javascript">
    setTimeout(function () {
        window.location.href= 'manage.php'; // the redirect goes here

        },5000);
    </script>

   <?php echo '<h1 class="text-center">'. $title . ' has been Updated</h1>';

    

}else{
    echo '<br /><div class="text-center"><a href="add.php"> Please upload Image again</a></div><br />';
};

echo  '</article></div></div>';

include 'footer.php'; 

?>
