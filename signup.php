<?php
include 'utils.php';
// Inialize session
session_start();

// Check, if user session is NOT set then this page will jump to login page
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
else
{
    header('Location: login_form.php');
}


if (isset($_POST['submit'])) 
{
	if ($_POST['pwd1'] == $_POST['pwd2']) 
	{

		// Create connection
	$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
		// Check connection
		if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		}

		$name = $_POST['name'];
		$email = $_POST['email'];
		$pwd = $_POST['pwd1'];



		$sql = "INSERT INTO users (name, email, password, role)
		VALUES ('". $name ."', '". $email ."','". $pwd ."','user')";

		if ($conn->query($sql) === TRUE) {
    		echo '<script>window.location.href = "login_form.php";</script>';
    	}
	 	else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	}
	else
	{
		echo "Password Not Match!";
	}
}
else
  {
    header('Location: login_form.php');
  }
?>