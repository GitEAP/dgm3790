<?php
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
$query = "SELECT * FROM products";
$result = mysqli_query($dbconnect, $query) or die('run query failed');

/////////////////////////////////////////PAGINATION//////////////////////////////////////
//declare variables for pagination
if (!isset($_GET['currentPage'])) {
  $currentPage = 1;
} else {
  $currentPage = $_GET['currentPage'];
}
$perPage = 9;
$skip = ($currentPage - 1) * $perPage;
$totalProducts = mysqli_num_rows($result);//returns number of rows.
$num_pages = ceil($totalProducts / $perPage);

//build limit query
$limitQuery = " LIMIT $skip".", "."$perPage";

//display items from new query
$query2 = "SELECT * FROM products $limitQuery";
$result2 = mysqli_query($dbconnect, $query2) or die('limit query2 failed');

//next and previous buttons for pagination
$previousPage = ($currentPage == 1) ? $num_pages : $currentPage - 1;
$nextPage = ($currentPage == $num_pages) ? 1 : $currentPage + 1;
////////////////////////////////////END OF PAGINATION////////////////////////////////////////

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
    
    <form action="pub_detail.php" method="GET" enctype="multipart/form-data">
      <?php
        while($row = mysqli_fetch_array($result2)){
          echo '<div class="card col-xs-12 col-sm-6 col-md-4">'; 
          echo '<img class="card-img-top" src="'. $row['picture'] .'" alt="Product">';
          echo '<div class="card-body">';   
          echo '<h3 class="card-title">' . $row['title'] . '</h3>';  
          echo '<p>Price: $' . $row['price'] . '</p>';
          echo '<p class="card-text">'. $row['shortdescription'] . '</p>';
          echo '<a href="pub_detail.php?id='.$row['product_id'].'">View Details</a>';
          echo '</div>';
          echo '</div>';
        }
      ?>

    <div aria-label="Page navigation" class="myPagination">
      <ul class="pagination">
        <li class="page-item">
           <?php echo '<a class="page-link" href="products.php?currentPage='. $previousPage.'" aria-label="Previous">'; ?>
            <span aria-hidden="true"><i class="fa fa-caret-left"></i></span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <?php
          //display page numbers
          for ($i = 1; $i <= $num_pages; $i++) {
            //add active class to current page.
            if ($currentPage == $i) {
              echo '<li class="page-item active"><a class="page-link" href="products.php?currentPage='.$i.'">'.$i.'</a></li>';
            } else {
              echo '<li class="page-item"><a class="page-link" href="products.php?currentPage='.$i.'">'.$i.'</a></li>';
            }
          }
        ?>
        <li class="page-item">
           <?php echo '<a class="page-link" href="products.php?currentPage='.$nextPage.'" aria-label="Next">'; ?>
            <span aria-hidden="true"><i class="fa fa-caret-right"></i></span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </div><!-- end of pagination -->

    </form>
    <br /><br />
    <br /><br />
  </div>
</div>

<?php include 'footer.php'; ?>
