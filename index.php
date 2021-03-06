<?php
session_start();

if (isset($_SESSION['user_id'])) {
  if ($_SESSION['role'] == 'admin')
  {
    header('Location: user/admin_dashboard.php');
  }
  else
  {
    header('Location: user/user_dashboard.php');
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

  function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
  }

    function ajaxLogin()
    {
      $.post('Api/validateApi.php',$('#loginForm').serialize(),function(data, status){
        if(data == 'admin')
        {
          if(get('return_path'))
          {
            window.location.href = get('return_path');  
          }
          else
            window.location.href = 'user/admin_dashboard.php';  
        }
        else if(data == 'user')
        {
          if(get('return_path'))
          {
            window.location.href = get('return_path');  
          }
          else
            window.location.href = 'user/user_dashboard.php'; 
        }
        else if(data == 'error')
        {
          alert('Invalid username or password');
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
        <form id='loginForm' method="POST" onsubmit="return ajaxLogin()">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
          </div>
        <!--<div class="checkbox">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>-->

        <button id="submit" name="submit" type="submit" value="submit" class="btn btn-default">Submit</button>

        <a href="account/forget.php" style="float: right;">Forget Password?</a>
        
        <div style="text-align: center;"><a class="btn btn-primary" href="account/signup_form.php">Don't have an account? Sign Up</a></div>
      </form>
    </div>    
  </div>
</div>
</body>
</html>
