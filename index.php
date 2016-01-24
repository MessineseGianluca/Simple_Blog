<?php
  session_start();
  include 'php_functions.php';
  #Create an object for the dbms handlings
  if(!$_SESSION['authenticated'])
  {
    header("Location: login.html");
    exit;
  }  
  // remove all session variables
  #session_unset(); 
  // destroy the session 
  #session_destroy(); 
?>
<!DOCTYPE html>
<html lang='en'>
  <title> Dashboard </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">
  
</head>
<body>
  <div class='container'>
    <div class='page-header'>
      <h1><b> My Simple Blog </b></h1>
    </div>
    
    <div class='row'>
      <div class='col-lg-4 user-panel' >
        <div class='row'>
          <div class='col-lg-2'>
            <img src='img/user.jpg' class='img-rounded user-img'>
          </div>
          
          <div class='col-lg-8' >
            <p><?php echo $_SESSION['name']. ' ' . $_SESSION['surname']; ?></p>
          </div>
          
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" 
            data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" >
              <li><a tabindex="-1" href="logout.php">Log out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html> 

