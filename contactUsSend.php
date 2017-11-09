<?php
require_once('variable.php');

$subject = $_POST['subject'];
$message = $_POST['message'];
$from = $_POST['email'];
$to = "kylejohnson2612@gmail.com";
  
$newMessage = "Hi Hat Team,\n You have a message from $from.\nMessage:\n$message";

mail($to, $subject, $newMessage, 'From:' . $from);

include 'head.php';  

?>
<br /><br />
<div class="row">
<div class="col-xs-1"></div>
  <div class="col-xs-10 text-center">
    <article class="clearfix panel panel-default">
      <?php
      echo '<h1> Thanks you</h1><p>A representative will contact you shortly. </p>';
      ?>
      <br /><br />
    </article>
  </div>
</div>
<br /><br />

<?php include 'footer.php'; ?>
