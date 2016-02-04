<?php
  include 'php_functions.php';

  $_SESSION['login_message'] = '';
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  
  $data = new MysqlConnector();
  $data->connectMysql();
  
  #if authenticated
  if($data->logIn($email, $pass)) {
    header("location: index.php");
    exit;
  }
  
  #else come back to login.html  
  $data->disconnectMysql();
  $_SESSION['login_message'] = "Invalid input.";
  header("location: login.php");

