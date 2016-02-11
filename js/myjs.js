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



$( document ).ready(function() {

  $('.comment-form button').click( function() {
      post($(this).attr("data-id"));
  });

});


function post(postId)
{
  var comment = $(".insert-comment").val();
  var name = firstname + " " + lastname;
  var commentCode = $(".codesample").html();
  
  $(commentCode).find(".username").html(name);
  $(commentCode).find(".date").html(Date());
  $(commentCode).find(".comment").html(comment);
  
  //add comment and data
  comment_post = $("#" + postId).html() + commentCode;
  
  if(comment)
  {
    $.ajax
    ({
      type: 'post',
      url: 'comment.php',
      data: 
      {
        comment: comment,
        post: postId
      },
      success: function (response) 
      {
        
        $("#" + postId).html( comment_post );
        $("#commentarea").val("");
  
      }
    });
  }
  return false;
}
