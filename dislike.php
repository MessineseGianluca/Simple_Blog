<?php 

  include 'php_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $data->dislike($_POST['post_id']);

