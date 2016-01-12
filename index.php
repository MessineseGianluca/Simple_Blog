<DOCTYPE html>
<html>
<head>
  <title> My simple Blog </title>
</head>
<body>
  <?php
    include 'php_functions.php';
    include 'config.php';
    
    $conf = new Config();
    
    $data = connectMysql(
        $conf->getServername(), 
        $conf->getUsername(), 
        $conf->getPassword(), 
        $conf->getDbname()
    );
    
    #Inserimenti
    #Queriees 
    
    #close mysql connection 
    $data->close();
  ?>
</body>
</html>
