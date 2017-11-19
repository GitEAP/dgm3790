<?php
require_once('variable.php');

$product_id = $_GET['id'];

if(isset($_COOKIE["id"])){
  $mem_id = $_COOKIE["id"];
}else{
  setcookie('id', 0, time() + (60*60*24*30));
  $mem_id = $_COOKIE["id"];
};

if(isset($_POST['submit'])){
    $product_id = $_POST[newProductID];

    $testing = false;

    $dbconnect3 = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
    
    $query3 = "SELECT * FROM cart";
    
    $result3 = mysqli_query($dbconnect3, $query3) or die ('display query run failed');

    while($row = mysqli_fetch_array($result3)){
      $rowId = $row["mem_id"];
      if($row['product_id'] == $product_id && $row['mem_id'] == $mem_id){
        $testing = true;
      };
    };

    if($testing == false){
      $dbconnect2 = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
      
      $query2 = " INSERT INTO cart (product_id, mem_id) VALUES ('$product_id', '$mem_id')";
    
      $result2 = mysqli_query($dbconnect2, $query2) or die('run query failed');
      
      mysqli_close($dbconnect2);
      
      header('Location: cart.php');
    }else{
      header('Location: cart.php');
  
    };
    
  }else{
    $dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
    
    // $query = "SELECT * FROM products WHERE product_id=$product_id";
    
    $query = "SELECT * FROM products INNER JOIN categories ON (products.category_id = categories.category_id) WHERE product_id=$product_id";

    $result = mysqli_query($dbconnect, $query) or die ('display query run failed');
    
    $found = mysqli_fetch_array($result);
    $currentCategory = $found['type'];
  };

include 'head.php';

?>

<div class="row">
  <div class="col-xs-12 text-center">
     <br />
    <br />
  </div>
</div>

<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    <?php
      echo '<article class="clearfix panel panel-default">';
      echo '<form action="pub_detail.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">';
      echo '<div class="col-xs-12 col-sm-4"><img src="'. $found['picture'] .'" alt="Products" /> </div>';
      echo '<div class="col-xs-12 col-sm-8"><h3>' . $found['title'] . '</h3>';
      echo '<div class="priceTag">$' . $found['price'] .'</div><button type="submit" class="addCartBtn" name="submit">Add to Cart</button>';
      echo '<p>' . $found['longdescription'] . '</p>';
      echo '<input type="hidden" value="'. $product_id . '" name="newProductID">';
      echo '</form></article>';
    ?>

  </div>
</div>

<br><br>


<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-12">
<?php
//$product_id is the current product
//$currentCategory is the current category

//connect to db
$dbconnectSimilar = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('similar connection failed');
//get all products that have the same category as the current product.
$querySimilar = "SELECT * FROM products INNER JOIN categories ON (products.category_id = categories.category_id) WHERE type='$currentCategory'";
$resultSimilar = mysqli_query($dbconnectSimilar, $querySimilar) or die ('similar query 1 run failed');

$totalLimit = 5;
if(mysqli_num_rows($resultSimilar) < $totalLimit) {
  $totalProductsAfterLimit = mysqli_num_rows($resultSimilar);
}
else {
//Random number to set as limit
  $totalProducts = mysqli_num_rows($resultSimilar);
  $ranNum = mt_rand(1, ($totalProducts - $totalLimit));
  $setLimit = " LIMIT $ranNum, $totalLimit";
  $querySimilar .= $setLimit;

  $resultSimilar = mysqli_query($dbconnectSimilar, $querySimilar) or die ('similar query 2 run failed');
  $totalProductsAfterLimit = mysqli_num_rows($resultSimilar);
}
?>
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2>Similar Items:</h2>

    <div id="similarItemCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
      <?php
      //display slide dots (indicators)
        for ($i = 0; $i < $totalProductsAfterLimit; $i++) {
          if ($i == 0) {
            echo '<li data-target="#similarItemCarousel" data-slide-to="'.$i.'" class="active"></li>';
          } else {
              echo '<li data-target="#similarItemCarousel" data-slide-to="'.$i.'"></li>';
          }
        } 
      ?>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
<?php
  //display the products found
  //get the id of those products
  //send the id with GET through anchor tag
  $i = 1;
  while($rowSimilar = mysqli_fetch_array($resultSimilar)) {

    if($i == 1) {
       echo '<div class="item active">';
          echo '<a href="pub_detail.php?id='. $rowSimilar['product_id'] .'"><img src="'.$rowSimilar['picture'].'" alt="'.$rowSimilar['title'].'" class="carouselImg"></a>';
          echo '<div class="carousel-caption captionShowHide">';
            echo '<h3>'.$rowSimilar['title'].'</h3>';
           echo ' <p>'.$rowSimilar['price'].'</p>';
         echo ' </div>';
        echo '</div>';
      $i++;
    } else {
      echo '<div class="item">';
          echo '<a href="pub_detail.php?id='. $rowSimilar['product_id'] .'"><img src="'.$rowSimilar['picture'].'" alt="'.$rowSimilar['title'].'" class="carouselImg"></a>';
          echo '<div class="carousel-caption captionShowHide">';
            echo '<h3>'.$rowSimilar['title'].'</h3>';
           echo ' <p>'.$rowSimilar['price'].'</p>';
         echo ' </div>';
        echo '</div>';
    }//end of if else
  }//end of while loop
?>
      </div><!-- end of carousel inner -->
    </div><!-- end of carousel -->
  </div><!-- end of div container -->






  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2>Recently Purchased:</h2>

    <div id="recentlyPurchasedCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#recentlyPurchasedCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#recentlyPurchasedCarousel" data-slide-to="1"></li>
        <li data-target="#recentlyPurchasedCarousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">

        <div class="item active">
          <img src="img/hatperson1.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

        <div class="item">
          <img src="img/hatperson2.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

        <div class="item">
          <img src="img/hatperson3.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

      </div><!-- end of inner -->

      <!-- Controls -->
    <!--   <a class="left carousel-control" href="#recentlyPurchasedCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#recentlyPurchasedCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> -->
    </div><!-- end of carousel -->
  </div><!-- end of div container -->





  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2>Customers also bought:</h2>

    <div id="customersBoughtCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#customersBoughtCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#customersBoughtCarousel" data-slide-to="1"></li>
        <li data-target="#customersBoughtCarousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">

        <div class="item active">
          <img src="img/hatperson1.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

        <div class="item">
          <img src="img/hatperson2.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

        <div class="item">
          <img src="img/hatperson3.jpg" alt="..." class="carouselImg">
          <div class="carousel-caption captionShowHide">
            <h3>Lorem Ipsum</h3>
            <p>Lorem ipsum dolor sit amet, sint occaecat cupidatat non.</p>
          </div>
        </div>

      </div><!-- end of inner -->

      <!-- Controls -->
    <!--   <a class="left carousel-control" href="#customersBoughtCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#customersBoughtCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> -->
    </div><!-- end of carousel -->
  </div><!-- end of div container -->






  </div>
</div>

<br><br>





<?php include 'footer.php'; ?>
