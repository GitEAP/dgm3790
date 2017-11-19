<?php
require_once('variable.php');
$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

//***************************************GET DATA***************************************
$userSearch = ucwords(mysqli_real_escape_string($dbconnect, $_POST['userSearch']));
$itemFound = false;
$querySearch1 = "SELECT * FROM products WHERE title='$userSearch'";
$searchResult1 = mysqli_query($dbconnect, $querySearch1) or die("Search1 query failed");

if (mysqli_num_rows($searchResult1) > 0) {
  $itemFound = true;
}

else {
  $userSearch = strtolower($userSearch);
  $userSearchClean = str_replace(',',' ',$userSearch);
  $searchWords = explode(' ', $userSearchClean);//divides words at each space 
  //get each word and put in an array to build where clause.
  foreach ($searchWords as $word) {
    if(!empty($word)) {
      $searchArray[] = ucfirst($word);
    }//end of if
  }//end of foreach
  //**************************BUILD WHERE CLAUSE**************************
  $whereList = array();
  foreach ($searchArray as $word) {
    $whereList[] = "title LIKE '%$word%'";
  }//end of foreach

  $whereClause = implode(' OR ', $whereList);
  //default query, if user didn't search anything or just spaces
  $querySearch = "SELECT * FROM products";

  if (!empty($whereClause)) {
    $querySearch .= " WHERE $whereClause";
  }

  $itemFound = false;
  $searchResult = mysqli_query($dbconnect, $querySearch) or die("Search query failed");
}
include 'head.php'; 
?>

<div class="row">
  <div class="col-xs-12 text-center">
    <h1>Search Results</h1>
    <br />
    <br />
  </div>
</div>


<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
  <?php

    
    //search results displayed here   
     if ($itemFound == true) {
        echo '<p>Search results for: '.$userSearch.'</p>';
         $found = mysqli_fetch_array($searchResult1);
?>
          <div id="accordion" role="tablist">
            <div class="card cardResult col-xs-12">
              <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <h3><?php echo $found['title'].' <i class="fa fa-angle-down"></i></h3>'; ?>
                  </a>
                </h5>
              </div>
              <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body col-xs-12">

                
                  <div class="searchContentImg col-xs-8 col-sm-6 col-md-4">
                    <?php echo '<img src="'.$found['picture'].'" alt="'.$found['title'].'">'; ?>
                  </div>

                  <div class="searchContent col-xs-12 col-sm-6 col-md-8">
                  <?php
                    echo '<h4>'.$found['title'].'</h4>';
                    echo '<p>Description: '.$found['shortdescription'].'</p>';
                    echo '<a href="pub_detail.php?id='.$found['product_id'].'">View Item</a>';
                  ?>
                  </div><!-- //end of searchContent -->

                </div>
              </div>
            </div>
          </div>
<?php
     }//end of if itemfound == true

     if ($itemFound == false) {
      echo '<p>Search results for: '.$userSearchClean.'</p>';
      if (mysqli_num_rows($searchResult) > 0) {

        echo '<div id="accordion" role="tablist">';
        $t = 0;
        while($row = mysqli_fetch_array($searchResult)) {
?>
            <div class="card cardResult col-xs-12">
              <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" href="#<?php echo $t; ?>" aria-expanded="false" aria-controls="<?php echo $t; ?>">
                    <h3><?php echo $row['title'].' <i class="fa fa-angle-down"></i></h3>'; ?>
                  </a>
                </h5>
              </div>
              <div id="<?php echo $t; ?>" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body col-xs-12">


                  <div class="searchContentImg col-xs-8 col-sm-6 col-md-4">
                    <?php echo '<img src="'.$row['picture'].'" alt="'.$row['title'].'">'; ?>
                  </div>

                  <div class="searchContent col-xs-12 col-sm-6 col-md-8">
                  <?php
                    echo '<h4>'.$row['title'].'</h4>';
                    echo '<p>Description: '.$row['shortdescription'].'</p>';
                    echo '<a href="pub_detail.php?id='.$row['product_id'].'">View Item</a>';
                  ?>
                  </div><!-- //end of searchContent -->
                </div>
              </div>
            </div>
<?php
      $t += 1;
        }//end of while
        echo '</div>';//end of accordian

      }else {//no matches found.
        echo '<div class="alert alert-info" role="alert">';
        echo 'No matches found. <br>Separate keywords with a comma (,)<br> Please try again...';
        echo '</div>';

        echo '<form action="search.php" method="POST" enctype="multipart/form-data" class="form-inline">';
        echo '<div class="input-group col-xs-12 col-md-4">';
        echo '<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." title="Search the name of a product" name="userSearch" pattern="[0-9a-zA-Z., -]{2,99}">';
        echo '<span class="input-group-btn">';
        echo '<button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>';
        echo '</span>';
        echo ' </div>';
        echo '</form>';
        }//end of else
    }//end of if
  ?>
    <br /><br />
    <br /><br />
  </div>
</div>

<?php include 'footer.php'; ?>
