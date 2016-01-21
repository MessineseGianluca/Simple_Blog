<?php
  session_start();
  include 'php_functions.php';
  #Create an object for the dbms handlings
  if(!$_SESSION['authenticated'])
  {
    header("Location: login.html");
    exit;
  }
  echo "Benvenuto " . $_SESSION['name']. ' ' . $_SESSION['surname'];
  
   // remove all session variables
   #session_unset(); 

  // destroy the session 
  #session_destroy(); 
?> 

