<?php
require_once('auth.php');
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM products";

$result = mysqli_query($dbconnect, $query) or die('run query failed');

include 'head.php';

?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
  	<h1>Manage Products</h1>
		<p>View Details, Update the product, and delete it</p>
    <br /><br />
      <a href="add.php" class="padding-sm"><button class="primary_button">Add a new Product</button></a>
      <a href="purchaseHistory.php"><button class="primary_button">Purchase History</button></a>
      <br /><br />
	</article>
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10 text-center">
      <form action="pub_detail.php" method="get">
      <?php
        while($row = mysqli_fetch_array($result)){
          echo '<article class="margin-sm padding-sm clearfix panel panel-default">';
          echo '<figure id="manageImg"><img src="'. $row['picture'] .'" alt="Product" /> </figure>';
          echo  '<h3>' . $row['title'] . '</h3>';
          echo '<p>Price: $' . $row['price'] . ' | Shipping: $' . $row['shipping'] . ' | Tax: $' . $row['tax'] .'</p>';
          echo  '<p>'. $row['shortdescription'] . '</p>';
          echo '<a href="admin_detail.php?id='.$row['id'].'"> Detail view </a> | <a href="update.php?id='.$row['id'].'"> Update </a> | <a href=delete.php?id='.$row['id'].'> Delete</a>';
          echo  '</article>';
      }
      ?>
      </form>
      <br /><br />
      <br /><br />
  </div>
</div>

<?php include 'footer.php'; ?>
