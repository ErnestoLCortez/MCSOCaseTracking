<?php
session_start();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}

include 'dbConn.php';

$connection = dbConn();

function displayMyCases(){
  /*
  * SQL queries to retrieve pertinent cases
  */
    if($_SESSION['rank'] == "Admin" || $_SESSION['rank'] == "Commander"){
      $sql = "Select * FROM `case` WHERE `active` = 1 ORDER BY entryDate DESC";
    }else{
      $sql = "Select * FROM `case` a WHERE a.assignedTo = " . $_SESSION['userID'] . " ORDER BY entryDate DESC";
    }
    
    $records = getDataBySQL($sql);
    
    // $commentSQL = "Select * FROM comments ";
    // $comments = getDataBySQL($commentSQL);

     //Using Form Buttons
         echo "<table class='sortable' border=1>";
         echo "<th>Case Number</th>";		
         echo "<th>Victim</th>";		
         echo "<th>Crime</th>";		
         echo "<th>Follow Up Date</th>";		
         echo "<th>Complaint Action</th>";
         echo "<th>Comments</th>";
        foreach ($records as $record) {
          echo "<tr>"; 
          echo "<td>" . $record['caseNumber'] . "</td>"; 
          echo "<td>" . $record['victim'] . "</td>";
          echo "<td>" . $record['crime'] . "</td>";
          echo "<td>" . $record['followUpDate'] . "</td>";
          echo "<td>" . $record['complaintAction'] . "</td>";
              $com = "Select * FROM `comments` a WHERE a.caseID = " . $record['caseID'] . " ORDER BY commentDate DESC";
              $comments = getDataBySQL($com);
              $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
              $deputies = getDataBySQL($deputySQL);
          echo "<td><table border=1>"; //Limit the size of the comments table
          echo '<col width="150">';
          echo '<col width="150">';
          echo '<col width="500">';
          $atFive = 0;
            foreach($comments as $comment){
              if($atFive == 5){
                break;
              }
              echo "<tr>";
              foreach($deputies as $deputy){
                if($deputy['userID'] == $comment['userID']){
                  echo "<td>" . $deputy['rank'] . " " . $deputy['lastname'] . "</td>";
                  $atFive += 1;
                }
                
              }
              echo "<td>" . $comment['commentDate'] . "</td>";
              echo "<td>" . $comment['comment'] . "</td>";
              echo "</tr>";
            }
          echo "</table>";
          echo "</td></tr>";
          //UPDATE CASE BUTTON
          echo "<td> <form action=updateCase.php>";
          echo "<input type='hidden' name='caseID' value='".$record['caseID'] . "'/>";
          echo "<input type='submit' value='View Case'/></form> </td>";
          
          //COMMENT ON CASE BUTTON
          echo "<td> <form action=commentCase.php>";
          echo "<input type='hidden' name='caseID' value='".$record['caseID'] . "'/>";
          echo "<input type='submit' value='Comment On Case'/></form> </td>";
          
          //DELETE CASE BUTTON
          echo "<td> <form action=archiveCase.php>";
          echo "<input type='hidden' name='caseID' value='".$record['caseID'] . "'/>";
          echo "<input type='submit' value='Finalize/Archive Case'/></form> </td>";
          echo "</tr>";
          echo "</tr>";
        } //endForeach
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
  <script src="sorttable.js"></script>
</head>

<body>
  <div>
    <header>
      <h1>MCSO Case Menu</h1>
    </header>

   
    <div>
     <strong> Welcome <?=$_SESSION['rank']?> <?=$_SESSION['lastname']?>! </strong>
     <br>
     <table border=0>
       <tr>
         <td>
           <form action="logout.php">
              <input type="submit" value="Logout" />    
           </form>
          </td>
          <td>
           <form action="addCase.php">
              <input type="submit" value="Add Case" />    
           </form>
          </td>
          <td>
            <form action="searchCases.php">
              <input type="submit" value="Search Cases" />
            </form>
          </td>
          <td>
            <form action="users.php">
              <input type="submit" value="Add, Alter, Archive Users" />
            </form>
          </td>
        </tr>
    </table>
      <br /><br />
      
      
      
      <div>
        <h2>Active Cases at a glance</h2>
        <?=displayMyCases()?>
      </div>
      
      
      
    </div>

    <footer>

    </footer>
  </div>
</body>
</html>