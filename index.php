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
  <!-- Contain all -->
  <div class='container'>
    
    <!-- PAGE HEADER -->
    <div class='page-header'>
      <h1><b> My Simple Blog </b></h1>
    </div>
    
    <!-- USER PANEL AND ADD-POST PANEL -->
    <div class='row'>
      <!-- Icons for adding posts -->
      <div class="col-lg-8 col-md-8">  
        <!-- A panel who contains items for insert new post-->
        <img class='adder-img' src='img/add.png' id='add'>
        <img class='adder-img' src='img/add-picture.png'>
      </div> 
      <!-- User panel -->
      <div class='col-lg-4 col-md-4 user-panel'> 
        <div class='row'>
          <div class='col-lg-2 col-md-2'>
            <img src='img/user.jpg' class='img-rounded user-img'>
          </div>
          
          <div class='col-lg-8 col-md-8' >
            <p class='user'>
              <?php 
                echo $_SESSION['surname'] . " " . $_SESSION['name'] ; 
              ?>
            </p>
          </div>

          <div class='dropdown col-lg-2 col-md-2'>
            <button class='btn btn-default dropdown-toggle' type='button' 
            data-toggle='dropdown'>
              <span class='caret'></span>
            </button>
            <ul class='dropdown-menu dropdown-menu-right' >
              <li><a tabindex='-1' href='logout.php'>Log out</a></li>
            </ul>
          </div>
        </div>
      </div>     
    </div>
    
    <!-- A row for new posts -->
    <div class='row'style='margin-bottom: 20px;'>
      <div class="form-group col-lg-8 col-md-8" id='add-post'>
        <form action='post.php' method='post'>
          <label style='color:white'>New post:</label>
          <textarea class='form-control shadow elastic-box' style='resize: none' 
          rows='2' name='description' id='insert-post' 
          placeholder='Insert some text...'></textarea>
          
          <input style='float:right;margin-top:5px;' type='submit' value='Share'
          class='btn btn-defaul submit' id='submit'>
        </form>
      </div>  
    </div>
    
    <!-- Container of Posts -->
    <div class='row'>
      <div class='col-lg-8 col-md-8'> 
        <?php
          #LOAD ALL POSTS
          $result = $data->getPosts();
          
          #A FUNCTION FOR PRINTING A COMMENT
          function printCommentCode($name, $surname, $comment, $comment_date) { 
            echo "
              <div class='row shadow comment-box'>
                <div class='row'>
                  
                  <div class='col-lg-1 col-md-1'>
                    <img src='img/user.jpg' class='img-rounded comment-img'>
                  </div>
                    
                  <div class='col-lg-7 col-md-7 nopadding'>
                    <h4 class='nopadding username'>
                      " . $surname . " " . $name . " 
                    </h4>
                  </div>
                    
                  <div class='col-lg-4 col-md-4'>
                    <p class='date' style='font-size: 9px; 
                    margin: 2px; float: right'>
                      " . $comment_date . "
                    </p>
                  </div>
                </div>
                    
                <div class='row'>
                  <div class='col-lg-12 col-md-12'>
                    <h5 class='comment'>" . $comment . "</h5>
                  </div>
                </div>
              </div>
            ";
          } 
          
          #PRINT EACH LOADED POST WITH ITS COMMENTS
          while($post = $result->fetch_assoc()) {
            #LOAD COMMENTS OF THE CURRENT POST
            $comments = $data->getComments($post['post_id']);  
            echo "
              <div class='row' style='margin-left:10%; margin-bottom: 5%;'>
                
                <div class='row'>
                  <div class='col-lg-12 col-md-12'>
                    <img src='img/user.jpg' class='img-rounded user-img'>
                    <p class='user' style='display: inline-block'> 
                      " . $post['surname'] . " " . $post['name'] . "
                    </p>
                    <p class='timestamp'><b>" .$post['sharing_date']. "</b></p>
                    <div class='description shadow '> 
                      <p>". $post['description'] . "</p>
                    </div>
                  </div>
                </div>
            ";
            
            #CHECK IF THERE ARE COMMENTS AND PRINT THEM
            if ($comments->num_rows !== 0) {
              echo "
                <div class = 'jumbotron row' id='" . $post['post_id'] . "'
                style='padding: 0 7% 3% 7%; margin: 2px 0px'> 
                
                  <div class='row'>
                    <div class='col-12-lg col-12-md nopadding'>
                      <p class='nopadding'> <b> Comments: </b></p>
                    </div>
                  </div>
              ";
              #PRINT COMMENTS OF THE POST
              while($comment = $comments->fetch_assoc()) {
                printCommentCode(
                  $_SESSION['name'], 
                  $_SESSION['surname'], 
                  $comment['description'], 
                  $comment['sharing_date']
                );
              }
              #CLOSE JUMBOTRON
              echo "</div>";
            }
            
            #CREATE AN ADD-COMMENT PANEL
            echo "
              <div class='row'>
                <div class='col-lg-2 col-md-2 nopadding' 
                style='float: right !important'>
                  <img src='img/user.jpg' class='img-rounded user-img' 
                  style='display: inline'>
                </div>
              
                <div class='col-lg-10 col-md-10'>
                  <form class='comment-form' action='' method='post' >
                    <textarea name='comment' rows='1' maxlength='255'
                    class='
                      form-control 
                      elastic-box 
                      insert-comment" . $post['post_id'] . "
                    ' 
                    placeholder='Insert a comment (max 255) ...'></textarea>

                    <input type='text' name='post' style='display:none'
                    value=" . $post['post_id'] . " />

                    <button type='button' class='btn btn-defaul btn-xs' 
                    style='margin-top:2px;' data-id='" . $post['post_id'] . "'>
                      Comment
                    </button>
                  </form>
                </div>
              </div>
            
            </div>         
            ";
          }
        ?>
      </div>
    </div>
  </div>
  
  <!-- A div for storing a code sample of comment to print --> 
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
    userId = "<?php echo $_SESSION['id']; ?>";
  </script>

  <script src="js/myjs.js"></script>
</body>
</html> 

