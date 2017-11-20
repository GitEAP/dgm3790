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
$totalLimit = 5;
//connect to db
$dbconnectCarousels = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('similar connection failed');

function print_carousel_indicators($name, $total) {
  echo '<ol class="carousel-indicators">';
  //display slide dots (indicators)
    for ($i = 0; $i < $total; $i++) {
      if ($i == 0) {
        echo '<li data-target="#'.$name.'" data-slide-to="'.$i.'" class="active"></li>';
      } else {
          echo '<li data-target="#'.$name.'" data-slide-to="'.$i.'"></li>';
      }
    } 
  echo '</ol>';
}
function randomLimit ($total) {
    global $totalLimit;
    $ranNum = mt_rand(1, ($total - $totalLimit));
    $setLimit = " LIMIT $ranNum, $totalLimit";
    return $setLimit;
}
function print_carousel_items ($result) {
    $i = 1;
    while($row = mysqli_fetch_array($result)) {

      if($i == 1) {
         echo '<div class="item active">';
            echo '<a href="pub_detail.php?id='. $row['product_id'] .'"><img src="'.$row['picture'].'" alt="'.$row['title'].'" class="carouselImg"></a>';
            echo '<div class="carousel-caption captionShowHide">';
              echo '<h3>'.$row['title'].'</h3>';
             echo ' <p>'.$row['price'].'</p>';
           echo ' </div>';
          echo '</div>';
        $i++;
      } else {
        echo '<div class="item">';
            echo '<a href="pub_detail.php?id='. $row['product_id'] .'"><img src="'.$row['picture'].'" alt="'.$row['title'].'" class="carouselImg"></a>';
            echo '<div class="carousel-caption captionShowHide">';
              echo '<h3>'.$row['title'].'</h3>';
             echo ' <p>'.$row['price'].'</p>';
           echo ' </div>';
          echo '</div>';
      }//end of if else
    }//end of while loop
}


//get all products that have the same category as the current product.
$querySimilar = "SELECT * FROM products INNER JOIN categories ON (products.category_id = categories.category_id) WHERE type='$currentCategory'";
$resultSimilar = mysqli_query($dbconnectCarousels, $querySimilar) or die ('similar query 1 run failed');

if(mysqli_num_rows($resultSimilar) < $totalLimit) {
  $totalProductsAfterLimit = mysqli_num_rows($resultSimilar);
}
else {
  //Random number to set as limit
  $totalProducts = mysqli_num_rows($resultSimilar);
  $querySimilar .= randomLimit($totalProducts);

  $resultSimilar = mysqli_query($dbconnectCarousels, $querySimilar) or die ('similar query 2 run failed');
  $totalProductsAfterLimit = mysqli_num_rows($resultSimilar);
}

?>
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2>Similar Items:</h2>

    <div id="similarItemCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <?php print_carousel_indicators('similarItemCarousel', $totalProductsAfterLimit); ?>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      <?php print_carousel_items ($resultSimilar); ?>

      </div><!-- end of carousel inner -->
    </div><!-- end of carousel -->
  </div><!-- end of div container -->


<?php
if(isset($_COOKIE['name'])) {
//if logged in (name is set) => get name
  $mem_name = $_COOKIE['name'];
//use name to find recently purchased item
  $queryGetRecent = "SELECT products FROM send_information WHERE name='$mem_name'";
  $resultGetRecent = mysqli_query($dbconnectCarousels, $queryGetRecent) or die ('recent query 1 run failed');
  $sectionTitle = 'Recently Purchased:';

  if (mysqli_num_rows($resultGetRecent) == 0) {//if user has never purchased a product
    
    $queryAllProducts = "SELECT * FROM products";
    $result_all_products = mysqli_query($dbconnectCarousels, $queryAllProducts) or die ('rqueryAllProducts 1 run failed');
    $limitString = randomLimit(mysqli_num_rows($result_all_products));
    $queryRecent = "SELECT * FROM products $limitString";
    $sectionTitle = 'Other Products:';

  }else {
      while ($rowRecent = mysqli_fetch_array($resultGetRecent)) {
        //get rid of number in string
        $words = preg_replace('/[0-9]+/', '', $rowRecent['products']);//pattern, replace, subject
        //make a list of products, getting rid of commas
        $productWords = explode(',', $words);

        foreach ($productWords as $product) {
          if(!empty($product)) {
            $productArray[] = ucfirst($product);
          }//end of if
        }//end of foreach

      }//end of while loop

    $whereList = array();
    foreach ($productArray as $product) {
      $whereList[] = "title='$product'";
    }//end of foreach

    $whereClause = implode(' OR ', $whereList);

    $queryRecent = "SELECT * FROM products WHERE $whereClause LIMIT $totalLimit";

  }// end of if else mysqli_num_rows($resultGetRecent) == 0
} //end of if cookie name is set
else {
    $queryAllProducts = "SELECT * FROM products";
    $result_all_products = mysqli_query($dbconnectCarousels, $queryAllProducts) or die ('queryAllProducts 2 run failed');
    $limitString = randomLimit(mysqli_num_rows($result_all_products));
    $queryRecent = "SELECT * FROM products $limitString";
    $sectionTitle = 'Other Products:';
}

$resultRecent = mysqli_query($dbconnectCarousels, $queryRecent) or die ('recent query 2 run failed');
$total_recent_products = mysqli_num_rows($resultRecent);
?>
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2><?php echo $sectionTitle; ?></h2>
    <div id="recentlyPurchasedCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <?php print_carousel_indicators('recentlyPurchasedCarousel', $total_recent_products); ?>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      <?php print_carousel_items ($resultRecent); ?>
      </div><!-- end of inner -->
    </div><!-- end of carousel -->
  </div><!-- end of div container -->






<?php

?>
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-4">
    <h2>Customers also bought:</h2>

    <div id="customersBoughtCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
 
      <!-- print_carousel_indicators('similarItemCarousel', $totalProductsAfterLimit); -->

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">

      <!-- print_carousel_items ($resultRecent); -->

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




  </div><!-- end of col -->
</div><!-- end of row -->

<br><br>


<?php include 'footer.php'; ?>
