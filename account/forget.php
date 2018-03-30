<?php
session_start();

if (isset($_SESSION['user_id'])) {
  if ($_SESSION['role'] == 'admin')
  {
    header('Location: ../user/admin_dashboard.php');
  }
  else
  {
    header('Location: ../user/user_dashboard.php');
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
    
    function ajaxLogin()
    {
      //alert('hi');
      $.post('../Api/forgetApi.php',$('#forgetForm').serialize(),function(data, status){
        if(data == '0')
        {
          alert('Invalid email');
        }
        else if(data == '1')
        {
         alert('Change Password link has been sent to your email.');
         window.location.href = '../index.php';
       }
       else
       {
         alert('Please fill empty field');
       }
     });

      return false;
    }
  </script>
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-offset-3 col-md-6">
        <h2 style="text-align: center;">Login</h2>
        <form id='forgetForm' method="POST" onsubmit="return ajaxLogin()">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
          </div>

          <button id="submit" name="submit" type="submit" value="submit" class="btn btn-default">Send Change Password link</button>
        </form>
      </div>    
    </div>
  </div>
</body>

</html>
