<?php
include 'utils.php';


$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
		// Check connection
if ($conn->connect_error) {
	echo "<script type='text/javascript'>alert('failed!')</script>";
	die("Connection failed: " . $conn->connect_error);
}

$v_code = $_GET['v_code'];

$sql = "SELECT id, role, mode, status, name,v_code FROM crud_user WHERE v_code='". $v_code ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{ 
	if($row = $result->fetch_assoc()) 
	{
		$sql = "UPDATE crud_user SET status='active' WHERE v_code='". $v_code ."'";
		if ($conn->query($sql) === TRUE) 
		{
			session_start();
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['role'] = $row['role'];
			$_SESSION['mode'] = $row['mode'];
			$_SESSION['status'] = 'active';
			$_SESSION['name'] = $row['name'];
			header('Location: user_dashboard.php');
		}
	}
}
$conn->close();
?>