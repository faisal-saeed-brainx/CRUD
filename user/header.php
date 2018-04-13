<?php
echo " <div class='container'>
        <div class='row'>
        <div class='col-md-2'>
          <img style='border-radius: 8px;' src='". $_SESSION['pic'] ."' alt='Profile Pic' width='80' height='80'>
        </div>
        <div class='col-md-6'>
          <h1>Welcome ". $_SESSION['name'] ."! </h1>
        </div>
        <div class='col-md-4' style='padding: 15px 0px; text-align: right;'>
          <div class='col-md-6'>";
            if($_SESSION['mode'] == 'google') {
              include('googleScript.php');
              echo "<a class='btn btn-primary' href='../account/logout.php' onclick='gapi.auth2.getAuthInstance().signOut();'>Logout</a>";
            } else {
              echo "<a class='btn btn-primary' href='../account/logout.php'>Logout</a>";
            }
            echo "
          </div>
          <div class='col-md-6'>
            <a class='btn btn-success' href='edit_profile.php'>Edit Profile</a>
          </div>
        </div>   
      </div>
      </div>";

?>