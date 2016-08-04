<?php
//Check the session and connect to the database
session_start();
if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    header("Location: index.php");
}

include 'dbConn.php';
$connection = dbConn();

echo "<a href='main.php'>Home</a><br>";

if (isset($_GET['commentCase'])) {  //admin submitted form to add product
    
  
  
  $sql = "INSERT INTO comments ( caseID, userID, comment) 
          VALUES ( :caseID, :userID, :comment)";
          
    $namedParameters = array();
    $namedParameters[':caseID'] = $_GET['caseID'];
    $namedParameters[':userID'] = $_GET['userID'];
    $namedParameters[':comment'] = $_GET['comment'];

  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  echo "Comment added!";   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Comment</title>
  <link rel="stylesheet" href="css/default.css" type="text/css" />
</head>

<body>
  <div>
    <header>
      <h1>Add Comment</h1>
    </header>

    <div>
      <h4>Comment History</h4>
      <?php
        $connection = dbConn();
        $com = "Select * FROM `comments` WHERE caseID = " . $_GET['caseID'] . " ORDER BY commentDate ASC";
        $comments = getDataBySQL($com);
        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
        $deputies = getDataBySQL($deputySQL);
        echo "<table border=1>"; //limit the size of the comments table
        echo '<col width="150">';
        echo '<col width="150">';
        echo '<col width="500">';
        foreach($comments as $comment){
          echo "<tr>";
              
              foreach($deputies as $deputy){
                if($deputy['userID'] == $comment['userID']){
                  echo "<td>" . $deputy['rank'] . " " . $deputy['lastname'] . "</td>";
                }
              }
              echo "<td>" . $comment['commentDate'] . "</td>";
              echo "<td>" . $comment['comment'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      ?>
      
      <br><br><b>Comment:</b>
      <form>
          <textarea rows="4" cols="75" name="comment" /></textarea> <br />
          <input type="hidden" name="caseID" value="<?=$_GET['caseID']?>" />
          <input type="hidden" name="userID" value="<?=$_SESSION['userID']?>" />
          <input type="submit" value="Comment On Case" name="commentCase" />
      </form>
    </div>

    <footer>
    </footer>
  </div>
</body>
</html>