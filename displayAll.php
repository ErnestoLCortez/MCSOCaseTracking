<?php
include "dbConn.php";

$connection = dbConn(); 
$sql = "SELECT * FROM `case` WHERE 1 = 1";

/*
 * SQL LOGIC SECTION
 */
if(!empty($_GET) && isset($_GET))
{
    if(strcmp($_GET['victim'], "")!==0)
    {
        $sql .= " AND `victim` LIKE '%" . $_GET['victim'] . "%'";
    }
}

$sql .= " ORDER BY entryDate DESC";
echo $sql;
$records = getDataBySQL($sql);


// Execute the query
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
  echo "<input type='hidden' name='caseID' value='".$record['caseID'] . "'/>";
  echo "<input type='submit' value='View Case'/></form> </td>";
  
  //COMMENT ON CASE BUTTON
  echo "<td> <form action=commentCase.php>";
  echo "<input type='hidden' name='caseID' value='".$record['caseID'] . "'/>";
  echo "<input type='submit' value='Comment On Case'/></form> </td>";
  
} //endForeach
echo "</table>";
?>