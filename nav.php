<div class="myNavBar">

<ul class="mainNav">
  <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
  <li><a href="products.php"><i class="fa fa-automobile"></i> Products</a></li>
  <li><a href="email.php"><i class="fa fa-bell"></i> Contact</a></li>
  <li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart (<?php 
  require_once('variable.php');
  $dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
  $queryCheck = "SELECT * FROM cart";
  $resultCheck = mysqli_query($dbconnect, $queryCheck) or die('cart query failed');
  $cartCount = 0;
  if(isset($_COOKIE["id"])){
    $mem_id = $_COOKIE["id"];
  }else{
    setcookie('id', 0, time() + (60*60*24*30));
    $mem_id = $_COOKIE["id"];
  };
  while($rowCheck = mysqli_fetch_array($resultCheck)){
    if($rowCheck['mem_id'] == $mem_id){
      $cartCount += 1;
    };
  };
  echo $cartCount;
  ?>)</a></li>

  <li>
    <form action="search.php" method="POST" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">
      <div class="input-group">
        <input type="text" class="form-control mySearch" placeholder="Search for..." aria-label="Search for..." title="Search the name of a product" name="userSearch" pattern="[0-9a-zA-Z., -]{2,99}">
        <span class="input-group-btn ">
          <button class="btn btn-secondary mySearchBtn" type="submit"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </li>
</ul>

<div class="logNav">
  <?php
      if(isset($_COOKIE['username'])){
        echo 'Welcome, <a href="updateUser.php?id='.$_COOKIE['id'].'">';
        echo $_COOKIE['name'] . ' <i class="fa fa-chevron-down"></i> ';
        echo '</a> | <a href="logout.php">log out</a>';
      }else{
        echo '<a href="login.php">Log in</a>';
      }
    ?>
</div>

</div><!-- end myNavBar -->


