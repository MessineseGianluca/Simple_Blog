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
