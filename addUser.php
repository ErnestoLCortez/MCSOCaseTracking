<?php
session_start();
include 'dbConn.php';
echo "<a href='main.php'>Home</a>";
$connection = dbConn();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}
if (isset($_GET['addUser'])) {  //admin submitted form to add user
    $conn = dbConn();
    //Check authentication Here
  
    $sql = "INSERT INTO `users` ( rank, firstname, lastname, username, password)
    VALUES (:rank, :firstname, :lastname, :username, :password)";
    
    $namedParameters = array();
    $namedParameters[':rank'] = $_GET['rank'];
    $namedParameters[':firstname'] = $_GET['firstname'];
    $namedParameters[':lastname'] = $_GET['lastname'];
    $namedParameters[':username'] = $_GET['username'];
    $namedParameters[':password'] = hash("sha1",$_GET['password']);
    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);  
  
  echo "User has been added.";   
//   header("Location: main.php");
  $hasUpdate = true;
}

if (isset($_GET['updateUser'])) {
    /*
    *   The password field has text set, reset password to text entered.
    */
    if(strcmp($_GET['password'],"")!=0){
    $sql = "UPDATE `users`
          SET rank = :rank,
          firstname = :firstname,
          lastname = :lastname,
          active = :active,
          password = :password
          WHERE username = :username";
    
    $namedParameters = array();
    $namedParameters[':rank'] = $_GET['rank'];
    $namedParameters[':firstname'] = $_GET['firstname'];
    $namedParameters[':lastname'] = $_GET['lastname'];
    $namedParameters[':active'] = $_GET['active'];
    $namedParameters[':password'] = hash("sha1",$_GET['password']);
    $namedParameters[':username'] = $_GET['username'];
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>MCSOI Add User</title>
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
</head>
<header>
      <h1>Add a User</h1>
    </header>
<body>
    <?php
        if($_SESSION['rank'] == "Sergeant" || $_SESSION['rank'] == "Detective"){
            echo '<script>levelAccess()</script>';
            // header("location:javascript://history.go(-1)");
            header("location:main.php");
        }
    ?>
    
    <form>
    <table border=1>
        <tr>
            <th>Rank</th>
            <td><select name="rank">
                <option value="Commander" <?php if($user['rank'] == "Commander"){echo "selected";}?>>Commander</option>
                <option value="Admin" <?php if($user['rank'] == "Admin"){echo "selected";}?>>Admin</option>
                <option value="Sergeant" <?php if($user['rank'] == "Sergeant"){echo "selected";}?>>Sergeant</option>
                <option value="Deputy" <?php if($user['rank'] == "Deputy"){echo "selected";}?>>Deputy</option>
            </select></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td><input type="text" name="firstname"></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><input type="text" name="lastname"></td>
        </tr>
        <tr>
            <th>Username Name</th>
            <td><input type="text" name="username"></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td colspan=2>
                <input type='submit' value='Submit User' name='addUser'/>
            </td>
        </tr>
    </table>
    </form>
    <br>
    <?php if($hasUpdate){
        echo "<br><h3>User has been added.</h3>";
    }
    ?>
</body>

<footer>
    
</footer>
</html>