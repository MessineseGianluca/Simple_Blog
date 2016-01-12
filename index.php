<DOCTYPE html>
<html>
<head>
  <title> My simple Blog </title>
</head>
<body>
  <?php
    include 'php_functions.php';
    
    #Create an object for the dbms handlings
    $data = new MysqlConnector();
    
    #open mysql connection
    $data->connectMysql();
    
    #Inserts
    #Queriees 
    
    #close mysql connection 
    $data->disconnectMysql();
  ?>
</body>
</html>
