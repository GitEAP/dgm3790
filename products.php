<?php
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM products";

$result = mysqli_query($dbconnect, $query) or die('run query failed');

include 'head.php'; 

?>

<div class="row">
  <div class="col-xs-12 text-center">
    <h1>All Products</h1>
    <br /><br />
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    
    <form action="pub_detail.php" method="GET">
      <?php
        while($row = mysqli_fetch_array($result)){
          echo '<div class="card col-xs-3">'; 
          echo '<img class="card-img-top" src="'. $row['picture'] .'" alt="Product">';
          echo '<div class="card-body">';   
          echo '<h3 class="card-title">' . $row['title'] . '</h3>';  
          echo '<p>Price: $' . $row['price'] . '</p>';
          echo '<p class="card-text">'. $row['shortdescription'] . '</p>';
          echo '<a href="pub_detail.php?id='.$row['id'].'">View Details</a>';
          echo '</div>';
          echo '</div>';
        }
?>

    </form>
    <br /><br />
    <br /><br />
  </div>
</div>

<?php include 'footer.php'; ?>
