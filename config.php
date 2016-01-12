<?php
  class Config {
    private $servername = 'localhost';
    private $username = 'username';
    private $password = 'password';
    private $dbname = 'blogdb';
    
    public function getServer() {
      return $this->servername;
    }
    public function getUser() {
      return $this->username;
    }
    public function getPassw() {
      return $this->password;
    }
    public function getDb() {
      return $this->dbname;
    }  
  
  } 
?>
