<?php
  /**** REQUIRE CLOUDINARY ****/
  require 'vendor/cloudinary/cloudinary_php/src/Cloudinary.php';
  require 'vendor/cloudinary/cloudinary_php/src/Uploader.php';
  require 'vendor/cloudinary/cloudinary_php/src/Api.php';  
  include 'php_functions.php';
  include 'cloudinary_config.php';
  
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $pass = $_POST['pass'];
  $pass2 = $_POST['pass2'];
  $email = $_POST['email'];
  
  /******** CHECK PASSWORDS **********/
  if(strlen ($pass) < 8) {
    echo "*Please insert a password equal or longer than 8 characters.";
    exit;
  }

  if($pass2 !== $pass) {
    echo "*Please insert equal passwords.";
    exit;
  }
  
  /********** CHECK EMAIL *********/
  $data = new MysqlConnector();
  $data->connectMysql();
    
  if($data->isRegistered($email)) {
    echo "*Email already exists.";
    exit;
  }

  /************ CHECK PICTURE ************/
  $img_name = $_FILES['imgToUpdate']['name'];  
  if($img_name !== "") { 

    //Check if the file is bigger than 300kb
    if($_FILES['imgToUpdate']['size'] > 300000) {
      echo "*Please insert a picture with a size smaller than 300Kb.";
      exit;
    }

    \Cloudinary::config(getCloudinaryCredentials());
    
    $img_url = \Cloudinary\Uploader::upload(
        $_FILES['imgToUpdate']['tmp_name'],
        array(
          "crop" => "lfill", 
          "width" => "400", 
          "height" => "400"
        )                                     
    );
    
    $img_url = $img_url['url'];

  }

  /* IF EVERYTHING IS OKAY, CRIPT THE PASSWORD AND STORE THE NEW USER
   * INFORMATIONS.
   */
  $encrypted_pass = cryptPass($pass);    
  $data->signUp($email, $encrypted_pass, $name, $surname, $img_url);
  $data->disconnectMysql();

  echo "Successfully registered."; 

