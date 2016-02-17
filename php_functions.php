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
        //echo $this->status;
        
      }  
    
      #Insert new account
      public function signUp($email, $pass, $name, $surname) {
        $this->connection->query(
          "INSERT INTO Users(email, password, name, surname)
           VALUES('$email', '$pass', '$name', '$surname');      
          "
        ) or die($this->connection->error);
      }
      
      #Return true if the email  already exits, else return false 
      public function isRegistred($email) {
        $result = $this->connection->query(
            "SELECT email
             FROM Users 
             WHERE email='$email';
            "
        );
        if($result->num_rows === 1) return true;
        return false;
      }
      
      #Check login 
      public function logIn($email, $pass) {
        $result = $this->connection->query(
            "SELECT user_id, name, surname, password 
             FROM Users 
             WHERE email='$email';
            "
        );
        
        if($result->num_rows === 0) return false;
        
        //Put got data into $row
        $row = $result->fetch_assoc();
        
        if(crypt($pass, $row['password']) == $row['password']) {
          $_SESSION['authenticated'] = true;
          $_SESSION['id'] = $row['user_id'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['surname'] = $row['surname'];
          
          return true;
        }
        
        return false;
      }
      
      

      public function addPost($content) {
        $id = $_SESSION['id'];  
        $this->connection->query(
            "INSERT INTO Posts(description, user_id)
             VALUES ('$content', '$id'); 
            "
        ) or die($this->connection->error);
      }
      

      public function getPosts() {
        $posts = $this->connection->query(
            "SELECT Posts.description, Posts.sharing_date, Posts.post_id,
                    Users.name, Users.surname
             FROM Posts
             INNER JOIN Users
             ON Users.user_id = Posts.user_id
             ORDER BY sharing_date DESC;
            "
        );
        return $posts;

      }

      public function getComments($post) {
        $comments = $this->connection->query(
            "SELECT Comments.description, Comments.sharing_date, 
                    Comments.user_id, Users.name, Users.surname, Users.user_id
             FROM Comments
             INNER JOIN Users
             ON (Comments.post_id = '$post') AND 
                (Comments.user_id = Users.user_id) 
             ORDER BY sharing_date;
            "
        );
        return $comments;
      }
  
      public function addComment() {
        $id = $_SESSION['id'];
        $comment = $_POST['comment'];
        $post = $_POST['post'];

        $this->connection->query(
            "INSERT INTO Comments (description, user_id, post_id)
             VALUES ('$comment', '$id', '$post');
            "
        ) or die($this->connection->error);
      }
      

      
      #Disconnect from RDBMS
      public function disconnectMysql() {
                        
        $this->connection->close() or die(mysql_error());
        $this->status = "Disconnected from the server. <br>";
        //echo $this->status;
      
      }
  
  }
  
  
  function cryptPass($pass, $rounds = 10) {
  
    $salt = '';
    #merge all elements into the same array. It contains all the possible
    #characters that could be used to generate a random salt
    $saltChars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    
    #generate a random salt of 22 characters
    for($i = 0; $i < 22; $i++) {
      #array_rand chose a random index and takes the corrispent element
      $salt .= $saltChars[array_rand($saltChars)];
    }
  
    return crypt($pass, sprintf('$2y$%02d$', $rounds) . $salt);
  }
