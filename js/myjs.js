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
  //When user share a comment
  $('.comment-form button').click(function() {
    postId = $(this).parents('.post-box').attr("id");
    postComment(postId);
  });

  //When user shares a post
  $('.post-submit').click(function() {
    newPostId = parseInt($(this).attr("dataNextPostId")) + 1;
    postNewPost(newPostId);
  });


  $('.comm').click(function() {
    postId = $(this).parents(".post-box").attr("id");
    status = $('#' + postId ).find('.all-comments').css('display');
    if(status === "none" ) 
      $('#' + postId).find('.all-comments').css('display', 'block');
    else 
      $('#' + postId).find('.all-comments').css('display', 'none');  
  });
}


function postNewPost(postId) {

  var description = $('.text-post').val();
  var name = lastname + " " + firstname;

  $('.postCodeSample .post-box').attr("id", postId);
  $('.postCodeSample .author').html("<b>" + name + "</b>");
  $('.postCodeSample .text').html("<h3> " + description + "</h3>");
  $(".postCodeSample .date").text(getSqlFormatDate());
  $('.postCodeSample .user-img').attr("src", img);
  
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

  //comment inserted
  var comment = $('#' + postId).find(".insert-comment").val();
  //name of the commentator
  var name = lastname + " " + firstname;
  
  $(".commentCodeSample .username").text(name);
  $(".commentCodeSample .date").text(getSqlFormatDate());
  $(".commentCodeSample .comment").text(comment);
  $('.commentCodeSample .user-comm-img').attr("src", img);

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
        $('#' + postId).find('.all-comments').css('display', 'block');
        $('#' + postId).find('.all-comments').html( comments );
        $('#' + postId).find('.insert-comment').val('');
      }
    });
  }
}

function getSqlFormatDate() {
  //Date in SQL format 
  var date = new Date();
  return date.getUTCFullYear() + '-' +
    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
    ('00' + date.getUTCDate()).slice(-2) + ' ' + 
    ('00' + date.getUTCHours()).slice(-2) + ':' + 
    ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
    ('00' + date.getUTCSeconds()).slice(-2);
}
