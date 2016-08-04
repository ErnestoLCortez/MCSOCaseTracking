<?php
session_start();
include 'dbConn.php';
echo "<a href='main.php'>Home</a>";
$connection = dbConn();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}

$hasUpdate = false;

function getUserByID(){
  $conn = dbConn();
  $sql = "SELECT * FROM `users` WHERE userID = :userID";
  $namedParameters = array();
  $namedParameters[':userID'] = $_GET['userID'];
  $statement = $conn->prepare($sql);    
  $statement->execute($namedParameters);
  $record = $statement->fetch();
  return $record;
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
          WHERE userID = :userID";
    
    $namedParameters = array();
    $namedParameters[':rank'] = $_GET['rank'];
    $namedParameters[':firstname'] = $_GET['firstname'];
    $namedParameters[':lastname'] = $_GET['lastname'];
    $namedParameters[':active'] = $_GET['active'];
    $namedParameters[':password'] = hash("sha1",$_GET['password']);
    $namedParameters[':userID'] = $_GET['userID'];
    }else if(strcmp($_GET['password'],"")==0){
        /*
        *   The password field is unset. Ignore the field.
        */
        $sql = "UPDATE `users`
          SET rank = :rank,
          firstname = :firstname,
          lastname = :lastname,
          active = :active
          WHERE userID = :userID";
    
    $namedParameters = array();
    $namedParameters[':rank'] = $_GET['rank'];
    $namedParameters[':firstname'] = $_GET['firstname'];
    $namedParameters[':lastname'] = $_GET['lastname'];
    $namedParameters[':active'] = $_GET['active'];
    $namedParameters[':userID'] = $_GET['userID'];
    }
    
  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  $hasUpdate = true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Edit User</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="stylesheet" href="css/default.css" type="text/css" />
  <script>
    function levelAccess()
    {
         alert("Restricted Access!"); // Not high enough level? Can't alter users.
    }
</script>
  <script src="sorttable.js"></script>
</head>
<header>
      <h1>Edit User</h1>
    </header>
<body>
    <?php
        if($_SESSION['rank'] == "Sergeant" || $_SESSION['rank'] == "Detective"){
            echo '<script>levelAccess()</script>';
            header("location:main.php");
        }
    ?>
    
    <?php $user = getUserByID()?>
    
    <form>
        <table border=1>
            <tr>
                <th>Rank</th>
                <td><select name="rank">
                    <option value="Commander" <?php if($user['rank'] == "Commander"){echo "selected";}?>>Commander</option>
                    <option value="Admin" <?php if($user['rank'] == "Admin"){echo "selected";}?>>Admin</option>
                    <option value="Sargeant" <?php if($user['rank'] == "Sargeant"){echo "selected";}?>>Sargeant</option>
                    <option value="Deputy" <?php if($user['rank'] == "Deputy"){echo "selected";}?>>Deputy</option>
                </select></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><input type="text" name="firstname" value="<?=$user['firstname']?>"/></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" name="lastname" value="<?=$user['lastname']?>"/></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><input type="text" name="username" value="<?=$user['username']?>"/></td>
            </tr>
            <tr>
                <th>Active</th>
                <td><input type="checkbox" name="active" value="1" <?php if($user['active'] == "1"){echo "checked";}?>></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><input type="password" name="password"/></td>
            </tr>
        </table>
        <input type="hidden" name="userID" value="<?php echo $user['userID']?>" />
        <input type="submit" value="Update User" name="updateUser" />
    </form>
    
    <?php if($hasUpdate){
        echo "<br><h3>User has been updated.</h3>";
    }
    ?>
    
</body>

<footer>
    
</footer>
</html>