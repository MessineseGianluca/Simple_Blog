<!DOCTYPE html>
<html lang='en'>
  <title> Sign up </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">
</head>  
<body class="colored-body">
  <div class="container">
    <form class="form-signup"
          name='signup' 
          action='validate_new_user.php' 
          method='post'
          enctype="multipart/form-data">
      <h2>Please sign in</h2>
      <div class="errors"></div> 
      <input type="text" 
             class="form-control name"
             placeholder="Name"
             name="name"
             maxlength="20" 
             required
             autofocus>
      <input type="text" 
             class="form-control surname" 
             placeholder="Surname"
             name="surname"
             maxlength="20" 
             required>      
      <input type="email" 
             class="form-control email" 
             placeholder="Email address"
             name="email" 
             required>
      <input type="password" 
             maxlength="16" 
             class="form-control password"
             name="pass" 
             placeholder="Password" 
             required>
      <input type="password" 
             maxlength="16" 
             class="form-control password2"
             name="pass2" 
             placeholder="Repeat password" 
             required>
      
      <button class="btn btn-success upload-btn" 
              type="button">
              <span class="glyphicon glyphicon-folder-open"></span>
               Picture 
      </button>
      <input class='hidden upload-input' 
             type='file' 
             name='imgToUpdate'
             value="upload">

      <div class="row" style="margin-top: 20px;">
        <div class="col-lg-5">       
          <button class='btn btn-lg btn-warning btn-block sign-up' 
                  type='submit'>Sign up</button>
        </div>
        <div class="col-lg-2">
          <h4 style="text-align: center"> OR </h4>
        </div>
        <div class="col-lg-5">       
          <button class="btn btn-lg btn-primary btn-block login" 
                  type="button" 
                  onclick = 'window.open("login.php", "_self")'
          >Sing in</button>
        </div>
      </div>
    </form>
  </div>
  
  
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="js/upload.js"></script>  
</body>
</html>
