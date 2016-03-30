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

  function printPostCode($name, $surname, $description, $post_id) {
 	
    echo "
      <div class='post-box row' id=" . $post_id . ">
        <div class='col-lg-1 col-xs-1' style='padding: 0'>   
          <img src='img/user.jpg' class='img-rounded user-img'>
        </div>
        <div class='col-lg-11 col-xs-11'>
          <div class='row'>
            <div class='panel panel-info'>

              <div class='panel-heading'>
                <h3 class='panel-title author'>
                  <b>" . $surname . " " . $name . "</b>
                </h3>
              </div>

              <div class='panel-body text'>
                <h3> ". $description . " </h3>
              </div>

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
              </div>
    ";

          
    $data = new MysqlConnector();
  
    $data->connectMysql();

    #LOAD COMMENTS OF THE CURRENT POST
    $comments = $data->getComments($post_id);         
          
    echo "
      <div class='all-comments' 
           style='display: none'>
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

    echo "</div>"; #close <div class='all-comments'...>
          
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
                  class='btn btn-defaul btn-xs comment-button' 
                  style='margin-top:2px;' 
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