<?php
require_once('variable.php');

$feedback = 'Dont have an account? Create an account <a href="signup.php">here</a>';

if(isset($_POST['submit'])){

  $dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
  $username = mysqli_real_escape_string($dbconnect, trim($_POST['username']));
  $pw = mysqli_real_escape_string($dbconnect, trim($_POST['pw']));

  $query = "SELECT * FROM member WHERE username = '$username' AND password = SHA('$pw')";
  $data = mysqli_query($dbconnect, $query) or die('login query failed');

  if(mysqli_num_rows($data) == 1){
    $feedback =  'You are now logged in.';
    $row = mysqli_fetch_array($data);

    setcookie('username', $username, time() + (60*60*24*30));
    setcookie('name', $row['name'], time() + (60*60*24*30));
    setcookie('id', $row['id'], time() + (60*60*24*30));

    mysqli_close($dbconnect);

    header('Location: index.php');

  }else{
    $feedback = 'No account found. Try again or create a ' .  '<a href="signup.php">New Account</a>';
  }

};

include 'head.php';

?>
<div class="row">
<div class="col-xs-12 text-center">

<h1>Login</h1>
<br /><br />
</div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
    <div class="col-xs-10">
      <article class="clearfix panel panel-default">
        <div class="text-center">
          <h1> <?php echo $feedback; ?></h1><br /><br />
        </div>
        <form action="login.php" method="POST" enctype="multipart/form-data" class="form-horizontal padding-sm">

          <div class="form-group">
            <span>Username <input type="text" name="username" value="" class="form-control" required></span>
          </div>

          <div class="form-group">
            <span>Password <input type="password" name="pw" value="" class="form-control" required></span>
          </div>

          <button type="submit" class="primary_button" name="submit">Log in</button>

        </form>
      </article>
    </div>
  <div class="col-xs-1"></div>
</div>
  
  <?php include 'footer.php'; ?>
