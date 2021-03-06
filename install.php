<?php
  include 'php_functions.php';

  ####################################FUNCTIONS#############################
  
  #CREATE an array which will contain the SQL statements for deleting tables
  #and RETURN the string that we need.
  #Note: SQL can carry on only one statement for time. This is the reason why
  #      we have to call this function for each Stetement.
  function deleteTables($n_statement) {
      
    $dropper = array(
        'DROP TABLE Followings;',
        'DROP TABLE Likes;', 
        'DROP TABLE Comments;',
        'DROP TABLE Posts;',
        'DROP TABLE Users;'
    );
    
    return $dropper[$n_statement]; 
  }      
  
  
  #CREATE an array which will contain the SQL statements for creating tables
  #and RETURN the string that we need.
  #Note: SQL can carry on only one statement for time. This is the reason why
  #      we have to call this function for each Stetement.
  function addTables($n_statement) {
  
    $creator = array (
        'CREATE TABLE Users (
          user_id SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
          email VARCHAR(30) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          signing_up_date TIMESTAMP,
          name VARCHAR(20) NOT NULL,
          surname VARCHAR(20) NOT NULL,
          img_url varchar(100));
        ' ,
        'CREATE TABLE Posts (
          post_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
          description TEXT NOT NULL,
          sharing_date TIMESTAMP,
          user_id SMALLINT UNSIGNED NOT NULL,
          FOREIGN KEY(user_id) REFERENCES Users(user_id), 
          img_url varchar(100));
        ' ,
        'CREATE TABLE Comments (
          comment_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
          description VARCHAR(255) NOT NULL,
          sharing_date TIMESTAMP,
          user_id SMALLINT UNSIGNED NOT NULL,
          post_id INT UNSIGNED NOT NULL,
          FOREIGN KEY(user_id) REFERENCES Users(user_id),
          FOREIGN KEY(post_id) REFERENCES Posts(post_id) );
        ' ,
        'CREATE TABLE Followings (
          follower_id SMALLINT UNSIGNED NOT NULL,
          followed_id SMALLINT UNSIGNED NOT NULL,
          PRIMARY KEY(follower_id, followed_id),
          FOREIGN KEY(follower_id) REFERENCES Users(user_id),
          FOREIGN KEY(followed_id) REFERENCES Users(user_id) );
        ' ,
        'CREATE TABLE Likes (
           post_id INT UNSIGNED NOT NULL,
           user_id SMALLINT UNSIGNED NOT NULL,
           PRIMARY KEY(post_id, user_id),
           FOREIGN KEY(post_id) REFERENCES Posts(post_id),
           FOREIGN KEY(user_id) REFERENCES Users(user_id) 
         );
        '
    );
    
    return $creator[$n_statement];
  }
   
   
  #####################Calls methods########################
     
  #Create Mysql object 
  $installer = new MysqlConnector();
  
  #Connect to mysql
  $installer->connectMysql();
 
  #Uninstall old tables
  for($i = 0; $i < 5; $i++) {  
    if($installer->connection->query(deleteTables($i)) === TRUE) {
      echo "Deleted <br>";    
    }
    else {
      echo $installer->connection->error. '<br>';
    }
  }
  
  #Install new tables 
  for($i = 0; $i < 5; $i++) {
    if($installer->connection->query(addTables($i)) === TRUE) {
      echo "Created <br>";
    }
    else {
      echo $installer->connection->error . '<br>';
    }
  }
  
  #Disconnect from Mysql
  $installer->disconnectMysql();
 

