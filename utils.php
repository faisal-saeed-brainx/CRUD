<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Method to read .env file Example: getMyEnv('DB_HOST')
function getMyEnv($fieldName)
{
$myfile = fopen(".env", "r") or die("Unable to open file!");
while(!feof($myfile)) {
	$parts = explode("=",fgets($myfile));
	if($parts[0] == $fieldName)
	{
		fclose($myfile);
		return $parts[1];
	}
}
fclose($myfile);
return null;
}


?>