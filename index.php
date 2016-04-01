<?php
  session_start();
  include 'php_functions.php';
  include 'html_code_functions.php';
  #Create an object for the dbms handlings
  if(!$_SESSION['authenticated'])
  {
    header("Location: login.php");
    exit;
  } 


  $data = new MysqlConnector();
  $data->connectMysql();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
  <title> Dashboard </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" 
        href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">  
</head>
<body class='colored-body'>
  
  <!-- NAVBAR -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" 
                class="navbar-toggle collapsed" 
                data-toggle="collapse" 
                data-target="#bs-example-navbar-collapse-1" 
                aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="index.php">BeSocial</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" 
           id="bs-example-navbar-collapse-1">
        <form class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" 
               class="dropdown-toggle" 
               data-toggle="dropdown" 
               role="button" 
               aria-haspopup="true" 
               aria-expanded="false">
              <span class='glyphicon glyphicon-user img-rounded'></span>
              &nbsp;
              <?php 
                echo $_SESSION['surname'] . " " . $_SESSION['name'] ; 
              ?>
              <span class="caret"></span>
            </a> 
            <ul class="dropdown-menu">
              <li><a href="#">Profile</a></li>
              <li><a href="#">Account</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav> 
  
  <div class='container col-lg-6'>
    <!-- Write new post area -->
    <div class = 'row'>
      <div class="form-group write-post col-lg-12 col-xs-12">
        <form action='' method='post'>
          <textarea class='form-control elastic-box text-post'
                    style='resize: none;'
                    rows='2'
                    name='description'
                    placeholder='Insert some text...'></textarea>
          
          <button style='float: right;' 
                 class='btn btn-default post-submit' 
                 dataNextPostId=<?php echo $data->findLastPostId(); ?>
                 dataAuthorId=<?php echo $_SESSION['id']; ?>
                 ><span class="glyphicon glyphicon-pencil"></span></button>
          
          <!--<input class='hidden choose-img' type='file' name='imgToUpdate'>-->        

        </form>
      </div>
    </div> 

    <!-- Container of Posts -->
    <div class='posts-container'>
      <?php

        $data = new MysqlConnector();
        $data->connectMysql();
        
        #LOAD ALL POSTS
        $result = $data->getPosts();
          
        #PRINT EACH LOADED POST WITH ITS COMMENTS
        while($post = $result->fetch_assoc()) {     
          printPostCode(
            $post['user_id'],
            $post['name'], 
            $post['surname'],
            $post['description'],
            $post['post_id']
          );
        }
      ?>
    </div>
  </div>
  
  <div class='hidden postCodeSample'>
    <?php printPostCode("", "", "", "")?>
  </div>

  <!-- A div for storing a codesample of a general comment --> 
  <div class='hidden commentCodeSample'>
    <?php printCommentCode("", "", "", ""); ?>
  </div>
  

  <!--INCLUSIONS -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src=
    'bower_components/jakobmattsson-jquery-elastic/jquery.elastic.source.js'>
  </script>

  <!--Store some js global var -->
  <script>
    firstname = "<?php echo $_SESSION['name']; ?>";
    lastname =  "<?php echo $_SESSION['surname']; ?>";
    userId = "<?php echo $_SESSION['id']; ?>";
    img = "img/" + "<?php echo getImg($_SESSION['id']); ?>";
  </script>

  <script src="js/myjs.js"></script>
</body>
</html> 

