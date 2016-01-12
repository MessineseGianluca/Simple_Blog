<?php
  #delete all tables into DB 
  function deleteTables() {
      
    return '
      DROP TABLE Users;
    ';
  }      
  
  #add tables into DB
  function addTables() {
    
    return '
      CREATE TABLE Users (
        id_user INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY
      );
    ';
  }
   
?>