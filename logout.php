<?php
if (isset($_COOKIE['user_id'])) {
  setcookie ('user_id', '', time()-3600); //deleting cookies by turning into negative date
  setcookie ('username', '', time()-3600);
}
$home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'].'/index.php');
header ('Location: '. $home_url);
?>
