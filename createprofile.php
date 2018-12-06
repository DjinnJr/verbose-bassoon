<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mismatch - View Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<h2>Create your own profile right now!</h2>

<?php
require_once('connectvars.php');
require_once('appvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

if (isset($_POST['submit'])) {
  if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
    $data = "SELECT * FROM mismatch_user WHERE username = '$username'";
    if (mysqli_num_rows($dbc, $data) == 0) {
      $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$username', SHA('$password1'), NOW())";
      echo "<p>Your profile was created succesfully!</p><br /><p> <a href='editprofile.php'>CLICK HERE</a> to change it</p>";
    } else {
      echo '<p class="error">The username is already exists, please choose another username!</p>';
    }
  } else {
    echo '<p class="error">Please, fill up all fields and check if your passwords match each other</p>';
  }
}
mysqli_close($dbc);
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<fieldset>
<legend>Creating profile</legend>
    <label for="username"> Enter your username: </label>
    <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username ?>"/> <br />
    <label for="password1">Enter password: </label>
    <input type="password" id="password1" name="password1" /> <br />
    <label for="password2">Confirm password: </label>
    <input type="password" id="password2" name="password2" /> <br />
</fieldset>
<input type="submit" name="submit" value="Create profile" />
</form>
