<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  echo $data->findLastPostId();
  $data->disconnectMysql();


