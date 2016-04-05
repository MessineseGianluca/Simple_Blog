/*************** JS CODE USED FOR SIGN-UP and LOGIN ********/

$(".upload-btn").click(function () {
  $(".upload-input").trigger('click');
});


  
$('.form-signup').submit(function(event){
  event.preventDefault();    
    
  var name = $('.name').val();
  var surname = $('.surname').val();
  var pass = $('.password').val();
  var pass2 = $('.password2').val();
  var email = $('.email').val();
  
  $.ajax({
    type: "POST",
    url: "validate_new_user.php",
    data: {
      name: name,
      surname: surname,
      pass: pass,
      pass2: pass2,
      email: email
    },
    success: function(msg)
    { 
       if(msg !== "Successfully registered.") {
         $('.errors').html("<p style='color:red'>" + msg + "</p>");
       }
       else $('.login').trigger('click');
    }
  });
});