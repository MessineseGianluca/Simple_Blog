$('.elastic-box').elastic();

$('#add').click(function() {

  $('#add-post').css('display', 'block');
});

$('#insert-post').keyup(function() {
  if($('#insert-post').val() !== '')
    $('#submit').css('display', 'block');
  else 
    $('#submit').css('display', 'none');
});


//When the page is fully loaded
$( document ).ready(function() {
  //When the comment button is click
  $('.comment-form button').click( function() {
    post($(this).attr("data-id"));
  });

});


function post(postId) {

  //Date in SQL format 
  var date = new Date();
  date = date.getUTCFullYear() + '-' +
    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
    ('00' + date.getUTCDate()).slice(-2) + ' ' + 
    ('00' + date.getUTCHours()).slice(-2) + ':' + 
    ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
    ('00' + date.getUTCSeconds()).slice(-2);

  //comment inserted
  var comment = $(".insert-comment" + postId).val();
  //name of the commentator
  var name = lastname + " " + firstname;
  
   $(".codesample .username").text(name);
   $(".codesample .date").text(date);
   $(".codesample .comment").text(comment);
  //codesample of a comment
  var commentCode = $(".codesample").html();

  /*$(commentCode).find(".username").text(name);
  $(commentCode).find(".date").text(Date());
  $(commentCode).find(".comment").text(comment);
  */
  comment_post = $("#" + postId).html() + commentCode;
  
  if(comment)
  {
    //open an ajax comunication with comment.php
    //and send him comment, postId. If success, 
    //executes the function 
    $.ajax
    ({
      type: 'post',
      url: 'comment.php',
      data: {
        comment: comment,
        post: postId
      },
      success: function() {
        
        $("#" + postId).html( comment_post );
        $(".insert-comment" + postId).val("");
      }
    });
  }

  return false;
}
