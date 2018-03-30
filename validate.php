<?php
include 'utils.php';
session_start();

if (isset($_SESSION['user_id'])) {
  if ($_SESSION['role'] == 'admin')
  {
    header('Location: admin_dashboard.php');
  }
  else
  {
    header('Location: user_dashboard.php');
  }
}


if ($_POST['submit'] == 'submit') {
	// Create connection
	$conn = new mysqli(getMyEnv('DB_HOST'), getMyEnv('DB_USERNAME'), getMyEnv('DB_PASSWORD'), getMyEnv('DB_DATABASE'));
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 

	$email = $_POST['email'];
	$pwd = $_POST['pwd'];

	$sql = "SELECT id, role FROM crud_user WHERE email='". $email ."' AND password='". $pwd ."' AND mode='local'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{	
		if($row = $result->fetch_assoc()) {
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['role'] = $row['role'];
        	if ($row["role"] == 'user') 
			{
				echo '<script>window.location.href = "user_dashboard.php";</script>';
			}
			else
			{
				echo '<script>window.location.href = "admin_dashboard.php";</script>';
			}
    	}
	} 
	else {
    	echo '<script>window.location.href = "login_form.php";</script>';
	}
	$conn->close();
}
else
  {
    header('Location: login_form.php');
  }
?>