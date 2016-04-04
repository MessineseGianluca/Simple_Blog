<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  echo $data->findLastPostId();
  $data->disconnectMysql();
  http_response_code(200);

