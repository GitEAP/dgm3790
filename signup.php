<?php
require_once('variable.php');
$feedback =  'Sign Up';
$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

if (isset($_POST['submit'])){

  $name = mysqli_real_escape_string($dbconnect, trim($_POST['name']));
  $email = mysqli_real_escape_string($dbconnect, trim($_POST['email']));
  $phone = mysqli_real_escape_string($dbconnect, trim($_POST['phone']));
  $address = mysqli_real_escape_string($dbconnect, trim($_POST['address']));
  $creditcard = mysqli_real_escape_string($dbconnect, trim($_POST['creditcard']));
  $username = mysqli_real_escape_string($dbconnect, trim($_POST['username']));
  $pw1 = mysqli_real_escape_string($dbconnect, trim($_POST['pw1']));
  $pw2 = mysqli_real_escape_string($dbconnect, trim($_POST['pw2']));

  if(!empty($username) && !empty($pw1) && !empty($pw2) && ($pw1 == $pw2)) {
      //check for duplicate usernames
      $query = "SELECT * FROM member WHERE username = '$username'";
      $duplicate = mysqli_query($dbconnect, $query) or die('duplicate query failed');
      if(mysqli_num_rows($duplicate) == 0){
        $query = "INSERT INTO member (username, password, name, email, phone, address, creditcard, date) VALUES ('$username', SHA('$pw1'), '$name', '$email', '$phone', '$address', '$creditcard', NOW())";
        mysqli_query($dbconnect, $query) or die('insert new user query failed');

        $feedback = 'You are all signed up! You will be redirected to the login page to login.';

        mysqli_close($dbconnect);

        header( "refresh:5;url=login.php" );

      //  exit();

      }else{
        $feedback =  'Username already exists. Please try again.';
      }

  }
}

include 'head.php';

?>

<div class="row">
  <div class="col-xs-12 text-center">
    <h1> <?php echo $feedback; ?></h1>
    <br /><br />
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
  <div class="col-xs-10">
    <article class="clearfix panel panel-default">
      <form action="signup.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">
        <div class="form-group ">
          <span>Name<input type="text" name="name" value="<?php if(!empty($name)) echo $name ?>" class="form-control" required></span>
        </div>

        <div class="form-group">
          <span>Email <input type="text" name="email" value="<?php if(!empty($email)) echo $email ?>" class="form-control" required ></span>
        </div>

        <div class="form-group">
          <span>Phone <input type="tel" name="phone" value="<?php if(!empty($phone)) echo $phone ?>" class="form-control" required ></span>
        </div>

        <div class="form-group">
          <span>Address <input type="text" name="address" value="<?php if(!empty($address)) echo $address ?>" class="form-control" required ></span>
        </div>

        <div class="form-group">
          <span>Credit Card <input type="text" name="creditcard" value="<?php if(!empty($creditcard)) echo $creditcard ?>" class="form-control" required ></span>
        </div>

        <div class="form-group">
          <span>Username <input type="text" name="username" value="<?php if(!empty($username)) echo $username ?>" class="form-control" required></span>
        </div>

        <div class="form-group">
          <span>Password <input type="password" name="pw1" value="" class="form-control" required></span>
        </div>

        <div class="form-group">
          <span>Retype Password <input type="password" name="pw2" value="" class="form-control" required></span>
        </div>

        <button type="submit" class="primary_button" name="submit">Sign up!</button>

      </div>
      </form>
    </article>
  </div>
  <div class="col-xs-1"></div>
</div>
  
  <?php include 'footer.php'; ?>
