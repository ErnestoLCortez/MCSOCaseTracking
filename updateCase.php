<?php
echo "<a href='main.php'>Home</a>";
include 'dbConn.php';
$connection = dbConn();
$hasUpdate = false;
function getCaseByID(){
  $conn = dbConn();
  $sql = "SELECT * FROM `case` WHERE caseID = :caseID";
  $namedParameters = array();
  $namedParameters[':caseID'] = $_GET['caseID'];
  $statement = $conn->prepare($sql);    
  $statement->execute($namedParameters);
  $record = $statement->fetch();
  return $record;
}

if (isset($_GET['updateCase'])) {  //submit the updated case information
  //Check authentication Here
  // $conn = dbConn();
  $sql = "UPDATE `case`
          SET reportDate = :reportDate,
          caseNumber = :caseNumber,
          crime = :crime,
          location = :location,
          reportingParty = :reportingParty,
          victim = :victim,
          suspect = :suspect,
          reportingDeputy = :reportingDeputy,
          flaggedCase = :flaggedCase,
          agCrime = :agCrime,
          status = :status,
          assignedTo = :assignedTo,
          unit = :unit,
          assignedBy = :assignedBy,
          followUpDate = :followUpDate,
          complaintAction = :complaintAction,
          selfInit = :selfInit,
          property = :property,
          evidence = :evidence,
          summary = :summary
          WHERE caseID = :caseID";
    
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
    $namedParameters[':selfInit'] = $_GET['selfInit'];
    $namedParameters[':property'] = $_GET['property'];
    $namedParameters[':evidence'] = $_GET['evidence'];
    $namedParameters[':summary'] = $_GET['summary'];
    $namedParameters[':caseID'] = $_GET['caseID'];
    
    
  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  $hasUpdate = true;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Case</title>
  <link rel="stylesheet" href="css/default.css" type="text/css" />
</head>

<body>
  <div>
    <header>
      <h1>Update Case</h1>
    </header>

    <div>
        
        <?php $case = getCaseByID()?>
        
        <form>
        <table border=1>
            <tr>
            <th>Report information <br>
              <table border=1>
                <tr>
                  <td>Report Date:</td>
                  <td><input type="date" name="reportDate" value="<?=$case['reportDate']?>"/></td>
                </tr>
                <tr>
                  <td>Case number:</td>
                  <td><input type="text" name="caseNumber" value="<?=$case['caseNumber']?>"/></td>
                </tr>
                <tr>
                  <td>Crime:</td>
                  <td><input type="text" name="crime" value="<?=$case['crime']?>"/></td>
                </tr>
                <tr>
                  <td>Location:</td>
                  <td><textarea name="location" rows="3" ><?php echo $case['location'];?></textarea></td>
                </tr>
                <tr>
                  <td>Reporting Party:</td>
                  <td><input type="text" name="reportingParty" value="<?=$case['reportingParty']?>"/></td>
                </tr>
                <tr>
                  <td>Victim:</td>
                  <td><input type="text" name="victim" value="<?=$case['victim']?>"/></td>
                </tr>
                <tr>
                  <td>Suspect:</td>
                  <td><input type="text" name="suspect" value="<?=$case['suspect']?>"/></td>
                </tr>
                <tr>
                  <td>Reporting Deputy:</td>
                  <td><select name="reportingDeputy">
                       <?php
                        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['userID'] . '"';
                          if($deputy['userID'] == $case['reportingDeputy']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select></td>
                </tr>
                <tr>
                  <td>Flagged Case:</td>
                  <td><input type="checkbox" name="flaggedCase" value="1" <?php if($case['flaggedCase'] == "1"){echo "checked";}?>></td>
                </tr>
                <tr>
                  <td>Ag Crime:</td>
                  <td><input type="checkbox" name="agCrime" value="1" <?php if($case['agCrime'] == "1"){echo "checked";}?>></td>
                </tr>
              </table>
            </th>
            <th>Case Assignment Information<br>
              <table border=1>
                <tr>
                  <td>Entry Date:</td>
                  <td><?php echo $case['entryDate'];?></td>
                </tr>
                <tr>
                  <td>Status:</td>
                  <td><select name="status">
                       <option value="Active" <?php if($case['status'] == "Active"){echo "selected";}?>>Active</option>
                       <option value="Warrant" <?php if($case['status'] == "Warrant"){echo "selected";}?>>Warrant</option>
                       <option value="Closed" <?php if($case['status'] == "Closed"){echo "selected";}?>>Closed</option>
                       <option value="Suspended" <?php if($case['status'] == "Suspended"){echo "selected";}?>>Suspended</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Assigned To:</td>
                  <td><select name="assignedTo">
                       <?php
                        $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['userID'] . '"';
                          if($deputy['userID'] == $case['assignedTo']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select></td>
                </tr>
                <tr>
                  <td>Unit:</td>
                  <td><select name="unit">
                       <option value="SV-SA" <?php if($case['unit'] == "SV-SA"){echo "selected";}?>>DV-SA</option>
                       <option value="Narcotics" <?php if($case['unit'] == "Narcotics"){echo "selected";}?>>Narcotics </option>
                       <option value="Persons" <?php if($case['unit'] == "Persons"){echo "selected";}?>>Persons</option>
                       <option value="Property" <?php if($case['unit'] == "Property"){echo "selected";}?>>Property </option>
                       <option value="SED" <?php if($case['unit'] == "SED"){echo "selected";}?>>SED </option>
                       <option value="MADCAT" <?php if($case['unit'] == "MADCAT"){echo "selected";}?>>MADCAT </option>
                       <option value="AG Unit" <?php if($case['unit'] == "AG Unit"){echo "selected";}?>>AG Unit </option>
                    </select></td>
                </tr>
                <tr>
                  <td>Assigned By</td>
                  <td><select name="assignedBy">
                       <?php
                        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['userID'] . '"';
                          if($deputy['userID'] == $case['assignedBy']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select></td>
                </tr>
                <tr>
                  <td>Follow Up Date:</td>
                  <td><input type="date" name="followUpDate" value="<?=$case['followUpDate']?>"></td>
                </tr>
                <tr>
                  <td>Complaint Action:</td>
                  <td><select name="complaintAction">
                       <option value="To DA" <?php if($case['complaintAction'] == "To DA"){echo "selected";}?>>To DA</option>
                       <option value="Pending Court" <?php if($case['complaintAction'] == "Pending Court"){echo "selected";}?>>Pending Court</option>
                       <option value="Warrant Issued" <?php if($case['complaintAction'] == "Warrant Issued"){echo "selected";}?>>Warrant Issued</option>
                       <option value="Other" <?php if($case['complaintAction'] == "Other"){echo "selected";}?>>Other</option>
                    </select></td>
                </tr>
                <tr>
                  <td>Self Init:</td>
                  <td><input type="checkbox" name="selfInit" value="1" <?php if($case['selfInit'] == "1"){echo "checked";}?>></td>
                </tr>
                <tr>
                  <td>Property:</td>
                  <td><input type="checkbox" name="property" value="1" <?php if($case['property'] == "1"){echo "checked";}?>></td>
                </tr>
                <tr>
                  <td>Evidence:</td>
                  <td><input type="checkbox" name="evidence" value="1" <?php if($case['evidence'] == "1"){echo "checked";}?>></td>
                </tr>
                </table>
            </th>
            </tr>
            <tr>
              <th colspan=2>Summary</th>
            </tr>
            <tr>
              <td colspan=2><textarea name="summary" rows="10" cols="75"><?php echo $case['summary'];?></textarea></td>
            </tr>
            </table>
            <input type="hidden" name="caseID" value="<?php echo $case['caseID']?>" />
          <input type="submit" value="Update Case" name="updateCase" />
          
      </form>
    </div>
    <div>
      <?php if($hasUpdate){
        echo "<br><h3>Case has been updated.</h3>";
      }
      ?>
    </div>
    <footer>
    </footer>
  </div>
</body>
</html>