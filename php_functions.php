<?php
  include 'config.php';
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
        die("Connection hasn't workerd because: " . $this->connection->connect_error);
      }
    
      $this->status = "Connected to the server.";
    }
    
    #Return connection status
    public function  getStatus() {
      return $this->status;
    }
    
    #Disconnect from RDBMS
    public function disconnectMysql() {
      $this->connection->close();
      $this->status = "Disconnected from the server.";
    }
  
  }
 
?>

