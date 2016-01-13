# Simple-Blog
A Simple Blog using php and mysql. 

######################Configuring mysql#################################
-Open mysql as root: mysql -u root -p and insert password;

-Create in mysql a user 'username' with a password 'password': 
  CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
  SET PASSWORD FOR 'username'@'localhost' = PASSWORD('password');

-Create a database:
  CREATE DATABASE blogdb;

-Assign all the privileges to the user 'username'
  SET PASSWORD FOR 'username'@'localhost' = PASSWORD('password');


NOTE: if you want to access to the db with different username and password, 
      change the attributes in config.php Config class.



