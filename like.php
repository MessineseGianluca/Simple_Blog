<?php 

  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->like($_POST['post_id']);
  http_response_code(201);

