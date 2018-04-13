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
    header('Location: ../index.php');
}

include "header.php";
?>

</body>
</html>