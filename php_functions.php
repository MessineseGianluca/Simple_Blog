<?php
  include 'config.php';
  include 'install.php';
  
  Class MysqlConnector {
      
      private $connection;
      private $conf;
      private $status = ""; //a testing variable
    
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
        echo $this->getStatus();
        
        #Install tables
        for($i = 0; $i < 3; $i++) {
          if($this->connection->query(addTables($i)) === TRUE) {
            echo "Created <br>";
          }
          else {
            echo $this->connection->error . '<br>';
          }
        }
      }  
    
      #Return connection status
      public function  getStatus() {
        
        return $this->status;
      }
   
    
      #Disconnect from RDBMS
      public function disconnectMysql() {
        
        for($i = 0; $i < 3; $i++) {  
          if($this->connection->query(deleteTables($i)) === TRUE) {
            echo "Deleted <br>";    
          }
          else {
            echo $this->connection->error. '<br>';
          }
        }
         
        $this->connection->close() or die(mysql_error());
        $this->status = "Disconnected from the server. <br>";
        echo $this->getStatus();
      
      }
  
  }
 
?>

