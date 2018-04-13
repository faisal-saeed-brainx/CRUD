<?php
  include ('../assets/utils.php');
    include('../Social Auth/twitterScript.php'); 
    //session_start();
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
      <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

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
          var form = $('#signup')[0]; // You need to use standard javascript object here
          var formData = new FormData(form);
          $.ajax({
            url: '../Api/signupApi.php',
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, status){
              if(data == '1')
              {
                alert('Account has been created.');
                window.location.href = '../user/user_dashboard.php';  
              }
              else if(data == '0')
              {
                alert('An error has been occured!');
              }
              else if(data == '2')
              {
                alert('Account already exists!');
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
      <div id="fb-root"></div>

      <?php include('../Social Auth/fbScript.php');?>

      <div id="status"></div>

      <div class="container">
       <div class="row">
        <div class="col-md-offset-3 col-md-6">
         <h2>Sign Up</h2>
         <form id="signup" action="signup.php" method="POST" onsubmit="return ajaxLogin()" enctype="multipart/form-data">
          <div class="form-group">
            <label for="pic">Profile Pic:</label>
            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
          </div>

          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
          </div>

          <div class="form-group">
            <label for="pwd1">Password:</label>
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
        <div class="row" style="text-align: center;">
          <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" 
          scope="public_profile,email"
          onlogin="checkLoginState();">  
        </div>
      </div>
      <div class="row" style="text-align: -webkit-center; padding-top: 10px;">
        <button class='btn btn-danger' id="authorize-button" style="display: block; margin-top: 10px; width: 250px;">Login with Google</button>
        <button id="signout-button" style="display: none;">Sign Out</button>
        <div id="content"></div>
        <div id="my-signin2"></div>
        <?php include('../Social Auth/googleScript.php');?>
      </div>
      <div style="text-align: center;">
        <?php
        if(isset($login_url) && !isset($_SESSION['data'])){
            // echo the Twitter login url
          echo "<a href='$login_url' class='btn btn-primary' style='margin-top: 10px; width: 250px;'>Login with twitter</a>";
        }
        ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>