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

