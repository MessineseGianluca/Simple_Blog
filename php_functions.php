<?php
  session_start();
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
        ) or die($this->connection->error);
      }
      
      #Check login 
      public function logIn($email, $pass) {
        $result = $this->connection->query(
            "SELECT user_id,name,surname 
             FROM Users 
             WHERE email='$email' AND password='$pass';
            "
        );
        if($result->num_rows === 0) return false;
        
        //Put got data into $row
        $row = $result->fetch_assoc();
        $_SESSION['authenticated'] = true;
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['surname'] = $row['surname'];
        return true;
      }
      
      

      public function addPost($content) {
        $id = $_SESSION['id'];  
        $this->connection->query(
            "INSERT INTO Posts(description, user_id)
             VALUES ('$content', '$id'); 
            "
        ) or die($this->connection->error);
      }


      public function getPost() {
        $result = $this->connection->query(
            "SELECT Posts.description, Posts.sharing_date, 
                    Users.name, Users.surname
             FROM Posts
             INNER JOIN Users
             ON Users.user_id = Posts.user_id
             ORDER BY sharing_date DESC;
            "
        );
        return $result;

      }
    


      #Disconnect from RDBMS
      public function disconnectMysql() {
                        
        $this->connection->close() or die(mysql_error());
        $this->status = "Disconnected from the server. <br>";
        echo $this->status;
      
      }
  
  }
 
?>

