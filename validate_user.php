<?php
  include 'php_functions.php';

  $pass = $_POST['pass'];
  $email = $_POST['email'];
  
  $data = new MysqlConnector();
  $data->connectMysql();
  
  #if authenticated
  if($data->logIn($email, $pass) === TRUE) {
    header("location: index.php");
    exit;
  }
  
  #else come back to login.html  
  $data->disconnectMysql();
  header("location: login.html");

