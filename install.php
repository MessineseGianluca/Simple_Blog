<?php
  include 'php_functions.php';
  ####################################FUNCTIONS################################
  
  #CREATE an array which will contain the SQL statements for deleting tables
  #and RETURN the string that we need.
  #Note: SQL can carry on only one statement for time. This is the reason why
  #      we have to call this function for each Stetement.
  function deleteTables($n_statement) {
      
    $dropper = array(
        'DROP TABLE Comments;' , 
        'DROP TABLE Posts;' ,
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
          email VARCHAR(255) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          signing_up_date TIMESTAMP );
        ' ,
       
        'CREATE TABLE Posts (
          post_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
          descrition VARCHAR(255) NOT NULL,
          title VARCHAR(255),
          sharing_date TIMESTAMP,
          user_id SMALLINT UNSIGNED NOT NULL,
          FOREIGN KEY (user_id) REFERENCES Users(user_id) );
        ' ,
        
        'CREATE TABLE Comments (
          comment_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
          descrition VARCHAR(255) NOT NULL,
          sharing_date TIMESTAMP,
          user_id SMALLINT UNSIGNED NOT NULL,
          post_id INT UNSIGNED NOT NULL,
          FOREIGN KEY (user_id) REFERENCES Users(user_id),
          FOREIGN KEY (post_id) REFERENCES Posts(post_id) );
        '        
        
    );
    
    return $creator[$n_statement];
  }
   
   
  #####################Calls methods########################à
     
  #Create Mysql object 
  $installer = new MysqlConnector();
  
  #Connect to mysql
  $installer->connectMysql();
 
  #Uninstall old tables
  for($i = 0; $i < 3; $i++) {  
    if($installer->connection->query(deleteTables($i)) === TRUE) {
      echo "Deleted <br>";    
    }
    else {
      echo $installer->connection->error. '<br>';
    }
  }
  
  #Install new tables 
  for($i = 0; $i < 3; $i++) {
    if($installer->connection->query(addTables($i)) === TRUE) {
      echo "Created <br>";
    }
    else {
      echo $installer->connection->error . '<br>';
    }
  }
  
  #Disconnect from Mysql
  $installer->disconnectMysql();
 
?>
