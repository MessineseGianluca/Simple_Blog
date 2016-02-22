<!DOCTYPE html>
<html lang='en'>
<head>
  <title> Sign in </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" 
        href="bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
  <?php
    session_start();
    echo '<p style="color:red">' . $_SESSION['login_message'] . '</p> '; 
  ?>
  <form name='signin' action='validate_user.php' method='post'>
    E-mail:<br><input type='email' name='email' autofocus required>
    <br>
    Password:<br><input type='password' name='pass' maxlength="16" required>
    <br><br>
    <input type='submit' value='Enter'> or 
    <input type='button' value='Sign up'  
           onclick = 'window.open("signup.php", "_self")'>
  </form>
  
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
