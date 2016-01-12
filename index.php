<DOCTYPE html>
<html>
<head>
  <title> My simple Blog </title>
</head>
<body>
  <?php
    include 'config.php';
    $data = connectMysql('localhost', 'username', 'password', 'blogdb');
    #Inserimenti
    #Queriees 
    $data->close();
  ?>
</body>
</html>
