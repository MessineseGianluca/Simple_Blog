<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  
  $data->connectMysql();
  
  $data->addPost($_POST['description']);
  
  $data->disconnectMysql();
  header("location: index.php");
?>