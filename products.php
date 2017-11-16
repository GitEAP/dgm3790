<?php
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

function printInputs($categoryType) {
    $categoryFound = false;

    global $filterArray;

    if (!empty($filterArray)){
      foreach ($filterArray as $categoryName) {
        //Checks the users selected categories
        if($categoryName == $categoryType) {
          $categoryFound = true;
          //remove item from array
          $arrayIndex = array_search($categoryName, $filterArray);
          unset($filterArray[$arrayIndex]);
          //Once correct value is found no need to check the rest
          break;
        }
        if ($categoryName != $categoryType) {
          $categoryFound = false;
        }
      }//end of foreach loop
    }//end of if empty

    if ($categoryFound === true) {
      echo '<label class="btn btn-primary active">';
      echo '<input type="checkbox" name="filter[]" checked value="'.$categoryType.'" autocomplete="off"> ' . $categoryType;
      echo '</label>';
    } else {
      echo '<label class="btn btn-primary">';
      echo '<input type="checkbox" name="filter[]" value="'.$categoryType.'" autocomplete="off"> ' . $categoryType;
      echo '</label>';
    }
}//end of function

/////////////////////////////////////////Filter Categories//////////////////////////////////////
//By Default makes "all" button active
if(!isset($_POST['filter']) && !isset($_GET['filter'])) {
  $activeState = "active";
  $checkState = "checked";
} 
else{
  //if user clicks all, make all button active only
   if($_POST['filter'][0] == 'userAll') {
      $activeState = "active";
      $checkState = "checked";
    }
    //if the user did not click all disable "all" button and active other buttons
   if($_POST['filter'][0] != 'userAll') {
      $activeState = "";
      $checkState = "";

      $filterArray;
      $filterString;
      findFilter();
      
    }//end of if
}//end of else

function findFilter() {
  global $filterArray;
  global $filterString;
  if(isset($_POST['filter'])){
     //gets the categories choosen by the user
      foreach ($_POST['filter'] as $category) {
        $filterArray[] = $category;
        $filterString .= "&filter[]=". $category ."";
      }//end of foreach
  }
  else if (isset($_GET['filter'])) {
     foreach ($_GET['filter'] as $category) {
        $filterArray[] = $category;
        $filterString .= "&filter[]=". $category ."";
      }
  }
}
/////////////////////////////////////////END of Filter Categories//////////////////////////////////////


/////////////////////////////////////////PAGINATION//////////////////////////////////////
//declare variables for pagination
if (!isset($_GET['currentPage'])) {
  $currentPage = 1;
} else {
  $currentPage = $_GET['currentPage'];
}
$perPage = 9;
$skip = ($currentPage - 1) * $perPage;


//build limit query
$limitQuery = " LIMIT $skip".", "."$perPage";


// BULILD WHERE CLAUSE
$whereList = array();
foreach ($filterArray as $type) {

  if (($type == "All") || ($type == "userAll")) {
    //do nothing
  } else {
    $whereList[] = "(type='". $type ."')";//build list of where clauses
  }
}//end of foreach

$whereClause = implode(' OR ', $whereList);//add "AND" between each where clause

//query to get all products
$query2 = "SELECT * FROM products INNER JOIN categories ON (products.category_id = categories.category_id)";

//get number of pages based on the products we got (default display all products)
$pagesResult2 = mysqli_query($dbconnect, $query2) or die('pages result query2 failed');
$totalProducts = mysqli_num_rows($pagesResult2);

if (!empty($whereClause)) {
  //add where clause to query
  $query2 .= " WHERE $whereClause";
  //get new number of pages
  $pagesResult2 = mysqli_query($dbconnect, $query2) or die('pages result query2 part 2 failed');
  $totalProducts = mysqli_num_rows($pagesResult2);
  //add limit per page
  $query2 .= " $limitQuery";
}
else {
  //add limit per page
  $query2 .= " $limitQuery";
}
//displays each item
$result2 = mysqli_query($dbconnect, $query2) or die('limit query2 failed');
//get number of pages to display
$num_pages = ceil($totalProducts / $perPage);

//next and previous buttons for pagination (Cycles back or forth)
$previousPage = ($currentPage == 1) ? $num_pages : $currentPage - 1;
$nextPage = ($currentPage == $num_pages) ? 1 : $currentPage + 1;

////////////////////////////////////END OF PAGINATION////////////////////////////////////////

include 'head.php'; 
?>

<div class="row">
  <div class="col-xs-12 text-center">
    <h1>Products</h1>



<form action="products.php" method="POST" enctype="multipart/form-data" id="filterForm">

      <span style="padding: .4em; display: block; text-align: center;">
        Categories:
      </span>
    
      <div class="btn-group" data-toggle="buttons" role="group" aria-label="Filter Categories">

      <?php 
      echo '<label class="btn btn-primary '.$activeState.'">';
      echo '<input type="checkbox" id="all" name="filter[]" '.$checkState.' value="All" autocomplete="off"> All';
      echo '</label>';

      $categoryQuery = "SELECT * FROM categories";
      $resultCategory = mysqli_query($dbconnect, $categoryQuery) or die('category query failed');

      //print all the categories from database
      while($rowCategory = mysqli_fetch_array($resultCategory)){//Gets all the categories
        printInputs($rowCategory['type']);      
      }//end of while loop

?>
    </div><!-- /end of btn group -->

    <br />
    <br />
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    
     <?php
     //display each item
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
           <?php echo '<a class="page-link" href="products.php?currentPage='. $previousPage.$filterString.'" aria-label="Previous">'; ?>
            <span aria-hidden="true"><i class="fa fa-caret-left"></i></span>
            <span class="sr-only">Previous</span>
          </a>
        </li>

        <?php
          //display page numbers
          for ($i = 1; $i <= $num_pages; $i++) {
            //add active class to current page.
            if ($currentPage == $i) {
              echo '<li class="page-item active"><a class="page-link" href="products.php?currentPage='.$i.$filterString.'">'.$i.'</a></li>';
            } else {
              echo '<li class="page-item"><a class="page-link" href="products.php?currentPage='.$i.$filterString.'">'.$i.'</a></li>';
            }
          }
        ?>

        <li class="page-item">
           <?php echo '<a class="page-link" href="products.php?currentPage='.$nextPage.$filterString.'" aria-label="Next">'; ?>
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
