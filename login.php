<!DOCTYPE html>
<html lang='en'>
<head>
  <title> Sign in </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" 
        href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">
</head>
<body class="colored-body">
  <?php
    session_start();
    echo '<p style="color:red">' . $_SESSION['login_message'] . '</p> '; 
  ?>

  <div class="container">
    <form class="form-signin"
          name='signin' 
          action='validate_user.php' 
          method='post'>
      <h2 class="form-signin-heading">Please sign in</h2>
      <input type="email" 
             class="form-control" 
             placeholder="Email address"
             name="email" 
             required 
             autofocus>
      <input type="password" 
             id="inputPassword" 
             class="form-control"
             name="pass" 
             placeholder="Password" 
             required>
      <div class="row" style="margin-top: 20px;">
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </div>
        <div class="col-lg-2">
          <h4 style="text-align: center"> OR </h4>
        </div>
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-warning btn-block" 
                  type="button" 
                  onclick = 'window.open("signup.php", "_self")'
          >Sing up</button>
        </div>
      </div>
    </form>
  </div>

  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
