<?php
require_once('vendor/autoload.php');
$stripe = array(
  secret_key      => 'sk_test_h3MNJQvsjRQjRNfmX69eFvAD',
  publishable_key => 'pk_test_w0QWAoa4R0iYSpBxU7xLCqoc'
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>