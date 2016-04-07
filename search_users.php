<?php
  include 'php_functions.php';
  include 'html_code_functions.php';
  
  $data = new MysqlConnector();
  $data->connectMysql();
  $users = $data->getUsers($_POST['text']);
  $followed_users = $data->getFollowedUsers();
  $data->disconnectMysql();
  
  while($followed = $followed_users->fetch_assoc()) {     
    $followed_list[] = $followed;
  }

  while($user = $users->fetch_assoc()) {     
    $user['follow'] = 1;
    foreach ($followed_list as $followed) {
    	if($user['user_id'] === $followed['followed_id']) {
    		$user['follow'] = 0;
    	} 
    }

    printUserRow($user);
  }

