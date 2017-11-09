<?php
require_once('variable.php');
require_once('auth.php');
$id = $_GET['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($dbconnect, $query) or die ('run display query failed');
$found = mysqli_fetch_array($result);

include 'head.php'; 

?>
<br /><br />

<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    <?php
      echo '<article class="clearfix panel panel-default">';
      echo '<div class="col-xs-4"><img src="'. $found['picture'] .'" alt="Products" /> </div>';
      echo '<div class="col-xs-8"><h3>' . $found['title'] . '</h3>';
      echo '<p>Price: $' . $found['price'] . ' | Shipping: $' . $found['shipping'] . ' | Tax: $' . $found['tax'] .'</p>';
      echo '<p>' . $found['longdescription'] . '</p>';
      echo '<br /><a href="update.php?id='.$found['id'].'"><button class="primary_button">Update Product</button></a></div>';
      echo '</article>';
      
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>
