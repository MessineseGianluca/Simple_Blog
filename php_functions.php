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
    
    
    #Connect to the RDBMS
    public function connectMysql() {
        
      $this->connection = new mysqli(
          $this->conf->getServer(),  
          $this->conf->getUser(), 
          $this->conf->getPassw(), 
          $this->conf->getDb()
      );
      
      #Check connection
      if($this->connection->connect_error) {
        die("
          Connection hasn't workerd because: " .
          $this->connection->connect_error
        );
      }
      $this->status = "Connected to the server. <br>";
      echo $this->getStatus();
          
      #Install tables
      if($this->connection->query(addTables()) === TRUE) {
        echo "Created <br>";
      }
      else {
        echo $this->connection->error;
      }
    } 
    
    #Return connection status
    public function  getStatus() {
        
      return $this->status;
    }
   
    
    #Disconnect from RDBMS
    public function disconnectMysql() {
      if($this->connection->query(deleteTables()) === TRUE) {
        echo "Deleted <br>";    
      }
      else {
        echo $this->connection->error;
      }   
      $this->connection->close() or die(mysql_error());
      $this->status = "Disconnected from the server. <br>";
      echo $this->getStatus();
      
    }
  
  }
 
?>

