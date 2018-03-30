<?php
include 'utils.php';
  // Create connection
$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
  // Check connection
if ($conn->connect_error) {
  echo "<script type='text/javascript'>alert('failed!')</script>";
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'crud_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{ 
  if($row = $result->fetch_assoc()) {
    $user_id= $row['AUTO_INCREMENT'];
  }
}

include('signupUploadApi.php');
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  //File Uploaded
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd1'];
//$fileToUpload = $_POST['fileToUpload'];

    $sql = "SELECT id FROM crud_user WHERE email='". $email ."' AND mode='local'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0)
    {
      $sql = "INSERT INTO crud_user (name, email, password, role, mode,status,v_code)
      VALUES ('". $name ."', '". $email ."', '". $pwd ."','user','local','inactive','". md5(uniqid(rand(), true)) ."')";

      if ($conn->query($sql) === TRUE) 
      {

        $sql = "SELECT id, role, mode, status, name,v_code FROM crud_user WHERE email='". $email ."' AND mode='local'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        { 
          if($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['mode'] = $row['mode'];
            $_SESSION['status'] = $row['status'];
            $_SESSION['name'] = $row['name'];

            $to = $email;
            $subject = "Verification for CRUD";
            $msg = "Hello " . $row['name'] . "!. Your Verification link is: https://test.brainxtech.com/CRUD/verifyEmail.php?v_code=" . $row['v_code'];
            $headers = "From: faisal.saeed@brainxtech.com";
            if (mail($to,$subject,$msg,$headers) == 1) {
              echo "1";
            }


          }
        }     
      }
      else 
      {
        echo "0";
      }
    }
    else
    {    
      echo "2";
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}


$conn->close();
?>