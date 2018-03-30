<?php
include '../assets/utils.php';

		// Create connection
$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
		// Check connection
if ($conn->connect_error) {
 echo "<script type='text/javascript'>alert('failed!')</script>";
 die("Connection failed: " . $conn->connect_error);
}

$pwd = $_POST['pwd1'];
session_start();
$sql = "UPDATE crud_user SET password='". $pwd ."',f_code='' WHERE f_code='". $_SESSION['f_code'] ."'";
    if ($conn->query($sql) === TRUE) 
    {
      $_SESSION['f_code'] = "";
      echo "1";
    }
    else{
      echo "0";
    }
$conn->close();
?>