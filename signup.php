<?php
  include 'php_functions.php';
  
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  
  $data = new MysqlConnector();
  $data->connectMysql();
  
  $data->signUp($email, $pass, $name, $surname);
  
  $data->disconnectMysql();
  header('Location: login.html');


