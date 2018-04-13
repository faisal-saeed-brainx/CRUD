<?php

include '../assets/utils.php';
  // Create connection
$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
  // Check connection
if ($conn->connect_error) {
  echo "<script type='text/javascript'>alert('failed!')</script>";
  die("Connection failed: " . $conn->connect_error);
}
session_start();
$user_id= $_SESSION['user_id'];

include('signupUploadApi.php');
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  //File Uploaded
    $name = $_POST['name'];
    $pwd = $_POST['pwd1'];
    
      $sql = "UPDATE crud_user SET name='".$name."', password='".$pwd."', pic='".$target_file."' WHERE id=". $_SESSION['user_id'];

      if ($conn->query($sql) === TRUE) 
      {
        $_SESSION['name'] = $name;
        $_SESSION['pic'] = $target_file;
        echo "1";     
      }
      else 
      {
        echo "0";
      }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
$conn->close();
?>