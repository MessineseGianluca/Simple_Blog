<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->addComment();
  $data->disconnectMysql();
  //header("location: index.php");

