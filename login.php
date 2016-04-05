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

  <div class="container">
    <form class="form-signin"
          name='signin' 
          action='validate_user.php' 
          method='post'>
      <h2>Please sign in</h2>
      <div class="errors"></div> 
      <input type="email" 
             class="form-control email" 
             placeholder="Email address"
             name="email" 
             required 
             autofocus>
      <input type="password" 
             maxlength="16" 
             class="form-control password"
             name="pass" 
             placeholder="Password" 
             required>
      <div class="row" style="margin-top: 20px;">
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-primary btn-block sign-in" 
                  type="submit">Sign in</button>
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
  <script src="js/upload.js"></script>  
</body>
</html>
