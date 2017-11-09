<?php
require_once('protect.php');
require_once('variable.php');

$id = $_GET['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM send_information WHERE order_id='$id'";

$result = mysqli_query($dbconnect, $query) or die('update query failed');

$found = mysqli_fetch_array($result);

include 'head.php'; 

?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
  	<h1>Update Purchase</h1>
	</article>
  </div>
</div>

<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    <article class="clearfix panel panel-default">

      <form action="updateOrdersDatabase.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">
      <div class="form-group">
          <span>Name <input type="text" name="name" value="<?php echo $found['name'] ?>" class="form-control"></span>
        </div>
        <div class="form-group">
          <span>Email <input type="text" name="email" value="<?php echo $found['email'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Phone <input type="tel" name="phone" value="<?php echo $found['phone'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Address <input type="text" name="address" value="<?php echo $found['address'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Credit Card <input type="number" name="creditcard" value="<?php echo $found['creditcard'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Subtotal <input type="number" step=".01" name="subtotal" value="<?php echo $found['subtotal'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Products <input type="textarea" name="products" value="<?php echo $found['products'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Date <input type="date" name="date" value="<?php echo $found['date'] ?>" class="form-control"></span>
        </div>

        <input type="hidden" name="id" value=" <?php echo $found['order_id'] ?> ">

        <br /><br />
        <div class="text-center">
          <input type="submit"  class="primary_button" name="submit" value="Update" id="submit"/>
        </div>
        <br /><br />

    </form>
    </article>
  </div>
</div>
  
<?php include 'footer.php'; ?>
