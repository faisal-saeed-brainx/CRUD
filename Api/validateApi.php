<?php
include '../assets/utils.php';

if ($_POST['email'] && $_POST['pwd']) {
	// Create connection
	$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];

	$sql = "SELECT id, role, mode, name, status, pic FROM crud_user WHERE email='". $email ."' AND password='". $pwd ."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{	
		$row = $result->fetch_assoc();
		if($row) {
			session_start();
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['role'] = $row['role'];
			$_SESSION['mode'] = $row['mode'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['status'] = $row['status'];
			$_SESSION['pic'] = $row['pic'];
        	if ($row["role"] == 'user') 
			{
				echo 'user';
			}
			else
			{
				echo 'admin';
			}
    	}
	} 
	else {
    	echo 'error';
	}
	$conn->close();
}
else
  {
    echo 'empty';
  }
?>