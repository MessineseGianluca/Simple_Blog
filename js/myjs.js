$('.elastic-box').elastic();

//When the page is fully loaded
$( document ).ready(function() {
  //When the comment button is click
  $('.text-post').keyup(function() {
    if($('.text-post').val() !== '')
      $('.post-submit').css('display', 'block');
    else 
      $('.post-submit').css('display', 'none');
  });
  
  prepare();

});


function prepare() {
  $('.comment-form button').click(function() {
    postComment($(this).parents('.post-box').attr("id"));
  });

  $('.post-submit').click(function() {
    newPostId = parseInt($(this).attr("dataNextPostId")) + 1;
    userId = parseInt($(this).attr("dataAuthorId"));
    postNewPost(newPostId, userId);
  });

  $('.post-box .comm').click(function() {
    postId = $(this).parents(".post-box").attr("id");
    status = $('#' + postId ).find('.write-comment').css('display');
    if(status === "none" ) {
      $('#' + postId).find('.all-comments').css('display', 'block');
      $('#' + postId).find('.write-comment').css('display', 'block');
    }
    else {
      $('#' + postId).find('.all-comments').css('display', 'none');
      $('#' + postId).find('.write-comment').css('display', 'none');
    }
  });

}


function postNewPost(postId, userId) {

  var description = $('.text-post').val();
  var name = lastname + " " + firstname;

  $('.postCodeSample .post-box').attr("id", postId);
  $('.postCodeSample .author').html("<b>" + name + "</b>");
  $('.postCodeSample .text').html("<h3> " + description + "</h3>");
  $('.postCodeSample .user-img').attr("src", "img/" + userId);

  var postCode = $(".postCodeSample").html();

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
        $(".posts-container").prepend(postCode);
        $(".text-post").val("");
        $(".post-submit").attr("dataNextPostId", postId);
        prepare();
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
  var comment = $('#' + postId).find(".insert-comment").val();
  //name of the commentator
  var name = lastname + " " + firstname;
  
  $(".commentCodeSample .username").text(name);
  $(".commentCodeSample .date").text(date);
  $(".commentCodeSample .comment").text(comment);

  //codesample of a comment
  var commentCode = $(".commentCodeSample").html();

  var comments = $('#' + postId).find(".all-comments").html() + commentCode;
  
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
        
        $('#' + postId).find(".all-comments").html( comments );
        $('#' + postId).find(".insert-comment").val("");
      }
    });
  }
}
