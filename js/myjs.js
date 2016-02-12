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
      alert("entrato");
    post($(this).attr("data-id"));
  });

});


function post(postId) {
  
  var comment = $("." + "insert-comment" + postId).val();
  console.log(comment);
  /* 
  var name = firstname + " " + lastname;
  var commentCode = $(".codesample").html();
  
  $(commentCode).find(".username").text(name);
  $(commentCode).find(".date").text(Date());
  $(commentCode).find(".comment").text(comment);

  comment_post = $("#" + postId).html() + commentCode;
  
  if(comment)
  {
    alert("entrato");
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
        alert(postId);
        $(".insert-comment").val("");
  
      }
    });
  }*/
  return false;
}
