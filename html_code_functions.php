<?php
  
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

  function printPostCode($user_id, $name, $surname, $description, $post_id) {
 	  
    //find the img of the post's author
    if(file_exists('img/' . $user_id)) $img_name = $user_id;
    else $img_name = "user";

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
                  <span class='text-muted'>commented on</span>
                </div>
              </div>
          </div><!-- /panel-heading -->
          <div class='panel-body text'>
            <h3 class='text'>" . $description . "</h3>
          </div><!-- /panel-body -->
          <div class='panel-footer'>
            <button class='like'>
              <span class='glyphicon glyphicon-heart-empty'></span>
            </button>
            <button class='comm'>
              <span class='glyphicon glyphicon-comment'></span>
            </button>
            <button class='reblog pull-right'>
              <span class='glyphicon glyphicon-plus'></span>
            </button>
    ";

          
    $data = new MysqlConnector();
  
    $data->connectMysql();

    #LOAD COMMENTS OF THE CURRENT POST
    $comments = $data->getComments($post_id);         
          
    echo "
      <div class='all-comments'>
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

    $data->disconnectMysql();

    echo "</div>"; #close /all-comments
          
    echo " 
      <div class='write-comment' 
           style='display: none'
      >
        <div class='panel-body'>
          <form class='comment-form' action='' method='post'>
            <textarea class='form-control elastic-box 
                             insert-comment' 
                      style='resize: none' rows='2' name='comment'  
                      placeholder='Insert a comment...'></textarea>

            <button type='button' 
                    class='btn btn-default btn-xs comment-button' 
            > <span class='glyphicon glyphicon-pencil'></span> Comment </button>
          </form>
        </div>
      </div>
    ";

    echo "
      </div><!-- /panel-footer -->
    </div><!-- /panel -->
    ";
          
    echo "     
      </div><!-- col-lg-5 col-xs-12 -->
    </div><!-- /row -->
    ";
  }