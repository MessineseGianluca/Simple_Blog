<?php
  session_start();
  include 'php_functions.php';
  
  $_SESSION['signup_message'] = '';

  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $pass = $_POST['pass'];
  $pass2 = $_POST['pass2'];
  $email = $_POST['email'];
  
  if($pass2 !== $pass) {
    $_SESSION['signup_message'] = "Please insert equal passwords.";
    header('Location: signup.php');
    exit;
  }
  
  else {
    $data = new MysqlConnector();
    $data->connectMysql();
    
    if($data->isRegistred($email)) {
      $_SESSION['signup_message'] = "Email already exists.";
      header('Location: signup.php');
      exit;
    }
    
    $pass = cryptPass($pass);
    
    $user_id = $data->signUp($email, $pass, $name, $surname);
  
    $data->disconnectMysql();
    
    $img_name = $_FILES['imgToUpdate']['name'];
    if($img_name == "") echo "failed";
    else move_uploaded_file($_FILES['imgToUpdate']['tmp_name'], 'img/' . $user_id);
    
    header('Location: login.php');
  }

