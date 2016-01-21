<?php
  include 'php_functions.php';

  $pass = $_POST['pass'];
  $email = $_POST['email'];
  
  $data = new MysqlConnector();
  $data->connectMysql();
  /*
  if($data->login($email, $pass) === TRUE) {
    
  } */ 
  $data->disconnectMysql();
?>