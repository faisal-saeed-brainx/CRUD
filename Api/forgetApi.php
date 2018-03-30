<?php
include '../assets/utils.php';

if ($_POST['email']) {
	// Create connection
	$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$email = $_POST['email'];
	$f_code = md5(uniqid(rand(), true));
	
	$sql = "SELECT id FROM crud_user WHERE email='". $email ."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
		$sql = "UPDATE crud_user SET f_code='". $f_code ."' WHERE email='". $email ."'";
		if ($conn->query($sql) === TRUE) 
		{
			$to = $email;
			$subject = "Change Password for CRUD";
			$msg = "Hello!. Your Change Password link is: https://test.brainxtech.com/CRUD/account/changePassword.php?f_code=" . $f_code;
			$headers = "From: faisal.saeed@brainxtech.com";
			if (mail($to,$subject,$msg,$headers) == 1) {
				echo "1";
			}
		}
	}
	else{
		echo "0";
	}
	$conn->close();
}
else
{
	echo 'empty';
}
?>