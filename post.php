<?php
  include 'php_functions.php';
  
  $data = new MysqlConnector();
  
  $data->connectMysql();
  
  $data->addPost($_POST['description']);
  
  $data->disconnectMysql();
 
  http_response_code(201);
  
  /*$target_dir = "img/posts";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  //contain the img extension
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  $uploadOk = true;

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if (!$uploadOk) {
    echo "Sorry, your file was not uploaded.";
  	// if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . 
              basename( $_FILES["fileToUpload"]["name"]) . 
              " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
  }*/


