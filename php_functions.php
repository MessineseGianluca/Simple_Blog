<?php
  include 'config.php';
  
  Class MysqlConnector {
      
      public $connection;
      private $conf;
      public $status = " "; //a testing variable
    
      #constructor
      function __construct() {
        
        $this->conf = new Config();
      }
    
    
      # Connect to the RDBMS 
      public function connectMysql() {
        
        $this->connection = new mysqli(
            $this->conf->servername,  
            $this->conf->username, 
            $this->conf->password, 
            $this->conf->dbname
        );
      
        #Check connection
        if($this->connection->connect_error) {
          die(
            "Connection hasn't workerd because: " .
            $this->connection->connect_error
          );
        }
        $this->status = "Connected to the server. <br>";
        echo $this->status;
        
      }  
    
      #Insert new account
      public function signUp($email, $pass, $name, $surname) {
        $this->connection->query(
          "INSERT INTO Users(email, password, name, surname)
           VALUES('$email', '$pass', '$name', '$surname');      
          "
        ) or die($data->connection->error);
        echo 'Signed up. <br>';
      }
    
      #Disconnect from RDBMS
      public function disconnectMysql() {
                        
        $this->connection->close() or die(mysql_error());
        $this->status = "Disconnected from the server. <br>";
        echo $this->status;
      
      }
  
  }
 
?>

