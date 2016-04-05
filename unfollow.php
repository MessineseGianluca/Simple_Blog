<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->unfollow($_POST['user_to_unfollow']);
  $data->disconnectMysql();
