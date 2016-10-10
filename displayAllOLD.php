<?php
session_start();
include "dbConn.php";

$connection = dbConn(); 


$sql = "Select * FROM `case`";
if($_SESSION['rank'] == "Admin" || $_SESSION['rank'] == "Commander"){
      $sql .= " WHERE 1 = 1";
}else{
      $sql .= " a WHERE a.active = 0";
}
// $sql = "SELECT * FROM `case` WHERE 1 = 1";

/*
 * SQL LOGIC SECTION
 */
if(!empty($_GET) && isset($_GET))
{
    if(strcmp($_GET['victim'], "")!==0)
    {
        $sql .= " AND `victim` LIKE '%" . $_GET['victim'] . "%'";
    }
    if(strcmp($_GET['suspect'], "")!==0)
    {
        $sql .= " AND `suspect` LIKE '%" . $_GET['suspect'] . "%'";
    }
    if(strcmp($_GET['crime'], "")!==0)
    {
        $sql .= " AND `crime` LIKE '%" . $_GET['crime'] . "%'";
    }
    if(strcmp($_GET['location'], "")!==0)
    {
        $sql .= " AND `location` LIKE '%" . $_GET['location'] . "%'";
    }
    if(strcmp($_GET['assignedTo'], "")!==0)
    {
        $sql .= " AND `assignedTo` = '" . $_GET['assignedTo'] . "'";
    }
}


$sql .= " ORDER BY entryDate DESC";
$records = getDataBySQL($sql);


// Execute the query
 echo "<table class='sortable' border=1>";
 echo "<th>Case Number</th>";		
 echo "<th>Victim</th>";		
 echo "<th>Crime</th>";		
 echo "<th>Assigned To</th>";		
 echo "<th>Complaint Action</th>";
 echo "<th>Comments</th>";
foreach ($records as $record) {
  echo "<tr>"; 
  echo "<td>" . $record['caseNumber'] . "</td>"; 
  echo "<td>" . $record['victim'] . "</td>";
  echo "<td>" . $record['crime'] . "</td>";
  //Display the detective assigned to the case
  echo "<td>";
    $adSQL = "Select * FROM `users` a WHERE a.username = '" . $record['assignedTo'] . "'";
    $ad = getDataBySQL($adSQL);
    foreach($ad as $ad1){
        echo $ad1['rank'] . " " . $ad1['lastname'];
    }
  echo "</td>";
          
  echo "<td>" . $record['complaintAction'] . "</td>";
      $com = "Select * FROM `comments` a WHERE a.casenumber = '" . $record['casenumber'] . "' ORDER BY commentDate DESC";
      $comments = getDataBySQL($com);
  echo "<td><table border=1>";
    foreach($comments as $comment){
      echo "<tr>";
      echo "<td>" . $comment['commentDate'] . "</td>";
      echo "<td>" . $comment['comment'] . "</td>";
      echo "</tr>";
    }
  echo "</table>";
  echo "</td></tr>";
  //UPDATE CASE BUTTON
  echo "<td> <form action=updateCase.php>";
  echo "<input type='hidden' name='casenumber' value='".$record['casenumber'] . "'/>";
  echo "<input type='submit' value='View Case'/></form> </td>";
  
  //COMMENT ON CASE BUTTON
  echo "<td> <form action=commentCase.php>";
  echo "<input type='hidden' name='casenumber' value='".$record['casenumber'] . "'/>";
  echo "<input type='submit' value='Comment On Case'/></form> </td>";
  
} //endForeach
echo "</table>";
?>