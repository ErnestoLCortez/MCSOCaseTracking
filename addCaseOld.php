<?php
//Check the session and connect to the database
session_start();
include 'dbConn.php';
$connection = dbConn();
if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}

echo "<a href='main.php'>Home</a>";
if (isset($_GET['addCase'])) {  //admin submitted form to add product
if(strcmp($_GET['caseNumber'],"")==0){
  echo "<h2><font color=red>Case Number cannot be blank.</font></h2>";
}else{
  try{
    $conn = dbConn();
    //Check authentication Here
    
    $sql = "INSERT INTO `case` ( reportDate, caseNumber, crime, location, reportingParty, victim, suspect, reportingDeputy, flaggedCase, agCrime, status, assignedTo, unit, assignedBy, followUpDate, complaintAction, property, evidence, summary)
      VALUES ( :reportDate, :caseNumber, :crime, :location, :reportingParty, :victim, :suspect, :reportingDeputy, :flaggedCase, :agCrime, :status, :assignedTo, :unit, :assignedBy, :followUpDate, :complaintAction, :property, :evidence, :summary)";
      
      $namedParameters = array();
      $namedParameters[':reportDate'] = $_GET['reportDate'];
      $namedParameters[':caseNumber'] = $_GET['caseNumber'];
      $namedParameters[':crime'] = $_GET['crime'];
      $namedParameters[':location'] = $_GET['location'];
      $namedParameters[':reportingParty'] = $_GET['reportingParty'];
      $namedParameters[':victim'] = $_GET['victim'];
      $namedParameters[':suspect'] = $_GET['suspect'];
      $namedParameters[':reportingDeputy'] = $_GET['reportingDeputy'];
      $namedParameters[':flaggedCase'] = $_GET['flaggedCase'];
      $namedParameters[':agCrime'] = $_GET['agCrime'];
      $namedParameters[':status'] = $_GET['status'];
      $namedParameters[':assignedTo'] = $_GET['assignedTo'];
      $namedParameters[':unit'] = $_GET['unit'];
      $namedParameters[':assignedBy'] = $_GET['assignedBy'];
      $namedParameters[':followUpDate'] = $_GET['followUpDate'];
      $namedParameters[':complaintAction'] = $_GET['complaintAction'];
      $namedParameters[':property'] = $_GET['property'];
      $namedParameters[':evidence'] = $_GET['evidence'];
      $namedParameters[':cash'] = $_GET['cash'];
      $namedParameters[':narcotics'] = $_GET['narcotics'];
      $namedParameters[':weapons'] = $_GET['weapons'];
      $namedParameters[':summary'] = $_GET['summary'];
      
      
      $statement = $conn->prepare($sql);
      $statement->execute($namedParameters);  
    
    echo "Case has been added.";   
    header("Location: main.php");
  }catch (Exception $e){
    $hasError = true;
    echo "<h2><font color=red>Caught exception. Check your form. Duplicate Case Number?</font></h2>";
    function displayError(){
      echo '<p>Error Code for the squints: ', $e->getMessage(),"\n";
    }
  }
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

  <title>MCSO New Case</title>
  <meta name="description" content="">
  <meta name="author" content="Brian Rono">

  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="stylesheet" href="css/default.css" type="text/css" />
</head>

<body>
  <div>
    <header>
      <h1>New Case Form</h1>
    </header>

    <div >
          <form role="form">
          <table border=1>
            <tr>
            <th>Report information <br>
              <table border=1>
                <tr>
                  <td>Report Date:</td>
                  <td><input type="date" name="reportDate"></td>
                </tr>
                <tr>
                  <td>Case number:</td>
                  <td><input type="text" name="caseNumber"></td>
                </tr>
                <tr>
                  <td>Crime:</td>
                  <td><input type="text" name="crime"></td>
                </tr>
                <tr>
                  <td>Location:</td>
                  <td><textarea name="location" rows="3"></textarea></td>
                </tr>
                <tr>
                  <td>Reporting Party:</td>
                  <td><input type="text" name="reportingParty"></td>
                </tr>
                <tr>
                  <td>Victim:</td>
                  <td><input type="text" name="victim"></td>
                </tr>
                <tr>
                  <td>Suspect:</td>
                  <td><input type="text" name="suspect"></td>
                </tr>
                <tr>
                  <td>Reporting Deputy:</td>
                  <td><select name="reportingDeputy">
                       <?php
                        $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['username'] . '">' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select></td>
                </tr>
                <tr>
                  <td>Flagged Case:</td>
                  <td><input type="checkbox" name="flaggedCase" value="1"></td>
                </tr>
                <tr>
                  <td>Ag Crime:</td>
                  <td><input type="checkbox" name="agCrime" value="1"></td>
                </tr>
              </table>
            </th>
            <th>Case Assignment Information<br>
              <table border=1>
                <tr>
                  <td>Status:</td>
                  <td><select name="status">
                       <option value="Active" >Active</option>
                       <option value="Warrant" >Warrant</option>
                       <option value="Closed" >Closed</option>
                       <option value="Suspended" >Suspended</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Assigned To:</td>
                  <td><select name="assignedTo">
                       <?php
                        $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['username'] . '">' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select></td>
                </tr>
                <tr>
                  <td>Unit:</td>
                  <td><select name="unit">
                       <option value="SV-SA" >DV-SA</option>
                       <option value="Narcotics" >Narcotics </option>
                       <option value="Persons" >Persons</option>
                       <option value="Property" >Property </option>
                       <option value="SED" >SED </option>
                       <option value="MADCAT" >MADCAT </option>
                       <option value="AG Unit" >AG Unit </option>
                    </select></td>
                </tr>
                <tr>
                  <td>Assigned By</td>
                  <td><?=$_SESSION['rank']?> <?=$_SESSION['lastname']?><input type="hidden" name="assignedBy" value="<?=$_SESSION['username']?>"/></td>
                </tr>
                <tr>
                  <td>Follow Up Date:</td>
                  <td><input type="date" name="followUpDate"></td>
                </tr>
                <tr>
                  <td>Complaint Action:</td>
                  <td><select name="complaintAction">
                       <option value="To DA" >To DA</option>
                       <option value="Pending Court" >Pending Court</option>
                       <option value="Warrant Issued" >Warrant Issued</option>
                       <option value="Other" >Other</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Property:</td>
                  <td><input type="checkbox" name="property" value="1"></td>
                </tr>
                <tr>
                  <td>Evidence:</td>
                  <td><input type="checkbox" name="evidence" value="1"></td>
                </tr>
                </table>
                <center>
                <br>Seizures<br>
                <table border=1>
              <tr>
                <td>Cash:</td>
                <td><input type="checkbox" name="cash" value="1" ></td>
              </tr>
              <tr>
                <td>Narcotics:</td>
                <td><input type="checkbox" name="narcotics" value="1"></td>
              </tr>
              <tr>
                <td>Weapons:</td>
                <td><input type="checkbox" name="weapons" value="1" ></td>
              </tr>
            </table>
            </center>
            </th>
            </tr>
            <tr>
              <th colspan=2>Summary</th>
            </tr>
            <tr>
              <td colspan=2><textarea name="summary" rows="10" cols="75"></textarea></td>
            </tr>
            </table>
            
          <input type="submit" value="Submit Case" name="addCase" />
          
      </form>
      
    </div>
    <div>
      <?php if($hasError){
        displayError();
      }
      ?>
    </div>
    <footer>
    </footer>
  </div>
</body>
</html>