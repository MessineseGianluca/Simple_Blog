<?php
  include 'php_functions.php';
  
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->connection->query('
      INSERT INTO Users(email, password, name, surname)
      VALUES(' 
        . $email . ','
        . $pass . ','
        . $name . ','
        . $surname 
        . '
      );
  ') or die($data->connection->error);
  
  $data->disconnectMysql();
?>

