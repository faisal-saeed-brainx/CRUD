<?php
include 'utils.php';


$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
		// Check connection
if ($conn->connect_error) {
	echo "<script type='text/javascript'>alert('failed!')</script>";
	die("Connection failed: " . $conn->connect_error);
}

$f_code = $_GET['f_code'];

$sql = "SELECT id FROM crud_user WHERE f_code='". $f_code ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{ 
	session_start();
	$_SESSION['f_code']=$f_code;
	header('Location: change_form.php');
}
else{
	header('Location: login_form.php');
}
$conn->close();
?>