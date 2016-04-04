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

  $('.search').keyup(function() {
    text = $('.search').val();
    if(text !== '') {
      searchContent(text);
    }
    else { 
      $('.search-result').html("");
      if($('.search-result').css("display") === 'block')
        $('.dropdown-search').trigger("click");
    }
  });
  
  //When user shares a post
  $('.post-submit').click(function() {
    assignNewPostIdAndShareIt();
  });

  /******************** DELEGATED EVENTS ************************/
  /*WHEN YOU ADD ELEMENTS DINAMICALLY, NORMAL EVENTS DON'WORK    |
  /*WITH THEM. THIS IS A SMART WAY TO DO IT INSTEAD OF prepare() |
  /*FUNCTION.                                                    |
  /**************************************************************/

  //When user share a comment
  $('.posts-container').on(
    //event
    'click',
    //selector
    '.post-box .col-lg-12 .panel ' + 
    '.panel-footer .write-comment ' + 
    '.panel-body .comment-form button',
    //handler 
    function() {
      postId = $(this).parents('.post-box').attr("id");
      postComment(postId);
    }
  );

  $('.posts-container').on(
    'click', 
    '.post-box .col-lg-12 .panel .panel-footer .like span',
    function() {
      postId = $(this).parents('.post-box').attr("id");
      if($(this).hasClass("glyphicon-heart-empty"))
        like(postId);
      else 
        dislike(postId);
    }
  );
  
  $('.posts-container').on(
    'click', 
    '.post-box .col-lg-12 .panel .panel-footer .comm',
    function() {
      postId = $(this).parents(".post-box").attr("id");

      status = $('#' + postId ).find('.all-comments').css('display');
      if(status === "none" ) 
        $('#' + postId).find('.all-comments').css('display', 'block');
      else 
        $('#' + postId).find('.all-comments').css('display', 'none');  
    }
  );

  $('.search-result').on('click', 'li .follow', function() {
    
    userToFollow = $(this).attr("data-id");
    followUser(userToFollow);
  });
  
  $('.search-result').on('click', 'li .unfollow', function() {
    
    userToUnfollow = $(this).attr("data-id");
    unfollowUser(userToUnfollow);
  });
  /***********************************************************/
});

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

function searchContent(text) {
  $(".search-result").html();
  $.ajax({
    type: "POST",
    url: "search_users.php",
    data: {text: text},
    cache: false,
    success: function(html)
    { 
      $(".search-result").html(html);
      if($('.search-result').css("display") !== 'block')
        $(".dropdown-search").trigger("click");
        $('.search').focus();
      if($('.search-result').html() == "") {
        $(".search-result").append(
          "<li><strong> Result not found...<strong></li>"
        );
      }
    }
  });
  
}

function followUser(userToFollow) {

  $.ajax({
    type: "POST",
    url: "follow.php",
    data: {user_to_follow: userToFollow},
    success: function()
    {  
      alert("Followed.");
    }
  });
}

function unfollowUser(userToUnfollow) {

  $.ajax({
    type: "POST",
    url: "unfollow.php",
    data: {user_to_unfollow: userToUnfollow},
    success: function()
    {  
      alert("Unfollowed.");
    }
  });
} 

function  assignNewPostIdAndShareIt() {
  $.ajax({
    type: "POST",
    url: "assign_new_post_id.php",
    success: function(newId)
    { 
      postNewPost(newId);
    }
  });
  
}

function like(postId) {
  $.ajax({
    type: "POST",
    url: "like.php",
    data: {post_id: postId},
    success: function()
    { 
      $("#" + postId)
        .find(".like .glyphicon-heart-empty")
        .removeClass('glyphicon-heart-empty')
        .addClass('glyphicon-heart');

      //update number of likes  
      updatedNumOfLikes = parseInt($("#" + postId).find('.num').text()) + 1;
      $("#" + postId).find('.num').text(updatedNumOfLikes);
    }
  });
}

function dislike(postId) {
  $.ajax({
    type: "POST",
    url: "dislike.php",
    data: {post_id: postId},
    success: function()
    { 
      $("#" + postId)
        .find(".like .glyphicon-heart")
        .removeClass('glyphicon-heart')
        .addClass('glyphicon-heart-empty');
      
      //update number of likes  
      updatedNumOfLikes = parseInt($("#" + postId).find('.num').text()) - 1;
      $("#" + postId).find('.num').text(updatedNumOfLikes);
    }
  });
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
