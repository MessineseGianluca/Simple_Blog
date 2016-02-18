<?php
  session_start();
  include 'php_functions.php';
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
<body>
  
  <!-- NAVBAR -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" 
               class="navbar-toggle collapsed" 
               data-toggle="collapse" 
               data-target="#bs-example-navbar-collapse-1" 
               aria-expanded="false"
        >
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="index.php">BeSocial</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" 
           id="bs-example-navbar-collapse-1"
      >
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
               aria-expanded="false"
            >
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
  
  <div class='container'>
    <!-- Write new post area -->
    <div class = 'row'>
      <div class="form-group write-post col-lg-12">
        <form action='post.php' method='post'>
          <textarea class='form-control elastic-box text-post'
                    style='resize: none;' 
                    rows='2' 
                    name='description'
                    placeholder='Insert some text...'></textarea>
          
          <input style='float: right;' 
                 class='btn btn-defaul submit' 
                 type='submit' 
                 value='Share'>
        </form>
      </div>
    </div> 

    <!-- Container of Posts -->
    <div class='posts-container'>
      <?php
        #LOAD ALL POSTS
        $result = $data->getPosts();
          
        #A FUNCTION FOR PRINTING A COMMENT
        function printCommentCode($name, $surname, $comment, $comment_date) { 
          echo "
            <div class='panel-body comment-box'>
              <a href='#'>
                <h5 class='username'>" . $surname . " " . $name . "</h5>
              </a>
              <h6 class='date'>" . $comment_date . "</h6>
              <h5 class='comment'>" . $comment . "</h5>
            </div>
          "; 
        } 
          
        #PRINT EACH LOADED POST WITH ITS COMMENTS
        while($post = $result->fetch_assoc()) {
          
          echo "
            <div class='row'>
              <div class='col-lg-1'>   
                <img src='img/user.jpg' class='img-rounded user-img'>
              </div>
              <div class='col-lg-11'>
                <div class='row'>
                  <div class='panel panel-info'>
                    <div class='panel-heading'>
                      <h3 class='panel-title'>
                        <b>" . $post['surname'] . " " . $post['name'] . "</b>
                      </h3>
                    </div>
                    <div class='panel-body'>
                      <h3> ". $post['description'] . " </h3>
                    </div>
                    <div class='panel-footer'>
                      <span class='glyphicon glyphicon-heart-empty 
                      like'></span>
                      <span class='glyphicon glyphicon-comment comm' 
                            data-id='" . $post['post_id'] ."'>
                      </span>
                      <span class='glyphicon glyphicon-plus pull-right 
                                   reblog'>
                      </span>
                    </div>
          ";

          #LOAD COMMENTS OF THE CURRENT POST
          $comments = $data->getComments($post['post_id']);         
          
          echo "
            <div id='all-comments" . $post['post_id'] . "' 
                 style='display: none'
            >
          ";

          #CHECK IF THERE ARE COMMENTS AND PRINT THEM
          if ($comments->num_rows !== 0) { 

            #PRINT COMMENTS OF THE POST
            while($comment = $comments->fetch_assoc()) {
              printCommentCode(
                $comment['name'], 
                $comment['surname'], 
                $comment['description'], 
                $comment['sharing_date']
              );
            }
          }
          echo "</div>"; #close <div class='all-comments'...>
          
          echo " 
            <div id='write-comment" . $post['post_id'] . "' 
                 style='display: none'
            >
              <div class='panel-body'>
                <form class='comment-form' action='' method='post'>
                  <textarea class='
                    form-control 
                    elastic-box 
                    insert-comment" . $post['post_id'] . "
                  ' 
                  style='resize: none' rows='2' name='comment'  
                  placeholder='Insert a comment...'></textarea>
                  
                  <input type='text' name='post' class='hidden'
                  value=" . $post['post_id'] . " />

                  <button type='button' 
                          class='btn btn-defaul btn-xs' 
                          style='margin-top:2px;' 
                          data-id='" . $post['post_id'] . "'
                  >Comment</button>
                </form>
              </div>
            </div>
          ";

          echo "
              </div>
            </div>
          ";
          
          echo "     
              </div>
            </div>
          ";
        }
      ?>
    </div>
  </div>
  
  <!-- A div for storing a codesample of a general comment --> 
  <div class='hidden codesample '>
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
  </script>

  <script src="js/myjs.js"></script>
</body>
</html> 

