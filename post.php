<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  
  $data->connectMysql();
  
  $data->addPost();
  
  $data->disconnectMysql();
 
  http_response_code(201);

