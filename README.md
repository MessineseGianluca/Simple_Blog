# Simple-Blog
A Simple Blog using php and mysql. 

#Configuring mysql
-Open mysql as root: mysql -u root -p and insert password;

-Create in mysql a user 'username' with a password 'password': 
  CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
  SET PASSWORD FOR 'username'@'localhost' = PASSWORD('password');

-Create a database:
  CREATE DATABASE blogdb;

-Assign all the privileges to the user 'username'
  GRANT ALL PRIVILEGES ON blogdb . * TO 'username'@'localhost';

NOTE: if you want to access to the DB with different username and password, 
      change the attributes in config.php Config class.


#Installing Tables
After that, you have to create the SQL tables into your DB and you can do that
by executing install.php: it will erase all the old tables inside the DB and 
it will install the newest. This is why you can execute install.php even when 
you want to add another column inside a several table:
(modify the SQL code which will create the table where we are going to 
add the column and then you can execute install.php)
or when you simply want to reset the DB.
To execute install.php write in your browser search bar: 
localhost/.../.../Simple_Blog/install.php


#Configuring Bower
From the terminal move into Simple_Blog path, using cd and write:
-$ bower install bootstrap
then init and compile the bower.json config file by digiting:
-$ bower init
then:
-$ bower install --save

#Install And Configure Cloudinary by composer
-First install composer.phar(see the documentation) into the project folder
       and then digits on the cli:
       $php composer.phar install
-Then configure your credentials in cloudinary_config.php


