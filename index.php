<DOCTYPE html>
<html>
<head>
  <title> My simple Blog </title>
</head>
<body>
  <?php
    include 'php_functions.php';
    include 'install.php';
    
    #Create an object for the dbms handlings
    $data = new MysqlConnector();
    
    #open mysql connection
    $data->connectMysql();
    echo $data->getStatus() . '<br>';
    
    #Inserts
    #Queriees 
    
    #close mysql connection 
    $data->disconnectMysql();
    echo $data->getStatus();
  ?>
</body>
</html>
