<?php
require_once ('connectvars.php');

$error_msg = "";

if (!isset($_COOKIE['user_id'])) {
  if (isset($_POST['submit'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

    if(!empty($user_username) && !empty($user_password)) {
      $query = "SELECT username, user_id FROM mismatch_user WHERE username = '$user_username' AND password = SHA('$user_password')";
      $data = mysqli_query($dbc, $query);

      if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          setcookie ('user_id', $row['user_id'], time() + (60*60*24*30));
          setcookie ('username', $row['username'], time () + (60*60*24*30)); //lasts 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('location: ' . $home_url);
      } else {
        $error_msg = "Please, use valid username and password to sign in!";
      }
    } else {
      $error_msg = "Please fill up the fields!";
    }
  }
} ?>
<html>
  <head>
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <h3>MisMatch. Sign in.</h3>

    <?php
    if (empty($_COOKIE['user_id'])) {
      echo '<p class="error">'.$error_msg.'</p>'; ?>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <fieldset>
          <legend>Sign In</legend>
          <label for="username"> Username </label>
          <input type="text" id="username" name="username" value="<?php if(!empty($user_username)) echo $user_username;?>" /> <br />
          <label for="password"> Password </label>
          <input type="password" id="password" name="password" />
          <input type="submit" value="Sign in" name="submit" />
        </fieldset>
      </form>
    <?php
  } else {
    echo '<p class="login"> You have entered as '. $_COOKIE['username'] .'</p>';
  } ?>
</body>
</html>
