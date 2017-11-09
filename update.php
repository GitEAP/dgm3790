<?php
require_once('auth.php');
require_once('variable.php');

$id = $_GET['id'];

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM products WHERE id='$id'";

$result = mysqli_query($dbconnect, $query) or die('update query failed');

$found = mysqli_fetch_array($result);

include 'head.php'; 

?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
    <h1>Update <?php echo $found['title'] ?></h1>
    <br /><br />
	</article>
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    <article class="clearfix panel panel-default">

      <form action="updateDatabase.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">
      <div class="form-group">
          <span>Title <input type="text" name="title" value="<?php echo $found['title'] ?>" class="form-control "></span>
        </div>
        <div class="form-group">
          <span>Short Description <input type="textarea" name="shortdescription" value="<?php echo $found['shortdescription'] ?>" class="form-control "></span>
        </div>

        <div class="form-group">
          <span>Long Description <input type="textarea" name="longdescription" value="<?php echo $found['longdescription'] ?>" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Price $<input type="number" name="price" value="<?php echo $found['price'] ?>" placeholder="30.00" step=".01" class="form-control"></span>
        </div>

        <div class="form-group">
          <span>Photo<input type="file" name="picture" value="<?php echo $found['picture'] ?>" placeholder="<?php echo $found['picture'] ?>" class="form-control"></span>
        </div>

        <input type="hidden" name="id" value=" <?php echo $found['id'] ?> ">

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
