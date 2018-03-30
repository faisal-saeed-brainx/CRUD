<?php
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
      $.post('changeApi.php',$('#changeForm').serialize(),function(data, status){
        if(data == '1')
        {
          alert('Password has been changed.');
          window.location.href = 'login_form.php';  
        }
        else if(data == '0')
        {
          alert('An error has been occured!');
        }
      });
      return false;
      }
  </script>

</head>
<body onload="">
<div class="container">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
  	<h2>Sign Up</h2>
  	<form id="changeForm"  method="POST" onsubmit="return ajaxLogin()">

    <div class="form-group">
      <label for="pwd1">New Password:</label>
      <input type="password" class="form-control" id="pwd1" placeholder="Confirm password" name="pwd1" onkeyup="check();" required>
    </div>
    <div class="form-group">
      <label for="pwd2">Confirm Password:</label>
      <span id='message' style="float: right;font-family: 'Helvetica Neue',Helvetica,Arial, sans-serif;
    font-size: 14px;"></span>
      <input type="password" class="form-control" id="pwd2" placeholder="Confirm password" name="pwd2" onkeyup="check();" required>
      
    </div>

    <button id="submit" type="submit" class="btn btn-default">Sign Up</button>
  </form>
  </div>
</div>


</div>

</body>
</html>
