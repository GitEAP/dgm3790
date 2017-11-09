<?php
require_once('variable.php');

$subject = $_POST['subject'];
$message = $_POST['message'];
$to = $_POST['email'];
$from = "nba_eap@hotmail.com";

mail($to, $subject, $message, 'From:' . $from);

include 'head.php';  

?>
<br /><br />
<div class="row">
<div class="col-xs-1"></div>
  <div class="col-xs-10 text-center">
    <article class="clearfix panel panel-default">
      <?php
      echo '<h1>Success!</h1><p>Your email has been sent to:'. $to . '.</p>';
      ?>
      <br /><br />
    </article>
  </div>
</div>
<br /><br />

<?php include 'footer.php'; ?>
