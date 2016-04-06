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
        
      }  
    
      #Insert new account
      public function signUp($email, $pass, $name, $surname) {

        $this->connection->query(
          "INSERT INTO Users(email, password, name, surname)
           VALUES('$email', '$pass', '$name', '$surname');      
          "
        ) or die($this->connection->error);
        
        //Get the user_id of the new User
        $result = $this->connection->query(
            "SELECT user_id
             FROM Users
             WHERE email='$email';
            "
        ) or die($this->connection->error);
        
      }
      
      #Return true if the email  already exits, else return false 
      public function isRegistered($email) {

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
      
      public function findLastPostId() {
        
        $last = $this->connection->query(
          "SELECT MAX(post_id) FROM Posts;"
        ) or die ($this->connection->error);

        $lastone = $last->fetch_assoc();
        return $lastone['MAX(post_id)'];
      }

      public function findLastUserId() {
        
        $last = $this->connection->query(
          "SELECT MAX(user_id) FROM Users;"
        ) or die ($this->connection->error);

        $lastone = $last->fetch_assoc();
        return $lastone['MAX(user_id)'];
      }

      public function addPost() {
        
        $content = $_POST['description'];
        $id = $_SESSION['id'];
        
        //Add escape char \ in before special characters 
        $content = $this->connection->real_escape_string( $content );  
        
        $this->connection->query(
            "INSERT INTO Posts(description, user_id)
             VALUES (
               '$content', 
               '$id'
             ); 
            "
        ) or die($this->connection->error);
      }
      
      public function like($post_id) {
        $this->connection->query(
            "INSERT INTO Likes
             VALUES (
               '$post_id', 
               " . $_SESSION['id'] . "
             ); 
            "
        ) or die($this->connection->error);
      }

      public function dislike($post_id) {
        $this->connection->query(
            "DELETE FROM Likes
             WHERE post_id = '$post_id' AND 
                   user_id = " . $_SESSION['id'] . ";
            "
        ) or die($this->connection->error);
      }
     
      public function isLiked($post_id) {
         
        $like = $this->connection->query(
          "SELECT *
           FROM Likes
           WHERE post_id = " . $post_id . " AND 
                 user_id = " . $_SESSION['id'] . "
           ;
          "
        );
        if($like->num_rows !== 0) {
          return true;
        }
        
        return false;
      }

      public function getNumOfLikes($post_id) {
        
        $likes = $this->connection->query(
          "SELECT COUNT(*) as num
           FROM Likes
           WHERE post_id = " . $post_id . "
           ;
          "
        );

        $likes = $likes->fetch_assoc();
        return $likes['num'];
      }

      public function getUsers($text) {
        $text = $this->connection->real_escape_string( $text ); 
        //get all users
        $users = $this->connection->query(
          "SELECT user_id, name, surname
           FROM Users
           WHERE (name like '%" . $text . "%' or 
                 surname like '%" . $text . "%') and 
                 user_id <> " . $_SESSION['id'] . "; 
          "
        );

        return $users;
      }

      public function getFollowedUsers() {
        $followed_users = $this->connection->query(
          "SELECT followed_id
           FROM Followings
           WHERE follower_id =" . $_SESSION['id'] . ";" 
        );

        return $followed_users;
      }
      
      public function follow($user_to_follow) {
        $this->connection->query(
          "INSERT INTO Followings 
           VALUES(" . $_SESSION['id'] . ", " . $user_to_follow . ");" 
        );
      }
      
      public function unfollow($user_to_unfollow) {
        $this->connection->query(
          "DELETE FROM Followings
           WHERE follower_id = " . $_SESSION['id'] . " and
                 followed_id = " . $user_to_unfollow . ";"
        );
      }

      public function getPosts() {
        $posts = $this->connection->query(
          "SELECT P.post_id, P.description, P.sharing_date, 
                  U.name, U.surname, U.user_id 
           FROM Posts P, Users U
           WHERE (P.user_id = " . $_SESSION['id'] . " OR 
                 P.user_id IN (   
                  SELECT F.followed_id   
                  FROM Followings F, Users U   
                  WHERE F.followed_id = U.user_id AND 
                        F.follower_id = " . $_SESSION['id'] . "
                 )) AND 
                 P.user_id = U.user_id
           ORDER BY P.sharing_date DESC;
          "
        );

        return $posts;
      }

      public function getComments($post) {

        $comments = $this->connection->query(
            "SELECT Comments.description, Comments.sharing_date, 
                    Comments.user_id, Users.name, Users.surname, 
                    Users.user_id
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
        //Add escape char \ in before special characters 
        $comment = $this->connection->real_escape_string( $comment );
        
        $this->connection->query(
            "INSERT INTO Comments (description, user_id, post_id)
             VALUES (
               '$comment', 
               '$id', 
               '$post'
             );
            "
        ) or die($this->connection->error);
      }
      

      
      #Disconnect from RDBMS
      public function disconnectMysql() {
                        
        $this->connection->close() or die(mysql_error());
        $this->status = "Disconnected from the server. <br>";
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
  
