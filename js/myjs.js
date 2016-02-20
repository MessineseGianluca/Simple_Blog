$('.elastic-box').elastic();

//When the page is fully loaded
$( document ).ready(function() {
  //When the comment button is click
  $('.comment-form button').click( function() {
    postComment($(this).attr("data-id"));
  });

  $('.post-submit').click(function() {
    postNewPost(parseInt($(this).attr("dataNextPostId")) + 1);
  })

  $('.text-post').keyup(function() {
    if($('.text-post').val() !== '')
      $('.post-submit').css('display', 'block');
    else 
      $('.post-submit').css('display', 'none');
  });

  $('.comm').click(function() {
    postId = $(this).attr("data-id");
    status = $('#write-comment' + postId).css('display');
    alert("memt")
    if(status === "none" ) {
      $('#all-comments' + postId).css('display', 'block');
      $('#write-comment' + postId).css('display', 'block');
    }
    else {
      $('#all-comments' + postId).css('display', 'none');
      $('#write-comment' + postId).css('display', 'none');
    }
  });

});


function postNewPost(postId) {

  var description = $('.text-post').val();
  var name = lastname + " " + firstname;

  $('.postCodeSample .post-box').toggleClass("post-box post-box" + postId);
  $('.postCodeSample .author').html("<b>" + name + "</b>");
  $('.postCodeSample .text').html("<h3> " + description + "</h3>");
  $('.postCodeSample .comm').attr("data-id", postId);
  $('.postCodeSample #all-comments').attr("id", "all-comments" + postId);
  $('.postCodeSample #write-comment').attr("id", "write-comment" + postId);
  $('.postCodeSample .insert-comment').toggleClass("insert-comment insert-comment" + postId);
  $('.postCodeSample .comment-button').attr("data-id", postId);

  var postCode = $(".postCodeSample").html();
  
  var posts = postCode + $(".posts-container").html();

  if(description)
  {
    $.ajax
    ({
      type: 'post',
      url: 'post.php',
      data: {
        description: description,
      },
      success: function() {
        
        $(".posts-container").html( posts );
        $(".text-post").val("");
        $(".post-submit").attr("dataNextPostId", postId);
      }
    });
  }

}

function postComment(postId) {

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
  
  $(".commentCodeSample .username").text(name);
  $(".commentCodeSample .date").text(date);
  $(".commentCodeSample .comment").text(comment);

  //codesample of a comment
  var commentCode = $(".commentCodeSample").html();

  var comments = $("#all-comments" + postId).html() + commentCode;
  
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
        
        $("#all-comments" + postId).html( comments );
        $(".insert-comment" + postId).val("");
      }
    });
  }
}
