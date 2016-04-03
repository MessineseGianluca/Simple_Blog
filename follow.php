<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->follow($_POST['user_to_follow']);
  $data->disconnectMysql();
  http_response_code(201);

