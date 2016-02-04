<?php
  ############################### AN EXAMPLE OF PASSWORD HASHING##############
  function cryptPass($pass, $rounds = 10) {
  
    $salt = '';
    #merge all elements into the same array. It contains all the possible
    #characters that could be used to generate a random salt
    $saltChars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    
    #generate a random salt of 22 characters
    for($i = 0; $i < 22; $i++) {
      #array_rand chose a random index and takes the corrispent element
      $salt .= $saltChars[array_rand($saltChars)];
    }
  
    return crypt($pass, sprintf('$2y$%02d$', $rounds) . $salt);
  }
 
  $input_pass = "dog";

  $pass = "dog";

  $hashed_pass = cryptPass($pass); 
  echo $hashed_pass;
  if(crypt($input_pass, $hashed_pass) == $hashed_pass) {
    echo "Passwords match";
  }

  else {
    echo "Passwords don't match";
  }