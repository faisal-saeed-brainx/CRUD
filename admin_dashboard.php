<?php
include 'utils.php';
// Inialize session
session_start();

// Check, if user session is NOT set then this page will jump to login page
if (isset($_SESSION['user_id'])) {
  if ($_SESSION['role'] == 'user')
  {
    header('Location: user_dashboard.php');
  }
}
else
{
    header('Location: login_form.php');
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">  
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  
  <script type="text/javascript">
    $(document).ready(function() {
        $('#users_table').DataTable();
    } );
  </script>
</head>
<body>

<?php

echo " <div class='container'>
        <div class='row'>
        <div class='col-md-8'>
          <h1>Welcome ". $_SESSION['name'] ."! </h1>
        </div>
        <div class='col-md-4' style='padding: 15px 0px; text-align: right;'>
          <a class='btn btn-primary' href='logout.php'>Logout</a>
        </div>    
      </div>
      </div>";

// Create connection
  $conn = new mysqli(rtrim(getMyEnv('DB_HOST')), rtrim(getMyEnv('DB_USERNAME')), rtrim(getMyEnv('DB_PASSWORD')), rtrim(getMyEnv('DB_DATABASE')));
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, name, email,mode, role FROM crud_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo "<div class='container'>
  				<h2 style='text-align: center;'>Users</h2>           
  					<table id='users_table' class='table table-striped table-bordered'>
    					<thead>
      					<tr>
        					<th>ID</th>
        					<th>Name</th>
        					<th>Email</th>
        					<th>Role</th>
                  <th>Mode</th>
      					</tr>
    					</thead>
    					<tbody>";
      					while($row = $result->fetch_assoc()) 
    					{ 
        					echo "<tr><td>" . $row["id"]. "</td>
        					<td>" . $row["name"]. "</td>
        					<td>" . $row["email"]. "</td>
                  <td>" . $row["mode"]. "</td>
        					<td>" . $row["role"]. "</td></tr>";
        				} 
        				echo "
    					</tbody>
  					</table>
				</div>";

} else {
    echo "0 results";
}
$conn->close();
?>
</body>
</html>