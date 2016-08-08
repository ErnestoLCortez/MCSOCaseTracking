<?php
session_start();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}
include "dbConn.php";
echo "<a href='main.php'>Home</a>";
$connection = dbConn(); 

function displayAllCases(){
  /*
  * SQL queries to retrieve pertinent cases
  */
    if($_SESSION['rank'] == "Admin" || $_SESSION['rank'] == "Commander"){
      $sql = "Select * FROM `case` ORDER BY entryDate DESC";
    }else{
      $sql = "Select * FROM `case` a WHERE a.active = 0";
    }
    
    $records = getDataBySQL($sql);
     //Using Form Buttons
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
            $adSQL = "Select * FROM `users` a WHERE a.userID = " . $record['assignedTo'];
            $ad = getDataBySQL($adSQL);
            foreach($ad as $ad1){
                echo $ad1['rank'] . " " . $ad1['lastname'];
            }
          echo "</td>";
          echo "<td>" . $record['complaintAction'] . "</td>";
          
          //Comments table. Find comments associated with the primary key on the case number.
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
        } //endForeach
        
        echo "</table>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Archived Cases</title>
  <meta name="description" content="Archived Investigation Cases at MCSO">
  <meta name="author" content="Brian Rono">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="stylesheet" href="css/default.css" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="sorttable.js"></script>
</head>

<body>
    <div>
     <table border=1>
        <tr>
            <th>Victim</th>

            <th>Suspect</th>
            
            <th>Crime</th>

            <th>Location</th>

            <th>Assigned To</th>
        </tr>
        <tr>
            <td>
                <input type="text"name="victim" id="victim">
            </td>
            <td>
                <input type="text"name="suspect" id="suspect">
            </td>
            <td>
                <input type="text"name="crime" id="crime">
            </td>
            <td>
                <input type="text"name="location" id="location">
            </td>
            <td>
                <select name="assignedTo" id="assignedTo">
                       <?php
                        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        echo '<option selected disabled hidden value=""></option>';
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['userID'] . '">' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select>
            </td>
            <td><div><button id="displayAll">Search</button></div></td>
            <td><div><button id="reset">Reset</button></div></td>
        </tr>
        </table>
        
     </div>
     
    <div id="all"><?=displayAllCases()?></div>
    
    <script>
         $("#displayAll").click(function(){
            $.ajax({
                "method": "GET",
                "url": "displayAll.php",
                "data": {
                    "victim": $("#victim").val(),
                    "suspect": $("#suspect").val(),
                    "crime": $("#crime").val(),
                    "location": $("#location").val(),
                    "assignedTo": $("#assignedTo").val(),
                },
                "success": function(data, status)
                {
                    $("#all").html(data);
                    $("#all").slideDown(0);
                }
            });
        });
        $("#reset").click(function(){
            $.ajax({
                "method": "GET",
                "url": "displayAll.php",
                "data": {
                    "victim": null,
                    "suspect": null,
                    "crime": null,
                    "location": null,
                    "assignedTo": null,
                },
                "success": function(data, status)
                {
                    $("#all").html(data);
                    $("#all").slideDown(0);
                }
            });
        });
         </script>
         
         
    <footer>
    </footer>
</body>
</html>