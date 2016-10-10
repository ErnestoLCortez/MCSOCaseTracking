<?php
session_start();
include 'dbConn.php';
echo "<a href='main.php'>Home</a>";
$connection = dbConn();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}

function displayAllUsers(){
    $usersSQL = "Select * FROM `users` WHERE 1=1 ORDER BY lastname DESC";
    $users = getDataBySQL($usersSQL);
    
    echo "<table class='sorttable' border=1>";
    
    echo "<th>Rank</th>";		
    echo "<th>First Name</th>";		
    echo "<th>Last Name</th>";		
    echo "<th>Username</th>";		
    echo "<th>Active</th>";
    
    foreach ($users as $user){
        echo "<tr>";
        echo '<td>' . $user['rank'] . '</td>';
        echo '<td>' . $user['firstname'] . '</td>';
        echo '<td>' . $user['lastname'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>';
            if($user['active'] == 1){
                echo "Yes";
            }else{
                echo "No";
            }
        echo '</td>';
        
        //Alter User
        echo "<td> <form action=editUser.php>";
        echo "<input type='hidden' name='username' value='".$user['username'] . "'/>";
        echo "<input type='submit' value='Edit User'/></form> </td>";
        echo "</tr>";
    }
    
    
    echo "</table>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>MCSO Investigations</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="stylesheet" href="css/default.css" type="text/css" />
  <script>
    function levelAccess()
    {
         alert("Restricted Access!"); // this is the message in ""
    }
</script>
  <script src="sorttable.js"></script>
</head>
<header>
      <h1>Users Panel</h1>
    </header>
<body>
    <?php
        if($_SESSION['rank'] == "Deputy" || $_SESSION['rank'] == "Detective"){
            echo '<script>levelAccess()</script>';
            // header("location:javascript://history.go(-1)");
            header("location:main.php");
        }
    ?>
    
    <form action="addUser.php">
      <input type="submit" value="Add User" />    
   </form>
    
    
    <!--List all Users-->
    <?=displayAllUsers()?>
    
</body>

<footer>
    
</footer>
</html>