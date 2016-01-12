<?php 
  
  #Connect to the RDBMS
  function connectMysql($servername, $username, $password, $dbname) {
    $connection = new mysqli($servername, $username, $password, $dbname);
    
    #Check connection
    if($connection->connect_error) {
      die("Connection hasn't workerd because: " . $connection->connect_error);
    }
    echo "connected";
    return $connection;
  }

?>

