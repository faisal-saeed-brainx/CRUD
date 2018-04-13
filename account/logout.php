<?php
Session_start();

if (isset($_SESSION['user_id'])) 
{    
	$_SESSION['user_id'] = "";
	$_SESSION['role'] = "";
	$_SESSION['mode'] = "";
	$_SESSION['status'] = "";
	$_SESSION['name'] = "";
	$_SESSION['pic'] = "";
	session_unset();
	Session_destroy();
}
header('Location: ../index.php');
?>