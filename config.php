<?php
  class Config {
    private $servername = 'localhost';
    private $username = 'username';
    private $password = 'password';
    private $dbname = 'blogdb';
    
    public function getServername() {
      return $this->servername;
    }
    public function getUsername() {
      return $this->username;
    }
    public function getPassword() {
      return $this->password;
    }
    public function getDbname() {
      return $this->dbname;
    }  
  
  } 
?>
