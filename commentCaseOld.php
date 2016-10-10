<?php
//Check the session and connect to the database
session_start();
if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    header("Location: index.php");
}

include 'dbConn.php';
$connection = dbConn();

if (isset($_GET['commentCase'])) {  //admin submitted form to add product
    
  
  
  $sql = "INSERT INTO comments ( caseNumber, username, comment) 
          VALUES ( :caseNumber, :username, :comment)";
          
    $namedParameters = array();
    $namedParameters[':caseNumber'] = $_GET['caseNumber'];
    $namedParameters[':username'] = $_GET['username'];
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
      <h1>Add Comment for Case # <?php echo $_GET['caseNumber'];?></h1>
    </header>

    <div>
      <h4>Comment History</h4>
      <?php
        $connection = dbConn();
        $com = "Select * FROM `comments` WHERE caseNumber = '" . $_GET['caseNumber'] . "' ORDER BY commentDate ASC";
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
                if($deputy['username'] == $comment['username']){
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
          <input type="hidden" name="caseNumber" value="<?=$_GET['caseNumber']?>" />
          <input type="hidden" name="username" value="<?=$_SESSION['username']?>" />
          <input type="submit" value="Comment On Case" name="commentCase" />
      </form>
    </div>



    <footer>
    </footer>
  </div>
</body>
</html>