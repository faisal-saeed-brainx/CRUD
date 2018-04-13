<?php
include '../assets/utils.php';

$conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
  // Check connection
if ($conn->connect_error) {
  echo "<script type='text/javascript'>alert('failed!')</script>";
  die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['user_id'])) 
{
	header('Location: ../index.php?return_path=user/edit_profile.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>CRUD</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		var check = function() {
			if ((document.getElementById('pwd1').value == document.getElementById('pwd2').value) && document.getElementById('pwd1').value != "" ){
				document.getElementById('message').style.color = 'green';
				document.getElementById('message').innerHTML = 'matching';
				document.getElementById("submit").disabled = false;
			} else {
				document.getElementById('message').style.color = 'red';
				document.getElementById('message').innerHTML = 'not matching';
				document.getElementById("submit").disabled = true;
			}
		}
		function ajaxLogin()
		{
          //alert('hi');
          var form = $('#update')[0]; // You need to use standard javascript object here
          var formData = new FormData(form);
          $.ajax({
          	url: '../Api/editApi.php',
          	type: "POST",
          	data: formData,
          	cache: false,
          	contentType: false,
          	processData: false,
          	success: function(data, status){
          		if(data == '1')
          		{
          			alert('Account has been Updated.');
          			window.location.href = 'user_dashboard.php';  
          		}
          		else if(data == '0')
          		{
          			alert('An error has been occured!');
          		}
          		else
          		{
          			alert(data);
          		}
          	}
          });
          return false;
      }
  </script>
</head>

<body onload="">
	<?php include "header.php";?>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<h2>Edit Profile</h2>
				<?php
				$email = "";
				$pwd = "";
				$pic_src = "";
				$name = "";    		
				$sql = "SELECT email,password,pic FROM crud_user WHERE id=". $_SESSION['user_id'];
				$result = $conn->query($sql);

				if ($result->num_rows > 0) 
				{ 
					if($row = $result->fetch_assoc()) {
						$email = $row['email'];
						$pwd = $row['password'];
						$pic_src = $row['pic'];
						$name = $_SESSION['name'];
					}
				}
				echo "
				<div class='row'>
				<form id='update'  method='POST' onsubmit='return ajaxLogin();' enctype='multipart/form-data'>
				<div class='form-group'>
				<label for='pic'>Profile Pic:</label>
				<input type='file' class='form-control' value='".$pic_src."' name='fileToUpload' id='fileToUpload'>
				</div>

				<div class='form-group'>
				<label for='name'>Name:</label>
				<input type='text' class='form-control' id='name' value='".$name."' placeholder='Enter name' name='name' required>
				</div>

				<div class='form-group'>
				<label for='email'>Email:</label>
				<input type='email' class='form-control' id='email' value='".$email."' placeholder='Enter email' name='email' disabled required>
				</div>

				<div class='form-group'>
				<label for='pwd1'>Password:</label>
				<input type='password' class='form-control' id='pwd1' placeholder='Confirm password' name='pwd1' onkeyup='check();' value='".$pwd."' required>
				</div>

				<div class='form-group'>
				<label for='pwd2'>Confirm Password:</label>
				<span id='message' style='float: right;font-family: 'Helvetica Neue',Helvetica,Arial, sans-serif;
				font-size: 14px;'></span>
				<input type='password' class='form-control' id='pwd2' placeholder='Confirm password' name='pwd2' onkeyup='check();' value='".$pwd."' required>
				</div>

				<button id='submit' type='submit' class='btn btn-default'>Update</button>
				</form>
				"; ?>
			</div>
		</div>
	</div>
</body>
</html>