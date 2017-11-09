<?php

setcookie('username', '', time()-3600);
setcookie('name', '', time()-3600);
setcookie('id', 0, time() + (60*60*24*30));
header('Location: index.php');

 ?>
