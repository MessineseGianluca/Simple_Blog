<?php
  
  #A FUNCTION FOR PRINTING A COMMENT
  function printCommentCode(
    $user_id, 
    $name, 
    $surname, 
    $comment, 
    $comment_date
  ) {

    $img_name = getImg($user_id);
    echo "
      <div class='panel-body comment-box row' style='border-bottom: 1px;'>
        
        <div class='col-lg-1 col-xs-2'>
          <img class='img-rounded user-comm-img img-container' 
               src='img/" . $img_name . "' >
        </div>
        <div class='col-lg-11 col-xs-10'>
          <strong class='username'>" . $surname . " " . $name . "</strong>
          <span class='text-muted'>
            commented on: <span class='date'>" . $comment_date . "</span>
          </span>
          <h4 class='comment'>" . $comment . "</h4>
        </div>
      </div>
    "; 
  } 

  function printPostCode(
    $user_id, 
    $name, 
    $surname, 
    $description, 
    $post_id,
    $sharing_date
  ) {
    $img_name = getImg($user_id);
    echo "
      <div class='row post-box' id=" . $post_id . ">
        <div class='col-lg-12 col-xs-12'>
          <div class='panel'>
            <div class='panel-heading'>
              <div class='row'>
                <div class='col-lg-1 col-xs-2 img-container'>
                  <img class='img-rounded user-img' 
                       src='img/" . $img_name . "' >
                </div>
                <div class='col-lg-11 col-xs-10'>
                  <strong class='author'>" . $surname . " " . $name . "</strong>
                  <br> 
                  <span class='text-muted date'>
                    posted on: " . $sharing_date . 
                  "</span>
                </div>
              </div>
          </div><!-- /panel-heading -->
          <div class='panel-body text'>
            <h3 class='text'>" . $description . "</h3>
          </div><!-- /panel-body -->
          <div class='panel-footer'>
            <button class='like'>
              <span class='glyphicon glyphicon-heart-empty'></span>
              <strong>likes</strong>
            </button>
            <button class='comm'>
              <span class='glyphicon glyphicon-comment'></span>
              <strong>comments</strong>
            </button>
            <button class='reblog pull-right'>
              <span class='glyphicon glyphicon-plus'></span>
            </button>
    ";
          
    echo " 
      <div class='write-comment'>
        <div class='panel-body'>
          <form class='comment-form' action='' method='post'>
            <textarea class='form-control elastic-box 
                             insert-comment' 
                      style='resize: none;' 
                      rows='2' name='comment'  
                      placeholder='Insert a comment...'></textarea>

            <button type='button' 
                    class='btn btn-default btn-xs comment-button pull-right' 
            > <span class='glyphicon glyphicon-pencil'></span> Comment </button>
          </form>
        </div>
      </div>
    ";
          
    $data = new MysqlConnector();
  
    $data->connectMysql();

    #LOAD COMMENTS OF THE CURRENT POST
    $comments = $data->getComments($post_id);         
          
    echo "<div class='all-comments'>";

    #CHECK IF THERE ARE COMMENTS AND PRINT THEM
    if ($comments->num_rows !== 0) { 

      #PRINT COMMENTS OF THE POST
      while($comment = $comments->fetch_assoc()) {
        printCommentCode(
          $comment['user_id'],
          $comment['name'], 
          $comment['surname'], 
          $comment['description'], 
          $comment['sharing_date']
        );
      }

    }

    $data->disconnectMysql();

    echo "</div>"; #close /all-comments
    echo "
      </div><!-- /panel-footer -->
    </div><!-- /panel -->
    ";
          
    echo "     
      </div><!-- col-lg-5 col-xs-12 -->
    </div><!-- /row -->
    ";
  }
  
  function printUserRow($user) {
    echo "
      <li>
       <img class='user-img img-rounded' 
            src='img/" . getImg($user['user_id']) . "'>           
        <strong>" . $user['surname'] . "<strong>
        <strong>" . $user['name'] . "</strong>
    ";

    if($user['follow']) 
      echo "
        <button class='follow pull-right btn btn-success' 
          type=button> 
          Follow 
        </button>
      ";

    else 
       echo "
        <button class='unfollow pull-right btn btn-warning' 
          type=button> 
          Unfollow 
        </button>
      ";
  }


  function getImg($user_id) {   
    //find the img of the post's author
    if(file_exists('img/' . $user_id)) return $user_id;
    return "user";
  }