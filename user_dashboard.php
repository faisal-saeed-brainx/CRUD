<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
// Inialize session
session_start();

if (isset($_SESSION['user_id'])) {
  if ($_SESSION['role'] == 'admin')
  {
    header('Location: admin_dashboard.php');
  }
  else if ($_SESSION['status'] == 'inactive')
  {
    echo "<div class='container'>
            <div class='alert alert-danger'>
              <strong>Warning!</strong> Please Verify your email first.
            </div>
          </div>";
  }
}
else
{
    header('Location: login_form.php');
}
?>
<div class='container'>
	<div class='row'>
       <div class='col-md-8'>
        <h1>Welcome <?= $_SESSION['name'] ?>!</h1>
      </div>
      <div class='col-md-4' style='padding: 15px 0px; text-align: right;'>
        <!--<a class='btn btn-primary' href='logout.php' onclick="FB.logout()">Logout</a>-->
        <?php if($_SESSION['mode'] == 'google') {?>
        <?php include('googleScript.php');?>
        <a class='btn btn-primary' href='logout.php' onclick="gapi.auth2.getAuthInstance().signOut();">Logout</a>
        <?php } else {?>
                <a class='btn btn-primary' href='logout.php'>Logout</a>
        <?php }?>
      </div>    
    </div>
</div>
</body>
</html>