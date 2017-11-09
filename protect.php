<?php
if(!isset($_COOKIE['username'])){

 include 'head.php';

echo '<div class="row">
  <div class="col-xs-12 text-center">
    <h1>Restrictive Access</h1>
    <br /><br />
  </div>
</div>
<div class="row">
  <div class="col-xs-1"></div>
    <div class="col-xs-10">
      <article class="clearfix panel panel-default text-center">
          <br />
          <h1>Please <a href="login.php">log in</a> to see this page</h1>
          <br />
      </article>
    </div>
  <div class="col-xs-1"></div>
</div>';
  
include 'footer.php';

exit();
}
?>


