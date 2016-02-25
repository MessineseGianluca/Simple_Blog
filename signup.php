<!DOCTYPE html>
<html lang='en'>
  <title> Sign up </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">
</head>  
<body class="colored-body">
  <?php
    session_start();
    echo '<p style="color:red">' . $_SESSION['signup_message'] . '</p> '; 
  ?>
    <!--<form name='signup' action='validate_new_user.php' method='post'>
    Name: <br><input type='text' maxlength='20' name='name' auofocus required><br>
    Surname: <br><input type='text' maxlength='20' name='surname' required><br>
    E-mail: <br><input type='email' name='email' required><br>
    Password: <br><input type='password' name='pass' maxlength='16' required><br>
    Repeat Password:<br><input type='password' maxlength='16' name='pass2' required>
    <br><br>
    <input type='submit' value='Sign up'> or 
    <input type='button' value='Login'  
    onclick = 'window.open("login.php", "_self")'>
  </form>-->

  <div class="container">
    <form class="form-signin"
          name='signup' 
          action='validate_new_user.php' 
          method='post'>
      <h2>Please sign in</h2>

      <input type="text" 
             class="form-control" 
             placeholder="Name"
             name="name"
             maxlength="20" 
             required
             autofocus>
      <input type="text" 
             class="form-control" 
             placeholder="Surname"
             name="surname"
             maxlength="20" 
             required>      
      <input type="email" 
             class="form-control" 
             placeholder="Email address"
             name="email" 
             required>
      <input type="password" 
             maxlength="16" 
             class="form-control"
             name="pass" 
             placeholder="Password" 
             required>
      <input type="password" 
             maxlength="16" 
             class="form-control"
             name="pass2" 
             placeholder="Repeat password" 
             required>
      <div class="row" style="margin-top: 20px;">
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-warning btn-block" type="submit">Sign up</button>
        </div>
        <div class="col-lg-2">
          <h4 style="text-align: center"> OR </h4>
        </div>
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-primary btn-block" 
                  type="button" 
                  onclick = 'window.open("login.php", "_self")'
          >Sing in</button>
        </div>
      </div>
    </form>
  </div>
  
  
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  
</body>
</html>
