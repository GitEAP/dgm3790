<?php
$id = $_COOKIE['id'];
require_once('variable.php');
$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');
$query = "SELECT * FROM member WHERE id=$id";
$result = mysqli_query($dbconnect, $query) or die('send message query failed');
$found = mysqli_fetch_array($result);

mysqli_close($dbconnect);
include 'head.php';

?>
<br /><br />
<div class="row">
	<div class="col-sm-1 text-center"></div>
  <div class="col-sm-10 text-center">
	<article class="clearfix panel panel-default">
  	<h1>Contact Us</h1>
		<p>Fill out the form below to contact us with any questions that you have.</p>
	</article>
  </div>
</div>
<div class="row">
<div class="col-sm-1"></div>
  <div class="col-sm-10">
    <article class="clearfix panel panel-default">
      <form action="contactUsSend.php" method="POST" enctype="multipart/form-data">
					<div class="col-sm-12">

						<div class="form-group">
						  <label class="control-label">Your Email</label>
						  <div class="controls">
							<?php
							echo '<input id="email" name="email" placeholder="your-email@email.com" class="form-control input-lg requiredField" type="text" required="" oninvalid="this.setCustomValidity("Please enter your email.")" oninput="setCustomValidity("")" value="' . $found['email'] . '">';

							?>
						  </div>
						</div><!-- End subject  input -->

						<div class="form-group">
						  <label class="control-label">Subject</label>
						  <div class="controls">
							<input id="subject" name="subject" placeholder="Subject" class="form-control input-lg requiredField" type="text" required="" oninvalid="this.setCustomValidity('Please enter your subject.')" oninput="setCustomValidity('')">
						  </div>
						</div><!-- End subject  input -->

            <div class="form-group">
						  <label class="control-label">Message</label>
						  <div class="controls">
              <textarea id="message" rows="8" cols="40" name="message" placeholder="Message" class="form-control input-lg" type="text" required="" oninvalid="this.setCustomValidity('Please enter your message.')" oninput="setCustomValidity('')"></textarea>
                <input type="hidden" name="id" value="<?php echo $found['id']; ?>">
						  </div>
						</div><!-- End message input -->

						<input type="submit" value="Send" class="primary_button" id="submit" />

					</div>
      	</form><!-- End contact-form -->
			<br />
</article><!--End article-->
</div>
</div>
  
<?php include 'footer.php'; ?>
