<?php
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

        <ul class="nav navbar-nav zoom">
          <li class="dropdown zoom">
            <a
               href='#'
               class="dropdown-search" 
               data-toggle="dropdown" 
               role="button" 
               aria-haspopup="true" 
               aria-expanded="false"
               style='padding-top: 0px;'>
              <form class="navbar-form navbar-left" 
                    role="search"
                    style=" margin-bottom: 0px">
                <div class="form-group">
                  <input type="text" 
                         class="form-control search" 
                         placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">
                  <span class='glyphicon glyphicon-search'></span> 
                </button>
              </form>
            </a> 
            <ul class="dropdown-menu search-result"></ul>
          </li>
        </ul>   
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
  
  <div class='container col-lg-6 col-md-8 .col-sm-12 col-xs-12'>
    <!-- Write new post area -->
    <div class = 'row'>
      <div class="form-group write-post col-lg-12">
        <form action='' method='post'>
          <textarea class='form-control elastic-box text-post'
                    style='resize: none;'
                    rows='2'
                    name='description'
                    placeholder='Insert some text...'></textarea>
          
          <button class='btn btn-default post-submit'
                  type='button'
                  ><span class="glyphicon glyphicon-pencil"></span></button>
                 
        </form>
      </div>
    </div> 
    
    <div class='events'></div>
        
    <!-- Container of Posts -->
    <div class='posts-container'>
      <?php

        $data = new MysqlConnector();
        $data->connectMysql();
        
        #LOAD ALL POSTS
        $result = $data->getPosts();
        
        #PRINT EACH LOADED POST WITH ITS COMMENTS
        while($post = $result->fetch_assoc()) {
          
          //check if the logged user likes the current post      
          $like = $data->isLiked($post['post_id']);
          //count how many like the post has
          $likes = $data->getNumOfLikes($post['post_id']);
          
          printPostCode(
            $post['user_id'],
            $post['name'], 
            $post['surname'],
            $post['description'],
            $post['post_id'],
            $post['sharing_date'],
            $like,
            $likes,
            $post['img_url']
          );
        }
      ?>
    </div>
  </div>
  
  <div class='hidden postCodeSample'>
    <?php printPostCode("", "", "", "", "", "", false, "", "", "")?>
  </div>

  <!-- A div for storing a codesample of a general comment --> 
  <div class='hidden commentCodeSample'>
    <?php printCommentCode("", "", "", "", "", ""); ?>
  </div>
  

  <!--INCLUSIONS -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src=
    'bower_components/jakobmattsson-jquery-elastic/jquery.elastic.source.js'>
  </script>

  <!--Store some js global var -->
  <script>
    /* GLOBAL VARIABLES */
    firstname = "<?php echo $_SESSION['name']; ?>";
    lastname =  "<?php echo $_SESSION['surname']; ?>";
    userId = "<?php echo $_SESSION['id']; ?>";
    img = "<?php echo getImg() ?>";
  </script>

  <script src="js/myjs.js"></script>
</body>
</html> 

