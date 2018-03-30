<?php
include '../assets/utils.php';

$jsondata = file_get_contents('php://input');

$obj = json_decode($jsondata);

//echo  $obj->name;

// Create connection
$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
    // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $obj->name;
$email = $obj->email;

$sql = "SELECT id FROM crud_user WHERE email='". $email ."' AND mode='facebook'";
$result = $conn->query($sql);

if ($result->num_rows == 0)
{
  $sql = "INSERT INTO crud_user (name, email, role, mode,status,v_code)
  VALUES ('". $name ."', '". $email ."','user','facebook','inactive','". md5(uniqid(rand(), true)) ."')";

  if ($conn->query($sql) === TRUE) 
  {

    $sql = "SELECT id, role,mode, status, name,v_code FROM crud_user WHERE email='". $email ."' AND mode='facebook'";
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
        $msg = "Hello " . $row['name'] . "!. Your Verification link is: https://test.brainxtech.com/CRUD/account/verifyEmail.php?v_code=" . $row['v_code'];
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
  $sql = "SELECT id, role,mode, status, name FROM crud_user WHERE email='". $email ."' AND mode='facebook'";
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
      echo "2";
    }
  }     
}
$conn->close();  
?>