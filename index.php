<DOCTYPE html>
<html>
<head>
  <title> My simple Blog </title>
</head>
<body>
  <?php
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "blogdb";

    #Connect to RDBMS
    $connection = new mysqli($servername, $username, $password, $dbname);
    #Check connection
    if($connection->connect_error) {
      die("Connection hasn't workerd because: " . $connection->connect_error);
    }
    echo "connected";
    $connection->close();
  ?>
</body>
</html>
